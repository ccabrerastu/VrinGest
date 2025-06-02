<?php
require_once __DIR__ . '/../config/database.php';

class MaterialModel {
    private $conexion;
    private $id_material;
    private $nombre;
    private $id_tipo_material;
    private $cantidad_stock;
  public function getIdMaterial() {
        return $this->id_material;
    }

    public function setIdMaterial($id_material) {
        $this->id_material = $id_material;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function getIdTipoMaterial() {
        return $this->id_tipo_material;
    }

    public function setIdTipoMaterial($id_tipo_material) {
        $this->id_tipo_material = $id_tipo_material;
    }

    public function getCantidadStock() {
        return $this->cantidad_stock;
    }

    public function setCantidadStock($cantidad_stock) {
        $this->cantidad_stock = $cantidad_stock;
    }

    public function __construct() {
        try {
            $db = new Conexion(); 
            $this->conexion = $db->getConexion();
        } catch (Exception $e) {
            error_log("Error de conexión en MaterialModel: " . $e->getMessage());
            die("Error crítico: No se pudo conectar a la base de datos.");
        }
    }

    public function getAllMaterialesList() {
        $sql = "SELECT
                    m.id_material,
                    m.nombre,
                    tm.descripcion AS tipo, 
                    m.cantidad_stock,
                    m.descripcion
                   
                FROM tbMateriales m
                LEFT JOIN tbTipoMaterial tm ON m.id_tipo_material = tm.idtipo 
                ORDER BY m.nombre ASC";

        $resultado = $this->conexion->query($sql);

        if (!$resultado) {
            error_log("Error ejecutando getAllMaterialesList: (" . $this->conexion->errno . ") " . $this->conexion->error);
            return [];
        }

        $materiales = $resultado->fetch_all(MYSQLI_ASSOC);
        $resultado->free();
        return $materiales;
    }
    public function agregarMaterial($nombre, $id_tipo_material, $cantidad_stock) {
        
        $sql_check = "SELECT COUNT(*) FROM tbMateriales WHERE nombre = ?";
        $stmt_check = $this->conexion->prepare($sql_check);
        $stmt_check->bind_param('s', $nombre);
        $stmt_check->execute();
        $stmt_check->bind_result($count);
        $stmt_check->fetch();
        $stmt_check->close();
    
        
        if ($count > 0) {
            return false; 
        }
    
       
        $sql = "INSERT INTO tbMateriales (nombre, id_tipo_material, cantidad_stock) VALUES (?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param('sii', $nombre, $id_tipo_material, $cantidad_stock);
        $resultado = $stmt->execute();
        $stmt->close();
    
        return $resultado;
    }
    public function obtenerIdTipoMaterial($tipo) {
        
        $query = "SELECT id_tipo_material FROM tbTipoMaterial WHERE nombre = ?";
        $stmt = $this->conexion->prepare($query);
    
        if (!$stmt) {
            error_log("Error preparando la consulta: " . $this->conexion->error);
            return 0; 
        }
    
        
        $stmt->bind_param("s", $tipo);
    
        
        $stmt->execute();
    
       
        $stmt->bind_result($id_tipo_material);
    
        
        if ($stmt->fetch()) {
            $stmt->close();
            return $id_tipo_material;
        } else {
            $stmt->close();
            return 0; 
        }
    }
    public function actualizarMaterial($id, $nombre, $id_tipo_material, $cantidad_stock) {
        $query = "UPDATE tbMateriales SET nombre = ?, id_tipo_material = ?, cantidad_stock = ? WHERE id_material = ?";
        $stmt = $this->conexion->prepare($query);
    
        if (!$stmt) {
            error_log("Error preparando la consulta: " . $this->conexion->error);
            return false;
        }
    
       
        $stmt->bind_param("siii", $nombre, $id_tipo_material, $cantidad_stock, $id);
    
        
        $resultado = $stmt->execute();
    
        if ($resultado) {
            error_log("Actualización exitosa para el ID: $id");
        } else {
            error_log("Error al ejecutar la consulta de actualización: " . $stmt->error);
        }
    
        $stmt->close();
        return $resultado;
    }


} 
?>
