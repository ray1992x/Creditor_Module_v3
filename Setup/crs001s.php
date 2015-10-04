<!DOCTYPE html>
<?php
//require("../fpdf/fpdf.php");
require("../fpdf/mysql_table.php");
require("../fpdf/cellfit.php");
include("../DatabaseConnect.php");

class PDF extends PDF_MYSQL_TABLE{
	
	function Header(){
		$this->SetFont('Arial','B',18);
		$this->Cell(0,6,'Creditor Control Table',0,1,'C');
		$this->Ln(10);
		parent::Header();
	}
}

$CCT_balance = "";
$CCT_period = "";
$CCT_batchentry = "";
$CCT_bankcode = "";
$CCT_amount = "";
$CCT_POprinting = "";
$CCT_POtype = "";

$CCTerr0 = "";
$CCTerr1 = "";
$CCTerr2 = "";
$CCTerr3 = "";
$CCTerr4 = "";
$CCTerr5 = "";
$CCTerr6 = "";
$CCTerr7 = "";
$CCTerr8 = "";
$CCTerr9 = "";

$downloadfilename = "CRctrltable.pdf";

if(isset($_POST['Save'])){
	if ($_SERVER['REQUEST_METHOD'] == 'POST'){
		
		
		if(empty($_POST['CCT_Balance'])){
			$CCTerr1 = "Missing";
		}else{
			$CCT_balance = strip_tags($_POST['CCT_Balance']);
		}
		
		if(empty($_POST['CCT_Fiscal'])){
			$CCTerr2 = "Missing";
		}else{
			$CCT_period = strip_tags($_POST['CCT_Fiscal']);
		}
		
		if(empty($_POST['Batch_Entry'])){
			$CCTerr3 = "Missing";
		}else{
			$CCT_batchentry = strip_tags($_POST['Batch_Entry']);
		}
		
		if(empty($_POST['Bank_Code'])){
			$CCTerr6 = "Missing";
		}else{
			$CCT_bankcode= strip_tags($_POST['Bank_Code']);
		}
		
		if(empty($_POST['Amount_Number'])){
			$CCTerr7 = "Missing";
		}else{
			$CCT_amount= strip_tags($_POST['Amount_Number']);
		}
		
		if(empty($_POST['PO_Print'])){
			$CCTerr8 = "Missing";
		}else{
			$CCT_POprinting= strip_tags($_POST['PO_Print']);
		}
		
		if(empty($_POST['PO_Print_Type'])){
			$CCTerr9 = "Missing";
		}else{
			$CCT_POtype= strip_tags($_POST['PO_Print_Type']);
		}
	}	
	if(	(!empty($_POST['CCT_Balance'])) &&
		(!empty($_POST['CCT_Fiscal'])) &&
		(!empty($_POST['Batch_Entry'])) &&
		(!empty($_POST['Bank_Code'])) &&
		(!empty($_POST['Amount_Number'])) &&
		(!empty($_POST['PO_Print'])) &&
		(!empty($_POST['PO_Print_Type']))
		){
		$query = "Insert INTO `creditctrltable`(`balance`,`period`,`batchentry`,`bankcode`,`amount`,`POprinting`,`POtype`) values ('$CCT_balance','$CCT_period','$CCT_batchentry','$CCT_bankcode','$CCT_amount','$CCT_POprinting','$CCT_POtype')";
		$result = mysql_query($query) or die (mysql_error());
		
		if(!$result){
			$msg = "not Inserted";
		}else{
			$CCT_balance = NULL;
			$CCT_period = date("F j, Y");
			$CCT_batchentr = NULL;
			$CCT_amount = NULL;
			$CCT_POprinting = NULL;
			$CCT_POtype = NULL;
		}
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
			
			$query = "SELECT * FROM creditctrltable";
			$records = mysql_query($query) or die (mysql_error());
			$exists = "no";
			while($row=mysql_fetch_array($records)){
				if( (!empty($row['amount'])) &&
					(!empty($row['balance'])) &&
					(!empty($row['period'])) &&
					(!empty($row['batchentry'])) &&
					(!empty($row['bankcode'])) &&
					(!empty($row['POprinting'])) &&
					(!empty($row['POtype']))
					){
					$exists = "yes";
					$pdf->AddCol('amount',50,'Account #','L');
					$pdf->AddCol('balance',50,'Current Ledger Balance','L');
					$pdf->AddCol('period',50,'Current Fiscal Period','L');
					$pdf->AddCol('batchentry',50,'Batch Entry','L');
			
					$pdf->Table('select amount, balance, period, batchentry from creditctrltable',$prop);
					
					$pdf->AddPage('L');
			
					$pdf->AddCol('amount',50,'Account #','L');
					$pdf->AddCol('bankcode',50,'Bank code','L');
					$pdf->AddCol('POprinting',50,'PO Printing option','L');
					$pdf->AddCol('POtype',20,'PO type','L');
			
					$pdf->Table('select amount, POprinting, POtype from creditctrltable',$prop);
					break;
				}
			}
			
			if ($exists == "no"){
				$pdf->SetTextColor(255,0,0);
				$pdf->Cell(0,50,"There are currently no data to display.",0,0,'C');
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
		<label><a href="crs001s.php"><button class="btn btn-default"><span class="glyphicon glyphicon-refresh"></span> Refresh</button></a></label>
</table>
<fieldset>
	<legend><strong>Creditor Control Table</strong></legend>
	

	<table >
		<form id="form" name="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			<tr>
				<td><p>Current Ledger Balance</p></td>
				<td><p>
				<label><input type="text" name="CCT_Balance" id="CCT_Balance" placeholder="Enter Current Ledger Balance" value="<?php echo $CCT_balance;?>" /></label>
				</p></td>
				<td><p><font color="red"><?php echo $CCTerr1;?></font></p></td>
			</tr>
			<tr>
				<td><p>Current Fiscal Period</p></td>
				<td><p><label><input type="text" name="CCT_Fiscal" id="CCT_Fiscal"  value="<?php echo $CCT_period;?>"  /></td>
				<td><p><font color="red"><?php echo $CCTerr2;?></font></p></td>
			</tr>
			<tr>
				<td><p>Batch Entry</p></td>
				<td><p><label><input type="radio" name="Batch_Entry" id="Batch_Entry" value="Yes" <?php if ($CCT_batchentry=='Yes') { echo 'checked'; } ?> />Yes</label>
				<label><input type="radio" name="Batch_Entry" id="Batch_Entry" value="No" <?php if ($CCT_batchentry=='No') { echo 'checked'; } ?> />No</label></p></td>
				<td><p><font color="red"><?php echo $CCTerr3;?></font></p></td>
			</tr>
			<tr>
				<td><p>Bank Code</p></td>
				<td><p><label><input type="text" name="Bank_Code" id="Bank_Code" placeholder="Enter Bank Code" value="<?php echo $CCT_bankcode;?>" /></label></p></td>
				<td><p><font color="red"><?php echo $CCTerr6;?></font></p></td>
			</tr>
			<tr>
				<td><p>Account Number</p></td>
				<td><p>
				<label><input type="text" name="Amount_Number" id="Amount_Number" placeholder="Enter Account Number" value="<?php echo $CCT_amount;?>" /></label>
				</p></td>
				<td><p><font color="red"><?php echo $CCTerr7;?></font></p></td>
			</tr>
			<tr>
				<td><p>PO Printing Option</p></td>
				<td><p>
				<label><input type="radio" name="PO_Print" id="PO_Print" value="Yes" <?php if ($CCT_POprinting=='Yes') { echo 'checked'; } ?> />Yes</label>
				<label><input type="radio" name="PO_Print" id="PO_Print" value="No" <?php if ($CCT_POprinting=='No') { echo 'checked'; } ?> />No</label></p></td>
				<td><p>for Purchase order Type
					<select name="PO_Print_Type">
						<?php
						$query = "SELECT POtype FROM potypetable";
						$records = mysql_query($query) or die(mysql_error());	
						while($row=mysql_fetch_array($records)){
							echo '<option value="' . $row['POtype'] . '"';
							if ($CCT_POtype==$row['POtype']){echo 'selected';}
							echo '>' . $row['POtype'] . '</option>';
						}
						?>
					</select>
				</p></td>
				<td><p><font color="red"><?php echo $CCTerr8;?></font></p></td>
			</tr>
			
			<table>
				<tr>
					<td><label><button name="Save" value="Save"   class="btn btn-default" /><span class="glyphicon glyphicon-plus"></span> Add</button></label>
					<label><button name="Edit" value="Edit"   class="btn btn-default" /><span class="glyphicon glyphicon-edit"></span> Edit</button></label>
					<label><button name="Update" value="Update"   class="btn btn-default" /><span class="glyphicon glyphicon-refresh"></span> Update</button></label>
					<label><button name="Print"  value="Print"  class="btn btn-default" /><span class="glyphicon glyphicon-print"> Print</button></label>
					</td>
				</tr>
			</table>
		</form> 
	</table>
							  
</fieldset>

</div></div></div>
<!--<div id="footer">
	<table id="tb2">
		<tr>
			<td id="noti"><strong>Creditor Document Control Number</strong></td>
			<td id="time" style="font-weight:bold;"></td>
		</tr>
	</table>-->
</div>
</body>
</html>
