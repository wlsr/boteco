<?php
	require_once('../include/session.php'); 	
    $user= $_SESSION['logged_name'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ventas</title>
</head>
<body>
    
<div class="container">
    <form id="salesForm">
        <div class="row">
                <?php
                date_default_timezone_set('America/La_Paz');
                $currentDate = date('Y-m-d');
                ?>
            <!-- Fecha a la izquierda -->
            <div class="col-md-3">
                <label for="date" class="form-label title-orange fw-bold">Fecha:</label>
                <input type="date" id="date" name="date" class="form-control" value="<?= $currentDate ?>">
            </div>
            <div class="col-md-2">
                <label for="salesType" class="form-label title-orange fw-bold">Ventas:</label>
                <select id="salesType" class="form-control text-danger fw-bold border-primary shadow-sm">
                    <option value="user"><?php echo ucfirst($user); ?></option>
                    <option value="all_sales">Totales</option>
                </select>
            </div>
            <!-- Contenedor para alinear Fecha Inicio y Fecha Fin a la derecha -->
            <div class="col-md-5 offset-md-2 d-flex justify-content-end">
                <div class="me-3">
                    <label for="startDate" class="form-label title-orange fw-bold">Fecha Inicio:</label>
                    <input type="date" id="startDate" name="startDate" class="form-control">
                </div>
                <div>
                    <label for="endDate" class="form-label title-orange fw-bold">Fecha Fin:</label>
                    <input type="date" id="endDate" name="endDate" class="form-control">
                </div>
            </div>
           
        </div>
       
    </form>
    <br>
    <div class="table-responsive">
        <div id="spinner" class="spinner-border text-primary" role="status" style="display: none;">
            <span class="visually-hidden">Cargando...</span>
        </div>
        <table id="myTable-sales" class="table table-hover">
            <thead>
                <tr class="table-header-orange">
                    <th class="text-center">Código</th>
                    <th class="text-center">Producto</th>
                    <th class="text-center">Gr</th>
                    <th class="text-center">Tipo</th>
                    <th class="text-center">Precio</th>
                    <th class="text-center">Cant.</th>
                    <th class="text-center">Sub Total</th>
                    <th class="text-center">Desc.</th>
                </tr>
            </thead>
            <tbody id="salesTableBody">
                <!-- Data will be inserted here dynamically -->
            </tbody>
            <tfoot>
                <tr class="table-dark">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="text-center"><strong>S/D</strong></td>
                    <td class="text-center"><strong id="totalAmount">0.00</strong></td>
                    <td class="text-center" style="color: red;">
                        <strong id="discountAmount">0.00</strong>
                    </td>
                </tr>
                <tr class="table-dark">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="text-success" align="right"><strong>TOTAL:</strong></td>
                    <td class="text-success" align="center">
                        <strong id="finalTotal">0.00</strong>
                    </td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
<script type="text/javascript" src="assets/js/sales.js"></script>
    
   
</body>
</html>
