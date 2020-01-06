<?php
session_start();
if((!isset($_SESSION['logged'])) && ($_SESSION['rola']==2)){	#Tylko dla zalogowanych!!!
	header('Location: ../index.php');
	exit();
}


if((!isset($_POST['idmag'])) || (!isset($_POST['magazyn'])) || ($_POST['magazyn']==-1) || (!isset($_POST['koszyk']))){

	$_SESSION['info'] = '<span style="color:red">nie wybrano towaru lub magazynu!</span>';

	header('Location: zawartosc.php?idmag='.$_POST['idmag'].'&kupno=0');
	exit();
}
else{

	$idmag=$_POST['idmag'];
	$idtowar=array();
	$ile=0;
		
	$magazyn=$_POST['magazyn'];
	
	foreach($_POST['koszyk'] as $id)
	{
		$idtowar[$ile]=$id;
		$ile++;
	}
	
	require_once "../connection.php";
	
	for($i=0;$i<$ile;$i++)
	{
		$id=$idtowar[$i];
		$ileid=$_POST['ile'.$id];

		$sql="SELECT ilosc FROM pozycja WHERE id_magazynu=$idmag AND id_towaru=$id";
		
		if($result = $conn->query($sql))
		{
			$row = $result->fetch_assoc();
			$row['ilosc']-=$ileid;
			
			$sql = "UPDATE pozycja SET ilosc=".$row['ilosc']." WHERE id_magazynu=$idmag AND id_towaru=$id";
			
			if($result = $conn->query($sql))
			{	
				$sql="SELECT ilosc FROM pozycja WHERE id_magazynu=$magazyn AND id_towaru=$id";

				if($result = $conn->query($sql))
				{
					$ilosc = $result->num_rows;
					if($ilosc)
					{
						$row = $result->fetch_assoc();
						$ileid+=$row['ilosc'];
						
						$sql = "UPDATE pozycja SET ilosc=$ileid WHERE id_magazynu=$magazyn AND id_towaru=$id";	
					}else
					{
						$date=date("Y-m-d H:i:s");
						
						$sql="INSERT INTO pozycja (id_pozycji, id_magazynu, id_towaru, ilosc, data_wprowadzenia, opis) VALUES (NULL, '$magazyn', '$id', '$ileid', '$date', '')";
					}
				}

				if($result = $conn->query($sql))
				{
					$_SESSION['info'] = '<span style="color:green">Dane towaru zostały przeniesiony! </span>';
				}
				else
				{
					$_SESSION['info'] = '<span style="color:red">Nie udało się przeniesc  towaru!</span>';
					$conn->close();
					header('Location: zawartosc.php?idmag='.$idmag.'&kupno=0');
					exit();
				}
			}
		}
	}
}

$conn->close();
header('Location: zawartosc.php?idmag='.$idmag.'&kupno=0');
?>
