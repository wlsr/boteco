<?php
require_once('../class/Stock.php');
require_once('../class/Cart.php');

$stockList = $stock->all_stockList();
$cartDatas = $cart->all_cartDatas($_SESSION['logged_id']);

$total = 0;

?>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-red" >
            <div class="panel-heading" >
                <h4 class="panel-title">
                    <span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span> Ventas
                </h4>
            </div>
        <div class="panel-body" >
                <!-- cart -->
<div class="table-responsive">
    <table id="myTable-cart" class="table table-bordered table-hover table-striped" >
        <thead>
            <tr class="first-row">
                <th><center>Nombre</center></th>
                <th><center>Precio</center></th>
                <th><center>Cantidad</center></th>
                <th><center>Descuento</center></th>
                <th><center>Total</center></th>
                <th><center>Acción</center></th>
            </tr>
        </thead>
        <tbody>
        <?php
        $total = 0;
        foreach ($cartDatas as $c):
            $price = $c['item_price'];
            $qty = $c['cart_qty'];
            $subTotal = $price * $qty;
            $total += $subTotal;
        ?>
            <tr align="center">
                <td><?= ucwords($c['item_name']); ?></td>
                <td><?= "$ ".number_format($c['item_price'], 2); ?></td>
               
                <td>
                <input class="centro" style="width: 60px; padding: 2px; color: green; background-color: #E7E550;" type="number" id="<?= $c['cart_id']; ?>" name="cantidad[]" min="1" value="<?= (isset($_SESSION['cantidad_' . $c['cart_id']]) && $_SESSION['cantidad_' . $c['cart_id']] !== '') ? $_SESSION['cantidad_' . $c['cart_id']] : $c['cart_qty']; ?>" onchange="applyCantidad(this, <?= $price; ?>);">


                </td>

                <td>
                     <input class="centro" style="width: 60px; padding: 2px; color: red; background-color: #E7E550;" type="number" name="descuento[]" value="0" min="0" oninput="applyDiscount(this, <?= $price; ?>); updateTotal();">

            
                </td>
                <td id="total<?= $c['cart_id']; ?>"><?= number_format($subTotal,2); ?></td>
                <td>
                    <button onclick="performDelCart(this, '<?= $c['cart_stock_id']; ?>','<?= $qty; ?>','<?= $c['cart_id']; ?>');" type="button" class="btn btn-danger btn-xs"> Eliminar
        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>

                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
        <tr>
            <td></td>
            <td></td>
	    <td></td>
            <td align="right"><strong>Total:</strong></td>
            <td align="center" id="totalAmount">
                <strong><?= number_format($total, 2); ?></strong>
            </td>
            <td align="center">
                <?php if($total > 0):?> 
                    <button onclick="confirm_cart()" type="button" class="btn btn-success btn-xs">
                    Confirmar 
                    <span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span>
                    </button>
                <?php endif; ?>
            </td>
        </tr>
    </table>
</div>

<script>
    // Función para aplicar descuento
    function applyDiscount(input, price) {
        var discount = parseFloat(input.value) || 0;
        var rowTotalElement = input.parentNode.nextElementSibling;
        var cantidad = input.parentNode.previousElementSibling.querySelector('input').value;
        var rowTotal = (price * cantidad) - discount;
        rowTotalElement.textContent = rowTotal.toFixed(2);
        updateTotal(); // Llama a la función para actualizar el total después de aplicar el descuento
        console.log('Se cambió el descuento:', input.value);
        console.log('cantidad new:', cantidad)
    }

    // Función para actualizar el total
    function updateTotal() {
        var totalAmountElement = document.getElementById('totalAmount');
        var subtotals = document.querySelectorAll('td[id^="total"]');
        var total = 0;

        for (var i = 0; i < subtotals.length; i++) {
            total += parseFloat(subtotals[i].textContent) || 0;
        }

        totalAmountElement.innerHTML = '<strong>$' + total.toFixed(2) + '</strong>';
        console.log('Total actualizado:', total.toFixed(2));
    }

     // Función para escuchar cambios en los campos de cantidad
    // Función para escuchar cambios en los campos de cantidad
    function applyCantidad(input, price) {
    var cantidad = parseFloat(input.value) || 0;
    var rowTotalElement = input.parentNode.nextElementSibling.nextElementSibling;
    var descuentoInput = input.parentNode.nextElementSibling.querySelector('input[name="descuento[]"]');

    var descuento = descuentoInput ? parseFloat(descuentoInput.value) || 0 : 0; // Verifica si el campo de descuento existe
    var rowTotal = (price * cantidad) - descuento;

    rowTotalElement.textContent = rowTotal.toFixed(2);
    updateTotal(); // Llama a la función para actualizar el total después de aplicar el descuento
    console.log('Se cambió la cantidad:', input.value);
    console.log('Descuento:', descuento)
}
</script>


<script type="text/javascript">
    
    $(document).ready(function() {
        $('#myTable-item-order').DataTable({
            "pageLength": 50,
            "scrollY": "500px",
            "dom": '<"custom-table-header"f>t<"custom-table-footer"ip>',
            "createdRow": function( row, data, dataIndex ) {
                // Aplica estilos a cada fila
                $(row).find('td').css({
                    "padding": "3px",
                    "height": "20px"
                    // Agrega otros estilos que desees
                });
            },
            language: {
                search: '<span class="glyphicon glyphicon-search custom-search" style="font-weight: bold;"> Buscar: </span>'
            }
        });
    });
</script>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="panel panel-yellow">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <span class="glyphicon glyphicon-list" aria-hidden="true"></span> Lista de
                    Productos
                </h3>
            </div>
            <div class="panel-body">
                <!-- start item -->
                <div class="table-responsive">
                    <table id="myTable-item-order" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr class="first-row">
                                <th><center>Código</center></th>
                                <th><center>Nombre</center></th>
                                <th><center>Tipo</center></th>
                                <th><center>Gr</center></th>
                                <th><center>Laboratorio</center></th>
                                <th><center>Precio</center></th>
                                <th><center>Stock</center></th>
                                <th><center></center></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($stockList as $s): ?>
                                <tr align="center">
                                    <td><?= ucwords($s['item_code']); ?></td>
                                    <td><?= ucwords($s['item_name']); ?></td>
                                    <td><?= ucwords($s['item_type_desc']); ?></td>
                                    <td><?= ucwords($s['item_grams']); ?></td>
                                    <td><?= ucwords($s['nombre_lab']); ?></td>
                                    <td><?= "$ ".number_format($s['item_price'], 2); ?></td>
                                    <td><?= $s['stock_qty']; ?></td>
                                    <td>
                                        <button onclick="toCart('<?= $s['stock_id']; ?>','<?= $s['stock_qty']; ?>','<?= $s['item_id']; ?>');" type="button" class="btn btn-success btn-xs">
                                            <span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <!-- end item -->
            </div>
        </div>
    </div>
</div>
<script>
    // Define una función para imprimir los datos de localStorage
    function imprimirDatosLocalStorage() {
        // Recupera todos los elementos almacenados en localStorage
        for (var i = 0; i < localStorage.length; i++) {
            var key = localStorage.key(i); // Obtiene la clave (key) del elemento en la posición i
            var value = localStorage.getItem(key); // Obtiene el valor asociado a esa clave
            console.log("Clave: " + key + ", Valor: " + value); // Muestra la clave y el valor en la consola
            
            // Verifica si el elemento con la clave como ID existe en el DOM
            var element = document.getElementById(key);
            if (element) {
                element.value = value; // Establece el valor desde localStorage
            } else {
                console.log("Elemento con ID " + key + " no encontrado en el DOM.");
            }
        }
    }

    // Llama a la función para imprimir los datos cuando se carga la página
    imprimirDatosLocalStorage();

    // Dispara un evento personalizado cuando se haya cargado order.php
    var orderLoadedEvent = new Event('orderLoaded');
    document.dispatchEvent(orderLoadedEvent);
</script>

