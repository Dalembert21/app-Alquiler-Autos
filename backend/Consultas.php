<?php
include_once "conexion.php";
class Modelo{ 
    public static function registrarUsuario(){
        try {
            // Recoger los datos del formulario
            $nombreRegistro = $_POST['nombre_Registro'];
            $apellidoRegistro = $_POST['apellido_Registro'];
            $correoRegistro = $_POST['correo_Registro'];
            $contraseñaRegistro = $_POST['clave_Registro'];
        
            // Conectar a la base de datos
            $objetoConexion = new Conexion();
            $con = $objetoConexion->conectar();
        
            // Preparar la consulta SQL
            $sql = "INSERT INTO usuarios (nombre_Registro, apellido_Registro, correo_Registro, clave_Registro) VALUES (?, ?, ?, ?)";
            $datos = $con->prepare($sql);
        
            // Ejecutar la consulta con los datos
            if ($datos->execute([$nombreRegistro, $apellidoRegistro, $correoRegistro, $contraseñaRegistro])) {
                // Usuario creado con éxito
                echo json_encode(['mensaje' => 'Usuario creado exitosamente']);
            } else {
                // Manejo de errores en caso de fallo en la ejecución
                echo json_encode(['mensaje' => 'Usuario no creado: error al ejecutar la consulta']);
            }
        } catch (PDOException $e) {
            // Manejo de excepciones
            echo json_encode(['mensaje' => 'Usuario no registrado: ' . $e->getMessage()]);
        }
    }

    public static function loginUsuario() {
        try {
            $correoRegistro = $_POST['correo_Registro'];
            $contraseñaRegistro = $_POST['clave_Registro'];

            // Conectar a la base de datos
            $objetoConexion = new Conexion();
            $con = $objetoConexion->conectar();

            // Preparar la consulta SQL
            $sql = "SELECT nombre_Registro FROM usuarios WHERE correo_Registro = ? AND clave_Registro = ?";
            $dato = $con->prepare($sql);
            $dato->execute([$correoRegistro, $contraseñaRegistro]);

            // Verificar si se encontró al usuario
            if ($dato->rowCount() > 0) {
                // Obtener el nombre del usuario autenticado
                $usuario = $dato->fetch(PDO::FETCH_ASSOC);
                $nombreUsuario = $usuario['nombre_Registro'];

                // Usuario autenticado correctamente
                echo json_encode(['mensaje' => 'Usuario autenticado', 'nombre' => $nombreUsuario]);
            } else {
                // Credenciales incorrectas
                echo json_encode(['mensaje' => 'Credenciales incorrectas']);
            }
        } catch (PDOException $e) {
            echo json_encode(['mensaje' => 'Error al iniciar sesión: ' . $e->getMessage()]);
        }
    }
}





?>