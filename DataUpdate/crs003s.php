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
	
	include('crs003s/Confirm.php');

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
	
	/*if ($_SERVER['REQUEST_METHOD'] == 'POST'){
		
		if(empty($_POST['PO_Number'])){
			$CTTerr0 = " Required";
		}else{
			$PO_Number = strip_tags($_POST['PO_Number']);
		}
	
	}*/
	
	//if(	(!empty($_POST['PO_Number']))
	//	){
		/*$query = "SELECT * FROM purchase";
		$query2 = "SELECT * FROM podetailtable";
		$records = mysql_query($query) or die (mysql_error());
		$records2 = mysql_query($query2) or die (mysql_error());
		$exists = "no";
		while($row=mysql_fetch_array($records)){
			if($row['POtemp']==$PO_Number){
				$exists = "yes";*/
				$PO_Number = $_SESSION['number'];
				$delete = "DELETE FROM purchase WHERE POtemp='".$PO_Number."'";
				$delete2 = "DELETE FROM podetailtable WHERE POtemp='".$PO_Number."'";
				$records = mysql_query($delete) or die (mysql_error());
				$records2 = mysql_query($delete2) or die (mysql_error());
				$PO_Number = NULL;
				$_SESSION['number'] = NULL;
				//break;
		//	}
		//}
		//if($exists=="no"){$PO_Number_Notfound = "Not found";}else{$PO_Number_Notfound = "Delete successful!";}	
	//}						
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
	
	
	$_SESSION['number']=NULL;
	$CR_Code = NULL;
	$PO_Allocation = NULL;
	$PO_Number = NULL;
	$PO_Date= NULL;
	$PO_Type = NULL;
	$PO_Amount =NULL;
}else if(isset($_POST['Clear'])){
	
	
	$_SESSION['number']=NULL;
	$CR_Code = NULL;
	$PO_Allocation = NULL;
	$PO_Number = NULL;
	$PO_Date= NULL;
	$PO_Type = NULL;
	$PO_Amount =NULL;
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

    <?php include('inc/header.php') ?>
    <?php include('inc/dhtmlx.php') ?>
	<script src="../js/crs003s.js"></script>
		<script>
	$(document).ready(function(){
		$('#hidden').hide();
		
		$('#searchCred').click(function(){
			$('#hidden').show('slow');
		});
		
		$('#close').click(function(){
			$('#hidden').hide('slow');
		});
	
	});
	
	$(':text').ready(function() {
		if($('#CR_Code').val() != "" ) {
		   event.preventDefault();
			$('#CR_Code,#PO_Number,#PO_Date,#PO_Amount').prop("disabled", false);
			$('#Confirm ,#Cancel').show();
			$(' #Add, #View, #Edit, #Delete').hide();
			}
	});
	</script>
	<link rel="stylesheet" type="text/css" href="../css/style.css">


</head>
<body onload="startTime()">
	<?php include('inc/Nav.php') ?>
	
<div id="page-wrapper">
	<div class="row">
		<div class="col-lg-12">
 
 	
<!--<label><button class="btn btn-default"><span class="glyphicon glyphicon-refresh"></span> Clear</button></a></label>-->
 
  
   

	
<table>
<form id="form" name="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

	 <table>
		<button name="Confirm" id="Confirm" value="Confirm" class="btn btn-default"><span class="glyphicon glyphicon-ok"></span> Confirm</button>
		<label><button name="Add" id="Add" value="Add"   class="btn btn-default" href="javascript:toggleFormElements(false);"/><span class="glyphicon glyphicon-plus"></span> Add</button></label>
		<label><button name="View" value="View"   id="View"class="btn btn-default" /><span class="glyphicon glyphicon-eye-open"></span> View</button></label>
		<label><button name="CView" value="CView"   id="CView"class="btn btn-default" /><span class="glyphicon glyphicon-eye-open"></span> View Item</button></label>
		<label><button name="Edit" value="Edit"  id="Edit" class="btn btn-default" /><span class="glyphicon glyphicon-edit"></span> Edit</button></label>
		<label><button name="Delete" value="Delete"   id="Delete"class="btn btn-default" /><span class="glyphicon glyphicon-remove"></span> Delete</button></label>
		<label><button name="CDelete" value="CDelete"   id="CDelete"class="btn btn-default" /><span class="glyphicon glyphicon-ok"></span> Confirm</button></label>
		<label><button  name="Update" value="Update"   id="Update"class="btn btn-default" /><span class="glyphicon glyphicon-refresh"></span> Update</button></label>
		<label><button name="Cancel" id="Cancel" value="Cancel" class="btn btn-default"><span class="glyphicon glyphicon-remove"></span> Cancel</button></label> 
		<label><button name="Clear" id="Clear" value="Clear" class="btn btn-default"><span class="glyphicon glyphicon-remove"></span> Clear</button></label> 
	 </table>
	 
 
	<legend><strong>Purchase Order</strong></legend>
	<div class="container">
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

$_SESSION['CurrCred']="";
					$seq=1;	
					
								echo '<div id="hidden">
								<form method="post" id="subCred">
								<table class="record_table">

									<tr>
										<th></th>
										<th width="20">No.</th>
										<th width="120">Creditor Code</th>
										<th width="200">Description</th>
									</tr>';
									$sql = "SELECT * FROM creditor";//select database
									$result = $conn->query($sql);//store the result in a variable
									
									while($row =  $result->fetch_assoc()){
										echo '<tr>';
											echo '<td><input type="radio" name="check" id="check" value="'.$row["CreditorCode"].'"></td>';
											echo '<td>'.$seq++.'</td>';
											echo '<td>'.$row["CreditorCode"].'</td>';
											echo '<td>'.$row["CreditorName"].'</td>';
										echo '</tr>';
									}
									echo '</table>';

								echo '<input type="submit" name="selCred" id="selCred" value="OK">
								<button type="button" id="close">Close</button>
								';
								
							if(isset($_POST['selCred']) && isset($_POST['check']))
							{
								$data1 = $_POST['check'];
								$_SESSION['CurrCred']=$data1;
							}
							else if(isset($_POST['confirm']) && !isset($_POST['check']))
								echo "Please select a creditor.";
							echo '</div>';
					?>
	<table>
					
					
			<td height="10"> 
				
			
				<tr>
					<td><p><label>Creditor Code </td>  
					 <td><label><input type="text"   disabled="disabled"placeholder="Enter Creditor Code" name="CR_Code" id="CR_Code"   value="<?php echo "".$_SESSION['CurrCred'].""; ?>" ></label>   
					 </label></p></td>
					 <td><button id="searchCred" type="button"><img src="../img/search.icon.png"></button></td>
				  </tr>
				  <tr>
					  <td><p><label>PO Number  </td> 
					<td width="250"> <label><input type="text" disabled="disabled" minlength="4" required  placeholder="Enter PO Number" name="PO_Number" id="PO_Number"   value="<?php echo $PO_Number;?>" ></label>   
					  <font color="red"><?php echo "$POExist $POInvalid $PO_Number_Notfound $added $updated";?>  </font> </label></p>
				 </td>
				<tr>
				<tr>
				 						
					  <td><p><label>PO Date </td> 
					  <td><label><input type="text"  disabled="disabled" placeholder="Enter PO Date" name="PO_Date" id="PO_Date"   value="<?php echo $PO_Date;?>"></label>  
					  <font color="red"><?php echo $POdateErr ;?></font></label></p>  
				 </td>
				</tr>
				<tr>
					 <td><p><label>PO Type </td>
					 
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
					<td><select name="PO_Type" id="PO_Type" disabled="disabled" >
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
					 <td> <p><label>PO Amount</td>  
					  <td><label> <input type="text" disabled="disabled" pattern="[0-9]*" title="Please enter only digits." placeholder="Enter PO Amount" name="PO_Amount" type="text" id="PO_Amount"   value="<?php echo $PO_Amount;?>" ></label>  
					  <font color="red"><?php echo $POamtErr;?></font></label></p></td>  
				 </tr>
				
		<!--<button name="additem" id="additem" class="btn btn-default">Add Row</button> -->
		
			</table>
		 	
	</div>
</form> 	
</table>
<script>
$("#form").validate({
	rules:{
		name:{
			required:true,
			minlength:2,
			maxlength:4,
			number:true
		}
	},
	messages:{
		name:{
			required:"this field is required",
			minlength:"need at least 2 char",
			maxlength:"max 4 chars",
			number:"decimal please"
		}
	}
});
</script>

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
		mygrid.loadXML("crs003s/crs003s_Detail.php");//for database control
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
		   $(' #Add').hide();
		} else {
		   $('#additem').attr('disabled', true);   
		   $('#removeitem').attr('disabled', true);   
		   $('#Edit').attr('disabled', true);   
		   $('#Delete').attr('disabled', true); 
		   $('#Edit, #Delete, #Clear').hide();  
		}
		
		});
		
	</script>
	</div>
	
</div></div></div>
<!--<div id="footer">
			<table id="tb2">
				 
					<td id="noti"><strong>Purchase Order</strong> 
					<td id="time" style="font-weight:bold;"> 
				 
			 
		</div>-->

</body>
</html>

