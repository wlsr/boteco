
function eMsg(params){
	//alert("Error: L"+params+"+");
}//end eMsg

//login
$(document).on('submit', '#form-login', function(event){
	event.preventDefault();
	/* Act on the event */
	var un = $('#un').val();
	var up = $('#up').val();

	$.ajax({
			url: 'data/login_user.php',
			type: 'post',
			dataType: 'json',
			data: {
				un:un,
				up:up
			},
			success: function (data) {
				console.log(data);
				if(data.logged == true){
					window.location = data.url;
				}else{
					alert(data.msg);
					$('#un').focus();
				}
			},
			error: function(){
				alert('Error: L17');
			}
		});
});

//all item
function showAllItem()
{
	$.ajax({
			url: 'data/all_item.php',
			success: function (data) {
				$('#all-item').html(data);
			},
			error: function(){
				alert('Error: L42+');
			}
		});
}//end showAllItem
showAllItem();

$('#add-new-item').click(function(event) {
	/* Act on the event */
	$('#modal-item').find('.modal-title').text('Agregar producto');
	$('#modal-item').modal('show');
	$('#submit-item').val('add');
});

$(document).on('submit', '#form-item', function(event) {
	event.preventDefault();
	/* Act on the event */
	var iName = $('#item-name').val();
	var iPrice = $('#item-price').val();
	var iType = $('#item-type').val();
	var code = $('#code').val();
	var brand = $('#brand').val();
	var grams = $('#grams').val();
    if($('#submit-item').val() == "add"){
    	// console.log('add ra');
	    $.ajax({
	    		url: 'data/add_item.php',
	    		type: 'post',
	    		dataType: 'json',
	    		data: {
	    			iName:iName,
	    			iPrice:iPrice,
	    			iType:iType,
	    			code:code,
	    			brand:brand,
	    			grams:grams
	    		},
	    		success: function (data) {
	    			alert(data.msg);
	    			if(data.valid == true){
	    				$('#modal-message').find('#msg-body').text(data.msg);
	    				$('#modal-item').modal('hide');
	    				showAllItem();
	    				
	    				$('#submit-item').val('null');
	    				$('#form-item')[0].reset();
	    			}
	    		},
	    		error: function(){
	    			console.log('nombre: '+iName);
	    			console.log('Precio: '+iPrice);
	    			console.log('Tipo: ' + iType);
	    			console.log('codigo:' +code);
	    			console.log('id_laboratorio' + brand);
	    			console.log('Gramos: '+grams);
	    			eMsg('70');
	    		}//
	    	});
    }//end if == "add"
});


function editModal(item_id){
	// $('#submit-item').val('add');
	$.ajax({
			url: 'data/get_item.php',
			type: 'post',
			dataType: 'json',
			data: {
				item_id:item_id
			},
			success: function (data) {
				$('#submit-item').val(data.event);
				$('#item-name').val(data.name);
				$('#item-price').val(data.price);
				$('#item-id').val(data.id);
				$('#code').val(data.code);
				$('#brand').val(data.brand);
				$('#grams').val(data.grams);
				$('#item-type').val(data.type);
				$('#modal-item').find('.modal-title').text("Editar producto");
				$('#modal-item').modal('show');
			},
			error: function(){
				alert('Error: L56+');
			}
		});
}//end editModal

//save edit modal
$(document).on('submit', '#form-item', function(event) {
	event.preventDefault();
	/* Act on the event */
	var submit = $('#submit-item').val();
	var item_id = $('#item-id').val();

	var iName = $('#item-name').val();
	var iPrice = $('#item-price').val();
	var iType = $('#item-type').val();
	var code = $('#code').val();
	var brand = $('#brand').val();
	var grams = $('#grams').val();

	if(submit  == "edit"){
		$.ajax({
				url: 'data/edit_item.php',
				type: 'post',
				dataType: 'json',
				data: {
					item_id:item_id,
					iName:iName,
	    			iPrice:iPrice,
	    			iType:iType,
	    			code:code,
	    			brand:brand,
	    			grams:grams
				},
				success: function (data) {
					// console.log(data);
					if(data.valid == true){
						$('#modal-message').find('#msg-body').text(data.msg);
						$('#modal-item').modal('hide');
						showAllItem();
						$('#modal-message').modal('show');
					}
				},
				error: function(){
					eMsg('127');
					console.log(brand);
				}
			});
	}//end submit
});

function showAllStockList(){
	$.ajax({
			url: 'data/all_stocklist.php',
			type: 'post',
			success: function (data) {
				$('#all-stocklist').html(data);
			},
			error: function(){
				eMsg('152');
			}
		});
}//end showAllStockList
showAllStockList();


// $('#del-stock').on('click', '.selector', function(event) {
// 	event.preventDefault();
// 	/* Act on the event */
// 	// $('input[type=checkbox]:checked').each(function(index) {
//  //        //where the magic begins wahaha. ge ahak.
//  // 		console.log($(this).val())
//  //    });
//  	console.log('sad');
// });
$('#del-stock').click(function(event) {
	/* Act on the event */
	var check = 0;
	 $('input[type=checkbox]:checked').each(function(index) {
		check++;        
    });
	 if(check == 0){
	 	alert('Please Select Row!');
	 }else{
	 	$('#confirm-type').val('expired');
		$('#modal-confirmation').modal('show');
	}//end if check == 0
});

$('.del-expired').click(function(event) {
	/* Act on the event */
	if($('#confirm-type').val() == "expired"){
			var finish = false;
		$('input[type=checkbox]:checked').each(function(index) {
			// console.log($(this).val());
			finish = true;
			var stock_id = $(this).val();
			$.ajax({
					url: 'data/del_expired.php',
					type: 'post',
					dataType: 'json',
					data: {
						stock_id:stock_id
					},
					success: function (data) {
						showAllStockList();
					},
					error: function(){
						eMsg('195');
					}
				});
	    });
		if(finish == true){
			$('#modal-confirmation').modal('hide');
			$('#modal-message').find('#msg-body').text('Eliminado correctamente!')
			$('#modal-message').modal('show');
			$(this).off('click');
		}//end finish
		
	}//end if
});

$('#add-stock').click(function(event) {
	/* Act on the event */
	$('#modal-stock').find('.modal-title').text('Nuevo stock');
	$('#modal-message').find('#msg-body').text('correctamente!')
	$('#modal-stock').modal('show');
});

//prueba
$(document).on('click', '.btn-add-stock', function(event) {
  event.preventDefault();
  var $row = $(this).closest('tr');
  var item_id = $row.data('id');
  var stock_id= $row.data('stock_id');
  var qty = $row.find('#qty').val();
  var stock_id = $row.find('td:nth-child(1) input[type="checkbox"]').val();
  var xDate = $('#xDate').val();
  var manu = $('#manu').val();
  var purc = $('#purc').val();
  $.ajax({
    url: 'data/add_fuck.php',
    type: 'post',
    data: {
      item_id: item_id,
      qty: qty,
      xDate: xDate,
      manu: manu,
      purc: purc
    },
    success: function (data) {
      //console.log(data);
      console.log('item:'+item_id,'cantidad:'+ qty);
      $('#modal-stock').modal('hide');
      showAllStockList();
      $('#modal-message').find('#msg-body').text(data.msg);
      $('#modal-message').modal('show');
    },
    error: function() {
      eMsg('233');
    }
  });
});


//form stock
var fuck = 0;
$(document).on('submit', '#form-stock', function(event) {
  event.preventDefault();

  var item_ids = [];
  var qtys = [];
  $('.stock-row').each(function() {
    var item_id = $(this).find('input[name="item_id[]"]').val();
    var qty = $(this).find('.qty-input').val();
    item_ids.push(item_id);
    qtys.push(qty);
  });

  var xDate = $('#xDate').val();
  var manu = $('#manu').val();
  var purc = $('#purc').val();

  $.ajax({
    url: 'data/add_fuck.php',
    type: 'post',
    data: {
      item_ids: item_ids,
      qtys: qtys,
      xDate: xDate,
      manu: manu,
      purc: purc
    },
    success: function (data) {
      console.log(data);
      console.log(item_id, qty);
      $('#modal-stock').modal('hide');
      showAllStockList();
      $('#modal-message').find('#msg-body').text(data.msg);
      $('#modal-message').modal('show');
    },
    error: function(){
      eMsg('233');
    }
  });
});


//all expired
function showAllExpired(){
	$.ajax({
			url: 'data/all_expired.php',
			type: 'post',
			// data: {},
			success: function (data) {
				$('#all-expired').html(data);
			},
			error: function(){
				eMsg('260');
			}
		});
}//end showAllExpired
showAllExpired();

//all stock
function showAllStocks(){
	$.ajax({
			url: 'data/all_stock.php',
			type: 'post',
			success: function (data) {
				$('#all-stock').html(data);
			},
			error: function(){
				eMsg('275');
			}
		});
}//end showAllStocks
showAllStocks();

//all history
function showAllHistory(){
	$.ajax({
			url: 'data/all_history.php',
			type: 'post',
			success: function (data) {
				$('#all-history').html(data);
			},
			error: function(){
				eMsg('275');
			}
		});
}//end showAllHistory
showAllHistory();

//stock report print
$('#stock-report').click(function(event) {
	/* Act on the event */
	// window.open('print.php?datePick=<?php echo $datePick; ?>','name','width=auto,height=auto');
	window.open('data/print.php','name','width=auto,height=auto');
});

//ventas report print
$(document).ready(function() {
    $('#ventas-report').click(function() {
        var contenidoDiv = document.getElementById('imprimir');
        var ventanaImpresion = window.open('', '', 'width=600,height=600');
        ventanaImpresion.document.write('<html><head><title>REPORTE</title></head><body>');
        ventanaImpresion.document.write(contenidoDiv.innerHTML);
        ventanaImpresion.document.write('</body></html>');
        ventanaImpresion.document.close();
        ventanaImpresion.print();
        ventanaImpresion.close();
    });
});


function showOrder(){
	$.ajax({
			url: 'data/order.php',
			type: 'post',
			success: function (data) {
				$('#order').html(data);
			},
			error: function(){
				eMsg('297');
			}
		});
}//end showOrder
showOrder();
//stock 0


//add to cart
function toCart(stock_id, qty, item_id){
	$('#stock-id').val(stock_id);
	$('#item-id').val(item_id);
	$('#item-qty').val(qty);
	//$('#modal-to-cart').modal('show');
}//end toCart

//input_cant_add
var formToCartExecuting = false; // Variable de control

// Evento cuando el usuario hace clic en el botón de agregar al carrito
$(document).on('click', '.add-to-cart-btn', function(event) {
    event.preventDefault();

    // Restablecer la variable de control si el modal se cerró previamente
    if (formToCartExecuting) {
        formToCartExecuting = false;  // Si ya está ejecutándose, reiniciamos el estado.
    }

    if (!formToCartExecuting) {
        formToCartExecuting = true; // Evita múltiples ejecuciones simultáneas

        var stock_id = $(this).data('stock-id');
        var item_id = $(this).data('item-id');
        var qty = $(this).data('qty');
        var cartQty = $('#cart-qty-' + stock_id).val();
        var newStockQty = qty - cartQty;

        $('#confirmAddToCart').data('stock-id', stock_id);
        $('#confirmAddToCart').data('item-id', item_id);
        $('#confirmAddToCart').data('qty', cartQty);
        $('#confirmAddToCart').data('new-stock-qty', newStockQty);
		$('#confirmModal').modal({
			backdrop: false,  // Deshabilita el oscurecimiento
			keyboard: true    // Permite cerrar con el teclado si lo deseas
		});
		if ($('#confirmModal').length) {
			$('#confirmModal').modal({
				backdrop: false,  // Deshabilita el oscurecimiento
				keyboard: true    // Permite cerrar con el teclado si lo deseas
			}).modal('show'); // Configura y muestra el modal
		} else {
            alert("El modal no se ha cargado correctamente.");
        }
    }
});

// Delegación del evento 'click' para el botón de confirmación
$(document).on('click', '#confirmAddToCart', function() {
    var stock_id = $(this).data('stock-id');
    var item_id = $(this).data('item-id');
    var cartQty = $(this).data('qty');
    var newStockQty = $(this).data('new-stock-qty');

    if (newStockQty < 0) {
        alert('Stock Insuficiente');
    } else {
        $.ajax({
            url: 'data/add_cart.php',
            type: 'post',
            data: {
                stock_id: stock_id,
                item_id: item_id,
                cqty: cartQty,
                nqty: newStockQty
            },
            success: function(data) {
                showOrder();
                //alert('Producto agregado al carrito');
            },
            error: function() {
                alert('Error al agregar al carrito');
            }
        });
    }

    // Cerrar el modal y restablecer el estado de la variable de control
    $('#confirmModal').modal('hide');
    formToCartExecuting = false;
});

// Restablecer los datos del modal cuando se cierra (por cancelación o cualquier otro cierre)
$('#confirmModal').on('hidden.bs.modal', function () {
    $('#confirmAddToCart').removeData('stock-id item-id qty new-stock-qty');
    formToCartExecuting = false; // Asegura que siempre se resetee
});

// Restablecer manualmente la variable de control en el botón "Cancelar" del modal
$(document).on('click', '#cancelAddToCart', function() {
    // Solo cerrar el modal y restablecer el estado
    $('#confirmModal').modal('hide');
    formToCartExecuting = false; // Asegura resetear la variable
});





//del from cart
var delCartExecuting = false;

function performDelCart(button, stock_id, qty, cart_id) {
    if (!delCartExecuting) {
        delCartExecuting = true;

        // Deshabilita temporalmente el botón
        $(button).prop('disabled', true);

        delCart(stock_id, qty, cart_id);
    }
}

function delCart(stock_id, qty, cart_id) {
    $.ajax({
        url: 'data/del_cart.php',
        type: 'post',
        data: {
            stock_id: stock_id,
            cart_id: cart_id,
            qty: qty
        },
        success: function (data) {
            console.log(data);
            showOrder();
        },
        error: function () {
            eMsg('354');
        },
        complete: function () {
            // Agrega un pequeño retraso antes de volver a habilitar el botón
            setTimeout(function () {
                delCartExecuting = false;
                // Habilita nuevamente el botón
                $(button).prop('disabled', false);
            }, 200); // ajusta el tiempo según sea necesario
        }
    });
}


//end delCart

//order form
$(document).on('submit', '#form-order', function(event) {
    event.preventDefault();
    /* Act on the event */
    var custName = $('#customer-name').val();
    var tender = parseFloat($('#tendered').val());
    var totalOrder = parseFloat($('#totalOrder').text());
    var change = tender - totalOrder;

    if (change < 0) {
        alert('Datos insuficientes!');
    } else {
        //good vibes
        $.ajax({
            url: 'data/add_transaction.php',
            type: 'post',
            // dataType: 'json',
            data: {
                custName: custName,
                tender: tender,
                totalOrder: totalOrder,
                change: change
            },
            success: function(data) {
                console.log(data);
                // Aquí puedes realizar cualquier acción adicional después de la respuesta exitosa del servidor
            },
            error: function() {
                eMsg('385');
            }
        });
    }
});
//form order




function confirm_cart() {
    $('#confirm-type').val('confirmCart');
    $('#modal-confirmation').modal('show');
}

$('#confirm-yes').click(function(event) {
    var choice = $('#confirm-type').val();
    if (choice == 'confirmCart') {
		var cantidads = $('input[name="cantidad[]"]').map(function() {
            return $(this).val();
        }).get();
        var descuentos = $('input[name="descuento[]"]').map(function() {
            return $(this).val();
        }).get();
		

        $.ajax({
            url: 'data/confirm_order.php',
            type: 'post',
            dataType: 'json',
            data: {
                click: 'yes',
				cantidad:cantidads,
                descuento: descuentos
				
            },
            success: function(data) {
                
                if (data.valid == 0) {
                    $('#confirm-type').val('');
					$('#modal-message .modal-content').css({
						'background-color': 'white',
						'color': 'green'
					});
                    $('#modal-confirmation').modal('hide');
                    showOrder();
                    $('#modal-message').find('#msg-body').text(data.msg);
                    $('#modal-message').modal('show');
                    console.log(data);
                }else {
                    
					$('#confirm-type').val('');
					$('#modal-message .modal-content').css({
						'background-color': '#CD6155',
						'color': 'white'
					});
					
					$('#modal-confirmation').modal('hide');
					showOrder();
					$('#modal-message').find('#msg-body').html(data.msg);
					$('#modal-message').modal('show');
                    
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert("Error: " + textStatus + " - " + errorThrown);
                console.log("Error: " + textStatus + " - " + errorThrown);
                console.log("Mensaje de registro en la línea " + (new Error().stack.split('\n')[1].split(':')[1]));
            }
        });
    }
});




function showAllSales(){
	var date = $('#dailyDate').val();
	dailySales(date);
}//end showAllSales
showAllSales();

function showAllSale2(){
	var date = $('#dailyDate2').val();
	dailySalesALL(date);
}//end showAllSales
showAllSale2();

function consultarRangoSalesALL() {
  var startDate = $('#startDate').val();
  var endDate = $('#endDate').val();
  rangoSalesALL(startDate, endDate);
}
consultarRangoSalesALL();

function consultarRangoSales() {
  var startDate = $('#startDate').val();
  var endDate = $('#endDate').val();
  rangoSales(startDate, endDate);
}
consultarRangoSales();

function dailySales(date){
	$.ajax({
			url: 'data/user_sales.php?date='+date,
			type: 'get',
			data: {
				date:date
			},
			success: function (data) {
				$('#user-sales').html(data);
			},
			error:function(){
				eMsg(474);
			}
		});	
}

function dailySalesALL(date){
	$.ajax({
			url: 'data/all_sales.php?date='+date,
			type: 'get',
			data: {
				date:date
			},
			success: function (data) {
				$('#all-sales').html(data);
			},
			error:function(){
				eMsg(474);
			}
		});	
}

function rangoSalesALL(startDate, endDate) {
  $.ajax({
    url: 'data/all_sales.php?startDate=' + startDate + '&endDate=' + endDate,
    type: 'get',
    data: {
      startDate: startDate,
      endDate: endDate
    },
    success: function (data) {
      $('#all-sales').html(data);
    },
    error: function () {
      eMsg(474);
    }
  });
}

function rangoSales(startDate, endDate) {
  $.ajax({
    url: 'data/user_sales.php?startDate=' + startDate + '&endDate=' + endDate,
    type: 'get',
    data: {
      startDate: startDate,
      endDate: endDate
    },
    success: function (data) {
      $('#user-sales').html(data);
    },
    error: function () {
      eMsg(474);
    }
  });
}

$(document).on('change', '#dailyDate', function(event) {
	event.preventDefault();
	/* Act on the event */
	var date = $('#dailyDate').val();
	if(date == '' || date == null){
		$('#printBut').hide();
	}else{
		$('#printBut').show();
	}
	dailySales(date);
});

$(document).on('change', '#dailyDate2', function(event) {
	event.preventDefault();
	/* Act on the event */
	var date = $('#dailyDate2').val();
	if(date == '' || date == null){
		$('#printBut').hide();
	}else{
		$('#printBut').show();
	}
	dailySalesALL(date);
});

$('#printBut').click(function(event) {
	/* Act on the event */
	var date = $('#dailyDate').val();
	window.open('data/print-sales.php?date='+date,'name','width=600,height=400');	
});

// datatable-config.js
$(document).ready(function() {
  $('[id^="myTable"]').each(function() {
    var tableId = $(this).attr('id');
    var searchHtml = '<span class="glyphicon glyphicon-search custom-search" style="font-weight: bold;"> Buscar: </span>';
    
    $(this).DataTable({
      language: {
        search: searchHtml
      }
    });
  });
});

function showMAsVendido(){
	$.ajax({
			url: 'data/all_vendido.php',
			type: 'post',
			success: function (data) {
				$('#all-vendido').html(data);
			},
			error: function(){
				eMsg('275');
			}
		});
}//end showMAsVendido
showMAsVendido();

// Función para validar la cantidad ingresada
function validateQty(input) {
    var stockQty = $(input).data('qty'); // Obtener el stock disponible
    var enteredQty = input.value;

    // Limitar el valor del input a la cantidad máxima (stock disponible)
    if (enteredQty > stockQty) {
        input.value = stockQty; // Restablece el valor al máximo permitido
    }

    // Mostrar u ocultar el mensaje de error
    var errorMessage = $('#errorQty-' + $(input).data('stock-id'));
    if (enteredQty > stockQty) {
        errorMessage.show();
    } else {
        errorMessage.hide();
    }
}

//Spinner
