<?php
session_start();
if((!isset($_SESSION['logged'])) && ($_SESSION['rola']==2)){	#Tylko dla zalogowanych!!!
	header('Location: ../index.php');
	exit();
}


if((!isset($_POST['magazyn'])) || ($_POST['magazyn']==-1) || (!isset($_POST['towarid']))){

	$_SESSION['info'] = '<span style="color:red">nie wybrano towaru lub magazynu!</span>';

	header('Location: ../index.php?page=3');
	exit();
}
else{

	$idtowar=array();
	$ile=0;
		
	$magazyn=$_POST['magazyn'];
	
	foreach($_POST['towarid'] as $id)
	{
		$idtowar[$ile]=$id;
		$ile++;
	}
	
	require_once "../connection.php";
	
	for($i=0;$i<$ile;$i++)
	{
		$id=$idtowar[$i];
		$ileid=$_POST['ile'.$id];
		
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
			$_SESSION['info'] = '<span style="color:green">Towar poprawnie dodany </span>';
		}
		else
		{
			$_SESSION['info'] = '<span style="color:red">Nie udało się dodac  towaru do magazynu!</span>';
			$conn->close();
			header('Location: ../index.php?page=3');
			exit();
		}
	}
}

$conn->close();
header('Location: ../index.php?page=3');
?>
