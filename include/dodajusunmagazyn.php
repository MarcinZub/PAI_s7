<?php
session_start();

if((!isset($_SESSION['logged']))&&($_SESSION['rola']==2))
{
	header('location: ../index.php');
	exit();
}


if (isset($_GET['idmag'])) 
{
	require_once '../connection.php';
	
	$id_magazynu = $_GET['idmag'];
		
	$sql = "DELETE FROM magazyny WHERE id_magazynu='$id_magazynu'";
	
	if($result = $conn->query($sql))
	{
		$_SESSION['info'] = '<span style="color:green">Usunięto magazyn z bazy!</span>';
	}
	else
	{
		$_SESSION['info'] = '<span style="color:red">Nie udało się usunoć magazynu!</span>';
	}
	$conn->close();
	
	header("Location: ../index.php?page=2");
		
	exit(); 
}
else if(isset($_POST['nazwa']))
{
	require_once '../connection.php';
	
	$nazwa=$_POST['nazwa'];
	$region=$_POST['region'];
	$opis=$_POST['opis'];
	$data_zalozenia = date("Y-m-d H:i:s");

	$sql = "INSERT INTO magazyny (id_magazynu, nazwa, region, data_zalozenia, opis) VALUES (NULL, '$nazwa', '$region', '$data_zalozenia', '$opis')";

	if($result = $conn->query($sql))
	{
		$_SESSION['info'] = '<span style="color:green">Udane dodanie magazynu!</span>';
	}
	else
	{
		$_SESSION['info'] = '<span style="color:red">Connection ERROR!</span>';
	}

	$conn->close();
	
	header("Location: ../index.php?page=2");
		
	exit();  

}else
{

	header('Location: ../index.php');
	exit();
}


?>