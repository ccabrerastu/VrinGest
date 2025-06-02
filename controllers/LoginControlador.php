<?php
require_once 'vendor/autoload.php';
require_once 'model/usuarioModel.php';
require_once 'model/ReactivoModel.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class LoginControlador {
    public function index() {
        require 'views/loginVista.php';
    }

public function autenticar() {
    session_start();
    $codigo_institucional = $_POST['codigo_institucional'] ?? '';
    $clave = $_POST['clave'] ?? '';

    $recaptcha_response = $_POST['g-recaptcha-response'] ?? '';
    $recaptcha_secret = '6LcrZhwrAAAAAPeUUebIQnFRBi8XC93DcD85L9Un'; 

    // Validar reCAPTCHA
    $verify = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$recaptcha_secret}&response={$recaptcha_response}");
    $responseData = json_decode($verify);

    if (!$responseData->success) {
        $error = "Verificación CAPTCHA fallida.";
        require 'views/loginVista.php';
        return;
    }

    if (!empty($codigo_institucional) && !empty($clave)) {
        $modelo = new UsuarioModel();
        $usuarioData = $modelo->verificarCredenciales($codigo_institucional, $clave);

        if ($usuarioData) {
            // Usuario autenticado correctamente
            $_SESSION['username'] = $usuarioData['username'];
            $_SESSION['idRolSistema'] = $usuarioData['id_rol_sistema'];
            $_SESSION['idusuario'] = $usuarioData['id_usuario'];
            $_SESSION['nombre'] = $usuarioData['nombres'];
            $_SESSION['apellido'] = $usuarioData['apellidos'];
            $_SESSION['dni'] = $usuarioData['dni'];
            $_SESSION['nombre_rol'] = $usuarioData['nombre_rol'];

            // Redirección según rol
            if ($usuarioData['id_rol_sistema'] == 1 || $usuarioData['id_rol_sistema'] == 3) {
                header("Location: index.php?c=Dashboard&a=index2");
                exit;
            } elseif ($usuarioData['id_rol_sistema'] == 2) {
                header("Location: index.php?c=Dashboard&a=index");
                exit;
            }
        } else {
            // Credenciales inválidas
            $error = "Credenciales inválidas";
            require 'views/loginVista.php';
        }
    } else {
        // Campos incompletos
        $error = "Por favor, complete todos los campos";
        require 'views/loginVista.php';
    }
}
    public function validarCodigo() {
        session_start();
    
        $codigo_institucional = $_SESSION['codigo_institucional'] ?? '';
        $codigo_ingresado = $_POST['codigo_verificacion'] ?? '';

        
        $modelo = new UsuarioModel();
        $usuarioData = $modelo->verificarCodigo($codigo_institucional, $codigo_ingresado);
        
        if ($usuarioData) {
                        
             header("Location: index.php?c=Dashboard&a=index2");
            exit;  
        } else {
            
            $error = "Código de verificación incorrecto.";
            require 'views/validarAdministrador.php';
        }
    }

    public function logout() {
        session_start();
        $_SESSION = array();
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        
        session_destroy();
        header("Location: index.php?c=Login&a=index");
        exit;
    }
}