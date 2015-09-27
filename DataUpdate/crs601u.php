<!DOCTYPE html>
<html>
<head>
  
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" 
    <title>Creditor Module</title>
	<link rel="shortcut icon" href="img/icon.ico">
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
					<a href="index.php">Home</a>
				</li>
				<li>
					<a href="Help.php">Help</a>
				</li>
				<li>
					<a href="About.php">About</a>
				</li>
			</ul>
		</div>
	</div>
</nav>
	
<fieldset>
<legend><strong>Creditor Transaction Enquiry</strong></legend>
	<table>
		<form id="form" name="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			<tr>
				<td>Current Period</td>
				<td>
				<label><input type="text" name="CP1" id="CP1" />/<input type="text" name="CP2" id="CP2" /></label>
				</td>
			<tr>
			<tr>
				<td>Next Period</td>
				<td>
				<label><input type="text" name="NP1" id="NP1" />/<input type="text" name="NP2" id="NP2" /></label>
				</td>
			<tr>
			<tr><td><input type="button" name="Close" id="Close" value="Close Month"></td></tr>
				</form> 
				</table>
							  
</fieldset>

</body>
</html>
