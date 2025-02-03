<?php
require_once('../database/configuracion.php');
// Obtener el nombre del laboratorio enviado desde el formulario
$tipoName = $_POST['tipo-name'];
$tipoName = ucwords(strtolower($tipoName));

// Verificar que el nombre del laboratorio no esté vacío
if (empty($tipoName)) {
    $response_array['status'] = 'error';
    $response_array['message'] = 'No puede estar vacío';
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
$sql = "SELECT * FROM item_type WHERE item_type_desc='$tipoName'";
$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) > 0){
    $response_array['status'] = 'error';
    $response_array['message'] = 'Ya existe';
} else {
    // Insertar el nuevo laboratorio en la base de datos
    $sql = "INSERT INTO item_type (item_type_desc) VALUES ('$tipoName')";
    if(mysqli_query($conn, $sql)){
        $response_array['status'] = 'success';
        $response_array['message'] = 'agregado correctamente';
    } else{
        $response_array['status'] = 'error';
        $response_array['message'] = 'Error al registrar el tipo: ' . mysqli_error($conn);
    }
}

// Cerrar la conexión a la base de datos
mysqli_close($conn);

// Devolver la respuesta como JSON
header('Content-type: application/json');
echo json_encode($response_array);
?>
