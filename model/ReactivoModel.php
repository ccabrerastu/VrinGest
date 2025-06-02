<?php
require_once __DIR__ . '/../config/database.php';


class ReactivoModel {
    private $id_reactivo;
    private $nombre;
    private $formula_quimica;
    private $numero_cas;
    private $estado_fisico;
    private $concentracion_pureza;
    private $idunidamedida;
    private $numero_onu;
    private $cantidad;
    private $fecha_vencimiento;
    private $fecha_recepcion;
    private $lote;
    private $proveedor;
    private $es_fiscalizado;
    private $fk_id_fpa;
    
    private $conexion;

    public function __construct() {
        try {
            $conexion = new Conexion();
            $this->conexion = $conexion->getConexion();
        }catch (Exception $e) {
            error_log("Error de conexión en ReactivoModel: " . $e->getMessage());
            die("Error de conexión a la base de datos.");
        }
    }

    public function setIdReactivo($id_reactivo) {
        $this->id_reactivo = $id_reactivo;
    }

    public function getIdReactivo() {
        return $this->id_reactivo;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setFormulaQuimica($formula_quimica) {
        $this->formula_quimica = $formula_quimica;
    }

    public function getFormulaQuimica() {
        return $this->formula_quimica;
    }

    public function setNumeroCas($numero_cas) {
        $this->numero_cas = $numero_cas;
    }

    public function getNumeroCas() {
        return $this->numero_cas;
    }

    public function setEstadoFisico($estado_fisico) {
        $this->estado_fisico = $estado_fisico;
    }

    public function getEstadoFisico() {
        return $this->estado_fisico;
    }

    public function setConcentracionPureza($concentracion_pureza) {
        $this->concentracion_pureza = $concentracion_pureza;
    }

    public function getConcentracionPureza() {
        return $this->concentracion_pureza;
    }

    public function setIdUnidadMedida($idunidamedida) {
        $this->idunidamedida = $idunidamedida;
    }

    public function getIdUnidadMedida() {
        return $this->idunidamedida;
    }

    public function setNumeroOnu($numero_onu) {
        $this->numero_onu = $numero_onu;
    }

    public function getNumeroOnu() {
        return $this->numero_onu;
    }

    public function setCantidad($cantidad) {
        $this->cantidad = $cantidad;
    }

    public function getCantidad() {
        return $this->cantidad;
    }

    public function setFechaVencimiento($fecha_vencimiento) {
        $this->fecha_vencimiento = $fecha_vencimiento;
    }

    public function getFechaVencimiento() {
        return $this->fecha_vencimiento;
    }

    public function setFechaRecepcion($fecha_recepcion) {
        $this->fecha_recepcion = $fecha_recepcion;
    }

    public function getFechaRecepcion() {
        return $this->fecha_recepcion;
    }



    public function setEsFiscalizado($es_fiscalizado) {
        $this->es_fiscalizado = $es_fiscalizado;
    }

    public function getEsFiscalizado() {
        return $this->es_fiscalizado;
    }

    public function setFkIdFpa($fk_id_fpa) {
        $this->fk_id_fpa = $fk_id_fpa;
    }

    public function getFkIdFpa() {
        return $this->fk_id_fpa;
    }

    public function crearReactivo($nombre, $formula_quimica, $concentracion, $idunidamedida, $numero_onu, 
    $cantidad, $fecha_vencimiento, $fecha_recepcion,
    $es_fiscalizado, $id_estado, $fichatecnica, 
    $fichaseguridad, $normanfpa) {

        $query = "INSERT INTO tbReactivo (
            nombre, 
            formula_quimica, 
            concentracion_pureza, 
            idunidamedida, 
            numero_onu, 
            cantidad, 
            fecha_vencimiento, 
            fecha_recepcion, 
            es_fiscalizado,
            id_estado,
            fichatecnica,
            fichaseguridad,
            normanfpa
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $this->conexion->prepare($query);

    if ($stmt === false) {
        error_log("Error en preparación: " . $this->conexion->error);
        return false;
    }

    $stmt->bind_param(
        'sssissssiisss', // <- 15 letras para 15 valores
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

    return $stmt->execute();
}

public function actualizarReactivo($id_reactivo, $nombre, $formula_quimica, $cantidad, $fecha_vencimiento) {
    // Consulta SQL para actualizar el reactivo
    $query = "UPDATE tbReactivo SET 
                nombre = ?, 
                formula_quimica = ?, 
                cantidad = ?, 
                fecha_vencimiento = ? 
              WHERE id_reactivo = ?";

    // Preparar la consulta
    $stmt = $this->conexion->prepare($query);

    if ($stmt === false) {
        error_log("Error en preparación: " . $this->conexion->error);
        return false;
    }
 
    // Enlazar los parámetros
    $stmt->bind_param('ssssi', $nombre, $formula_quimica, $cantidad, $fecha_vencimiento, $id_reactivo);



    // Ejecutar la consulta
    return $stmt->execute();
}
    public function obtenerReactivos() {
        if ($this->conexion === null) {
            die("No hay conexión a la base de datos.");
        }
        $conn = $this->conexion;
        $sql = "SELECT r.*, u.nombre_unidad AS nombre_unidad 
        FROM tbReactivo r 
        JOIN tbUnidadMedida u ON r.idunidamedida = u.id_unidad_medida";

        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die("Error en la preparación de la consulta: " . $conn->error);
        }
        $stmt->execute();
        if ($stmt->error) {
            die("Error al ejecutar la consulta: " . $stmt->error);
        }
        $resultado = $stmt->get_result();
        $reactivos = [];
        
        while ($fila = $resultado->fetch_assoc()) {
            $reactivos[] = $fila;
        }
        return $reactivos;
    }
    public function obtenerPorFiscalizado($esFiscalizado) {
        $sql = "SELECT r.*, u.nombre_unidad AS nombre_unidad 
                FROM tbReactivo r
                LEFT JOIN tbUnidadMedida u ON r.idunidamedida = u.id_unidad_medida
                WHERE r.es_fiscalizado = ?";
        
        $stmt = $this->conexion->prepare($sql);
        if ($stmt === false) {
            error_log("Error en la preparación: " . $this->conexion->error);
            return [];
        }
    
        $stmt->bind_param("i", $esFiscalizado);
        $stmt->execute();
        $result = $stmt->get_result();
    
        $reactivos = [];
        while ($fila = $result->fetch_assoc()) {
            $reactivos[] = $fila;
        }
    
        return $reactivos;
    }
    public function obtenerReactivoPorId($id_reactivo) {
        $query = "SELECT * FROM tbReactivo WHERE id_reactivo = ?";
        $stmt = $this->conexion->prepare($query);
        if ($stmt === false) {
            error_log("Error en la preparación de la consulta: " . $this->conexion->error);
            return null;
        }
        $stmt->bind_param('i', $id_reactivo);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            return $result->fetch_assoc(); 
        } else {
            return null; 
        }
    }
    
    public function eliminarReactivo($id_reactivo) {
        $query = "DELETE FROM tbReactivo WHERE id_reactivo = ?";
        $stmt = $this->conexion->prepare($query);

        if ($stmt === false) {
            error_log("Error en la preparación de la consulta: " . $this->conexion->error);
            return false;
        }

        $stmt->bind_param('i', $id_reactivo);
        
        if ($stmt->execute()) {
            return true; 
        } else {
            error_log("Error al eliminar el reactivo: " . $stmt->error);
            return false; 
        }
    }
    public function obtenerReactivosCriticos() {
        if ($this->conexion === null) {
            die("No hay conexión a la base de datos.");
        }
    
        $conn = $this->conexion;
        $sql = "SELECT r.*, u.nombre_unidad 
                FROM tbReactivo r 
                JOIN tbUnidadMedida u ON r.idunidamedida = u.id_unidad_medida
                WHERE 
                    r.fecha_vencimiento <= DATE_ADD(CURDATE(), INTERVAL 14 DAY)
                    OR r.cantidad < 10";
    
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die("Error en la preparación: " . $conn->error);
        }
        
    
        $stmt->execute();
        $resultado = $stmt->get_result();
        $reactivos = [];
    
        while ($fila = $resultado->fetch_assoc()) {
            $reactivos[] = $fila;
        }
        if (empty($reactivos)) {
            echo "No se encontraron reactivos críticos.";
        }
    
        return $reactivos;
    }
    public function buscarFichaTecnica($nombre) {
        $apiUrl = "http://161.132.39.165:5000/buscar_ficha?nombre=" . urlencode($nombre);
        return file_get_contents($apiUrl); // Manejar errores también
    }

    public function buscarFichaSeguridad($nombre) {
        $apiUrl = "http://161.132.39.165:5050/buscar_ficha_seguridad?nombre=" . urlencode($nombre);
        return file_get_contents($apiUrl);
    }
public function actualizarFechaVencimiento($id, $fecha) {
    if ($this->conexion === null) {
        die("No hay conexión a la base de datos.");
    }
    $sql = "UPDATE tbReactivo SET fecha_vencimiento = ? WHERE id_reactivo = ?";
    $stmt = $this->conexion->prepare($sql);
    $stmt->bind_param("si", $fecha, $id); 
    $result = $stmt->execute();
    if (!$result) {
        error_log("Error execute: " . $stmt->error);
    } else {
        error_log("Ejecutado correctamente");
    }

    return $result;
}
public function actualizarCantidad($id, $cantidad) {
    if ($this->conexion === null) {
        die("No hay conexión a la base de datos.");
    }
    $sql = "UPDATE tbReactivo SET cantidad = ? WHERE id_reactivo = ?";
    $stmt = $this->conexion->prepare($sql);
    $stmt->bind_param("ii", $cantidad, $id);
    $result = $stmt->execute();
    return $result;
}
}
?>
