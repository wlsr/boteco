<?php 
    require_once('../class/Item.php');
    $items = $item->all_items();
    // echo '<pre>';
    //     print_r($items);
    // echo '</pre>';
 ?>
<br />
<div class="table-responsive">
    <table id="myTable-item" class="table table-hover">
        <thead>
            <tr class="table-header-dark">
                <th class="text-center">Código</th>
                <th class="text-center">Producto</th>
                <th class="text-center">Laboratorio</th>
                <th class="text-center">Tipo</th>
                <th class="text-center">Gramos</th>
                <th class="text-center">Precio</th>
                <th class="text-center">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($items as $it): ?>
                <tr class="text-center table-txt-body">
                    <td class="text-start"><?= $it['item_code']; ?></td>
                    <td class="text-start"><?= ucwords($it['item_name']); ?></td>
                    <td class="text-center"><?= $it['nombre_lab']; ?></td>
                    <td class="text-start"><?= $it['item_type_desc']; ?></td>
                    <td><?= $it['item_grams']; ?></td>
                    <td><?= "$ ".number_format($it['item_price'], 2); ?></td>
                    <td>
                        <a href="javascript:void(0)" onclick="editModal('<?= $it['item_id']; ?>');" class="text-warning fw-bold" style="text-decoration: none;">
                            Editar
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>




<br /><br /><br /><br />

<!-- for the datatable of employee -->
<script type="text/javascript">
    $(document).ready(function() {
        $('#myTable-item').DataTable({
            "pageLength": 25,
        });
    });
</script>

<?php 
$item->Disconnect();
 ?>