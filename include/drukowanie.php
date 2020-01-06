<?php
session_start();
if((!isset($_SESSION['logged'])) && ($_SESSION['rola']==2))
{
	header('location: ../index.php');
	exit();
}

//-----------FUNKCJA-----------
function do_wydruku($sum, $idtowaru){
	$ile=count($idtowaru);

	require_once '../connection.php';
	
	for($i=0; $i<$ile; $i++){

		$sql = "SELECT kod_produktu, nr_seryjny, nazwa, data_waznosci, cena_brutto FROM towar WHERE id_towaru = $idtowaru[$i]";

		$wyjscie = '';

		if($result = $conn->query($sql)){

			$row = $result->fetch_assoc();

			$wyjscie .= '
			<tr>
				<td>'.$row["kod_produktu"].'</td>
				<td>'.$row["nr_seryjny"].'</td>
				<td>'.$row["nazwa"].'</td>
				<td>'.$row["data_waznosci"].'</td>
				<td>'.$row["cena_brutto"].'</td>
			</tr>
			';

		}
		else{
			echo 'error';
		}
	}

	$wyjscie .= 'Suma: '.$sum.' zł';

	return $wyjscie;
}
//-----------FUNKCJA-----------

if((!isset($_POST['imie'])) || (!isset($_POST['nazwisko'])) || (!isset($_POST['suma']))){
	header('location: ../index.php');
	exit(); 
}
else{
	$data = date('d-m-Y');
	$imie = $_POST['imie'];
	$nazwisko = $_POST['nazwisko'];
	$suma = $_SESSION['suma_kupna'];

	$idtowaru=$_SESSION['idtowaru'];
	$idmagazynu=$_SESSION['idmagazynu'];
	$iletowaru=$_SESSION['iletowaru'];

	require_once('../TCPDF-master/tcpdf.php');
	ob_start();
	
	$obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'iso-8859-2', false);
	$obj_pdf->SetCreator(PDF_CREATOR);
	$obj_pdf->SetTitle("Paragon");

	$obj_pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);

	$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
	$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

	$obj_pdf->SetDefaultMonospacedFont('freesans');

	$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
	$obj_pdf->SetMargins(PDF_MARGIN_LEFT, '5', PDF_MARGIN_RIGHT);

	$obj_pdf->setPrintHeader(false);
	$obj_pdf->setPrintFooter(false);

	$obj_pdf->SetAutoPageBreak(TRUE, 10);
	$obj_pdf->SetFont('freesans', '', 12);

	$obj_pdf->AddPage();

	$zawartosc = '';
	$zawartosc .='
	<p style="text-align:right;">Data wydania: '.$data.'</p>
	<p style="text-align:right;">Imie i nazwisko: '.$imie.' '.$nazwisko.'</p>
	<h3 style="text-align:center;">Paragon </h3>
	<table>
		<tr>
			<td>Kod produktu</td>
			<td>Nr. ser.</td>
			<td>Nazwa</td>
			<td>Data ważności</td>
			<td>Cena</td>
		</tr>
	
	';
	
	$zawartosc .= do_wydruku($suma, $idtowaru);
	$zawartosc .= '</table>';

	$obj_pdf->writeHTML($zawartosc, true, false, false, false, '');
	ob_end_clean();
	$obj_pdf->Output('test.pdf', 'I');


}

unset($_SESSION['iletowaru']);
unset($_SESSION['idmagazynu']);
unset($_SESSION['idtowaru']);

?>