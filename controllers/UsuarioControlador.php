<?php
require_once 'model/usuarioModel.php';

class UsuarioControlador {
    public function gestionarUsuarios() {
        $modelo = new UsuarioModel();
        $usuarios = $modelo->obtenerUsuariosConRol();
    
        require 'views/gestionarUsuariosVista.php'; 
    }
    public function agregar() {
        $formData = [
            'nombre' => '',
            'apellidos' => '',
            'codigo_institucional' => '',
            'email' => '',
            'contrasena' => '',
            'rol' => ''
        ];
        $formErrors = [];
    
        require 'views/agregarUsuario.php';
    }
    public function agregarUsuario() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nombre = trim($_POST['nombre']);
            $apellidos = trim($_POST['apellidos']);
            $codigo = trim($_POST['codigo_institucional']);
            $email = trim($_POST['email']);
            $contrasena = ($_POST['contrasena']);
            $rol = $_POST['rol']; 
    
            $formData = [
                'nombre' => $nombre,
                'apellidos' => $apellidos,
                'codigo_institucional' => $codigo,
                'email' => $email,
                'contrasena' => $contrasena,
                'rol' => $rol
            ];
    
            $formErrors = [];
    
            
            if (empty($nombre)) {
                $formErrors['nombre'] = "El nombre es obligatorio.";
            }
    
            if (empty($apellidos)) {
                $formErrors['apellidos'] = "Los apellidos son obligatorios.";
            }
    
            if (empty($codigo)) {
                $formErrors['codigo_institucional'] = "El código institucional es obligatorio.";
            }
    
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $formErrors['email'] = "El correo electrónico no es válido.";
            }
    
            if (strlen($contrasena) < 6) {
                $formErrors['contrasena'] = "La contraseña debe tener al menos 6 caracteres.";
            }
    
            if (empty($rol)) {
                $formErrors['rol'] = "Debe seleccionar un rol.";
            }
    
            if (!empty($formErrors)) {
                require 'views/agregarUsuario.php'; 
                return;
            }

            if (empty($formErrors)) {
                $modeloCheck = new UsuarioModel();

                if (!empty($codigo) && $modeloCheck->findByCodigoInstitucional($codigo)) {
                    $formErrors['codigo_institucional'] = "Este código institucional ya está registrado.";
                }

                if (!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL) && $modeloCheck->findByEmail($email)) {
                    $formErrors['email'] = "Este correo electrónico ya está registrado.";
                }
            }

            if (!empty($formErrors)) {
                require __DIR__ . '/../views/agregarUsuario.php';
                return;
            }
    

            $usuario = new UsuarioModel();
            $usuario->setNombre($nombre);
            $usuario->setApellidos($apellidos);
            $usuario->setCodigoInstitucional($codigo);
            $usuario->setEmail($email);
            $usuario->setContrasena($contrasena);
            $usuario->setRol($rol);
    
            if ($usuario->agregarUsuario()) {
                if (session_status() === PHP_SESSION_NONE) { session_start(); } 
                $_SESSION['status_message'] = ['type' => 'success', 'text' => 'Usuario agregado exitosamente.'];
                
                header("Location: index.php?c=Usuario&a=gestionarUsuarios");
                exit();
            } else {
                $formErrors['general'] = "Error inesperado al guardar el usuario. Inténtelo de nuevo.";
                require __DIR__ . '/../views/agregarUsuario.php';
                return;
            }
        } else {
            require 'views/agregarUsuario.php';
        }
        



    }


    public function asignarRolAdmin() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['idRol']) || $_SESSION['idRol'] != 2) {
            echo "Acceso denegado."; 
            exit();
        }

        $idUsuarioModificar = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if (!$idUsuarioModificar) {
            $_SESSION['status_message'] = ['type' => 'error', 'text' => 'ID de usuario inválido.'];
            header("Location: index.php?c=Usuario&a=gestionarUsuarios");
            exit();
        }

        $modelo = new UsuarioModel();
        $nuevoRolId = 2; 

        if ($modelo->cambiarRol($idUsuarioModificar, $nuevoRolId)) {
            $_SESSION['status_message'] = ['type' => 'success', 'text' => 'Rol de administrador asignado correctamente.'];
        } else {
            $_SESSION['status_message'] = ['type' => 'error', 'text' => 'Error al asignar el rol de administrador.'];
        }

        header("Location: index.php?c=Usuario&a=gestionarUsuarios");
        exit();
    }

    public function quitarRolAdmin() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $loggedInUserCodigo = $_SESSION['codigo_institucional'] ?? null;
        $loggedInUserId = $_SESSION['idusuario'] ?? null;

        if ($loggedInUserCodigo !== '212324') {
            $_SESSION['status_message'] = ['type' => 'error', 'text' => 'Acción no permitida. Permisos insuficientes.'];
            header("Location: index.php?c=Usuario&a=gestionarUsuarios");
            exit();
        }

        $idUsuarioModificar = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if (!$idUsuarioModificar) {
            $_SESSION['status_message'] = ['type' => 'error', 'text' => 'ID de usuario inválido.'];
            header("Location: index.php?c=Usuario&a=gestionarUsuarios");
            exit();
        }

        
        if ($idUsuarioModificar == $loggedInUserId) { 
            $_SESSION['status_message'] = ['type' => 'error', 'text' => 'No puedes quitar el rol de administrador a tu propia cuenta.'];
            header("Location: index.php?c=Usuario&a=gestionarUsuarios");
            exit();
        }

        $modelo = new UsuarioModel();
        $nuevoRolId = 1;

        if ($modelo->cambiarRol($idUsuarioModificar, $nuevoRolId)) {
            $_SESSION['status_message'] = ['type' => 'success', 'text' => 'Rol de administrador quitado correctamente (asignado como Docente).'];
        } else {
            $_SESSION['status_message'] = ['type' => 'error', 'text' => 'Error al quitar el rol de administrador.'];
        }

        header("Location: index.php?c=Usuario&a=gestionarUsuarios");
        exit();
    }



    private function generarCodigoVerificacion($longitud = 7) {
        $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $codigo = '';
        for ($i = 0; $i < $longitud; $i++) {
            $codigo .= $caracteres[rand(0, strlen($caracteres) - 1)];
        }
        return $codigo;
    }
    public function validarAdministrador() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    
        if (!isset($_SESSION['codigo_institucional']) || $_SESSION['idRol'] != 2) {
            echo "Acceso denegado.";
            exit();
        }
    
        $modelo = new UsuarioModel();
        $usuario = $modelo->findByCodigoInstitucional($_SESSION['codigo_institucional']);
    
        if (!$usuario || empty($usuario['email'])) {
            echo "Usuario no encontrado o sin correo válido.";
            exit();
        }
    
        $codigoVerificacion = $this->generarCodigoVerificacion();
        $_SESSION['codigo_verificacion'] = $codigoVerificacion;
    
        $asunto = "Código de Verificación - Validación Administrador";
        $mensaje = "Su código de verificación es: <strong>$codigoVerificacion</strong>";
        $cabeceras = "MIME-Version: 1.0" . "\r\n";
        $cabeceras .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $cabeceras .= "From: no-reply@ecosplash.com" . "\r\n";
    
        if (mail($usuario['email'], $asunto, $mensaje, $cabeceras)) {
            require 'views/validarAdministrador.php';
        } else {
            echo "Error al enviar el correo de verificación.";
        }
    }
}
