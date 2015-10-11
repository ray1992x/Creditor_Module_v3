 <!DOCTYPE html>
<?php
include("../DatabaseConnect.php");
$CR_Code = "";
$CR_NoteAmt = "";
$CR_NoteNo = "";
$CR_NoteDate = "";
$CR_NoteDesc = "";
$CR_BatchNo = "";
$CR_SeqNo = "";

$CR_Code_Err = "";
$CR_NoteAmt_Err = "";
$CR_NoteNo_Err = "";
$CR_NoteDate_Err = "";
$CR_NoteDesc_Err = "";
$CR_BatchNo_Err = "";
$CR_SeqNo_Err = "";
$checkseq = 0;
$REF = "";

if(isset($_POST['Confirm']))
{
	if($_SERVER["REQUEST_METHOD"] == "POST") 
	{
		if(empty($_POST["CR_NoteNo"])) 
		{
			$CR_NoteNo_Err = "* Missing Credit Note Number";
		}
		else 
		{
			$CR_NoteNo = strip_tags($_POST['CR_NoteNo']);
		}
		if(empty($_POST["CR_BatchNo"])) 
		{
			$CR_BatchNo_Err = "* Missing Batch Number";
		}
		else 
		{
			$CR_BatchNo = strip_tags($_POST['CR_BatchNo']);
		}
		if(empty($_POST["CR_Code"])) 
		{
			$CR_Code_Err = "* Missing Creditor Code";
		}
		else 
		{
			$CR_Code = strip_tags($_POST['CR_Code']);
		}
		if(empty($_POST["CR_NoteAmt"])) 
		{
			$CR_NoteAmt_Err = "* Missing Missing Credit Note Amount";
		}
		else 
		{
			$CR_NoteAmt = strip_tags($_POST['CR_NoteAmt']);
		}
		if(empty($_POST["CR_NoteDate"])) 
		{
			$CR_NoteDate_Err = "* Missing Credit Note Date";
		}
		else
		{
			$CR_NoteDate = strip_tags($_POST['CR_NoteDate']);
		}
		if(empty($_POST["CR_NoteDesc"])) 
		{
			$CR_NoteDesc_Err = "* Missing Credit Note Description";
		}
		else
		{
			$CR_NoteDesc = strip_tags($_POST['CR_NoteDesc']);
		}
	}
	$query = "Select MAX(SequenceNumber) AS maxseq FROM `CreditNote` WHERE `BatchNumber`='$CR_BatchNo'";
		$records = mysql_query($query) or die (mysql_error());
		while($row=mysql_fetch_array($records)){
			$CR_SeqNo = $row['maxseq'];		
		}$query1 = "Select TransactionCount FROM BatchHeader WHERE BatchNumber='$CR_BatchNo'";
		$records1 = mysql_query($query1) or die (mysql_error());
		while($row1=mysql_fetch_array($records1)){
			$checkseq = $row1['TransactionCount'];
		}
		if($CR_SeqNo > $checkseq){
			$CR_BatchNo_Err = "* Max no. of Credit Note";
			$CR_BatchNo = NULL;
			$CR_SeqNo = NULL;
			$CR_NoteNo = NULL;
			$CR_Code = NULL;
			$CR_NoteAmt =NULL;
			$CR_NoteDate= NULL;
			$CR_NoteDesc = NULL;
		}
		else
		{			
			$CR_SeqNo++;	
			$query1 = "UPDATE BatchHeader SET CheckTotal = '$CR_SeqNo' WHERE BatchNumber = '$CR_BatchNo'";
			$result1 = mysql_query($query1) or die(mysql_error());
	
	if((!empty($_POST["CR_NoteNo"]))&&(!empty($_POST["CR_BatchNo"]))&&(!empty($_POST["CR_Code"]))&&(!empty($_POST["CR_NoteAmt"]))&&(!empty($_POST["CR_NoteDate"]))&&(!empty($_POST["CR_NoteDesc"])))
	{
		$query = "Insert INTO `CreditNote`(`CNnumber`,`BatchNumber`, `SequenceNumber`,`CreditorCode`,`CreditNoteAmount`,`CreditNoteDate`,`CreditNoteDesc` )
		values('$CR_NoteNo','$CR_BatchNo','$CR_SeqNo','$CR_Code','$CR_NoteAmt','$CR_NoteDate','$CR_NoteDesc')";
		$result = mysql_query($query) or die(mysql_error());

		if(!$result)
		{
			$msg = "not Inserted";
		}
		else
		{
			$query = "Insert INTO `cndetailtable` (`CNnumber`) values ('$CR_NoteNo')";
			$result = mysql_query($query) or die(mysql_error()); 

			$_SESSION['CRNoteNo']=$CR_NoteNo;//store $cr number 
			$_SESSION['cnBatch']=$CR_BatchNo;//store $cr number 
			
			if(!$result)
			{
				$msg = "not Inserted";
			}
			else{
				$query="SELECT * FROM `CreditNote` WHERE `CNnumber`='$CR_NoteNo'";
				$records = mysql_query($query) or die(mysql_error());	

				while($row=mysql_fetch_array($records))
				{
					$CR_NoteNo = $row['CNnumber'];
					$CR_BatchNo = $row['BatchNumber'];
					$CR_SeqNo = $row['SequenceNumber'];
					$CR_Code = $row['CreditorCode'];
					$CR_NoteAmt = $row['CreditNoteAmount'];
					$CR_NoteDate = $row['CreditNoteDate'];
					$CR_NoteDesc = $row['CreditNoteDesc'];
				}
			}
		}
	}
		}
}
else if(isset($_POST['aa']))
{
	$CR_BatchNo = null;//strip_tags($_POST['CR_BatchNo']);
	$CR_SeqNo =null;// strip_tags($_POST['CR_SeqNo']);
	$CR_NoteNo = strip_tags($_POST['CR_NoteNo']);
	$CR_Code = null;
	//$CR_NoteAmt = null;
	$CR_NoteDate = null;
	$CR_NoteDesc = null;
	$_SESSION['CRNoteNo']=$CR_NoteNo;
	
	$query="SELECT * FROM `CreditNote` WHERE `CNnumber`='$CR_NoteNo'"; //retrieve
	$records = mysql_query($query) or die(mysql_error());	
	while($row=mysql_fetch_array($records))
	{
		$CR_NoteAmt = $row['CreditNoteAmount'];
	}
	//$_SESSION['amount']=$CR_NoteAmt;  
}

else if(isset($_POST['CView']))
{
	if(empty($_POST["CR_NoteNo"])) 
		{
			$CR_NoteNo_Err = "* Missing Credit Note Number";
		}
		else 
		{
			$CR_NoteNo = strip_tags($_POST['CR_NoteNo']);
		}
	
	if(!empty($_POST["CR_NoteNo"])){
		$CR_NoteNo = strip_tags($_POST['CR_NoteNo']);
		$_SESSION['CRNoteNo']=$CR_NoteNo;
		$query="SELECT * FROM `CreditNote` WHERE `CNnumber`='$CR_NoteNo'";
		$records = mysql_query($query) or die(mysql_error());	

		while($row=mysql_fetch_array($records))
		{
			$CR_NoteNo = $row['CNnumber'];
			$CR_BatchNo = $row['BatchNumber'];
			$CR_SeqNo = $row['SequenceNumber'];
			$CR_Code = $row['CreditorCode'];
			$CR_NoteAmt = $row['CreditNoteAmount'];
			$CR_NoteDate = $row['CreditNoteDate'];
			$CR_NoteDesc = $row['CreditNoteDesc'];
		}
	}
}	
else if(isset($_POST['Update']))
{
	if ($_SERVER["REQUEST_METHOD"] == "POST") 
	{
		if(empty($_POST["CR_NoteNo"])) 
		{
			$CR_NoteNo_Err = "* Missing Credit Note Number";
		}
		else 
		{
			$CR_NoteNo = strip_tags($_POST['CR_NoteNo']);
		}
		if(empty($_POST["CR_BatchNo"])) 
		{
			$CR_BatchNo_Err = "* Missing Batch Number";
		}
		else 
		{
			$CR_BatchNo = strip_tags($_POST['CR_BatchNo']);
		}
		if(empty($_POST["CR_Code"])) 
		{
			$CR_Code_Err = "* Missing Creditor Code";
		}
		else 
		{
			$CR_Code = strip_tags($_POST['CR_Code']);
		}
		if(empty($_POST["CR_NoteAmt"])) 
		{
			$CR_NoteAmt_Err = "* Missing Missing Credit Note Amount";
		}
		else 
		{
			$CR_NoteAmt = strip_tags($_POST['CR_NoteAmt']);
		}
		if(empty($_POST["CR_NoteDate"])) 
		{
			$CR_NoteDate_Err = "* Missing Credit Note Date";
		}
		else
		{
			$CR_NoteDate = strip_tags($_POST['CR_NoteDate']);
		}
		if(empty($_POST["CR_NoteDesc"])) 
		{
			$CR_NoteDesc_Err = "* Missing Credit Note Description";
		}
		else
		{
			$CR_NoteDesc = strip_tags($_POST['CR_NoteDesc']);
		}
		
	}
	if((!empty($_POST["CR_NoteNo"]))&&(!empty($_POST["CR_BatchNo"]))&&(!empty($_POST["CR_Code"]))&&(!empty($_POST["CR_NoteAmt"]))&&(!empty($_POST["CR_NoteDate"]))&&(!empty($_POST["CR_NoteDesc"])))
	{
		$query = "UPDATE `CreditNote` SET `SequenceNumber`=$CR_SeqNo, `CreditorCode`='$CR_Code', `CreditNoteAmount`= $CR_NoteAmt , `CreditNoteDate`= $CR_NoteDate, `CreditNoteDesc`='$CR_NoteDesc'   where `CNnumber`= '$CR_NoteNo'";
		$result = mysql_query($query) or die(mysql_error());

		if(!$result)
		{
			$msg = "not Inserted";
		}
		else
		{
			$_SESSION['CRNoteNo']=$CR_NoteNo;
			//$_SESSION['amount']=$CR_NoteAmt;
			$CR_BatchNo = NULL;
			$CR_SeqNo = NULL;
			$CR_NoteNo = NULL;
			$CR_Code = NULL;
			$CR_NoteAmt =NULL;
			$CR_NoteDate = NULL;
			$CR_NoteDesc = NULL;
		}
	}
}	
else if(isset($_POST['additem']))
{
	$CR_NoteNo = strip_tags($_POST['CR_NoteNo']);
	$_SESSION['CRNoteNo']=$CR_NoteNo;
	if($_SERVER["REQUEST_METHOD"] == "POST") 
	{
		$REF = strip_tags($_POST['REF']);
	}
	if((!empty($_POST["REF"])))
	{
		$query = "INSERT INTO cndetailtable (CNnumber,ReferenceNumber) values('$CR_NoteNo','$REF')" ;
			$result = mysql_query($query) or die(mysql_error());
	}
}
else if(isset($_POST['REFRESH']))
{
	header("Location: Creditnoterefresh.php");
	$_SESSION['CRNoteNo']=NULL;
	//$_SESSION['amount']=NULL;
	$CR_BatchNo = NULL;
	$CR_SeqNo = NULL;
	$CR_NoteNo = NULL;
	$CR_Code = NULL;
	$CR_NoteAmt =NULL;
	$CR_NoteDate= NULL;
	$CR_NoteDesc = NULL;
}
else
{
	$_SESSION['CRNoteNo']=NULL;
	//$_SESSION['amount']=NULL;
	$CR_BatchNo = NULL;
	$CR_SeqNo = NULL;
	$CR_NoteNo = NULL;
	$CR_Code = NULL;
	$CR_NoteAmt =NULL;
	$CR_NoteDate= NULL;
	$CR_NoteDesc = NULL;
}
?>
<html>
<head>

	
    <?php include('inc/header.php') ?>
    <?php include('inc/dhtmlx.php') ?>
	<script src="../js/crs005s.js"></script>
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
			$('#CR_Code,#CR_NoteNo,#CR_BatchNo,#CR_SeqNo,#CR_NoteAmt,#CR_NoteDate,#CR_NoteDesc').prop("disabled", false);
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
<!--<table>
	<td><label><a href="../DataUpdate.php"><button class="btn btn-default"><span class="glyphicon glyphicon-chevron-left"></span></button></a></label>
	<label><a href="crs005s.php"><button class="btn btn-default"><span class="glyphicon glyphicon-refresh"></span> Refresh</button></a></label>
	<label><a href="crs005s_Print.php" target="_blank"><button name="Print"  value="Print"  class="btn btn-default" /><span class="glyphicon glyphicon-print"> Print</button></a></label></td>
</table>-->
		
<form id="form" name="form" method="post" action="">
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
<fieldset>
<legend><strong>Credit Note</strong></legend>

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

		<td height="10"></td>
		<tr>			
		<td>Creditor Code</td>
		<td><label><input disabled="disabled" type="text" pattern="[C][0-9]{3,3}" title="{C}{3-digit code} without parentheses" placeholder="Enter Creditor Code" name="CR_Code" id="CR_Code" value="<?php echo "".$_SESSION['CurrCred'].""; ?>"></label></td>
		<td><font color="red"><?php echo $CR_Code_Err;?></font></td>
		<td><button id="searchCred" type="button"><img src="../img/search.icon.png"></button></td>
			</tr>
		<tr>
					
		<td>Credit Note No</td>
		<td><label><input disabled="disabled" type="text"  placeholder="Enter Credit Note No" name="CR_NoteNo" id="CR_NoteNo" value="<?php echo $CR_NoteNo;?>"></label></td>
		<td><font color="red"><?php echo $CR_NoteNo_Err;?></font></td>
		</tr>
		
		<tr>
		<td>Batch Number</td>
		<td><label><input disabled="disabled" type="text" pattern="[C][B][0-9]{9,9}" title="{CB}{9-digit no.} without parentheses" placeholder="Enter Batch Number" name="CR_BatchNo" id="CR_BatchNo" value="<?php echo $CR_BatchNo;?>" ></label></td> 
		<td><font color="red"><?php echo $CR_BatchNo_Err;?></font></td>
		</tr>
		
		<tr>
		<td>Sequence Number </td>
		<td><label><input  readonly STYLE="background:#ffffe0; color:#8b0000;"type="text"  name="CR_SeqNo" id="CR_SeqNo" value="<?php echo $CR_SeqNo;?>" ></label></td> 					
		<td><font color="red"><?php echo $CR_SeqNo_Err;?></font></td>
		</tr>
		
		<tr>
		<td>Credit Note Amount</td>
		<td><label><input disabled="disabled" type="text" pattern="[0-9]*" title="Please enter only digits." placeholder="Enter Credit Note Amount" name="CR_NoteAmt" id="CR_NoteAmt" value="<?php echo $CR_NoteAmt;?>" ></label></td>
		<td><font color="red"><?php echo $CR_NoteAmt_Err;?></font></td>
		</tr>
		
		<tr>
		<td>Credit Note Date</td>
		<td><label><input disabled="disabled" type="text" placeholder="Enter Credit Note Date" name="CR_NoteDate" type="text" id="CR_NoteDate" value="<?php echo $CR_NoteDate;?>" ></label></td>
		<td><font color="red"><?php echo $CR_NoteDate_Err;?></font></td>
		</tr>
		
		<tr>
		<td>Credit Note Description</td>
		<td><label><input disabled="disabled" type="text" placeholder="Enter Credit Note Description" name="CR_NoteDesc" type="text" id="CR_NoteDesc" value="<?php echo $CR_NoteDesc;?>" ></label></td>
		<td><font color="red"><?php echo $CR_NoteDesc_Err;?></font></td>
		</tr>
		
		
		
	</table>
</div>

<fieldset>

	<legend><strong>Item</strong></legend> 

	<div class="container">
		<table> 
			<tr>
			<td>Credit Note REF No.</td>
			<td><label><select name="REF" id="REF"  >
				<option >Select Reference Number</option>
				<?php

				$query = "SELECT InvNumber FROM invoice WHERE CreditorCode='$CR_Code'";
				$records = mysql_query($query) or die(mysql_error());	
				while($row=mysql_fetch_array($records)){
				echo '<option value="' . $row['InvNumber'] . '"';
				if ($REF==$row['InvNumber']){echo 'selected';}
				echo '>' . $row['InvNumber'] . '</option>';
				}
				?>

			</select></label></td>
			</tr>
		</table>
		<div id="gridbox" style="width:700px;height:400px;"></div> 
		<script>
		function calculateFooterValues(stage){
		/* if(stage && stage!=2)
		return true; */
		var nrQ = document.getElementById("nr_q");
		nrQ.innerHTML = sumColumn(4)
		return true;
		}
		function sumColumn(ind){
		var out = 0;
		for(var i=0;i<mygrid1.getRowsNum();i++){
		out+= parseFloat(mygrid1.cells2(i,ind).getValue())
		}
		return out;
		}

		mygrid1 = new dhtmlXGridObject('gridbox');// video for this http://www.youtube.com/watch?v=hPBwsqfyi0s
		mygrid1.setImagePath('codebase/imgs/'); //the path to images required by grid         
		mygrid1.setHeader("aa,Item ID,CreditNote REF No,Narrative,Amount");//the headers of columns 
		mygrid1.setInitWidths("150,80,150,235,80")   //the widths of columns     
		mygrid1.setColAlign("left,right,right,right") //the alignment of columns          
		mygrid1.setColTypes("ed,cntr,ed,ed,ed");                //the types of columns          
		mygrid1.setColSorting("connector,connector,connector,connector,connector");          //the sorting types 
		mygrid1.setSkin("dhx_web");	
		mygrid1.attachEvent("onEditCell",calculateFooterValues)		//note
		mygrid1.setSkin("dhx_web");				//set the layout of grid 
		mygrid1.init();      //finishes initialization  path to images required by grid 
		mygrid1.attachFooter("Total amount,<div id='nr_q'>0</div>",["text-align:left;"]); //note
		mygrid1.enableMathEditing(true);  
		mygrid1.enableSmartRendering(true);
		mygrid1.loadXML("CNdetail.php");//for database control
		var dp1=new dataProcessor("CNdetail.php");
		dp1.init(mygrid1); 
		mygrid1.setColumnHidden(0,true); 

		var i="<?php echo $_SESSION['CRNoteNo']; ?>";

		function addRow(){
		var newId1= (new Date()).valueOf()
		mygrid1.addRow(newId1,[i,,,,,],mygrid1.getRowsNum())
		mygrid1.selectRow(mygrid1.getRowIndex(newId1),false,false,true);
		}
		function removeRow(){
		var selId = mygrid1.getSelectedId()
		mygrid1.deleteRow(selId);
		}	

		</script>  
		<button name="additem" id="additem" class="btn btn-default"> Add Item</button>
		<button onclick="removeRow()"class="btn btn-default"id="removeitem">Remove Row</button>
	</div>
</fieldset>
</fieldset>
</form> 
</div>
</div>
</div>
<script type="text/javascript">

	$(':text').ready(function() {
	if($('#CR_NoteNo').val() != "" ) {
	   $('#additem').removeAttr('disabled');
	   $('#removeitem').removeAttr('disabled');
	   $('#Edit').removeAttr('disabled');
	   $('#Delete').removeAttr('disabled');
	   $('#REF').removeAttr('disabled');
	} else {
	   $('#additem').attr('disabled', true);   
	   $('#REF').attr('disabled', true);   
	   $('#removeitem').attr('disabled', true);   
	   $('#Edit').attr('disabled', true);   
	   $('#Delete').attr('disabled', true);   
	}
	});
</script>
<!--<div id="footer">
			<table id="tb2">
				<tr>
					<td id="noti"><strong>Credit Note</strong></td>
					<td id="time" style="font-weight:bold;"></td>
				</tr>
			</table>
		</div>-->
</body>
</html>

