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
		$this->Cell(100, 8, 'Cheque Payment Report', 0,0,'C');
		$this->Ln(20);
		$this->SetFillColor(232,232,232);
		$this->SetFont('Arial', 'B', 8);
		$this->SetFillColor(232,232,232);
		$this->Cell(40, 8, '', 0,0,'');
		$this->Cell(10, 8, 'No', 0,0,'',true);
		$this->Cell(20, 8, 'Cheque No.', 0,0,'',true);
		$this->Cell(20, 8, 'Payment Amt.', 0,0,'',true);
		$this->Cell(20, 8, 'CR Code', 0,0,'',true);
		$this->Cell(20, 8, 'Date Paid', 0,0,'',true);
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

$ChequePrint = "";
$PaymentDateFrom = "";
$PaymentDateTo = "";
$FiscalPeriodM = "";
$FiscalPeriodY = "";
$GroupBy = "";
$IncludeSummary = "";

$CPRerr0 = "";
$CPRerr1 = "";
$CPRerr2 = "";
$CPRerr3 = "";

$optionsname = "crs022s_options.php";
$windowname = "";

$downloadfilename = "ChequePaymentReport.pdf";

if(isset($_POST['Print'])){
	if ($_SERVER['REQUEST_METHOD'] == 'POST'){
		
		if(empty($_POST['CPR_Print'])){
			$CPRerr0 = "Missing";
		}else{
			$ChequePrint = strip_tags($_POST['CPR_Print']);
		}
		
		if($_POST['CPR_Print'] == 'Date'){
			if(empty($_POST['Payment_Date_From']) || empty($_POST['Payment_Date_To'])){
				$CPRerr1 = "Please fill in both fields.";
			}else{
				$PaymentDateFrom = strip_tags($_POST['Payment_Date_From']);
				$PaymentDateTo = strip_tags($_POST['Payment_Date_To']);
			}
		}else if($_POST['CPR_Print'] = 'Period'){
			if(empty($_POST['Fiscal_Period_M']) || empty($_POST['Fiscal_Period_Y'])){
				$CPRerr2 = "Please fill in both fields.";
			}else{
				$FiscalPeriodM = strip_tags($_POST['Fiscal_Period_M']);
				$FiscalPeriodY = strip_tags($_POST['Fiscal_Period_Y']);
			}
		}
					
		if(empty($_POST['CPR_Group'])){
			$CPRerr3 = "Missing";
		}else{
			$GroupBy = strip_tags($_POST['CPR_Group']);
		}
		
		if(!empty($_POST['CR_Code_Last'])){
			$IncludeSummary = strip_tags($_POST['CPR_Summ']);
		}
		
		$windowname = "crs022s_view.php";
		
	}
	
	if( (!empty($_POST['CPR_Print'])) &&
		((!empty($_POST['Payment_Date_From']) && !empty($_POST['Payment_Date_To'])) || (!empty($_POST['Fiscal_Period_M']) && !empty($_POST['Fiscal_Period_Y']))) &&
		(!empty($_POST['CPR_Group']))
		){
			$_SESSION['ChequePrint'] = $ChequePrint;
			$_SESSION['PaymentDateFrom'] = $PaymentDateFrom;
			$_SESSION['PaymentDateTo'] = $PaymentDateTo;
			$_SESSION['FiscalPeriodM'] = $FiscalPeriodM;
			$_SESSION['FiscalPeriodY'] = $FiscalPeriodY;
			$_SESSION['GroupBy'] = $GroupBy;
			$_SESSION['IncludeSummary'] = $IncludeSummary;
			
			$_SESSION['OptionsName'] = $optionsname;
			$_SESSION['WindowName'] = $windowname;
			
			echo "<script>window.open('viewFrame.php','_blank_','menubar=0, width=1152, height=600');</script>";
			
			
			/*
			$pdf = new PDF();
			$pdf->AliasNbPages();
			$pdf->AddPage('P');
			$pdf->SetFont('Arial', '', 8);
			
			
			$query = "SELECT * FROM payment";
			$records = mysql_query($query) or die (mysql_error());
			$exists = "no";
			while($row=mysql_fetch_array($records)){
				if( (!empty($row['ChequeNumber'])) &&
					(!empty($row['PaymentAmount'])) &&
					(!empty($row['CreditorCode'])) &&
					(!empty($row['DatePaid']))
					){
					$exists = "yes";
					
						
					if($ChequePrint == 'Date'){
						$query = "SELECT ChequeNumber, PaymentAmount, creditormaster.CreditorCode, DATE_FORMAT(DatePaid,'%b %d, %Y') AS DatePaid FROM payment
						LEFT JOIN creditormaster
						on payment.CreditorCode=creditormaster.CreditorCode
						WHERE DatePaid BETWEEN '".$PaymentDateFrom."' AND '".$PaymentDateTo."'
						ORDER BY '".$GroupBy."'";
						
					}else if($ChequePrint == 'Period'){
						$query = "SELECT ChequeNumber, PaymentAmount, creditormaster.CreditorCode, DATE_FORMAT(DatePaid,'%b %d, %Y') AS DatePaid FROM payment
						LEFT JOIN creditormaster
						on payment.CreditorCode=creditormaster.CreditorCode
						WHERE MONTH(DatePaid)='".$FiscalPeriodM."' AND YEAR(DatePaid)='".$FiscalPeriodY."'
						ORDER BY '".$GroupBy."'";
						

					}
					$result = mysql_query($query);
					$item = 0;
					
					while($row = mysql_fetch_array($result)){
						$item = $item+1;
						$pdf->SetFillColor(232,232,232);
						$pdf->Cell(40, 8, '', 0,0,'');
						$pdf->Cell(10, 8, $item, 0,0,'',true);
						$pdf->Cell(20, 8, $row['ChequeNumber'], 0,0,'');
						$pdf->Cell(20, 8, $row['PaymentAmount'], 0,0,'');
						$pdf->Cell(20, 8, $row['CreditorCode'], 0,0,'');
						$pdf->Cell(20, 8, $row['DatePaid'], 0,0,'');
						$pdf->Ln(8);
					}
					break;
				}				
				
			}
			
			if ($exists == "no"){
				$pdf->SetTextColor(255,0,0);
				$pdf->Cell(0,50,"There are currently no data to display.",0,0,C);
			}else if($exists == "yes"){
				$pdf->Output($downloadfilename); 
				echo "<script>window.open('../web/viewer.html?file=../Enquiry/".$downloadfilename."#zoom=100','_blank_','menubar=0');</script>";
				//header('Location: '."../web/viewer.html?file=../Enquiry/$downloadfilename#zoom=100");
			}
			*/
			
		}
	
}

if(isset($_POST['Print2'])){
	if ($_SERVER['REQUEST_METHOD'] == 'POST'){
		
		$windowname = "crs022s_viewall.php";
			
			$_SESSION['OptionsName'] = $optionsname;
			$_SESSION['WindowName'] = $windowname;
			echo "<script>window.open('viewFrame.php','_blank_','menubar=0, width=1152, height=600');</script>";
		
		
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
	
	<link rel="stylesheet" type="text/css" href="../css/ui-lightness/jquery-ui-1.9.2.custom.css">
	<script type="text/javascript" src='../js/jquery-ui-1.9.2.custom.js'></script>
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.js"></script>
	<script type="text/javascript" src='../js/jquery-ui.js'></script>
	
	<script type="text/javascript">
	
	$(document).ready(function(){
		$('#Payment_Date_From,#Payment_Date_To').datepicker({dateFormat:'yy-mm-dd'});
	});
	
	</script>
	
	<script language="JavaScript">
	function PayDate(){
		document.getElementById('Payment_Date_From').disabled=false;
		document.getElementById('Payment_Date_To').disabled=false;
		document.getElementById('Fiscal_Period_M').disabled=true;
		document.getElementById("Fiscal_Period_M").style["background"] = "#eeeeee";
		document.getElementById('Fiscal_Period_Y').disabled=true;
		
	}
	function FisPeriod(){
		document.getElementById('Payment_Date_From').disabled=true;
		document.getElementById('Payment_Date_To').disabled=true;
		document.getElementById('Fiscal_Period_M').disabled=false;
		document.getElementById("Fiscal_Period_M").style["background"] = "#ffffff";
		document.getElementById('Fiscal_Period_Y').disabled=false;
	}
	</script>
	
	<style type="text/css">




@media (min-width: 1200px) {
  .container {
    width: 1000px;
  }
}
table#tb1 {
	border-collapse: collapse;
}

td {
	padding: 6px;
}

table#tb1 td{
	border:2px solid black;
	align:center;
}

table#tb1 th{
	background-color:gray;
	color:black;
	border:2px solid black;
	padding: 6px;
}

div.table_config{
	float: center;
	background:#FFF;
	height:750px;
	width:100%;
	overflow:scroll;
	margin-left:auto;
	margin-right:auto;
}

div.footer{
	position:fixed;
	bottom:0;
	right:auto;
	left:auto;
	width:100%;
	height:40px;
	background-color:grey;
}



	</style>
	
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

<!-- <div class="sidebar col-xs-3"> -->
<?php
/*
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "company";

	//create a connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	//check connection
	if ($conn->connect_error){
		die("connection failed:" . $conn->connect_error);
	}
	$sql = "SELECT * FROM payment ORDER BY DatePaid";//select database
	$result = $conn->query($sql);//store the result in a variable
		echo'<div class="Container">';
		echo'<div class="table_config">';
				echo '<table id="tb1" >
				<tr bgcolor="gray">
				<th>Creditor Code</th>
				<th>Bank Code</th>
				<th>Cheque Number</th>
				<th>Payment Number</th>
				<th>Payment Amount</th>
				<th>Date Paid</th>
				<th>Batch Number</th>
				<th>Sequence Number</th>
				<th>Batch Value</th>
				
				</tr>';
				while($row = $result->fetch_assoc()){
					echo "<tr>";
					echo "<td>".$row["CreditorCode"]."</td>";
					echo "<td>".$row["BankCode"]."</td>";
					echo "<td>".$row["ChequeNumber"]."</td>";
					echo "<td>".$row["PaymentNo"]."</td>";
					echo "<td>".$row["PaymentAmount"]."</td>";
					echo "<td>".$row["DatePaid"]."</td>";
					echo "<td>".$row["BatchNumber"]."</td>";
					echo "<td>".$row["SequenceNumber"]."</td>";
					echo "<td>".$row["BatchValue"]."</td>";
					echo "</tr>";
				}
		echo '</table>';
		echo '</div>';
		echo '</div>';
*/
?>
<!-- </div> -->

<fieldset>
<legend><strong>Cheque Payment Report</strong></legend>
<table>
	<td><label><a href="../Enquiry.php"><button class="btn btn-default"><span class="glyphicon glyphicon-chevron-left"></span></button></a></label>
			<label><a href="crs022s.php"><button class="btn btn-default"><span class="glyphicon glyphicon-refresh"></span> Refresh</button></a></label></td>
	</table>
	<table>
		<form id="form" name="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			<!--<tr>
				<td>Print Destination</td>
				<td><p>
				<label><input type="radio" name="CPR_PrintDest" id="CPR_PrintDest" value="Screen" />Screen</label>
				<label><input type="radio" name="CPR_PrintDest" id="CPR_PrintDest" value="Printer"/>Printer</label>
				</p></td>
			</tr>-->
				<tr>
					<td style="vertical-align:top">Print</td>
					<td>
				
					<label><input onclick="PayDate()" type="radio" name="CPR_Print" id="CPR_Print" value="Date" <?php if ($ChequePrint=='Date') { echo 'checked'; } ?> />Payment Date</label>
					<label><input onclick="FisPeriod()" type="radio" name="CPR_Print" id="CPR_Print" value="Period" <?php if ($ChequePrint=='Period') { echo 'checked'; } ?> />Fiscal Period</label>
					</td>
					<td><font color="red"><?php echo $CPRerr0 ;?></font></td>
				</tr>
				<tr>
					<td>Payment Date</td>
					<td>
					<label><input disabled type="text" name="Payment_Date_From" id="Payment_Date_From" placeholder="From..." value="<?php echo $PaymentDateFrom;?>" /></label>
					<label><input disabled type="text" name="Payment_Date_To" id="Payment_Date_To" placeholder="To..." value="<?php echo $PaymentDateTo;?>" /></label>
					</td>
					<td><font color="red"><?php echo $CPRerr1 ;?></font></td>
				<tr>
				<tr>
					<td>Fiscal Period</td>
					<td>
					<label>
					<select disabled STYLE=background:#eeeeee name="Fiscal_Period_M" id="Fiscal_Period_M">
						<option value="1">January</option>
						<option value="2">February</option>
						<option value="3">March</option>
						<option value="4">April</option>
						<option value="5">May</option>
						<option value="6">June</option>
						<option value="7">July</option>
						<option value="8">August</option>
						<option value="9">September</option>
						<option value="10">October</option>
						<option value="11">November</option>
						<option value="12">December</option>
					</select>
					</label>
					<label><input disabled type="number" name="Fiscal_Period_Y" id="Fiscal_Period_Y" placeholder="Fiscal Year" value="<?php echo $FiscalPeriodY;?>" /></label>
					</td>
					<td><font color="red"><?php echo $CPRerr2 ;?></font></td>
				<tr>
				<tr>
					<td style="vertical-align:top">Group By</td>
					<td>
					<!-- <label><input type="radio" name="CPR_Group" id="CPR_Group" value="None" />None</label> -->
					<label><input type="radio" name="CPR_Group" id="CPR_Group" value="DatePaid" <?php if ($GroupBy=='DatePaid') { echo 'checked'; } ?> />Payment Date</label>
					<label><input type="radio" name="CPR_Group" id="CPR_Group" value="CreditorCode" <?php if ($GroupBy=='CreditorCode') { echo 'checked'; } ?> />Creditor Code</label>
					</td>
					<td><font color="red"><?php echo $CPRerr3 ;?></font></td>
				</tr>
				<!--
				<tr>
					<td style="vertical-align:top">Include Summary</td>
					<td>
					&nbsp <label><input type="checkbox" name="CPR_Summ" id="CPR_Summ" value="yes" <?php if ($IncludeSummary=='yes') { echo 'checked'; } ?> /></label>
					</td>
				</tr>
				-->
				<table>
					<tr><td><label><button name="Print"  value="Print"  class="btn btn-default" /><span class="glyphicon glyphicon-eye-open"> View</button></label>
					<td><label><button name="Print2"  value="Print2"  class="btn btn-default" /><span class="glyphicon glyphicon-eye-open"> All Records</button></label>
					</td></tr>
				</table>
		</form> 
	</table>				  
</fieldset>

</body>
</html>
