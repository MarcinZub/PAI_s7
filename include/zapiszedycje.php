<?php
session_start();
if((!isset($_SESSION['logged'])) && ($_SESSION['rola']!=0)){	#Tylko dla zalogowanych!!!
	header('Location: ../index.php');
	exit();
}


if((!isset($_POST['typ_user'])) || (!isset($_POST['imie'])) || (!isset($_POST['nazwisko'])) || (!isset($_POST['login'])) || (!isset($_POST['miejscowosc'])) || (!isset($_POST['date'])) || (!isset($_POST['time']))  || (!isset($_POST['haslo1'])) || (!isset($_POST['haslo2']))){

	$_SESSION['info'] = '<span style="color:red">Uzupełnij pola formularza!</span>';

	header('Location: edytujuser.php?id='.$_POST['id']);
	exit();
}
else{
	$id = $_POST['id'];
	
	$login = $_POST['login'];
	$login = htmlentities($login,ENT_QUOTES, "UTF-8");

	require_once "../connection.php";

	$sql=sprintf("SELECT id_uzytkownika FROM User WHERE login='%s'", mysqli_real_escape_string($conn,$login));

	if($result = $conn->query($sql))
	{
		$ile = $result->num_rows;

		$row=$result->fetch_assoc();

		if(($ile > 0) && ($id != $row['id_uzytkownika']))
		{
			$_SESSION['info'] = '<span style="color:red">taki login jest już używany</span>';

			$conn->close();
			header('Location: edytujuser.php?id='.$id);
			exit();
		}
		else
		{
			//Pobrane z formularza
			$typ_user = $_POST['typ_user'];
			$imie = $_POST['imie'];
			$nazwisko = $_POST['nazwisko'];
			$miejscowosc = $_POST['miejscowosc'];
			$date = $_POST['date'];
			$time = $_POST['time'];
		
			$aktywny=isset($_POST['aktywny'])?1:0;
			$data_wygasniecia = "0000-00-00 00:00:00";
			
			if(!isset($_POST['wygaszenie'])) $data_wygasniecia=$date.' '.$time; 
			
			$haslo1 = $_POST['haslo1'];
			$haslo2 = $_POST['haslo2'];

			if(!strcmp($haslo1, $haslo2))
			{
				if(strcmp($haslo1, 'domyslne')!=0 )
				{

					$hash = md5($haslo1);
					$sql = "UPDATE User SET haslo='$hash' WHERE id_uzytkownika='$id' ";

					if($result = $conn->query($sql));
					else
					{
						$_SESSION['info'] = '<span style="color:red">wystapił błąd!</span>';
						$conn->close();
						header('Location: edytujuser.php?id='.$id);
						exit();
					}
				}
			}
			else
			{
				$_SESSION['info'] = '<span style="color:red">Hasła różnią sie od siebie!</span>';
				$conn->close();
				header('Location: edytujuser.php?id='.$id);
				exit();
			}

			$sql = "UPDATE User SET rola='$typ_user', imie='$imie', nazwisko='$nazwisko', login='$login', region='$miejscowosc', aktywny='$aktywny', data_wygasniecia='$data_wygasniecia' WHERE id_uzytkownika='$id' ";


			if($result = $conn->query($sql))
			{
				$_SESSION['info'] = '<span style="color:green">Dane użytkonika zostały zmienione! </span>';
			}
			else
			{
				$_SESSION['info'] = '<span style="color:red">Nie udało się zmienić danych użytkownika!</span>';
				
				$conn->close();
				header('Location: edytujuser.php?id='.$id);
				exit();
			}
		}
	}
}

$conn->close();
header('Location: edytujuser.php?id='.$id);
?>
