<?php
session_start();

Get_menu();

$definedPages = array (1, 2, 3, 4);
 
$page = (isset($_GET['page'])) ? $_GET['page'] : 0;
 
if(in_array($page, $definedPages)) {
	switch($page){
		case 1:
			Get_user();
		break;
		
		case 2:
			Get_magazyny();
		break;
		
		case 3:
			Get_towar();
		break;

		case 4:
			Get_koszyk();
		break;
	}
	
	
} else {
	include "error/404.php";
}
?>