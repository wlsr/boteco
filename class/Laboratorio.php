<?php
require_once('../database/Database.php');
require_once('../interface/iLaboratorio.php');
class Laboratorio extends Database implements iLaboratorio {
	public function all_labs()
	{
		$sql = "SELECT * FROM laboratorio
				ORDER BY nombre_lab ASC";
		return $this->getRows($sql);
	}//end all_items
	
	public function get_lab($lab_id)
	{
		$sql = "SELECT *
				FROM laboratorio
				WHERE lab_id = ?";
		return $this->getRow($sql, [$lab_id]);
	}//end edit_item

	public function add_lab($iName)
	{
		$sql = "INSERT INTO laboratorio (nombre_lab) 
				VALUES(?)";
		return $this->insertRow($sql, [$iName]);
	}//end add_item

	
}//end class Item

$laboratorio = new Laboratorio();

