<?php
require_once('../class/Sales.php');

if (isset($_GET['date']) && !empty($_GET['date'])) {
    // Consulta por un día específico
    $date = $_GET['date'];

    // Validar que el formato de la fecha sea correcto (Y-m-d)
    $dateObj = DateTime::createFromFormat('Y-m-d', $date);
    if ($dateObj && $dateObj->format('Y-m-d') === $date) {
        $dailySales = $sales->daily_sales($date);
    } else {
        // Si la fecha no es válida, muestra un mensaje de error
        echo "Fecha inválida. El formato debe ser Y-m-d.";
        exit;
    }

} elseif (isset($_GET['startDate']) && isset($_GET['endDate']) && !empty($_GET['startDate']) && !empty($_GET['endDate'])) {
    // Consulta por rango de fechas
    $startDate = $_GET['startDate'];
    $endDate = $_GET['endDate'];

    // Validar que ambas fechas estén en formato Y-m-d
    $startDateObj = DateTime::createFromFormat('Y-m-d', $startDate);
    $endDateObj = DateTime::createFromFormat('Y-m-d', $endDate);

    if ($startDateObj && $startDateObj->format('Y-m-d') === $startDate && $endDateObj && $endDateObj->format('Y-m-d') === $endDate) {
        $rangoSales = $sales->range_sales($startDate, $endDate);
    } else {
        // Si alguna fecha no es válida, muestra un mensaje de error
        echo "Una o ambas fechas son inválidas. El formato debe ser Y-m-d.";
        exit;
    }

} else {
    // No se proporcionaron fechas válidas, muestra un mensaje de error
    echo "No se proporcionaron fechas válidas.";
    exit;
}
?>

<br />
<div class="table-responsive">
    <table id="myTable-sales" class="table table-small table-dark rounded-3">
        <thead>
            <tr class="table-header-dark">
                <th class="text-center">Código</th>
                <th class="text-center">Producto</th>
                <th class="text-center">Gr</th>
                <th class="text-center">Tipo</th>
                <th class="text-center">Precio</th>
                <th class="text-center">Cant.</th>
                <th class="text-center">Sub Total</th>
                <th class="text-center">Desc</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $total = 0;
            $descuentoTotal = 0;
            if (isset($dailySales)) {
                foreach ($dailySales as $ds):
                    // El subtotal se calcula directamente en SQL
                    $subTotal = number_format($ds['subtotal'], 2);
                    $total += $ds['subtotal'];
                    $descuentoTotal += $ds['descuento'];
            ?>
                    <tr class="text-center table-txt-body">
                        <td class="d-none"><?= $ds['time_sold']; ?></td>
                        <td class="text-center"><?= $ds['item_code']; ?></td>
                        <td class="text-center"><?= $ds['generic_name']; ?></td>
                        <td class="text-center"><?= $ds['gram']; ?></td>
                        <td class="text-center"><?= $ds['type']; ?></td>
                        <td class="text-center"><?= number_format($ds['price'], 2); ?></td>
                        <td class="text-center"><?= $ds['qty']; ?></td>
                        <td class="text-center"><?= $subTotal; ?></td>
                        <td class="text-center"><?= $ds['descuento']; ?></td>
                    </tr>
            <?php
                endforeach;
            } elseif (isset($rangoSales)) {
                foreach ($rangoSales as $ds):
                    // El subtotal se calcula directamente en SQL
                    $subTotal = number_format($ds['subtotal'], 2);
                    $total += $ds['subtotal'];
                    $descuentoTotal += $ds['descuento'];
            ?>
                    <tr>
                        <td class="d-none" align="center"><?= $ds['date_sold']; ?></td>
                        <td align="center"><?= $ds['item_code']; ?></td>
                        <td align="center"><?= $ds['generic_name']; ?></td>
                        <td align="center"><?= $ds['gram']; ?></td>
                        <td align="center"><?= $ds['type']; ?></td>
                        <td align="center"><?= number_format($ds['price'], 2); ?></td>
                        <td align="center"><?= $ds['qty']; ?></td>
                        <td align="center"><?= $subTotal; ?></td>
                        <td align="center"><?= $ds['descuento']; ?></td>
                    </tr>
            <?php
                endforeach;
            }
            ?>
        </tbody>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td align="center"><strong>S/D</strong></td>
            <td align="center">
                <strong><?= number_format($total, 2); ?></strong>
            </td>
            <td align="center" style="color: red;">
                <strong><?= number_format($descuentoTotal, 2); ?></strong>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td class="verde" align="right"><strong>TOTAL:</strong></td>
            <td class="verde" align="center">
                <strong><?= number_format($total - $descuentoTotal, 2); ?></strong>
            </td>
            <td> </td>
        </tr>
    </table>
</div>

<br /><br /><br /><br />

<?php
$sales->Disconnect();
?>
