<?php 
session_start();
if(!isset($_SESSION['logged'])&&($_SESSION['rola']!=0))
{
	header('location: ../index.php');
	exit();
}

require '../function.php';

Get_head_out();

Get_menu_out();

require_once "../connection.php";

	
	$id_user = (isset($_GET['id'])) ? $_GET['id'] : 0;

	$sql='SELECT * FROM User WHERE id_uzytkownika='.$id_user;
	if(($id_user>0)&&($result = $conn->query($sql)))
	{ 
	
		$row = $result->fetch_assoc();
		
		echo '<h2>Edycja użytkownika</h2>';
		
		echo '<div id="formularz">';
		echo '<form id="fromedycja" action="zapiszedycje.php" method="post">';
		echo '<input type="hidden" name="id" value='.$row['id_uzytkownika'].'>';
		
		echo '<div id="form_edycja_uzyt">Typ: <br /><select name="typ_user" id="typ_user">';
		echo '<option ';
		echo $row['rola']==0 ? 'selected' :'';
		echo ' value="0">Administrator</option>';
		echo '<option ';
		echo $row['rola']==1 ? 'selected' :'';
		echo ' value="1">Magazynier</option>';
		echo '<option ';
		echo $row['rola']==2 ? 'selected' :'';
		echo ' value="2">Wydawca</option>';
		echo '</select></div>';	
		
		echo '<div class="form_edycja_uzyt">Imie: <br /><input type="text" id="imie" name="imie" placeholder="Imie" value='.$row['imie'].'></div>';
		
		echo '<div class="form_edycja_uzyt">Nazwisko: <br /><input type="text" id="nazwisko" name="nazwisko" placeholder="Nazwisko" value='.$row['nazwisko'].'></div>';
		
		echo '<div class="form_edycja_uzyt">Login: <br /><input type="text" id="login" name="login" placeholder="Login" value='.$row['login'].'></div>';
		
		echo '<div class="form_edycja_uzyt">Miejscowości: <br /><select name="miejscowosc" id="miejscowosc" >';
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
		echo '</select></div>';

		echo '<div class="form_edycja_uzyt">Aktywny: <input type="checkbox" name="aktywny" id="aktywny" ';
		echo $row['aktywny']? ' checked' :'';
		echo '></div>';

		#$data_wygasniecia = "0000-00-00 00:00:00";
		#$data_tabela = $row['data_wygasniecia'];
	#	echo $data_wygasniecia.'<br />';
	#	echo $data_tabela.'<br />';
		//Dodać w JS wygaszenie inputów 'date' i 'time', gdy czeckbox 'wygaszenie' jest zaznaczony, tak żeby użytkownik nie mógł tego edytwać
		echo '<div class="form_edycja_uzyt">Data wygasniecia: <br /><input type="date" name="date" id="date" value="'.substr($row['data_wygasniecia'], 0, 10).'"></div>';
		echo '<div class="form_edycja_uzyt">Czas wygasniecia: <br /><input type="time" name="time" id="time" value="'.substr($row['data_wygasniecia'], 11, 8 ).'"></div>';
		
		echo '<div class="form_edycja_uzyt">Nie wygaszaj konta: <input type="checkbox" name="wygaszenie" id="wygaszenie"';
		echo $row['data_wygasniecia']=="0000-00-00 00:00:00"? 'checked ' :' ';
		echo '></div>';
		#if(strcmp($data_wygasniecia, $data_tabela)){
		#	echo 'Nie wygaszaj konta: <input type="checkbox" name="wygaszenie" id="wygaszenie" value="1" checked';
		#}
		#else{
	#		echo 'Nie wygaszaj konta: <input type="checkbox" name="wygaszenie" id="wygaszenie" value="0"';
#		}

		//----------------------------------------------------------------------------------------------------------
		echo '<div class="form_edycja_uzyt">Zmien Hasło użytkownika : <br /><input type="password" name="haslo1" id="haslo1" placeholder="Hasło" value="domyslne"></div>';
		echo '<div class="form_edycja_uzyt">Powtórz Hasło: <br /><input type="password" name="haslo2" id="haslo2" placeholder="Powtórz Hasło" value="domyslne"></div>';
		echo '<div class="form_edycja_uzyt"><br /><input type="submit" value="Edytuj!"></div>';
		echo '</form>';
		echo '</div>';
		

		$sql='SELECT d.id_dostepu, d.id_magazynu , m.nazwa, m.region, d.data_wprowadzenia FROM dostep as d, magazyny as m WHERE d.id_magazynu=m.id_magazynu AND d.id_uzytkownika='.$id_user; 
		
		if($result = $conn->query($sql))
		{ 
			$ilosc = $result->num_rows;
			echo '<h2>Usuń dostęp użytkownika do magazynów:</h2>';
			
			//Sessioninfo();
			if(isset($_SESSION['info'])){ echo $_SESSION['info'];}
				unset($_SESSION['info']);
			
			echo '<br />ilość magazynów: '.$ilosc;
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
				echo '<br />brak dostępu';
			}
		}
		
		
		$sql='SELECT id_magazynu, nazwa, region FROM magazyny';
		
		if($result = $conn->query($sql))
		{ 
			$ilosc = $result->num_rows;
			
			echo '<h2>Udziel dostępu magazynów:</h2>';
			echo 'Ilość dostępnych magazynów: ';
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

Get_footer();
?>