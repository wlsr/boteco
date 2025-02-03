<?php 
require_once('../class/Stock.php');
$stockList = $stock->all_stockList();


 ?>
<br />
<div class="table-responsive">
    <table id="myTable-stocklist" class="table table-hover">
        <thead>
            <tr class="table-header-dark">
                <th class="text-center sorting_disabled" style="width: 50px;"><i class="fa fa-check"></i></th></th>
                <th class="text-center">Código</th>
                <th class="text-center">Producto</th>
                <th class="text-center">Laboratorio</th>
                <th class="text-center">Gr</th>
                <th class="text-center">Tipo</th>
                <th class="ctext-center">Precio</th>
                <th class="ctext-center">Stock</th>  
                <th class="ctext-center">Cantidad</th>
                <th class="ctext-center">Agregar</th>
            </tr>
        </thead>
        <tbody class="text-secondary-emphasis">
            <?php 
                $dateNow = date('Y-m');
                foreach($stockList as $sl): 
            ?>
                <tr class="stock-row table-txt-body <?= $sl['stock_qty'] == 0 ? 'text-danger' : ($sl['stock_qty'] > 0 && $sl['stock_qty'] < 6 ? 'text-warning' : ''); ?>" 
                data-id="<?= $sl['item_id']; ?>">
                    <td class="text-center p-1 ">
                        <input type="checkbox" name="stock" value="<?= $sl['stock_id']; ?>">
                    </td>
                    <td class="text-start p-1"><?= $sl['item_code']; ?></td>
                    <td class="text-start p-1"><?= ucwords($sl['item_name']); ?></td>
                    <td class="text-start p-1"><?= ucwords($sl['nombre_lab']); ?></td>
                    <td class="text-start p-1"><?= ucwords($sl['item_grams']); ?></td>
                    <td class="text-start p-1"><?= $sl['item_type_desc']; ?></td> 
                    <td class="text-center p-1"><?= "$ ".number_format($sl['item_price'],2); ?></td>
                    <td class="text-center p-1"><?= $sl['stock_qty']; ?></td>  
                    <td class="text-center p-1">
                        <input type="number" 
                               style="width: 80px;" 
                               min="1" 
                               step="any" 
                               class="text-center form-control p-1 bg-dark text-light border-secondary" 
                               id="qty" 
                               onkeypress="return event.charCode >= 48 && event.charCode <= 57" 
                               required="" 
                               oninvalid="this.setCustomValidity('Por favor, ingrese solo números.')" 
                               oninput="this.setCustomValidity('')">
                    </td>
                    <td class="text-center p-1">   
                        <a href="javascript:void(0)" 
                           class="text-warning fw-bold btn-add-stock <?php if ($sl['stock_qty'] < 6) echo 'btn-warning'; ?>" 
                           style="text-decoration: none;">
                           +
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>


<!-- for the datatable of employee -->
<script type="text/javascript">
    $(document).ready(function() {
        $('#myTable-stocklist').DataTable({
            "pageLength": 25,  
            "columnDefs": [
                {
                    "targets": 0, // Índice de la columna que no quieres que sea ordenable (en este caso la primera columna)
                    "orderable": false // Deshabilitar la opción de ordenar
                }
            ] 
        });
    });
</script>

<?php 
$stock->Disconnect();
 ?>