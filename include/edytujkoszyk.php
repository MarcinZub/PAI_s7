<?php
session_start();

if((!isset($_SESSION['logged']))&&($_SESSION['rola']==2))
{
	header('location: ../index.php');
	exit();
}

if (isset($_GET['idt'])) 
{
	$id=$_GET['idt'];
	$iletowaru=$_SESSION['iletowaru'];
	$idmag=$_SESSION['idmagazynu'];
	$idtowaru=$_SESSION['idtowaru'];
	$idtowaru2=array();
	$idmag2=array();
	$iletowaru2=array();
	$i=0;

	foreach($idtowaru as $key=>$value)
	{
		if($key!=$id)
		{
			echo"przepisanie ";
			$idtowaru2[$i]=$value;
			$idmag2[$i]=$idmag[$key];
			$iletowaru2[$i]=$iletowaru[$key];
			$i++;
		}
	}
	
	if(count($iletowaru2)==0)
	{
		unset($_SESSION['iletowaru']);
		unset($_SESSION['idmagazynu']);
		unset($_SESSION['idtowaru']);
	}else
	{
		$_SESSION['iletowaru']=$iletowaru2;
		$_SESSION['idmagazynu']=$idmag2;
		$_SESSION['idtowaru']=$idtowaru2;
	}
	
	header('location: ../index.php?page=4');
	exit(); 
}
else if( (isset($_POST['id'])) && (isset($_POST['ile'])) )
{
	require_once '../connection.php';			
	
	$id=$_POST['id'];
	$ile=$_POST['ile'];
	$iletowaru=$_SESSION['iletowaru'];
	$idmag=$_SESSION['idmagazynu'];
	$idtowaru=$_SESSION['idtowaru'];
	
	$sql = "SELECT ilosc FROM  pozycja WHERE id_magazynu=$idmag[$id] AND id_towaru=$idtowaru[$id]";
	
	if($result = $conn->query($sql))
	{
		$row = $result->fetch_assoc();
		
		if($row['ilosc']<$ile) 
		{
			$iletowaru[$id]=$row['ilosc'];
			echo '<p style="color:red;">maksymalna wartosc osiągnięta</p>';
		}else
		{			
			$iletowaru[$id]=$ile;
			echo "<p style='color:green;'>poprawnie zmieniono ilość na $iletowaru[$id]</p>";	
		}
	//echo"<br>sesja: $iletowaru[$id] id: $id ile: $ile update: $iletowaru[$id] <br>";
	$_SESSION['iletowaru']=$iletowaru;
	}else
	{
	echo 'ERROR';	
	}
	$conn->close();
	exit();  
}else
{
	header('Location: ../index.php');
	exit();
}

?>