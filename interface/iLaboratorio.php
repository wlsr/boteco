<?php 
interface iLaboratorio{
	public function all_labs();
	public function get_lab($lab_id);
	public function add_lab($iName);
	
}//end iLaboratorio