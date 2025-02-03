<?php
require_once('../database/Database.php');
require_once('../interface/iSales.php');

class Sales extends Database implements iSales {
	public function new_sales($code,$generic,$brand,$gram,$type,$qty,$price,$descuento)
	{
		$user_id = $_SESSION['logged_id'];
		$sql = " 
				INSERT INTO sales(item_code,generic_name,brand,gram,type,qty,price,user_id,descuento)
				VALUES(?,?,?,?,?,?,?,$user_id,?)";
				
		return $this->insertRow($sql, [$code,$generic,$brand,$gram,$type,$qty,$price,$descuento]);
	}//end new_sales

	public function daily_sales($date)
	{
		$user_id = $_SESSION['logged_id'];
		$sql = "SELECT 
					item_code,
					generic_name,
					gram,
					type,
					price,
					qty,
					descuento,
					(price * qty) AS subtotal,  -- Calcular subtotal por cada fila
					SUM(price * qty) OVER () AS total_sales,  -- Calcular total por día
					SUM(descuento) OVER () AS total_descuento,  -- Calcular total descuento por día
					TIME(date_sold) AS time_sold
				FROM sales
				WHERE DATE(date_sold) = ? and user_id= $user_id
				ORDER BY date_sold";
		return $this->getRows($sql, [$date]);
	}
	
	public function daily_salesAll($date)
	{
		$sql = "SELECT 
					item_code,
					generic_name,
					gram,
					type,
					price,
					qty,
					descuento,
					(price * qty) AS subtotal,  -- Calcular subtotal por cada fila
					SUM(price * qty) OVER () AS total_sales,  -- Calcular total por día
					SUM(descuento) OVER () AS total_descuento,  -- Calcular total descuento por día
					TIME(date_sold) AS time_sold
				FROM sales
				WHERE DATE(date_sold) = ?
				ORDER BY date_sold";
		return $this->getRows($sql, [$date]);
	}


	public function range_salesAll($startDate, $endDate)
	{
		$sql = "SELECT 
					item_code,
					generic_name,
					gram,
					type,
					price,
					qty,
					descuento,
					(price * qty) AS subtotal, -- Calculamos el subtotal por fila
					TIME(date_sold) AS time_sold -- Hora de venta
				FROM sales
				WHERE date_sold >= ? AND date_sold < DATE_ADD(?, INTERVAL 1 DAY)
				ORDER BY date_sold";
		return $this->getRows($sql, [$startDate, $endDate]);
	}



	public function range_sales($startDate, $endDate)
	{
		$user_id = $_SESSION['logged_id'];
		$sql = "SELECT 
					item_code,
					generic_name,
					gram,
					type,
					price,
					qty,
					descuento,
					(price * qty) AS subtotal, -- Calculamos el subtotal por fila
					TIME(date_sold) AS time_sold -- Hora de venta
				FROM sales
				WHERE date_sold >= ? AND date_sold < DATE_ADD(?, INTERVAL 1 DAY) and user_id= $user_id
				ORDER BY date_sold";
		return $this->getRows($sql, [$startDate, $endDate]);
		}

	public function mas_vendidos()
	{
    
    $sql = "SELECT s.generic_name, SUM(s.qty) AS cantidad_total_vendida, l.nombre_lab, st.stock_qty
		FROM sales s
		JOIN item i ON s.item_code = i.item_code
		JOIN laboratorio l ON i.lab_id = l.lab_id
		JOIN stock st ON i.item_id = st.item_id
		GROUP BY s.generic_name, l.nombre_lab, st.stock_qty
		ORDER BY cantidad_total_vendida DESC;";
    
    return $this->getRows($sql);
	}


}//end class
$sales = new Sales();


/* End of file Sales.php */
/* Location: .//D/xampp/htdocs/regis/class/Sales.php */