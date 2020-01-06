<?php 
session_start();
if((!isset($_SESSION['logged'])) && ($_SESSION['rola']==2))
{
	header('location: ../index.php');
	exit();
}
require '../function.php';

Get_head_out();

Get_menu_out();


	if((!isset($_SESSION['idtowaru'])) || (!isset($_SESSION['idmagazynu'])) || (!isset($_SESSION['iletowaru'])) || (count($_SESSION['idtowaru']) == 0) )
	{
		header('location: ../index.php?page=4');
		exit(); 
	}else
	{	
		$idtowaru=$_SESSION['idtowaru'];
		$idmagazynu=$_SESSION['idmagazynu'];
		$iletowaru=$_SESSION['iletowaru'];
		
		$ile=count($idtowaru);
		
		require_once '../connection.php';
				
		echo "<div id='wynik'></div>";
		
		if(isset($_SESSION['info']))
			{
				echo $_SESSION['info'];
			}unset($_SESSION['info']);

		echo '<h2>Płatności</h2>';
		
		echo '<table><tr><td>Lp.</td><td>kod produktu</td><td>numer seryjny</td><td>nazwa</td><td>data ważnosci</td><td>magazyn</td><td>cena netto (szt.)</td><td>cena brutto (szt.)</td><td>opis</td><td>ile</td><td>suma netto</td><td>suma brutto</td></tr>';
		
		$sumaN=0;
		$sumaB=0;
		
		for($i=0;$i<$ile;$i++)
		{			
			$sql = "SELECT t.id_towaru, t.kod_produktu, t.nr_seryjny, t.nazwa, t.data_waznosci, t.data_wprowadzenia, t.cena_netto, t.cena_brutto, p.ilosc, t.opis, m.nazwa as nazwamag FROM towar as t, pozycja as p, magazyny as m WHERE t.id_towaru=p.id_towaru AND p.id_magazynu=m.id_magazynu AND p.id_magazynu=$idmagazynu[$i] AND p.id_towaru=$idtowaru[$i]";

			if($result = $conn->query($sql))
			{
				$row = $result->fetch_assoc();
					
				$suma_netto=$row['cena_netto']*$iletowaru[$i];
				$suma_brutto=$row['cena_brutto']*$iletowaru[$i];
				$sumaN+=$suma_netto;
				$sumaB+=$suma_brutto;	
					
				echo '<tr><td>'.($i+1).'</td><td>'.$row['kod_produktu'].'</td><td>'.$row['nr_seryjny'].'</td><td>'.$row['nazwa'].'</td><td>'.$row['data_waznosci'].'</td><td>'.$row['nazwamag'].'</td><td>'.$row['cena_netto'].'</td><td>'.$row['cena_brutto'].'</td><td>'.$row['opis'].'</td><td>'.$iletowaru[$i].'</td><td>'.$suma_netto.'</td><td>'.$suma_brutto.'</td></tr>';	
					
			}else{echo 'error';}
		}
		
		if($i!=1)echo"<tr><td></td><td> </td><td> </td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td>$sumaN</td><td>$sumaB</td></tr>";
			
		echo '</table><br>';
		
		echo "do zapłaty: $sumaB PLN Brutto <br>";
		
		echo 'dane klienta:<br />';
		echo '<form action="wykonajkupno.php" method="post">';
		echo '<input type="hidden" name="sumaB" value="$sumaB" >';
		echo 'imie: <input type="text" name="imie" required/> <br />';
		echo 'nazwisko: <input type="text" name="nazwisko" required/><br />';
		echo '<input type="submit" value="potwierdzenie zakupu"/>';
		echo '</form><br /><br />';

		$_SESSION['suma_kupna'] = $sumaB;
		$conn->close();
	}

Get_footer();
?>