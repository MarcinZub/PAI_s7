<?php
session_start();

if(!isset($_SESSION['logged']))
{
	header('location: ../index.php');
	exit();
}

if ((!isset($_GET['idmag'])) || (!isset($_GET['idtowar'])))
{
	header('Location: ../index.php');
	exit();
	
}else
{
	require_once '../connection.php';
	
	$id_towaru = $_GET['idtowar'];
	$idmag=$_GET['idmag'];
		
	$sql = "DELETE FROM pozycja WHERE id_towaru=$id_towaru AND id_magazynu=$idmag";
	
	if($result = $conn->query($sql))
	{
		$_SESSION['info'] = '<span style="color:green">Usunięto towar z magazynu!</span>';
	}
	else
	{
		$_SESSION['info'] = '<span style="color:red">Nie udało się usunoć towaru!</span>';
	}
	$conn->close();
	
	header("Location: zawartosc.php?idmag=".$idmag);
	exit();
}


?>