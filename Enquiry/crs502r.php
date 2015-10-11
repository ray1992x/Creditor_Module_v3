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
			$pdf = new PDF();
			$pdf->AliasNbPages();
			$pdf->AddPage('P');
			$pdf->SetFont('Arial', '', 8);
			
			$query = "SELECT * FROM payment";
			$records = mysql_query($query) or die (mysql_error());
			$exists = "no";
			while($row=mysql_fetch_array($records)){
				if( (!empty($row['CreditorCode'])) &&
					(!empty($row['DatePaid'])) &&
					(!empty($row['PaymentType'])) &&
					(!empty($row['BankCode'])) &&
					(!empty($row['BatchNumber'])) &&
					(!empty($row['PaymentAmount']))
					){
					$exists = "yes";
					$pdf->AddCol('CNnumber',10,'No.','L');
					$pdf->AddCol('BatchNumber',30,'Batch Number','L');
					$pdf->AddCol('SequenceNumber',40,'Sequence Number','L');
					$pdf->AddCol('CreditorCode',30,'Creditor Code','C');
					$pdf->AddCol('CreditNoteAmount',30,'Amount','L');
					$pdf->AddCol('CreditNoteDate',20,'Date','L');
					$pdf->AddCol('CreditNoteDesc',100,'Description','L');
					
					if($CML_Range=='all'){
							$query = "SELECT * FROM payment";
					}
					else if(
						($CML_Range=='range') &&
						(!empty($_POST['CR_Code_First'])) &&
						(!empty($_POST['CR_Code_Last']))
						){												
							$query = "SELECT * FROM payment
										WHERE CreditorCode BETWEEN '".$CR_Code_First."' AND '".$CR_Code_Last."'";
					}
					$result = mysql_query($query);
					$item = 0;
					
					while($row = mysql_fetch_array($result)){
						$item = $item+1;
						$pdf->SetFillColor(232,232,232);
						$pdf->Cell(25, 8, '', 0,0,'');
						$pdf->Cell(10, 8, $item, 0,0,'',true);
						$pdf->Cell(20, 8, $row['CreditorCode'], 0,0,'');
						$pdf->Cell(20, 8, $row['DatePaid'], 0,0,'');
						$pdf->Cell(20, 8, $row['PaymentType'], 0,0,'');
						$pdf->Cell(20, 8, $row['BankCode'], 0,0,'');
						$pdf->Cell(20, 8, $row['BatchNumber'], 0,0,'');
						$pdf->Cell(20, 8, $row['PaymentAmount'], 0,0,'');
						$pdf->Ln(8);
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
<legend><strong>Creditor Transaction History</strong></legend>
<table>
	<td><label><a href="../Enquiry.php"><button class="btn btn-default"><span class="glyphicon glyphicon-chevron-left"></span></button></a></label>
			<label><a href="crs502r.php"><button class="btn btn-default"><span class="glyphicon glyphicon-refresh"></span> Refresh</button></a></label></td>
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

			<tr><td><label><button name="Print"  value="Print"  class="btn btn-default" /><span class="glyphicon glyphicon-print"> Print</button></label></td></tr>
		</form> 
	</table>
							  
</fieldset>

<div>
<?php	
/*	$servername = "localhost";
						$username = "root";
						$password = "";
						$dbname = "company";
						
						//create a connection
						$conn = new mysqli($servername, $username, $password, $dbname);
						//check connection
						if ($conn->connect_error){
							die("connection failed:" . $conn->connect_error);
						}
	
	
	
		$sql = "SELECT * FROM CreditorMaster  ";//select database
		$result = $conn->query($sql);//store the result in a variable
		
					echo'<div class="table_config">';
						echo '<table id="tb1">
						<tr bgcolor="gray">
							<th>Creditor Code</th>
							<th>Creditor Name</th>
							<th>Creditor Type</th>
							<th>Short Name</th>
							<th>Company Number</th>
							<th>Credit Period</th>
							<th>Remark</th>
							<th>Payment YTD</th>
							<th>Last Payment Date</th>
							<th>Invoice YTD</th>
							<th>Last Invoice Date</th>
							<th>Creditor Balance</th>
							<th>Address</th>
							<th>Contact Name</th>
							<th>Telephone 1</th>
							<th>Fax</th>
							<th>Telephone 2</th>
							<th>E-mail</th>
							<th>Start Active Date</th>
							<th>Last On Hold Date</th>
						</tr>';
						
						while($row = $result->fetch_assoc()){
							echo "<tr>";
							echo "<td>".$row["CreditorCode"]."</td>";
							echo "<td>".$row["CreditorName"]."</td>";
							echo "<td>".$row["CreditorType"]."</td>";
							echo "<td>".$row["ShortName"]."</td>";
							echo "<td>".$row["CompanyNumber"]."</td>";
							echo "<td>".$row["CreditPeriod"]."</td>";
							echo "<td>".$row["Remark"]."</td>";
							echo "<td>".$row["PaymentYTD"]."</td>";
							echo "<td>".$row["LastPaymentDate"]."</td>";
							echo "<td>".$row["InvoiceYTD"]."</td>";
							echo "<td>".$row["LastInvoiceDate"]."</td>";
							echo "<td>".$row["CreditorBalance"]."</td>";
							echo "<td>".$row["Address"]."</td>";
							echo "<td>".$row["ContactName"]."</td>";
							echo "<td>".$row["Telephone1"]."</td>";
							echo "<td>".$row["Fax"]."</td>";
							echo "<td>".$row["Telephone2"]."</td>";
							echo "<td>".$row["Email"]."</td>";
							echo "<td>".$row["StartActiveDate"]."</td>";
							echo "<td>".$row["LastOnHoldDate"]."</td>";
							echo "</tr>";
						}
					echo '</table></div>';
*/
?>
</div>

</body>
</html>
