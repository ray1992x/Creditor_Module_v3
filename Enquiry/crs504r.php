<!DOCTYPE html>
<?php
//require(dirname(dirname(__FILE__)) . '/fpdf/fpdf.php');
require(dirname(dirname(__FILE__)) . '/fpdf/mysql_table.php');
require(dirname(dirname(__FILE__)) . '/fpdf/cellfit.php');
include(dirname(dirname(__FILE__)) . "/DatabaseConnect.php");

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
		$this->Cell(100, 8, 'Unfilled Purchase Order', 0,0,'C');
		$this->Ln(20);
		$this->SetFillColor(232,232,232);
		$this->SetFont('Arial', 'B', 8);
		$this->SetFillColor(232,232,232);
		$this->Cell(20, 8, '', 0,0,'');
		$this->Cell(10, 8, 'No', 0,0,'',true);
		$this->Cell(20, 8, 'CR Code', 0,0,'',true);
		$this->Cell(20, 8, 'CR Name', 0,0,'',true);
		$this->Cell(20, 8, 'PO Alloc.', 0,0,'',true);
		$this->Cell(20, 8, 'PO No.', 0,0,'',true);
		$this->Cell(20, 8, 'Date', 0,0,'',true);
		$this->Cell(20, 8, 'PO Type', 0,0,'',true);
		$this->Cell(20, 8, 'PO Amt.', 0,0,'',true);
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

/*
class PDF extends PDF_MYSQL_TABLE{
	
	function Header(){
		$this->SetFont('Arial','B',18);
		$this->Cell(0,6,'Unfilled Purchase Order',0,1,'C');
		$this->Ln(10);
		parent::Header();
	}
}
*/

$AsOfDate = date('Y-m-d');
$AllCreditors = "";
$CR_Code_First = "";
$CR_Code_Last = "";
$CML_Order = "";

$CMLerr0 = "";
$CMLerr1 = "";
$CMLerr2 = "";
$CMLerr3 = "";
$CMLerr4 = "";

$downloadfilename = "Unfilled_PO.pdf";

if(isset($_POST['Print'])){
	if ($_SERVER['REQUEST_METHOD'] == 'POST'){
		
		if(empty($_POST['UFPO_Date'])){
			$AsOfDate = date('Y-m-d');
		}
		
		if(!empty($_POST['UFPO_All'])){
			$AllCreditors = strip_tags($_POST['UFPO_All']);
		}
		
		if($AllCreditors!='All'){
			if((empty($_POST['F_CR_Code']))){
				$CMLerr2 = "Missing";
			}else{
				$CR_Code_First = strip_tags($_POST['F_CR_Code']);
			}
			
			if((empty($_POST['L_CR_Code']))){
				$CMLerr3 = "Missing";
			}else{
				$CR_Code_Last = strip_tags($_POST['L_CR_Code']);
			}
		}
		
		if(empty($_POST['CTH_Order'])){
			$CMLerr4 = "Missing";
		}else{
			$CML_Order = strip_tags($_POST['CTH_Order']);
		}
		
	}
	
	if(
		(!empty($_POST['CTH_Order']))
		){		
			$pdf = new PDF();
			$pdf->AliasNbPages();
			$pdf->AddPage('P');
			$pdf->SetFont('Arial', '', 8);
			
			
			
			$query = "SELECT * FROM purchase";
			$records = mysql_query($query) or die (mysql_error());
			$exists = "no";
			while($row=mysql_fetch_array($records)){
				if( (!empty($row['POAllocation'])) &&
					(!empty($row['POtemp'])) &&
					(!empty($row['PODate'])) &&
					(!empty($row['POType'])) &&
					(!empty($row['POAmount']))
					){
					$exists = "yes";
					if($AllCreditors=='All'){
							$query = "SELECT creditormaster.CreditorCode, creditormaster.CreditorName, POAllocation, POtemp, DATE_FORMAT(PODate,'%b %d, %Y') AS PODate, POType, POAmount FROM purchase
							LEFT JOIN creditormaster
							ON purchase.CreditorCode=creditormaster.CreditorCode
							WHERE ( POtemp NOT IN(
								select PONumber FROM invoice
							) )
							AND ( PODate<='".$AsOfDate."' )
							ORDER BY creditormaster.Creditor".$CML_Order."";
																			
					}else if(
						($AllCreditors!='All') &&
						(!empty($_POST['F_CR_Code'])) &&
						(!empty($_POST['L_CR_Code']))
						){
							$query = "SELECT creditormaster.CreditorCode, creditormaster.CreditorName, POAllocation, POtemp, DATE_FORMAT(PODate,'%b %d, %Y') AS PODate, POType, POAmount FROM purchase
							LEFT JOIN creditormaster
							ON purchase.CreditorCode=creditormaster.CreditorCode
							WHERE ( POtemp NOT IN(
								select PONumber FROM invoice
							) )
							AND ( PODate<='".$AsOfDate."' ) 
							AND ( creditormaster.CreditorCode BETWEEN '".$CR_Code_First."' AND '".$CR_Code_Last."' )
							ORDER BY creditormaster.Creditor".$CML_Order."";
					}
					$result = mysql_query($query);
					$item = 0;
					
					while($row = mysql_fetch_array($result)){
						$item = $item+1;
						$pdf->SetFillColor(232,232,232);
						$pdf->Cell(20, 8, '', 0,0,'');
						$pdf->Cell(10, 8, $item, 0,0,'',true);
						$pdf->Cell(20, 8, $row['CreditorCode'], 0,0,'');
						$pdf->Cell(20, 8, $row['CreditorName'], 0,0,'');
						$pdf->Cell(20, 8, $row['POAllocation'], 0,0,'');
						$pdf->Cell(20, 8, $row['POtemp'], 0,0,'');
						$pdf->Cell(20, 8, $row['PODate'], 0,0,'');
						$pdf->Cell(20, 8, $row['POType'], 0,0,'');
						$pdf->Cell(20, 8, $row['POAmount'], 0,0,'');
						$pdf->Ln(8);
					}
					break;
				}
			}
			
			if ($exists == "no"){
				$pdf->SetTextColor(255,0,0);
				$pdf->Cell(0,50,"There are currently no data to display.",0,0,C);
			}
			
			
		
		if((empty($_POST['F_CR_Code'])) && $AllCreditors!='All'){
			$CMLerr2 = "Missing";
		}else if((empty($_POST['L_CR_Code'])) && $AllCreditors!='All'){
			$CMLerr3 = "Missing";			
		}else{
			$pdf->Output($downloadfilename); 
			echo "<script>window.open('../web/viewer.html?file=../Enquiry/".$downloadfilename."#zoom=100','_blank_','menubar=0');</script>";
			//header('Location: '."../web/viewer.html?file=../Enquiry/$downloadfilename#zoom=100");
		}
		
	}
	
}

?>
<html>
<head>
    
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Creditor Module</title>
	<link rel="shortcut icon" href="../img/icon.ico">

    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../bootstrap/css/logo-nav.css" rel="stylesheet">
	
    <script src="../bootstrap/js/jquery.js"></script>
    <script src="../bootstrap/js/bootstrap.min.js"></script>
	<script language="JavaScript">
	
	function allcreditors(){
	  var allcr = document.getElementById('UFPO_All');
	  if (allcr.checked){
		 document.getElementById('F_CR_Code').disabled=true;
		 document.getElementById('L_CR_Code').disabled=true;
	  }else{
		 document.getElementById('F_CR_Code').disabled=false;
		 document.getElementById('L_CR_Code').disabled=false;
	  }
	}
	
	</script>
	
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

<fieldset>
<legend><strong>Unfilled Purchase Order</strong></legend>
	<table>
	<td><label><a href="../Enquiry.php"><button class="btn btn-default"><span class="glyphicon glyphicon-chevron-left"></span></button></a></label>
			<label><a href="crs504r.php"><button class="btn btn-default"><span class="glyphicon glyphicon-refresh"></span> Refresh</button></a></label></td>
	</table>
	<table>
		<form id="form" name="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			<tr>
			</tr>
			<!--<tr>
				<td>Print Destination</td>
				<td><p>
				<label><input type="radio" name="UFPO_PrintDest" id="UFPO_PrintDest" value="Screen" />Screen</label>
				<label><input type="radio" name="UFPO_PrintDest" id="UFPO_PrintDest" value="Printer"/>Printer</label>
				</p></td>
			</tr>-->
			<tr>
				<td style="vertical-align:top">As at Date</td>
				<td>
				<label><input type="text" name="UFPO_Date" id="UFPO_Date" value="<?php echo date('F d, Y'); ?>" disabled /></label>
				<br><br>
				<label><input onclick="allcreditors()" type="checkbox" name="UFPO_All" id="UFPO_All" value="All" <?php if ($AllCreditors=='All') { echo 'checked'; } ?> />All Creditors</label>
				</td>
				<td><font color="red"><?php echo $CMLerr0 ;?></font><br><br><br></td>
			</tr>
			<tr>
					<td>First Creditor Code</td>
					<td><label><input type="text" name="F_CR_Code" id="F_CR_Code" value="<?php echo $CR_Code_First;?>" /></label></td>
					<td><font color="red"><?php echo $CMLerr2 ;?></font></td>
				<tr>
				</tr>
					<td>Last Creditor Code</td>
					<td><label><input type="text" name="L_CR_Code" id="L_CR_Code" value="<?php echo $CR_Code_Last;?>" /></label></td>
					<td><font color="red"><?php echo $CMLerr3 ;?></font></td>					
				</tr>
				<tr>
					<td>Order By</td>
					<td>
					<label><input type="radio" name="CTH_Order" id="CTH_Order" value="Code" <?php if ($CML_Order=='Code') { echo 'checked'; } ?> />Creditor Code</label>
					<label><input type="radio" name="CTH_Order" id="CTH_Order" value="Name" <?php if ($CML_Order=='Name') { echo 'checked'; } ?> />Creditor Name</label>
					</td>
					<td><font color="red"><?php echo $CMLerr4 ;?></font></td>
				</tr>
				<tr><td><label><button name="Print"  value="Print"  class="btn btn-default" /><span class="glyphicon glyphicon-print"> Print</button></label></td></tr>
		</form> 
	</table>
							  
</fieldset>

</body>
</html>
