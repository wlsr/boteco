<?php
require_once('../class/Stock.php');
require_once('../class/Cart.php');

$stockList = $stock->all_stockList();
$cartDatas = $cart->all_cartDatas($_SESSION['logged_id']);

$total = 0;
?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-danger">
            <div class="card-header bg-danger text-white px-2 py-1">
                <h6 class="mb-0">
                    <i class="fa fa-shopping-cart me-2"></i> Ventas
                </h6>
            </div>
            <div class="card-body py-1">
                <!-- cart -->
                <div class="table">
                    <table id="myTable-cart" class="table table-sm">
                        <thead>
                            <tr class="table-danger" style="font-size: 13px">
                                <th class="text-center product-col">Producto</th>
                                <th class="text-center action-col">Precio</th>
                                <th class="text-center action-col">Cantidad</th>
                                <th class="text-center action-col">Descuento</th>
                                <th class="text-center action-col">Total</th>
                                <th class="text-center action-col">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $total = 0;
                            foreach ($cartDatas as $c):
                                $price = $c['item_price'];
                            ?>
                                <tr class="text-center table-body-light">
                                    <td style="font-size: 13px;"><?= ucwords($c['item_name']); ?></td>
                                    <td><?= "$ " . number_format($c['item_price'], 2); ?></td>
                                    <td>
                                        <input class="form-control form-control-sm text-center bg-warning text-dark" 
                                            style="width: 60px;" type="number" 
                                            id="<?= $c['cart_id']; ?>" name="cantidad[]" min="1" 
                                            value="<?= (isset($_SESSION['cantidad' . $c['cart_id']]) && $_SESSION['cantidad' . $c['cart_id']] !== '') ? $_SESSION['cantidad' . $c['cart_id']] : $c['cart_qty']; ?>" 
                                            data-price="<?= $price; ?>" onchange="actualizarCantidad(this, <?= $price; ?>);">
                                    </td>
                                    <?php 
                                    $qty = isset($_POST['cantidad'][$c['cart_id']]) ? $_POST['cantidad'][$c['cart_id']] : $c['cart_qty'];
                                    $qty = is_numeric($qty) ? $qty : 0;
                                    $subTotal = $price * $qty;
                                    $total += $subTotal;
                                    ?>
                                    <td>
                                        <input class="form-control form-control-sm text-center bg-danger text-light" 
                                            style="width: 60px;" type="number" 
                                            name="descuento[]" value="0" min="0" 
                                            oninput="applyDiscount(this, <?= $price; ?>);">
                                    </td>
                                    <td id="total<?= $c['cart_id']; ?>"></td>
                                    <td>
                                        <button onclick="performDelCart(this, '<?= $c['cart_stock_id']; ?>','<?= $qty; ?>','<?= $c['cart_id']; ?>');" 
                                            type="button" class="btn btn-danger btn-sm">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot py-0>
                            <tr class="table-danger">
                                <td colspan="3"></td>
                                <td class="text-end fw-bold">Total:</td>
                                <td class="text-center fw-bold text-success" id="totalAmount">
                                    <strong><?= number_format($total, 2); ?></strong>
                                </td>
                                <td class="text-center">
                                    <?php if($total > 0):?> 
                                        <button onclick="confirm_cart()" type="button" class="btn btn-success btn-sm">
                                            Confirmar 
                                            <i class="fa fa-shopping-cart ms-1"></i>
                                        </button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>



    <div class="col-md-12">
    </br>
        <div class="card shadow-sm">
            <!-- Encabezado de la tarjeta -->
            <div class="card-header text-white px-2 py-0" style ="background-color:#77BBCC !important;">
                <h6 class="mb-0">
                    <i class="fa fa-list me-2"></i> Lista de productos
                </h6>
            </div>
            <!-- Cuerpo de la tarjeta -->
            <div class="card-body py-1">
               
                <div class="table-responsive">
                    <table id="myTable-item-order" class="table table-sm table-hover align-middle">
                        <thead>
                            <tr class="table-header-light">
                                <th scope="col" class="text-center">Código</th>
                                <th scope="col" class="text-center">Producto</th>
                                <th scope="col" class="text-center">Tipo</th>
                                <th scope="col" class="text-center">Gr</th>
                                <th scope="col" class="text-center">Laboratorio</th>
                                <th scope="col" class="text-center">Precio</th>
                                <th scope="col" class="text-center">Stock</th>
                                <th scope="col" class="text-center"  style="width: 80px;">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($stockList as $s): ?>
                                <tr class="text-center table-body-dark <?= $s['stock_qty'] == 0 ? 'text-danger' : '' ?>">
                                    <td><?= ucwords($s['item_code']); ?></td>
                                    <td class="text-start"><?= ucwords($s['item_name']); ?></td>
                                    <td><?= ucwords($s['item_type_desc']); ?></td>
                                    <td><?= ucwords($s['item_grams']); ?></td>
                                    <td><?= ucwords($s['nombre_lab']); ?></td>
                                    <td style="color: <?= $s['stock_qty'] == 0 ? '' : '#283'; ?> !important;"><?= "$ " . number_format($s['item_price'], 2); ?></td>
                                    <td><?= $s['stock_qty']; ?></td>
                                    <td>
                                        <div class="d-flex align-items-center justify-content-center">
                                            <input 
                                                type="number" 
                                                min="1" 
                                                class="form-control text-center form-control-sm cart-qty <?= $s['stock_qty'] == 0 ? 'disabled bg-secondary' : ''; ?>" 
                                                value="1"
                                                id="cart-qty-<?= $s['stock_id']; ?>" 
                                                data-stock-id="<?= $s['stock_id']; ?>" 
                                                data-item-id="<?= $s['item_id']; ?>" 
                                                data-qty="<?= $s['stock_qty']; ?>"
                                                style="width: 80px;" 
                                                oninput="validateQty(this)" 
                                                <?= $s['stock_qty'] == 0 ? 'disabled' : ''; ?>>
                                            <button 
                                                class="btn btn-sm ms-2 add-to-cart-btn <?= $s['stock_qty'] == 0 ? 'btn-danger disabled' : 'btn-success'; ?>" 
                                                data-stock-id="<?= $s['stock_id']; ?>" 
                                                data-item-id="<?= $s['item_id']; ?>" 
                                                data-qty="<?= $s['stock_qty']; ?>">
                                                <i class="fa fa-fw fa-plus"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <div id="modal-container"></div>
                </div>
            </div>
        </div>
    </div>   
</div>

<script type="text/javascript">
    $(document).ready(function () {
    
        $('#myTable-item-order').DataTable({
            "lengthChange": false,
            "pageLength": 25,
            "ordering": false,
            language: {
                search: '<span class="fa fa-search custom-search" style="font-weight: bold;"> Buscar: </span>'
            },
        });
    });
</script>


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
	console.log('cantidad new:', cantidad);
}

// Función para actualizar el total
function updateTotal() {
	var totalAmountElement = document.getElementById('totalAmount');
	var subtotals = document.querySelectorAll('td[id^="total"]');
	var total = 0;

	for (var i = 0; i < subtotals.length-1; i++) {
		total += parseFloat(subtotals[i].textContent)|| 0;
	}

	totalAmountElement.innerHTML = '<strong>$' + total.toFixed(2) + '</strong>';
	//console.log('Total actualizado:', total.toFixed(2));
}

// Función para escuchar cambios en los campos de cantidad y almacenar en localStorage
function actualizarCantidad(input, price) {
	var cartId = input.id; // Obtener el cart_id del producto
	var cantidad = parseFloat(input.value) || 0;
	localStorage.setItem(cartId, cantidad); // Almacenar la cantidad en localStorage
	input.value = cantidad; // Actualizar el valor del input con la nueva cantidad
	applyCantidad(input, price); // Llamar a la función para actualizar el subtotal
}

// Función para aplicar la cantidad desde localStorage
function applyCantidad(input, price) {
	//console.log('Aplicando cantidad desde localStorage');
	var cartId = input.id; // Obtener el cart_id del producto
	var storedCantidad = localStorage.getItem(cartId); // Obtener la cantidad almacenada
	//console.log('Cantidad almacenada para el producto ' + cartId + ':', storedCantidad);
	var cantidad = storedCantidad ? parseFloat(storedCantidad) : parseFloat(input.value) || 0; // Usar la cantidad almacenada si existe
	//console.log('Cantidad final:', cantidad);
	var rowTotalElement = input.parentNode.nextElementSibling.nextElementSibling;
	var descuentoInput = input.parentNode.nextElementSibling.querySelector('input[name="descuento[]"]');

	var descuento = descuentoInput ? parseFloat(descuentoInput.value) || 0 : 0; // Verifica si el campo de descuento existe
	var rowTotal = (price * cantidad) - descuento;

	rowTotalElement.textContent = rowTotal.toFixed(2);
	updateTotal(); // Llama a la función para actualizar el total después de aplicar el descuento
	console.log('Se cambió la cantidad:', input.value);
	console.log('Descuento:', descuento);
}

// Aplicar cantidades desde localStorage al cargar la página
document.addEventListener('DOMContentLoaded', function() {
	var cantidadInputs = document.querySelectorAll('input[id^="cantidad"]');
	cantidadInputs.forEach(function(input) {
		var cartId = input.id;
		var storedCantidad = localStorage.getItem(cartId);
		if (storedCantidad !== null) {
			input.value = storedCantidad;
		}
		
		applyCantidad(input,$price);
	});
	
});
// Calcula el subtotal y actualiza el valor en el td correspondiente
function recalcularSubtotal() {
	var subtotals = document.querySelectorAll('td[id^="total"]');
	
	subtotals.forEach(function(subtotalElement) {
		var cartId = subtotalElement.id.replace('total', ''); // Obtén el ID del carrito
		var quantityInput = document.getElementById(cartId); // Busca el input de cantidad correspondiente
		
		if (quantityInput) {
			var price = parseFloat(quantityInput.getAttribute('data-price'));
			var quantity = parseFloat(quantityInput.value) || 0;
			var subtotal = price * quantity;

			// Actualiza el contenido del td con el nuevo subtotal
			subtotalElement.textContent = subtotal.toFixed(2);
		}
	});
	updateTotal();
}

// Llama a la función para recalcular el subtotal cuando se carga la página
window.addEventListener('load', function() {
	recalcularSubtotal();
});

 // Define una función para imprimir los datos de localStorage
 function imprimirDatosLocalStorage() {
	// Recupera todos los elementos almacenados en localStorage
	for (var i = 0; i < localStorage.length; i++) {
		var key = localStorage.key(i); // Obtiene la clave (key) del elemento en la posición i
		var value = localStorage.getItem(key); // Obtiene el valor asociado a esa clave
		//console.log("Clave: " + key + ", Valor: " + value); // Muestra la clave y el valor en la consola
		
		// Verifica si el elemento con la clave como ID existe en el DOM
		var element = document.getElementById(key);
		if (element) {
			element.value = value; // Establece el valor desde localStorage
		} else {
		   // console.log("Elemento con ID " + key + " no encontrado en el DOM.");
		}
	}
}

// Llama a la función para imprimir los datos cuando se carga la página
imprimirDatosLocalStorage();
recalcularSubtotal();
</script>
<script>
  $(document).ready(function() {
    // Cargar el modal desde el archivo externo
    $('#modal-container').load('modal/confirm_add.php');
  });
</script>









