<?php 
session_start();
if((!isset($_SESSION['logged'])) && ($_SESSION['rola']==2))
{
	header('location: ../index.php');
	exit();
}

if((!isset($_POST['idmag'])) || (!isset($_POST['koszyk']))){
	$_SESSION['info'] = '<span style="color:red">nie wybrano towaru!</span>';
	header('Location: zawartosc.php?idmag='.$_POST['idmag'].'&kupno=1');
	exit();
}
else{
	$idmag = $_POST['idmag'];

	$ile =0;

	$idtowaru= array();
	$idmagazunu=array();
	$iletowaru=array();
	$bool=false;
	if((isset($_SESSION['idtowaru'])) && (isset($_SESSION['idmagazynu'])) && (isset($_SESSION['iletowaru'])))
	{
		$idtowaru=$_SESSION['idtowaru'];
		$idmagazynu=$_SESSION['idmagazynu'];
		$iletowaru=$_SESSION['iletowaru'];
		
		$ile=count($idtowaru);
		$bool=true;	
	}
	
	if($bool)
	{
		foreach($_POST['koszyk'] as $id)
		{
			$ilosc=$_POST['ile'.$id];
			if($ilosc)
			{
				$bool2=true;
				foreach($idtowaru as $key=>$value)
				{
					if(($value==$id)&&($idmagazynu[$key]==$idmag))
					{
						$iletowaru[$key]+=$ilosc;
						$bool2=false;
					}
				}
				
				if($bool2)
				{
				$idtowaru[$ile]=$id;		
				$idmagazynu[$ile]=$idmag;
				$iletowaru[$ile]=$ilosc;
				
				$ile++;
				}
			}
		}		
	}else
	{
		foreach($_POST['koszyk'] as $id)
		{
			$ilosc=$_POST['ile'.$id];
			if($ilosc)
			{
				$idtowaru[$ile]=$id;
				$idmagazynu[$ile]=$idmag;
				$iletowaru[$ile]=$ilosc;
				
				$ile++;
			}
		}
	}
	
	$_SESSION['idtowaru']=$idtowaru;
	$_SESSION['idmagazynu']=$idmagazynu;
	$_SESSION['iletowaru']=$iletowaru;
	
	//unset($_SESSION['idtowaru']);
	//unset($_SESSION['idmagazunu']);
	//unset($_SESSION['iletowaru']);

}
$_SESSION['info'] = '<span style="color:green">Towar zosał dodany!</span>';
header('Location: zawartosc.php?idmag='.$idmag.'&kupno=1');
?>