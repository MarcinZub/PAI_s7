<?php
session_start();
if((!isset($_SESSION['logged'])) && ($_SESSION['rola']==2)){	#Tylko dla zalogowanych!!!
	header('Location: ../index.php');
	exit();
}


if((!isset($_POST['idmag'])) || (!isset($_POST['nazwa'])) || (!isset($_POST['region'])) || (!isset($_POST['opis']))){

	$_SESSION['info'] = '<span style="color:red">Uzupełnij pola formularza!</span>';

	header('Location: edytujmagazyn.php?idmag='.$_POST['idmag']);
	exit();
}
else{

	$idmag = $_POST['idmag'];
	$nazwa = $_POST['nazwa'];
	$region = $_POST['region'];
	$opis = $_POST['opis'];
	
	require_once "../connection.php";

	
	$sql = "UPDATE magazyny SET nazwa='$nazwa', region='$region', opis='$opis' WHERE id_magazynu='$idmag' ";
			

	if($result = $conn->query($sql))
	{
		$_SESSION['info'] = '<span style="color:green">Dane magazynu zostały zmienione! </span>';
	}
	else
	{
		$_SESSION['info'] = '<span style="color:red">Nie udało się zmienić danych magazynu!</span>';
	
		$conn->close();
		header('Location: edytujmagazyn.php?idmag='.$idmag);
		exit();
	}
}

$conn->close();
header('Location: edytujmagazyn.php?idmag='.$idmag);
?>
