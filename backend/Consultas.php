<?php
include_once "conexion.php";
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




?>