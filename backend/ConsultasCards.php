<?php
include_once "conexion.php";

header('Content-Type: application/json'); 

class ModeloVehiculos {

    public static function obtenerVehiculos() {
        try {
            $objetoConexion = new Conexion();
            $con = $objetoConexion->conectar();
    
            $sql = "SELECT 
                v.matricula_vehiculo,
                v.titulo_vehiculo,
                v.imagen_vehiculo,
                v.año_vehiculo,
                v.color_vehiculo,
                v.combustible_vehiculo,
                v.pasajeros_vehiculo,
                v.transmision_vehiculo,
                v.precio_vehiculo,
                t.tipo_vehiculo,
                d.estado_disponibilidad,
                det.marca_vehiculo,
                det.modelo_vehiculo,
                det.caracteristicas
            FROM 
                vehiculos v
            JOIN 
                tipo_vehiculos t ON v.id_tipo_vehiculo = t.id_tipo_vehiculo
            JOIN 
                disponibilidad_vehiculo d ON v.id_disponibilidad_pertenece = d.id_disponibilidad_vehiculo
            JOIN 
                detalle_vehiculo det ON v.matricula_vehiculo = det.matricula_vehiculo";
    
            $stmt = $con->prepare($sql);
            $stmt->execute();
    
            $vehiculos = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($vehiculos);
        } catch (PDOException $e) {
            echo json_encode(['mensaje' => 'Error al obtener vehículos: ' . $e->getMessage()]);
        }
    }

    public static function obtenerTiposVehiculos() {
        $objetoConexion = new Conexion();
        $con = $objetoConexion->conectar();
        $sql = "SELECT DISTINCT tipo_vehiculo FROM tipo_vehiculos";
        $stmt = $con->prepare($sql);
        $stmt->execute();
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    // Similar para obtener los años de vehículos
    public static function obtenerAniosVehiculos() {
        $objetoConexion = new Conexion();
        $con = $objetoConexion->conectar();
        $sql = "SELECT DISTINCT año_vehiculo FROM vehiculos ORDER BY año_vehiculo DESC";
        $stmt = $con->prepare($sql);
        $stmt->execute();
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    // Similar para obtener transmisiones
    public static function obtenerTransmisiones() {
        $objetoConexion = new Conexion();
        $con = $objetoConexion->conectar();
        $sql = "SELECT DISTINCT transmision_vehiculo FROM vehiculos";
        $stmt = $con->prepare($sql);
        $stmt->execute();
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    // Similar para obtener combustibles
    public static function obtenerCombustibles() {
        $objetoConexion = new Conexion();
        $con = $objetoConexion->conectar();
        $sql = "SELECT DISTINCT combustible_vehiculo FROM vehiculos";
        $stmt = $con->prepare($sql);
        $stmt->execute();
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    public static function registrarVehiculo() {
        // Comprobar si la solicitud es de tipo POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                // Crear conexión a la base de datos
                $objetoConexion = new Conexion();
                $con = $objetoConexion->conectar();
                
                // Obtener los datos enviados en la solicitud
                $matriculaVehiculo = $_POST['matriculaVehiculo'];
                $tituloVehiculo = $_POST['tituloVehiculo'];
                $marcaVehiculo = $_POST['marcaVehiculo'];
                $modeloVehiculo = $_POST['modeloVehiculo'];
                $anioVehiculo = $_POST['anioVehiculo'];
                $colorVehiculo = $_POST['colorVehiculo'];
                $combustibleVehiculo = $_POST['combustibleVehiculo'];
                $pasajerosVehiculo = $_POST['pasajerosVehiculo'];
                $transmisionVehiculo = $_POST['transmisionVehiculo'];
                $precioVehiculo = $_POST['precioVehiculo'];
                $tipoVehiculo = $_POST['tipoVehiculo'];
                $caracteristicas = $_POST['caracteristicas'];
    
                // Validación: Verificar si el id_tipo_vehiculo existe en la tabla tipo_vehiculos
                $sqlVerificarTipo = "SELECT COUNT(*) FROM tipo_vehiculos WHERE id_tipo_vehiculo = :tipo";
                $stmtVerificarTipo = $con->prepare($sqlVerificarTipo);
                $stmtVerificarTipo->bindParam(':tipo', $tipoVehiculo);
                $stmtVerificarTipo->execute();
                $existeTipo = $stmtVerificarTipo->fetchColumn();
    
                if ($existeTipo == 0) {
                    // Si el tipo de vehículo no existe, devolver un mensaje de error
                    echo json_encode(['mensaje' => 'El tipo de vehículo no existe']);
                    return; // Salir de la función para evitar el registro
                }
    
                // Comprobar si la imagen fue subida correctamente
                if (isset($_FILES['imagen_vehiculo']) && $_FILES['imagen_vehiculo']['error'] == 0) {
                    // Obtener la extensión de la imagen
                    $imageFileType = strtolower(pathinfo($_FILES['imagen_vehiculo']['name'], PATHINFO_EXTENSION));
    
                    // Verificar si la extensión es una de las permitidas
                    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'jfif'];
                    if (!in_array($imageFileType, $allowedExtensions)) {
                        echo json_encode(['mensaje' => 'Formato de imagen no permitido.']);
                        return;
                    }
    
                    // Generar un nombre único para la imagen
                    $imageName = uniqid('vehiculo_') . '.' . $imageFileType;
    
                    // Definir la carpeta de destino donde se guardarán las imágenes
                    $targetDirectory = "../fotosVehiculos/";
    
                    // Mover el archivo de imagen a la carpeta de destino
                    $targetFile = $targetDirectory . $imageName;
                    move_uploaded_file($_FILES['imagen_vehiculo']['tmp_name'], $targetFile);
    
                    // Solo se guarda el nombre de la imagen (y no su contenido)
                    $imagenVehiculo = $imageName;
                } else {
                    // Si no se sube una imagen, manejarlo según lo necesites
                    throw new Exception('Error al subir la imagen.');
                }
    
                // Iniciar la transacción para asegurar que ambas inserciones se hagan correctamente
                $con->beginTransaction();
    
                // Insertar el vehículo en la tabla 'vehiculos'
                $sqlVehiculo = "INSERT INTO vehiculos (
                    matricula_vehiculo,  
                    titulo_vehiculo, 
                    imagen_vehiculo, 
                    año_vehiculo, 
                    color_vehiculo, 
                    combustible_vehiculo, 
                    pasajeros_vehiculo, 
                    transmision_vehiculo, 
                    precio_vehiculo, 
                    id_tipo_vehiculo, 
                    id_disponibilidad_pertenece
                ) VALUES (
                    :matricula, 
                    :titulo, 
                    :imagen, 
                    :anio, 
                    :color, 
                    :combustible, 
                    :pasajeros, 
                    :transmision, 
                    :precio, 
                    :tipo,  
                    1  
                )";
                
                $stmtVehiculo = $con->prepare($sqlVehiculo);
                $stmtVehiculo->bindParam(':matricula', $matriculaVehiculo);  
                $stmtVehiculo->bindParam(':titulo', $tituloVehiculo);
                $stmtVehiculo->bindParam(':imagen', $imagenVehiculo); 
                $stmtVehiculo->bindParam(':anio', $anioVehiculo);
                $stmtVehiculo->bindParam(':color', $colorVehiculo);
                $stmtVehiculo->bindParam(':combustible', $combustibleVehiculo);
                $stmtVehiculo->bindParam(':pasajeros', $pasajerosVehiculo);
                $stmtVehiculo->bindParam(':transmision', $transmisionVehiculo);
                $stmtVehiculo->bindParam(':precio', $precioVehiculo);
                $stmtVehiculo->bindParam(':tipo', $tipoVehiculo);
    
                $stmtVehiculo->execute();
    
                // Insertar los detalles del vehículo en la tabla 'detalle_vehiculo'
                $sqlDetalle = "INSERT INTO detalle_vehiculo (matricula_vehiculo, marca_vehiculo, modelo_vehiculo, caracteristicas) 
                               VALUES (:matricula, :marca, :modelo, :caracteristicas)";
                
                $stmtDetalle = $con->prepare($sqlDetalle);
                $stmtDetalle->bindParam(':matricula', $matriculaVehiculo);  
                $stmtDetalle->bindParam(':marca', $marcaVehiculo);
                $stmtDetalle->bindParam(':modelo', $modeloVehiculo);
                $stmtDetalle->bindParam(':caracteristicas', $caracteristicas);
                $stmtDetalle->execute();
    
                // Confirmar la transacción
                $con->commit();
    
                // Responder con éxito
                echo json_encode(['mensaje' => 'Vehículo registrado exitosamente']);
            } catch (PDOException $e) {
                // En caso de error, hacer rollback de la transacción
                $con->rollBack();
                echo json_encode(['mensaje' => 'Error al registrar vehículo: ' . $e->getMessage()]);
            } catch (Exception $e) {
                // Manejar otros errores
                echo json_encode(['mensaje' => $e->getMessage()]);
            }
        } else {
            echo json_encode(['mensaje' => 'Método HTTP no permitido.']);
        }
    }
}
?>