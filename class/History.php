<?php
require_once('../database/Database.php');
require_once('../interface/iHistory.php');
class History extends Database implements iHistory {

    public function all_history()
	{
		$sql = "SELECT 
            sh.item_id,
            i.item_name,
            CASE 
                WHEN sh.cant_add = 0 THEN 'DELETE'
                ELSE sh.action_type
            END AS action_type,
            u.user_account,
            sh.cant_add,
            sh.stock_qty,
            sh.action_date
        FROM stock_history sh
        INNER JOIN item i ON sh.item_id = i.item_id
        INNER JOIN user u ON sh.user_id = u.user_id;";
		return $this->getRows($sql);
	}//end all_history
}
$history = new History();