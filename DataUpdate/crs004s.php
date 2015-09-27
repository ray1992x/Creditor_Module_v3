<!DOCTYPE html>
<?php
include("../DatabaseConnect.php");
$CR_Code = "";
$INV_Num = "";
$INV_Total = "";
$INV_Date = "";
$INV_Desc = "";
$PAY_Due = "";
$PO_Number = "";
$PO_Type = "";
$Batch_Num = "";
$SEQ_Num = 0;
$Batch_Value = "";
	$checkseq = 0;

$CR_Code_Err = "";
$INV_Num_Err = "";
$INV_Total_Err = "";
$INV_Date_Err = "";
$INV_Desc_Err = "";
$PAY_Due_Err = "";
$PO_Number_Err = "";
$PO_Type_Err = "";
$Batch_Num_Err = "";
$SEQ_Num_Err = "";
$Batch_Value_Err = "";
$INVExist = " ";
$INVInvalid = " ";
$msg = "";
$counter = 1;
$sequence = 1;
$POUsed = "";
$total = 0;
$count = "";
//$aa = $_SESSION['testing'];
if(isset($_POST['Add']))
{
	$aa = "";
	
}
	

if(isset($_POST['Confirm']))
{
	if ($_SERVER["REQUEST_METHOD"] == "POST") {	
			if ($_SERVER["REQUEST_METHOD"] == "POST") {

				if(empty($_POST["INV_Num"])) {
				$INV_Num_Err = " (Required)";
				}else {
				$INV_Num = strip_tags($_POST['INV_Num']);
				}

				if(empty($_POST["Batch_Num"])) {
				$Batch_Num_Err = " (Required)";
				}else {
				$Batch_Num = strip_tags($_POST['Batch_Num']);
				}

				
				if(empty($_POST["CR_Code"])) {
				$CR_Code_Err = " (Required)";
				}else {
				$CR_Code = strip_tags($_POST['CR_Code']);
				}
				if(empty($_POST["INV_Total"])) {
				$INV_Total_Err = " (Required)";
				}else {
				$INV_Total = strip_tags($_POST['INV_Total']);
				}
				if(empty($_POST["INV_Date"])) {
				$INV_Date_Err = " (Required)";
				}else{
				$INV_Date = strip_tags($_POST['INV_Date']);
				}
				if(empty($_POST["PAY_Due"])) {
				$PAY_Due_Err = " (Required)";
				}else{
				$PAY_Due = strip_tags($_POST['PAY_Due']);
				}
				if(empty($_POST["PO_Number"])) {
				$PO_Number_Err = " (Required)";
				}else{
				$PO_Number = strip_tags($_POST['PO_Number']);
				}
				if(empty($_POST["PO_Type"])) {
				$PO_Type_Err = " (Required)";
				}else{
				$PO_Type = strip_tags($_POST['PO_Type']);
				}
				$INV_Desc = strip_tags($_POST['INV_Desc']);
				$Batch_Value = strip_tags($_POST['Batch_Value']);
			}
		
	}

	
	$query = "Select MAX(SequenceNumber) AS maxseq FROM `invoice` WHERE `BatchNumber`='$Batch_Num'";
		$records = mysql_query($query) or die (mysql_error());
		while($row=mysql_fetch_array($records)){
			$SEQ_Num = $row['maxseq'];		
		}$query1 = "Select TransactionCount FROM BatchHeader WHERE BatchNumber='$Batch_Num'";
		$records1 = mysql_query($query1) or die (mysql_error());
		while($row1=mysql_fetch_array($records1)){
			$checkseq = $row1['TransactionCount'];
		}
		if($SEQ_Num > $checkseq){
			$Batch_Num_Err = "* Max no. of Invoice";
			$Batch_Num = NULL;
			$SEQ_Num = NULL;
			$INV_Num = NULL;
			$CR_Code = NULL;
			$INV_Desc = NULL;
			$INV_Total = NULL;
			$INV_Date = NULL;
			$PAY_Due = NULL;
			$PO_Number = NULL;
			$PO_Type = NULL;
			$Batch_Value = NULL;
		}
		else
		{			
			$SEQ_Num++;	
			$query1 = "UPDATE BatchHeader SET CheckTotal = '$SEQ_Num' WHERE BatchNumber = '$Batch_Num'";
			$result1 = mysql_query($query1) or die(mysql_error());
			
			if((!empty($_POST["INV_Num"]))&&(!empty($_POST["Batch_Num"]))&&(!empty($_POST["CR_Code"]))&&(!empty($_POST["INV_Total"]))&&(!empty($_POST["INV_Date"]))&&(!empty($_POST["PAY_Due"]))&&(!empty($_POST["PO_Number"]))&&(!empty($_POST["PO_Type"]))) {						
			
				$query = " Select * FROM invoice";
				$result = mysql_query($query) or die(mysql_error());
				$exists = "no";
				$exists2 = "no";

				while($row = mysql_fetch_array($result)){
					if($row['InvNumber'] == $INV_Num ){
						$exists = "yes";
						break;
					}
				}
				if($exists == "no"  ){
					$query = " Select * FROM invoice";
					$result = mysql_query($query) or die(mysql_error());
					$exists2 = "no";

					while($row = mysql_fetch_array($result)){
						if($row['PONumber'] == $PO_Number){
							$exists2 = "yes";
							break;
						}
					}
					if($exists2 == "no" ){
						$query = "Insert INTO `invoice`( `InvNumber`, `BatchNumber`, `SequenceNumber`, `CreditorCode`, `InvoiceDescription`,`InvoiceTotal`, `InvoiceDate`,`DatePaymentDue`, `PONumber`, `POType`)
						values('$INV_Num','$Batch_Num','$SEQ_Num','$CR_Code','$INV_Desc','$INV_Total','$INV_Date','$PAY_Due','$PO_Number','$PO_Type')";
						//$query ="Insert INTO `invoice` (`BatchValue`) values ((select `BatchValue` from `BatchHeader` where `BatchNumber` = $Batch_Num))";

						$result = mysql_query($query) or die(mysql_error());

						//insert statement for retrieve  batch value *
						if(!$result) 
						{
							$msg = "not Inserted";

						}
						else
						{
							
								$query ="UPDATE `invoice` SET `BatchValue`=(SELECT `BatchTotal` from `batchheader` where `BatchNumber` = '$Batch_Num') where `BatchNumber`= '$Batch_Num'";
								$result = mysql_query($query) or die(mysql_error());	
								$_SESSION['invnumber']=$INV_Num;//store $invoice number 
								$_SESSION['invbatch']=$Batch_Num;
								if(!$result)
								{
									$msg = "not Inserted";

								}
								else
								{
									$query ="INSERT INTO ivdetailtable (CreditorCode, PONumber,itemid, Description,Quantity,UnitPrice,ItemPrice) 
											 SELECT CreditorCode, POtemp, itemid, Description, booktitle, author, price FROM podetailtable
											 WHERE POtemp = '$PO_Number'";
									$result = mysql_query($query) or die(mysql_error());	
								
								
										if(!$result)
										{
											$msg = "not Inserted";
										}
										else
										{
											$query ="UPDATE ivdetailtable SET InvNumber='$INV_Num' WHERE PONumber='$PO_Number'";
											$result = mysql_query($query) or die(mysql_error());	
											if(!$result)
											{
												$msg = "not Inserted";

											}
											else
											{
												$query="SELECT * FROM `invoice` WHERE `InvNumber`='$INV_Num'";
												$records = mysql_query($query) or die(mysql_error());
												$query1="SELECT SUM(ItemPrice) as Total FROM `ivdetailtable` WHERE `InvNumber`='$INV_Num'";
												$records1 = mysql_query($query1) or die(mysql_error());	
												while($row=mysql_fetch_array($records))
												{
													$Batch_Num = $row['BatchNumber'];
													$SEQ_Num = $row['SequenceNumber'];
													$INV_Num = $row['InvNumber'];
													$CR_Code = $row['CreditorCode'];
													$INV_Desc = $row['InvoiceDescription'];
													$INV_Total = $row['InvoiceTotal'];
													$INV_Date = $row['InvoiceDate'];
													$PAY_Due = $row['DatePaymentDue'];
													$PO_Number = $row['PONumber'];
													$PO_Type = $row['POType'];
													$Batch_Value = $row['BatchValue'];
												}
												while($row1=mysql_fetch_array($records1))
												{
													$total = $row1['Total'];
												}
											}
										}
								}
						}	
					}else{
						$POUsed = "Already Invoiced";
					}
				}else{
					$INVExist = "Already exists";
					
				}


			}
		}
}


else if(isset($_POST['CView']))
{

$INV_Num = strip_tags($_POST['INV_Num']);
$_SESSION['invnumber']=$INV_Num;

$query1 = " Select * FROM invoice";
$result = mysql_query($query1) or die(mysql_error());
$exists = "no";

while($row = mysql_fetch_array($result)){
	if($row['InvNumber'] == $INV_Num){
		$exists = "yes";
		break;
	}
}
if($exists == "no"){
	echo "";
	$INVInvalid = "No PO Number Found";
}else{
	
$query="SELECT * FROM `invoice` WHERE `InvNumber`='$INV_Num'";
$records = mysql_query($query) or die(mysql_error());
$query1="SELECT SUM(ItemPrice) as Total FROM `ivdetailtable` WHERE `InvNumber`='$INV_Num'";
$records1 = mysql_query($query1) or die(mysql_error());	
while($row=mysql_fetch_array($records))
{
	$Batch_Num = $row['BatchNumber'];
	$SEQ_Num = $row['SequenceNumber'];
	$INV_Num = $row['InvNumber'];
	$CR_Code = $row['CreditorCode'];
	$INV_Desc = $row['InvoiceDescription'];
	$INV_Total = $row['InvoiceTotal'];
	$INV_Date = $row['InvoiceDate'];
	$PAY_Due = $row['DatePaymentDue'];
	$PO_Number = $row['PONumber'];
	$PO_Type = $row['POType'];
	$Batch_Value = $row['BatchValue'];
}
while($row1=mysql_fetch_array($records1))
{
	$total = $row1['Total'];
}

}


}	
else if(isset($_POST['Update']))
{
if ($_SERVER["REQUEST_METHOD"] == "POST") {

if(empty($_POST["INV_Num"])) {
$INV_Num_Err = " Required";
}else {
$INV_Num = strip_tags($_POST['INV_Num']);
}

if(empty($_POST["Batch_Num"])) {
$Batch_Num_Err = " Required";
}else {
$Batch_Num = strip_tags($_POST['Batch_Num']);
}

if(empty($_POST["CR_Code"])) {
$CR_Code_Err = " Required";
}else {
$CR_Code = strip_tags($_POST['CR_Code']);
}
if(empty($_POST["INV_Total"])) {
$INV_Total_Err = " Required";
}else {
$INV_Total = strip_tags($_POST['INV_Total']);
}
if(empty($_POST["INV_Date"])) {
$INV_Date_Err = " Required";
}else{
$INV_Date = strip_tags($_POST['INV_Date']);
}
if(empty($_POST["PAY_Due"])) {
$PAY_Due_Err = " Required";
}else{
$PAY_Due = strip_tags($_POST['PAY_Due']);
}
if(empty($_POST["PO_Number"])) {
$PO_Number_Err = " Required";
}else{
$PO_Number = strip_tags($_POST['PO_Number']);
}
if(empty($_POST["PO_Type"])) {
$PO_Type_Err = " Required";
}else{
$PO_Type = strip_tags($_POST['PO_Type']);
}
}

$INV_Desc = strip_tags($_POST['INV_Desc']);
$Batch_Value = strip_tags($_POST['Batch_Value']);

if((!empty($_POST["INV_Num"]))&&(!empty($_POST["Batch_Num"]))&&(!empty($_POST["SEQ_Num"]))&&(!empty($_POST["CR_Code"]))&&(!empty($_POST["INV_Total"]))&&(!empty($_POST["INV_Date"]))&&(!empty($_POST["PAY_Due"]))&&(!empty($_POST["PO_Number"]))&&(!empty($_POST["PO_Type"]))) {


$query = "UPDATE `invoice` SET `BatchNumber`='$Batch_Num', `SequenceNumber`='$SEQ_Num', `CreditorCode`='$CR_Code',`InvoiceDescription`='$INV_Desc', `InvoiceTotal`='$INV_Total', `InvoiceDate`= '$INV_Date' 
,`DatePaymentDue`='$PAY_Due', `POType`= '$PO_Type',`BatchValue`='$Batch_Value' where `InvNumber`= '$INV_Num'";
$result = mysql_query($query) or die(mysql_error());

			if(!$result) 
			{
				$msg = "not Inserted";

			}
			else
			{
				
								$query="SELECT * FROM `invoice` WHERE `InvNumber`='$INV_Num'";
								$records = mysql_query($query) or die(mysql_error());	

								while($row=mysql_fetch_array($records))
								{
									$Batch_Num = $row['BatchNumber'];
									$SEQ_Num = $row['SequenceNumber'];
									$INV_Num = $row['InvNumber'];
									$CR_Code = $row['CreditorCode'];
									$INV_Desc = $row['InvoiceDescription'];
									$INV_Total = $row['InvoiceTotal'];
									$INV_Date = $row['InvoiceDate'];
									$PAY_Due = $row['DatePaymentDue'];
									$PO_Number = $row['PONumber'];
									$PO_Type = $row['POType'];
									$Batch_Value = $row['BatchValue'];
								}
							

			}	
					}
}
else if(isset($_POST['REFRESH']))
{
header("Location: invoicerefresh.php");
$_SESSION['invnumber']=NULL;
//$_SESSION['invbatch']=NULL;
$Batch_Num = NULL;
$SEQ_Num = NULL;
$INV_Num = NULL;
$CR_Code = NULL;
$INV_Desc = NULL;
$INV_Total = NULL;
$INV_Date = NULL;
$PAY_Due = NULL;
$PO_Number = NULL;
$PO_Type = NULL;
$Batch_Value = NULL;
//$_SESSION['invbatch']=$Batch_Num;
}

else
{
$_SESSION['invnumber']=NULL;/*
$Batch_Num = NULL;
$SEQ_Num = NULL;
$INV_Num = NULL;
$CR_Code = NULL;
$INV_Desc = NULL;
$INV_Total = NULL;
$INV_Date = NULL;
$PAY_Due = NULL;
$PO_Number = NULL;
$PO_Type = NULL;
$Batch_Value = NULL;
$_SESSION['invbatch']=NULL;*/
}

	

?>
<html>
<head>

	 <?php include('inc/header.php') ?>
    <?php include('inc/dhtmlx.php') ?>
	<script src="../js/crs004s.js"></script>

</head>
<body onload="startTime()">
	<?php include('inc/Nav.php') ?>
	
<div id="page-wrapper">
	<div class="row">
		<div class="col-lg-12">
	<table>
<td><label><a href="../DataUpdate.php"><button class="btn btn-default"><span class="glyphicon glyphicon-chevron-left"></span></button></a></label>
		<label><a href="crs004s.php"><button class="btn btn-default"><span class="glyphicon glyphicon-refresh"></span> Refresh</button></a></label>
		<label><a href="crs004s_Print.php" target="_blank"><button name="Print"  value="Print"  class="btn btn-default" /><span class="glyphicon glyphicon-print"> Print</button></a></label></td>
		</table>
		
		
   
<form id="form" name="form" method="post" action="">
<fieldset>
	<legend><strong>Invoice</strong></legend>
	<div class="container">

		
		<table >

			<tr>			
			<td width="200">Creditor Code</td>
			<td width="300" ><label><input disabled="disabled" type="text"  pattern="[C][0-9]{3,3}" title="{C}{3-digit code} without parentheses"  placeholder="Enter Creditor Code" name="CR_Code" id="CR_Code"  value="<?php echo $CR_Code;?>"></label><font color="red"><?php echo $CR_Code_Err;?></font></td>
				
			<td width="200">Invoice No</td>
			<td width="300"><label><input disabled="disabled" type="text"  pattern="[I][0-9]{3,3}" title="{I}{3-digit no.} without parentheses"  placeholder="Enter Invoice No" name="INV_Num" id="INV_Num" value="<?php echo $INV_Num;?>"></label><font color="red"><?php echo "$INV_Num_Err $INVExist $INVInvalid";?></font></td>
			</tr>
			<tr>
			<td>Invoice Total</td>
			<td><label> <input disabled="disabled" type="text"  pattern="[0-9]*" title="Please enter only digits."  placeholder="Enter Invoice Total" name="INV_Total" type="text" id="INV_Total" value="<?php echo $INV_Total;?>" ></label><font color="red"><?php echo $INV_Total_Err;?></font></td>

			<td>Invoice Date</td>
			<td><label> <input disabled="disabled" type="text"    placeholder="Enter Invoice Date" name="INV_Date" type="text" id="INV_Date" value="<?php echo $INV_Date;?>" ></label><font color="red"><?php echo $INV_Date_Err;?></font></td>
			</tr>
			<tr>
			<td>Invoice Description</td>
			<td><label><input disabled="disabled" type="text"    placeholder="Enter Invoice Description" name="INV_Desc" id="INV_Desc" value="<?php echo $INV_Desc ;?>" ></label></td>
			<td>Date Payment Due</td>
			<td><label><input disabled="disabled" type="text"    placeholder="Enter Date Payment Due" name="PAY_Due" type="text" id="PAY_Due" value="<?php echo $PAY_Due;?>" ></label><font color="red"><?php echo $PAY_Due_Err;?></font></td>
			</tr>
			<tr>
			<td>PO Number</td>
			<td><label> <input disabled="disabled" type="text"  pattern="[P][0-9]{3,3}" title="{P}{3-digit no.} without parentheses"  placeholder="Enter PO Number" name="PO_Number" type="text" id="PO_Number" value="<?php echo $PO_Number;?>" ></label><font color="red"><?php echo "$POUsed $PO_Number_Err";?></font></td>

			<td>PO Type</td>
							<td><label>
							<?php
							
								 define('servername','localhost');

								 define('username','root');

								 define('password','');

								 define('dbname','company');
								function connect(){
									mysql_connect(servername, username, password) or die ('Could not connect to database'. mysql_error());
									mysql_select_db(dbname);
								}
								
								function close(){
									mysql_close();
								}
								
								function query(){
									$myData = mysql_query("SELECT * FROM potypetable");
									while($record = mysql_fetch_array($myData)){
										echo '<option value="'.$record['POtype'].'">'.$record['POtype'].'</option>';
										
									}
								}
							
								 connect();
							?>
							<select disabled="disabled" name="PO_Type" id="PO_Type"   >
								<?php query()?>
							</select>
								<?php close()?>
							
							<!-- <input type="text"   placeholder="Enter PO Type" name="PO_Type" id="PO_Type" value="<?php echo $PO_Type;?>" > -->
							</label></td>
						</tr>
						<?php echo $msg;?>
			<tr>
			<td>Batch Number</td>
			<td><label><input disabled="disabled" type="text"  pattern="[I][B][0-9]{9,9}" title="{IB}{9-digit no.} without parentheses"  placeholder="Enter Batch Number" name="Batch_Num" id="Batch_Num" value="<?php echo $Batch_Num;?>" ></label><font color="red"><?php echo $Batch_Num_Err;?></font></td>
			</tr>
			<tr>
			<td>Sequence Number </td>
			<td><label><input type="text"     name="SEQ_Num" id="SEQ_Num" value="<?php echo $SEQ_Num?>" readonly STYLE="background:#ffffe0; color:#8b0000;" ></label><font color="red"><?php echo $SEQ_Num_Err;?></font></td>
			</tr>
			<tr>
			<td>Batch Value</td>
			<td><label> <input type="text"     name="Batch_Value" type="text" id="Batch_Value" readonly STYLE="background:#ffffe0; color:#8b0000;" value="<?php echo $Batch_Value;?>" ></label></td>
			</tr>
			<table>
				<tr>
					<td colspan="2"><button name="Confirm" id="Confirm" value="Confirm" class="btn btn-default"><span class="glyphicon glyphicon-ok"></span> Confirm</button>
					<label><button name="Add" id="Add" value="Add"   class="btn btn-default" href="javascript:toggleFormElements(false);"/><span class="glyphicon glyphicon-plus"></span> Add</button></label>
					<label><button name="View" value="View"   id="View"class="btn btn-default" /><span class="glyphicon glyphicon-eye-open"></span> View</button></label>
					<label><button name="CView" value="CView"   id="CView"class="btn btn-default" /><span class="glyphicon glyphicon-eye-open"></span> View Item</button></label>
					<label><button name="Edit" value="Edit"  id="Edit" class="btn btn-default" /><span class="glyphicon glyphicon-edit"></span> Edit</button></label>
					<label><button name="Delete" value="Delete"   id="Delete"class="btn btn-default" /><span class="glyphicon glyphicon-remove"></span> Delete</button></label>
					<label><button name="CDelete" value="CDelete"   id="CDelete"class="btn btn-default" /><span class="glyphicon glyphicon-ok"></span> Confirm</button></label>
					<label><button name="Update" value="Update"   id="Update"class="btn btn-default" /><span class="glyphicon glyphicon-refresh"></span> Update</button></label>
					<label><button name="Cancel" id="Cancel" value="Cancel" class="btn btn-default"><span class="glyphicon glyphicon-remove"></span> Cancel</button></label></td>
				</tr>
			</table>
		</table>

	</div>
</form> 
<fieldset>

<legend><strong>Item</strong></legend> 
<div class="container">
<div id="gridbox" style="width:700px;height:400px;"></div> 

<script>
function calculateFooterValues1(stage){

var nrS = document.getElementById("nr_s");
nrS.innerHTML = "$"+sumIncome(4,5)
return true;
}

function sumIncome(indPrice,indQuant){
var out = 0;
for(var i=0;i<mygrid2.getRowsNum();i++){
out+= parseFloat(mygrid2.cells2(i,indPrice).getValue())*parseFloat(mygrid2.cells2(i,indQuant).getValue())
}
return out;
} 


mygrid2 = new dhtmlXGridObject('gridbox');// video for this http://www.youtube.com/watch?v=hPBwsqfyi0s
mygrid2.setImagePath('.../dhtmlx/codebase/imgs/'); //the path to images required by grid         
mygrid2.setHeader("Invoice REF NO,Item ID,Description,UOM,Quantity,Unit Price,ItemPrice");//the headers of columns 
mygrid2.setInitWidths("150,80,200,0,80,80,150")   //the widths of columns     
mygrid2.setColAlign("left,left,left,right,right,right,right") //the alignment of columns          
mygrid2.setColTypes("ro,ro,ro,ro,ro,ro,ro[=c4*c5]");                //the types of columns          
mygrid2.setColSorting("connector,connector,connector,connector,connector,connector,connector");          //the sorting types 
mygrid2.setSkin("dhx_web");	
mygrid2.attachEvent("onEditCell",calculateFooterValues1)		//note calculate
mygrid2.setSkin("dhx_web");				//set the layout of grid 
mygrid2.init();      //finishes initialization  path to images required by grid 
mygrid2.enableMathEditing(true);  
mygrid2.enableSmartRendering(true);
mygrid2.loadXML("invoicedetail.php");//for database control
var dp2=new dataProcessor("invoicedetail.php");
dp2.init(mygrid2);  
mygrid2.setColumnHidden(0,true);

var i="<?php echo $_SESSION['invnumber']; ?>";

function addRow(){
var newId2= (new Date()).valueOf()
mygrid2.addRow(newId2,[i,,,,,,,],mygrid2.getRowsNum())
mygrid2.selectRow(mygrid2.getRowIndex(newId2),false,false,true);
}
function removeRow(){
var selId = mygrid2.getSelectedId()
mygrid2.deleteRow(selId);
}	

</script>  
	<tr>
	<td>Total Amount</td>
	<td><label> <input type="text"   name="Total_amount" type="text" id="Total_amount" readonly STYLE="background:#ffffe0; color:#8b0000;" value="<?php echo $total;?>" ></label>
	</td>
</tr>
<!--
<button onclick="addRow()"class="btn btn-default "id="additem">Add Row</button> 
	<button onclick="removeRow()"class="btn btn-default"id="removeitem">Remove Row</button>
	-->
</div>
</fieldset>

</fieldset>

</div>
</div>
</div>
<script type="text/javascript">
		
	$(':text').ready(function() {
	if($('#INV_Num').val() != "" ) {
	   $('#additem').removeAttr('disabled');
	   $('#removeitem').removeAttr('disabled');
	   $('#Edit').removeAttr('disabled');
	   $('#Delete').removeAttr('disabled');
	} else {
	   $('#additem').attr('disabled', true);   
	   $('#removeitem').attr('disabled', true);   
	   $('#Edit').attr('disabled', true);   
	   $('#Delete').attr('disabled', true);   
	}
	});
</script>
	
<!--<div id="footer">
			<table id="tb2">
				<tr>
					<td id="noti"><strong>Invoice</strong></td>
					<td id="time" style="font-weight:bold;"></td>
				</tr>
			</table>
		</div>-->
</body>
</html>
