<?php
include_once "Consultas.php";
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['accion'])) {
        switch ($_POST['accion']) {
            case 'registrarUsuario':
                Modelo::registrarUsuario();
                break;
            case 'loginUsuario':
                Modelo::loginUsuario();
                break;
        }
    } else {
        echo json_encode(['mensaje' => 'No se ha especificado ninguna acción']);
    }
} else {
    echo json_encode(['mensaje' => 'Método no permitido']);
}

?>