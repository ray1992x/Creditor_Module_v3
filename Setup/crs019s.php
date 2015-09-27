<!DOCTYPE html>
<?php
//require("../fpdf/fpdf.php");
require("../fpdf/mysql_table.php");
require("../fpdf/cellfit.php");
include("../DatabaseConnect.php");

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

class PDF extends PDF_MYSQL_TABLE{
	
	function Header(){
		$this->SetFont('Arial','B',18);
		$this->Cell(0,6,'Purchase Order Type List',0,1,'C');
		$this->Ln(10);
		parent::Header();
	}
}

$PTT_potype="";
$PTT_podesc="";

$PTTerr0="";
$PTTerr1="";
$PTTnotfound="";

$downloadfilename = "POtype.pdf";

if(isset($_POST['Save'])){
	if ($_SERVER['REQUEST_METHOD'] == 'POST'){
		
		if(empty($_POST['PO_Type'])){
			$PTTerr0 = "Missing";
		}else{
			$PTT_potype = strip_tags($_POST['PO_Type']);
		}
		
		if(empty($_POST['PO_Desc'])){
			$PTTerr1 = "Missing";
		}else{
			$PTT_podesc = strip_tags($_POST['PO_Desc']);
		}
	}
	
	if(	(!empty($_POST['PO_Type'])) &&
		(!empty($_POST['PO_Desc']))
		){
		
		$query = "SELECT * FROM potypetable";
		$records = mysql_query($query) or die (mysql_error());
		$exists = "no";
		while($row=mysql_fetch_array($records)){
			if($row['POtype']==$PTT_potype){
				$exists = "yes";
				break;
			}
		}
		
		if($exists=="no"){
			$query = "Insert INTO `potypetable`(`POtype`,`POdesc`) values ('$PTT_potype','$PTT_podesc')";
			$result = mysql_query($query) or die (mysql_error());
		
			if(!$result){
				$msg = "not Inserted";
			}else{
				$PTT_potype = NULL;
				$PTT_podesc = NULL;
				$PTTnotfound = "Added!";
			}
			
		}else{
			$PTTnotfound = "Already exists!";
		}
		
		
	}
}

if(isset($_POST['View'])){
	if ($_SERVER['REQUEST_METHOD'] == 'POST'){
		
		if(empty($_POST['PO_Type'])){
			$PTTerr0 = "Missing";
		}else{
			$PTT_potype = strip_tags($_POST['PO_Type']);
		}
	
	}
	
	if(	(!empty($_POST['PO_Type']))
		){
		$query = "SELECT * FROM potypetable";
		$records = mysql_query($query) or die (mysql_error());
		$exists = "no";
		while($row=mysql_fetch_array($records)){
			if($row['POtype']==$PTT_potype){
				$exists = "yes";
				$PTT_podesc = $row['POdesc'];
				break;
			}
			
		}
		if($exists=="no"){$PTTnotfound = "Not found";}else{$PTTnotfound = "";}
	}
}

/*
if(isset($_POST['Delete'])){
	if ($_SERVER['REQUEST_METHOD'] == 'POST'){
		
		if(empty($_POST['PO_Type'])){
			$PTTerr0 = "Missing";
		}else{
			$PTT_potype = strip_tags($_POST['PO_Type']);
		}
	
	}
	
	if(	(!empty($_POST['PO_Type']))
		){
		$query = "SELECT * FROM potypetable";
		$records = mysql_query($query) or die (mysql_error());
		$exists = "no";
		while($row=mysql_fetch_array($records)){
			if($row['POtype']==$PTT_potype){
				$exists = "yes";
				$delete = "DELETE FROM potypetable WHERE POtype='".$PTT_potype."'";
				$records = mysql_query($delete) or die (mysql_error());
				$PTT_potype = "";
				break;
			}
		}
		if($exists=="no"){$PTTnotfound = "Not found";}else{$PTTnotfound = "Delete successful!";}
	}						
}
*/

if(isset($_POST['Print'])){
	if ($_SERVER['REQUEST_METHOD'] == 'POST'){
		
		
			$pdf = new PDF();
			$pdf->AddPage('L');
			
			$prop=array('HeaderColor'=>array(112,128,144),
						'color1'=>array(255,255,255),
						'color2'=>array(198,226,255),
						'padding'=>2);
			
			$query = "SELECT * FROM potypetable";
			$records = mysql_query($query) or die (mysql_error());
			$exists = "no";
			while($row=mysql_fetch_array($records)){
				if( (!empty($row['POtype'])) &&
					(!empty($row['POdesc']))
					){
					$exists = "yes";
					$pdf->AddCol('POtype',20,'PO Type','L');
					$pdf->AddCol('POdesc',150,'Description','L');
					$pdf->Table('select POtype, POdesc from potypetable',$prop);
					break;
				}
			}
			
			if ($exists == "no"){
				$pdf->SetTextColor(255,0,0);
				$pdf->Cell(0,50,"There are currently no data to display.",0,0,C);
			}
		
		
		
		$pdf->Output($downloadfilename);
		//header('Location: '."../web/viewer.html?file=../Setup/$downloadfilename#zoom=100");
		echo "<script>window.open('../web/viewer.html?file=../Setup/".$downloadfilename."#zoom=100','_blank_','menubar=0');</script>";
		
	
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
	<script>
		function startTime() {
			var today=new Date();
			var h=today.getHours();
			var m=today.getMinutes();
			var s=today.getSeconds();
			var y=today.getYear();
			var mo=today.getMonth();
			var d=today.getDay();
			m = checkTime(m);
			s = checkTime(s);
			document.getElementById('time').innerHTML = h+":"+m+":"+s;
			var t = setTimeout(function(){startTime()},500);
		}

		function checkTime(i) {
			if (i<10) {i = "0" + i};  // add zero in front of numbers < 10
			return i;
		}
	</script>
	<style>
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

		div#footer{
			position:fixed;
			bottom:0;
			right:auto;
			left:auto;
			width:100%;
			height:40px;
			background-color:grey;
		}

			table#tb2 td{
			border: 5px solid black;
			width:100%;
			background-color:#D8D8D8;
		}
	</style>
</head>
<body onload="startTime()">
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
<div class="container">
<table>
	<td><label><a href="../Setup.php"><button class="btn btn-default"><span class="glyphicon glyphicon-chevron-left"></span></button></a></label>
			<label><a href="crs019s.php"><button class="btn btn-default"><span class="glyphicon glyphicon-refresh"></span> Refresh</button></a></label>
			</table>
<fieldset>
	<legend><strong>Purchase Order Type Table</strong></legend>
	
	
	<table>
		<form id="form" name="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			<tr>
				<td><p>Purchase Order Type</p></td>
				<td><p>
				<label><input type="text" name="PO_Type" id="PO_Type" value="<?php echo $PTT_potype;?>" placeholder="Enter PO type" /></label>
				<td><p><font color="red"><?php echo "$PTTerr0 $PTTnotfound";?></font></p></td>
				</p></td>
			</tr>
			<tr>
				<td><p>Purchase Order Description</p></td>
				<td><p>
				<label><input type="text" name="PO_Desc" id="PO_Desc" value="<?php echo $PTT_podesc;?>" placeholder="Enter PO description" /></label>
				<td><p><font color="red"><?php echo $PTTerr1 ;?></font></p></td>
				</p></td>
			</tr>
			
			<table>
				<tr>
					<td><label><button name="Save" value="Save"   class="btn btn-default" /><span class="glyphicon glyphicon-plus"></span> Add</button></label>
					<label><button name="CView" value="CView"   class="btn btn-default" /><span class="glyphicon glyphicon-eye-open"></span> View</button></label>
					<label><button name="Edit" value="Edit"   class="btn btn-default" /><span class="glyphicon glyphicon-edit"></span> Edit</button></label>
					<label><button name="Update" value="Update"   class="btn btn-default" /><span class="glyphicon glyphicon-refresh"></span> Update</button></label>
					<label><button name="Print"  value="Print"  class="btn btn-default" /><span class="glyphicon glyphicon-print"> Print</button></label>
					</td>
				</tr>
			</table>
		</form> 
				</table>
							  
</fieldset>
</div>
<div id="footer">
	<table id="tb2">
		<tr>
			<td id="noti"><strong>Purchase Order Type Table</strong></td>
			<td id="time" style="font-weight:bold;"></td>
		</tr>
	</table>
</div>
<?php	
	echo '<fieldset class="fieldset1">';
		echo'<div class="table_config">';
				echo '<table id="tb1" >
				<tr bgcolor="gray">
				<th>PO Type</th>
				<th>PO Description</th>
				</tr>';
		echo '</div>';
	echo '</fieldset>';

	
	if(isset($_POST['CView']))
	{
		
		
		//find related creditor
		$sql = "SELECT * FROM potypetable";//select database
		$result = $conn->query($sql);//store the result in a variable
		
		//display related data
		while($row = $result->fetch_assoc()){
			echo "<tr>";
			echo "<td>".$row["POdesc"]."</td>";
			echo "<td>".$row["POtype"]."</td>";
			echo "</tr>";
		}
		echo '</table>';
		
	}	
?>
</body>
</html>
