<?php 
require_once('../class/Stock.php');
require_once('../database/Connection.php');
require_once('../database/configuracion.php');

if(isset($_POST['purc'])) {
    $item_id  = $_POST['item_id'];
    $stock_qty = $_POST['qty'];
    
    // Obtener el valor de $stock_id de la base de datos
    
    $mysqli = new mysqli('localhost', 'root', $BD_pass, $BD_name);
    $query = "SELECT stock_id FROM stock WHERE item_id = '$item_id'";
    $result = $mysqli->query($query);
    if (!$result) {
        die('Error en la consulta: ' . $mysqli->error);
    }
    $row = $result->fetch_assoc();
    if ($row) {
        $stock_id = $row['stock_id'];
    } else {
        // Maneja el caso cuando no se encuentra ninguna fila
        echo "No se encontró el stock";
    }
    
    // Crear una nueva instancia de la clase Stock y llamar a la función updateInventario con los parámetros correspondientes
    $stock = new Stock();
    
    $saveStock = $stock->updateInventario($stock_id, $item_id, $stock_qty);
    
echo $item_id . ' ' . $stock_qty;
}//end isset
