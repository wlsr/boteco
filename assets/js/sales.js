// salesALL
$(document).ready(function () {
    // Obtén el ID del usuario actual (esto debe estar disponible en tu sistema, por ejemplo, guardado en una variable de sesión o en el localStorage)
    const currentUser = 'user_id'; // Cambia esto con el ID del usuario actual, por ejemplo: sessionStorage.getItem('user_id')

    // Función para obtener los datos de ventas
    function fetchSalesData(params) {
        $('#spinner').show();

        // Agrega el ID del usuario actual a los parámetros
        params.user_id = currentUser;

        $.ajax({
            url: 'data/sales_table.php',  // Cambiar a tu archivo de servidor
            type: 'GET',
            data: params,
            dataType: 'json',
            success: function (data) {
                $('#spinner').hide();
                const tableBody = $('#salesTableBody');
                tableBody.empty(); // Limpiar tabla antes de insertar nuevos datos
                let total = 0;
                let descuentoTotal = 0;

                if (data.error) {
                    alert(data.error);
                } else {
                    data.forEach(row => {
                        total += row.subtotal;
                        descuentoTotal += row.descuento;

                        const tableRow = `
                            <tr class="table-body-dark">
                                <td class="d-none">${row.time_sold}</td>
                                <td class="text-center">${row.item_code}</td>
                                <td class="text-center">${row.generic_name}</td>
                                <td class="text-center">${row.gram}</td>
                                <td class="text-center">${row.type}</td>
                                <td class="text-center">${parseFloat(row.price).toFixed(2)}</td>
                                <td class="text-center">${row.qty}</td>
                                <td class="text-center">${parseFloat(row.subtotal).toFixed(2)}</td>
                                <td class="text-center">${row.descuento}</td>
                            </tr>`;

                        tableBody.append(tableRow);
                    });

                    // Actualizar totales en el pie de la tabla
                    $('#totalAmount').text(parseFloat(total).toFixed(2));
                    $('#discountAmount').text(parseFloat(descuentoTotal).toFixed(2));
                    $('#finalTotal').text(parseFloat(total - descuentoTotal).toFixed(2));
                }
                
            },
            error: function () {
                $('#spinner').hide();
                alert('Error al obtener los datos.');
            }
        });
    }

    // Llamada inicial al cargar la página para cargar las ventas del día
    // Hora Boliviana
    // Obtener la fecha en milisegundos desde el 1 de enero de 1970 UTC
    const timestamp = Date.now();

    // Calcular la diferencia en minutos entre la zona horaria UTC y la zona horaria de Bolivia (America/La_Paz)
    const offset = -4 * 60; // -4 horas de diferencia respecto a UTC

    // Crear un nuevo objeto Date con el timestamp ajustado a la zona horaria de Bolivia
    const boliviaDate = new Date(timestamp + offset * 60 * 1000);

    // Obtener la fecha en formato ISO
    const today = boliviaDate.toISOString().split('T')[0];

    fetchSalesData({ date: today, salesType: 'user' });
    
    // Función para manejar las fechas de inicio y fin o la fecha específica
    $('#date').on('change', function () {
        $('#startDate').val('');
        $('#endDate').val('');
        const date = $(this).val();
        if (date) {
            fetchSalesData({ date, salesType: $('#salesType').val() });
        }
    });

    $('#startDate, #endDate').on('change', function () {
        $('#date').val('');
        const startDate = $('#startDate').val();
        const endDate = $('#endDate').val();

        if (startDate && endDate) {
            fetchSalesData({ startDate, endDate, salesType: $('#salesType').val() });
        }
    });

    // Cambiar tipo de ventas cuando se seleccione el tipo
    $('#salesType').on('change', function () {
        fetchSalesData({ date: $('#date').val(), startDate: $('#startDate').val(), endDate: $('#endDate').val(), salesType: $(this).val() });
    });
});


