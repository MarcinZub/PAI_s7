<?php
session_start();

if(!isset($_SESSION['logged']))
{
	header('location: ../index.php');
	exit();
}
require '../function.php';

Get_head_out();

Get_menu_out();

if (isset($_GET['idmag'])) 
{
	require_once '../connection.php';
	
	$idmag = $_GET['idmag'];
		
	$sql = "SELECT t.id_towaru, t.kod_produktu, t.nr_seryjny, t.nazwa, t.data_waznosci, t.data_wprowadzenia, t.cena_netto, t.cena_brutto, p.ilosc, t.opis FROM towar as t, pozycja as p WHERE t.id_towaru=p.id_towaru AND p.id_magazynu=$idmag";

	if($result = $conn->query($sql))
	{
		if(isset($_SESSION['info']))
			{
				echo $_SESSION['info'];
			}unset($_SESSION['info']);
			
		$ilosc = $result->num_rows;
		echo '<h1>Lista towaru w magazynie</h1>';
		
		echo '<br />Ilość pozycji: '.$ilosc.'<br /><br />';
		if($ilosc)
		{		
			if((isset($_SESSION['idtowaru'])) && (isset($_SESSION['idmagazynu'])) && (isset($_SESSION['iletowaru'])))
			{
				$idtowaru=$_SESSION['idtowaru'];
				$idmagazynu=$_SESSION['idmagazynu'];
				$iletowaru=$_SESSION['iletowaru'];
		
				$ile=count($idtowaru);
				$bool=true;				
			}
			
			$lp=1;
			if((isset($_GET['kupno']))&&($_GET['kupno']==0))
			{
				echo '<a href="zawartosc.php?idmag='.$idmag.'&kupno=1"><input type="button" value="Kupno"/></a>';
				$_SESSION['kupno']=0;
				echo '<form id="koszyk" action="przenies.php" method="post">';
				
				$sql="SELECT m.id_magazynu,m.nazwa FROM  magazyny as m, dostep as d WHERE m.id_magazynu=d.id_magazynu AND d.id_uzytkownika=".$_SESSION['id'];
				
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
				
				echo '<input type="submit" value="przenies!">';			
			}
			else
			{
				echo '<a href="zawartosc.php?idmag='.$idmag.'&kupno=0"><input type="button" value="Przeniesienie"/></a>';
				$_SESSION['kupno']=1;
				echo '<form id="koszyk" action="dokoszyka.php" method="post">';
				echo '<input type="submit" value="dodaj do koszyka!">';
			}
			
			echo '<input type="hidden" name="idmag" value="'.$idmag.'">';
			echo '<table><tr><td>Lp.</td><td>kod produktu</td><td>numer seryjny</td><td>nazwa</td><td>data ważnosci</td><td>data wprowadzenia</td><td>cena netto</td><td>cena brutto</td><td>ilosc</td><td>opis</td><td>zaznacz</td><td>ile</td><td></td></tr>';
			
			while($row = $result->fetch_assoc())
			{
				if($bool)
				{
					foreach($idtowaru as $key=>$value)
					{
					if( ($idmagazynu[$key]==$idmag) && ($value==$row['id_towaru']) ) $row['ilosc']-=$iletowaru[$key];
					}
				}
				
				echo '<tr><td>'.$lp.'</td><td>'.$row['kod_produktu'].'</td><td>'.$row['nr_seryjny'].'</td><td>'.$row['nazwa'].'</td><td>'.$row['data_waznosci'].'</td><td>'.$row['data_wprowadzenia'].'</td><td>'.$row['cena_netto'].'</td><td>'.$row['cena_brutto'].'</td><td>'.$row['ilosc'].'</td><td>'.$row['opis'].'</td><td><input type="checkbox" name="koszyk[]" class="koszyk" value="'.$row['id_towaru'].'"> </td><td><input type="number" name="ile'.$row['id_towaru'].'" min=0 max='.$row['ilosc'].'></td><td><a href="usunzawartosc.php?idtowar='.$row['id_towaru'].'&idmag='.$idmag.'">Usuń</a></td></tr>';
				$lp++;	
			}			
			echo '</table><input type="submit" value="';
			
			if($_SESSION['kupno']) echo "dodaj do koszyka!";
			else echo 'przenies!';
			
			echo '"></form>';
		}else
		{ 
			echo '<br />brak towaru';
		}		
	}
	else
	{
		echo 'ERROR';
	}
}
else
{
	header('Location: ../index.php');
	exit();
}

$conn->close();

Get_footer_out()
?>