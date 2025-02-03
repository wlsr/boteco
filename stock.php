<?php
 require_once('include/session.php'); 
 $stock_menu=1;
 ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Inventario -  Sistema de Inventario Farmacéutico</title>
    <link rel="icon" href="img/fav.png" type="image/png">
    <?php include("head.php");?>
</head>

    <body>
        <div id="body-style">
            <?php include("navbar.php");?>
            <div id="page-body-style">
                <div class="container-fluid">
                        <div class="col-lg-12">
                            <button class="btn btn-success btn-sm" id="stock-report">IMPRIMIR
                                <span class="glyphicon glyphicon-print" aria-hidden="true"></span>
                            </button>
                        </div>
                    <!-- /.row -->
                        <div id="all-stock"></div>
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- /#page-wrapper -->
            
        </div>
        
        <!-- /#wrapper -->
        <?php include_once('modal/confirmation.php'); ?>
        <?php include_once('modal/message.php'); ?>

        <script src="assets/js/jquery-3.6.0.min.js"></script>
        <script src="assets/js/bootstrap.bundle.min.js"></script>
        <script src="assets/js/jquery.dataTables.min.js"></script>
        <script src="assets/js/dataTables.bootstrap5.min.js"></script>

        <script type="text/javascript" src="assets/js/regis_add.js"></script>
        <script type="text/javascript" src="assets/js/regis.js"></script>

    </body>
    <footer>  
        <?php include("footer.php");?>
    </footer>
</html>
