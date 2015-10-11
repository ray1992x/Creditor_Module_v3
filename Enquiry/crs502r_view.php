<!DOCTYPE html>
<?php
//require(dirname(dirname(__FILE__)) . '../fpdf/fpdf.php');
require(dirname(dirname(__FILE__)) . '../fpdf/mysql_table.php');
require(dirname(dirname(__FILE__)) . '../fpdf/cellfit.php');
include(dirname(dirname(__FILE__)) . "../DatabaseConnect.php");


$CML_Range = $_SESSION['CML_Range'];
$CML_Zero = $_SESSION['CML_Zero'];
$CR_Code_First = $_SESSION['CML_Code_First'];
$CR_Code_Last = $_SESSION['CML_Code_Last'];

$query_all = "SELECT *,creditormaster.CreditorName FROM payment
				LEFT JOIN creditormaster
				ON payment.CreditorCode=creditormaster.CreditorCode";
				
$query_view = "SELECT * FROM payment
				LEFT JOIN creditormaster
				ON payment.CreditorCode=creditormaster.CreditorCode
					WHERE payment.CreditorCode BETWEEN '".$CR_Code_First."' AND '".$CR_Code_Last."'";

$downloadfilename = "Credit_Transaction.pdf";


class PDF extends PDF_MYSQL_TABLE
{
	function Header()
	{
		
		$this->Cell(5, 10, '', 0);
		$this->SetFont('Arial', '', 9);
		$this->Cell(1, 10, 'Company: Kuching Port Authority', 0,0,'L');
		$this->Cell(180, 10, 'Date/Time: '.date('d-m-Y / g:i:s A').'', 0,0,'R');
		$this->Ln(15);
		$this->SetFont('Arial', 'B', 16);
		$this->Cell(45, 8, '', 0);
		$this->Cell(100, 8, 'Creditor Transaction History', 0,0,'C');
		$this->Ln(20);
		$this->SetFillColor(232,232,232);
		$this->SetFont('Arial', 'B', 8);
		$this->SetFillColor(232,232,232);
		$this->SetLineWidth(0.4);
		$this->Cell(3, 8, '', 0,0,'','');
		$this->Cell(8, 8, 'No','BR',0,'','');
		$this->Cell(25, 8, 'Creditor Code', 'B',0,'','');
		$this->Cell(25, 8, 'Creditor Name', 'B',0,'','');
		$this->Cell(20, 8, 'Date','B',0,'','');
		$this->Cell(20, 8, 'Txn. Type','B',0,'','');
		$this->Cell(20, 8, 'Bank Code','B',0,'','');
		$this->Cell(25, 8, 'Bank Name','B',0,'','');
		$this->Cell(20, 8, 'Reference No.','B',0,'','');
		$this->Cell(20, 8, 'Amount','B',1,'R','');
		parent::Header();
	}
	function Footer()
	{
			$this->SetY(-15);
			// Arial italic 8
			$this->SetFont('Arial','I',8);
			// Page number
			$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'R');
	}
}



if(isset($_POST['Print'])){
	if ($_SERVER['REQUEST_METHOD'] == 'POST'){
		
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
							$query = $query_all;
					}
					else if($CML_Range=='range') {												
							$query = $query_view;
					}
					$result = mysql_query($query);
					$item = 0;
					
					while($row = mysql_fetch_array($result)){
						$item = $item+1;
						$pdf->SetFillColor(232,232,232);
						$pdf->SetLineWidth(0.4);
						$pdf->Cell(3, 8, '', 0,0,'');
						$pdf->Cell(8, 8, $item, 'R',0,'','');
						$pdf->Cell(25, 8, $row['CreditorCode'], 0,0,'');	
						$pdf->Cell(25, 8, $row['CreditorName'], 0,0,'');	
						$pdf->Cell(20, 8, $row['DatePaid'], 0,0,'');
						$pdf->Cell(20, 8, $row['PaymentType'], 0,0,'');
						$pdf->Cell(20, 8, $row['BankCode'], 0,0,'');
						$pdf->Cell(25, 8, bankName($row['BankCode']), 0,0,'');
						$pdf->Cell(20, 8, $row['BatchNumber'], 0,0,'');
						$pdf->Cell(20, 8, number_format($row["PaymentAmount"],0,'.',','), 0,0,'R');
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
<base target="_self">
   
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Creditor Module</title>
	<link rel="shortcut icon" href="../img/icon.ico">

    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../bootstrap/css/logo-nav.css" rel="stylesheet">
	
	<link href="../css/table.css" rel="stylesheet">
	
    <script src="../bootstrap/js/jquery.js"></script>
    <script src="../bootstrap/js/bootstrap.min.js"></script>
	
	<link rel="stylesheet" type="text/css" href="../css/ui-lightness/jquery-ui-1.9.2.custom.css"
	<script type="text/javascript" src='../js/jquery-ui-1.9.2.custom.js'></script>
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.js"></script>
	<script type="text/javascript" src='../js/jquery-ui.js'></script>
	
	
	
	
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

li#buttons{
	margin-top:2px;
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
			
				<li id="buttons">
					<table>
					<tr>
						<form id="form" name="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
							<td><button name="Print"  value="Print"  class="btn btn-default" /><span class="glyphicon glyphicon-print"> Print</button></td>
						</form>
					</tr>
					</table>
				</li>
			</ul>
		</div>
	</div>
</nav>
<?php

	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "company";
	
	$number = 0;
	$switch = "a";

	//create a connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	//check connection
	if ($conn->connect_error){
		die("connection failed:" . $conn->connect_error);
	}
	
	
			if($CML_Range=='all'){
					$sql = $query_all;
			}
			else if
				($CML_Range=='range'){												
					$sql = $query_view;
			}
			$result = $conn->query($sql);//store the result in a variable
		
			
				echo '<div class="datagrid"><table align="center">
						<thead>
						<tr>
						<th>No.</th>
						<th>Creditor Code</th>
						<th>Creditor Name</th>
						<th>Date</th>
						<th>Txn. Type</th>
						<th>Bank Code</th>
						<th>Bank Name</th>
						<th>Ref. no.</th>
						<th>Amount</th>
						</tr>
						</thead>
						<tfoot><tr><td colspan="9"><div id="no-paging">&nbsp;</div></tr></tfoot>
						<tbody>';
						while($row = $result->fetch_assoc()){
							$number = $number+1;
							if($switch == "a"){
								echo "<tr>";
								$switch = "b";
							}else{
								echo '<tr class="alt">';
								$switch = "a";
							}
							echo "<td>".$number."</td>";
							echo "<td>".$row["CreditorCode"]."</td>";
							echo "<td>".$row["CreditorName"]."</td>";
							echo "<td>".$row["DatePaid"]."</td>";
							echo "<td>".$row["PaymentType"]."</td>";
							echo "<td>".$row["BankCode"]."</td>";
							echo "<td>".bankName($row["BankCode"])."</td>";
							echo "<td>".$row["BatchNumber"]."</td>";
							echo "<td align='right'>".number_format($row["PaymentAmount"],0,'.',',')."</td>";
							echo "</tr>";
						}
				echo '</tbody></table></div>';
				
	
		
			

	
?>


</body>
</html>
