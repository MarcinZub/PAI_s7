<?php
session_start();

if(!isset($_SESSION['logged']))
{
	header('location: ../index.php');
	exit();
}

if (isset($_GET['idtowar'])) 
{
	require_once '../connection.php';
	
	$id_towaru = $_GET['idtowar'];
		
	$sql = "DELETE FROM towar WHERE id_towaru='$id_towaru'";
	
	if($result = $conn->query($sql))
	{
		$_SESSION['info'] = '<span style="color:green">Usunięto towar z bazy!</span>';
	}
	else
	{
		$_SESSION['info'] = '<span style="color:red">Nie udało się usunoć towaru!</span>';
	}
	$conn->close();
	
	header("Location: ../index.php?page=3");
		
	exit(); 
}
else if(isset($_POST['nazwa']))
{
	require_once '../connection.php';
	
	$nazwa=$_POST['nazwa'];
	$kod_produktu=$_POST['kod_produktu'];
	$nr_seryjny=$_POST['nr_seryjny'];
	$data_waznosci=$_POST['data_waznosci'];
	$cena_netto=$_POST['cena_netto'];
	$cena_brutto=$_POST['cena_brutto'];
	$opis=$_POST['opis'];
	$data_wprowadzenia = date("Y-m-d H:i:s");

	$sql = "INSERT INTO towar (id_towaru, kod_produktu, nr_seryjny, nazwa, data_waznosci, data_wprowadzenia, cena_netto, cena_brutto, opis) VALUES (NULL, '$kod_produktu', '$nr_seryjny', '$nazwa', '$data_waznosci', '$data_wprowadzenia', '$cena_netto', '$cena_brutto', '$opis')";

	if($result = $conn->query($sql))
	{
		$_SESSION['info'] = '<span style="color:green">Udane dodanie towaru!</span>';
	}
	else
	{
		$_SESSION['info'] = '<span style="color:red">Connection ERROR!</span>';
	}

	$conn->close();
	
	header("Location: ../index.php?page=3");
		
	exit();  

}else
{

	header('Location: ../index.php');
	exit();
}


?>