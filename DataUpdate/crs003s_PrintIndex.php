<!DOCTYPE html>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Creditor Module</title>

	<link rel="shortcut icon" href="../img/icon.ico">
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../bootstrap/css/logo-nav.css" rel="stylesheet">
	
    <script src="../bootstrap/js/jquery.js"></script>
    <script src="../bootstrap/js/bootstrap.min.js"></script>
</head>
<body>
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
		</div>
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav">
				<li>
					<a href="../index.php">Home</a>
				</li>
				<li>
					<a href="../Help.php">Help</a>
				</li>
				<li>
					<a href="../About.php">About</a>
				</li>
			</ul>
		</div>
	</div>
</nav>
<table height="100">
</table>
<div class="container">
<table>
<form id="form" name="form" method="post" ">
<td width="200">
Input Purchase Order Number
<tr>
</td>
<td width ="250">
<label><input type="text" placeholder="Enter PO Number" name="PO_Number" id="PO_Number" value=""></label>
</td>
</tr>
<tr>
<td>
<label><button name="Print" value="Print"   class="btn btn-default" /><span class="glyphicon glyphicon-print"></span> Print</button></label>
</td>				
</tr>

</form>
</table>
</div>

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
			$this->Cell(155, 10, 'Date: '.date('d-m-Y').'', 0,0,'R');
			$this->Ln(15);
			$this->SetFont('Arial', 'B', 20);
			$this->Cell(45, 8, '', 0);
			$this->Cell(100, 8, 'Purchase Order Item', 0,0,'C');
			$this->Ln(10);
			$this->SetFont('Arial', 'B', 12);
			$this->Cell(30, 8, 'Purchase Order Number ', 0,0,'');
			$this->Ln(10);
			$this->SetFillColor(232,232,232);
			$this->SetFont('Arial', 'B', 12);
			$this->SetFillColor(232,232,232);
			$this->Cell(30, 8, 'ID', 0,0,'',true);
			$this->Cell(30, 8, 'Quantity', 0,0,'',true);
			$this->Cell(50, 8, 'Unit Price', 0,0,'',true);
			$this->Cell(50, 8, 'Total Price', 0,0,'',true);
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
	
	$downloadfilename = "PO_Item_Report.pdf";
	
if(isset($_POST['Print']))
{
	
$PO_Number = strip_tags($_POST['PO_Number']);
		$pdf= new PDF();
		$pdf->AliasNbPages();
		$pdf->AddPage();
		$pdf->SetFont('Arial', '', 12);
		$result = mysql_query("SELECT * FROM podetailtable WHERE POTemp = '".$PO_Number."'");
		$item = 0;

		while($row = mysql_fetch_array($result)){
			$item = $item+1;
			$pdf->SetFillColor(232,232,232);
			$pdf->Cell(30, 8, $row['itemid'], 0,0,'',true);
			$pdf->Cell(30, 8, $row['booktitle'], 0,0,'');
			$pdf->Cell(50, 8, $row['author'], 0,0,'');
			$pdf->Cell(50, 8, $row['price'], 0,0,'');
			$pdf->Ln(8);
		}
		$pdf->SetFont('Arial', 'B', 8);
		$pdf->Cell(114,8,'',0);

		
		$pdf->Output($downloadfilename); 
		echo "<script>window.open('../web/viewer.html?file=../DataUpdate/".$downloadfilename."#zoom=100','_blank_','menubar=0');</script>";
		//header('Location: '."../web/viewer.html?file=../DataUpdate/$downloadfilename#zoom=100");
	
}
?>
</body>
</html>