<!-- Dodaje i odbiera dostęp użytkonikowi do magazynu -->
<?php
session_start();

if((!isset($_SESSION['logged']))&&($_SESSION['rola']!=0))
{
	header('location: ../index.php');
	exit();
}

if ((!isset($_GET['iduser'])) && (!isset($_GET['idmag'])) && (!isset($_GET['option']))) {
	
	$_SESSION['info'] = '<span style="color:red">Dane nie przesłane</span>';

	header('Location: ../index.php');
	exit();
}
else{
	
	require_once '../connection.php';
	
	 $id_uzytkownika = $_GET['iduser'];
	 $id_magazynu = $_GET['idmag'];
	 $option = $_GET['option'];
	 
	 if($option){
	 	$data_wprowadzenia = date("Y-m-d H:i:s");

		 $sql = "INSERT INTO dostep (id_dostepu, id_magazynu, id_uzytkownika, data_wprowadzenia, opis) VALUES (NULL, '$id_magazynu', '$id_uzytkownika', '$data_wprowadzenia', '')";

		 if($result = $conn->query($sql)){

		 	$_SESSION['info'] = '<span style="color:green">Udane dodanie uprawnień!</span>';
		 }
		 else{

		 	$_SESSION['info'] = '<span style="color:red">Connection ERROR!</span>';
		 }
	 }
	 else if(!$option){

		$sql = "DELETE FROM dostep WHERE id_uzytkownika='$id_uzytkownika' AND id_magazynu=$id_magazynu";

		if($result = $conn->query($sql)){

			$_SESSION['info'] = '<span style="color:green">Usunięto dostęp użytkownika do bazy!</span>';
		}
		else{

			$_SESSION['info'] = '<span style="color:red">Nie udało się odebrać dostępu!</span>';

		}	 
	 }

	$conn->close();

	header('Location: edytujuser.php?id='.$id_uzytkownika);
		
	exit(); 
}


?>