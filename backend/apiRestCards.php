<?php
include_once "ConsultasCards.php";
header('Content-Type: application/json');

$action = $_GET['action'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    switch ($action) {
        case 'registrarVehiculo':
            // Registrar un vehículo
            ModeloVehiculos::registrarVehiculo();
            break;
        case 'editarVehiculo':
            // Editar un vehículo
            ModeloVehiculos::editarVehiculo();
            break;
        default:
            echo json_encode(['mensaje' => 'Acción no válida']);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    switch ($action) {
        case 'obtenerVehiculos':
            ModeloVehiculos::obtenerVehiculos();
            break;
        case 'obtenerTiposVehiculos':
            ModeloVehiculos::obtenerTiposVehiculos();
            break;
        case 'obtenerAniosVehiculos':
            ModeloVehiculos::obtenerAniosVehiculos();
            break;
        case 'obtenerTransmisiones':
            ModeloVehiculos::obtenerTransmisiones();
            break;
        case 'obtenerCombustibles':
            ModeloVehiculos::obtenerCombustibles();
            break;
        default:
            echo json_encode(['mensaje' => 'Acción no válida']);
    }
}
