<?php 
session_start();
if((!isset($_SESSION['logged']))&&($_SESSION['rola']==2))
{
	header('location: ../index.php');
	exit();
}
require_once '../function.php';

Get_head_out();

Get_menu_out();

require_once "../connection.php";

	
	$idtowar = (isset($_GET['idtowar'])) ? $_GET['idtowar'] : 0;

	$sql='SELECT * FROM towar WHERE id_towaru='.$idtowar;
	if(($idtowar>0)&&($result = $conn->query($sql)))
	{ 
	
		$row = $result->fetch_assoc();
		
		echo '<h2>Edycja towaru</h2>';
		
		echo '<div class=formularz>';

		echo '<form id="fromedycja" action="zapiszedycjetowaru.php" method="post">';
		echo '<input type="hidden" name="idtowar" value="'.$row['id_towaru'].'">';
		
		echo '<div class="form_edit_towar">Kod Produktu: <br /><input type="test" id="kod_produktu" name="kod_produktu" placeholder="kod produktu" value="'.$row['kod_produktu'].'"></div>';
		echo '<div class="form_edit_towar">Numer Seryjny: <br /><input type="text" id="nr_seryjny" name="nr_seryjny" placeholder="numer seryjny" value="'.$row['nr_seryjny'].'"></div>';
		echo '<div class="form_edit_towar">Nazwa: <br /><input type="text" id="nazwa" name="nazwa" placeholder="Nazwa" value="'.$row['nazwa'].'"></div>';
		echo '<div class="form_edit_towar">Data waznosci: <br /><input type="date" id="data_waznosci" name="data_waznosci" value="'.substr($row['data_waznosci'], 0, 10).'"></div>';
		echo '<div class="form_edit_towar">Cena netto: <br /><input  type="number" step="0.01" min="0" id="cena_netto" name="cena_netto" value="'.$row['cena_netto'].'"></div>';
		echo '<div class="form_edit_towar">Cena brutto: <br /><input type=number step="0.01" min="0" id="cena_brutto" name="cena_brutto" value="'.$row['cena_brutto'].'"></div>';	
		echo '<div class="form_edit_towar">Opis: <br /><input type="textarea" id="opis" name="opis" placeholder="Brak" value='.$row['opis'].'></div>';
		echo '<div class="form_edit_towar"><input type="submit" value="Edytuj!"></div>';
		echo '</form>';
		echo '</div>';
		
		if(isset($_SESSION['info'])) echo $_SESSION['info'];
		else unset($_SESSION['info']);
	}

$conn->close();

Get_footer();
?>