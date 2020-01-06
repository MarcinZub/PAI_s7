<?php 
session_start();
if((!isset($_SESSION['logged'])) && ($_SESSION['rola']==2))
{
	header('location: ../index.php');
	exit();
}

	if((!isset($_POST['imie'])) || (!isset($_POST['nazwisko'])))
	{
		header('location: ../index.php');
		exit(); 
	}else
	{	
		$idtowaru=$_SESSION['idtowaru'];
		$idmagazynu=$_SESSION['idmagazynu'];
		$iletowaru=$_SESSION['iletowaru'];
		$imie=$_POST['imie'];
		$nazwisko=$_POST['nazwisko'];
		$suma = $_POST['sumaB'];
		$data=date("Y-m-d H:i:s");
		$ile=count($idtowaru);
		$imie_kupno = $imie;
		$nazwisko_kupno = $nazwisko;

		require_once '../connection.php';
		
		$bool=1;
		
		while($bool)
		{
			$sql="SELECT id_klienta FROM klienci WHERE imie=$imie AND nazwisko=$nazwisko";
				
			if($result = $conn->query($sql))
			{
				$ilosc = $result->num_rows;
				
				if($ilosc=!0)
				{
					$row = $result->fetch_assoc();
					$id_klienta=$row['id_klienta'];
					$bool=0;
				}else
				{				
					$sql = "INSERT INTO klienci (id_klienta, imie, nazwisko, data_wprowadzenia, opis) VALUES(NULL, '$imie', '$nazwisko','$data', '')";
					if(!($result = $conn->query($sql)))
					{
						$bool=0;
					}
				}
						
			}else $bool=0;	
		}
		
		for($i=0;$i<$ile;$i++)
		{			
	
			$sql ="INSERT INTO kupione (id_zakupu, id_towaru, id_magazynu, id_klienta, id_uzytkownika, ilosc, data_zakupu) VALUES (NULL, '$idtowaru[$i]', '$idmagazynu[$i]', '$id_klienta', '".$_SESSION['id']."','$iletowaru[$i]', '$data' )";
			
			$result = $conn->query($sql);
			
			$sql = "SELECT ilosc FROM pozycja WHERE id_magazynu=$idmagazynu[$i] AND id_towaru=$idtowaru[$i]";

			if($result = $conn->query($sql))
			{
				$row = $result->fetch_assoc();
					
				$row['ilosc']-=$iletowaru[$i];
				
				$sql = "UPDATE pozycja SET ilosc='".$row['ilosc']."' WHERE id_magazynu=$idmagazynu[$i] AND id_towaru=$idtowaru[$i]";
				
				$result = $conn->query($sql);
					
			}
		}
		$_SESSION['info'] = '<span style="color:green">towar został zakupiony </span>';


		$sql = "SELECT kod_produktu, nr_seryjny, nazwa, data_waznosci, cena_brutto FROM towar WHERE id_towaru = $idtowaru";

		if($result = $conn->query($sql)){
			$row = $result->fetch_assoc();

			$kod_produktu = $row['kod_produktu'];
			$nr_seryjny = $row['nr_seryjny'];
			$nazwa = $row['nazwa'];
			$data_waznosci = $row['data_warznosci'];
			$cena_brutto = $row['cena_brutto'];

		}
		
		unset($_SESSION['iletowaru']);
		unset($_SESSION['idmagazynu']);
		unset($_SESSION['idtowaru']);

		$conn->close();
	}

	header('location: ../index.php?page=4');
	exit();
?>