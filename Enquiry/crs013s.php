<!DOCTYPE html>
<?php
//require(dirname(dirname(__FILE__)) . '/fpdf/fpdf.php');
require(dirname(dirname(__FILE__)) . '/fpdf/mysql_table.php');
require(dirname(dirname(__FILE__)) . '/fpdf/cellfit.php');
include(dirname(dirname(__FILE__)) . "/DatabaseConnect.php");

class PDF extends PDF_MYSQL_TABLE{
	
	function Header(){
		$this->SetFont('Arial','B',18);
		$this->Cell(0,6,'Creditor Master Listing',0,1,'C');
		$this->Ln(10);
		parent::Header();
	}
}

$CML_Range = "";
$CML_Zero = "";
$CR_Code_First = "";
$CR_Code_Last = "";
$CML_Order = "";

$CMLerr0 = "";
$CMLerr1 = "";
$CMLerr2 = "";
$CMLerr3 = "";
$CMLerr4 = "";

$downloadfilename = "Credit_Master.pdf";

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
		
		if((empty($_POST['CR_Code_First'])) && $CML_Range=='range'){
			$CMLerr2 = "Missing";
		}else{
			$CR_Code_First = strip_tags($_POST['CR_Code_First']);
		}
		
		if((empty($_POST['CR_Code_Last'])) && $CML_Range=='range'){
			$CMLerr3 = "Missing";
		}else{
			$CR_Code_Last = strip_tags($_POST['CR_Code_Last']);
		}
		
		if(empty($_POST['CML_Order'])){
			$CMLerr4 = "Missing";
		}else{
			$CML_Order = strip_tags($_POST['CML_Order']);
		}
		
	}
	
	if(	(!empty($_POST['CML_Range'])) &&
		(!empty($_POST['CML_Order']))
		){		
			$pdf = new PDF('L','mm','Legal');
			
			$prop=array('HeaderColor'=>array(112,128,144),
						'color1'=>array(255,255,255),
						'color2'=>array(198,226,255),
						'padding'=>2);
			
			$query = "SELECT * FROM creditormaster";
			$records = mysql_query($query) or die (mysql_error());
			$exists = "no";
			while($row=mysql_fetch_array($records)){
				if( (!empty($row['CreditorCode'])) &&
					(!empty($row['CreditorName'])) &&
					(!empty($row['CreditorType'])) &&
					(!empty($row['ShortName'])) &&
					(!empty($row['CompanyNumber'])) &&
					(!empty($row['CreditPeriod'])) &&
					(!empty($row['Remark'])) &&
					(!empty($row['PaymentYTD'])) &&
					(!empty($row['LastPaymentDate'])) &&
					(!empty($row['InvoiceYTD'])) &&
					(!empty($row['LastInvoiceDate'])) &&
					(!empty($row['CreditorBalance']))
					){
					$exists = "yes";
					
					
					if($CML_Range=='all'){
						if($CML_Order=='CreditorCode'){
							$pdf->AddPage('L');
							$pdf->SetFont('Arial','B',15);
							$pdf->Cell(0,0,"Creditor Details",0,0,C);
							$pdf->Ln(5);
							
							$pdf->AddCol('CreditorCode',20,'Cr. Code','L');
							$pdf->AddCol('CreditorName',30,'Name','L');
							$pdf->AddCol('CreditorType',20,'Type','L');
							$pdf->AddCol('ShortName',30,'Short Name','L');
							$pdf->AddCol('CompanyNumber',30,'Company no.','L');
							$pdf->AddCol('CreditPeriod',20,'Period','L');
							$pdf->AddCol('Remark',30,'Remarks','L');
							$pdf->AddCol('PaymentYTD',30,'Payment YTD','L');
							$pdf->AddCol('LastPaymentDate',30,'Last Payment','L');
							$pdf->AddCol('InvoiceYTD',30,'Invoice YTD','L');
							$pdf->AddCol('LastInvoiceDate',30,'Last Invoice','L');
							$pdf->AddCol('CreditorBalance',30,'Balance','L');
							
							$query = "SELECT CreditorCode, CreditorName, CreditorType, ShortName, CompanyNumber, CreditPeriod, Remark, PaymentYTD, DATE_FORMAT(LastPaymentDate,'%b %d, %Y') AS LastPaymentDate, InvoiceYTD, DATE_FORMAT(LastInvoiceDate,'%b %d, %Y') AS LastInvoiceDate, CreditorBalance FROM creditormaster
										ORDER BY CreditorCode";
							$pdf->Table($query,$prop);
							
							
							$pdf->AddPage('L');
							$pdf->SetFont('Arial','B',15);
							$pdf->Cell(0,0,"Contact Details",0,0,C);
							$pdf->Ln(5);
							
							$pdf->AddCol('CreditorCode',20,'Cr. Code','L');
							$pdf->AddCol('ShortName',30,'Short Name','L');
							$pdf->AddCol('Address',30,'Address','L');
							$pdf->AddCol('ContactName',30,'Contact Name','L');
							$pdf->AddCol('Telephone1',30,'Tel No. 1','L');
							$pdf->AddCol('Fax',30,'Fax No.','L');
							$pdf->AddCol('Telephone2',30,'Tel No. 2','L');
							$pdf->AddCol('Email',30,'Email','L');
							
							$query = "SELECT CreditorCode, ShortName, Address, ContactName, Telephone1, Fax, Telephone2, Email FROM creditormaster
										ORDER BY CreditorCode";
							$pdf->Table($query,$prop);
							
							
							$pdf->AddPage('L');
							$pdf->SetFont('Arial','B',15);
							$pdf->Cell(0,0,"Others",0,0,C);
							$pdf->Ln(5);
							
							$pdf->AddCol('CreditorCode',20,'Cr. Code','L');
							$pdf->AddCol('ShortName',30,'Short Name','L');
							$pdf->AddCol('StartActiveDate',30,'Start Active','L');
							$pdf->AddCol('LastOnHoldDate',30,'Last On Hold','L');
							
							$query = "SELECT CreditorCode, ShortName, DATE_FORMAT(StartActiveDate,'%b %d, %Y') AS StartActiveDate, DATE_FORMAT(LastOnHoldDate,'%b %d, %Y') AS LastOnHoldDate FROM creditormaster
										ORDER BY CreditorCode";
							$pdf->Table($query,$prop);
										
			
						}else{
							$pdf->AddPage('L');
							$pdf->SetFont('Arial','B',15);
							$pdf->Cell(0,0,"Creditor Details",0,0,C);
							$pdf->Ln(5);
							
							$pdf->AddCol('CreditorCode',20,'Cr. Code','L');
							$pdf->AddCol('CreditorName',30,'Name','L');
							$pdf->AddCol('CreditorType',20,'Type','L');
							$pdf->AddCol('ShortName',30,'Short Name','L');
							$pdf->AddCol('CompanyNumber',30,'Company no.','L');
							$pdf->AddCol('CreditPeriod',20,'Period','L');
							$pdf->AddCol('Remark',30,'Remarks','L');
							$pdf->AddCol('PaymentYTD',30,'Payment YTD','L');
							$pdf->AddCol('LastPaymentDate',30,'Last Payment','L');
							$pdf->AddCol('InvoiceYTD',30,'Invoice YTD','L');
							$pdf->AddCol('LastInvoiceDate',30,'Last Invoice','L');
							$pdf->AddCol('CreditorBalance',30,'Balance','L');
							
							$query = "SELECT CreditorCode, CreditorName, CreditorType, ShortName, CompanyNumber, CreditPeriod, Remark, PaymentYTD, DATE_FORMAT(LastPaymentDate,'%b %d, %Y') AS LastPaymentDate, InvoiceYTD, DATE_FORMAT(LastInvoiceDate,'%b %d, %Y') AS LastInvoiceDate, CreditorBalance FROM creditormaster
										ORDER BY CreditorName";
							$pdf->Table($query,$prop);
							
							
							$pdf->AddPage('L');
							$pdf->SetFont('Arial','B',15);
							$pdf->Cell(0,0,"Contact Details",0,0,C);
							$pdf->Ln(5);
							
							$pdf->AddCol('CreditorCode',20,'Cr. Code','L');
							$pdf->AddCol('ShortName',30,'Short Name','L');
							$pdf->AddCol('Address',30,'Address','L');
							$pdf->AddCol('ContactName',30,'Contact Name','L');
							$pdf->AddCol('Telephone1',30,'Tel No. 1','L');
							$pdf->AddCol('Fax',30,'Fax No.','L');
							$pdf->AddCol('Telephone2',30,'Tel No. 2','L');
							$pdf->AddCol('Email',30,'Email','L');
							
							$query = "SELECT CreditorCode, ShortName, Address, ContactName, Telephone1, Fax, Telephone2, Email FROM creditormaster
										ORDER BY CreditorName";
							$pdf->Table($query,$prop);
							
							
							$pdf->AddPage('L');
							$pdf->SetFont('Arial','B',15);
							$pdf->Cell(0,0,"Others",0,0,C);
							$pdf->Ln(5);
							
							$pdf->AddCol('CreditorCode',20,'Cr. Code','L');
							$pdf->AddCol('ShortName',30,'Short Name','L');
							$pdf->AddCol('StartActiveDate',30,'Start Active','L');
							$pdf->AddCol('LastOnHoldDate',30,'Last On Hold','L');
							
							$query = "SELECT CreditorCode, ShortName, DATE_FORMAT(StartActiveDate,'%b %d, %Y') AS StartActiveDate, DATE_FORMAT(LastOnHoldDate,'%b %d, %Y') AS LastOnHoldDate FROM creditormaster
										ORDER BY CreditorName";
							$pdf->Table($query,$prop);
						}
					}
					else if(
						($CML_Range=='range') &&
						(!empty($_POST['CR_Code_First'])) &&
						(!empty($_POST['CR_Code_Last']))
						){
						if($CML_Order=='CreditorCode'){
							$pdf->AddPage('L');
							$pdf->SetFont('Arial','B',15);
							$pdf->Cell(0,0,"Creditor Details",0,0,C);
							$pdf->Ln(5);
							
							$pdf->AddCol('CreditorCode',20,'Cr. Code','L');
							$pdf->AddCol('CreditorName',30,'Name','L');
							$pdf->AddCol('CreditorType',20,'Type','L');
							$pdf->AddCol('ShortName',30,'Short Name','L');
							$pdf->AddCol('CompanyNumber',30,'Company no.','L');
							$pdf->AddCol('CreditPeriod',20,'Period','L');
							$pdf->AddCol('Remark',30,'Remarks','L');
							$pdf->AddCol('PaymentYTD',30,'Payment YTD','L');
							$pdf->AddCol('LastPaymentDate',30,'Last Payment','L');
							$pdf->AddCol('InvoiceYTD',30,'Invoice YTD','L');
							$pdf->AddCol('LastInvoiceDate',30,'Last Invoice','L');
							$pdf->AddCol('CreditorBalance',30,'Balance','L');
							
							$query = "SELECT CreditorCode, CreditorName, CreditorType, ShortName, CompanyNumber, CreditPeriod, Remark, PaymentYTD, DATE_FORMAT(LastPaymentDate,'%b %d, %Y') AS LastPaymentDate, InvoiceYTD, DATE_FORMAT(LastInvoiceDate,'%b %d, %Y') AS LastInvoiceDate, CreditorBalance FROM creditormaster
										WHERE CreditorCode BETWEEN '".$CR_Code_First."' AND '".$CR_Code_Last."'
										ORDER BY CreditorCode";
							$pdf->Table($query,$prop);
							
							
							$pdf->AddPage('L');
							$pdf->SetFont('Arial','B',15);
							$pdf->Cell(0,0,"Contact Details",0,0,C);
							$pdf->Ln(5);
							
							$pdf->AddCol('CreditorCode',20,'Cr. Code','L');
							$pdf->AddCol('ShortName',30,'Short Name','L');
							$pdf->AddCol('Address',30,'Address','L');
							$pdf->AddCol('ContactName',30,'Contact Name','L');
							$pdf->AddCol('Telephone1',30,'Tel No. 1','L');
							$pdf->AddCol('Fax',30,'Fax No.','L');
							$pdf->AddCol('Telephone2',30,'Tel No. 2','L');
							$pdf->AddCol('Email',30,'Email','L');
							
							$query = "SELECT CreditorCode, ShortName, Address, ContactName, Telephone1, Fax, Telephone2, Email FROM creditormaster
										WHERE CreditorCode BETWEEN '".$CR_Code_First."' AND '".$CR_Code_Last."'
										ORDER BY CreditorCode";
							$pdf->Table($query,$prop);
							
							
							$pdf->AddPage('L');
							$pdf->SetFont('Arial','B',15);
							$pdf->Cell(0,0,"Others",0,0,C);
							$pdf->Ln(5);
							
							$pdf->AddCol('CreditorCode',20,'Cr. Code','L');
							$pdf->AddCol('ShortName',30,'Short Name','L');
							$pdf->AddCol('StartActiveDate',30,'Start Active','L');
							$pdf->AddCol('LastOnHoldDate',30,'Last On Hold','L');
							
							$query = "SELECT CreditorCode, ShortName, DATE_FORMAT(StartActiveDate,'%b %d, %Y') AS StartActiveDate, DATE_FORMAT(LastOnHoldDate,'%b %d, %Y') AS LastOnHoldDate FROM creditormaster
										WHERE CreditorCode BETWEEN '".$CR_Code_First."' AND '".$CR_Code_Last."'
										ORDER BY CreditorCode";
							$pdf->Table($query,$prop);
										
			
						}else{
							$pdf->AddPage('L');
							$pdf->SetFont('Arial','B',15);
							$pdf->Cell(0,0,"Creditor Details",0,0,C);
							$pdf->Ln(5);
							
							$pdf->AddCol('CreditorCode',20,'Cr. Code','L');
							$pdf->AddCol('CreditorName',30,'Name','L');
							$pdf->AddCol('CreditorType',20,'Type','L');
							$pdf->AddCol('ShortName',30,'Short Name','L');
							$pdf->AddCol('CompanyNumber',30,'Company no.','L');
							$pdf->AddCol('CreditPeriod',20,'Period','L');
							$pdf->AddCol('Remark',30,'Remarks','L');
							$pdf->AddCol('PaymentYTD',30,'Payment YTD','L');
							$pdf->AddCol('LastPaymentDate',30,'Last Payment','L');
							$pdf->AddCol('InvoiceYTD',30,'Invoice YTD','L');
							$pdf->AddCol('LastInvoiceDate',30,'Last Invoice','L');
							$pdf->AddCol('CreditorBalance',30,'Balance','L');
							
							$query = "SELECT CreditorCode, CreditorName, CreditorType, ShortName, CompanyNumber, CreditPeriod, Remark, PaymentYTD, DATE_FORMAT(LastPaymentDate,'%b %d, %Y') AS LastPaymentDate, InvoiceYTD, DATE_FORMAT(LastInvoiceDate,'%b %d, %Y') AS LastInvoiceDate, CreditorBalance FROM creditormaster
										WHERE CreditorCode BETWEEN '".$CR_Code_First."' AND '".$CR_Code_Last."'
										ORDER BY CreditorName";
							$pdf->Table($query,$prop);
							
							
							$pdf->AddPage('L');
							$pdf->SetFont('Arial','B',15);
							$pdf->Cell(0,0,"Contact Details",0,0,C);
							$pdf->Ln(5);
							
							$pdf->AddCol('CreditorCode',20,'Cr. Code','L');
							$pdf->AddCol('ShortName',30,'Short Name','L');
							$pdf->AddCol('Address',30,'Address','L');
							$pdf->AddCol('ContactName',30,'Contact Name','L');
							$pdf->AddCol('Telephone1',30,'Tel No. 1','L');
							$pdf->AddCol('Fax',30,'Fax No.','L');
							$pdf->AddCol('Telephone2',30,'Tel No. 2','L');
							$pdf->AddCol('Email',30,'Email','L');
							
							$query = "SELECT CreditorCode, ShortName, Address, ContactName, Telephone1, Fax, Telephone2, Email FROM creditormaster
										WHERE CreditorCode BETWEEN '".$CR_Code_First."' AND '".$CR_Code_Last."'
										ORDER BY CreditorName";
							$pdf->Table($query,$prop);
							
							
							$pdf->AddPage('L');
							$pdf->SetFont('Arial','B',15);
							$pdf->Cell(0,0,"Others",0,0,C);
							$pdf->Ln(5);
							
							$pdf->AddCol('CreditorCode',20,'Cr. Code','L');
							$pdf->AddCol('ShortName',30,'Short Name','L');
							$pdf->AddCol('StartActiveDate',30,'Start Active','L');
							$pdf->AddCol('LastOnHoldDate',30,'Last On Hold','L');
							
							$query = "SELECT CreditorCode, ShortName, DATE_FORMAT(StartActiveDate,'%b %d, %Y') AS StartActiveDate, DATE_FORMAT(LastOnHoldDate,'%b %d, %Y') AS LastOnHoldDate FROM creditormaster
										WHERE CreditorCode BETWEEN '".$CR_Code_First."' AND '".$CR_Code_Last."'
										ORDER BY CreditorName";
							$pdf->Table($query,$prop);
						}
					}
					break;
				}
			}
			
			if ($exists == "no"){
				$pdf->SetTextColor(255,0,0);
				$pdf->Cell(0,50,"There are currently no data to display.",0,0,C);
			}
			
			
		
		if((empty($_POST['CR_Code_First'])) && $CML_Range=='range'){
			$CMLerr2 = "Missing";
		}else if((empty($_POST['CR_Code_Last'])) && $CML_Range=='range'){
			$CMLerr3 = "Missing";			
		}else{
			$pdf->Output($downloadfilename); 
			header('Location: '.$downloadfilename);
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
    <legend><strong>Creditor Master Listing</strong></legend>
	<table>
	<td><label><a href="../Enquiry.php"><button class="btn btn-default"><span class="glyphicon glyphicon-chevron-left"></span></button></a></label>
			<label><a href="crs013s.php"><button class="btn btn-default"><span class="glyphicon glyphicon-refresh"></span> Refresh</button></a></label></td>
	</table>
		<table>
			<form id="form" name="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
				<!--<tr>
					<td>Print Destination</td>
					<td><p>
					<label><input type="radio" name="CML_PrintDest" id="CML_PrintDest" value="Screen" />Screen</label>
					<label><input type="radio" name="CML_PrintDest" id="CML_PrintDest" value="Printer"/>Printer</label>
					</p></td>
				</tr>-->
				<tr>
					<td>Print Range</td>
					<td>
					<label><input type="radio" name="CML_Range" id="CML_Range" value="all" <?php if ($CML_Range=='all') { echo 'checked'; } ?> />All</label>
					<label><input type="radio" name="CML_Range" id="CML_Range" value="range" <?php if ($CML_Range=='range') { echo 'checked'; } ?>/>Range</label>
					</td>
					<td><font color="red"><?php echo $CMLerr0 ;?></font></td>
				</tr>
				<tr>
				<td></td><td><label><input type="checkbox" name="CML_Zero" id="CML_Zero" value="zero" <?php if ($CML_Zero=='zero') { echo 'checked'; } ?> />Include Zero</label></td>
				</tr>
				<tr>
					<td>First Creditor Code</td>
					<td>
					<label><input type="text" name="CR_Code_First" id="CR_Code_First" value="<?php echo $CR_Code_First;?>" /></label>
					</td>
					<td><font color="red"><?php echo $CMLerr2 ;?></font></td>
				</tr>
				<tr>
					<td>Last Creditor Code</td>
					<td>
					<label><input type="text" name="CR_Code_Last" id="CR_Code_Last" value="<?php echo $CR_Code_Last;?>"  /></label>
					</td>
					<td><font color="red"><?php echo $CMLerr3 ;?></font></td>
				</tr>
				<tr>
					<td style="vertical-align:top">Group By</td>
					<td>
					
					<label><input type="radio" name="CML_Order" id="CML_Order" value="CreditorCode" <?php if ($CML_Order=='CreditorCode') { echo 'checked'; } ?> />Creditor Code</label>
					<label><input type="radio" name="CML_Order" id="CML_Order" value="CreditorName" <?php if ($CML_Order=='CreditorName') { echo 'checked'; } ?> />Creditor Name</label>
					
					</td>
					<td><font color="red"><?php echo $CMLerr4 ;?></font></td>
				</tr>
				<tr><td><label><button name="Print"  value="Print"  class="btn btn-default" /><span class="glyphicon glyphicon-print"> Print</button></label></td></tr>
					</form> 
					</table>
								  
</fieldset>
</body>
</html>
