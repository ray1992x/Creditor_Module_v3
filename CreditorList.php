<?php
include("databaseconnect.php");
?>
<!DOCTYPE html>
<html>
<head>
<title>List Of Creditors</title>

<link rel="shortcut icon" href="../img/icon.ico">
<link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="../bootstrap/css/logo-nav.css" rel="stylesheet">

<!--highlight the table row selected-->
<script>
$(document).ready(function () {
    $('.record_table tr').click(function (event) {
        if (event.target.type !== 'radio') {
            $(':radio', this).trigger('click');
        }
    });

    $("input[type='radio']").change(function (e) {
        if ($(this).is(":checked")) {
            $(this).closest('tr').addClass("highlight_row");
        } else {
            $(this).closest('tr').removeClass("highlight_row");
        }
    });
});

</script>

<script language="javascript" type="text/javascript"> 
function windowClose() { 
window.open('','_parent',''); 
window.close();
} 
</script>

<style>
.record_table {
    width: 100%;
    border-collapse: collapse;
}
.record_table tr:hover {
    background: #eee;
}
.record_table td th{
    border: 1px solid black;
}
.highlight_row {
    background: #eee;
}
td{
	border:2px solid black;
}

th{
	background-color:gray;
}
table {
	width:100%;
	align:center;
}
</style>
</head>
<body>

<form method="post">
<table class="record_table">

	<tr>
		<th></th>
		<th>No.</th>
		<th>Creditor Code</th>
		<th>Description</th>
	</tr>
	<tr>
		<td><input type="radio" name="check" id="check" value="C001"/></td>
		<td>1</td>
		<td>C001</td>
		<td>Courth Mammoth</td>
	</tr>
	<tr>
		<td><input type="radio" name="check" id="check" value="C002"/></td>
		<td>2</td>
		<td>C002</td>
		<td>PC Image</td>
	</tr>
	<tr>
		<td><input type="radio" name="check" id="check" value="C003"/></td>
		<td>3</td>
		<td>C003</td>
		<td>MPH</td>
	</tr>
	<tr>
		<td><input type="radio" name="check" id="check" value="C004"/></td>
		<td>4</td>
		<td>C004</td>
		<td>Stark Industries</td>
	</tr>

</table>

<input type="submit" name="confirm" id="confirm" value="OK">
<!--<input type="submit" value="Cancel" onclick="windowClose();"></form>-->
<a href="DataUpdate/crs006s.php">back</a>


<?php
if(isset($_POST['confirm']) && isset($_POST['check']))
{
	$data1 = $_POST['check'];
	$_SESSION['CurrCred']=$data1;
	echo "".$_SESSION['CurrCred']."";
	
	//echo "<script>window.close();</script>";
}
else if(isset($_POST['confirm']) && !isset($_POST['check']))
	echo "Please select a creditor.";


?>

</body>
</html>