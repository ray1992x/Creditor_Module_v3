<!DOCTYPE html>
<?php
include("../DatabaseConnect.php");
$CR_Code = "";
$CR_Name = "";
$CR_Type = "";
$ShortName = "";
$CompanyNo = "";
$CR_Period = "";
$Remark = "";
$Payment_YTD = "";
$Last_Payment_Date = "";
$Last_Payment_Date_Temp = "";
$Invoice_YTD = "";
$Last_Invoice_Date = "";
$Last_Invoice_Date_Temp = "";
$CR_Balance = "";

$Contact_Address = "";
$Contact_Name = "";
$Tel1 = "";
$Tel2 = "";
$Fax = "";
$Contact_Email = "";

$Start_Active_Date = "";
$Start_Active_Date_Temp = "";
$Last_On_Hold_Date = "";
$Last_On_Hold_Date_Temp = "";

$CR_Code_Err = "";
$CR_Name_Err = "";
$CR_Type_Err = "";
$ShortName_Err = "";
$CompanyNo_Err = "";
$CR_Period_Err = "";
$Remark_Err = "";
$Payment_YTD_Err = "";
$Last_Payment_Date_Err = "";
$Invoice_YTD_Err = "";
$Last_Invoice_Date_Err = "";
$CR_Balance_Err = "";

$Contact_Address_Err = "";
$Contact_Name_Err = "";
$Tel1_Err = "";
$Tel2_Err = "";
$Fax_Err = "";
$Contact_Email_Err = "";

$Start_Active_Date_Err = "";
$Last_On_Hold_Date_Err = "";

$CMExist = "";
$CMNoExist = "";

if(isset($_POST['Confirm']))
{
	if ($_SERVER["REQUEST_METHOD"] == "POST") 
	{
		if(empty($_POST["CR_Code"])) 
		{
			$CR_Code_Err = " Required";
		}
		else 
		{
			$CR_Code = strip_tags($_POST['CR_Code']);
		}
		
		if(empty($_POST["CR_Name"])) 
		{
			$CR_Name_Err = " Required";
		}
		else 
		{
			$CR_Name = strip_tags($_POST['CR_Name']);
		}
		
		if(empty($_POST["CR_Type"])) 
		{
			$CR_Type_Err = " Required";
		}
		else 
		{
			$CR_Type = strip_tags($_POST['CR_Type']);
		}
		
		if(empty($_POST["ShortName"])) 
		{
			$ShortName_Err = " Required";
		}
		else 
		{
			$ShortName = strip_tags($_POST['ShortName']);
		}
		
		if(empty($_POST["CompanyNo"])) 
		{
			$CompanyNo_Err = " Required";
		}
		else 
		{
			$CompanyNo = strip_tags($_POST['CompanyNo']);
		}
		
		if(empty($_POST["CR_Period"])) 
		{
			$CR_Period_Err = " Required";
		}
		else
		{
			$CR_Period = strip_tags($_POST['CR_Period']);
		}

		if(empty($_POST["Remark"])) 
		{
			$Remark_Err = " Required";
		}
		else
		{
			$Remark = strip_tags($_POST['Remark']);
		}
		
		if(empty($_POST["Contact_Address"])) 
		{
			$Contact_Address_Err = " Required";
		}
		else
		{
			$Contact_Address = strip_tags($_POST['Contact_Address']);
		}
		
		if(empty($_POST["Contact_Name"])) 
		{
			$Contact_Name_Err = " Required";
		}
		else
		{
			$Contact_Name = strip_tags($_POST['Contact_Name']);
		}
		
		if(empty($_POST["Tel1"])) 
		{
			$Tel1_Err = " Required";
		}
		else
		{
			$Tel1 = strip_tags($_POST['Tel1']);
		}
		
		if(empty($_POST["Fax"])) 
		{
			$Fax_Err = " Required";
		}
		else
		{
			$Fax = strip_tags($_POST['Fax']);
		}
		
		if(empty($_POST["Tel2"])) 
		{
			$Tel2_Err = " Required";
		}
		else
		{
			$Tel2 = strip_tags($_POST['Tel2']);
		}
		
		if(empty($_POST["Contact_Email"])) 
		{
			$Contact_Email_Err = " Required";
		}
		else
		{
			$Contact_Email = strip_tags($_POST['Contact_Email']);
		}
		/*
		if(empty($_POST["Start_Active_Date"])) 
		{
			$Start_Active_Date_Err = " Required";
		}
		else
		{
			$Start_Active_Date  = strip_tags($_POST['Start_Active_Date']);
		}
		
		if(empty($_POST["Last_On_Hold_Date"])) 
		{
			$Last_On_Hold_Date_Err = " Required";
		}
		else
		{
			$Last_On_Hold_Date = strip_tags($_POST['Last_On_Hold_Date']);
		}	*/	
		
		/*$query1 = "SELECT SUM(InvoiceTotal) AS INVtotal FROM invoice WHERE CreditorCode = '$CR_Code'";
		$query2 = "SELECT SUM(PaymentAmount) AS PAYtotal FROM payment WHERE CreditorCode = '$CR_Code'";
		$query3 = "SELECT max(InvoiceDate) AS MAXinv FROM invoice WHERE CreditorCode = '$CR_Code'";
		$query4 = "SELECT max(DatePaid) AS MAXpay FROM payment WHERE CreditorCode = '$CR_Code'";*/
		$CR_Balance = strip_tags($_POST['CR_Balance']);
		$Last_Invoice_Date = strip_tags($_POST['Last_Invoice_Date']);
		$Invoice_YTD = strip_tags($_POST['Invoice_YTD']);
		$Last_Payment_Date = strip_tags($_POST['Last_Payment_Date']);
		$Payment_YTD = strip_tags($_POST['Payment_YTD']);
	}
	
	if((!empty($_POST["CR_Code"]))&&(!empty($_POST["CR_Name"]))&&(!empty($_POST["CR_Type"]))&&(!empty($_POST["ShortName"]))&&(!empty($_POST["CompanyNo"]))&&(!empty($_POST["CR_Period"]))
		&&(!empty($_POST["Contact_Address"]))&&(!empty($_POST["Contact_Name"]))&&(!empty($_POST["Tel1"]))&&(!empty($_POST["Fax"]))
		&&(!empty($_POST["Tel2"]))&&(!empty($_POST["Contact_Email"]))/*&&(!empty($_POST["Start_Active_Date"]))&&(!empty($_POST["Last_On_Hold_Date"]))*/)
	{
		
		
		$query = "SELECT * FROM CreditorMaster";
		$result = mysql_query($query) or die(mysql_error());
		$exists = "no";
		while($row = mysql_fetch_array($result)){
			if($row['CreditorCode'] == $CR_Code){
				$exists = "yes";
				break;
			}
		}
		
		if($exists == "no"){
			$query = "INSERT INTO `CreditorMaster`(`CreditorCode`,`CreditorName`,`CreditorType`,`ShortName`,`CompanyNumber`,`CreditPeriod`,`Remark`,
					`PaymentYTD`,`LastPaymentDate`,`InvoiceYTD`,`LastInvoiceDate`,`CreditorBalance`,`Address`,`ContactName`,`Telephone1`,`Fax`,
					`Telephone2`,`Email`,`StartActiveDate`,`LastOnHoldDate`)
				VALUES('$CR_Code','$CR_Name','$CR_Type','$ShortName','$CompanyNo','$CR_Period','$Remark','$Payment_YTD','$Last_Payment_Date',
					'$Invoice_YTD','$Last_Invoice_Date','$CR_Balance','$Contact_Address','$Contact_Name','$Tel1','$Fax','$Tel2','$Contact_Email',
					'$Start_Active_Date','$Last_On_Hold_Date')";
			$result = mysql_query($query) or die(mysql_error());
			
		
				if(!$result)
			{
				$msg = "not Inserted";
			}
			else
			{
				
				$query = "UPDATE CreditorMaster SET PaymentYTD =(SELECT SUM(PaymentAmount) FROM payment WHERE CreditorCode = '$CR_Code'), InvoiceYTD = ( SELECT SUM(InvoiceTotal) from invoice WHERE CreditorCode = '$CR_Code'),
				CreditorBalance = (SELECT SUM(payment_amount) from paydetailtable WHERE CRCode = '".$CR_Code."' ), LastPaymentDate = (SELECT MAX(DatePaid) FROM payment WHERE CreditorCode = '$CR_Code'),LastInvoiceDate = (SELECT MAX(InvoiceDate) FROM invoice WHERE CreditorCode = '$CR_Code')WHERE CreditorCode = '$CR_Code'";
				$result = mysql_query($query) or die(mysql_error());
							
				$_SESSION['CR_Code']=$CR_Code;//store $cr code 
				if(!$result)
				{
					$msg = "not Inserted";		
				}
				else
				{
					$query = "SELECT * FROM CreditorMaster WHERE CreditorCode = '$CR_Code'";
					$record = mysql_query($query) or die(mysql_error());
					
					while ($row = mysql_fetch_array($record))
					{
						$CR_Code = NULL;
						$CR_Name = NULL;
						$CR_Type = NULL;
						$ShortName = NULL;
						$CompanyNo = NULL;
						$CR_Period = NULL;
						$Remark = NULL;
						$Payment_YTD = NULL;
						$Last_Payment_Date = NULL;
						$Invoice_YTD = NULL;
						$Last_Invoice_Date = NULL;
						$CR_Balance = NULL;

						$Contact_Address = NULL;
						$Contact_Name = NULL;
						$Tel1 = NULL;
						$Tel2 = NULL;
						$Fax = NULL;
						$Contact_Email = NULL;

						$Start_Active_Date = NULL;
						$Last_On_Hold_Date = NULL;
					}
				}
			}
		}else{
			$CMExist = "";
			$CMExist = "Already exists";
		}

	}
}
else if(isset($_POST['CView'])){
			$CR_Code = strip_tags($_POST['CR_Code']);
			$_SESSION['CR_Code']=$CR_Code;//store $cr code 
			
			$query = "SELECT * FROM CreditorMaster";
		$result = mysql_query($query) or die(mysql_error());
		$exists = "no";
		while($row = mysql_fetch_array($result)){
			if($row['CreditorCode'] == $CR_Code){
				$exists = "yes";
				break;
			}
		}
		
		if($exists == "no"){
			$CMNoExist = "Not Found";
		}else{
			$query1 = "SELECT SUM(payment_amount) AS payamt from paydetailtable WHERE CRCode = '".$CR_Code."'";
			$query2 = "SELECT SUM(paid_period) AS payprd from paydetailtable WHERE CRCode = '".$CR_Code."'";
			$result1 = mysql_query($query1) or die(mysql_error());
			$result2 = mysql_query($query2) or die(mysql_error());
			while ($row1 = mysql_fetch_array($result1))
			{
				$a = $row1['payamt'];
			}
			while ($row2 = mysql_fetch_array($result2))
			{
				$b = $row2['payprd'];
			}
			
			$balance = $a - $b;
			
			$query = "UPDATE CreditorMaster SET PaymentYTD =(SELECT SUM(PaymentAmount) FROM payment WHERE CreditorCode = '$CR_Code'), InvoiceYTD = ( SELECT SUM(InvoiceTotal) from invoice WHERE CreditorCode = '$CR_Code'),
			CreditorBalance = '$balance', LastPaymentDate = (SELECT MAX(DatePaid) FROM payment WHERE CreditorCode = '$CR_Code'),LastInvoiceDate = (SELECT MAX(InvoiceDate) FROM invoice WHERE CreditorCode = '$CR_Code')WHERE CreditorCode = '$CR_Code'";
			$result = mysql_query($query) or die(mysql_error());
			if(!$result)
			{
				$msg = "not Inserted";		
			}
			else
			{
				$query = "SELECT * FROM CreditorMaster WHERE CreditorCode = '$CR_Code'";
				$record = mysql_query($query) or die(mysql_error());
				
				while ($row = mysql_fetch_array($record))
				{
					$CR_Code = $row['CreditorCode'];
					$CR_Name = $row['CreditorName'];
					$CR_Type = $row['CreditorType'];
					$ShortName = $row['ShortName'];
					$CompanyNo = $row['CompanyNumber'];
					$CR_Period = $row['CreditPeriod'];
					$Remark = $row['Remark'];
					$Payment_YTD = $row['PaymentYTD'];
					$Last_Payment_Date = $row['LastPaymentDate'];
					$Invoice_YTD = $row['InvoiceYTD'];
					$Last_Invoice_Date = $row['LastInvoiceDate'];
					$CR_Balance = $row['CreditorBalance'];

					$Contact_Address = $row['Address'];
					$Contact_Name = $row['ContactName'];
					$Tel1 = $row['Telephone1'];
					$Tel2 = $row['Telephone2'];
					$Fax = $row['Fax'];
					$Contact_Email = $row['Email'];

					$Start_Active_Date = $row['StartActiveDate'];
					$Last_On_Hold_Date = $row['LastOnHoldDate'];
				}
			}
		}
}else if(isset($_POST['Update'])){
	if ($_SERVER["REQUEST_METHOD"] == "POST") 
	{
		if(empty($_POST["CR_Code"])) 
		{
			$CR_Code_Err = " Required";
		}
		else 
		{
			$CR_Code = strip_tags($_POST['CR_Code']);
		}
		
		if(empty($_POST["CR_Name"])) 
		{
			$CR_Name_Err = " Required";
		}
		else 
		{
			$CR_Name = strip_tags($_POST['CR_Name']);
		}
		
		if(empty($_POST["CR_Type"])) 
		{
			$CR_Type_Err = " Required";
		}
		else 
		{
			$CR_Type = strip_tags($_POST['CR_Type']);
		}
		
		if(empty($_POST["ShortName"])) 
		{
			$ShortName_Err = " Required";
		}
		else 
		{
			$ShortName = strip_tags($_POST['ShortName']);
		}
		
		if(empty($_POST["CompanyNo"])) 
		{
			$CompanyNo_Err = " Required";
		}
		else 
		{
			$CompanyNo = strip_tags($_POST['CompanyNo']);
		}
		
		if(empty($_POST["CR_Period"])) 
		{
			$CR_Period_Err = " Required";
		}
		else
		{
			$CR_Period = strip_tags($_POST['CR_Period']);
		}

		if(empty($_POST["Remark"])) 
		{
			$Remark_Err = " Required";
		}
		else
		{
			$Remark = strip_tags($_POST['Remark']);
		}
		
		if(empty($_POST["Contact_Address"])) 
		{
			$Contact_Address_Err = " Required";
		}
		else
		{
			$Contact_Address = strip_tags($_POST['Contact_Address']);
		}
		
		if(empty($_POST["Contact_Name"])) 
		{
			$Contact_Name_Err = " Required";
		}
		else
		{
			$Contact_Name = strip_tags($_POST['Contact_Name']);
		}
		
		if(empty($_POST["Tel1"])) 
		{
			$Tel1_Err = " Required";
		}
		else
		{
			$Tel1 = strip_tags($_POST['Tel1']);
		}
		
		if(empty($_POST["Fax"])) 
		{
			$Fax_Err = " Required";
		}
		else
		{
			$Fax = strip_tags($_POST['Fax']);
		}
		
		if(empty($_POST["Tel2"])) 
		{
			$Tel2_Err = " Required";
		}
		else
		{
			$Tel2 = strip_tags($_POST['Tel2']);
		}
		
		if(empty($_POST["Contact_Email"])) 
		{
			$Contact_Email_Err = " Required";
		}
		else
		{
			$Contact_Email = strip_tags($_POST['Contact_Email']);
		}
		
		/*$query1 = "SELECT SUM(InvoiceTotal) AS INVtotal FROM invoice WHERE CreditorCode = '$CR_Code'";
		$query2 = "SELECT SUM(PaymentAmount) AS PAYtotal FROM payment WHERE CreditorCode = '$CR_Code'";
		$query3 = "SELECT max(InvoiceDate) AS MAXinv FROM invoice WHERE CreditorCode = '$CR_Code'";
		$query4 = "SELECT max(DatePaid) AS MAXpay FROM payment WHERE CreditorCode = '$CR_Code'";*/
		$CR_Balance = strip_tags($_POST['CR_Balance']);
		$Last_Invoice_Date = strip_tags($_POST['Last_Invoice_Date']);
		$Invoice_YTD = strip_tags($_POST['Invoice_YTD']);
		$Last_Payment_Date = strip_tags($_POST['Last_Payment_Date']);
		$Payment_YTD = strip_tags($_POST['Payment_YTD']);
	}
	if((!empty($_POST["CR_Code"]))&&(!empty($_POST["CR_Name"]))&&(!empty($_POST["CR_Type"]))&&(!empty($_POST["ShortName"]))&&(!empty($_POST["CompanyNo"]))&&(!empty($_POST["CR_Period"]))
		&&(!empty($_POST["Contact_Address"]))&&(!empty($_POST["Contact_Name"]))&&(!empty($_POST["Tel1"]))&&(!empty($_POST["Fax"]))
		&&(!empty($_POST["Tel2"]))&&(!empty($_POST["Contact_Email"])))
	{
							
				$query = "UPDATE CreditorMaster SET CreditorCode = '$CR_Code', CreditorName='$CR_Name', CreditorType='$CR_Type', ShortName='$ShortName', CompanyNumber='$CompanyNo',
				CreditPeriod='$CR_Period',Remark='$Remark', Address='$Contact_Address', ContactName='$Contact_Name', Telephone1='$Tel1', Telephone2='$Tel2', Fax='$Fax', Email='$Contact_Email', StartActiveDate='$Start_Active_Date', LastOnHoldDate='$Last_On_Hold_Date',
				PaymentYTD =(SELECT SUM(PaymentAmount) FROM payment WHERE CreditorCode = '$CR_Code'), InvoiceYTD = ( SELECT SUM(InvoiceTotal) from invoice WHERE CreditorCode = '$CR_Code'),
				CreditorBalance = (SELECT SUM(payment_amount) from paydetailtable WHERE CRCode = '".$CR_Code."' ), LastPaymentDate = (SELECT MAX(DatePaid) FROM payment WHERE CreditorCode = '$CR_Code'),LastInvoiceDate = (SELECT MAX(InvoiceDate) FROM invoice WHERE CreditorCode = '$CR_Code')WHERE CreditorCode = '$CR_Code'";
				$result = mysql_query($query) or die(mysql_error());
							
				$_SESSION['CR_Code']=$CR_Code;//store $cr code 
				if(!$result)
				{
					$msg = "not Inserted";		
				}
				else
				{
					$query = "SELECT * FROM CreditorMaster WHERE CreditorCode = '$CR_Code'";
					$record = mysql_query($query) or die(mysql_error());
					
					while ($row = mysql_fetch_array($record))
					{
						$CR_Code = NULL;
						$CR_Name = NULL;
						$CR_Type = NULL;
						$ShortName = NULL;
						$CompanyNo = NULL;
						$CR_Period = NULL;
						$Remark = NULL;
						$Payment_YTD = NULL;
						$Last_Payment_Date = NULL;
						$Invoice_YTD = NULL;
						$Last_Invoice_Date = NULL;
						$CR_Balance = NULL;

						$Contact_Address = NULL;
						$Contact_Name = NULL;
						$Tel1 = NULL;
						$Tel2 = NULL;
						$Fax = NULL;
						$Contact_Email = NULL;

						$Start_Active_Date = NULL;
						$Last_On_Hold_Date = NULL;
					}
				}
	}

}
else
{
	$_SESSION['CRCode']= NULL;
	$CR_Code = NULL;
	$CR_Name = NULL;
	$CR_Type = NULL;
	$ShortName = NULL;
	$CompanyNo = NULL;
	$CR_Period = NULL;
	$Remark = NULL;
	$Payment_YTD = NULL;
	$Last_Payment_Date = NULL;
	$Invoice_YTD = NULL;
	$Last_Invoice_Date = NULL;
	$CR_Balance = NULL;

	$Contact_Address = NULL;
	$Contact_Name = NULL;
	$Tel1 = NULL;
	$Tel2 = NULL;
	$Fax = NULL;
	$Contact_Email = NULL;

	$Start_Active_Date = NULL;
	$Last_On_Hold_Date = NULL;
}


?>

<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Creditor Module</title>

	<link rel="shortcut icon" href="../img/icon.ico">
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../bootstrap/css/logo-nav.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="../css/ui-lightness/jquery-ui-1.9.2.custom.css">
	
    <script src="../bootstrap/js/jquery.js"></script>
    <script src="../bootstrap/js/bootstrap.min.js"></script>
	<script src="../js/crs002s.js"></script>
	<script type="text/javascript" src='../js/jquery-ui-1.9.2.custom.js'></script>
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.js"></script>
	<script type="text/javascript" src='../js/jquery-ui.js'></script>
		
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
		div#footer {
			position:fixed;
			bottom:0;
			right:auto;
			left:auto;
			width:100%;
			height:40px;
			background-color:grey;
		}

		table#tb1 {
			border-collapse: collapse;
			
		}		

		td {
			padding: 6px;
		}

		table#tb1 td {
			border:2px solid black;
			align:center;
			
		}

		table#tb1 th {
			background-color:gray;
			color:black;
			border:2px solid black;
			padding: 6px;
		}

		div.table_config {
			float: center;
			background:#FFF;
			height:400px;
			width:100%;
			overflow:scroll;
			margin-left:auto;
			margin-right:auto;
		}
		
		table#tb2 td {
			border: 4px solid black;
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
<table >
<td><label><a href="../DataUpdate.php"><button class="btn btn-default"><span class="glyphicon glyphicon-chevron-left"></span></button></a></label>
		<label><a href="crs002s.php"><button class="btn btn-default"><span class="glyphicon glyphicon-refresh"></span> Refresh</button></a></label>
		<label><a href="crs002s_PrintIndex.php"><button name="Print"  value="Print"  class="btn btn-default" /><span class="glyphicon glyphicon-print"> Print</button></a></label></td>
</table>
<fieldset>
<legend><strong>Creditor Master Table</strong></legend>
<!--<fieldset>-->
<!--<table align="center">-->
<form id="form" name="form" method="post" action="">
	<div class="container">
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
</div>
		
<div class="table_config">
<div class="container">
<legend><strong>Creditor Detail</strong></legend>
<table align="center">
<td height="10"></td>

<tr>
<td width="200"><p>Creditor Code</p></td>
<td width="250"><p><label><input disabled="disabled" type="text" placeholder="Enter Creditor Code" name="CR_Code" id="CR_Code" value="<?php echo $CR_Code;?>" pattern="[C]{1}[0-9]{3}" maxlength="3" ></label></p><font color="red"><?php echo "$CR_Code_Err $CMExist $CMNoExist";?></font></td>
</tr>
<tr>			
<td><p>Creditor Name</p></td>
<td><p><label><input disabled="disabled" type="text" placeholder="Enter Creditor Name" name="CR_Name" id="CR_Name" value="<?php echo $CR_Name;?>"></label></p><font color="red"><?php echo $CR_Name_Err;?></font></td>
</tr>
<tr>
<td><p>Creditor Type</p></td>
<td><p><label>
<select disabled="disabled" name="CR_Type" id="CR_Type"  >
							<?php
							$query = "SELECT CRtype FROM credittypetable";
							$records = mysql_query($query) or die(mysql_error());	
							while($row=mysql_fetch_array($records)){
								echo '<option value="' . $row['CRtype'] . '"';
								if ($CR_Type==$row['CRtype']){echo 'selected';}
								echo '>' . $row['CRtype'] . '</option>';
							}
							?>
</select>
</tr>
<tr>
<td><p>Short Name</p></td>
<td><p><label> <input disabled="disabled" type="text" placeholder="Enter Short Name" name="ShortName" id="ShortName" value="<?php echo $ShortName;?>" ></label></p><font color="red"><?php echo $ShortName_Err;?></font></td>
</tr>
<tr>
<td><p>Company Number</p></td>
<td><p><label> <input disabled="disabled" type="text" placeholder="Enter Company Number" name="CompanyNo" id="CompanyNo" value="<?php echo $CompanyNo;?>" pattern="[0-9]*" ></label></p><font color="red"><?php echo $CompanyNo_Err;?></font></td>
</tr>
<tr>
<td><p>Credit Period</p></td>
<td><p><label> <input disabled="disabled" type="text" placeholder="Enter Credit Period" name="CR_Period" id="CR_Period" value="<?php echo $CR_Period;?>" pattern="[0-9]*"></label></p><font color="red"><?php echo $CR_Period_Err;?></font></td>
</tr>
<tr>
<td><p>Remark</p></td>
<td><p><label> <input disabled="disabled" type="text" placeholder="Enter Remark" name="Remark" id="Remark" value="<?php echo $Remark;?>" pattern="[a-zA-z]*" oninvalid="setCustomValidity('Invalid Input')" ></label></p><font color="red"><?php echo $Remark_Err;?></font></td>
</tr>
<tr>
<td><p>Payment YTD</p></td>
<td><p><label> <input type="text" readonly STYLE="background:#ffffe0; color:#8b0000;" name="Payment_YTD" id="Payment_YTD" value="<?php echo $Payment_YTD;?>"></label></p></td>
<td width="150"><p>&nbsp;&nbsp;&nbsp;&nbsp;Last Payment Date</p></td>
<td><p><label> <input type="text" readonly STYLE="background:#ffffe0; color:#8b0000;" name="Last_Payment_Date" id="Last_Payment_Date" value="<?php echo $Last_Payment_Date;?>" ></label></p></td>
</tr>
<tr>
<td><p>Invoice YTD</p></td>
<td><p><label> <input type="text" readonly STYLE="background:#ffffe0; color:#8b0000;" name="Invoice_YTD" id="Invoice_YTD" value="<?php echo $Invoice_YTD;?>" ></label></p></td>
<td><p>&nbsp;&nbsp;&nbsp;&nbsp;Last Invoice Date</p></td>
<td><p><label> <input type="text" readonly STYLE="background:#ffffe0; color:#8b0000;" name="Last_Invoice_Date" id="Last_Invoice_Date" value="<?php echo $Last_Invoice_Date;?>" ></label></p></td>
</tr>
<td><p>Creditor Balance</p></td>
<td><p><label> <input type="text"  readonly STYLE="background:#ffffe0; color:#8b0000;"name="CR_Balance" id="CR_Balance" value="<?php echo $CR_Balance;?>" ></label></p></td>
</tr>
</table>

<!--</fieldset>-->

<!--<fieldset>-->
<!--<div class="container">-->
<legend><strong>Contact Detail</strong></legend>
<!--</div>-->
<table>
<tr><p>
<td width="200"><p>Address</p></td>
<td width="250"><label><TextArea disabled="disabled" ROWS = 3 COLS = 20 placeholder="Enter Address" name="Contact_Address" class="resizedTextbox" id="Contact_Address"  ><?php echo $Contact_Address;?></TextArea></label>
<font color="red"><?php echo $Contact_Address_Err;?></font></td> 
</tr>
<tr><td> &nbsp;</td></tr>		
<tr>
<td width="200"><p>Contact Name</p></td>
<td width="250"><p><label><input disabled="disabled" type="text" placeholder="Enter Contact Name" name="Contact_Name" id="Contact_Name" value="<?php echo $Contact_Name;?>" pattern="[a-zA-Z]*"></label> 
<font color="red"><?php echo $Contact_Name_Err;?></font></td>
</tr>
<tr>
<td><p>Contact Telephone 1</p></td>
<td><p><label><input disabled="disabled" type="text" placeholder="eg.08x-xxxxxx" name="Tel1" id="Tel1" value="<?php echo $Tel1;?>" pattern="[0-9]*"></label>
<font color="red"><?php echo $Tel1_Err;?></font></td> 
<td><p>&nbsp;&nbsp;&nbsp;&nbsp;Fax Contact</td>
<td><p><label><input disabled="disabled" type="text" placeholder="Enter Fax" name="Fax" id="Fax" value="<?php echo $Fax;?>" pattern="[0-9]*"></label>
<font color="red"><?php echo $Fax_Err;?></font></td> 
</tr>	
<tr>
<td><p>Contact Telephone 2</p></td>
<td><p><label><input disabled="disabled" type="text" placeholder="eg.08x-xxxxxx" name="Tel2" id="Tel2" value="<?php echo $Tel2;?>" ></label>
<font color="red"><?php echo $Tel2_Err;?></font></td> 
<td width="150"><p>&nbsp;&nbsp;&nbsp;&nbsp;E-mail Contact</td>
<td><p><label><input disabled="disabled" type="text" placeholder="Enter E-mail" name="Contact_Email" id="Contact_Email" value="<?php echo $Contact_Email;?>" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" oninvalid="setCustomValidity('Invalid Email!')"></label>
<font color="red"><?php echo $Contact_Email_Err;?></font></td>
</tr>			

</table>
<!--</fieldset>-->

<!--<fieldset>-->
<!--<div class="container">-->
<!--<legend><strong>Other Detail</strong></legend>
</div>
<table align="center">
<tr>
<td width="200"><p>Account Status</p></td>
<td><label>&nbsp;<input type="radio" name="Account_Status" value="Active" />Active/Added</label>
<label>&nbsp;<input type="radio" name="Account_Status" value="Deleted" />Deleted</label>
<label>&nbsp;<input type="radio" name="Account_Status" value="Suspended" />Suspended</label></td>
</tr>
<tr>
<td><p>Start Active Date</p></td>
<td><label>&nbsp;<input type="text" placeholder="Enter Start Active Date" name="Start_Active_Date" id="Start_Active_Date" value="<?php echo $Start_Active_Date;?>" ></label>
<font color="red"><?php echo $Start_Active_Date_Err;?></font></td>
</tr>
<tr>
<td><p>Last On Hold Date</p></td>
<td><label>&nbsp;<input type="text" placeholder="Enter Last On Hold Date" name="Last_On_Hold_Date" id="Last_On_Hold_Date" value="<?php echo $Last_On_Hold_Date;?>" ></label>
<font color="red"><?php echo $Last_On_Hold_Date_Err;?></font></td><td width="340">&nbsp;</td>
</tr>
</table>-->
</div>
</div>
</form>
<!--</fieldset>-->

</fieldset> 
<div>
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
	
	
	
		$sql = "SELECT * FROM CreditorMaster  ";//select database
		$result = $conn->query($sql);//store the result in a variable
		
					echo'<div class="table_config">';
						echo '<table id="tb1">
						<tr bgcolor="gray">
							<th>Creditor Code</th>
							<th>Creditor Name</th>
							<th>Creditor Type</th>
							<th>Short Name</th>
							<th>Company Number</th>
							<th>Credit Period</th>
							<th>Remark</th>
							<th>Payment YTD</th>
							<th>Last Payment Date</th>
							<th>Invoice YTD</th>
							<th>Last Invoice Date</th>
							<th>Creditor Balance</th>
							<th>Address</th>
							<th>Contact Name</th>
							<th>Telephone 1</th>
							<th>Fax</th>
							<th>Telephone 2</th>
							<th>E-mail</th>
						</tr>';
						
						while($row = $result->fetch_assoc()){
							echo "<tr>";
							echo "<td>".$row["CreditorCode"]."</td>";
							echo "<td>".$row["CreditorName"]."</td>";
							echo "<td>".$row["CreditorType"]."</td>";
							echo "<td>".$row["ShortName"]."</td>";
							echo "<td>".$row["CompanyNumber"]."</td>";
							echo "<td>".$row["CreditPeriod"]."</td>";
							echo "<td>".$row["Remark"]."</td>";
							echo "<td>".$row["PaymentYTD"]."</td>";
							echo "<td>".$row["LastPaymentDate"]."</td>";
							echo "<td>".$row["InvoiceYTD"]."</td>";
							echo "<td>".$row["LastInvoiceDate"]."</td>";
							echo "<td>".$row["CreditorBalance"]."</td>";
							echo "<td>".$row["Address"]."</td>";
							echo "<td>".$row["ContactName"]."</td>";
							echo "<td>".$row["Telephone1"]."</td>";
							echo "<td>".$row["Fax"]."</td>";
							echo "<td>".$row["Telephone2"]."</td>";
							echo "<td>".$row["Email"]."</td>";
							echo "</tr>";
						}
					echo '</table></div>';
?>
</div>
<script type="text/javascript">
		
		$(':text').ready(function() {
		if($('#CR_Code').val() != "" ) {
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
<br><br>
<div id="footer">
			<table id="tb2">
				<tr>
					<td id="noti"><strong>Creditor Master Table</strong></td>
					<td id="time" style="font-weight:bold;"></td>
				</tr>
			</table>
		</div>
  
</body>
</html>
