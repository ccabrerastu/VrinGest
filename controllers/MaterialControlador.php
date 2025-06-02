<?php
require_once __DIR__ . '/../model/MaterialModel.php';

class MaterialControlador {

    public function index() {
        if (session_status() === PHP_SESSION_NONE) { session_start(); }

        $isAdmin = (isset($_SESSION['idRol']) && $_SESSION['idRol'] == 2);

        $materialModel = new MaterialModel();
        $materiales = $materialModel->getAllMaterialesList();

        $statusMessage = $_SESSION['status_message'] ?? null;
        unset($_SESSION['status_message']);  

        if ($isAdmin) {
            require __DIR__ . '/../views/gestionarMaterialesVista.php';
        } else {
            require __DIR__ . '/../views/visualizarMaterialesVista.php';
             
        }
    }

    public function agregarMateriales() {
        if (session_status() === PHP_SESSION_NONE) { session_start(); }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
            $id_tipo_material = isset($_POST['id_tipo_material']) ? intval($_POST['id_tipo_material']) : 0;
            $cantidad_stock = isset($_POST['cantidad_stock']) ? intval($_POST['cantidad_stock']) : 0;

            if ($nombre !== '' && $id_tipo_material > 0 && $cantidad_stock >= 0) {
                $materialModel = new MaterialModel();
                $resultado = $materialModel->agregarMaterial($nombre, $id_tipo_material, $cantidad_stock);

                
                if ($resultado) {
                    $_SESSION['status_message'] = "Material agregado correctamente.";
                } else {
                    $_SESSION['status_message'] = "El material con ese nombre ya existe.";
                }
            } else {
                $_SESSION['status_message'] = "Datos inválidos. Verifique los campos.";
            }

           
            header("Location: index.php?c=Material&a=index");
            exit;
        }
    }
    public function actualizarMaterial() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (session_status() === PHP_SESSION_NONE) { session_start(); }
            
            $id = isset($_POST['id_material']) ? intval($_POST['id_material']) : 0;
            $nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
            $id_tipo_material = isset($_POST['id_tipo_material']) ? intval($_POST['id_tipo_material']) : 0;
            $cantidad_stock = isset($_POST['cantidad_stock']) ? intval($_POST['cantidad_stock']) : 0;
            
            if ($id > 0 && $nombre !== '' && $id_tipo_material > 0 && $cantidad_stock >= 0) {
                $materialModel = new MaterialModel();
                $resultado = $materialModel->actualizarMaterial($id, $nombre, $id_tipo_material, $cantidad_stock);
    
                if ($resultado) {
                    $_SESSION['status_message'] = "Material actualizado correctamente.";
                } else {
                    $_SESSION['status_message'] = "Hubo un problema al actualizar el material.";
                }
            } else {
                $_SESSION['status_message'] = "Datos inválidos. Verifique los campos.";
            }
    
            header("Location: index.php?c=Material&a=index");
            exit;
        }
    }

}
?>
