<?php
session_start();
if((!isset($_SESSION['logged'])) && ($_SESSION['rola']==2)){	#Tylko dla zalogowanych!!!
	header('Location: ../index.php');
	exit();
}


if((!isset($_POST['idtowar'])) || (!isset($_POST['kod_produktu'])) || (!isset($_POST['nr_seryjny']))|| (!isset($_POST['data_waznosci']))|| (!isset($_POST['cena_netto']))|| (!isset($_POST['cena_brutto']))|| (!isset($_POST['opis']))){

	$_SESSION['info'] = '<span style="color:red">Uzupełnij pola formularza!</span>';

	header('Location: edytujtowar.php?idtowar='.$_POST['idtowar']);
	exit();
}
else{

	$idtowar = $_POST['idtowar'];
	$nazwa = $_POST['nazwa'];
	$kod_produktu = $_POST['kod_produktu'];
	$nr_seryjny = $_POST['nr_seryjny'];
	$data_waznosci = $_POST['data_waznosci'];
	$cena_netto = $_POST['cena_netto'];
	$cena_brutto = $_POST['cena_brutto'];
	$opis = $_POST['opis'];
	
	require_once "../connection.php";

	
	$sql = "UPDATE towar SET nazwa='$nazwa', kod_produktu='$kod_produktu', nr_seryjny='$nr_seryjny', data_waznosci='$data_waznosci', cena_netto='$cena_netto', cena_brutto='$cena_brutto', opis='$opis' WHERE id_towaru='$idtowar' ";
			

	if($result = $conn->query($sql))
	{
		$_SESSION['info'] = '<span style="color:green">Dane towaru zostały zmienione! </span>';
	}
	else
	{
		$_SESSION['info'] = '<span style="color:red">Nie udało się zmienić danych towaru!</span>';
	
		$conn->close();
		header('Location: edytujtowar.php?idtowar='.$idtowar);
		exit();
	}
}

$conn->close();
header('Location: edytujtowar.php?idtowar='.$idtowar);
?>
