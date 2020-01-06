<?php

session_start();

	if((!isset($_POST['login'])) || (!isset($_POST['haslo']))){ #Jeżeli login i haslo nie są ustawione

		header('Location: index.php');
		exit();
	}

//else do if connect_errno

$login = $_POST['login'];
$haslo = $_POST['haslo'];

$login = htmlentities($login,ENT_QUOTES, "UTF-8"); #Anty wstrzykiwanie

require_once "connection.php";

$sql=sprintf("SELECT * FROM User WHERE login='%s'", mysqli_real_escape_string($conn,$login));

if($result = $conn->query($sql)){ #sprawdzania poprawność zapytania
	
	$ile_users = $result->num_rows; #ilość wierszy

	if($ile_users > 0){
		$row = $result->fetch_assoc();

		$conn->close();

		$login_db = $row['login'];
		$haslo_db = $row['haslo'];

		$encrypt = md5($haslo);
		
		$aktywne = $row['aktywny'];
		$data_db = $row['data_wygasniecia'];

		$data_teraz = date("Y-m-d H:i:s");
		$inf = "0000-00-00 00:00:00";
		
		//Sprawdzanie czy konto nie wygasło
		if($data_db == $inf) 
		{

		}else if($data_teraz > $data_db){
			$_SESSION['info'] ='<span style="color:red">Twoje konto wygasło. Skontaktuj się z administratorem!</span>';

			header('Location: index.php');
			exit();
		}

		//Sprawdzanie czy konto jest aktywne
		if(!$aktywne){
			$_SESSION['info'] ='<span style="color:red">Twoje konto zostało zablokowane. Skontaktuj się z administratorem!</span>';

			header('Location: index.php');
			exit();
		}

		if(($login == $login_db) && ($encrypt == $haslo_db)){
		
			$_SESSION['logged'] = true;

			$_SESSION['id'] = $row['id_uzytkownika'];
			$_SESSION['imie'] = $row['imie'];
			$_SESSION['nazwisko'] = $row['nazwisko'];
			$_SESSION['region'] = $row['region'];
			$_SESSION['rola'] = $row['rola'];

			unset($_SESSION['info']);

			//$result->free_result();

			header('Location: index.php');
			exit();
		}
		else{
			
			$blad = true;
			//$_SESSION['blad']='1'; 
		}
	}
	else{
		$blad = true;
		//$_SESSION['blad']='2'; 
	}

	if($blad){
		
		$_SESSION['info'] .='<span style="color:red">Podałeś/aś nieprawidłowy <b>Login</b> lub <b>Hasło</b>!</span>';

		header('Location: index.php');
	}

}

?>