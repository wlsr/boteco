<?php 
interface iSales{
	public function new_sales($code,$generic,$brand,$gram,$type,$qty,$price,$descuento);
	public function daily_sales($date);
}