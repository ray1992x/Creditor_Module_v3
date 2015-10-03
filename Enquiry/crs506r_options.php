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
		$this->Cell(100, 8, 'Creditor Batch Listing', 0,0,'C');
		$this->Ln(20);
		$this->SetFillColor(232,232,232);
		$this->SetFont('Arial', 'B', 8);
		$this->SetFillColor(232,232,232);
		$this->Cell(10, 8, 'No', 0,0,'',true);
		$this->Cell(20, 8, 'Batch No.', 0,0,'',true);
		$this->Cell(20, 8, 'Batch Type', 0,0,'',true);
		$this->Cell(20, 8, 'Date', 0,0,'',true);
		$this->Cell(20, 8, 'Period', 0,0,'',true);
		$this->Cell(20, 8, 'Batch Total', 0,0,'',true);
		$this->Cell(20, 8, 'Check Total', 0,0,'',true);
		$this->Cell(20, 8, 'Difference', 0,0,'',true);
		$this->Cell(30, 8, 'TransactionCount', 0,0,'',true);
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

$CR_BatchType = "";
$CR_Number = "";

$POMLerr0 = "";
$POMLerr1 = "";

$downloadfilename = "Batch_Listing.pdf";
/*
if(isset($_POST['Print'])){
	if ($_SERVER['REQUEST_METHOD'] == 'POST'){
		
		if(empty($_POST['Batch_Type'])){
			$POMLerr0 = "Please choose an option.";
		}else{
			$CR_BatchType = strip_tags($_POST['Batch_Type']);
		}
		
		if(empty($_POST['CR_Num'])){
			$POMLerr1 = "Missing";
		}else{
			$CR_Number = strip_tags($_POST['CR_Num']);
		}
		
		
	}
	
	if((!empty($_POST['Batch_Type'])) && (!empty($_POST['CR_Num']))){

			$pdf = new PDF();
			$pdf->AliasNbPages();
			$pdf->AddPage('P');
			$pdf->SetFont('Arial', '', 8);
						
			$query = "SELECT * FROM batchheader";
			$records = mysql_query($query) or die (mysql_error());
			$exists = "no";
			while($row=mysql_fetch_array($records)){
				if( (!empty($row['BatchType'])) &&
					(!empty($row['BatchNumber'])) &&
					(!empty($row['BatchDate'])) &&
					(!empty($row['BatchPeriod'])) &&
					(!empty($row['BatchTotal'])) &&
					(!empty($row['TransactionCount']))
					){
					$exists = "yes";	
						$query = "SELECT BatchNumber,BatchType,BatchDate,BatchPeriod,BatchTotal,CheckTotal,Difference,TransactionCount FROM batchheader WHERE BatchType='".$CR_BatchType."' AND BatchNumber='".$CR_Number."' ORDER BY BatchType";
						$result = mysql_query($query);
						$item = 0;
						
						while($row = mysql_fetch_array($result)){
							$item = $item+1;
							$pdf->SetFillColor(232,232,232);
							$pdf->Cell(10, 8, $item, 0,0,'',true);
							$pdf->Cell(20, 8, $row['BatchNumber'], 0,0,'');
							$pdf->Cell(20, 8, $row['BatchType'], 0,0,'');
							$pdf->Cell(20, 8, $row['BatchDate'], 0,0,'');
							$pdf->Cell(20, 8, $row['BatchPeriod'], 0,0,'');
							$pdf->Cell(20, 8, $row['BatchTotal'], 0,0,'');
							$pdf->Cell(20, 8, $row['CheckTotal'], 0,0,'');
							$pdf->Cell(20, 8, $row['Difference'], 0,0,'');
							$pdf->Cell(30, 8, $row['TransactionCount'], 0,0,'');
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

if(isset($_POST['Print2'])){
	if ($_SERVER['REQUEST_METHOD'] == 'POST'){
		
			$pdf = new PDF();
			$pdf->AliasNbPages();
			$pdf->AddPage('P');
			$pdf->SetFont('Arial', '', 8);
						
			$query = "SELECT * FROM batchheader";
			$records = mysql_query($query) or die (mysql_error());
			$exists = "no";
			while($row=mysql_fetch_array($records)){
				if( (!empty($row['BatchType'])) &&
					(!empty($row['BatchNumber'])) &&
					(!empty($row['BatchDate'])) &&
					(!empty($row['BatchPeriod'])) &&
					(!empty($row['BatchTotal'])) &&
					(!empty($row['TransactionCount']))
					){
					$exists = "yes";	
						$query = "SELECT BatchNumber,BatchType,BatchDate,BatchPeriod,BatchTotal,CheckTotal,Difference,TransactionCount FROM batchheader ORDER BY BatchType";
						$result = mysql_query($query);
						$item = 0;
						
						while($row = mysql_fetch_array($result)){
							$item = $item+1;
							$pdf->SetFillColor(232,232,232);
							$pdf->Cell(10, 8, $item, 0,0,'',true);
							$pdf->Cell(20, 8, $row['BatchNumber'], 0,0,'');
							$pdf->Cell(20, 8, $row['BatchType'], 0,0,'');
							$pdf->Cell(20, 8, $row['BatchDate'], 0,0,'');
							$pdf->Cell(20, 8, $row['BatchPeriod'], 0,0,'');
							$pdf->Cell(20, 8, $row['BatchTotal'], 0,0,'');
							$pdf->Cell(20, 8, $row['CheckTotal'], 0,0,'');
							$pdf->Cell(20, 8, $row['Difference'], 0,0,'');
							$pdf->Cell(30, 8, $row['TransactionCount'], 0,0,'');
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
*/
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

	
 	function changeRadioButton(el){
		var BT = el.value.charAt(0);
	
		var d = new Date();
		var year = d.getFullYear();
		var monthTemp = d.getMonth() + 1;
		var month;
		if(monthTemp < 10){
			month = '0' + monthTemp;
		}else{
			month = monthTemp;
		}
	
		var autogen = BT + "B" + year;
	
		var input;
		if (el.value == 'Invoice'){
			input = autogen;
		}else if(el.value == 'Credit Note'){
			input = autogen;
			
		}else if(el.value == 'Journal'){
			input = autogen;
		}else if(el.value == 'Auto Payment'){
			input = autogen;
		}else if(el.value == 'Manual Payment'){
			input = autogen;
		}
			
		document.getElementById("CR_Num").value = input;
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
<base target="_self">

<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
	<div class="container">
		
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			
		</div>
	</div>
</nav>

<fieldset>
<legend><strong>Creditor Batch Listing</strong></legend>
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
				<label><input type="radio" name="CBL_PrintDest" id="CBL_PrintDest" value="Screen" />Screen</label>
				<label><input type="radio" name="CBL_PrintDest" id="CBL_PrintDest" value="Printer"/>Printer</label>
				</p></td>
			</tr>-->
			<tr>
				<td><p>Batch Type<br>&nbsp;</p></td>
				<td>
				<label><input onclick="changeRadioButton(this)" type="radio" name="Batch_Type" id="Batch_Type" value="Invoice" />Invoice &nbsp;</label>
				<label><input onclick="changeRadioButton(this)" type="radio" name="Batch_Type" id="Batch_Type" value="Credit Note"/>Credit Note &nbsp;</label>
				<label><input onclick="changeRadioButton(this)" type="radio" name="Batch_Type" id="Batch_Type" value="Journal"/>Journal &nbsp;</label>
				<label><input onclick="changeRadioButton(this)" type="radio" name="Batch_Type" id="Batch_Type" value="Auto Payment"/>Auto Payment &nbsp;</label>
				<label><input onclick="changeRadioButton(this)" type="radio" name="Batch_Type" id="Batch_Type" value="Manual Payment"/>Manual Payment &nbsp;</label>
				<br><font color="red"><?php echo $POMLerr0;?></font>&nbsp;
				</td>
			</tr>
			<tr>
				<td>Batch Number</td>
				<td><label><input type="text" name="CR_Num" id="CR_Num" /></label><font color="red"><?php echo $POMLerr1;?></font></td>
			<tr>
			<table>
			<tr>
			<td><label><button name="View"  value="View"  class="btn btn-default" /><span class="glyphicon glyphicon-eye-open"> View</button></label></td>
			<td><label><button name="Print2"  value="Print2"  class="btn btn-default" /><span class="glyphicon glyphicon-eye-open"> View All</button></label></td>
			</tr>
			</table>
			
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
		
		if(empty($_POST['Batch_Type'])){
			$POMLerr0 = "Please choose an option.";
		}else{
			$CR_BatchType = strip_tags($_POST['Batch_Type']);
		}
		
		if(empty($_POST['CR_Num'])){
			$POMLerr1 = "Missing";
		}else{
			$CR_Number = strip_tags($_POST['CR_Num']);
		}		
	}
	
	if((!empty($_POST['Batch_Type'])) && (!empty($_POST['CR_Num']))){
		
		$_SESSION['CR_BatchType'] = $CR_BatchType;
		$_SESSION['CR_Number'] = $CR_Number;
		echo "<script>window.open('crs506r_view.php','view','menubar=0');</script>";
		/*
		$sql = "SELECT BatchNumber,BatchType,BatchDate,BatchPeriod,BatchTotal,CheckTotal,Difference,TransactionCount FROM batchheader WHERE BatchType='".$CR_BatchType."' AND BatchNumber LIKE '%".$CR_Number."%' ORDER BY BatchType";//select database
		$result = $conn->query($sql);//store the result in a variable
			echo'<div class="Container">';
			echo'<div class="table_config">';
					echo '<table id="tb1" >
					<tr bgcolor="gray">
					<th>Batch Type</th>
					<th>Batch Number</th>
					<th>Batch Date</th>
					<th>Batch Period</th>
					<th>Batch Total</th>
					<th>Check Total</th>
					<th>Difference</th>
					<th>Transaction Count</th>
					</tr>';
					while($row = $result->fetch_assoc()){
						echo "<tr>";
						echo "<td>".$row["BatchType"]."</td>";
						echo "<td>".$row["BatchNumber"]."</td>";
						echo "<td>".$row["BatchDate"]."</td>";
						echo "<td>".$row["BatchPeriod"]."</td>";
						echo "<td>".$row["BatchTotal"]."</td>";
						echo "<td>".$row["CheckTotal"]."</td>";
						echo "<td>".$row["Difference"]."</td>";
						echo "<td>".$row["TransactionCount"]."</td>";
						echo "</tr>";
					}
			echo '</table>';
			echo '</div>';
			echo '</div>';
			*/
		}
	}
	
	if(isset($_POST['Print2'])){
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){
			
			
			echo "<script>window.open('crs506r_viewall.php','view','menubar=0');</script>";
			
		}
	
			
	}
?>
</body>
</html>
