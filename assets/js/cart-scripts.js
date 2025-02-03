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