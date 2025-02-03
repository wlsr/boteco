<?php 
require_once('include/session.php'); 
$item_menu=1;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title> PRODUCTOS</title>
    <link rel="icon" href="img/fav.png" type="image/png">
    <?php include("head.php");?>
</head>
<body>
    <div id="body-style">
        <!-- Navigation -->
        <?php include('navbar.php');?>
        <div id="page-body-style">
            <div class="container-fluid">
                <div class="col-lg-12">
                    <button type="button" class="btn btn-info"  data-bs-toggle="modal" data-bs-target="#modal-laboratorio">
                        <i class="fa fa-plus-circle" aria-hidden="true"></i> <strong>Laboratorio</strong>
                    </button>
                    <button type="button" class="btn btn-warning ms-3" data-bs-toggle="modal" data-bs-target="#modal-tipo">
                        <i class="fa fa-plus-circle" aria-hidden="true"></i> <strong>Categoría</strong>
                    <button class="btn btn-success ms-3" id="add-new-item">
                        <i class="fa fa-plus-circle" aria-hidden="true"></i> <strong>Producto</strong>
                    </button>
                </div>
                <div id="all-item"></div>
            </div><!-- /.container-fluid -->
        </div>
    </div>
    
    <?php include_once('modal/add_new_item.php'); ?>
    <?php include_once('modal/message.php'); ?>
    <?php include_once('modal/stock.php'); ?>
    <?php include_once('modal/laboratorio.php'); ?>
    <?php include_once('modal/confirmation.php'); ?>


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
