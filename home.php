<?php 

require_once 'database/Connection.php';
require_once('include/session.php');
$id = $_SESSION['logged_id'];
$home_menu = 1;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Inicio - Sistema de Inventario Farmacéutico </title>
    <link rel="icon" href="img/fav.png" type="image/png">
    <?php include("head.php");?>
</head>

<body>
    <div id="body-style">
        <?php include('navbar.php');?>
        <div id="page-body-style">
            <div class="container-fluid">
                <div id="order"></div>
            </div><!-- /.container-fluid -->
        </div>
    </div>
   
    

    <?php include_once('modal/to_cart.php'); ?>
    <?php include_once('modal/confirmation.php'); ?>
    <?php include_once('modal/add_new_item.php'); ?>
    <?php include_once('modal/message.php'); ?>

    
    <script src="assets/js/jquery-3.6.0.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/jquery.dataTables.min.js"></script>
    <script src="assets/js/dataTables.bootstrap5.min.js"></script>
    <!--<script type="text/javascript" src="assets/js/cart-scripts.js"></script>-->
    <script type="text/javascript" src="assets/js/regis.js"></script>
    

</body>
<footer>  
    <?php include("footer.php");?>
</footer>

<script>
    // Escucha el evento personalizado orderLoaded y ejecuta la función imprimirDatosLocalStorage()
    document.addEventListener('orderLoaded', function() {
        imprimirDatosLocalStorage();
    });
</script>

</html>
