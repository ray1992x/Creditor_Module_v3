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
		$this->Cell(100, 8, 'Overdue Invoices', 0,0,'C');
		$this->Ln(20);
		$this->SetFillColor(232,232,232);
		$this->SetFont('Arial', 'B', 8);
		$this->SetFillColor(232,232,232);
		$this->Cell(6, 8, '', 0,0,'');
		$this->Cell(10, 8, 'No', 0,0,'',true);
		$this->Cell(20, 8, 'Batch No.', 0,0,'',true);
		$this->Cell(20, 8, 'CR Code', 0,0,'',true);
		$this->Cell(20, 8, 'PO No.', 0,0,'',true);
		$this->Cell(20, 8, 'Inv. no.', 0,0,'',true);
		$this->Cell(20, 8, 'Inv. date', 0,0,'',true);
		$this->Cell(50, 8, 'Invoice Description', 0,0,'',true);
		$this->Cell(20, 8, 'Inv. Total', 0,0,'',true);
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

$INV_Overdue = "";

$POMLerr0 = "";

$downloadfilename = "Overdue_Inv.pdf";

if(isset($_POST['Print'])){
	if ($_SERVER['REQUEST_METHOD'] == 'POST'){
		
		if(empty($_POST['IOR_Date'])){
			$POMLerr0 = "Please specify a date.";
		}else{
			$INV_Overdue = strip_tags($_POST['IOR_Date']);
		}
		
		
	}
	
	if(!empty($_POST['IOR_Date'])){

			$pdf = new PDF();
			$pdf->AliasNbPages();
			$pdf->AddPage('P');
			$pdf->SetFont('Arial', '', 8);
						
			$query = "SELECT * FROM invoice";
			$records = mysql_query($query) or die (mysql_error());
			$exists = "no";
			while($row=mysql_fetch_array($records)){
				if( (!empty($row['BatchNumber'])) &&
					(!empty($row['CreditorCode'])) &&
					(!empty($row['DatePaymentDue'])) &&
					(!empty($row['InvNumber'])) &&
					(!empty($row['InvoiceDate'])) &&
					(!empty($row['InvoiceTotal'])) &&
					(!empty($row['PONumber'])) &&
					(!empty($row['POType']))
					){
					$exists = "yes";
						$query = "SELECT BatchNumber, purchase.CreditorCode, purchase.POtemp, InvNumber, InvoiceDate, InvoiceDescription,InvoiceTotal FROM invoice
						INNER JOIN purchase
						ON invoice.PONumber=purchase.POtemp
						WHERE ( InvoiceDate>'".$INV_Overdue."' )
						ORDER BY InvoiceDate";
						$result = mysql_query($query);	
						$item = 0;
						
						while($row = mysql_fetch_array($result)){
							$item = $item+1;
							$pdf->SetFillColor(232,232,232);
							$pdf->Cell(6, 8, '', 0,0,'');
							$pdf->Cell(10, 8, $item, 0,0,'',true);
							$pdf->Cell(20, 8, $row['BatchNumber'], 0,0,'');
							$pdf->Cell(20, 8, $row['CreditorCode'], 0,0,'');
							$pdf->Cell(20, 8, $row['POtemp'], 0,0,'');
							$pdf->Cell(20, 8, $row['InvNumber'], 0,0,'');
							$pdf->Cell(20, 8, $row['InvoiceDate'], 0,0,'');
							$pdf->Cell(50, 8, $row['InvoiceDescription'], 0,0,'');
							$pdf->Cell(20, 8, $row['InvoiceTotal'], 0,0,'');
							$pdf->Ln(8);
						}
		
					break;
				}
			}
			
			if ($exists == "no"){
				$pdf->SetTextColor(255,0,0);
				$pdf->Cell(0,50,"There are currently no data to display.",0,0,C);
			}			
			
		
		$pdf->Output($downloadfilename);
		echo "<script>window.open('../web/viewer.html?file=../Enquiry/".$downloadfilename."#zoom=100','_blank_','menubar=0');</script>";
		//header('Location: '."../web/viewer.html?file=../Enquiry/$downloadfilename#zoom=100");
		
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
	
	<link rel="stylesheet" type="text/css" href="../css/ui-lightness/jquery-ui-1.9.2.custom.css"
	<script type="text/javascript" src='../js/jquery-ui-1.9.2.custom.js'></script>
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.js"></script>
	<script type="text/javascript" src='../js/jquery-ui.js'></script>
	
	<script type="text/javascript">
	
	$(document).ready(function(){
		$('#IOR_Date').datepicker({dateFormat:'yy-mm-dd'});
	});
	
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
	height:400px;
	width:65%;
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

<fieldset>
<legend><strong>Invoice Overdue Report</strong></legend>
	<table>
	<td><label><a href="../Enquiry.php"><button class="btn btn-default"><span class="glyphicon glyphicon-chevron-left"></span></button></a></label>
			<label><a href="crs505r.php"><button class="btn btn-default"><span class="glyphicon glyphicon-refresh"></span> Refresh</button></a></label></td>
	</table>
	<table>
		<form id="form" name="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			<!--<tr>
				<td>Print Destination</td>
				<td><p>
				<label><input type="radio" name="IOR_PrintDest" id="IOR_PrintDest" value="Screen" />Screen</label>
				<label><input type="radio" name="IOR_PrintDest" id="IOR_PrintDest" value="Printer"/>Printer</label>
				</p></td>
			</tr>-->
			<tr>
				<td style="vertical-align:top">Overdue Date</td>
				<td>
				<label><input type="text" name="IOR_Date" id="IOR_Date" /></label>
				</td>
				<td><font color="red"><?php echo $POMLerr0;?></font></td>		
			</tr>
			<tr><td><label><button name="Print"  value="Print"  class="btn btn-default" /><span class="glyphicon glyphicon-print"> Print</button></label></td>
			<td><label><button name="View"  value="View"  class="btn btn-default" /><span class="glyphicon glyphicon-eye-open"> View</button></label>
			</td></tr>
		</form> 
	</table>
	
</fieldset>


<?php
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
	
	if(isset($_POST['View'])){		
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){
		
			if(empty($_POST['IOR_Date'])){
				$POMLerr0 = "Please choose an option.";
			}else{
				$INV_Overdue = strip_tags($_POST['IOR_Date']);
			}
		}
	
		if(!empty($_POST['IOR_Date'])){
			$sql = "SELECT BatchNumber, purchase.CreditorCode, purchase.POtemp, InvNumber, InvoiceDate, InvoiceDescription,InvoiceTotal FROM invoice
			INNER JOIN purchase
			ON invoice.PONumber=purchase.POtemp
			WHERE ( InvoiceDate>'".$INV_Overdue."' )
			ORDER BY InvoiceDate";//select database
			$result = $conn->query($sql);//store the result in a variable
				echo'<div class="Container">';
				echo'<div class="table_config">';
						echo '<table id="tb1" >
						<tr bgcolor="gray">
						<th>Batch No.</th>
						<th>CR Code</th>
						<th>PO Number</th>
						<th>Invoice No.</th>
						<th>Invoice Date</th>
						<th>Invoice Description</th>
						<th>Invoice Total</th>
						</tr>';
						while($row = $result->fetch_assoc()){
							echo "<tr>";
							echo "<td>".$row["BatchNumber"]."</td>";
							echo "<td>".$row["CreditorCode"]."</td>";
							echo "<td>".$row["POtemp"]."</td>";
							echo "<td>".$row["InvNumber"]."</td>";
							echo "<td>".$row["InvoiceDate"]."</td>";
							echo "<td>".$row["InvoiceDescription"]."</td>";
							echo "<td>".$row["InvoiceTotal"]."</td>";
							echo "</tr>";
						}
				echo '</table>';
				echo '</div>';
				echo '</div>';
		}
	}
?>


</body>
</html>
