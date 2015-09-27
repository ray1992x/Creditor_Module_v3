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
		$this->Cell(0,6,'Creditor Type List',0,1,'C');
		$this->Ln(10);
		parent::Header();
	}
}

$CTT_crtype="";
$CTT_crdesc="";

$CTTerr0="";
$CTTerr1="";
$CTTnotfound="";

$downloadfilename = "CRtype.pdf";

if(isset($_POST['Save'])){
	if ($_SERVER['REQUEST_METHOD'] == 'POST'){
		
		if(empty($_POST['CR_Type'])){
			$PTTerr0 = "Missing";
		}else{
			$CTT_crtype = strip_tags($_POST['CR_Type']);
		}
		
		if(empty($_POST['CR_Desc'])){
			$PTTerr1 = "Missing";
		}else{
			$CTT_crdesc = strip_tags($_POST['CR_Desc']);
		}
	}
	
	if(	(!empty($_POST['CR_Type'])) &&
		(!empty($_POST['CR_Desc']))
		){
		
		$query = "SELECT * FROM credittypetable";
		$records = mysql_query($query) or die (mysql_error());
		$exists = "no";
		while($row=mysql_fetch_array($records)){
			if($row['CRtype']==$CTT_crtype){
				$exists = "yes";
				break;
			}
		}
		
		if($exists=="no"){
			$query = "Insert INTO `credittypetable`(`CRtype`,`CRdesc`) values ('$CTT_crtype','$CTT_crdesc')";
			$result = mysql_query($query) or die (mysql_error());
		
			if(!$result){
				$msg = "not Inserted";
			}else{
				$CTT_crtype = NULL;
				$CTT_crdesc = NULL;
				$CTTnotfound = "Added!";
			}
		}else{
			$CTTnotfound = "Already exists!";
		}
		
	}
}

if(isset($_POST['View'])){
	if ($_SERVER['REQUEST_METHOD'] == 'POST'){
		
		if(empty($_POST['CR_Type'])){
			$CTTerr0 = "Missing";
		}else{
			$CTT_crtype = strip_tags($_POST['CR_Type']);
		}
	
	}
	
	if(	(!empty($_POST['CR_Type']))
		){
		$query = "SELECT * FROM credittypetable";
		$records = mysql_query($query) or die (mysql_error());
		$exists = "no";
		while($row=mysql_fetch_array($records)){
			if($row['CRtype']==$CTT_crtype){
				$exists = "yes";
				$CTT_crdesc = $row['CRdesc'];
				break;
			}
			
		}
		if($exists=="no"){$CTTnotfound = "Not found";}else{$CTTnotfound = "";}		
	}
}

if(isset($_POST['Delete'])){
	if ($_SERVER['REQUEST_METHOD'] == 'POST'){
		
		if(empty($_POST['CR_Type'])){
			$CTTerr0 = "Missing";
		}else{
			$CTT_crtype = strip_tags($_POST['CR_Type']);
		}
	
	}
	
	if(	(!empty($_POST['CR_Type']))
		){
		$query = "SELECT * FROM credittypetable";
		$records = mysql_query($query) or die (mysql_error());
		$exists = "no";
		while($row=mysql_fetch_array($records)){
			if($row['CRtype']==$CTT_crtype){
				$exists = "yes";
				$delete = "DELETE FROM credittypetable WHERE CRtype='".$CTT_crtype."'";
				$records = mysql_query($delete) or die (mysql_error());
				$CTT_crtype = "";
				break;
			}
		}
		if($exists=="no"){$CTTnotfound = "Not found";}else{$CTTnotfound = "Delete successful!";}	
	}						
}

if(isset($_POST['Print'])){
	if ($_SERVER['REQUEST_METHOD'] == 'POST'){
		
		
			$pdf = new PDF();
			$pdf->AddPage('L');
			
			$prop=array('HeaderColor'=>array(112,128,144),
						'color1'=>array(255,255,255),
						'color2'=>array(198,226,255),
						'padding'=>2);
			
			$query = "SELECT * FROM credittypetable";
			$records = mysql_query($query) or die (mysql_error());
			$exists = "no";
			while($row=mysql_fetch_array($records)){
				if( (!empty($row['CRtype'])) &&
					(!empty($row['CRdesc']))
					){
					$exists = "yes";
					$pdf->AddCol('CRtype',50,'Creditor Type','L');
					$pdf->AddCol('CRdesc',150,'Description','L');
					$pdf->Table('select CRtype, CRdesc from credittypetable',$prop);
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
	<?php include('inc/header.php') ?>
    <?php include('inc/dhtmlx.php') ?>
	
</head>
<body onload="startTime()">
<?php include('inc/Nav.php') ?>
	
	
<div id="page-wrapper">
	<div class="row">
		<div class="col-lg-12">
<table>
	<td><label><a href="../Setup.php"><button class="btn btn-default"><span class="glyphicon glyphicon-chevron-left"></span></button></a></label>
			<label><a href="crs020s.php"><button class="btn btn-default"><span class="glyphicon glyphicon-refresh"></span> Refresh</button></a></label>
			</table>
			
<fieldset>
<legend><strong>Maintenance of Creditor Type Table</strong></legend>
<div class="panel-heading">
	<div class="pull-right">
		<div class="btn-group">
			<button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
				Demo
				<span class="caret"></span>
			</button>
			<ul class="dropdown-menu pull-right" role="menu">								
				<li><a href="#" id="buttonPrint"><span class="glyphicon glyphicon-print"></span> Print</a></li>							
			</ul>
		</div>
	</div>
</div>	
	
	<table>
		<form id="form" name="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			<tr>
				<td width="200"><p>Creditor Type</p></td>
				<td><p>
				<label><input type="text"   name="CR_Type" id="CR_Type" value="<?php echo $CTT_crtype;?>" placeholder="Enter Creditor Type" /></label>
				<td><p><font color="red"><?php echo "$CTTerr0 $CTTnotfound";?></font></p></td>
				</p></td>
			</tr>
			<tr>
				<td><p>Creditor Description</p></td>
				<td><p>
				<label><input type="text"   name="CR_Desc" id="CR_Desc" value="<?php echo $CTT_crdesc;?>" placeholder="Enter Creditor Description" /></label>
				<td><p><font color="red"><?php echo $CTTerr1;?></font></p></td>
				</p></td>
			</tr>
			</table>
			<table>
				<tr>
					<td><label><button name="Save" value="Save"   class="btn btn-default" /><span class="glyphicon glyphicon-plus"></span> Add</button></label>
					<label><button name="CView" value="CView"   class="btn btn-default" /><span class="glyphicon glyphicon-eye-open"></span> View</button></label>
					<label><button name="Edit" value="Edit"   class="btn btn-default" /><span class="glyphicon glyphicon-edit"></span> Edit</button></label>
					<label><button name="Delete" value="Delete"   class="btn btn-default" /><span class="glyphicon glyphicon-remove"></span> Delete</button></label>
					<label><button name="Update" value="Update"   class="btn btn-default" /><span class="glyphicon glyphicon-refresh"></span> Update</button></label>
					<label><button name="Print"  value="Print"  class="btn btn-default" /><span class="glyphicon glyphicon-print"> Print</button></label>
					</td>
				</tr>
			</table>
		</form> 
	</table>
							  
</fieldset>
</div>
</div>
</div>
<!--<div id="footer">
	<table id="tb2">
		<tr>
			<td id="noti"><strong>Creditor Type Table</strong></td>
			<td id="time" style="font-weight:bold;"></td>
		</tr>
	</table>
</div>-->
<?php	
	/*echo '<fieldset class="fieldset1">';
		echo'<div class="table_config">';
				echo '<table id="tb1" >
				<tr bgcolor="gray">
				<th>Creditor Type</th>
				<th>Creditor Type Description</th>
				</tr>';
		echo '</div>';
	echo '</fieldset>';

	
	if(isset($_POST['CView']))
	{
		
		
		//find related creditor
		$sql = "SELECT * FROM credittypetable";//select database
		$result = $conn->query($sql);//store the result in a variable
		
		//display related data
		while($row = $result->fetch_assoc()){
			echo "<tr>";
			echo "<td>".$row["CRdesc"]."</td>";
			echo "<td>".$row["CRtype"]."</td>";
			echo "</tr>";
		}
		echo '</table>';
		
	}	*/
?>
</body>
</html>
