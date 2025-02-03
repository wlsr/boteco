<?php 
require_once('../class/Item.php');

if(isset($_POST['iName']) && isset($_POST['iPrice']) && isset($_POST['code'])){
	$iName = $_POST['iName'];
	$iPrice = $_POST['iPrice'];
	$iType = $_POST['iType'];
	$code = $_POST['code'];
	$brand = $_POST['brand'];
	$grams = $_POST['grams'];
	$iName = strtolower($iName);
	$iPrice = strtolower($iPrice);
	$iName = ucwords(strtolower($iName));
	$code = ucwords(strtolower($code));
	$brand = ucwords(strtolower($brand));
	$grams = ucwords(strtolower($grams));

	// Check if code already exists in the database
	$sql = "SELECT item_code FROM item WHERE item_code=?";
	$checkCode = $item->getRow($sql, [$code]);
	if ($checkCode) {
		// If the code already exists, return an error message
		$return['valid'] = false;
		$return['msg'] = "CODIGO REPETIDO";
		echo json_encode($return);
	} else {
		// If the code does not exist, add the item to the database
		$saveItem = $item->add_item($iName, $iPrice, $iType, $code, $brand, $grams);
		if($saveItem){
			$return['valid'] = true;
			$return['msg'] = "AGREGADO CON EXITO";
		} else {
			$return['valid'] = false;
			$return['msg'] = "Error al agregar el registro.";
		}
		echo json_encode($return);
	}
}//end isset

$item->Disconnect();
