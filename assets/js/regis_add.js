$(document).ready(function() {
    // Cuando se haga clic en el botón "Guardar" en la ventana modal
    $('#add-lab-btn').click(function(event) {
        event.preventDefault(); // Evitar que se envíe el formulario de forma convencional

        // Obtener el nombre del laboratorio
        var labName = $('#lab-name').val();
        console.log('Valor del campo de entrada:', labName); // línea agregada
        
        // Enviar los datos al archivo PHP mediante AJAX
        $.ajax({
            url: 'data/add_laboratorio.php',
            type: 'POST',
            data: { 'lab-name': labName },
            dataType: 'json',
            success: function(response) {
                // Mostrar la respuesta del servidor
                console.log('Respuesta del servidor:', response);
                if (response.status == 'success') {
                    // Si el servidor devuelve un estado "success", cerrar la ventana modal y actualizar la lista de laboratorios
                    $('#modal-laboratorio').modal('hide');
                    location.reload();
                    alert('Laboratorio registrado exitosamente.');
                } else {

                    // Si el servidor devuelve un estado "error", mostrar el mensaje de error en la ventana modal
                    $('#modal-laboratorio .modal-body').prepend('<div class="alert alert-danger" role="alert">' + response.message + '</div>');
                }
            },
            error: function(xhr, status, error) {
                // Si ocurre un error al enviar la solicitud AJAX, mostrar el mensaje de error en la consola del navegador
                console.log('Error al enviar la solicitud AJAX:', error);
            }
        });
    });
});


  $('#modal-laboratorio').on('shown.bs.modal', function () {
    $('#lab-name').focus();
  });

  //agregar tipo 

  $(document).ready(function() {
    // Cuando se haga clic en el botón "Guardar" en la ventana modal
    $('#add-tipo-btn').click(function(event) {
        event.preventDefault(); // Evitar que se envíe el formulario de forma convencional

        // Obtener el nombre del laboratorio
        var tipoName = $('#tipo-name').val();
        console.log('Valor del campo de entrada:', tipoName); // línea agregada
        
        // Enviar los datos al archivo PHP mediante AJAX
        $.ajax({
            url: 'data/add_tipo.php',
            type: 'POST',
            data: { 'tipo-name': tipoName },
            dataType: 'json',
            success: function(response) {
                // Mostrar la respuesta del servidor
                console.log('Respuesta del servidor:', response);
                if (response.status == 'success') {
                    // Si el servidor devuelve un estado "success", cerrar la ventana modal y actualizar la lista de laboratorios
                    $('#modal-tipo').modal('hide');
                    location.reload();
                    alert('Tipo registrado exitosamente.');
                } else {

                    // Si el servidor devuelve un estado "error", mostrar el mensaje de error en la ventana modal
                    $('#modal-tipo .modal-body').prepend('<div class="alert alert-danger" role="alert">' + response.message + '</div>');
                }
            },
            error: function(xhr, status, error) {
                // Si ocurre un error al enviar la solicitud AJAX, mostrar el mensaje de error en la consola del navegador
                console.log('Error al enviar la solicitud AJAX:', error);
            }
        });
    });
});


  $('#modal-tipo').on('shown.bs.modal', function () {
    $('#tipo-name').focus();
  });





 

  

