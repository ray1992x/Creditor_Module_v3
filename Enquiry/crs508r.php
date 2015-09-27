<!DOCTYPE html>
<html>
<head>
    
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Creditor Module</title>
	<link rel="shortcut icon" href="../img/icon.ico">

    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../bootstrap/css/logo-nav.css" rel="stylesheet">
	
    <script src="../bootstrap/js/jquery.js"></script>
    <script src="../bootstrap/js/bootstrap.min.js"></script>
	
</head>
<body>

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
<legend><strong>Creditor Transaction Interfaced to GL</strong></legend>
	<table>
	<td><label><a href="../Enquiry.php"><button class="btn btn-default"><span class="glyphicon glyphicon-chevron-left"></span></button></a></label>
			<label><a href="crs508r.php"><button class="btn btn-default"><span class="glyphicon glyphicon-refresh"></span> Refresh</button></a></label></td>
	</table>
	<table>
		<form id="form" name="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		<tr>
		</tr>
			<!--<tr>
				<td>Print Destination</td>
				<td><p>
				<label><input type="radio" name="CTI_PrintDest" id="CTI_PrintDest" value="Screen" />Screen</label>
				<label><input type="radio" name="CTI_PrintDest" id="CTI_PrintDest" value="Printer"/>Printer</label>
				</p></td>
			</tr>-->
			<tr>
				<td style="vertical-align:top">Transaction Date</td>
				<td>
				<label> From<input type="date" name="CTI_Date_From" id="CTI_Date_From" /> To <input type="date" name="CTI_Date_To" id="CTI_Date_To" /></label>
				</td>	
			</tr>
			<tr><td><label><button name="Print"  value="Print"  class="btn btn-default" /><span class="glyphicon glyphicon-print"> Print</button></label></td></tr>
		</form> 
	</table>
							  
</fieldset>
 
</body>
</html>
