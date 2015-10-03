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
		$this->Cell(100, 8, 'PO Master Listing', 0,0,'C');
		$this->Ln(20);
		$this->SetFillColor(232,232,232);
		$this->SetFont('Arial', 'B', 8);
		$this->SetFillColor(232,232,232);
		$this->Cell(40, 8, '', 0,0,'');
		$this->Cell(10, 8, 'No', 0,0,'',true);
		$this->Cell(20, 8, 'CR Code', 0,0,'',true);
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

$PO_PrintOp = "";
   $CR_Code = "";
	
   $PO_From = "";
	 $PO_To = "";

$POMLerr0 = "";
$POMLerr1 = "";
$POMLerr2 = "";
$downloadfilename = "Purchase_Order.pdf";



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
	
	<link rel="stylesheet" type="text/css" href="../css/ui-lightness/jquery-ui-1.9.2.custom.css"
	<script type="text/javascript" src='../js/jquery-ui-1.9.2.custom.js'></script>
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.js"></script>
	<script type="text/javascript" src='../js/jquery-ui.js'></script>
	
	<script type="text/javascript">
	
	$(document).ready(function(){
		$('#PO_From,#PO_To').datepicker({dateFormat:'yy-mm-dd'});
	});
	
	</script>
	
	<script language="JavaScript">
	function radioCRCode(){	  
		 document.getElementById('CR_Code').disabled=false;
		 document.getElementById('PO_To').disabled=true;
		 document.getElementById('PO_From').disabled=true;
	}
	function radioPODate(){
		 document.getElementById('CR_Code').disabled=true;
		 document.getElementById('PO_To').disabled=false;
		 document.getElementById('PO_From').disabled=false;
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
		
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			
		</div>
	</div>
</nav>

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
*/
	
	if(isset($_POST['View'])){
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){
			
			if(empty($_POST['PO_PrintOp'])){
				$POMLerr0 = "Please choose an option.";
			}else{
				$PO_PrintOp = strip_tags($_POST['PO_PrintOp']);

				if($PO_PrintOp=="ByCreditor"){
					if(empty($_POST['CR_Code'])){
						$POMLerr1 = "Missing";
					}else{
						$CR_Code = strip_tags($_POST['CR_Code']);
					}
						
				}else if($PO_PrintOp=="ByPOD"){
					if(empty($_POST['PO_From']) || empty($_POST['PO_To'])){
						$POMLerr2 = "Missing";
					}else{
						$PO_From = strip_tags($_POST['PO_From']);
						$PO_To = strip_tags($_POST['PO_To']);
					}
				}
			}
		}
	
		if(
		((!empty($_POST['PO_PrintOp']))&&(!empty($_POST['CR_Code']))) ||
		((!empty($_POST['PO_PrintOp']))&&(!empty($_POST['PO_From']))&&(!empty($_POST['PO_To'])))
		){
			
			
			$_SESSION['PO_PrintOp']= $PO_PrintOp;
			$_SESSION['CR_Code']= $CR_Code;
			$_SESSION['PO_From']= $PO_From;
			$_SESSION['PO_To']= $PO_To;
			echo "<script>window.open('crs503r_view.php','view','menubar=0');</script>";
			/*
			if($PO_PrintOp=='ByCreditor'){
				$sql = "SELECT creditormaster.CreditorCode, POtemp, POAmount, PODate, POType FROM purchase
				LEFT JOIN creditormaster
				ON purchase.CreditorCode=creditormaster.CreditorCode
				WHERE purchase.CreditorCode='".$CR_Code."' ORDER BY creditormaster.CreditorCode";//select database
			}else if($PO_PrintOp=='ByPOD'){
				$sql = "SELECT creditormaster.CreditorCode, POtemp, POAmount, PODate, POType FROM purchase
				LEFT JOIN creditormaster
				ON purchase.CreditorCode=creditormaster.CreditorCode
				WHERE PODate BETWEEN '".$PO_From."' AND '".$PO_To."' ORDER BY PODate";
			}
			$result = $conn->query($sql);//store the result in a variable
				echo'<div class="sidebar col-xs-3">';
				echo'<div class="Container">';
				echo'<div class="table_config">';
						echo '<table id="tb1" >
						<tr bgcolor="gray">
						<th>Creditor Code</th>
						<th>PO Number</th>
						<th>Date</th>
						<th>PO Type</th>
						<th>PO Amount</th>
						</tr>';
						while($row = $result->fetch_assoc()){
							echo "<tr>";
							echo "<td>".$row["CreditorCode"]."</td>";
							echo "<td>".$row["POtemp"]."</td>";
							echo "<td>".$row["PODate"]."</td>";
							echo "<td>".$row["POType"]."</td>";
							echo "<td>".$row["POAmount"]."</td>";
							echo "</tr>";
						}
				echo '</table>';
				echo '</div>';
				echo '</div>';
				echo '</div>';
				*/
		}
			
	}
	
	if(isset($_POST['View2'])){
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){
			
			
			$_SESSION['PO_PrintOp']= $PO_PrintOp;
			$_SESSION['CR_Code']= $CR_Code;
			$_SESSION['PO_From']= $PO_From;
			$_SESSION['PO_To']= $PO_To;
			echo "<script>window.open('crs503r_viewall.php','view','menubar=0');</script>";
			
		}
	
			
	}
	
?>



<fieldset>
<legend><strong>Purchase Order Master Listing</strong></legend>
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
				<label><input type="radio" name="PO_PrintDest" id="PO_PrintDest" value="Screen" />Screen</label>
				<label><input type="radio" name="PO_PrintDest" id="PO_PrintDest" value="Printer"/>Printer</label>
				</p></td>
			</tr>-->
			<tr>
				<td style="vertical-align:top">Print Option</td>
				<td><label><input onclick="radioCRCode()" type="radio" name="PO_PrintOp" id="PO_PrintOp" value="ByCreditor" <?php if ($_SESSION['PO_PrintOp']=='ByCreditor') { echo 'checked'; } ?> />By Creditor Code</label>
				<label><input <?php if(empty($_SESSION['CR_Code'])) { echo 'disabled';} else { echo 'value="'.$_SESSION['CR_Code'].'"'; } ?> type="text" name="CR_Code" id="CR_Code" /></label><font color="red"><?php echo $POMLerr1 ;?></font>
				<br><br>
				<label><input onclick="radioPODate()" type="radio" name="PO_PrintOp" id="PO_PrintOp" value="ByPOD" <?php if ($_SESSION['PO_PrintOp']=='ByPOD') { echo 'checked'; } ?> />By Purchase Order Date</label>
				<br>
				<label>from date:<br><input <?php if(empty($_SESSION['PO_From'])) { echo 'disabled';} else { echo 'value="'.$_SESSION['PO_From'].'"'; } ?> type="text" name="PO_From" id="PO_From" /><br> to date: <br><input <?php if(empty($_SESSION['PO_To'])) { echo 'disabled';} else { echo 'value="'.$_SESSION['PO_To'].'"'; } ?> type="text" name="PO_To" id="PO_To" /></label><font color="red"><?php echo $POMLerr2 ;?></font>
				</td>
				
			<table>	
			<!--</tr>
			<tr><td><label><button name="Print"  value="Print"  class="btn btn-default" /><span class="glyphicon glyphicon-print"> Print</button></label></td>
			<td><label><button name="Print2"  value="Print2"  class="btn btn-default" /><span class="glyphicon glyphicon-print"> Print All</button></label></td></tr>-->
			<tr>
			<td><label><button name="View"  value="View"  class="btn btn-default" /><span class="glyphicon glyphicon-eye-open"> View</button></label></td>
			<td><label><button name="View2"  value="View2"  class="btn btn-default" /><span class="glyphicon glyphicon-eye-open"> All Records</button></label></td>
			<td><font color="red"><?php echo $POMLerr0 ;?></font></td></tr>
			</table>
		</form> 
	</table>	
</fieldset>

</body>
</html>
