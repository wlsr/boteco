<?php
	require_once('include/session.php'); 
	$sales_menu=1;	
    $user= $_SESSION['logged_name'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>MIS VENTAS</title>
    <link rel="icon" href="img/fav.png" type="image/png">
    <?php include("head.php");?>
</head>

<body>
    <div id="body-style">
        <?php include("navbar.php");?>
        <div id="page-body-style">
            <div class="container-fluid">
                <h5 class="centro"><strong>Mis Ventas: <span style="color: #309EC1;"><?php echo ucfirst($user); ?></span></strong></h5>
                <?php
                date_default_timezone_set('America/La_Paz');
                $currentDate = date('Y-m-d');
                ?>
                <div class="d-flex justify-content-between align-items-center">
                    <!-- dailyDate con un margen a la derecha para separación -->
                    <input id="dailyDate" type="date" class="btn btn-info btn-md" placeholder="" value="<?= $currentDate ?>">

                    <!-- Contenedor con separación de 10px entre elementos -->
                    <div class="d-flex align-items-center ms-3">
                        <h5 style="color:#309EC1" class="me-2 fw-bold">Consulta por fechas: </h5>
                        <input id="startDate" type="date" class="btn btn-info btn-md" placeholder="" value="">
                        <label style="color:#309EC1" class="me-2 fw-bold">Hasta: </label>
                        <input id="endDate" type="date" class="btn btn-info btn-md" placeholder="" value="">
                        <button onclick="consultarRangoSales()" class="btn btn-info btn-outline-success btn-sm ms-3 fw-bold">Consultar</button>
                    </div>
                </div>
                <div id="user-sales"></div>
                
            </div>
           
        </div>
            <!-- /.container-fluid -->
   
        <!-- /#page-wrapper -->

        <script src="assets/js/jquery-3.6.0.min.js"></script>
        <script src="assets/js/bootstrap.bundle.min.js"></script>
        <script src="assets/js/jquery.dataTables.min.js"></script>
        <script src="assets/js/dataTables.bootstrap5.min.js"></script>
        
        <script type="text/javascript" src="assets/js/regis.js"></script>
        
        <script type="text/javascript">
        $(document).ready(function () {
            var currentDate = '<?= $currentDate ?>';
            dailySales(currentDate);
        });
        </script>
        <footer>  
            <?php include("footer.php");?>
        </footer>
    </body>
</html>
