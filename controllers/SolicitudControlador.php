<?php
require_once 'vendor/autoload.php';
require_once 'model/usuarioModel.php';
require_once 'model/ReactivoModel.php';
require_once 'model/MaterialModel.php';
require_once 'model/ClaseModel.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class SolicitudControlador {
   private $reactivoModel;
   private $materialModel;
   private $claseModel;


    public function __construct()
    {
        $this->reactivoModel = new ReactivoModel();
        $this->materialModel = new MaterialModel();
        $this->claseModel = new ClaseModel();

    }

    public function index() 
    {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    $idUsuario = $_SESSION['idusuario'] ?? null;

    if (!$idUsuario) {
        header("Location:index.php?c=Clase&a=registrarClase");
        exit;
    }

    $solicitudes = $this->claseModel->obtenerSolicitudesPorUsuario($idUsuario);

    
    require __DIR__ . '/../views/miSolicitudVista.php';
    }

    public function index2() 
    {
    $solicitudesRaw = $this->claseModel->obtenerSolicitudes();
    $solicitudesPendientesAgrupadas = [];

foreach ($solicitudesRaw as $solicitud) {
    $idClase = $solicitud['idclase'];

    if (!isset($solicitudesPendientesAgrupadas[$idClase])) {
        $solicitudesPendientesAgrupadas[$idClase] = [
            'id_clase' => $idClase,
            'fecha_solicitud' => $solicitud['fecha_solicitud'],
            'fecha_uso' => $solicitud['fecha_uso'],
            'curso' => $solicitud['nombre_curso'],
            'justificacion' => $solicitud['justificacion'],
            'solicitantes' => [],
            'reactivos' => [],
        ];
    }

    if (!in_array($solicitud['nombre_usuario'], $solicitudesPendientesAgrupadas[$idClase]['solicitantes'])) {
        $solicitudesPendientesAgrupadas[$idClase]['solicitantes'][] = $solicitud['nombre_usuario'];
    }

    // Agregar reactivo
    $solicitudesPendientesAgrupadas[$idClase]['reactivos'][] = [
        'id_solicitud' => $solicitud['id_solicitud'], 
        'nombre' => $solicitud['nombre_reactivo'],
        'cantidad' => $solicitud['cantidad_solicitada'],
        'fiscalizado' => $solicitud['es_fiscalizado'],
    ];
}
    
    require __DIR__ . '/../views/solicitudesVista.php';
    }
public function actualizarEstadoSolicitud() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id_solicitud = isset($_POST['id_solicitud']) ? (int)$_POST['id_solicitud'] : null;
        $estado = isset($_POST['estado']) ? trim($_POST['estado']) : null;
        $nota = isset($_POST['nota']) ? trim($_POST['nota']) : null;

        $id_usuario_decision = $_SESSION['idusuario'] ?? null;

        error_log("id_solicitud: " . var_export($id_solicitud, true));
        error_log("estado: " . var_export($estado, true));
        error_log("id_usuario_decision: " . var_export($id_usuario_decision, true));

        if ($id_solicitud !== null && $estado !== null && $estado !== '' && $id_usuario_decision !== null) {
            $solicitudModel = new ClaseModel();

            $resultado = $solicitudModel->actualizarEstadoSolicitud2($id_solicitud, $id_usuario_decision, $estado, $nota);

            if ($resultado) {
                http_response_code(200);
                echo "Solicitud actualizada correctamente";
            } else {
                http_response_code(500);
                echo "Error al actualizar solicitud o no se realizaron cambios";
            }
        } else {
            http_response_code(400);
            echo "Datos inválidos";
        }
    } else {
        http_response_code(405);
        echo "Método no permitido";
    }
}

}
?>