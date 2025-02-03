<?php
require_once('../class/Sales.php');
$masVendidos = $sales->mas_vendidos();

?>

<div class="table-responsive">
    <div class="container">
        <table id="myTable-datos" class="table table-hover">
            <thead>
                <tr class="table-header-dark">
                    <th class="text-center">Producto</th>
                    <th class="text-center">Nro Vendidos</th>
                    <th class="text-center">Laboratorio</th>
                    <th class="text-center">Stock</th>
                   
                </tr>
            </thead>
            <tbody>
            <?php foreach($masVendidos as $s): ?>
               <tr class="text-center table-body-dark <?= $s['stock_qty'] < 10 ? 'text-danger' : ''; ?>">
                    <td <?php if ($s['stock_qty'] < 10) { echo 'class="red_dark"'; } ?>><?= ucwords($s['generic_name']); ?></td>
                    <td class="text-center"><?= $s['cantidad_total_vendida']; ?></td>
                    <td><?= $s['nombre_lab']; ?></td>
                    <td><?= $s['stock_qty']; ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>



<br /><br />


<!-- for the datatable of employee -->
<script type="text/javascript">
    $(document).ready(function() {
        $('#myTable-datos').DataTable({
            "pageLength": 50,
            "ordering": false
        });
    });
</script>

<?php
$sales->Disconnect();
?>
