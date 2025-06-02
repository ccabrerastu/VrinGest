<?php
require_once __DIR__ . '/../config/database.php';

class ClaseModel {
    private $conexion;
   

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
   public function registrarClase($docente, $fecha, $horaInicio, $horaFin, $laboratorio, $idCurso, $justificacion) {
    $stmt = $this->conexion->prepare("INSERT INTO tbClase (id_usuario, fecha_clase, hora_inicio, hora_fin, id_laboratorio, idcurso, justificacion) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $docente, $fecha, $horaInicio, $horaFin,$laboratorio,$idCurso, $justificacion);
        
        if (!$stmt->execute()) {
            error_log("Error al registrar clase: " . $stmt->error);
            return false;
        }

        return $this->conexion->insert_id;
    }

   
    public function registrarMaterialesClase($idClase, $materiales) {
        $stmt = $this->conexion->prepare("INSERT INTO tbClaseMaterial (id_clase, id_material, cantidad_usada) VALUES (?, ?, ?)");
        foreach ($materiales as $idMaterial => $cantidad) {
            if ($cantidad > 0) {
                $stmt->bind_param("iid", $idClase, $idMaterial, $cantidad);
                if (!$stmt->execute()) {
                    error_log("Error al insertar material en clase: " . $stmt->error);
                }
            }
        }
        $stmt->close();
    }
    public function registrarReactivosClase($idClase, $reactivos) {
    $stmt = $this->conexion->prepare("INSERT INTO tbClaseReactivo (id_clase, id_reactivo, cantidad_usada) VALUES (?, ?, ?)");
    foreach ($reactivos as $idReactivo => $cantidad) {
        if ($cantidad > 0) {
            $stmt->bind_param("iid", $idClase, $idReactivo, $cantidad);
            if (!$stmt->execute()) {
                error_log("Error al insertar reactivo en clase: " . $stmt->error);
            }
        }
    }
    $stmt->close();
}
public function esFiscalizado($idReactivo): bool {
    $sql = "SELECT es_fiscalizado FROM tbReactivo WHERE id_reactivo = ?";
    $stmt = $this->conexion->prepare($sql);
    $stmt->bind_param("i", $idReactivo);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $row = $resultado->fetch_assoc();

    return $row && isset($row['es_fiscalizado']) && $row['es_fiscalizado'] == 1;
}
public function registrarSolicitudFiscalizado($idClase, $idReactivo, $cantidad, $idUsuario) {
    $sql = "INSERT INTO tbSolicitudesFiscalizados 
            (id_clase, id_reactivo, id_usuario, cantidad_solicitada, estado, fecha_solicitud)
            VALUES (?, ?, ?, ?, 'Pendiente', NOW())";
    $stmt = $this->conexion->prepare($sql);
    $stmt->bind_param("iiid", $idClase, $idReactivo, $idUsuario, $cantidad);

    if (!$stmt->execute()) {
        error_log("Error al registrar solicitud de reactivo fiscalizado: " . $stmt->error);
    }

    $stmt->close();
}
public function obtenerNombreReactivo($idReactivo) {
    $sql = "SELECT nombre FROM tbReactivo WHERE id_reactivo = ?";
    $stmt = $this->conexion->prepare($sql);
    $stmt->bind_param("i", $idReactivo);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $row = $resultado->fetch_assoc();
    $stmt->close();

    return $row ? $row['nombre'] : "Reactivo #$idReactivo";
}
public function obtenerClasesPorUsuario($idUsuario) {
    $stmt = $this->conexion->prepare("SELECT * FROM tbClase WHERE id_usuario = ?");
    $stmt->bind_param("s", $idUsuario);
    $stmt->execute();
    $resultado = $stmt->get_result();
    return $resultado->fetch_all(MYSQLI_ASSOC);
}
public function obtenerSolicitudesPorUsuario($idUsuario) {
    $stmt = $this->conexion->prepare("SELECT
                sf.id_solicitud,
                sf.estado,
                c.idclase,
                l.numero,
                r.nombre,
                c.fecha_clase,
                c.hora_inicio,
                c.hora_fin,
                c.idcurso,
                c.justificacion,
                cu.nombre_curso
            FROM
                tbSolicitudesFiscalizados sf
            JOIN tbClase c ON sf.id_clase = c.idclase
            JOIN tbLaboratorio l ON c.id_laboratorio = l.id
            JOIN tbReactivo r ON sf.id_reactivo = r.id_reactivo
            JOIN tbCurso cu ON c.idcurso = cu.idcurso
            WHERE
                sf.id_usuario = ?
            GROUP BY
                sf.id_clase, sf.id_solicitud
            ORDER BY
                c.fecha_clase DESC");
    $stmt->bind_param("s", $idUsuario);
    $stmt->execute();
    $resultado = $stmt->get_result();
    return $resultado->fetch_all(MYSQLI_ASSOC);
}
public function obtenerSolicitudes() {
    $stmt = $this->conexion->prepare("SELECT
    sf.id_solicitud,
    sf.estado,
    sf.id_usuario,
    sf.fecha_solicitud,
    c.fecha_clase AS fecha_uso,
    CONCAT(u.nombre, ' ', u.apellido) AS nombre_usuario,
    c.idclase,
    l.numero,
    r.nombre AS nombre_reactivo,
    r.id_reactivo,
    sf.cantidad_solicitada,
    r.es_fiscalizado,
    c.hora_inicio,
    c.hora_fin,
    c.idcurso,
    c.justificacion,
    cu.nombre_curso
FROM tbSolicitudesFiscalizados sf
JOIN tbClase c ON sf.id_clase = c.idclase
JOIN tbLaboratorio l ON c.id_laboratorio = l.id
JOIN tbReactivo r ON sf.id_reactivo = r.id_reactivo
JOIN tbCurso cu ON c.idcurso = cu.idcurso
JOIN tbUsuario u ON sf.id_usuario = u.idusuario");
    
    $stmt->execute();
    $resultado = $stmt->get_result();
    return $resultado->fetch_all(MYSQLI_ASSOC);
}
public function actualizarEstadoSolicitud2($idSolicitud, $idUsuario, $estado, $nota) {
    $stmt = $this->conexion->prepare("UPDATE tbSolicitudesFiscalizados SET estado = ?, nota = ?, id_usuario_decision = ? WHERE id_solicitud = ?");
    
    if (!$stmt) {
        die("Error en prepare: " . $this->conexion->error); // ❗ Agrega esto para debug
    }

    $stmt->bind_param("ssii", $estado, $nota, $idUsuario, $idSolicitud);

    if (!$stmt->execute()) {
        die("Error en execute: " . $stmt->error); // ❗ También agrega esto
    }

    $filasAfectadas = $stmt->affected_rows;

    $stmt->close();

    return $filasAfectadas > 0;
}

   
} 
?>
