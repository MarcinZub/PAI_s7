<?php
session_start();
if((!isset($_SESSION['logged']))&&($_SESSION['rola']!=0))
{
	header('location: ../index.php');
	exit();
}

require_once "connection.php";	

	echo '<h2>Rejestracaj użytkownika</h2>';
	echo '<div class="formularz">';
	Rejestruj();
	echo '</div>';
	if(isset($_SESSION['info']))
	{
		echo $_SESSION['info'];
	}unset($_SESSION['info']);

	echo '<h2>Lista użytkowników</h2>';
	
	$sql="SELECT id_uzytkownika, login, imie, nazwisko, region, rola, aktywny, data_wprowadzenia ,data_wygasniecia FROM User";
	
	if($result = $conn->query($sql))
	{
		$ile_users = $result->num_rows; #ilość wierszy
	
		echo 'ilość użytkowników: '.$ile_users;
		echo '<table><tr><td>id użytkownika </td><td> login </td><td> imie </td><td> nazwisko </td><td> region </td><td> rola </td><td> aktywny </td><td>data wprowadzenia</td><td> data wygaśnięcia</td><td></td>';
		while($row = $result->fetch_assoc())
		{		
			switch($row['rola'])
			{
				case 0:$rola='Administrator'; break;
				case 1:$rola='Magazynier'; break;
				case 2:$rola='Wydawca'; break;
			}
			echo '<tr><td>'.$row['id_uzytkownika'].'</td><td>'.$row['login'].'</td><td>'.$row['imie'].'</td><td>'.$row['nazwisko'].'</td><td>'.$row['region'].'</td><td>'.$rola.'</td><td>';
			echo $row['aktywny']?'Tak':'Nie';
			echo '</td><td>'.substr($row['data_wprowadzenia'], 0, 10).'</td><td>'.substr($row['data_wygasniecia'], 0, 10).'</td><td><a href="include/edytujuser.php?id='.$row['id_uzytkownika'].'" >Edytuj</a></td>';
		}
		echo "</table>";
	}else
	{
		echo 'error SQL query';		
	}

	$conn->close();

?>