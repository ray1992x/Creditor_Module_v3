<!DOCTYPE html>
<?php
include("../databaseconnect.php");
?>
<html lang="en">
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

<!-- css link for datepicker function -->
<link rel="stylesheet" type="text/css" href="../css/ui-lightness/jquery-ui-1.9.2.custom.css">


<!--load jquery files-->
<script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script type="text/javascript" src='../js/jquery-ui.js'></script>
<script type="text/javascript" src='../js/ui.js'></script>
<script type="text/javascript" src='../js/jquery-ui-1.9.2.custom.js'></script>


<style type="text/css">

table#t02{
	width:100%;
}

table#t02 td{
	border:2px solid black;
	align:center;
}

table#t02 th{
	background-color:gray;
	color:black;
	border:2px solid black;
}
table#t02 th#th1 {
	width:200px;
}

table#t02 th#th2 {
	width:200px;
}
table#t02 th#th3 {
	width:100px;
}
table#t02 th#th4 {
	width:200px;
}
table#t02 th#th5 {
	width:200px;
}
table#t02 th#th6 {
	width:200px;
}


div.table_config{
	float: center;
	background:#FFF;
	height:400px;
	width:80%;
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
td {
	padding: 6px;
}
</style>

 <!---implement Jquery autocomplete-->
 <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script>
  $(function() {
    var availableTags = [
      "C001",
	  "C002",
	  "C003"
    ];
    $( "#CR" ).autocomplete({
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
  </script>
  
  
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
  
    <legend><strong>Creditor Transaction Enquiry</strong></legend>
	<table>
	<td><label><a href="../Enquiry.php"><button class="btn btn-default"><span class="glyphicon glyphicon-chevron-left"></span></button></a></label>
			<label><a href="crs007s.php"><button class="btn btn-default"><span class="glyphicon glyphicon-refresh"></span> Refresh</button></a></label></td>
	</table>
	
	<p class="largetxt"></p>
		<table>
			<form id="form" name="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
				<tr>
					<td>Creditor Code</td>
					<td>
						<input id="CR" name="CR" class="form-control txt-auto"/>
					</td>
				</tr>
				
				<tr>
					<td>From Date</td>
					<td><input id="date" type="text" size="10" name="From_Date"/></td>
					<td>To Date</td>
					<td><input id="Tdate" type="text" size="10" name="To_Date" /></td>
				<tr>
					<td style="vertical-align:top">Print</td>
					<td>
					<p>
					<label><input type="radio" name="Trans_Type" id="Trans_Type" value="Invoice"/>Invoice</label>
					<label><input type="radio" name="Trans_Type" id="Trans_Type" value="Payment" />Payment</label>
					<label><input type="radio" name="Trans_Type" id="Trans_Type" value="CreditNote"/>Credit Note</label>
					<label><input type="radio" name="Trans_Type" id="Trans_Type" value="Journal" />Journal</label>
					</p>
					</td>
				</tr>
				
				<tr><td><button name="Find"  value="View Enquiry"class="btn btn-default"/><span class="glyphicon glyphicon-eye-open"> View</button></td></tr>
			</form> 
		</table>
								  
  </fieldset>
  <header>
		<fieldset>
			<legend><strong>Creditor Transaction Details</strong></legend>
				
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
						
						
						if(isset($_POST['Find']) && isset($_POST['Trans_Type']))
						{
							
							$input = $_POST['CR'];
							$Sdate = $_POST['From_Date'];//get start date from input box
							$Edate = $_POST['To_Date'];//get end date from input box
							
						
							if($_POST['Trans_Type']=="Invoice"){
								$sql = "SELECT * FROM invoice WHERE CreditorCode = '$input' ";//select database
								$result = $conn->query($sql);//store the result in a variable
								
								if (mysqli_query($conn, $sql)) {
								//echo the validation notification to the footer
									echo '<script type="text/javascript">document.getElementById("noti").innerHTML="Record(s) added successfully"</script>';
									} else {
									echo '<script type="text/javascript">document.getElementById("noti").innerHTML="Failed to Delete Invoice Data"</script>' . mysqli_error($conn);
									}
								
								echo'<div class="table_config">';
										echo '<table id="t02">
											<tr bgcolor="gray">
											<th id="th1">Invoice Number</th>
											<th id="th2">Batch Number</th>
											<th id="th3">Sequence Number</th>
											<th id="th4">Creditor Code</th>
											<th id="th5">Invoice Date</th>
											<th id="th6">Invoice Total</th>
											<th>Payment Due</th>
											<th>PO number</th>
											</tr>';
										echo '</div>';
								
								if ($result->num_rows > 0){
											//output data for each row
											while($row = $result->fetch_assoc()){
												
												$dateP = $row['InvoiceDate'];//store payment date in a variable
												$dateTimestamp1 = strtotime($dateP);
												$dateTimestamp2 = strtotime($Sdate);
												$dateTimestamp3 = strtotime($Edate);
												
												if($dateTimestamp1>=$dateTimestamp2 && $dateTimestamp1<=$dateTimestamp3){
													echo "<tr>";
													echo "<td>" . $row["InvNumber"] . "</td>";
													echo "<td>" . $row["BatchNumber"] . "</td>";
													echo "<td>" . $row["SequenceNumber"] . "</td>";
													echo "<td>" . $row["CreditorCode"] . "</td>";
													echo "<td>" . $row["InvoiceDate"] . "</td>";
													echo "<td>" . $row["InvoiceTotal"] . "</td>";
													echo "<td>" . $row["DatePaymentDue"] . "</td>";
													echo "<td>" . $row["PONumber"] . "</td>";
													echo "</tr>";
												}
												
											}
											
										}
							}
							else if($_POST['Trans_Type']=="Payment"){
								$sql = "SELECT * FROM payment WHERE CreditorCode = '$input' ";//select database
								$result = $conn->query($sql);//store the result in a variable
								
								echo'<div class="table_config">';
								echo '<table id="t02">
								<tr bgcolor="gray">
								<th id="th1">Payment Date</th>
								<th id="th2">Payment Type</th>
								<th id="th3">Bank Code</th>
								<th id="th4">Payment Number</th>
								<th id="th5">Reference Number</th>
								<th id="th6">Payment Amount</th>
								</tr>';
								echo '</div>';
								
								if ($result->num_rows > 0){
											//output data for each row
											echo '<script type="text/javascript">document.getElementById("noti").innerHTML="Record(s) Available"</script>';
											while($row = $result->fetch_assoc()){
												
												$dateP = $row['DatePaid'];//store payment date in a variable
												$dateTimestamp1 = strtotime($dateP);
												$dateTimestamp2 = strtotime($Sdate);
												$dateTimestamp3 = strtotime($Edate);
												
												if($dateTimestamp1>=$dateTimestamp2 && $dateTimestamp1<=$dateTimestamp3){
													echo "<tr>";
													echo "<td>" . $row["DatePaid"] . "</td>";
													echo "<td>" . $row["PaymentType"] . "</td>";
													echo "<td>" . $row["BankCode"] . "</td>";
													echo "<td>" . $row["id"] . "</td>";
													echo "<td>" . $row["BatchNumber"] . "</td>";
													echo "<td>" . $row["PaymentAmount"] . "</td>";
													echo "</tr>";
												}
												
											}
										}
							
							}
							else if($_POST['Trans_Type']=="CreditNote"){
								$sql = "SELECT * FROM creditnote WHERE CreditorCode = '$input' ";//select database
								$result = $conn->query($sql);//store the result in a variable
								
								echo'<div class="table_config">';
								echo '<table id="t02">
								<tr bgcolor="gray">
								<th id="th1">Credit Note Number</th>
								<th id="th2">Batch Number</th>
								<th id="th3">Sequence Number</th>
								<th id="th4">Creditor Code</th>
								<th id="th5">Credit Note Amount</th>
								<th id="th6">Credit Note Date</th>
								</tr>';
								echo '</div>';
								
								if ($result->num_rows > 0){
											//output data for each row
											echo '<script type="text/javascript">document.getElementById("noti").innerHTML="Record(s) Available"</script>';
											while($row = $result->fetch_assoc()){
												
												$dateP = $row['DatePaid'];//store payment date in a variable
												$dateTimestamp1 = strtotime($dateP);
												$dateTimestamp2 = strtotime($Sdate);
												$dateTimestamp3 = strtotime($Edate);
												
												if($dateTimestamp1>=$dateTimestamp2 && $dateTimestamp1<=$dateTimestamp3){
													echo "<tr>";
													echo "<td>" . $row["CNnumber"] . "</td>";
													echo "<td>" . $row["BatchNumber"] . "</td>";
													echo "<td>" . $row["SequenceNumber"] . "</td>";
													echo "<td>" . $row["CreditorCode"] . "</td>";
													echo "<td>" . $row["CreditNoteAmount"] . "</td>";
													echo "<td>" . $row["CreditNoteDate"] . "</td>";
													echo "</tr>";
												}
												
											}
										}
							}
							else if($_POST['Trans_Type']=="Journal"){
								$sql = "SELECT * FROM journal WHERE CreditorCode = '$input' ";//select database
								$result = $conn->query($sql);//store the result in a variable
								
								echo'<div class="table_config">';
								echo '<table id="t02">
								<tr bgcolor="gray">
								<th id="th1">Journal Number</th>
								<th id="th2">Journal Date</th>
								<th id="th3">Journal Amount</th>
								<th id="th4">Creditor Code</th>
								<th id="th5">Journal Reference</th>
								<th id="th6">Reference Amount</th>
								</tr>';
								echo '</div>';
								
								if ($result->num_rows > 0){
											//output data for each row
											echo '<script type="text/javascript">document.getElementById("noti").innerHTML="Record(s) Available"</script>';
											while($row = $result->fetch_assoc()){
												
												$dateP = $row['DatePaid'];//store payment date in a variable
												$dateTimestamp1 = strtotime($dateP);
												$dateTimestamp2 = strtotime($Sdate);
												$dateTimestamp3 = strtotime($Edate);
												
												if($dateTimestamp1>=$dateTimestamp2 && $dateTimestamp1<=$dateTimestamp3){
													echo "<tr>";
													echo "<td>" . $row["JournalNo"] . "</td>";
													echo "<td>" . $row["JournalDate"] . "</td>";
													echo "<td>" . $row["JournalAmount"] . "</td>";
													echo "<td>" . $row["CreditorCode"] . "</td>";
													echo "<td>" . $row["JournalRef"] . "</td>";
													echo "<td>" . $row["RefAmount"] . "</td>";
													echo "</tr>";
												}
												
											}
										}
							}
							else
								echo '<script type="text/javascript">document.getElementById("noti").innerHTML="No Records Available"</script>';
									
							}
						
						else if (isset($_POST['Find']) && !isset($_POST['Trans_Type']))
							echo '<script type="text/javascript">document.getElementById("noti").innerHTML="Please select a transaction type"</script>';
								echo "</table>";
?>

		</fieldset>
  </header>
  <!--
    <div id="footer">
			<table id="tb2">
				<tr>
					<td id="noti">Creditor Transaction Enquiry<strong></strong></td>
					<td id="time" style="font-weight:bold;"></td>
				</tr>
			</table>
		</div>
		-->
 </body>
</html>
