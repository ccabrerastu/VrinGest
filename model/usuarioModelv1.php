<?php
require_once __DIR__ . '/../config/database.php';

class UsuarioModel {
    private $id;
    private $nombre;
    private $apellidos;
    private $codigo_institucional;
    private $email;
    private $contrasena; 
    private $rol; 
    private $activo; 
    private $conexion; 

   
    public function __construct() {
        try {
            $db = new Conexion(); 
            $this->conexion = $db->getConexion();
        } catch (Exception $e) {
            error_log("Error de conexión en UsuarioModel: " . $e->getMessage());
            die("Error crítico: No se pudo conectar a la base de datos.");
        }
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getId() {
        return $this->id;
    }

    public function setNombre($nombre) {
        $this->nombre = trim($nombre); 
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setApellidos($apellidos) {
        $this->apellidos = trim($apellidos);
    }

    public function getApellidos() {
        return $this->apellidos;
    }

    public function setCodigoInstitucional($codigo_institucional) {
        $this->codigo_institucional = trim($codigo_institucional);
    }

    public function getCodigoInstitucional() {
        return $this->codigo_institucional;
    }

    public function setEmail($email) {
        $this->email = trim($email);
    }

    public function getEmail() {
        return $this->email;
    }

    public function setContrasena($contrasena) {
        $this->contrasena = $contrasena;
    }


    public function setRol($rol) {
        $this->rol = (int)$rol; 
    }

    public function getRol() {
        return $this->rol;
    }

    public function setActivo($activo) {
        $this->activo = (bool)$activo;
    }

    public function isActivo() {
        return $this->activo;
    }


    public function verificarCredenciales($codigo_institucional, $contrasena_ingresada) {
        $sql = "SELECT idusuario, nombre, apellido, idRol, contrasena, activo
                FROM tbUsuario
                WHERE codigo_institucional = ? AND activo = 1";
        $stmt = $this->conexion->prepare($sql);

        if (!$stmt) {
            error_log("Error preparando la consulta de verificación: (" . $this->conexion->errno . ") " . $this->conexion->error);
            return null;
        }

        $stmt->bind_param("s", $codigo_institucional);

        if (!$stmt->execute()) {
            error_log("Error ejecutando la consulta de verificación: (" . $stmt->errno . ") " . $stmt->error);
            $stmt->close();
            return null;
        }

        $resultado = $stmt->get_result();
        $stmt->close(); 

        if ($resultado->num_rows === 1) {
            $usuario = $resultado->fetch_assoc();
            $resultado->free(); 
            
            if (password_verify($contrasena_ingresada, $usuario['contrasena'])) {
                return [
                    'idusuario' => $usuario['idusuario'],
                    'nombre' => $usuario['nombre'],
                    'apellido' => $usuario['apellido'],
                    'idRol' => $usuario['idRol']
                ];
            } else {
                return null;
            }
        } else {
            return null;
        }
    }

    
    public function obtenerUsuariosConRol() {
        $sql = "SELECT
                    u.idusuario,
                    CONCAT(u.nombre, ' ', u.apellido) AS nombre_completo,
                    u.codigo_institucional,
                    u.email_insitucional,
                    r.nombre_rol AS rol,
                    u.activo
                FROM tbUsuario u
                LEFT JOIN tbRol r ON u.idRol = r.id_rol
                ORDER BY u.apellido, u.nombre";

        $resultado = $this->conexion->query($sql);

        if (!$resultado) {
            error_log("Error ejecutando la consulta obtenerUsuariosConRol: (" . $this->conexion->errno . ") " . $this->conexion->error);
            return [];
        }

        $usuarios = $resultado->fetch_all(MYSQLI_ASSOC);
        $resultado->free();
        return $usuarios;
    }

    public function agregarUsuario() {
        if (empty($this->nombre) || empty($this->apellidos) || empty($this->codigo_institucional) || empty($this->email) || empty($this->contrasena) || empty($this->rol)) {
            error_log("Intento de agregar usuario con datos incompletos.");
            return false;
        }

        $hashedPassword = password_hash($this->contrasena, PASSWORD_DEFAULT);
        if ($hashedPassword === false) {
            error_log("Error al hashear la contrasena.");
            return false;
        }


        $sql = "INSERT INTO tbUsuario
                    (nombre, apellido, codigo_institucional, email_insitucional, contrasena, idRol, activo, fecha_creacion)
                    VALUES (?, ?, ?, ?, ?, ?, 1, NOW())";
        $stmt = $this->conexion->prepare($sql);

        if (!$stmt) {
            error_log("Error preparando la consulta de inserción de usuario: (" . $this->conexion->errno . ") " . $this->conexion->error);
            return false;
        }

        $stmt->bind_param("sssssi",
            $this->nombre,
            $this->apellidos,
            $this->codigo_institucional,
            $this->email,
            $hashedPassword,
            $this->rol
        );

        $success = $stmt->execute();

        if (!$success) {
            error_log("Error ejecutando la inserción de usuario: (" . $stmt->errno . ") " . $stmt->error);
        }

        $stmt->close();
        return $success;
    }

    
    public function find($id) {
        $sql = "SELECT idusuario, nombre, apellido, codigo_institucional, email_insitucional, idRol, activo FROM tbUsuario WHERE idusuario = ?";
        $stmt = $this->conexion->prepare($sql);
        if (!$stmt) { error_log("Error prepare find: ".$this->conexion->error); return null; }
        $stmt->bind_param("i", $id);
        if (!$stmt->execute()) { error_log("Error execute find: ".$stmt->error); $stmt->close(); return null; }
        $resultado = $stmt->get_result();
        $usuario = $resultado->fetch_assoc();
        $resultado->free();
        $stmt->close();
        return $usuario;
    }

    
    Public function cambiarRol($idUsuario, $idNuevoRol) {
        $sql = "UPDATE tbUsuario SET idRol = ? WHERE idusuario = ?";
        $stmt = $this->conexion->prepare($sql);
        if (!$stmt) { error_log("Error prepare cambiarRol: ".$this->conexion->error); return false; }
        $stmt->bind_param("ii", $idNuevoRol, $idUsuario);
        $success = $stmt->execute();
        if (!$success) { error_log("Error execute cambiarRol: ".$stmt->error); }
        $stmt->close();
        return $success;
    }


}
?>
