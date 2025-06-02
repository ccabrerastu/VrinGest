<?php
require_once __DIR__ . '/../model/ReactivoModel.php'; 


class ReactivoControlador  {

    private $reactivoModel;

    public function __construct()
    {
        $this->reactivoModel = new ReactivoModel();
    }

    public function index() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    
        $isAdmin = (isset($_SESSION['idRol']) && $_SESSION['idRol'] == 2);
        $statusMessage = $_SESSION['status_message'] ?? null;
        unset($_SESSION['status_message']);
        $filtro = isset($_GET['filtro']) ? $_GET['filtro'] : null;
            if ($filtro === '0' || $filtro === '1') {
            $reactivos = $this->reactivoModel->obtenerPorFiscalizado($filtro);
        } else {
            $reactivos = $this->reactivoModel->obtenerReactivos(); 
        }
    
        $baseUrl = "/";
    
        if ($isAdmin) {
            require __DIR__ . '/../views/gestionarReactivosVista.php';
        } else {
            require __DIR__ . '/../views/visualizarReactivosVista.php';
      
        }
    }

    public function registrarClase() {
    $reactivos = $this->reactivoModel->obtenerReactivos();
    
    require __DIR__ . '/../views/registrarClaseVista.php';
} 
    public function mostrarReactivosCriticos() {
        $reactivos = $this->modelo->obtenerReactivosCriticos();
        require_once 'views/DashboardAVista.php';
    }
    public function crearReactivo() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['nombre_reactivo'] ?? '';
            $formula_quimica = $_POST['formula_quimica'] ?? '';
            $concentracion = $_POST['concentracion_pureza'] ?? '';
            $idunidamedida = $_POST['unidad_medida'] ?? 0;
            $numero_onu = $_POST['numero_onu'] ?? '';
            $cantidad = $_POST['cantidad'] ?? 0;
            $fecha_vencimiento = $_POST['fecha_caducidad'] ?? '';
            $fecha_recepcion = $_POST['fecha_recepcion'] ?? '';
            $es_fiscalizado = isset($_POST['tipo_reactivo']) ? (int)$_POST['tipo_reactivo'] : 0;
;
            $id_estado = $_POST['estado_reactivo'] ?? 0;
            $fichatecnica = $_POST['ficha_tecnica_ref'] ?? '';
            $fichaseguridad = $_POST['ficha_seguridad_ref'] ?? '';
            $normanfpa = '';
            if (isset($_FILES['norma_nfpa_img']) && $_FILES['norma_nfpa_img']['error'] === UPLOAD_ERR_OK) {
                $archivo = $_FILES['norma_nfpa_img'];
                $nombreArchivo = basename($archivo['name']);
                $extension = strtolower(pathinfo($nombreArchivo, PATHINFO_EXTENSION));
                $permitidas = ['jpg', 'jpeg', 'png', 'gif'];
    
                if (in_array($extension, $permitidas) && $archivo['size'] <= 2 * 1024 * 1024) {
                    $directorioDestino = 'assets/imagenes/nfpa/';
                    if (!is_dir($directorioDestino)) {
                        mkdir($directorioDestino, 0777, true);
                    }
    
                    $nombreUnico = uniqid('nfpa_', true) . '.' . $extension;
                    $rutaCompleta = $directorioDestino . $nombreUnico;
    
                    if (move_uploaded_file($archivo['tmp_name'], $rutaCompleta)) {
                        $normanfpa = $rutaCompleta; 
                    } else {
                        $formErrors['norma_nfpa_img'] = 'Error al mover el archivo.';
                    }
                } else {
                    $formErrors['norma_nfpa_img'] = 'Formato no válido o archivo demasiado grande.';
                }
            } else {
                $formErrors['norma_nfpa_img'] = 'Debe subir una imagen.';
            }
            if (!empty($formErrors)) {
                require_once 'views/agregarReactivoVista.php';
                return;
            }
            $resultado = $this->reactivoModel->crearReactivo(
                $nombre,
                $formula_quimica,
                $concentracion,
                $idunidamedida,
                $numero_onu,
                $cantidad,
                $fecha_vencimiento,
                $fecha_recepcion,
                $es_fiscalizado,
                $id_estado,
                $fichatecnica,
                $fichaseguridad,
                $normanfpa
            );
  
            
            $_SESSION['status_message'] = $resultado
                ? "Reactivo creado correctamente."
                : "Hubo un problema al crear el reactivo.";
    
            header("Location: index.php?c=Reactivo&a=index");
            exit;
        }
    }
    public function actualizarReactivo() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_reactivo = $_POST['id_reactivo'] ?? 0;
            $nombre = $_POST['nombre'] ?? '';
            $formula_quimica = $_POST['formula_quimica'] ?? '';
            $cantidad = $_POST['cantidad'] ?? 0;
            $fecha_vencimiento = $_POST['fecha_vencimiento'] ?? '';
            if ($id_reactivo === 0) {
                $_SESSION['status_message'] = "ID del reactivo no válido.";
                header("Location: index.php?c=Reactivo&a=index");
                exit;
            }
            if (empty($nombre) || empty($formula_quimica) || empty($cantidad) || empty($fecha_vencimiento)) {
                $_SESSION['status_message'] = "Todos los campos son obligatorios.";
                header("Location: index.php?c=Reactivo&a=index");
                exit;
            }     
            $resultado = $this->reactivoModel->actualizarReactivo(
                $id_reactivo,
                $nombre,
                $formula_quimica,
                $cantidad,
                $fecha_vencimiento
            );
            $_SESSION['status_message'] = $resultado
                ? "Reactivo actualizado correctamente."
                : "Hubo un problema al actualizar el reactivo.";
    
            header("Location: index.php?c=Reactivo&a=index");
            exit;
        }
 
    }
    
    
    public function create() {
        require_once 'views/agregarReactivoVista.php'; 
    }



    public function gestionarReactivos()
    {
        
        $modelo = new ReactivoModel();
        $reactivos = $modelo->obtenerReactivos(); 
        error_log("CONTENIDO DE \$reactivos: " . print_r($reactivos, true));
        require_once '/../views/gestionarReactivosVista.php';
    }
    
    public function obtenerReactivoPorId($id_reactivo) {
        $reactivo = $this->reactivoModel->obtenerReactivoPorId($id_reactivo);

        if ($reactivo) {
            echo "ID: " . $reactivo['id_reactivo'] . "<br>";
            echo "Nombre: " . $reactivo['nombre'] . "<br>";
            echo "Fórmula química: " . $reactivo['formula_quimica'] . "<br>";
           
        } else {
            echo "Reactivo no encontrado.";
        }
    }



    public function eliminarReactivo($id_reactivo) {
        $resultado = $this->reactivoModel->eliminarReactivo($id_reactivo);

        
        if ($resultado) {
            echo "Reactivo eliminado con éxito!";
        } else {
            echo "Error al eliminar el reactivo.";
        }
    }
    public function buscarFichaTecnica() {
        $nombre = $_GET['nombre'] ?? '';
        if (empty(trim($nombre))) {
            http_response_code(400);
            echo json_encode(['error' => 'Nombre vacío']);
            return;
        }
        echo $this->model->buscarFichaTecnica($nombre);
    }

    public function buscarFichaSeguridad() {
        $nombre = $_GET['nombre'] ?? '';
        if (empty(trim($nombre))) {
            http_response_code(400);
            echo json_encode(['error' => 'Nombre vacío']);
            return;
        }
        echo $this->model->buscarFichaSeguridad($nombre);
    }
  public function actualizarReactivoDesdeModal() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'] ?? null;
        $tipo = $_POST['tipo'] ?? null;
        $valor = $_POST['valor'] ?? null;
        

        if ($id === null || $tipo === null || $valor === null) {
            echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
            return;
        }

        $resultado = false;
        if ($tipo === 'stock') {
            $resultado = $this->reactivoModel->actualizarCantidad($id, $valor);
        } elseif ($tipo === 'fecha') {
            $resultado = $this->reactivoModel->actualizarFechaVencimiento($id, $valor);
        }

        if ($resultado) {
            header('Location: index.php?c=Dashboard&a=index');
            exit;
        } else {
            echo json_encode(['success' => false, 'message' => 'No se pudo actualizar el reactivo.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    }
}

}
?>
