<?php 
require_once('../class/Cart.php');
require_once('../class/Stock.php');
//session_start();
if(isset($_POST['stock_id'])){
	$stock_id = $_POST['stock_id'];
	$item_id = $_POST['item_id'];
	$cqty = $_POST['cqty'];//cart qty ni siya
	$user_id = $_SESSION['logged_id'];
	$nqty = $_POST['nqty'];//cart qty ni siya
	$uniqid = $_SESSION['uniqid'];
	//$cantidad = $_POST['cantidad'];
	
	//add to cart
	//$updateQTY = $cart-> update_toCart(4921,$nqty);
	$saveToCart = $cart->add_toCart($item_id, $cqty, $stock_id, $user_id, $uniqid);
	$stock_total=$stock->get_stock($stock_id);
	$stck = $nqty;
	//update stock og minus si sa cart qty
	
	//$updateStockQty = $stock->update_stockQty($stock_id, $stck);

}//end isset
$cart->Disconnect();