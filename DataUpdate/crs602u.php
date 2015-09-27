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
    <legend><strong>Creditor Transaction Purging</strong></legend>
		<table >
			<form id="form" name="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
				<tr>
					<td>Purging Maturity</td>
					<td>
					<label><input type="text" name="Purge_Mat" id="Purge_Mat" placeholder="Enter Purging Maturity"/></label>Days
					</td>
				<tr>
				<tr>
					<td>Last Purging Date</td>
					<td>
					<label><input type="text" name="Purge_Date_L" id="Purge_Date_L" placeholder="Enter Purging Date"/></label>
					</td>
				<tr>
				<tr>
					<td>Current Purging Date</td>
					<td>
					<label><input type="text" name="Purge_Date_C" id="Purge_Date_C" placeholder="Enter Purging Date"/></label>
					</td>
				<tr>
				<tr>
				<td></td>
				<td>Master File</td>
				<td>Transaction File</td>
				</tr>
				<tr>
					<td>Transaction Count</td>
					<td>
					<label><input type="text" name="Trans_Count_Master" id="Trans_Count_Master" placeholder="Enter Transaction Count"/></label>
					</td><td>
					<label><input type="text" name="Trans_Count_Trans" id="Trans_Count_Trans" placeholder="Enter Transaction Count"/></label>
					</td>
				<tr>
				<tr>
					<td>Transaction To Purge</td>
					<td>
					<label><input type="text" name="Trans_Purge_Master" id="Trans_Purge_Master" placeholder="Enter Transaction To Purge"/></label>
					</td><td>
					<label><input type="text" name="Trans_Purge_Trans" id="Trans_Purge_Trans" placeholder="Enter Transaction To Purge"/></label>
					</td>
				<tr>
				<tr><td></td><td><input type="button" name="Close" id="Close" value="Close Month"></td></tr>
					</form> 
					</table>
								  
  </fieldset>
 </body>
</html>
