<?php
require_once('../database/Database.php');
require_once('../interface/iStock.php');
class Stock extends Database implements iStock {

	public function all_stockList()
	{	
		// $sql = "SELECT *, COALESCE(i.item_id, 0) AS item_id, i.item_name, COALESCE(s.stock_qty, 0) AS stock_qty
		// 		FROM item i
		// 		LEFT JOIN stock s ON i.item_id = s.item_id
		// 		JOIN item_type it ON i.item_type_id = it.item_type_id
		// 		JOIN laboratorio l ON i.lab_id = l.lab_id";	
		$sql = "SELECT 
					i.item_code, 
					i.item_name, 
					i.item_id,
					COALESCE(s.stock_qty, 0) AS stock_qty, 
					it.item_type_desc, 
					i.item_grams,
					l.nombre_lab,
					i.item_price,
					s.stock_id
				FROM 
					item i
				LEFT JOIN 
					stock s ON i.item_id = s.item_id
				JOIN 
					item_type it ON i.item_type_id = it.item_type_id
				JOIN 
					laboratorio l ON i.lab_id = l.lab_id";
		return $this->getRows($sql);
	}//end all_stockList

	public function all_stockFilter()
	{
		$sql = "SELECT *,SUM(stock_qty) as qty
				FROM stock s
				INNER JOIN item i
				ON s.item_id = i.item_id
                INNER JOIN item_type t
                ON i.item_type_id = t.item_type_id
				GROUP BY s.item_id
				ORDER BY i.item_name ASC";
		return $this->getRows($sql);
	}//end all_stockGroupFilter



	public function get_stockList($stock_id)
	{
		$sql = "SELECT *
				FROM stock s 
				INNER JOIN item i 
				ON s.item_id = i.item_id
				WHERE s.stock_id = ?";
		return $this->getRow($sql, [$stock_id]);
	}//end get_stocklist

	public function del_stockList($stock_id)
	{
		$user_id = $_SESSION['logged_id'];
		$sql = "UPDATE stock
				SET stock_qty = 0, user_id = $user_id, cant_add = 0
				WHERE stock_id = ?";
		return $this->updateRow($sql, [$stock_id]);
	}//end del_stockList

	public function add_stock($item_id, $qty, $xDate, $manu, $purc)
	{	
		
		if ($xDate === 'undefined' || $manu === 'undefined' || $purc === 'undefined') {
		    // Establecer un valor predeterminado o manejar el error
		    $xDate = null;  // o algún valor válido para tu aplicación
		    $manu = null;
		    $purc = null;
		}
		$sql = "INSERT INTO stock(item_id, stock_qty, stock_expiry, stock_manufactured, stock_purchased)
				VALUES(?,?,?,?,?)";
		// return true;

		return $this->insertRow($sql, [$item_id, $qty,$xDate, $manu, $purc]);
	}//end add_stock

	public function all_stockGroup()
	{
		$sql = "SELECT s.stock_id,i.item_id,i.item_name, i.item_price,SUM(stock_qty) as qty
				FROM stock s 
				INNER JOIN item i
				ON s.item_id = i.item_id
				GROUP BY s.stock_id, i.item_id, i.item_name, i.item_price
				ORDER BY i.item_name ASC";
		return $this->getRows($sql);
	}//end all_stockGroup

	public function update_stockQty($stock_id, $stock_qty)
	{
		$sql = "UPDATE stock
				SET stock_qty = ?
				WHERE stock_id = ?";
		
		return $this->updateRow($sql, [$stock_qty, $stock_id]);
	}//end update_stockQty

	public function update_stockQty2($item_code, $stock_qty, $cantidad)
	{
		$user_id = $_SESSION['logged_id'];
		$sql = "UPDATE stock 
				SET stock_qty = ?, 
					user_id = ?, 
					cant_add = (? * -1) 
				WHERE item_id = (SELECT item_id FROM item WHERE item_code = ?)";

		$stmt = $this->datab->prepare($sql);
		return $stmt->execute([$stock_qty, $user_id, $cantidad, $item_code]);
	}



	public function updateInventario($stock_id, $item_id, $stock_qty)
	{
		$user_id = $_SESSION['logged_id'];
		$sql = "INSERT INTO stock (stock_id, item_id, stock_qty, user_id, cant_add) 
				VALUES (?, ?, ?, ?, ?) 
				ON DUPLICATE KEY UPDATE 
				item_id = VALUES(item_id), 
				stock_qty = stock_qty + VALUES(stock_qty), 
				user_id = VALUES(user_id),
				cant_add = VALUES(stock_qty)";
		
		return $this->updateRow($sql, [$stock_id, $item_id, $stock_qty, $user_id, $stock_qty]);
	}

	public function get_stockQty($stock_id)
	{
		$sql = "SELECT *
				FROM stock 
				WHERE stock_id = ?";
		return $this->getRow($sql, [$stock_id]);
	}//end get_stockQty
	
	public function get_stock($item_code)
	{
		$sql = "SELECT stock_qty FROM stock WHERE item_id = ( SELECT item_id FROM item WHERE item_code = ? )";
		return $this->getRow($sql, [$item_code]);
	}//end get_stock


	public function add_fuck($item_id, $qty, $xDate, $manu, $purc)
	{
		if ($xDate === 'undefined' || $manu === 'undefined' || $purc === 'undefined') {
		    // Establecer un valor predeterminado o manejar el error
		    $xDate = null;  // o algún valor válido para tu aplicación
		    $manu = null;
		    $purc = null;
		}
		$sql = "INSERT INTO stock(item_id, stock_qty, stock_expiry, stock_manufactured, stock_purchased)
				VALUES(?,?,?,?,?)";
		return $this->insertRow($sql, [$item_id, $qty, $xDate, $manu, $purc]);
	}//end add_stock
	

}//end class Stock
$stock = new Stock();
/* End of file Stock.php */
/* Location: .//D/xampp/htdocs/regis/class/Stock.php */