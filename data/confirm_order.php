<?php
require_once('../class/Cart.php');
require_once('../class/Sales.php');
require_once('../class/Stock.php');

if(isset($_POST['click'])){
    if($_POST['click'] == 'yes'){
        $cartDetails = $cart->allCart();
        $cantidads = $_POST['cantidad'];
        $descuentos = $_POST['descuento']; // Obtener los descuentos ingresados
        $updateSuccessful = 0; // Variable para rastrear si todas las actualizaciones fueron exitosas
        
        foreach ($cartDetails as $key => $cd) {
            $code = $cd['item_code'];
            $generic = $cd['item_name'];
            $brand = $cd['lab_id'];
            $gram = $cd['item_grams'];
            $type = $cd['item_type_desc'];
            $cartQty = $cd['cart_qty'];
            $price = $cd['item_price'];
           

            // Obtener el descuento correspondiente al elemento del carrito
            $descuento = isset($descuentos[$key]) ? $descuentos[$key] : 0;
            $cantidad = isset($cantidads[$key]) ? $cantidads[$key] : 0;

            // Obtener el stock total del artículo actual
            $stock_total = $stock->get_stock($code);
            $current_stock = $stock_total['stock_qty']; // Obtener el stock actual del artículo
            
            // Calcular el nuevo stock
            $new_stock = $current_stock - $cantidad;
            
            if($new_stock >= 0){
                if($cantidad > 0){
                    $insertSale = $sales->new_sales($code, $generic, $brand, $gram, $type,$cantidad, $price, $descuento);
                    $updateStock = $stock->update_stockQty2($code, $new_stock, $cantidad);
                } else{
                    $updateSuccessful = 1;
                    break;
                }
            } else {
                // Si el nuevo stock es menor que cero, establecer la variable $updateSuccessful en falso
                $updateSuccessful = 2;
                //$return['alert'] = 'Error: Stock insuficiente para completar la transacción.';
                break; // Salir del bucle foreach
            }
        }
        

        // Eliminar todos los artículos del carrito solo si todas las actualizaciones fueron exitosas
        if ($updateSuccessful == 0) {
            $delAllCart = $cart->dellAllCart();
        }
        
        try {
            // Preparar la respuesta JSON
            $return['valid'] = $updateSuccessful; // Utilizar la variable $updateSuccessful para determinar si la transacción fue exitosa
            if($updateSuccessful == 0){
                $return['msg'] = 'Transacción Exitosa!';
                
            } elseif($updateSuccessful == 1){
                $return['msg'] = '..<(-.-)>.. NO!';
            } 
            else {
              
                $return['msg'] = 'Stock insuficiente : <span class="item-name" style="color:black">'.htmlspecialchars($generic).' :<strong> ' .htmlspecialchars($current_stock) .'</strong> en stock</span>'; // Mensaje de alerta

            }
            
            // Devolver la respuesta JSON
            header('Content-Type: application/json');
            echo json_encode($return);
        } catch (Exception $e) {
            // Si ocurre un error, envía una respuesta de error válida JSON
            $errorResponse = array('error' => true, 'message' => 'Ocurrió un error en el servidor.');
            header('Content-Type: application/json');
            echo json_encode($errorResponse);
        }
    }
}
?>
