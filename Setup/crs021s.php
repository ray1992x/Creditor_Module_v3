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
		$this->Cell(0,6,'Document Control Number',0,1,'C');
		$this->Ln(10);
		parent::Header();
	}
}

$CDC_doctype="";
$CDC_docprefix="";
$CDC_docnum="";
$CDC_docyear="";
$CDC_docdesc="";

$CDCerr0="";
$CDCerr1="";
$CDCerr2="";
$CDCerr3="";
$CDCerr4="";
$CDCnotfound="";

$downloadfilename = "DocCtrlNum.pdf";

if(isset($_POST['Save'])){
	if ($_SERVER['REQUEST_METHOD'] == 'POST'){
		
		if(empty($_POST['Doc_Type'])){
			$CDCerr0 = "Missing";
		}else{
			$CDC_doctype = strip_tags($_POST['Doc_Type']);
		}
		
		if(empty($_POST['Doc_Prefix'])){
			$CDCerr1 = "Missing";
		}else{
			$CDC_docprefix = strip_tags($_POST['Doc_Prefix']);
		}
		
		if(empty($_POST['Doc_Num'])){
			$CDCerr2 = "Missing";
		}else{
			$CDC_docnum = strip_tags($_POST['Doc_Num']);
		}
		
		if(empty($_POST['Doc_Year'])){
			$CDCerr3 = "Missing";
		}else{
			$CDC_docyear = strip_tags($_POST['Doc_Year']);
		}
		
		if(empty($_POST['Doc_Desc'])){
			$CDCerr4 = "Missing";
		}else{
			$CDC_docdesc = strip_tags($_POST['Doc_Desc']);
		}
	}
	
	if(	(!empty($_POST['Doc_Type'])) &&
		(!empty($_POST['Doc_Prefix'])) &&
		(!empty($_POST['Doc_Num'])) &&
		(!empty($_POST['Doc_Year'])) &&
		(!empty($_POST['Doc_Desc']))
		){
		$query = "Insert INTO `docctrlnumtable`(`doctype`,`docprefix`,`docnum`,`docyear`,`docdesc`) values ('$CDC_doctype','$CDC_docprefix','$CDC_docnum','$CDC_docyear','$CDC_docdesc')";
		$result = mysql_query($query) or die (mysql_error());
		
		if(!$result){
			$msg = "not Inserted";
		}else{
			$CDC_doctype = NULL;
			$CDC_docprefix = NULL;
			$CDC_docnum = NULL;
			$CDC_docyear = NULL;
			$CDC_docdesc = NULL;
		}
	}
}

if(isset($_POST['Delete'])){
	if ($_SERVER['REQUEST_METHOD'] == 'POST'){
		
		if(empty($_POST['Doc_Prefix'])){
			$CDCerr1 = "Missing";
		}else{
			$CDC_docprefix = strip_tags($_POST['Doc_Prefix']);
		}
	
	}
	
	if(	(!empty($_POST['Doc_Prefix']))
		){
		$query = "SELECT * FROM docctrlnumtable";
		$records = mysql_query($query) or die (mysql_error());
		$exists = "no";
		while($row=mysql_fetch_array($records)){
			if($row['docprefix']==$CDC_docprefix){
				$exists = "yes";
				$delete = "DELETE FROM docctrlnumtable WHERE docprefix='".$CDC_docprefix."'";
				$records = mysql_query($delete) or die (mysql_error());
				$CDC_docprefix = "";
				break;
			}
		}
		if($exists=="no"){$CDCnotfound = "Not found";}else{$CDCnotfound = "Delete successful!";}	
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
			
			$query = "SELECT * FROM docctrlnumtable";
			$records = mysql_query($query) or die (mysql_error());
			$exists = "no";
			while($row=mysql_fetch_array($records)){
				if( (!empty($row['docdesc'])) &&
					(!empty($row['docnum'])) &&
					(!empty($row['docprefix'])) &&
					(!empty($row['doctype'])) &&
					(!empty($row['docyear']))
					){
					$exists = "yes";
					$pdf->AddCol('doctype',20,'Type','L');
					$pdf->AddCol('docprefix',30,'Prefix','L');
					$pdf->AddCol('docnum',30,'Document no.','L');
					$pdf->AddCol('docyear',20,'Year','L');
					$pdf->AddCol('docdesc',150,'Description','L');
					
					$pdf->Table('select doctype, docprefix, docnum, docyear, docdesc from docctrlnumtable',$prop);
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
			<label><a href="crs021s.php"><button class="btn btn-default"><span class="glyphicon glyphicon-refresh"></span> Refresh</button></a></label>
			</table>
<fieldset>
<legend><strong>Creditor Document Control Number</strong></legend>
	
	<table>
		<form id="form" name="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			<tr>
				<td><p>Document Type</p></td>
				<td><p>
				<label><input type="radio" name="Doc_Type" id="Doc_Type" value="PO" <?php if ($CDC_doctype=='PO') { echo 'checked'; } ?> />Purchase Order</label>
				</p></td>
				
				<td><p>
				<label><input type="radio" name="Doc_Type" id="Doc_Type" value="PV" <?php if ($CDC_doctype=='PV') { echo 'checked'; } ?> />Payment Voucher</label>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				</p></td>
				
				<td><p>
				<label><input type="radio" name="Doc_Type" id="Doc_Type" value="J" <?php if ($CDC_doctype=='J') { echo 'checked'; } ?> />Journal</label>
				</p></td>
				
				<td><p><font color="red"><?php echo $CDCerr0 ;?></font></p></td>
			</tr>
			<tr>
				<td><p>Document Prefix</p></td>
				<td><p>
				<label><input type="text" name="Doc_Prefix" id="Doc_Prefix" placeholder="Enter Document Prefix" /></label>
				</p></td>
				<td><p><font color="red"><?php echo "$CDCerr1 $CDCnotfound" ;?></font></p></td>
			</tr>
			<tr>
				<td><p>Document Number</p></td>
				<td><p>
				<label><input type="text" name="Doc_Num" id="Doc_Num" placeholder="Enter Document Number" /></label>
				</p></td>
				<td><p><font color="red"><?php echo $CDCerr2 ;?></font></p></td>
			</tr>
			<tr>
				<td><p>Document Year</p></td>
				<td><p>
				<label><input type="text" name="Doc_Year" id="Doc_Year" placeholder="Enter Document Year" /></label>
				</p></td>
				<td><p><font color="red"><?php echo $CDCerr3 ;?></font></p></td>
			</tr>
			<tr>
				<td><p>Document Description</p></td>
				<td><p>
				<label><input type="text" name="Doc_Desc" id="Doc_Desc" placeholder="Enter Document Description" /></label>
				</p></td>
				<td><p><font color="red"><?php echo $CDCerr4 ;?></font></p></td>
			</tr>
			
			<table>
				<tr>
					<td><label><button name="Save" value="Save"   class="btn btn-default" /><span class="glyphicon glyphicon-plus"></span> Add</button></label>
					<label><button name="CView" value="CView"   class="btn btn-default" /><span class="glyphicon glyphicon-eye-open"></span> View</button></label>
					<label><button name="Edit" value="Edit"   class="btn btn-default" /><span class="glyphicon glyphicon-edit"></span> Edit</button></label>
					<label><button name="Delete" value="Delete"   class="btn btn-default" /><span class="glyphicon glyphicon-remove"></span> Delete</button></label>
					<label><button name="Update" value="Update"   class="btn btn-default" /><span class="glyphicon glyphicon-refresh"></span> Update</button></label>
					<label><button name="Print"  value="Print"  class="btn btn-default" /><span class="glyphicon glyphicon-print"> Print</button></label></td>
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
			<td id="noti"><strong>Creditor Document Control Number</strong></td>
			<td id="time" style="font-weight:bold;"></td>
		</tr>
	</table>
</div>-->
<?php	
	/*echo '<fieldset class="fieldset1">';
		echo'<div class="table_config">';
				echo '<table id="tb1" >
				<tr bgcolor="gray">
				<th>Document Type</th>
				<th>Document Prefix</th>
				<th>Document No.</th>
				<th>Year</th>
				<th>Description</th>
				<th>Document Control Number</th>
				</tr>';
		echo '</div>';
	echo '</fieldset>';

	
	if(isset($_POST['CView']))
	{
		
		
		//find related creditor
		$sql = "SELECT * FROM docctrlnumtable";//select database
		$result = $conn->query($sql);//store the result in a variable
		
		//display related data
		while($row = $result->fetch_assoc()){
			echo "<tr>";
			if($row["doctype"]=='PO'){
				echo "<td>Purchase Order</td>";
			}else if($row["doctype"]=='PV'){
				echo "<td>Payment Voucher</td>";
			}else if($row["doctype"]=='J'){
				echo "<td>Journal</td>";
			}
			echo "<td>".$row["docprefix"]."</td>";
			echo "<td>".$row["docnum"]."</td>";
			echo "<td>".$row["docyear"]."</td>";
			echo "<td>".$row["docdesc"]."</td>";
			echo "<td>".$row["doctype"].$row["docnum"].$row["docyear"]."</td>";
			echo "</tr>";
		}
		echo '</table>';
		
	}	*/
?>
</body>
</html>
