<?php 
    require_once('../class/History.php');
    $histories = $history->all_history();
 ?>
<br />
    <div class="table-responsive">
        <table id="myTable-history" class="table table-hover">
            <thead>
                <tr class="table-header-dark">
                    <th class="text-center">Codigo</th>
                    <th class="text-center">Producto</th>
                    <th class="text-center">Accion</th>
                    <th class="text-center">Usuario</th>
                    <th class="text-center"># Cant</th>
                    <th class="text-center">Stock Total</th>
                    <th class="text-center">Fecha</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($histories as $s): ?>
                    <tr style="font-size:14px" class="text-center
                        <?= $s['action_type'] == 'INSERT' ? 'table-success' : 
                            ($s['action_type'] == 'UPDATE' ? 'table-warning' : 
                            ($s['action_type'] == 'DELETE' ? 'table-danger' : '')); ?> 
                        <?= $s['stock_qty'] == 0 ? 'table-danger' : ''; ?>">
                        <td><?= $s['item_id']; ?></td>
                        <td><?= ucwords($s['item_name']); ?></td>
                        <td><?= $s['action_type']; ?></td>
                        <td><?= ucwords($s['user_account']); ?></td>
                        <td><?= $s['cant_add']; ?></td>
                        <td><?= $s['stock_qty']; ?></td>
                        <td class="text-success fw-bold"><?= $s['action_date']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

            
    </div>

<!-- for the datatable of employee -->
<script type="text/javascript">
    $(document).ready(function() {
        $('#myTable-history').DataTable({
            "pageLength": 100,
            "order": [[6, 'asc']], 
        });
    });
</script>

<?php 
$history->Disconnect();
 ?>