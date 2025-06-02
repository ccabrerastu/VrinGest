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
    
    private $conexion;

    public function __construct() {
        try {
            $conexion = new Conexion();
            $this->conexion = $conexion->getConexion();
        }catch (Exception $e) {
            error_log("Error de conexión en UsuarioModel: " . $e->getMessage());
            die("Error de conexión a la base de datos.");
        }
        
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getId() {
        return $this->id;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setApellidos($apellidos) {
        $this->apellidos = $apellidos;
    }

    public function getApellidos() {
        return $this->apellidos;
    }

    public function setCodigoInstitucional($codigo_institucional) {
        $this->codigo_institucional = $codigo_institucional;
    }

    public function getCodigoInstitucional() {
        return $this->codigo_institucional;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setContrasena($contrasena) {
        $this->contrasena = $contrasena;
    }

    public function getContrasena() {
        return $this->contrasena;
    }

    public function setRol($rol) {
        $this->rol = $rol;
    }

    public function getRol() {
        return $this->rol;
    }
    public function setActivo($activo) { $this->activo = (bool)$activo; }
    public function isActivo() { return $this->activo; }
public function verificarCredenciales($codigo_institucional, $clave) {
    $conn = $this->conexion;

    $stmt = $conn->prepare("
        SELECT 
            u.id_usuario,
            u.username,
            u.password_hash,
            u.id_rol_sistema,
            u.activo,
            p.nombres,
            p.apellidos,
            p.dni,
            rs.nombre_rol
        FROM Usuarios u
        INNER JOIN Personas p ON u.id_persona = p.id_persona
        INNER JOIN RolesSistema rs ON u.id_rol_sistema = rs.id_rol_sistema
        WHERE u.username = ?
    ");

    $stmt->bind_param("s", $codigo_institucional);
    $stmt->execute();

    $resultado = $stmt->get_result();
    $usuarioData = $resultado->fetch_assoc();

    if ($usuarioData) {
        // Hashear la contraseña ingresada con SHA256 para comparar
        $claveHasheada = hash('sha256', $clave);

        if ($claveHasheada === $usuarioData['password_hash']) {
            return $usuarioData;
        }
    }
    return null;
}

    public function obtenerUsuariosConRol() {
        $conn = $this->conexion;

        $sql = "SELECT 
                    idusuario,
                    CONCAT(nombre, ' ', apellido) AS nombre_completo, 
                    CASE 
                        WHEN idRol = 1 THEN 'Docente' 
                        WHEN idRol = 2 THEN 'Administrador' 
                        ELSE 'Otro' 
                    END AS rol
                FROM tbUsuario";

        $stmt = $conn->prepare($sql);

        $stmt->execute();

        $resultado = $stmt->get_result();

        $usuarios = [];

        while ($fila = $resultado->fetch_assoc()) {
            $usuarios[] = $fila;
        }
        return $usuarios;
    }

    public function agregarUsuario() {
        $stmt = $this->conexion->prepare("INSERT INTO tbUsuario (nombre, apellido, codigo_institucional, email_insitucional, contrasena, idRol) VALUES (?, ?, ?, ?, ?, ?)");
        
        $stmt->bind_param("sssssi", 
            $this->nombre, 
            $this->apellidos, 
            $this->codigo_institucional, 
            $this->email, 
            $this->contrasena, 
            $this->rol
        );

        if ($stmt->execute()) {
            return true;  
        } else {
            return false; 
        }
    }
    public function findByCodigoInstitucional($codigo) {
        $sql = "SELECT idusuario FROM tbUsuario WHERE codigo_institucional = ?";
        $stmt = $this->conexion->prepare($sql);
        if (!$stmt) { error_log("Error prepare findByCodigo: ".$this->conexion->error); return null; }
        $stmt->bind_param("s", $codigo);
        if (!$stmt->execute()) { error_log("Error execute findByCodigo: ".$stmt->error); $stmt->close(); return null; }
        $resultado = $stmt->get_result();
        $usuario = $resultado->fetch_assoc();
        $resultado->free();
        $stmt->close();
        return $usuario;
    }
    
    public function findByEmail($email) {
        $sql = "SELECT idusuario FROM tbUsuario WHERE email_insitucional = ?";
        $stmt = $this->conexion->prepare($sql);
        if (!$stmt) { error_log("Error prepare findByEmail: ".$this->conexion->error); return null; }
        $stmt->bind_param("s", $email);
        if (!$stmt->execute()) { error_log("Error execute findByEmail: ".$stmt->error); $stmt->close(); return null; }
        $resultado = $stmt->get_result();
        $usuario = $resultado->fetch_assoc();
        $resultado->free();
        $stmt->close();
        return $usuario; 
    }

    public function cambiarRol($idUsuario, $idNuevoRol) {
        $sql = "UPDATE tbUsuario SET idRol = ? WHERE idusuario = ?";
        $stmt = $this->conexion->prepare($sql);

        if (!$stmt) {
            error_log("Error preparando cambiarRol: (" . $this->conexion->errno . ") " . $this->conexion->error);
            return false;
        }

        $stmt->bind_param("ii", $idNuevoRol, $idUsuario);
        $success = $stmt->execute();
        if (!$success) {
            error_log("Error ejecutando cambiarRol: (" . $stmt->errno . ") " . $stmt->error);
        }
        $stmt->close();
        return $success;
    }
    public function guardarCodigoVerificacion($codigo_institucional, $codigo) {
        $conn = $this->conexion;
        $stmt = $conn->prepare("UPDATE tbUsuario SET codigo_verificacion = ? WHERE codigo_institucional = ?");
        return $stmt->execute([$codigo, $codigo_institucional]);
    }
    
    public function verificarCodigo($codigo_institucional, $codigo) {
        $conn = $this->conexion; 
        $stmt = $conn->prepare("SELECT * FROM tbUsuario WHERE codigo_institucional = ? AND codigo_verificacion = ?");
        $stmt->bind_param("ss", $codigo_institucional, $codigo);  
        $stmt->execute();
        $result = $stmt->get_result();  
        return $result->fetch_assoc();  
    }
    


}
?>
