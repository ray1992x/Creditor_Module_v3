 <!DOCTYPE html>
<?php
include("../DatabaseConnect.php");
$Pay_Type = "";
$Bank_Code = "";
$CR_Code = "";
$CHQ_Number = "";
$Pay_Vou_Num = "";
$Pay_Amount = "";
$Date_Paid = "";
$Batch_Num = "";
$SEQ_Num = "";
$Batch_Amt = "";

$Pay_Type_Err = "";
$Bank_Code_Err = "";
$CR_Code_Err = "";
$CHQ_Number_Err = "";
$Pay_Vou_Num_Err = "";
$Pay_Amount_Err = "";
$Date_Paid_Err = "";
$Batch_Num_Err = "";
$SEQ_Num_Err = "";
$Batch_Amt_Err = "";

$counter = 1;
$sequence = 1;

if(isset($_POST['Confirm'])){
		
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$CR_BatchNo = strip_tags($_POST['Batch_Num']);
		$query = "Select * FROM `payment` WHERE `BatchNumber`='$CR_BatchNo'";
		$records = mysql_query($query) or die (mysql_error());
		while($row=mysql_fetch_array($records)){
			++$counter;			
		}
		if($counter > 50){
			$Batch_Num_Err = "* Max no. of items reached (50)";
		}
		else
		{		

			if(empty($_POST["Pay_Type"])) {
			$Pay_Type_Err = " (Required)";
			}else {
			$Pay_Type = strip_tags($_POST['Pay_Type']);
			}

			if(empty($_POST["Bank_Code"])) {
			$Bank_Code_Err = " (Required)";
			}else {
			$Bank_Code = strip_tags($_POST['Bank_Code']);
			}

			if(empty($_POST["CR_Code"])) {
			$CR_Code_Err = " (Required)";
			}else {
			$CR_Code = strip_tags($_POST['CR_Code']);
			}
			if(empty($_POST["CHQ_Number"])) {
			$CHQ_Number_Err = " (Required)";
			}else {
			$CHQ_Number = strip_tags($_POST['CHQ_Number']);
			}
			if(empty($_POST["Pay_Vou_Num"])) {
			$Pay_Vou_Num_Err = " (Required)";
			}else{
			$Pay_Vou_Num = strip_tags($_POST['Pay_Vou_Num']);
			}
			if(empty($_POST["Pay_Amount"])) {
			$Pay_Amount_Err = " (Required)";
			}else{
			$Pay_Amount = strip_tags($_POST['Pay_Amount']);
			}
			if(empty($_POST["Date_Paid"])) {
			$Date_Paid_Err = " (Required)";
			}else{
			$Date_Paid = strip_tags($_POST['Date_Paid']);
			}
			if(empty($_POST["Batch_Num"])) {
			$Batch_Num_Err = " (Required)";
			}else{
			$Batch_Num = strip_tags($_POST['Batch_Num']);
			}
			if(empty($_POST["SEQ_Num"])) {
			$SEQ_Num_Err = " (Required)";
			}else{
			$SEQ_Num = $counter;
			}
		
			$Batch_Amt = strip_tags($_POST['Batch_Amt']);
		}
	}
if((!empty($_POST["SEQ_Num"]))&&(!empty($_POST["Batch_Num"]))&&
(!empty($_POST["Date_Paid"]))&&(!empty($_POST["Pay_Amount"]))&&(!empty($_POST["Pay_Vou_Num"]))&&
(!empty($_POST["CHQ_Number"]))&&(!empty($_POST["CR_Code"]))&&(!empty($_POST["Bank_Code"]))&&(!empty($_POST["Pay_Type"]))) {

$query = "Insert INTO `payment`(`PaymentType`, `BankCode`, `CreditorCode`, `ChequeNumber`, `PaymentNo`, `PaymentAmount`
, `DatePaid`, `BatchNumber`, `SequenceNumber`, `BatchValue`)
values('$Pay_Type','$Bank_Code','$CR_Code','$CHQ_Number','$Pay_Vou_Num','$Pay_Amount','$Date_Paid','$Batch_Num','$SEQ_Num','$Batch_Amt')";
$result = mysql_query($query) or die(mysql_error());


if(!$result)
{
$msg = "not Inserted";

}
else
{
$query = "Insert INTO `paydetailtable` (`CRCode`) values ('$CR_Code')";
$result = mysql_query($query) or die(mysql_error()); 



if(!$result) 
{

$msg = "not Inserted";

}
else
{
$query ="UPDATE `payment` SET `BatchValue`=(SELECT `BatchTotal` from `batchheader` where `BatchNumber` = '$Batch_Num') where `BatchNumber`= '$Batch_Num'";
$result = mysql_query($query) or die(mysql_error());	
$_SESSION['CR_Code']=$CR_Code;
$_SESSION['paybatch']=$Batch_Num;// changed
if(!$result)
{
$msg = "not Inserted";

}
else
{
$query="SELECT * FROM `payment` WHERE `CreditorCode`='$CR_Code'";
$records = mysql_query($query) or die(mysql_error());	

while($row=mysql_fetch_array($records))
{

$Pay_Type = NULL;
$Bank_Code = NULL;
$CR_Code = NULL;
$CHQ_Number = NULL;
$Pay_Vou_Num = NULL;
$Pay_Amount = NULL;
$Date_Paid = NULL;
$Batch_Num = NULL;
$SEQ_Num = NULL;
$Batch_Amt = NULL;


}
}
}

}

}

}

else if(isset($_POST['CView']))
{

$CR_Code = strip_tags($_POST['CreditorCode']);
$_SESSION['CR_Code']=$CR_Code;
$query="SELECT * FROM `payment` WHERE `CreditorCode`='$CR_Code'";
$records = mysql_query($query) or die(mysql_error());	

while($row=mysql_fetch_array($records))
{
$Pay_Type = $row['PaymentType'];
$Bank_Code = $row['BankCode'];
$CR_Code = $row['CreditorCode'];
$CHQ_Number = $row['ChequeNumber'];
$Pay_Vou_Num = $row['PaymentNo'];
$Pay_Amount = $row['PaymentAmount'];
$Date_Paid = $row['DatePaid'];
$Batch_Num = $row['BatchNumber'];
$SEQ_Num = $row['SequenceNumber'];
$Batch_Amt = $row['BatchValue'];
}


}	
else if(isset($_POST['Update']))
{
//$PO_Allocation = strip_tags($_POST['PO_Allocation']); for`POAllocation`=$PO_Allocation,

if ($_SERVER["REQUEST_METHOD"] == "POST") {

if(empty($_POST["Pay_Type"])) {
$Pay_Type_Err = " (Required)";
}else {
$Pay_Type = strip_tags($_POST['Pay_Type']);
}

if(empty($_POST["Bank_Code"])) {
$Bank_Code_Err = " (Required)";
}else {
$Bank_Code = strip_tags($_POST['Bank_Code']);
}

if(empty($_POST["CR_Code"])) {
$CR_Code_Err = " (Required)";
}else {
$CR_Code = strip_tags($_POST['CR_Code']);
}
if(empty($_POST["CHQ_Number"])) {
$CHQ_Number_Err = " (Required)";
}else {
$CHQ_Number = strip_tags($_POST['CHQ_Number']);
}
if(empty($_POST["Pay_Vou_Num"])) {
$Pay_Vou_Num_Err = " (Required)";
}else{
$Pay_Vou_Num = strip_tags($_POST['Pay_Vou_Num']);
}
if(empty($_POST["Pay_Amount"])) {
$Pay_Amount_Err = " (Required)";
}else{
$Pay_Amount = strip_tags($_POST['Pay_Amount']);
}
if(empty($_POST["Date_Paid"])) {
$Date_Paid_Err = " (Required)";
}else{
$Date_Paid = strip_tags($_POST['Date_Paid']);
}
if(empty($_POST["Batch_Num"])) {
$Batch_Num_Err = " (Required)";
}else{
$Batch_Num = strip_tags($_POST['Batch_Num']);
}
if(empty($_POST["SEQ_Num"])) {
$SEQ_Num_Err = " (Required)";
}else{
$SEQ_Num = strip_tags($_POST['SEQ_Num']);
}

$Batch_Amt = strip_tags($_POST['Batch_Amt']);

}
if((!empty($_POST["SEQ_Num"]))&&(!empty($_POST["Batch_Num"]))&&
(!empty($_POST["Date_Paid"]))&&(!empty($_POST["Pay_Amount"]))&&(!empty($_POST["Pay_Vou_Num"]))&&
(!empty($_POST["CHQ_Number"]))&&(!empty($_POST["CR_Code"]))&&(!empty($_POST["Bank_Code"]))&&(!empty($_POST["Pay_Type"]))) {

$query = "UPDATE `payment` SET `PaymentType`='$Pay_Type', `BankCode`='$Bank_Code', `CreditorCode`= $CR_Code , `ChequeNumber`= $CHQ_Number,
`PaymentNo`= $Pay_Vou_Num, `PaymentAmount`= $Pay_Amount, `DatePaid`= '$Date_Paid'
, `BatchNumber`= $Batch_Num, `SequenceNumber`= $SEQ_Num, `BatchValue`= $Batch_Amt
where `ChequeNumber`= $CHQ_Number";
$result = mysql_query($query) or die(mysql_error());

if(!$result)
{
$msg = "not Inserted";

}
else
{

$_SESSION['CR_Code']=$CR_Code;
$Pay_Type = NULL;
$Bank_Code = NULL;
$CR_Code = NULL;
$CHQ_Number = NULL;
$Pay_Vou_Num = NULL;
$Pay_Amount = NULL;
$Date_Paid = NULL;
$Batch_Num = NULL;
$SEQ_Num = NULL;
$Batch_Amt = NULL;

}
}

}	
else
{
$_SESSION['CR_Code']=NULL;
$Pay_Type = NULL;
$Bank_Code = NULL;
$CR_Code = NULL;
$CHQ_Number = NULL;
$Pay_Vou_Num = NULL;
$Pay_Amount = NULL;
$Date_Paid =  NULL;
$Batch_Num = NULL;
$SEQ_Num = NULL;
$Batch_Amt = NULL;
$_SESSION['paybatch']=NULL;
}

if(isset($_POST['Confirm']))
{
	if($_SERVER["REQUEST_METHOD"] == "POST") 
	{
		$query = "Select * FROM `payment` WHERE BatchNumber='".strip_tags($_POST['Batch_Num'])."'";
		$records = mysql_query($query) or die (mysql_error());
		while($row=mysql_fetch_array($records)){
			++$sequence;		
		}
	}
}

?>
<html>
<head>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Creditor Module</title>
	<link rel="shortcut icon" href="../img/icon.ico">

	<link rel="stylesheet" type="text/css" href="../dhtmlx/skins/web/dhtmlxgrid.css">
	<link rel='STYLESHEET' type='text/css' href='../dhtmlx/codebase/dhtmlxgrid.css'>
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../bootstrap/css/logo-nav.css" rel="stylesheet">
	<!-- css link for datepicker function -->
	<link rel="stylesheet" type="text/css" href="../css/ui-lightness/jquery-ui-1.9.2.custom.css">
		
	<script src='../dhtmlx/codebase/dhtmlxcommon.js'></script>
	<script src='../dhtmlx/codebase/dhtmlxgrid.js'></script>		
	<script src='../dhtmlx/codebase/dhtmlxgridcell.js'></script>
	<script src='../dhtmlx/codebase/dhtmlxgrid_math.js'></script>
	<script src="../dhtmlx/connector_codebase/connector.js"></script>
	<script src="../dhtmlx/codebase/dhtmlxgrid_srnd.js"></script>
	<script src="../dhtmlx/codebase/dhtmlxgrid_filter.js"></script>
	
    <script src="../bootstrap/js/jquery.js"></script>
    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <script src="../js/Button1.js"></script>
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



	</style>
	
			
		<!--add current time to footer-->
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
	<table>
<td><label><a href="../DataUpdate.php"><button class="btn btn-default"><span class="glyphicon glyphicon-chevron-left"></span></button></a></label>
		<label><a href="crs008s.php"><button class="btn btn-default"><span class="glyphicon glyphicon-refresh"></span> Refresh</button></a></label>
		<label><a href="crs008s_Print.php" target="_blank"><button name="Print"  value="Print"  class="btn btn-default" /><span class="glyphicon glyphicon-print"> Print</button></a></label></td>
	</td></table>
	
<fieldset>
<legend><strong>Payment</strong></legend>

        <div class="container">

<form id="form" name="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

<table>
<tr>
<td align="top">Payment Type</td>
<td>
<label><input type="radio" name="Pay_Type" id="Pay_Type" value="Auto" <?php if ($Pay_Type=='Auto') { echo 'checked'; }  ?>  />Auto</label>
<label><input type="radio" name="Pay_Type" id="Pay_Type" value="Manual"<?php if ($Pay_Type=='Manual') { echo 'checked'; } ?> />Manual</label>

<font color="red"><?php echo $Pay_Type_Err;?></font></td>



</tr>
<tr>			
<td>Bank Code</td>
<td><label><input type="text"   placeholder="Enter Bank Code" name="Bank_Code" id="Bank_Code" value="<?php echo $Bank_Code;?>"></label>
<font color="red"><?php echo $Bank_Code_Err;?>
</td>
</tr>
<tr>
<td width="200"> Creditor Code </td>
<td width ="300"><label><input type="text"   placeholder="Enter Creditor Code" name="CR_Code" id="CR_Code" value="<?php echo $CR_Code;?>" ></label>
<font color="red"><?php echo $CR_Code_Err;?>
</td> 
</tr>
<tr>			
<td>Cheque Number</td>
<td><label><input type="text"   placeholder="Enter Cheque Number" name="CHQ_Number" id="CHQ_Number" value="<?php echo $CHQ_Number;?>"></label>
<font color="red"><?php echo $CHQ_Number_Err;?>
</td>
</tr>
<tr>
<td>Payment Voucher Number</td>
<td><label><input type="text"   placeholder="Enter Payment Voucher Number" name="Pay_Vou_Num" id="Pay_Vou_Num" value="<?php echo $Pay_Vou_Num;?>" ></label>
<font color="red"><?php echo $Pay_Vou_Num_Err;?>
</td>
</tr>
<tr>
<td>Payment Amount</td>
<td><label> <input type="text"   placeholder="Enter Payment Amount" name="Pay_Amount" type="text" id="Pay_Amount" value="<?php echo $Pay_Amount;?>" ></label>
<font color="red"><?php echo $Pay_Amount_Err;?>
</td>
</tr>
<tr>
<td>Date Paid</td>
<td><label> <input   name="Date_Paid" id="Date_Paid" value="<?php echo $Date_Paid;?>" ></label>
<font color="red"><?php echo $Date_Paid_Err;?>
</td>
</tr>
<tr>
<td>Batch Number</td>
<td><label> <input type="text"   placeholder="Enter Batch Number" name="Batch_Num" type="text" id="Batch_Num" value="<?php echo $Batch_Num;?>" ></label>
<font color="red"><?php echo $Batch_Num_Err;?>
</td>
</tr>
<tr>
<td>Sequence Number</td>
<td><label> <input type="text"  name="SEQ_Num" type="text" id="SEQ_Num" value="<?php if($sequence<51){echo $sequence;}else{echo '1';}?>" readonly STYLE="background:#ffffe0; color:#8b0000;" ></label>
</td>
</tr>
<tr>
<td>Batch Amount</td>
<td><label> <input type="text"   name="Batch_Amt" type="text" id="Batch_Amt" readonly STYLE="background:#ffffe0; color:#8b0000;" value="<?php echo $Batch_Amt;?>" ></label>
</td>
</tr>
<table>
	<tr>
		<td colspan="2"><button name="Confirm" id="Confirm" value="Confirm" class="btn btn-default"><span class="glyphicon glyphicon-ok"></span> Confirm</button>
		<label><button name="Add" id="Add" value="Add"   class="btn btn-default" href="javascript:toggleFormElements(false);"/><span class="glyphicon glyphicon-plus"></span> Add</button></label>
		<label><button name="View" value="View"   id="View"class="btn btn-default" /><span class="glyphicon glyphicon-eye-open"></span> View</button></label>
		<label><button name="CView" value="CView"   id="CView"class="btn btn-default" /><span class="glyphicon glyphicon-eye-open"></span> View Item</button></label>
		<label><button name="Edit" value="Edit"  id="Edit" class="btn btn-default" /><span class="glyphicon glyphicon-edit"></span> Edit</button></label>
		<label><button name="Update" value="Update"   id="Update"class="btn btn-default" /><span class="glyphicon glyphicon-refresh"></span> Update</button></label>
		<label><button name="Cancel" id="Cancel" value="Cancel" class="btn btn-default"><span class="glyphicon glyphicon-remove"></span> Cancel</button></label></td>
	</tr>
</table>
</table>
	</form>
</div>
<fieldset>

<legend><strong>Purchase Order Sub(ITEMS) Detail(ADD/EDIT/VIEW/REMOVE)</strong></legend> 
        <div class="container">
<div id="gridbox" style="width:700px;height:400px;"></div> 

<script>
function calculateFooterValues2(stage){
/* if(stage && stage!=2)
return true; */
var nrQ = document.getElementById("nr_q");
nrQ.innerHTML = sumColumn(8)
return true;
}
function sumColumn(ind){
var out = 0;
for(var i=0;i<mygrid3.getRowsNum();i++){
out+= parseFloat(mygrid3.cells2(i,ind).getValue())
}
return out;
}


mygrid3 = new dhtmlXGridObject('gridbox');// video for this http://www.youtube.com/watch?v=hPBwsqfyi0s
mygrid3.setImagePath('../codebase/imgs/'); //the path to images required by grid         
mygrid3.setHeader("ChequeNumber,No,Date,Period,Invoice/Credit Note No,PO Number, Invoice/Credit Note Amount,Paid Amount, Payment Amount");//the headers of columns 
mygrid3.setInitWidths("50,80,80,80,80,80,80,80,80")   //the widths of columns     
mygrid3.setColAlign("left,left,right,right,right,right,right,right,right") //the alignment of columns          
mygrid3.setColTypes("ro,ed,ed,ed,ed,ed,ed,ed,ed[=c6-c7]");                //the types of columns          
mygrid3.setColSorting("connector,connector,connector,connector,connector,connector,connector,connector,connector");          //the sorting types   
mygrid3.setSkin("dhx_web");				//set the layout of grid 
mygrid3.attachEvent("onEditCell",calculateFooterValues2)		//note calculate
mygrid3.setSkin("dhx_web");				//set the layout of grid 
mygrid3.init();      //finishes initialization  path to images required by grid 
mygrid3.attachFooter("Total amount,<div id='nr_q'>0</div>",["text-align:left;"]); //note
mygrid3.enableMathEditing(true);  
mygrid3.enableSmartRendering(true);
mygrid3.loadXML("paydetailtable.php");//for database control
var dp3=new dataProcessor("paydetailtable.php");
dp3.init(mygrid3);  
mygrid3.setColumnHidden(0,true);

var i="<?php echo $_SESSION['CR_Code']; ?>";

function addRow(){
var newId3 = (new Date()).valueOf()
mygrid3.addRow(newId3,[i,,,,,,,,,],mygrid3.getRowsNum())
mygrid3.selectRow(mygrid3.getRowIndex(newId3),false,false,true);
}
function removeRow(){
var selId = mygrid3.getSelectedId()
mygrid3.deleteRow(selId);
}	
</script>  

<button onclick="addRow()">Add Row</button> 
<button onclick="removeRow()">Remove Row</button>
</div>
</fieldset>

</fieldset>



</body>
</html>

