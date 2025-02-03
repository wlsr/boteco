<?php 
    require_once('../class/Stock.php');
    $stocks = $stock->all_stockGroup();
 ?>
<br />
    <div class=" col-md-8 table-responsive ">
            <table id="myTable-stock" class="table table-hover">
                <thead>
                    <tr class="table-header-dark">
                        <th class="text-center">Producto</th>
                        <th class="text-center">Precio</th>
                        <th class="text-center">Stock</th>
                    
                    </tr>
                </thead>
                <tbody>
                <?php foreach($stocks as $s): ?>
                    <tr class="text-center table-txt-body <?= $s['qty'] == 0 ? 'text-danger fw-bold' : ''; ?>">
                        <td class="text-start"><?= ucwords($s['item_name']); ?></td>
                        <td><?= "$ " . number_format($s['item_price'], 2); ?></td>
                        <td><?= $s['qty']; ?></td>
                    </tr>

                <?php endforeach; ?>
                </tbody>
            </table>
    </div>


<br /><br /><br /><br />

<!-- for the datatable of employee -->
<script type="text/javascript">
    $(document).ready(function() {
        $('#myTable-stock').DataTable({
            "pageLength": 100,
        });
    });
</script>

<?php 
$stock->Disconnect();
 ?>