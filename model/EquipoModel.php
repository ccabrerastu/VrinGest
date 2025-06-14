<?php
require_once __DIR__ . '/../config/database.php';

class EquipoModel {
    private $conexion;

    public function __construct() {
        try {
            $db = new Conexion();
            $this->conexion = $db->getConexion();
        } catch (Exception $e) {
            error_log("Error de conexión en EquipoModel: " . $e->getMessage());
            die("Error crítico: No se pudo conectar a la base de datos.");
        }
    }

   public function getAllEquipos() {
    $sql = "SELECT e.*, es.nombre_estado, g.nombre AS nombre_grupo, u.nombre AS nombre_ubicacion, te.nombre_tipo
            FROM Equipos e
            LEFT JOIN tbEstado es ON e.id_estado = es.id_estado
            LEFT JOIN GruposInvestigacion g ON e.id_grupo_asignado = g.id_grupo
            LEFT JOIN Ubicaciones u ON e.id_ubicacion = u.id_ubicacion
            LEFT JOIN TipoEquipo te ON e.id_tipoequipo = te.id_tipo";
    $result = $this->conexion->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}
    public function getCaracteristicasByEquipo($id_equipo) {
    $sql = "
        SELECT cte.nombre, ce.valor
        FROM CaracteristicasEquipo ce
        INNER JOIN CaracteristicaTipoEquipo cte ON ce.id_caracteristica_tipo = cte.id_caracteristica_tipo
        WHERE ce.id_equipo = ?
    ";
    $stmt = $this->conexion->prepare($sql);
    if ($stmt === false) {
        // Manejo de error, si quieres
        return [];
    }
    $stmt->bind_param("i", $id_equipo);
    $stmt->execute();
    $result = $stmt->get_result();
    $caracteristicas = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $caracteristicas[] = $row;
        }
    }
    $stmt->close();
    return $caracteristicas;
}



    public function getEquipoById($id) {
        $sql = "SELECT * FROM Equipos WHERE id_equipo = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    public function getTiposEquipo() {
    $sql = "SELECT id_tipo, nombre_tipo FROM TipoEquipo ORDER BY nombre_tipo ASC";
    $result = $this->conexion->query($sql); 
    return $result->fetch_all(MYSQLI_ASSOC);
}
public function getEstados() {
    $sql = "SELECT id_estado, nombre_estado FROM tbEstado ORDER BY nombre_estado ASC";
    $result = $this->conexion->query($sql); 
    return $result->fetch_all(MYSQLI_ASSOC);
}
public function getGrupos() {
    $sql = "SELECT id_grupo, nombre FROM GruposInvestigacion ORDER BY nombre ASC";
    $result = $this->conexion->query($sql); 

    return $result->fetch_all(MYSQLI_ASSOC);
}
    public function insertEquipo($data) {
        $sql = "INSERT INTO Equipos (tipo_equipo, codigo_patrimonial, codigo_barras, id_estado, fecha_ingreso, descripcion, id_ubicacion, id_grupo_asignado)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("sssissii",
            $data['tipo_equipo'],
            $data['codigo_patrimonial'],
            $data['codigo_barras'],
            $data['id_estado'],
            $data['fecha_ingreso'],
            $data['descripcion'],
            $data['id_ubicacion'],
            $data['id_grupo_asignado']
        );
        $stmt->execute();
    }
    public function obtenerUltimoCodigoPatrimonial() {
    $sql = "SELECT codigo_patrimonial FROM Equipos 
            WHERE codigo_patrimonial LIKE 'CP-%' 
            ORDER BY id_equipo DESC LIMIT 1";
    $resultado = $this->conexion->query($sql);

    if ($resultado && $resultado->num_rows > 0) {
        $fila = $resultado->fetch_assoc();
        return $fila['codigo_patrimonial'];
    } else {
        return null;
    }
}

public function generarNuevoCodigoPatrimonial() {
    $ultimo = $this->obtenerUltimoCodigoPatrimonial();

    if ($ultimo) {
        $numero = intval(substr($ultimo, 3));
        $nuevoNumero = str_pad($numero + 1, 5, '0', STR_PAD_LEFT);
    } else {
        $nuevoNumero = '00001';
    }

    return 'CP-' . $nuevoNumero;
}
public function obtenerUltimoCodigoBarras() {
    $sql = "SELECT codigo_barras FROM Equipos 
            WHERE codigo_barras LIKE 'CB-%' 
            ORDER BY id_equipo DESC LIMIT 1";
    $resultado = $this->conexion->query($sql);

    if ($resultado && $resultado->num_rows > 0) {
        $fila = $resultado->fetch_assoc();
        return $fila['codigo_barras'];
    } else {
        return null;
    }
}

public function generarNuevoCodigoBarras() {
    $ultimo = $this->obtenerUltimoCodigoBarras();

    if ($ultimo) {
        $numero = intval(substr($ultimo, 3)); // Extrae número sin 'CB-'
        $nuevoNumero = str_pad($numero + 1, 5, '0', STR_PAD_LEFT);
    } else {
        $nuevoNumero = '10001'; // Puedes ajustar esto si quieres iniciar desde 00001
    }

    return 'CB-' . $nuevoNumero;
}


    public function updateEquipo($data) {
        $sql = "UPDATE Equipos SET
                    tipo_equipo = ?, codigo_patrimonial = ?, codigo_barras = ?, id_estado = ?, fecha_ingreso = ?, descripcion = ?, id_ubicacion = ?, id_grupo_asignado = ?
                WHERE id_equipo = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("sssissiii",
            $data['tipo_equipo'],
            $data['codigo_patrimonial'],
            $data['codigo_barras'],
            $data['id_estado'],
            $data['fecha_ingreso'],
            $data['descripcion'],
            $data['id_ubicacion'],
            $data['id_grupo_asignado'],
            $data['id_equipo']
        );
        $stmt->execute();
    }

    public function deleteEquipo($id_equipo) {
        $sql = "DELETE FROM Equipos WHERE id_equipo = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $id_equipo);
        $stmt->execute();
    }

    public function getHistorialPrestamos($id_equipo) {
        $sql = "SELECT p.*, g.nombre AS grupo_nombre, pr.nombre AS proyecto_nombre, per.nombres, per.apellidos
                FROM Prestamos p
                LEFT JOIN GruposInvestigacion g ON p.id_grupo = g.id_grupo
                LEFT JOIN ProyectosInvestigacion pr ON p.id_proyecto = pr.id_proyecto
                LEFT JOIN Personas per ON p.id_responsable = per.id_persona
                WHERE p.id_equipo = ?
                ORDER BY fecha_prestamo DESC";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $id_equipo);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getEstados2() {
        $sql = "SELECT * FROM tbEstado";
        $result = $this->conexion->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getGrupos2() {
        $sql = "SELECT * FROM GruposInvestigacion";
        $result = $this->conexion->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getUbicaciones() {
        $sql = "SELECT * FROM Ubicaciones";
        $result = $this->conexion->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>
