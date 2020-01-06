<?php 
session_start();
if((!isset($_SESSION['logged']))&&($_SESSION['rola']==2))
{
	header('location: ../index.php');
	exit();
}
	require '../function.php';

	Get_head_out();

	Get_menu_out();

	require_once "../connection.php";

	$id_mag = (isset($_GET['idmag'])) ? $_GET['idmag'] : 0;

	$sql='SELECT * FROM magazyny WHERE id_magazynu='.$id_mag;
	if(($id_mag>0)&&($result = $conn->query($sql)))
	{ 
	
		$row = $result->fetch_assoc();
		
		echo '<h2>Edycja magazynu</h2>';
		echo '<div class="formularz">';
		echo '<form id="fromedycja" action="zapiszedycjemagazynu.php" method="post">';
		echo '<input type="hidden" name="idmag" value='.$row['id_magazynu'].'>';
		echo '<div class="form_edit_mag">Nazwa: <input type="text" id="nazwa" name="nazwa" placeholder="Nazwa" value='.$row['nazwa'].'></div>';
		echo '<div class="form_edit_mag">Region: <select name="region" id="region" >';
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
		echo '<div class="form_edit_mag">Opis: <input type="textarea" id="opis" name="opis" placeholder="Brak" value='.$row['opis'].'></div>';
		echo '<br /><br /><input type="submit" value="Edytuj!">';
		echo '</form>';
		echo '</div>';
		
		if(isset($_SESSION['info'])) echo $_SESSION['info'];
		else unset($_SESSION['info']);
	}

$conn->close();

Get_footer();
?>

