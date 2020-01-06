<?php
session_start();
if(!isset($_SESSION['logged']))
{
	header('location: ../index.php');
	exit();
}

require_once "connection.php";


echo<<<END

	<h2>Dodaj towar</h2>

	<div class="formularz">
		<form id="dodajtowar" action="include/dodajusuntowar.php" method="post">
			<div class="form_towar">Kod Produktu:<br /><input type="test" id="kod_produktu" name="kod_produktu" placeholder="kod produktu" required></div>
			<div class="form_towar">Numer Seryjny: <br /><input type="text" id="nr_seryjny" name="nr_seryjny" placeholder="numer seryjny" required></div>
			<div class="form_towar">Nazwa: <br /><input type="text" id="nazwa" name="nazwa" placeholder="Nazwa" required></div>
			<div class="form_towar">Data waznosci: <br /><input type="date" id="data_waznosci" name="data_waznosci" required></div>
			<div class="form_towar">Cena netto: <br /><input  type="number" step="0.01" min="0" id="cena_netto" name="cena_netto" required></div>
			<div class="form_towar">Cena brutto: <br /><input type=number step="0.01" min="0" id="cena_brutto" name="cena_brutto" required></div>
			<div class="form_towar">Opis: <br /><input type="textarea" name="opis" id="opis" placeholder="Brak"></div>

			<div class="form_towar"><input type="submit" value="Dodaj!"></div>

		</form>
	</div>


END;


	// echo '<h1>Dodaj towar:</h1>';

	// echo '<div class="formularz">';

	// echo '<form id="dodajtowar" action="include/dodajusuntowar.php" method="post">';
	// echo 'Kod Produktu:<br /><input type="test" id="kod_produktu" name="kod_produktu" placeholder="kod produktu" required><br />';
	// echo 'Numer Seryjny: <br /><input type="text" id="nr_seryjny" name="nr_seryjny" placeholder="numer seryjny" required><br />';
	// echo 'Nazwa: <br /><input type="text" id="nazwa" name="nazwa" placeholder="Nazwa" required><br />';
	// echo 'Data waznosci: <br /><input type="date" id="data_waznosci" name="data_waznosci" required><br />';
	// echo 'Cena netto: <br /><input  type="number" step="0.01" min="0" id="cena_netto" name="cena_netto" required><br />';
	// echo 'Cena brutto: <br /><input type=number step="0.01" min="0" id="cena_brutto" name="cena_brutto" required><br />';
	// echo 'Opis: <br /><input type="textarea" name="opis" id="opis" placeholder="Brak"><br>';
	// echo '<br /><input type="submit" value="Dodaj!">';
	// echo '</form>';

	// echo '</div>';

	$sql='SELECT * FROM towar'; 
	
	if(isset($_SESSION['info']))
		{
			echo $_SESSION['info'];
		}unset($_SESSION['info']);
	
	if($result = $conn->query($sql))
	{ 
		$ilosc = $result->num_rows;
		echo '<h2>Lista towarów</h2>';
			
		echo '<br />Ilość pozycji: '.$ilosc;
		
		if($ilosc)
		{	
			$lp=1;
			
				
				$sql="SELECT m.id_magazynu,m.nazwa FROM  magazyny as m, dostep as d WHERE m.id_magazynu=d.id_magazynu AND d.id_uzytkownika=".$_SESSION['id'];
				
				echo '<form id="towar" action="include/dodajtowardomagazynu.php" method="post">';
				echo 'Magazyn: <select name="magazyn" id="magazyn">';
				echo '<option selected value="-1"></option>';
				if($result2 = $conn->query($sql))
				{
					while($row2 = $result2->fetch_assoc()) if($row2['id_magazynu']!=$idmag)echo '<option value="'.$row2['id_magazynu'].'">'.$row2['nazwa'].'</option>';
					
				}else
				{
					 echo '<option value="error">error</option>';
				}
				
				echo '</select><br />';
				
				echo '<input type="submit" value="dodaj!">';		
			
			echo '<table><tr><td>Lp.</td><td>kod produktu</td><td>numer seryjny</td><td>nazwa</td><td>data ważnosci</td><td>data wprowadzenia</td><td>cena netto</td><td>cena brutto</td><td>opis</td><td></td><td></td><td>zaznacz</td><td>ile</td></tr>';
				while($row = $result->fetch_assoc())
				{
					echo '<tr><td>'.$lp.'</td><td>'.$row['kod_produktu'].'</td><td>'.$row['nr_seryjny'].'</td><td>'.$row['nazwa'].'</td><td>'.$row['data_waznosci'].'</td><td>'.$row['data_wprowadzenia'].'</td><td>'.$row['cena_netto'].'</td><td>'.$row['cena_brutto'].'</td><td>'.$row['opis'].'</td><td><a href="include/edytujtowar.php?idtowar='.$row['id_towaru'].'" >Edytuj</a></td><td><a href="include/dodajusuntowar.php?idtowar='.$row['id_towaru'].'">Usuń</a></td><td><input type="checkbox" name="towarid[]" class="towarid" value="'.$row['id_towaru'].'"> </td><td><input type="number" name="ile'.$row['id_towaru'].'" min=0></td></tr>';
					$lp++;	
				}
				echo '</table>';
				echo '<input type="submit" value="dodaj!"></form>';
			}else
			{ 
				echo '<br />brak towaru';
			}
	}

$conn->close();

?>
