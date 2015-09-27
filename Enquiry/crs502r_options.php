<!DOCTYPE html>
<?php
//require(dirname(dirname(__FILE__)) . '../fpdf/fpdf.php');
require(dirname(dirname(__FILE__)) . '../fpdf/mysql_table.php');
require(dirname(dirname(__FILE__)) . '../fpdf/cellfit.php');
include(dirname(dirname(__FILE__)) . "../DatabaseConnect.php");

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
		$this->Cell(100, 8, 'Creditor Transaction History', 0,0,'C');
		$this->Ln(20);
		$this->SetFillColor(232,232,232);
		$this->SetFont('Arial', 'B', 8);
		$this->SetFillColor(232,232,232);
		$this->Cell(25, 8, '', 0,0,'');
		$this->Cell(10, 8, 'No', 0,0,'',true);
		$this->Cell(20, 8, 'CR Code', 0,0,'',true);
		$this->Cell(20, 8, 'Date', 0,0,'',true);
		$this->Cell(20, 8, 'Trans. Type', 0,0,'',true);
		$this->Cell(20, 8, 'Bank Code', 0,0,'',true);
		$this->Cell(20, 8, 'Reference No.', 0,0,'',true);
		$this->Cell(20, 8, 'Amount', 0,0,'',true);
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


$CML_Range = "";
$CML_Zero = "";
$CR_Code_First = "";
$CR_Code_Last = "";

$CMLerr0 = "";
$CMLerr1 = "";
$CMLerr2 = "";
$CMLerr3 = "";

$downloadfilename = "Credit_Transaction.pdf";

if(isset($_POST['Print'])){
	if ($_SERVER['REQUEST_METHOD'] == 'POST'){
		
		if(empty($_POST['CML_Range'])){
			$CMLerr0 = "Missing";
		}else{
			$CML_Range = strip_tags($_POST['CML_Range']);
		}
		
		if(!empty($_POST['CML_Zero'])){
			$CML_Zero = strip_tags($_POST['CML_Zero']);
		}
		
		if(empty($_POST['CR_Code_First'])){
			$CMLerr2 = "Missing";
		}else{
			$CR_Code_First = strip_tags($_POST['CR_Code_First']);
		}
		
		if(empty($_POST['CR_Code_Last'])){
			$CMLerr3 = "Missing";
		}else{
			$CR_Code_Last = strip_tags($_POST['CR_Code_Last']);
		}
		
		
	}
	
	if(	(!empty($_POST['CML_Range']))
		){		
					
		
			if((empty($_POST['CR_Code_First'])) && $CML_Range=='range'){
				$CMLerr2 = "Missing";
			}else if((empty($_POST['CR_Code_Last'])) && $CML_Range=='range'){
				$CMLerr3 = "Missing";			
			}else{
				$_SESSION['CML_Range'] = $CML_Range;
				$_SESSION['CML_Zero'] = $CML_Zero;
				$_SESSION['CML_Code_First'] = $CR_Code_First;
				$_SESSION['CML_Code_Last'] = $CR_Code_Last;
				echo "<script>window.open('crs502r_view.php','view','menubar=0');</script>";
		}
		
	}
	
}

?>

<html>
<head>
	<base target="_self">
   
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Creditor Module</title>
	<link rel="shortcut icon" href="../img/icon.ico">

    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../bootstrap/css/logo-nav.css" rel="stylesheet">
	
    <script src="../bootstrap/js/jquery.js"></script>
    <script src="../bootstrap/js/bootstrap.min.js"></script>
	
	<script language="JavaScript">
	function all(){
		 document.getElementById('CR_Code_First').disabled=true;
		 document.getElementById('CR_Code_Last').disabled=true;
	}	
	function range(){
		 document.getElementById('CR_Code_First').disabled=false;
		 document.getElementById('CR_Code_Last').disabled=false;
	}	
	</script>

	
	
	<style type="text/css">
		div#footer {
			position:fixed;
			bottom:0;
			right:auto;
			left:auto;
			width:100%;
			height:40px;
			background-color:grey;
		}

		table#tb1 {
			border-collapse: collapse;
		}		

		td {
			padding: 6px;
		}

		table#tb1 td {
			border:2px solid black;
			align:center;
		}

		table#tb1 th {
			background-color:gray;
			color:black;
			border:2px solid black;
			padding: 6px;
		}

		div.table_config {
			float: center;
			background:#FFF;
			height:400px;
			width:100%;
			overflow:scroll;
			margin-left:auto;
			margin-right:auto;
		}
		
		table#tb2 td {
			border: 4px solid black;
			width:100%;
			background-color:#D8D8D8;
		}
	</style>
	
</head>
<body>
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
	<div class="container">
		
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			
		</div>
	</div>
</nav>	

<fieldset>
<legend><strong>Creditor Transaction History</strong></legend>
<table>
	<td><label><button class="btn btn-default" onclick="top.close();"><span class="glyphicon glyphicon-chevron-left"></span> Back </button></label></td>
	</table>
	<table>
		<form id="form" name="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			<tr>
			</tr>
			<!--<tr>
				<td>Print Destination</td>
				<td><p>
				<label><input type="radio" name="CTH_PrintDest" id="CTH_PrintDest" value="Screen" />Screen</label>
				<label><input type="radio" name="CTH_PrintDest" id="CTH_PrintDest" value="Printer"/>Printer</label>
				</p></td>
			</tr>-->
			<tr>
				<td>Print Range</td>
				<td>
				<label><input onclick="all()" type="radio" name="CML_Range" id="CML_Range" value="all" <?php if ($CML_Range=='all') { echo 'checked'; } ?> />All</label>
				<label><input onclick="range()" type="radio" name="CML_Range" id="CML_Range" value="range" <?php if ($CML_Range=='range') { echo 'checked'; } ?>/>Range</label>
				</td>
				<td><font color="red"><?php echo $CMLerr0 ;?></font></td>
			</tr>
			<!--
			<tr>
			<td></td><td><label><input type="checkbox" name="CML_Zero" id="CML_Zero" value="zero" <?php if ($CML_Zero=='zero') { echo 'checked'; } ?> />Include Zero</label></td>
			</tr>
			-->
				
			<tr>
				<td>First Creditor Code</td>
				<td>
				<label><input disabled="disabled" type="text" name="CR_Code_First" id="CR_Code_First" value="<?php echo $CR_Code_First;?>" /></label>
				</td>
				<td><font color="red"><?php echo $CMLerr2 ;?></font></td>
			</tr>
			<tr>
				<td>Last Creditor Code</td>
				<td>
				<label><input disabled="disabled" type="text" name="CR_Code_Last" id="CR_Code_Last" value="<?php echo $CR_Code_Last;?>"  /></label>
				</td>
				<td><font color="red"><?php echo $CMLerr3 ;?></font></td>
			</tr>

			<tr><td><label><button name="Print"  value="Print"  class="btn btn-default" /><span class="glyphicon glyphicon-eye-open"> View</button></label></td></tr>
		</form> 
	</table>
							  
</fieldset>

<div>

</div>

</body>
</html>
