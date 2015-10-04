<!DOCTYPE html>
<?php
include("../DatabaseConnect.php");

$Batch_Type = "";
$Batch_Number = "";
$Batch_Date_Temp = "";
$Batch_Date = "";
$Batch_Period = "";
$Batch_Total = "";
$Check_Total = "";
$Difference = "";
$Transaction_Count = "";

$Batch_Type_Err = "";
$Batch_Number_Err = "";
$Batch_Date_Err = "";
$Batch_Period_Err = "";
$Batch_Total_Err = "";
$Check_Total_Err = "";
$Difference_Err = "";
$Transaction_Count_Err = "";
$output = " ";
$output2 = " ";

if(isset($_POST['Confirm']))
{

	if ($_SERVER["REQUEST_METHOD"] == "POST") {

		if(empty($_POST["Batch_Type"])) {
		$Batch_Type_Err = "* Batch Type Not Selected";
		}else {
		$Batch_Type = strip_tags($_POST['Batch_Type']);
		}

		if(empty($_POST["Batch_Number"])) {
		$Batch_Number_Err = "* Missing Batch Number";
		}else {
		$Batch_Number = strip_tags($_POST['Batch_Number']);
		}
		if(empty($_POST["Batch_Date"])) {
		$Batch_Date_Err = "* Missing Batch Date";
		}else {
		$Batch_Date = strip_tags($_POST['Batch_Date']);
		}
		if(empty($_POST["Batch_Period"])) {
		$Batch_Period_Err = "* Missing Batch Period";
		}else {
		$Batch_Period = strip_tags($_POST['Batch_Period']);
		}
		if(empty($_POST["Batch_Total"])) {
		$Batch_Total_Err = "* Missing Batch Total";
		}else{
		$Batch_Total = strip_tags($_POST['Batch_Total']);
		$Difference = strip_tags($_POST['Batch_Total']);
		}
		if(empty($_POST["Transaction_Count"])) {
		$Transaction_Count_Err = "* Missing Transaction Count";
		}else{
		$Transaction_Count = strip_tags($_POST['Transaction_Count']);
		}
		$Check_Total = strip_tags($_POST['Check_Total']);
	}

	if((!empty($_POST["Batch_Type"]))&&(!empty($_POST["Batch_Number"]))&&(!empty($_POST["Batch_Date"]))&&(!empty($_POST["Batch_Period"]))&&(!empty($_POST["Batch_Total"]))&&(!empty($_POST["Transaction_Count"]))) {
		$query = "Insert INTO `BatchHeader`( `BatchType`, `BatchNumber`, `BatchDate`, `BatchPeriod`, `BatchTotal`,`CheckTotal`, `Difference`,`TransactionCount`)
		values('$Batch_Type','$Batch_Number','$Batch_Date','$Batch_Period','$Batch_Total','$Check_Total','$Difference','$Transaction_Count')";

		$result = mysql_query($query) or die(mysql_error());


		if(!$result)
		{
			$msg = "not Inserted";

		}
		else
		{
		$query="SELECT * FROM `BatchHeader` WHERE `BatchNumber`='$Batch_Number'";
		$records = mysql_query($query) or die(mysql_error());	

		while($row=mysql_fetch_array($records))
		{                       
			$Batch_Type = $row['BatchType'];
			$Batch_Number = $row['BatchNumber'];
			$Batch_Date = $row['BatchDate']; 
			$Batch_Period = $row['BatchPeriod'];
			$Batch_Total = $row['BatchTotal'];
			$Check_Total = $row['CheckTotal'];
			$Difference = $row['Difference'];
			$Transaction_Count = $row['TransactionCount'];

		}
		}

	}
}





else if(isset($_POST['CView']))
{  

		$Batch_Number = strip_tags($_POST['Batch_Number']);
		$query="SELECT * FROM `BatchHeader` WHERE `BatchNumber`='$Batch_Number'";
		$records = mysql_query($query) or die(mysql_error());	

		while($row=mysql_fetch_array($records))
		{                       
			$Batch_Type = $row['BatchType'];
			$Batch_Number = $row['BatchNumber'];
			$Batch_Date = $row['BatchDate']; 
			$Batch_Period = $row['BatchPeriod'];
			$Batch_Total = $row['BatchTotal'];
			$Check_Total = $row['CheckTotal'];
			$Difference = $row['Difference'];
			$Transaction_Count = $row['TransactionCount'];

		}
		//notification here
		/*if ($Check_Total == $Transaction_Count){
		$output = "Batch Complete";
		}
		else{
			$output2 = "Batch Incomplete";
		}*/
}
else if(isset($_POST['Update']))
{

	if ($_SERVER["REQUEST_METHOD"] == "POST") {

		if(empty($_POST["Batch_Type"])) {
			$Batch_Type_Err = "* Batch Type Not Selected";
		}else {
			$Batch_Type = strip_tags($_POST['Batch_Type']);
		}
		if(empty($_POST["Batch_Number"])) {
			$Batch_Number_Err = "* Missing Batch Number";
		}else {
			$Batch_Number = strip_tags($_POST['Batch_Number']);
		}
		if(empty($_POST["Batch_Date"])) {
			$Batch_Date_Err = "* Missing Batch Date";
		}else {
			$Batch_Date = strip_tags($_POST['Batch_Date']);
		}
		if(empty($_POST["Batch_Period"])) {
			$Batch_Period_Err = "* Missing Batch Period";
		}else {
			$Batch_Period = strip_tags($_POST['Batch_Period']);
		}
		if(empty($_POST["Batch_Total"])) {
			$Batch_Total_Err = "* Missing Batch Total";
		}else{
			$Batch_Total = strip_tags($_POST['Batch_Total']);
		}
		if(empty($_POST["Transaction_Count"])) {
			$Transaction_Count_Err = "* Missing Transaction Count";
		}else{
			$Transaction_Count = strip_tags($_POST['Transaction_Count']);
		}
		$Check_Total = strip_tags($_POST['Check_Total']);
		$Difference = strip_tags($_POST['Difference']);
	}


	if((!empty($_POST["Batch_Type"]))&&(!empty($_POST["Batch_Number"]))&&(!empty($_POST["Batch_Date"]))&&(!empty($_POST["Batch_Period"]))&&(!empty($_POST["Batch_Total"]))&&(!empty($_POST["Transaction_Count"]))) {
		$query = "UPDATE `BatchHeader` SET `BatchType`='$Batch_Type', `BatchDate`='$Batch_Date', `BatchPeriod`='$Batch_Period',`BatchTotal`='$Batch_Total', `CheckTotal`='$Check_Total', `Difference`= '$Difference', `TransactionCount`= '$Transaction_Count' 
		where `BatchNumber`= '$Batch_Number'";


		$result = mysql_query($query) or die(mysql_error());


		if(!$result)
		{
			$msg = "not Inserted";

		}
		else
		{
		
		$Batch_Number = strip_tags($_POST['Batch_Number']);
		$query="SELECT * FROM `BatchHeader` WHERE `BatchNumber`='$Batch_Number'";
		$records = mysql_query($query) or die(mysql_error());	

		while($row=mysql_fetch_array($records))
		{                       
			$Batch_Type = $row['BatchType'];
			$Batch_Number = $row['BatchNumber'];
			$Batch_Date = $row['BatchDate']; 
			$Batch_Period = $row['BatchPeriod'];
			$Batch_Total = $row['BatchTotal'];
			$Check_Total = $row['CheckTotal'];
			$Difference = $row['Difference'];
			$Transaction_Count = $row['TransactionCount'];

		}
		}

	}

}
/*else
{
	$Batch_Type = NULL;
	$Batch_Number = NULL;
	$Batch_Date = NULL;
	$Batch_Period = NULL;
	$Batch_Total = NULL;
	$Check_Total = NULL;
	$Difference = NULL;
	$Transaction_Count = NULL;
}*/

?>


<html>
<head>

	<?php include('inc/header.php') ?>
    <?php include('inc/dhtmlx.php') ?>
	<script src="../js/crs018s.js"></script>

</head>
<body onload="startTime()">
<?php include('inc/Nav.php') ?>
	
<div id="page-wrapper">
	<div class="row">
		<div class="col-lg-12">
<!--<table>
<td><label><a href="../DataUpdate.php"><button class="btn btn-default"><span class="glyphicon glyphicon-chevron-left"></span></button></a></label>
	<label><a href="crs018s.php"><button onclick="changeRadioButton(this)" value="Refresh" class="btn btn-default"><span class="glyphicon glyphicon-refresh"></span> Refresh</button></a></label>
</table>-->

<?php echo "$output $output2";?>

<fieldset>
<form id="form" name="form" method="post" action="">
<table>
	<tr>
		<td colspan="2"><button  onclick="changeRadioButton(this).toString()" name="Confirm" id="Confirm" value="Confirm" class="btn btn-default"><span class="glyphicon glyphicon-ok"></span> Confirm</button>
		<label><button  name="Add" id="Add" value="Add"   class="btn btn-default" href="javascript:toggleFormElements(false);"/><span class="glyphicon glyphicon-plus"></span> Add</button></label>
		<label><button name="View" value="View"   id="View"class="btn btn-default" /><span class="glyphicon glyphicon-eye-open"></span> View</button></label>
		<label><button name="CView" value="CView"   id="CView"class="btn btn-default" /><span class="glyphicon glyphicon-eye-open"></span> View Item</button></label>
		<label><button name="Edit" value="Edit"  id="Edit" class="btn btn-default" /><span class="glyphicon glyphicon-edit"></span> Edit</button></label>
		<label><button name="Update" value="Update"   id="Update"class="btn btn-default" /><span class="glyphicon glyphicon-refresh"></span> Update</button></label>
		<label><button name="Cancel" id="Cancel" value="Cancel" class="btn btn-default"><span class="glyphicon glyphicon-remove"></span> Cancel</button></label></td>
	</tr>
</table>
<legend><strong>Batch Header Detail</strong></legend>



<table>
<tr>
<td width ="200">Batch Type</td>
<td >
<label><input disabled="disabled" onclick="changeRadioButton(this)" type="radio" name="Batch_Type" id="Batch_Type" value="Invoice" <?php if ($Batch_Type=='Invoice') { echo 'checked'; } ?>/>Invoice</label>
<label><input disabled="disabled" onclick="changeRadioButton(this)" type="radio" name="Batch_Type" id="Batch_Type" value="Credit Note" <?php if ($Batch_Type=='Credit Note') { echo 'checked'; } ?>/>Credit Note</label>
<label><input disabled="disabled" onclick="changeRadioButton(this)" type="radio" name="Batch_Type" id="Batch_Type" value="Journal" <?php if ($Batch_Type=='Journal') { echo 'checked'; } ?>/>Journal</label>
<label><input disabled="disabled" onclick="changeRadioButton(this)" type="radio" name="Batch_Type" id="Batch_Type" value="Auto Payment" <?php if ($Batch_Type=='Auto Payment') { echo 'checked'; } ?>/>Auto Payment</label>
<label><input disabled="disabled" onclick="changeRadioButton(this)" type="radio" name="Batch_Type" id="Batch_Type" value="Manual Payment"<?php if ($Batch_Type=='Manual Payment') { echo 'checked'; } ?>/>Manual Payment</label>
<font color="red"><?php echo $Batch_Type_Err;?></font>
</td>
</table>
<table>
</tr>
<tr>
<td width ="200">Batch Number</td>
<td width="250"><label><input disabled="disabled" type="text"    placeholder="Enter Batch Number" name="Batch_Number" id="Batch_Number" value="<?php echo $Batch_Number;?>" ></label>
<font color="red"><?php echo $Batch_Number_Err;?></font></td> 
</tr>
<tr>			
<td>Batch Date</td>
<td><label><input disabled="disabled" type="text"    placeholder="Enter Batch Date" name="Batch_Date" id="Batch_Date" value="<?php echo $Batch_Date;?>"></label>
<font color="red"><?php echo $Batch_Date_Err;?></font></td>
</tr>
<tr>
<td>Batch Period</td>
<td><label><input disabled="disabled" type="text"    placeholder="Enter Batch Period" name="Batch_Period" id="Batch_Period" value="<?php echo $Batch_Period;?>" ></label>
<font color="red"><?php echo $Batch_Period_Err;?></font></td>
</tr>
<tr>
<td>Batch Total</td>
<td><label><input disabled="disabled" type="text"    placeholder="Enter Batch Total" name="Batch_Total" id="Batch_Total" value="<?php echo $Batch_Total;?>" ></label>
<font color="red"><?php echo $Batch_Total_Err;?></font></td>
<td width ="200">Check Total</td>
<td width="250"><label><input type="text"    name="Check_Total" id="Check_Total" readonly STYLE="background:#ffffe0; color:#8b0000;" value="<?php echo $Check_Total;?>"  ></label></td></tr>


<tr>
<td>
<label>Transaction Count </label> 
<td><label><input disabled="disabled" type="text"    placeholder="Enter Transaction Count" name="Transaction_Count" id="Transaction_Count" value="<?php echo $Transaction_Count;?>" ></label>
<font color="red"><?php echo $Transaction_Count_Err;?></font></td>

</td>

<td width="75">Difference</td>
<td width="118"><label><input type="text"    name="Difference" id="Difference" readonly STYLE="background:#ffffe0; color:#8b0000;" value="<?php echo $Difference;?>" ></label></td>

</tr>


</table>
</form> 	
</div>
</div>
</div>

<script type="text/javascript">
		
		$(':text').ready(function() {
		if($('#Batch_Number').val() != "" ) {
		   $('#additem').removeAttr('disabled');
		   $('#removeitem').removeAttr('disabled');
		   $('#Edit').removeAttr('disabled');
		   $('#Delete').removeAttr('disabled');
		}else {
		   $('#additem').attr('disabled', true);   
		   $('#removeitem').attr('disabled', true);   
		   $('#Edit').attr('disabled', true);   
		   $('#Delete').attr('disabled', true);   
		}
		});
	</script>
	
	<script type="text/javascript">
	
	$(':text').ready(function() {
	if($("#Check_Total").val()==$("#Transaction_Count").val())
		{
			
		   $('#Edit').attr('disabled', true);   
		}
		});
	/*
	var data1 = <?PHP echo $Check_Total;?>;
	var data2 = <?PHP echo $Transaction_Count;?>;

	if($("#Check_Total").val()==$("#Transaction_Count").val())
		//if(data1==data2)
		//document.getElementById('Edit').disabled=true;
		   $('#Edit').attr('disabled', true);   */
	</script>
</body>
</html>