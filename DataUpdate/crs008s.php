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
$SEQ_Num = 0;
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
$Difference2 = " ";
$counter = 1;
$sequence = 1;

$invoiceno = " ";
$payerr = " ";
$aa = " ";
$overpay = " ";
	$total = 0;
	$paytotal = "";
	$checkseq = 0;
	$CHQExist = "";
	

if(isset($_POST['Confirm'])){
		
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
		
			$Batch_Amt = strip_tags($_POST['Batch_Amt']);
	}
		$query = "Select MAX(SequenceNumber) AS maxseq FROM `payment` WHERE `BatchNumber`='$Batch_Num'";
		$records = mysql_query($query) or die (mysql_error());
		while($row=mysql_fetch_array($records)){
			$SEQ_Num = $row['maxseq'];		
		}$query1 = "Select TransactionCount FROM BatchHeader WHERE BatchNumber='$Batch_Num'";
		$records1 = mysql_query($query1) or die (mysql_error());
		while($row1=mysql_fetch_array($records1)){
			$checkseq = $row1['TransactionCount'];
		}
		if($SEQ_Num > $checkseq){
			$Batch_Num_Err = "* Max no. of Payment";
			$Pay_Type = NULL;
			$Bank_Code = NULL;
			$CR_Code = NULL;
			$CHQ_Number = NULL;
			$Pay_Amount = NULL;
			$Date_Paid = NULL;
			$Batch_Num = NULL;
			$SEQ_Num = NULL;
			$Batch_Amt = NULL;
		}
		else
		{			
			$SEQ_Num++;	
			$query1 = "UPDATE BatchHeader SET CheckTotal = '$SEQ_Num' WHERE BatchNumber = '$Batch_Num'";
			$result1 = mysql_query($query1) or die(mysql_error());
	if((!empty($_POST["Batch_Num"]))&&(!empty($_POST["CHQ_Number"]))&&
	(!empty($_POST["Date_Paid"]))&&(!empty($_POST["Pay_Amount"]))&&
	(!empty($_POST["CR_Code"]))&&(!empty($_POST["Bank_Code"]))&&(!empty($_POST["Pay_Type"]))) {
		
		$query = " Select * FROM payment";
		$result = mysql_query($query) or die(mysql_error());
		$exists = "no";
		$exists2 = "no";

		while($row = mysql_fetch_array($result)){
			if($row['ChequeNumber'] == $CHQ_Number ){
				$exists = "yes";
				break;
			}
		}
		
		if($exists = "no")
		{

			$query = "Insert INTO `payment`(`PaymentType`, `BankCode`, `CreditorCode`, `ChequeNumber`, `PaymentAmount`
			, `DatePaid`, `BatchNumber`, `SequenceNumber`, `BatchValue`)
			values('$Pay_Type','$Bank_Code','$CR_Code','$CHQ_Number','$Pay_Amount','$Date_Paid','$Batch_Num','$SEQ_Num','$Batch_Amt')";
			$result = mysql_query($query) or die(mysql_error());


			if(!$result)
			{
				$msg = "not Inserted";

			}
			else
			{
				$query = "Insert INTO paydetailtable (CRCode,date,period,invoice_no,po_number,invoice_amount, payment_amount) 
						  SELECT CreditorCode,InvoiceDate,DatePaymentDue,InvNumber,PONumber, InvoiceTotal,InvoiceTotal FROM invoice WHERE NOT EXISTS(SELECT * FROM paydetailtable WHERE invoice_no = InvNumber)";
				$result = mysql_query($query) or die(mysql_error()); 



				if(!$result) 
				{

					$msg = "not Inserted";

				}
				else
				{
					
						$query ="UPDATE `payment` SET `BatchValue`=(SELECT `BatchTotal` from `batchheader` where `BatchNumber` = '$Batch_Num') where `BatchNumber`= '$Batch_Num'";
						$result = mysql_query($query) or die(mysql_error());	
						$_SESSION['PCR_Code']=$CR_Code;
						$_SESSION['ChequeNumber']=$CHQ_Number;
						$_SESSION['paybatch']=$Batch_Num;// changed
						if(!$result)
						{
							$msg = "not Inserted";

						}
						else
						{
							$query="SELECT * FROM `payment` WHERE `CreditorCode`='$CR_Code'";
							$records = mysql_query($query) or die(mysql_error());	
							$query1 = " SELECT SUM(paid_period) as paid FROM paydetailtable WHERE ChequeNo = '$CHQ_Number'";
							$records1 = mysql_query($query1) or die(mysql_error());	

							while($row1=mysql_fetch_array($records1))
							{

								$total = $row['paid'];


							}
							while($row=mysql_fetch_array($records))
							{

								$Pay_Type = $row['PaymentType'];
								$Bank_Code = $row['BankCode'];
								$CR_Code = $row['CreditorCode'];
								$CHQ_Number = $row['ChequeNumber'];
								$Pay_Amount = $row['PaymentAmount'];
								$Date_Paid = $row['DatePaid'];
								$Batch_Num = $row['BatchNumber'];
								$SEQ_Num = $row['SequenceNumber'];
								$Batch_Amt = $row['BatchValue'];


							}
							
							while($row1=mysql_fetch_array($records1))
							{
								
								$total = $row1['paid'];
								if($total == 0)
								{
									$total = 0;
								}


							}
						}
					
				}
			}
		}else{
			$CHQExist = "Cheque Number Exist.";
		}
	}
		}
}

else if(isset($_POST['CView']))
{

	$CR_Code = strip_tags($_POST['CR_Code']);
	$CHQ_Number = strip_tags($_POST['CHQ_Number']);
	$_SESSION['PCR_Code']=$CR_Code;
	$_SESSION['ChequeNumber']=$CHQ_Number;
					
	$query1 = " Select * FROM payment";
	$result = mysql_query($query1) or die(mysql_error());
	$exists = "no";
	
	while($row = mysql_fetch_array($result)){
		if($row['CreditorCode'] == $CR_Code ){
			$exists = "yes";
			break;
		} /*
		if (){
			$exists = "yes";
			break;			
		}*/
	}
	if($exists == "no"){
		echo "";
		$Invalid = " Number Found";
		$CR_Code = NULL;
		$CHQ_Number = NULL;
		$_SESSION['PCR_Code']=NULL;
	}else{
		$query="SELECT * FROM `payment` WHERE `CreditorCode`='$CR_Code' AND ChequeNumber = '$CHQ_Number' ";
		$records = mysql_query($query) or die(mysql_error());	
		$query1 = " SELECT SUM(paid_period) as paid FROM paydetailtable WHERE ChequeNo = '$CHQ_Number'";
		$records1 = mysql_query($query1) or die(mysql_error());	


		while($row=mysql_fetch_array($records))
		{
			$Pay_Type = $row['PaymentType'];
			$Bank_Code = $row['BankCode'];
			$CR_Code = $row['CreditorCode'];
			$CHQ_Number = $row['ChequeNumber'];
			$Pay_Amount = $row['PaymentAmount'];
			$Date_Paid = $row['DatePaid'];
			$Batch_Num = $row['BatchNumber'];
			$SEQ_Num = $row['SequenceNumber'];
			$Batch_Amt = $row['BatchValue'];
		}
		$_SESSION['paybatch'] = $Batch_Num;
		while($row1=mysql_fetch_array($records1))
		{
			
			$total = $row1['paid'];
			if($total == 0)
			{
				$total = 0;
			}


		}
		/*$query4 - "SELECT * FROM invoice WHERE CRCode = '$CR_Code'";
		$result4 = mysql_query($query4) or die(mysql_error()); 
		while($row4=mysql_fetch_array($result4))
		{
			
			$abc = ['InvNumber'];


		}*/
		$query3 = "Insert INTO paydetailtable (CRCode,date,period,invoice_no,po_number,invoice_amount, payment_amount) 
						  SELECT CreditorCode,InvoiceDate,DatePaymentDue,InvNumber,PONumber, InvoiceTotal,InvoiceTotal FROM invoice 
						  WHERE NOT EXISTS(SELECT * FROM paydetailtable WHERE invoice_no = InvNumber)";
		$result3 = mysql_query($query3) or die(mysql_error()); 


	}


}	
else if(isset($_POST['pay']))
{
	$CHQ_Number = $_SESSION['ChequeNumber'];
			$invoiceno = strip_tags($_POST['invoiceno']);
$_SESSION['invoiceno'] = $invoiceno  ;
				
				$Batch_Num = $_SESSION['paybatch'];// changed
			$query = "Update paydetailtable  SET paid_period = (SELECT InvoiceTotal FROM invoice WHERE InvNumber = '$invoiceno'), ChequeNo = (SELECT ChequeNumber FROM payment WHERE ChequeNumber = '$CHQ_Number'), remark='Paid' WHERE invoice_no = '$invoiceno'";
			$records = mysql_query($query) or die(mysql_error());	
			if(!$records) 
			{

				$msg = "not Inserted";

			}
			else
			{			
				$query = " SELECT SUM(paid_period) as paid FROM paydetailtable WHERE ChequeNo = '$CHQ_Number'";
				$query1 = "SELECT PaymentAmount FROM payment WHERE ChequeNumber = '$CHQ_Number'";
				$records = mysql_query($query) or die(mysql_error());	
				$records1 = mysql_query($query1) or die(mysql_error());	
				while($row=mysql_fetch_array($records))
				{
					$paytotal = $row['paid'];
				}
				while($row1=mysql_fetch_array($records1))
				{
					$payamount = $row1['PaymentAmount'];
				}
				if($paytotal > $payamount)
				{
					$overpay = "Overpay Amount";
					 $invoiceno = $_SESSION['invoiceno'];
					$query = "Update paydetailtable  SET paid_period = 0, ChequeNo = 0 , remark = NULL WHERE invoice_no = '$invoiceno'";
					$records = mysql_query($query) or die(mysql_error());	
			
				}
				else
				{
					$query = "SELECT BatchNumber FROM `invoice` WHERE InvNumber = '$invoiceno'";
					$records = mysql_query($query) or die(mysql_error());	
					while($row=mysql_fetch_array($records))
					{
						$batchnum = $row['BatchNumber'];
					}
					$query1 = "SELECT Difference FROM `BatchHeader` WHERE BatchNumber = '$batchnum'";
					$records1 = mysql_query($query1) or die(mysql_error());	
					while($row1=mysql_fetch_array($records1))
					{
						$Difference = $row1['Difference'];
					}
					$Difference2 = $Difference - $paytotal;
					$total = $paytotal;
					$query2 = "UPDATE BatchHeader SET Difference = '$Difference2' WHERE BatchNumber = '$batchnum'";
					$records2 = mysql_query($query2) or die(mysql_error());	
					if(!$records2)
					{
						$msg = "not Inserted";

					}
					else
					{
						$CR_Code=$_SESSION['PCR_Code'];
						$CHQ_Number = $_SESSION['ChequeNumber'];
						$aa = "paid!";
						$query="SELECT * FROM `payment` WHERE `CreditorCode`='$CR_Code' AND ChequeNumber = '$CHQ_Number' ";
						$records = mysql_query($query) or die(mysql_error());	

						while($row=mysql_fetch_array($records))
						{
							$Pay_Type = $row['PaymentType'];
							$Bank_Code = $row['BankCode'];
							$CR_Code = $row['CreditorCode'];
							$CHQ_Number = $row['ChequeNumber'];
							$Pay_Amount = $row['PaymentAmount'];
							$Date_Paid = $row['DatePaid'];
							$Batch_Num = $row['BatchNumber'];
							$SEQ_Num = $row['SequenceNumber'];
							$Batch_Amt = $row['BatchValue'];
						}
						$_SESSION['invoiceno'] = NULL;
					}
				}
			}
}	
else if(isset($_POST['Update']))
{
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

	$Batch_Amt = strip_tags($_POST['Batch_Amt']);

	}
	if((!empty($_POST["Batch_Num"]))&&
	(!empty($_POST["Date_Paid"]))&&(!empty($_POST["Pay_Amount"]))&&
	(!empty($_POST["CHQ_Number"]))&&(!empty($_POST["CR_Code"]))&&(!empty($_POST["Bank_Code"]))&&(!empty($_POST["Pay_Type"]))) {
	$query = " Select * FROM payment";
	$result = mysql_query($query) or die(mysql_error());
	$exists = "no";
	$exists2 = "no";

	while($row = mysql_fetch_array($result)){
		if($row['ChequeNumber'] == $CHQ_Number ){
			$exists = "yes";
			break;
		}
	}
		
	if($exists = "no")
	{
			if(!$result)
			{
				$msg = "not Inserted";

			}
			else
			{
				$query = "UPDATE `payment` SET `PaymentType`='$Pay_Type', `BankCode`='$Bank_Code', `CreditorCode`= $CR_Code , `ChequeNumber`= $CHQ_Number,
				`PaymentAmount`= $Pay_Amount, `DatePaid`= '$Date_Paid'
				, `BatchNumber`= $Batch_Num,  `BatchValue`= $Batch_Amt
				where `ChequeNumber`= $CHQ_Number";
				$result = mysql_query($query) or die(mysql_error());


				if(!$result) 
				{

					$msg = "not Inserted";

				}
				else
				{
					
						$query ="UPDATE `payment` SET `BatchValue`=(SELECT `BatchTotal` from `batchheader` where `BatchNumber` = '$Batch_Num') where `BatchNumber`= '$Batch_Num'";
						$result = mysql_query($query) or die(mysql_error());	
						$_SESSION['PCR_Code']=$CR_Code;
						$_SESSION['ChequeNumber']=$CHQ_Number;
						$_SESSION['paybatch']=$Batch_Num;// changed
						if(!$result)
						{
							$msg = "not Inserted";

						}
						else
						{
							$query="SELECT * FROM `payment` WHERE `CreditorCode`='$CR_Code'";
							$records = mysql_query($query) or die(mysql_error());	
							$query1 = " SELECT SUM(paid_period) as paid FROM paydetailtable WHERE ChequeNo = '$CHQ_Number'";
							$records1 = mysql_query($query1) or die(mysql_error());	

							while($row1=mysql_fetch_array($records1))
							{

								$total = $row['paid'];


							}
							while($row=mysql_fetch_array($records))
							{

								$Pay_Type = $row['PaymentType'];
								$Bank_Code = $row['BankCode'];
								$CR_Code = $row['CreditorCode'];
								$CHQ_Number = $row['ChequeNumber'];
								$Pay_Amount = $row['PaymentAmount'];
								$Date_Paid = $row['DatePaid'];
								$Batch_Num = $row['BatchNumber'];
								$SEQ_Num = $row['SequenceNumber'];
								$Batch_Amt = $row['BatchValue'];


							}
						}
					
				}
			}
		}
	}

}	
else
	
$_SESSION['PCR_Code']=NULL;
{/*
$_SESSION['PCR_Code']=NULL;
$Pay_Type = NULL;
$Bank_Code = NULL;
$CR_Code = NULL;
$CHQ_Number = NULL;
$Pay_Amount = NULL;
$Date_Paid =  NULL;
$Batch_Num = NULL;
$SEQ_Num = NULL;
$Batch_Amt = NULL;
$_SESSION['PCR_Code']=NULL;*/
}
/*
if(isset($_POST['Confirm']))
{
	if($_SERVER["REQUEST_METHOD"] == "POST") 
	{
		$query = "Select * FROM `payment` WHERE BatchNumber='".strip_tags($_POST['Batch_Num'])."'";
		$records = mysql_query($query) or die (mysql_error());
		while($row=mysql_fetch_array($records)){
			++$sequence;
		}
		//--$sequence;
		
		$query = "Select * FROM `payment`";
		$records = mysql_query($query) or die (mysql_error());
		while($row=mysql_fetch_array($records)){
			$CHQ_Number = 2314111 + $row['id'];
		}
	}
}*/
?>
<html>
<head>
	
    <?php include('inc/header.php') ?>
    <?php include('inc/dhtmlx.php') ?>
	<script src="../js/crs008s.js"></script>

<script language="JavaScript">
	function setCookie(cname, cvalue) {
		document.cookie = cname + "=" + cvalue;
	}
	
	function getCookie(cname) {
		var name = cname + "=";
		var ca = document.cookie.split(';');
		for(var i=0; i<ca.length; i++) {
			var c = ca[i];
			while (c.charAt(0)==' ') c = c.substring(1);
			if (c.indexOf(name) == 0) return c.substring(name.length,c.length);
		}
		return "";
	}
	
	var MYAPP = {};
	MYAPP.counter = getCookie('chequenumber');
	if (MYAPP.counter == NULL){
		MYAPP.counter = 1;
		setCookie("chequenumber", MYAPP.counter);
	}
	
 	function changeRadioButton(el){
		
	
		var autogen = 1234 + MYAPP.counter;
		var autogenB = "RHB" + 9001 ;
	
		var input;
		var inputB;
		var pat;
		var msg;
		if (el.value == 'Auto'){
			input = autogen;
			inputB = autogenB;
			pat = "[A][B][0-9]{9,9}";
			msg = "{AB}{9-digit no.} without parentheses";
		}else if(el.value == 'Manual'){
			input = "";
			inputB = "";
			pat = "[M][B][0-9]{9,9}";
			msg = "{MB}{9-digit no.} without parentheses";
		}
		
		if (el.value == 'Confirm'){
			MYAPP.counter++;
			setCookie("chequenumber", MYAPP.counter);
		}
		
		document.getElementById("CHQ_Number").value = input.toString();
		document.getElementById("Bank_Code").value = inputB;
		document.getElementById("Batch_Num").pattern = pat;
		document.getElementById("Batch_Num").title = msg;
		
	}
	//pattern="[AM][B][0-9]{9,9}" title="{AB/MB}{9-digit no.} without parentheses"
	</script>
</head>
<body onload="startTime()">
	<?php include('inc/Nav.php') ?>
	
<div id="page-wrapper">
<div class="row">
<div class="col-lg-12">
<!--<table>
<td><label><a href="../DataUpdate.php"><button class="btn btn-default"><span class="glyphicon glyphicon-chevron-left"></span></button></a></label>
<label><a href="crs008s.php"><button class="btn btn-default"><span class="glyphicon glyphicon-refresh"></span> Refresh</button></a></label>
<label><a href="crs008s_Print.php" target="_blank"><button name="Print"  value="Print"  class="btn btn-default" /><span class="glyphicon glyphicon-print"> Print</button></a></label></td>
</table>-->

<form id="form" name="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
<table>
	<tr>
		<td colspan="2"><button onclick="changeRadioButton(this)" name="Confirm" id="Confirm" value="Confirm" class="btn btn-default"><span class="glyphicon glyphicon-ok"></span> Confirm</button>
		<label><button name="Add" id="Add" value="Add"   class="btn btn-default" href="javascript:toggleFormElements(false);"/><span class="glyphicon glyphicon-plus"></span> Add</button></label>
		<label><button name="View" value="View"   id="View"class="btn btn-default" /><span class="glyphicon glyphicon-eye-open"></span> View</button></label>
		<label><button name="CView" value="CView"   id="CView"class="btn btn-default" /><span class="glyphicon glyphicon-eye-open"></span> View Item</button></label>
		<label><button name="Edit" value="Edit"  id="Edit" class="btn btn-default" /><span class="glyphicon glyphicon-edit"></span> Edit</button></label>
		<label><button name="Update" value="Update"   id="Update"class="btn btn-default" /><span class="glyphicon glyphicon-refresh"></span> Update</button></label>
		<label><button name="Cancel" id="Cancel" value="Cancel" class="btn btn-default"><span class="glyphicon glyphicon-remove"></span> Cancel</button></label></td>
	</tr>
</table>
	<fieldset>
		<legend><strong>Payment</strong></legend>

		<div class="container">
			<table>
				<tr>
				<td align="top">Payment Type</td>
				<td>
				<label><input disabled="disabled" onclick="changeRadioButton(this)" type="radio" name="Pay_Type" id="Pay_Type" value="Auto" <?php if ($Pay_Type=='Auto') { echo 'checked'; }  ?>  />Auto</label>
				<label><input disabled="disabled" onclick="changeRadioButton(this)" type="radio" name="Pay_Type" id="Pay_Type" value="Manual"<?php if ($Pay_Type=='Manual') { echo 'checked'; } ?> />Manual</label>

				<font color="red"><?php echo $Pay_Type_Err;?></font></td>


				<tr>
				<td width="200"> Creditor Code </td>
				<td width ="300"><label><input disabled="disabled" type="text" pattern="[C][0-9]{3,3}" title="{C}{3-digit code} without parentheses"  placeholder="Enter Creditor Code" name="CR_Code" id="CR_Code" value="<?php echo $CR_Code;?>" ></label>
				<font color="red"><?php echo $CR_Code_Err;?>
				</td> 
				</tr>
				</tr>
				<tr>			
				<td>Bank Code</td>
				<td><label><input disabled="disabled" type="text"   placeholder="Enter Bank Code" name="Bank_Code" id="Bank_Code" value="<?php echo $Bank_Code;?>"></label>
				<font color="red"><?php echo $Bank_Code_Err;?>
				</td>
				</tr>

				<tr>			
				<td>Cheque Number</td>
				<td><label><input disabled="disabled" type="text" name="CHQ_Number"placeholder="Enter Cheque Number" id="CHQ_Number" value="<?php echo $CHQ_Number;?>" ></label>
				<font color="red"><?php echo "$CHQ_Number_Err $CHQExist";?>
				</td>
				</tr>
				<tr>
				<td>Payment Amount</td>
				<td><label> <input disabled="disabled" type="text" pattern="[0-9]*" title="Please enter only digits."  placeholder="Enter Payment Amount" name="Pay_Amount" type="text" id="Pay_Amount" value="<?php echo $Pay_Amount;?>" ></label>
				<font color="red"><?php echo $Pay_Amount_Err;?>
				</td>
				</tr>
				<tr>
				<td>Date Paid</td>
				<td><label> <input disabled="disabled" name="Date_Paid" id="Date_Paid" value="<?php echo $Date_Paid;?>" ></label>
				<font color="red"><?php echo $Date_Paid_Err;?>
				</td>
				</tr>
				<tr>
				<td>Batch Number</td>
				<td><label> <input disabled="disabled" type="text"  placeholder="Enter Batch Number" name="Batch_Num" type="text" id="Batch_Num" value="<?php echo $Batch_Num;?>" ></label>
				<font color="red"><?php echo $Batch_Num_Err;?>
				</td>
				</tr>
				<tr>
				<td>Sequence Number</td>
				<td><label> <input type="text"  name="SEQ_Num" type="text" id="SEQ_Num" value="<?php echo $SEQ_Num;?>" readonly STYLE="background:#ffffe0; color:#8b0000;" ></label>
				</td>
				</tr>
				<tr>
				<td>Batch Amount</td>
				<td><label> <input type="text"   name="Batch_Amt" type="text" id="Batch_Amt" readonly STYLE="background:#ffffe0; color:#8b0000;" value="<?php echo $Batch_Amt;?>" ></label>
				</td>
				</tr>
				
			</table>
		</div>
		<fieldset>

			<legend><strong>Payment Detail</strong></legend> 
					<div class="container">
			<table>	
			<tr>
			<td>Invoice</td>
			<td><label> <input  type="text"   placeholder="Invoice to be paid" name="invoiceno" type="text" id="invoiceno" value="" ></label>
			<label><button name="pay" id="pay" value="pay" class="btn btn-default"> Pay</button></label>
			<font color="red"><?php echo $overpay;?><font color="green"><?php echo $aa;?></td>
			</td>
				
			</tr>
			</table>
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
			mygrid3.setHeader("ChequeNumber,No,Date,Due Date,Invoice No,PO Number, Invoice Amount,Paid Amount, Payment Amount, Remark");//the headers of columns 
			mygrid3.setInitWidths("50,80,80,80,80,80,80,80,80")   //the widths of columns     
			mygrid3.setColAlign("left,left,right,right,right,right,right,right,right,right") //the alignment of columns          
			mygrid3.setColTypes("ro,cntr,ro,ro,ro,ro,ro,ro,ro,ro");                //the types of columns          
			mygrid3.setColSorting("connector,connector,connector,connector,connector,connector,connector,connector,connector,connector");          //the sorting types   
			mygrid3.setSkin("dhx_web");				//set the layout of grid 
			mygrid3.attachEvent("onEditCell",calculateFooterValues2)		//note calculate
			mygrid3.setSkin("dhx_web");				//set the layout of grid 
			mygrid3.init();      //finishes initialization  path to images required by grid 
			mygrid3.enableMathEditing(true);  
			mygrid3.enableSmartRendering(true);
			mygrid3.loadXML("paydetailtable.php");//for database control
			var dp3=new dataProcessor("paydetailtable.php");
			dp3.init(mygrid3);  
			mygrid3.setColumnHidden(0,true);

			var i="<?php echo $_SESSION['PCR_Code']; ?>";

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
			<script type="text/javascript">
					function change()
					{
						var elem = document.getElementById("button1");
						if (elem.value=="Edit") elem.value = "Update";
						else elem.value = "Edit";
					}
					
					$(':text').ready(function() {
					if($('#CR_Code').val() != "" ) {
					   $('#additem').removeAttr('disabled');
					   $('#removeitem').removeAttr('disabled');
					   $('#Edit').removeAttr('disabled');
					   $('#Delete').removeAttr('disabled');  
					} if ($('#CHQ_Number').val() != "" ) {
					   $('#invoiceno').removeAttr('disabled');
					   $('#pay').removeAttr('disabled');
						
					} else {
					   $('#invoiceno').attr('disabled', true);   
					   $('#pay').attr('disabled', true); 
					   $('#additem').attr('disabled', true);   
					   $('#removeitem').attr('disabled', true);   
					   $('#Edit').attr('disabled', true);   
					   $('#Delete').attr('disabled', true);   
					}
					});
				</script>
				<tr>
				<td>Total Paid Amount</td>
				<td><label> <input type="text"   name="Total_amount" type="text" id="Total_amount" readonly STYLE="background:#ffffe0; color:#8b0000;" value="<?php echo $total;?>" ></label>
				</td>
			</tr>
				<!--
			<button onclick="addRow()">Add Row</button> 
			<button onclick="removeRow()">Remove Row</button>-->
			</div>
		</fieldset>

	</fieldset>
</form>
</div>
</div>
</div>
	<!--<div id="footer">
			<table id="tb2">
				<tr>
					<td id="noti"><strong>Payment</strong></td>
					<td id="time" style="font-weight:bold;"></td>
				</tr>
			</table>
		</div>
  <p> </p>-->
</body>
</html>

