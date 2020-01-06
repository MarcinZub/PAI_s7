<?php
session_start();
if((!isset($_SESSION['logged']))&&($_SESSION['rola']!=0))
{
	header('location: ../index.php');
	exit();
}

require_once "connection.php";

if($_SESSION['rola']!=2)
{
	echo '<h2>Dodaj magazyn</h2>';
	
	echo '<div class="formularz">';
	Dodajmagazyn();
	echo '</div>';
	
	#$sql='SELECT * FROM  magazyny'; 
	$sql="SELECT m.id_magazynu, m.nazwa, m.region, m.data_zalozenia, m.opis FROM  magazyny as m, dostep as d WHERE m.id_magazynu=d.id_magazynu AND d.id_uzytkownika=".$_SESSION['id'];
		
	if($result = $conn->query($sql))
	{ 
			$ilosc = $result->num_rows;
			echo '<h2>Lista magazynów</h2>';
			
			if(isset($_SESSION['info']))
			{
				echo $_SESSION['info'];
			}unset($_SESSION['info']);
			
			echo '<br />Ilość magazynów: '.$ilosc;
			if($ilosc)
			{	
				$lp=1;
				echo '<table><tr><td>Lp.</td><td>id magazynu</td><td>Nazwa magazynu</td><td>Region</td><td>data założenia</td><td>opis</td><td></td><td></td><td></td></tr>';
				while($row = $result->fetch_assoc())
				{
					echo '<tr><td>'.$lp.'</td><td>'.$row['id_magazynu'].'</td><td>'.$row['nazwa'].'</td><td>'.$row['region'].'</td><td>'.$row['data_zalozenia'].'</td><td>'.$row['opis'].'</td><td><a href="include/edytujmagazyn.php?idmag='.$row['id_magazynu'].'">Edytuj</a></td><td><a href="include/dodajusunmagazyn.php?idmag='.$row['id_magazynu'].'">Usuń</a></td><td><a href="include/zawartosc.php?idmag='.$row['id_magazynu'].'">Zobacz zawartość</a></td></tr>';
					$lp++;	
				}
				echo '</table>';
			}else
			{ 
				echo '<br />brak magazynów';
			}
	}
}

$conn->close();

?>