<!DOCTYPE html>
<?php
include("../databaseconnect.php");
?>
<html>
<head>
 

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Creditor Module</title>

	<link rel="stylesheet" type="text/css" href="../dhtmlx/skins/web/dhtmlxgrid.css">
	<link rel='STYLESHEET' type='text/css' href='../dhtmlx/codebase/dhtmlxgrid.css'>
	<!-- important for loading grid-->
	<script src='../dhtmlx/codebase/dhtmlxcommon.js'></script>
	<script src='../dhtmlx/codebase/dhtmlxgrid.js'></script>		
	<script src='../dhtmlx/codebase/dhtmlxgridcell.js'></script>
	<script src='../dhtmlx/codebase/dhtmlxgrid_math.js'></script>
	<!-- important for database (update/del/edit)-->
	<script src="../dhtmlx/connector_codebase/connector.js"></script>
	<!-- important for smartrender-->
	<script src="../dhtmlx/codebase/dhtmlxgrid_srnd.js"></script>
	<!-- important for filtering-->
	<script src="../dhtmlx/codebase/dhtmlxgrid_filter.js"></script>
	<!-- Place favicon.ico and apple-touch-icon(s) here  -->
	<link rel="shortcut icon" href="../img/icon.ico">
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../bootstrap/css/logo-nav.css" rel="stylesheet">


<!--load jquery files-->
<script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script type="text/javascript" src='../js/jquery-ui.js'></script>
<script type="text/javascript" src='../js/ui.js'></script>
<script type="text/javascript" src='../js/jquery-ui-1.9.2.custom.js'></script>

<!-- css link for datepicker function -->
<link rel="stylesheet" type="text/css" href="../css/ui-lightness/jquery-ui-1.9.2.custom.css">
  
<!--add current time to footer-->
<script>
//autocomplete function
$(function() {
    var availableTags = [
      "C001",
	  "C002",
	  "C003",
	  "C004"
    ];
    $( "#CR_Code" ).autocomplete({
      source: availableTags
    });
  });
  
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

  /*$(function() {
    var availableTags = [
      "232-Pasti Nyala Sdn. Bhd",
	  "445-Sony Sdn. Bhd",
	  "334-Apple co."
    ];
    $( "#CR_Code" ).autocomplete({
      source: availableTags
    });
  });*/
  
function myFunction() {
    window.open("../CreditorList.php", "_blank", "toolbar=yes, scrollbars=yes, resizable=no, top=240, left=1000, width=400, height=400");
}

  </script>

<style type="text/css">



table#tb1 {
	border-collapse: collapse;
	width:100%;
}

td {
	padding: 6px;
}

table#tb2 td{
	border: 5px solid black;
	width:100%;
	background-color:#D8D8D8;
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
	align:center;
}

table#tb3 {
	empty-cells: show; 
	border-collapse: collapse;
	width:100%;
	height:100%;
	cellspacing:4;
}

table#tb3 td{
	border:2px solid black;
	align:center;
}

table#tb3 th{
	background-color:gray;
	color:black;
	border:2px solid black;
	padding: 6px;
	width:50%;
}

div.table_config{
	float: right;
	background:#FFF;
	height:500px;
	width:75%%;
	overflow:scroll;
	margin-right:0;
}

div.table_config2{
	float: left;
	background:#FFF;
	height:500px;
	width:25%;
	overflow:scroll;
	margin-left:0;
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

#divChoices {
    border: 2px solid red;
    position: fixed;
    top: 100;
    left: 1600;
    display: none;
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
  <fieldset>
  <div class="J_entry">
  <div class="container">
    <legend><strong>Journal Transfer</strong></legend>
	<table>
	<td><label><a href="../DataUpdate.php"><button class="btn btn-default"><span class="glyphicon glyphicon-chevron-left"></span></button></a></label>
			<label><a href="crs006s.php"><button class="btn btn-default"><span class="glyphicon glyphicon-refresh"></span> Refresh</button></a></label>
			<!--<label><a href="crs006s_Print.php" target="_blank"><button name="Print"  value="Print"  class="btn btn-default" /><span class="glyphicon glyphicon-print"> Print</button></a></label>--></td>
	</table>
	</div>
		<table align="center">
			<form id="form" name="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
				<tr>
					<td>Journal Number		:</td>
					<td>
					<label><input type="text" name="JR_Number" id="JR_Number" placeholder="Enter Journal Number" disabled="disabled"/></label>
					</td>
					<td>Journal Date 	:</td>
					<td>
					<label><input type="text" name="JR_Date" id="JR_Date" placeholder="Enter Journal Date" disabled="disabled"/></label>
					</td>
				</tr>
				<tr>
					<td>Journal Amount		:</td>
					<td>
					<label><input type="text" pattern="[0-9]*" title="Invalid input" name="JR_Amount" id="JR_Amount" placeholder="Enter Journal Amount" disabled="disabled"/></label>
					</td>
				</tr>
				<tr>
					<td>Creditor Code	:</td>
					<td>
					<label><input type="text" name="CR_Code" id="CR_Code" placeholder="Enter Creditor Code" disabled="disabled"/><label>
					</td>
				</tr>
				<tr>
					<td>Journal Reference	:</td>
					<td>
					<label><input type="text" name="JR_Ref" id="JR_Ref" pattern="[I]+[0-9]*" title="IXXXX"  placeholder="Enter Journal Reference" disabled="disabled"/></label>
					</td>
					<td>Transaction Type	:</td>
					<td>
						<label><input type="text" name="Trans_Type" id="Trans_Type" value="Invoice" readOnly style="color:black; background-color:#D0D0D0 ;"><label>
					</td>
					<td>Reference Amount	:</td>
					<td>
					<label><input type="text" name="Reference_Amount" id="Reference_Amount" placeholder="Enter Reference Amount" disabled="disabled"/></label>
					</td>
				</tr>
				<tr>
					<td>Batch Number	:</td>
					<td>
					<label><input type="text" name="Batch_Number" id="Batch_Number" placeholder="Enter Batch Number" disabled="disabled"/></label>
					</td>
					<td>Batch Amount	:</td>
					<td>
					<label><input type="text" name="Batch_Amount" id="Batch_Amount" placeholder="Batch Amount" disabled="disabled" readonly STYLE="background:#ffffe0; color:#8b0000;"/></label>
					</td>
				</tr>
				<tr>
					<td><button name="Confirm" id="Confirm" class="btn btn-default">Confirm</button>
					<button name="Cancel" id="Cancel" class="btn btn-default">Cancel</button>
					<button name="CView" id="CView" class="btn btn-default">View</button>
					<button name="Cdelete" id="Cdelete" class="btn btn-default">Delete</button>
				</tr>
				<tr><td colspan="2">
				<button name="Add" id="Add" class="btn btn-default">Add New Entry</button>
				<button name="View" id="View" class="btn btn-default">View Journal Entry</button>
				<button name="delete" id="delete" class="btn btn-default">Delete Entry</button>
				</td>
				</tr>
					</form> 
					</table>
				</div>
	
  </fieldset>
<div id="footer">
			<table id="tb2">
				<tr>
					<td id="noti"><strong>Journal Transfer</strong></td>
					<td id="time" style="font-weight:bold;"></td>
				</tr>
			</table>
		</div>
	
  <?php
	$checkseq = 20;
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
						
						$mysql = "CREATE TABLE IF NOT EXISTS `J_invoice_details`(
					`id` INT(10) NOT NULL AUTO_INCREMENT,
					`InvNumber` VARCHAR(15) NOT NULL UNIQUE,
					`BatchNumber` VARCHAR(11) NOT NULL,
					`SequenceNumber` INT(100)  NOT NULL,
					`CreditorCode` VARCHAR(11) NOT NULL,
					`InvoiceDescription` VARCHAR(50) NOT NULL,
					`InvoiceTotal` INT(15) NOT NULL,
					`InvoiceDate` date NOT NULL,
					`DatePaymentDue` date NOT NULL,
					`PONumber` VARCHAR(10) NOT NULL,
					`POType` VARCHAR(25) NOT NULL,
					`BatchValue` INT(25)  NOT NULL,
					PRIMARY KEY (`id`)
					) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci AUTO_INCREMENT=1;;";

		$myresult = mysql_query($mysql) or die (mysql_error());
		
		$mysql = "CREATE TABLE IF NOT EXISTS `J_invoice_info_details`(
					`id` INT(10) NOT NULL AUTO_INCREMENT,
					`InvNumber` VARCHAR(15) NOT NULL,
					`itemid` INT(10) NOT NULL,
					`Description` VARCHAR(15) NOT NULL,
					`UOM` Decimal(65,0) NOT NULL,
					`Quantity` Decimal(65,0)  NOT NULL,
					`UnitPrice` Decimal(65,0) NOT NULL,
					`ItemPrice` Decimal(65,0)  NOT NULL,
					`CreditorCode` VARCHAR(15) NOT NULL,
					PRIMARY KEY (`id`)
					) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci AUTO_INCREMENT=1;;";
		
		$myresult = mysql_query($mysql) or die (mysql_error());
						
	if(isset($_POST['Confirm']))
	{
			
		$JR_reference = $_POST['JR_Ref'];
		
		$JR_Number = mysql_real_escape_string($_POST['JR_Number']); 
		$JR_Date = mysql_real_escape_string($_POST['JR_Date']);
		$JR_Amount = mysql_real_escape_string($_POST['JR_Amount']);
		$CR_Code = mysql_real_escape_string($_POST['CR_Code']);
		$JR_Ref = mysql_real_escape_string($_POST['JR_Ref']);
		$Trans_Type = mysql_real_escape_string($_POST['Trans_Type']);
		$Reference_Amount = mysql_real_escape_string($_POST['Reference_Amount']);
		$Batch_Number = mysql_real_escape_string($_POST['Batch_Number']);
		$SEQ_Num = "";
		$Batch_Amount = mysql_real_escape_string($_POST['Batch_Amount']);
	
	$query = "Select MAX(SequenceNo) AS maxseq FROM `Journal` WHERE `BatchNo`='$Batch_Number'";
		$records = mysql_query($query) or die (mysql_error());
		while($row=mysql_fetch_array($records)){
			$SEQ_Num = $row['maxseq'];		
		}$query1 = "Select TransactionCount FROM BatchHeader WHERE BatchNumber='$Batch_Number'";
		$records1 = mysql_query($query1) or die (mysql_error());
		while($row1=mysql_fetch_array($records1)){
			$checkseq = $row1['TransactionCount'];
		}
		if($SEQ_Num > $checkseq){
			$Batch_Num_Err = "* Max no. of Journal";
			$JR_Number = NULL;
			$JournalDate = NULL;
			$JournalAmount = NULL;
			$CreditorCode = NULL;
			$JournalRef = NULL;
			$TransType = NULL;
			$RefAmount = NULL;
			$BatchNo = NULL;
			$SequenceNo = NULL;
			$BatchAmount = NULL;
		}
		else
		{			
			$SEQ_Num++;	
			$query1 = "UPDATE BatchHeader SET CheckTotal = '$SEQ_Num' WHERE BatchNumber = '$Batch_Number'";
			$result1 = mysql_query($query1) or die(mysql_error());
			
			
		$query = "INSERT INTO Journal(`JournalNo`, `JournalDate`, `JournalAmount`, `CreditorCode`, `JournalRef`, `TransType`, `RefAmount`, `BatchNo`, `SequenceNo`, `BatchAmount`) 
				VALUES ('$JR_Number','$JR_Date','$JR_Amount','$CR_Code','$JR_Ref','$Trans_Type','$Reference_Amount','$Batch_Number','$SEQ_Num','$Batch_Amount')";
					
		
		$Sel_From_Invoice = "INSERT INTO J_invoice_details 
		(SELECT * FROM invoice WHERE InvNumber='$JR_Ref' AND CreditorCode='$CR_Code')";// send invoice data to archive
		
		$Sel_From_Invoice_Details = "INSERT INTO J_invoice_info_details 
		(SELECT * FROM ivdetailtable WHERE InvNumber='$JR_Ref')";// send invoice data to archive
		
		$get_batch_amount = "UPDATE `Journal` SET `BatchAmount`=(SELECT `BatchTotal` from `batchheader` where `BatchNumber` = '$Batch_Number') where `BatchNo`= '$Batch_Number'";
		
		$result = mysql_query($query) or die(mysql_error());
		$result3 = mysql_query($Sel_From_Invoice) or die(mysql_error());
		$result4 = mysql_query($Sel_From_Invoice_Details) or die(mysql_error());
		$result5 = mysql_query($get_batch_amount) or die(mysql_error());
		
		
		if (mysqli_query($conn, $query)) {
			//echo the validation notification to the footer
		echo '<script type="text/javascript">document.getElementById("noti").innerHTML="Record(s) added successfully"</script>';
		} else {
		echo '<script type="text/javascript">document.getElementById("noti").innerHTML="error adding records"</script>' . mysqli_error($conn);
		}
		
		if (mysqli_query($conn, $Sel_From_Invoice)) {
			//echo the validation notification to the footer
		echo '<script type="text/javascript">document.getElementById("noti").innerHTML="Record(s) added successfully"</script>';
		} else {
		echo '<script type="text/javascript">document.getElementById("noti").innerHTML="Failed to Transfer Invoice Data To Archive"</script>' . mysqli_error($conn);
		}
		
		if (mysqli_query($conn, $Sel_From_Invoice_Details)) {
			//echo the validation notification to the footer
		echo '<script type="text/javascript">document.getElementById("noti").innerHTML="Record(s) added successfully"</script>';
		} else {
		echo '<script type="text/javascript">document.getElementById("noti").innerHTML="Failed to Transfer invoice details Data"</script>' . mysqli_error($conn);
		}
		}
	}
	
	else if(isset($_POST['CView']))
	{
		$CR_input = $_POST['CR_Code'];
		$JR_reference = $_POST['JR_Ref'];
		//$JR_Date_Input = $_POST['JR_Date'];
		
		echo '<fieldset class="fieldset1">';
		$sql3 = "SELECT * FROM journal WHERE CreditorCode = '$CR_input' AND JournalRef = '$JR_reference'";//select database
		$result3 = $conn->query($sql3);//store the result in a variable
		
			while($row3 = $result3->fetch_assoc()){
		
			echo '<div class="table_config2">';
				echo '<table id="tb3">
					<tr>
						<th bgcolor="red" colspan="2"><center>Journal Details</center></th>
					</tr>
					<tr>
						<th bgcolor="gray">Journal Number</th>
						<td id="J_Number_disp">'.$row3["JournalNo"].'</td>
					</tr>
					<tr>
						<th bgcolor="gray">Journal Date</th>
						<td id="J_Date_disp">'.$row3["JournalDate"].'</td>
					</tr>
					<tr>
						<th bgcolor="gray">Journal Amount</th>
						<td id="J_Amount_disp">'.$row3["JournalAmount"].'</td>
					</tr>
					<tr>
						<th bgcolor="gray">Creditor Code</th>
						<td id="C_Code_disp">'.$row3["CreditorCode"].'</td>
					</tr>
					<tr>
						<th bgcolor="gray">Journal Reference</th>
						<td id="J_Referrence_disp">'.$row3["JournalRef"].'</td>
					</tr>
					<tr>
						<th bgcolor="gray">Transaction Type</th>
						<td id="T_Type_disp">'.$row3["TransType"].'</td>
					</tr>
					<tr>
						<th bgcolor="gray">Reference Amount</th>
						<td id="Referrence_Amount_disp">'.$row3["RefAmount"].'</td>
					</tr>
					<tr>
						<th bgcolor="gray">Batch Number</th>
						<td id="B_Number_disp">'.$row3["BatchNo"].'</td>
					</tr>
					<tr>
						<th bgcolor="gray">Sequence Number</th>
						<td id="S_Number_disp">'.$row3["SequenceNo"].'</td>
					</tr>
					<tr>
						<th bgcolor="gray">Batch Amount</th>
						<td id="Batch_Amount_Disp">'.$row3["BatchAmount"].'</td>
					</tr>';
				
				
			echo '</table>';
		echo '</div>';
		
		
		//find related creditor
		$sql = "SELECT * FROM J_invoice_details WHERE CreditorCode = '$CR_input' AND InvNumber = '$JR_reference'";//select database
		$result = $conn->query($sql);//store the result in a variable
		
			echo'<div class="table_config">';
				echo '<table id="tb1">
				<tr bgcolor="gray">
				<th style="width:13%;"><center>Invoice Number</center></th>	
				<th><center>Item ID</center></th>
				<th><center>Description</center></th>
				<th><center>Price</center></th>
				<th><center>Quantity</center></th>
				<th><center>Total</center></th>
				</tr>';
			echo '</div>';
			
				$sql2 = "SELECT * FROM J_invoice_info_details WHERE InvNumber = '$JR_reference'";
				$result2 = $conn->query($sql2);
				
					while($row2 = $result2->fetch_assoc()){
						echo "<td>".$JR_reference."</td>";
						echo "<td>".$row2["itemid"]."</td>";
						echo "<td>".$row2["Description"]."</td>";
						echo "<td>".$row2["UnitPrice"]."</td>";
						echo "<td>".$row2["Quantity"]."</td>";
						echo "<td>".$row2["ItemPrice"]."</td>";
						echo "</tr>";
					}
	
			
			echo '</table>';
		echo '</fieldset>';	
			
			if (mysqli_query($conn, $sql)) {
				echo '<script type="text/javascript">document.getElementById("noti").innerHTML="Record(s) Available"</script>';
				} 
				else
					echo'<script type="text/javascript">document.getElementById("noti").innerHTML="No record(s) available"</script>';
		
			
			echo '<script type="text/javascript">document.getElementById("Batch_Number").innerHTML="here"</script>';
			
				
	}
	}
	
	else if(isset($_POST['Cdelete']))
	{
		$JR_No_Input =  $_POST['JR_Number'];
		$sql = "DELETE FROM journal WHERE JournalNo = '$JR_No_Input' ";//select database to be deleted
		
		if (mysqli_query($conn, $sql)) {
			echo '<script type="text/javascript">document.getElementById("noti").innerHTML="Record(s) deleted successfully"</script>';
			
		} else {
		echo '<script type="text/javascript">document.getElementById("noti").innerHTML="Error deleting record(s)"</script>'. mysqli_error($conn);
		}
	}

	?>
	
	
		
 </body>
</html>
