<!DOCTYPE html>
<?php
include("../databaseconnect.php");
?>
<html lang="en">
<head>
<base target="_self">
  
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
<script type="text/javascript" src='../js/jquery-ui-1.9.2.custom.js'></script>
<script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script type="text/javascript" src='../js/jquery-ui.js'></script>



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
            
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                
            </div>
        </div>
    </nav>
  <fieldset>
  
    <legend><strong>Creditor Transaction Enquiry</strong></legend>
	<table>
	<td><label><button class="btn btn-default" onclick="top.close();"><span class="glyphicon glyphicon-chevron-left"></span> Back</button></label></td>
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
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td>To Date</td>
					<td><input id="Tdate" type="text" size="10" name="To_Date" /></td>
				</tr>
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
				
					<?php
						
						
						if(isset($_POST['Find']) && isset($_POST['Trans_Type']))
						{
							
							$_SESSION['input'] = $_POST['CR'];
							$_SESSION['Sdate'] = $_POST['From_Date'];//get start date from input box
							$_SESSION['Edate'] = $_POST['To_Date'];//get end date from input box
							$_SESSION['TType'] = $_POST['Trans_Type'];
							echo "<script>window.open('crs007s_view.php','view','menubar=0');</script>";
																	
						}
						
						else if (isset($_POST['Find']) && !isset($_POST['Trans_Type']))
							echo '<script type="text/javascript">document.getElementById("noti").innerHTML="Please select a transaction type"</script>';
?>

	
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
