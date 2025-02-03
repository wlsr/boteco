<?php
require_once('../class/Sales.php');
date_default_timezone_set('America/La_Paz');
// Función para validar la fecha
function isValidDate($date) {
    $dateObj = DateTime::createFromFormat('Y-m-d', $date);
    return $dateObj && $dateObj->format('Y-m-d') === $date;
}

$response = [];
$today = date('Y-m-d'); // Fecha de hoy
$user_id = isset($_GET['user_id']) ? $_GET['user_id'] : null; // ID del usuario actual
$salesType = isset($_GET['salesType']) ? $_GET['salesType'] : 'user'; // Tipo de ventas (usuario o total)

// Verificar si el usuario está autenticado
if (!$user_id) {
    echo json_encode(['error' => 'Usuario no autorizado']);
    exit;
}

// Validar y manejar las solicitudes
if (isset($_GET['date']) && !empty($_GET['date'])) {
    // Si se proporciona una fecha específica
    $date = $_GET['date'];

    if (isValidDate($date)) {
        // Si se solicita ver todas las ventas
        if ($salesType == 'all_sales') {
            // Obtener ventas de todos los usuarios para la fecha específica
            $response = $sales->daily_salesAll($date);
        } else {
            // Obtener ventas de un solo usuario para la fecha específica
            $response = $sales->daily_sales($date, $user_id);
        }
    } else {
        echo json_encode(['error' => 'Fecha inválida. El formato debe ser Y-m-d.']);
        exit;
    }
} elseif (isset($_GET['startDate']) && isset($_GET['endDate']) && !empty($_GET['startDate']) && !empty($_GET['endDate'])) {
    // Si se proporciona un rango de fechas
    $startDate = $_GET['startDate'];
    $endDate = $_GET['endDate'];

    if (isValidDate($startDate) && isValidDate($endDate)) {
        // Si se solicita ver todas las ventas en el rango de fechas
        if ($salesType == 'all_sales') {
            // Obtener ventas de todos los usuarios en el rango de fechas
            $response = $sales->range_salesAll($startDate, $endDate);
        } else {
            // Obtener ventas de un solo usuario en el rango de fechas
            $response = $sales->range_sales($startDate, $endDate, $user_id);
        }
    } else {
        echo json_encode(['error' => 'Una o ambas fechas son inválidas. El formato debe ser Y-m-d.']);
        exit;
    }
} else {
    // Por defecto, cargar ventas del día para un solo usuario
    $response = $sales->daily_sales($today, $user_id);
}

header('Content-Type: application/json');
echo json_encode($response);

$sales->Disconnect();
?>

