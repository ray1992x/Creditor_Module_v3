<?php
require(dirname(dirname(__FILE__)) . '../fpdf/fpdf.php');
require(dirname(dirname(__FILE__)) . '../fpdf/mysql_table.php');
require(dirname(dirname(__FILE__)) . '../fpdf/cellfit.php');
include(dirname(dirname(__FILE__)) . "../DatabaseConnect.php");

class PDF extends PDF_MYSQL_TABLE
{
function Header()
{
	$this->SetFont('Arial','B',18);
	$this->Cell(0,6,'Creditor Node',0,1,'C');
	$this->Ln(10);
	parent::Header();
}
}

$downloadfilename = "Credit_Note.pdf";
$query = "SELECT CNnumber,BatchNumber,SequenceNumber,CreditorCode, CreditNoteAmount,CreditNoteDate,CreditNoteDesc FROM CreditNote ORDER BY CNnumber";
$pdf= new PDF();
$pdf->AddPage('L');

$prop=array('HeaderColor'=>array(112,128,144),
            'color1'=>array(255,255,255),
            'color2'=>array(198,226,255),
            'padding'=>2);
$pdf->AddCol('CNumber',30,'No.');
$pdf->AddCol('BatchNumber',30,'Batch Number');
$pdf->AddCol('SequenceNumber',20,'Sequence Number');
$pdf->AddCol('CreditorCode',30,'Creditor Code');
$pdf->AddCol('CreditNoteAmount',30,' Amount');
$pdf->AddCol('CreditNoteDate',40,'Date');
$pdf->AddCol('CreditNoteDesc',100,200,'Description');

$pdf->Table($query,$prop);





$pdf->Output($downloadfilename); 
header('Location: '.$downloadfilename);

/*, `CreditNoteAmount`, `CreditNoteDate`, `CreditNoteDesc`*/
?>