<?php
session_start();
if((!isset($_SESSION['logged']))&&($_SESSION['rola']!=0)){	#Tylko dla zalogowanych!!!
	header('Location: ../index.php');
	exit();
}

$login = $_POST['login'];
$login = htmlentities($login,ENT_QUOTES, "UTF-8");

require_once "../connection.php";

$sql=sprintf("SELECT login FROM User WHERE login='%s'", mysqli_real_escape_string($conn,$login));

if($result = $conn->query($sql))
{
	$ile_loginow = $result->num_rows;

	if($ile_loginow > 0){
		
		$_SESSION['info'] = '<span style="color:red">Użytkownik o podanym loginie już istnieje</span>';
	}
	else
	{
		$imie = $_POST['imie'];
		$nazwisko = $_POST['nazwisko'];
		
		$haslo1 = $_POST['haslo1'];
		$haslo2 = $_POST['haslo2'];
		$data_hasla = $_POST['data_hasla'];
		$region = $_POST['miejscowosc'];
		$rola = $_POST['typ_user'];
		$aktywny = $_POST['aktywny'];

		$encrypt = md5($haslo1);
		$data_hasla = date("Y-m-d H:i:s");
		$inf = "0000-00-00 00:00:00";
		
		$sql = "INSERT INTO User (id_uzytkownika, login, imie, nazwisko, haslo, data_hasla, region, rola, aktywny, data_wprowadzenia, data_wygasniecia, opis) VALUES(NULL, '$login', '$imie', '$nazwisko', '$encrypt', '$data_hasla', '$region', '$rola', 1, '$data_hasla', '$inf', '$rola')";

		if($conn->query($sql))
		{
			$_SESSION['info'] = '<span style="color:green">Nowy użytkownik został dodany</span>';
			
		}
		else
		{
			$_SESSION['info'] = '<span style="color:red">ERROR SQL</span>';

		}

	}
}

$conn->close();
header('Location: ../index.php?page=1');

?>