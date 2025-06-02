<?php
require_once 'vendor/autoload.php';
require_once 'model/usuarioModel.php';
require_once 'model/ReactivoModel.php';
require_once 'model/MaterialModel.php';
require_once 'model/ClaseModel.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class ClaseControlador {
   private $reactivoModel;
   private $materialModel;
   private $claseModel;


    public function __construct()
    {
        $this->reactivoModel = new ReactivoModel();
        $this->materialModel = new MaterialModel();
        $this->claseModel = new ClaseModel();

    }
    public function registrarClase() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Obtener reactivos y materiales
        $reactivos = $this->reactivoModel->obtenerReactivos();
        $materiales = $this->materialModel->getAllMaterialesList();

        // Leer mensaje de sesión, si existe
    

        // Pasar $mensaje a la vista
        require __DIR__ . '/../views/registrarClaseVista.php';
    } 
public function guardarClase() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $idUsuario = $_POST['id_usuario'] ?? null;
        $docente = $_POST['nombre_docente'] ?? '';
        $fecha = $_POST['fecha_clase'] ?? '';
        $diaSemana = date('w', strtotime($fecha)); 

        if ($diaSemana == 0) {
            $_SESSION['status_message'] = "No se permite registrar clases los días domingo.";
            header("Location: index.php?c=Clase&a=registrarClase");
            exit;
        }
        $laboratorio = $_POST['laboratorio'] ?? '';
        $horaInicio = $_POST['hora_inicio'] ?? '';
        $horaFin = $_POST['hora_fin'] ?? '';
        $reactivosUsados = $_POST['reactivo_cantidad'] ?? [];
        $materialesUsados = $_POST['material_cantidad'] ?? [];
        $idCurso = $_POST['curso'] ?? null; // Combo box de curso
        $justificacion = trim($_POST['justificacion'] ?? ''); 
        $bloqueHorario = $_POST['bloque_horario'] ?? '';

        // Dividir bloque horario
        if ($bloqueHorario && strpos($bloqueHorario, '-') !== false) {
            list($horaInicio, $horaFin) = explode('-', $bloqueHorario);
        } else {
            $horaInicio = '';
            $horaFin = '';
        }


        if (empty($fecha) || empty($horaInicio) || empty($horaFin) || empty($laboratorio)) {
            $_SESSION['status_message'] = "Faltan datos obligatorios para registrar la clase.";
            header("Location: index.php?c=Clase&a=registrarClase");
            exit;
        }



        $idClase = $this->claseModel->registrarClase($idUsuario, $fecha, $horaInicio, $horaFin, $laboratorio, $idCurso, $justificacion);

        // Registrar materiales usados normalmente
        $this->claseModel->registrarMaterialesClase($idClase, $materialesUsados);

        // Arrays para listar los reactivos fiscalizados y no fiscalizados
        $reactivosRegistrados = [];
        $reactivosFiscalizados = [];

        // Procesar reactivos usados
        foreach ($reactivosUsados as $idReactivo => $cantidad) {
            if ($cantidad <= 0) continue;
             $nombreReactivo = $this->claseModel->obtenerNombreReactivo($idReactivo);

            if ($this->claseModel->esFiscalizado($idReactivo)) {
                // Si es fiscalizado, registrar como solicitud
                $this->claseModel->registrarSolicitudFiscalizado($idClase, $idReactivo, $cantidad, $idUsuario);
                $reactivosFiscalizados[] = $nombreReactivo;
            } else {
                // Si no es fiscalizado, registrar normalmente
                $this->claseModel->registrarReactivosClase($idClase, [$idReactivo => $cantidad], $idUsuario);
                $reactivosRegistrados[] = $nombreReactivo;
            }
        }

        // Formar mensaje con reactivos registrados y fiscalizados
        $msg = "Clase registrada.";

        if (!empty($reactivosRegistrados)) {
            $msg .= "<br>Reactivos registrados: " . implode(", ", $reactivosRegistrados) . ".";
        }

        if (!empty($reactivosFiscalizados)) {
            $msg .= "<br>Reactivos fiscalizados requieren aprobación: " . implode(", ", $reactivosFiscalizados) . ".";
        }

        $_SESSION['status_message'] = $msg;
        header("Location: index.php?c=Clase&a=registrarClase");
        exit;
    }
}


}
?>