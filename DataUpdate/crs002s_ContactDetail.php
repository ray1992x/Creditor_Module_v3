<?php
require('../DatabaseConnect.php');
require('../fpdf/mysql_table.php');


class PDF extends PDF_MYSQL_TABLE
{
	function Header()
	{
		$this->SetFont('Arial', '', 10);
		//$this->Image('../img/logo.gif' , 10 ,8, 30 , 30,'GIF');
		$this->Cell(18, 10, '', 0);
		$this->SetFont('Arial', '', 9);
		$this->Cell(250, 10, 'Date: '.date('d-m-Y').'', 0,0,'R');
		$this->Ln(15);
		$this->SetFont('Arial', 'B', 20);
		$this->Cell(45, 8, '', 0);
		$this->Cell(200, 8, 'Contact Detail', 0,0,'C');
		$this->Ln(20);
		$this->SetFillColor(232,232,232);
		$this->SetFont('Arial', 'B', 10);
		$this->SetFillColor(232,232,232);
		$this->Cell(15, 8, 'No.', 0,0,'',true);
		$this->Cell(20, 8, 'Code', 0,0,'',true);
		$this->Cell(30, 8, 'Name', 0,0,'',true);
		$this->Cell(40, 8, 'Address', 0,0,'',true);
		$this->Cell(30, 8, 'Contact Name', 0,0,'',true);
		$this->Cell(30, 8, 'Telephone1', 0,0,'',true);
		$this->Cell(30, 8, 'Fax', 0,0,'',true);
		$this->Cell(50, 8, 'Telephone2', 0,0,'',true);
		$this->Cell(30, 8, 'Email', 0,0,'',true);
		$this->Ln(8);
		parent::Header();
	}
	function Footer()
	{
			$this->SetY(-15);
			// Arial italic 8
			$this->SetFont('Arial','I',8);
			// Page number
			$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
	}
}

$pdf= new PDF();
$pdf->AliasNbPages();
$pdf->addPage('L');
$pdf->SetFont('Arial', '', 10);
$result = mysql_query("SELECT CreditorCode, CreditorName, Address, ContactName, Telephone1, Fax, Telephone2, Email FROM purchase ORDER BY POTemp");
$item = 0;

while($row = mysql_fetch_array($result)){
	$item = $item+1;
	$pdf->SetFillColor(232,232,232);
	$pdf->Cell(15, 8, $item, 0,0,'',true);
	$pdf->Cell(20, 8, $row['CreditorCode'], 0,0,'');
	$pdf->Cell(30, 8, $row['CreditorName'], 0,0,'');
	$pdf->Cell(40, 8, $row['Address'], 0,0,'');
	$pdf->Cell(30, 8, $row['ContactName'], 0,0,'');
	$pdf->Cell(30, 8, $row['Telephone1'], 0,0,'');
	$pdf->Cell(30, 8, $row['Fax'], 0,0,'');
	$pdf->Cell(30, 8, $row['Telephone2'], 0,0,'');
	$pdf->Cell(30, 8, $row['Email'], 0,0,'');
	$pdf->Ln(8);
}
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(114,8,'',0);

$downloadfilename="Creditor_Contact_Detail.pdf";
$pdf->Output($downloadfilename); 
header('Location: '."../web/viewer.html?file=../DataUpdate/$downloadfilename#zoom=100");
?>