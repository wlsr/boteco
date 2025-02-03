<?php
require_once('include/session.php'); 
$moresales_menu=1;   
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>VENTAS</title>
    <link rel="icon" href="img/fav.png" type="image/png">
    <?php include("head.php");?>
    
</head>

<body>
    <div id="body-style">
        <!-- Navigation -->
        <?php include("navbar.php");?>
        <div id="page-body-style">
            <div class="container-fluid">
                <!-- Page Heading -->
                 <?php
                date_default_timezone_set('America/La_Paz');
                $currentDate = date('Y-m-d');
                ?>
                <button class="btn btn-success btn-sm" id="ventas-report">IMPRIMIR
                    <span class="glyphicon glyphicon-print" aria-hidden="true"></span>
                </button>
                    <div id= "imprimir">    
                   <div id="all-vendido"></div>
                   </div>
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->

    <script src="assets/js/jquery-3.6.0.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/jquery.dataTables.min.js"></script>
    <script src="assets/js/dataTables.bootstrap5.min.js"></script>
    
    <script type="text/javascript" src="assets/js/regis.js"></script>
    <script type="text/javascript">
        $currentDate = "valor_de_currentDate";
        $(document).ready(function () {
            var currentDate = '<?= $currentDate.""?>';
            dailySalesALL(currentDate);
        });
    </script>
    <footer>  
        <?php include("footer.php");?>
    </footer>

</body>
</html>
