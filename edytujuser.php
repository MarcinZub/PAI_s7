<?php 
session_start();
if(!isset($_SESSION['logged']))
{
	header('location: ../index.php');
	exit();
}

require_once "../connection.php";

	
	$id_user = (isset($_GET['id'])) ? $_GET['id'] : 0;

	$sql='SELECT * FROM User WHERE id_uzytkownika='.$id_user;
	if(($id_user>0)&&($result = $conn->query($sql)))
	{ 
	
		$row = $result->fetch_assoc();
		
		echo '<h1>edycja użytkownika</h1>';
		echo '<form id="fromedycja" action="zapiszedycje.php" method="post">';
		echo 'Typ: <select name="typ_user" id="typ_user">';
		echo '<option ';
		echo $row['rola']==0 ? 'selected' :'';
		echo ' value="0">Administrator</option>';
		echo '<option ';
		echo $row['rola']==1 ? 'selected' :'';
		echo ' value="1">Magazynier</option>';
		echo '<option ';
		echo $row['rola']==2 ? 'selected' :'';
		echo ' value="2">Wydawca</option>';
		echo '</select><br />';	
		echo 'Imie: <input type="text" id="imie" name="imie" placeholder="Imie" value='.$row['imie'].'><br />';
		echo 'Nazwisko: <input type="text" id="nazwisko" name="nazwisko" placeholder="Nazwisko" value='.$row['nazwisko'].'><br />';
		echo 'Login: <input type="text" id="login" name="login" placeholder="Login" value='.$row['login'].'><br>';
		echo 'Miejscowości: <select name="miejscowosc" id="miejscowosc" >';
		echo '<option selected value="-1"></option>';
		echo '<option ';
		echo $row['region']=="Poniszowice"? 'selected' :'';
		echo ' value="Poniszowice">Poniszowice</option>';
		echo '<option ';
		echo $row['region']=="Pyskowice"? 'selected' :'';
		echo ' value="Pyskowice">Pyskowice</option>';
		echo '<option ';
		echo $row['region']=="Stare Pyskowice"? 'selected' :'';
		echo ' value="Stare Pyskowice">Stare Pyskowice</option>';
		echo '<option ';
		echo $row['region']=="Taciszów"? 'selected' :'';
		echo ' value="Taciszów">Taciszów</option>';
		echo '<option ';
		echo $row['region']=="Toszek"? 'selected' :'';
		echo ' value="Toszek">Toszek</option>';
		echo '</select><br />';
		echo 'Aktywny: <input type="checkbox" name="aktywny" id="aktywny" value="aktywny"';
		echo $row['aktywny']? 'checked' :'';
		echo '><br>';
		echo 'Data wygasniecia: <input type="date" name="date" id="date" value='.substr($row['data_wygasniecia'], 0, 10).'><br>';
		echo 'Czas wygasniecia: <input type="time" name="time" id="time" value='.substr($row['data_wygasniecia'], 11, 8 ).'><br>';
		echo 'Nie wygaszaj konta: <input type="checkbox" name="aktywny" id="aktywny" value="aktywny"';
		echo $row['data_wygasniecia']=="0000-00-00 00:00:00"? 'checked' :'';
		echo '><br>';
		echo 'Zmien Hasło użytkownika : <input type="password" name="haslo1" id="haslo1" placeholder="Hasło" value="domyslne"><br>';
		echo 'Powtórz Hasło: <input type="password" name="haslo2" id="haslo2" placeholder="Powtórz Hasło" value="domyslne"><br>';
		echo '<input type="submit" value="Edytuj!">';
		echo '</form>';
		
		
		$sql='SELECT d.id_dostepu, d.id_magazynu , m.nazwa, m.region, d.data_wprowadzenia FROM dostep as d, magazyny as m WHERE d.id_magazynu=m.id_magazynu AND d.id_uzytkownika=1'; 
		
		if($result = $conn->query($sql))
		{ 
			$ilosc = $result->num_rows;
			echo '<h1>dostęp do magazynów:</h1>';
			
			if(isset($_SESSION['info']))
			{
				echo $_SESSION['info'];
			}unset($_SESSION['info']);
			
			echo 'ilość magazynów: '.$ilosc;
			if($ilosc)
			{	
				$id_mag_user[$ilosc];
				$lp=1;
				echo '<table><tr><td>Lp.</td><td>Nazwa magazynu</td><td>Region</td><td>data udzielenia</td><td></td></tr>';
				while($row = $result->fetch_assoc())
				{
					$id_mag_user[$lp-1]=$row['id_magazynu'];
					echo '<tr><td>'.$lp.'</td><td>'.$row['nazwa'].'</td><td>'.$row['region'].'</td><td>'.$row['data_wprowadzenia'].'</td><td><a href="dostepmagazyn.php?iduser='.$id_user.'&idmag='.$row['id_magazynu'].'&option=0">Usuń</a></td></tr>';
					$lp++;	
				}
				echo '</table>';
			}else
			{ 
				echo 'brak dostępu';
			}
		}
		
		
		$sql='SELECT id_magazynu, nazwa, region FROM magazyny';
		if($result = $conn->query($sql))
		{ 
			$ilosc = $result->num_rows;
			
			echo '<h1>udziel dostępu magazyny:</h1>';
			echo 'ilość dostępnych magazynów: ';
			echo $ilosc-count($id_mag_user);
			if($ilosc)
			{
				$lp=1;
				echo '<table><tr><td>Lp.</td><td>Nazwa magazynu</td><td>Region</td><td></td></tr>';
				while($row = $result->fetch_assoc())
				{
					if(!in_array($row['id_magazynu'],$id_mag_user))
					{
						echo '<tr><td>'.$lp.'</td><td>'.$row['nazwa'].'</td><td>'.$row['region'].'</td><td><a href="dostepmagazyn.php?iduser='.$id_user.'&idmag='.$row['id_magazynu'].'&option=1">Dodaj</a></td></tr>';
						$lp++;
					}
				}
				echo '</table>';
			}else
			{ 
				echo 'brak dostępu';
			}
		}
	}

$conn->close();


?>