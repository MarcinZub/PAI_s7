<?php
session_start();

if((!isset($_SESSION['logged']))&&($_SESSION['rola']==2))
{
	header('location: ../index.php');
	exit();
}


echo "<h1>faktury</h1>";




?>
