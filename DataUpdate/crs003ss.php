 <!DOCTYPE html>
<?php
include("../DatabaseConnect.php");

$PO_Allocation = "";
$PO_Date = "";
$PO_Number = "";
$PO_Type = "";
$PO_Amount = "";
$CR_Code = " ";

$POnumErr = "";
$POnumErr2 = "";
$POallErr = "";
$POamtErr = "";
$POdateErr = "";
$POtypeErr = "";
$POExist = " ";
$POInvalid = " ";
$CR_Code_ERR = " ";
$PO_Number_Notfound = " ";

$added = "";
$updated = "";

if(isset($_POST['Confirm']))
{
	if ($_SERVER["REQUEST_METHOD"] == "POST") {

		

		if(empty($_POST["CR_Code"])) {
			$CR_Code_ERR = "Required";
		}else {
			$CR_Code = strip_tags($_POST['CR_Code']);
		}
		if(empty($_POST["PO_Number"])) {
			$POnumErr = "Required";
		}else {
			$PO_Number = strip_tags($_POST['PO_Number']);
		}
		
		if(empty($_POST["PO_Date"])) {
			$POdateErr = "Required";
		}else {
			$PO_Date = strip_tags($_POST['PO_Date']);
		}
		
		if(empty($_POST["PO_Type"])) {
			$POtypeErr = "Required";
		}else {
			$PO_Type = strip_tags($_POST['PO_Type']);
		}
		
		if(empty($_POST["PO_Amount"])) {
			$POamtErr = "Required";
		}else{
			$PO_Amount = strip_tags($_POST['PO_Amount']);
		}
	}
	
	if((!empty($_POST["CR_Code"])) && (!empty($_POST["PO_Number"])) && (!empty($_POST["PO_Date"])) && (!empty($_POST["PO_Type"])) && (!empty($_POST["PO_Amount"]))){
		
		
		$query = " Select * FROM purchase";
		$result = mysql_query($query) or die(mysql_error());
		$exists = "no";
		
		while($row = mysql_fetch_array($result)){
			if($row['POtemp'] == $PO_Number){
				$exists = "yes";
				break;
			}
		}
		
		if($exists == "no"){
			$query = "Insert INTO `purchase`( `CreditorCode`,`POtemp`, `PODate`, `POType`, `POAmount`)
			values('$CR_Code','$PO_Number','$PO_Date','$PO_Type','$PO_Amount')";
			
			$result = mysql_query($query) or die(mysql_error());
			if(!$result)
			{
				$msg = "not Inserted";

			}
			else
			{
				$added="Added!";
				$query = "Insert INTO `podetailtable` (`CreditorCode`,`POtemp`) values ('$CR_Code','$PO_Number')";
				$result = mysql_query($query) or die(mysql_error()); 

				
				if(!$result)
				{
					$msg = "not Inserted";
				}
				else
				{
					$_SESSION['number']=$PO_Number;//store $po number 
					$query="SELECT * FROM `purchase` WHERE `POtemp`='$PO_Number'";
					$records = mysql_query($query) or die(mysql_error());	
					while($row=mysql_fetch_array($records))
					{
						$CR_Code = $row['CreditorCode'];
						$PO_Number = $row['POtemp'];
						$PO_Date = $row['PODate'];
						$PO_Type = $row['POType'];
						$PO_Amount = $row['POAmount'];
					}
				}
			}
		}else{
			
			$CR_Code = NULL;
			$PO_Allocation = NULL;
			$PO_Number = NULL;
			$PO_Date= NULL;
			$PO_Type = NULL;
			$PO_Amount =NULL;
			$_SESSION['number']=NULL;
			$POExist = "Already exists";
		}
		
		


	}

}else if(isset($_POST['CView']))
{
	$PO_Number = strip_tags($_POST['PO_Number']);
	
	$query1 = " Select * FROM purchase";
	$result = mysql_query($query1) or die(mysql_error());
	$exists = "no";
	
	while($row = mysql_fetch_array($result)){
		if($row['POtemp'] == $PO_Number){
			$exists = "yes";
			break;
		}
	}
	if($exists == "no"){
		echo "";
		$POInvalid = "No PO Number Found";
		$PO_Number = NULL;
		$_SESSION['number']=NULL;
	}else{
		$_SESSION['number']=$PO_Number;
		$query="SELECT * FROM `purchase` WHERE `POtemp`='$PO_Number'";
		$records = mysql_query($query) or die(mysql_error());	

		while($row=mysql_fetch_array($records))
		{
			$CR_Code = $row['CreditorCode'];
			$PO_Number = $row['POtemp'];
			$PO_Date = $row['PODate'];
			$PO_Type = $row['POType'];
			$PO_Amount = $row['POAmount'];
		}	
	}
	
} else if(isset($_POST['CDelete'])){
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST'){
		
		if(empty($_POST['PO_Number'])){
			$CTTerr0 = " Required";
		}else{
			$PO_Number = strip_tags($_POST['PO_Number']);
		}
	
	}
	
	if(	(!empty($_POST['PO_Number']))
		){
		$query = "SELECT * FROM purchase";
		$query2 = "SELECT * FROM podetailtable";
		$records = mysql_query($query) or die (mysql_error());
		$records2 = mysql_query($query2) or die (mysql_error());
		$exists = "no";
		while($row=mysql_fetch_array($records)){
			if($row['POtemp']==$PO_Number){
				$exists = "yes";
				$delete = "DELETE FROM purchase WHERE POtemp='".$PO_Number."'";
				$delete2 = "DELETE FROM podetailtable WHERE POtemp='".$PO_Number."'";
				$records = mysql_query($delete) or die (mysql_error());
				$records2 = mysql_query($delete2) or die (mysql_error());
				$PO_Number = NULL;
				break;
			}
		}
		if($exists=="no"){$PO_Number_Notfound = "Not found";}else{$PO_Number_Notfound = "Delete successful!";}	
	}						
}




else if(isset($_POST['Update'])){
	
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if(empty($_POST["CR_Code"])) {
			$CR_Code_ERR = "Required";
		}else {
			$CR_Code = strip_tags($_POST['CR_Code']);
		}
		if(empty($_POST["PO_Number"])) {
			$POnumErr = " Required";
		}else {
			$PO_Number = strip_tags($_POST['PO_Number']);
		}
		
		if(empty($_POST["PO_Date"])) {
			$POdateErr = " Required";
		}else {
			$PO_Date = strip_tags($_POST['PO_Date']);
		}
		
		if(empty($_POST["PO_Type"])) {
			$POtypeErr = " Required";
		}else {
			$PO_Type = strip_tags($_POST['PO_Type']);
		}
		
		if(empty($_POST["PO_Amount"])) {
			$POamtErr = " Required";
		}else{
			$PO_Amount = strip_tags($_POST['PO_Amount']);
		}
	}
	if((!empty($_POST["CR_Code"])) && (!empty($_POST["PO_Number"])) && (!empty($_POST["PO_Date"])) && (!empty($_POST["PO_Type"])) && (!empty($_POST["PO_Amount"]))){
		$query = "UPDATE `purchase` SET `CreditorCode`='$CR_Code',`PODate`='$PO_Date', `POType`='$PO_Type', `POAmount`= $PO_Amount where `POtemp`= '$PO_Number'";
		$result = mysql_query($query) or die(mysql_error());

		if(!$result)
		{
			$msg = "not Inserted";

		}
		else
		{

			$Updated="Updated!";
			
			$query="SELECT * FROM `purchase` WHERE `POtemp`='$PO_Number'";
			$records = mysql_query($query) or die(mysql_error());	

			while($row=mysql_fetch_array($records))
			{
				$CR_Code = $row['CreditorCode'];
				$PO_Number = $row['POtemp'];
				$PO_Date = $row['PODate'];
				$PO_Type = $row['POType'];
				$PO_Amount = $row['POAmount'];
			}
		}


	}

}else if(isset($_POST['Cancel'])){
	
	
	//$_SESSION['number']= NULL;
	session_destroy();
}
else{
	
	$_SESSION['number']=NULL;
	$CR_Code = NULL;
	$PO_Allocation = NULL;
	$PO_Number = NULL;
	$PO_Date= NULL;
	$PO_Type = NULL;
	$PO_Amount =NULL;
	
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
    <script src="../js/crs003s.js"></script>
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
			<label><a href="crs003s.php"><button class="btn btn-default"><span class="glyphicon glyphicon-refresh"></span> Refresh</button></a></label>
			<label><a href="crs003s_PrintIndex.php" target="_blank"><button name="Print"  value="Print"  class="btn btn-default" /><span class="glyphicon glyphicon-print"> Print</button></a></label></td>
	</table> 
   

	
	
<fieldset>

	<legend><strong>Purchase Order</strong></legend>
	<div class="container">
	<table>
		<form id="form" name="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
				
				
		<td height="10"></td>
			
		
			
			<tr>
				<td> Creditor Code  </td>
				<td width="250"> <label><input type="text" disabled="disabled" pattern="[C][0-9]{3,3}" title="{C}{3-digit code} without parentheses" placeholder="Enter Creditor Code" name="CR_Code" id="CR_Code"   value="<?php echo $CR_Code;?>" ></label> </td> 
				<td> <font color="red"><?php echo $CR_Code_ERR;?> </td>
			</tr><tr>
				<td> PO Number  </td>
				<td width="250"> <label><input type="text" disabled="disabled" pattern="[P][0-9]{3,3}" title="{P}{3-digit no.} without parentheses" placeholder="Enter PO Number" name="PO_Number" id="PO_Number"   value="<?php echo $PO_Number;?>" ></label> </td> 
				<td> <font color="red"><?php echo "$POnumErr $POExist $POInvalid $PO_Number_Notfound $added $updated";?> </td>
			</tr>
			
			<tr>						
				<td> PO Date </td>
				<td> <label><input type="text"  disabled="disabled" placeholder="Enter PO Date" name="PO_Date" id="PO_Date"   value="<?php echo $PO_Date;?>"></label> </td>
				<td> <font color="red"><?php echo $POdateErr ;?></font> </td>
			</tr>
			<tr>
				<td><p>PO Type</p></td>
				<td><p><label>
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
				<select name="PO_Type" id="PO_Type" disabled="disabled" >
					<?php 	
					$PO_Number = strip_tags($_POST['PO_Number']);
					$_SESSION['number']=$PO_Number;
					$query="SELECT POType FROM `purchase` WHERE `POtemp`='$PO_Number'";
					$records = mysql_query($query) or die(mysql_error());	

					while($row=mysql_fetch_array($records))
					{
						echo '<option value = "'.$row['POType'].'">'.$row['POType'].'</option>';
					}	
					?>
					<?php query()?>
				</select>
					<?php close()?>
				
				<!-- <input type="text"   placeholder="Enter PO Type" name="PO_Type" id="PO_Type" value="<?php echo $PO_Type;?>" > -->
				</label></p></td>
			</tr>
			<tr>
				<td> PO Amount </td>
				<td> <label> <input type="text" disabled="disabled" pattern="[0-9]*" title="Please enter only digits." placeholder="Enter PO Amount" name="PO_Amount" type="text" id="PO_Amount"   value="<?php echo $PO_Amount;?>" ></label> </td>
				<td> <font color="red"><?php echo $POamtErr;?></font> </td>
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
					<label><button  name="Update" value="Update"   id="Update"class="btn btn-default" /><span class="glyphicon glyphicon-refresh"></span> Update</button></label>
					<label><button name="Cancel" id="Cancel" value="Cancel" class="btn btn-default"><span class="glyphicon glyphicon-remove"></span> Cancel</button></label></td>
				</tr>
			</table>
	<!--<button name="additem" id="additem" class="btn btn-default">Add Row</button> -->
		</form> 
		
	</table>	</div>
	

<fieldset>
	<legend><strong>Item </strong></legend> 
	
	<div class="container">
	<div id="gridbox" style="width:750px;height:400px;"></div> 
	<script>
  
		mygrid = new dhtmlXGridObject('gridbox');// video f	or this http://www.youtube.com/watch?v=hPBwsqfyi0s
		mygrid.setImagePath('.../dhtmlx/codebase/imgs/'); //the path to images required by grid         
		mygrid.setHeader("PO reference number,Item ID,Description,Quantity,Unit Price,Total Price");//the headers of columns 
		mygrid.setInitWidths("0,150,150,150,150,142")   //the widths of columns     
		mygrid.setColAlign("left,left,left,right,right,right") //the alignment of columns          
		mygrid.setColTypes("ed,cntr,ed,ed,ed,ro[=c3*c4]");                //the types of columns          
		mygrid.setColSorting("connector,connector,connector,connector,connector,connector,connector");          //the sorting types   
		mygrid.setSkin("dhx_web");				//set the layout of grid 
		mygrid.init();      //finishes initialization  path to images required by grid 
		mygrid.enableMathEditing(true);  
		mygrid.enableSmartRendering(true);
		mygrid.loadXML("crs003s_Detail.php");//for database control
		var dp=new dataProcessor("crs003s_Detail.php");
		dp.init(mygrid);  
		mygrid.setColumnHidden(0,true);
		/*declare onli can declare this value as reference to po header the value if sum value must be null*/
		var i="<?php echo $_SESSION['number']; ?>";


		function addRow(){
			var newId = (new Date()).valueOf()
			mygrid.addRow(newId,[i,,,,],mygrid.getRowsNum())
			mygrid.selectRow(mygrid.getRowIndex(newId),false,false,true);
		}
			function removeRow(){
			var selId = mygrid.getSelectedId()
			mygrid.deleteRow(selId);
		}	

	</script>  

<button onclick="addRow()"class="btn btn-default" id = "additem" disabled><span class="glyphicon glyphicon-plus"></span>Add</button> 
	<button onclick="removeRow()"class="btn btn-default" id = "removeitem"disabled><span class="glyphicon glyphicon-remove"></span>Remove</button>
	
	<script type="text/javascript">
		function change()
		{
			var elem = document.getElementById("button1");
			if (elem.value=="Edit") elem.value = "Update";
			else elem.value = "Edit";
		}
		
		$(':text').ready(function() {
		if($('#PO_Number').val() != "" ) {
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
	</div>
</fieldset>

</fieldset>

<div id="footer">
			<table id="tb2">
				<tr>
					<td id="noti"><strong>Purchase Order</strong></td>
					<td id="time" style="font-weight:bold;"></td>
				</tr>
			</table>
		</div>


</body>
</html>

