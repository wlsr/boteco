<?php
require_once('../database/configuracion.php');
// Obtener el nombre del laboratorio enviado desde el formulario
$labName = $_POST['lab-name'];

// Verificar que el nombre del laboratorio no esté vacío
if (empty($labName)) {
    $response_array['status'] = 'error';
    $response_array['message'] = 'El nombre del laboratorio no puede estar vacío';
    header('Content-type: application/json');
    echo json_encode($response_array);
    exit();
}

// Conectar a la base de datos
$servername = "localhost";
$username = "root";
$password = $BD_pass;
$dbname = $BD_name;

$conn = mysqli_connect($servername, $username, $password, $dbname);

// Verificar la conexión
if (!$conn) {
    die("La conexión falló: " . mysqli_connect_error());
}

// Verificar si el laboratorio ya existe en la base de datos
$stmt = $conn->prepare("SELECT * FROM laboratorio WHERE nombre_lab = ?");
$stmt->bind_param("s", $labName);
$stmt->execute();
$result = $stmt->get_result();

if(mysqli_num_rows($result) > 0){
    $response_array['status'] = 'error';
    $response_array['message'] = 'El laboratorio ya existe';
} else {
    // Insertar el nuevo laboratorio en la base de datos
    $stmt = $conn->prepare("INSERT INTO laboratorio (nombre_lab) VALUES (?)");
    $stmt->bind_param("s", $labName);
    if ($stmt->execute()) {
        $response_array['status'] = 'success';
        $response_array['message'] = 'El laboratorio se ha agregado correctamente';
    } else {
        $response_array['status'] = 'error';
        $response_array['message'] = 'Error al registrar el laboratorio: ' . $stmt->error;
    }
}

// Cerrar la conexión a la base de datos
mysqli_close($conn);

// Devolver la respuesta como JSON
header('Content-type: application/json');
echo json_encode($response_array);
?>
