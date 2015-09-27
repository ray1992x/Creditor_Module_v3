<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Creditor Module</title>
	<link rel="shortcut icon" href="img/icon.ico">

    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="bootstrap/css/logo-nav.css" rel="stylesheet">
    <link href="bootstrap/css/sb-admin-2.css" rel="stylesheet">
	
	
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
			</ul>
		</div>
	</div>
</nav>
	<?php
		if(isset($_POST['submit']))
		{
			$database_name = $_POST['database_name'];
			$FileName = 'inc/config.php';
			$File = File($FileName);
			
			$database_name = stripslashes($database_name);
			
	
			$database_name = mysql_real_escape_string($database_name);
		
            $File[11] = "\$dbName = \"$database_name\";?>";
			file_put_contents($FileName, $File);
	
	
			require('inc/config.php');
			$dbConnect = mysql_connect($dbHost, $dbUser, $dbPassword) or die("<p style='text-align:center; color:red;'>Connection failed! Failed to connect to phpMyAdmin. Redirecting back to System Setup Page...</p>".header('Refresh:3; url=http://localhost/CM_Demo/DM_Config.php'));
				
			$sql = "CREATE DATABASE $dbName;"; 
			$result = @mysql_query ($sql, $dbConnect) or die("<p style='text-align:center; color:red;'>Connection failed! Unable to connect to PhpMyAdmin. Redirecting back to System Setup Page...</p>".header('Refresh:3; url=http://localhost/CM_Demo/DM_Config.php'));
			
			$dbSelected = mysql_select_db($dbName, $dbConnect) or die ("<p style='text-align:center; color:red;'>Connection failed! Unable to select the database. Redirecting back to System Setup Page...</p>".header('Refresh:3; url=http://localhost/CM_Demo/DM_Config.php'));
			
			$mysql = "CREATE TABLE IF NOT EXISTS `purchase`(
					`Id` INT(11) NOT NULL AUTO_INCREMENT,
					`POAllocation` VARCHAR(50) NOT NULL,
					`POtemp` VARCHAR(130) NOT NULL UNIQUE,
					`PODate` date NOT NULL,
					`POType` VARCHAR(5) NOT NULL,
					`POAmount` INT(25) NOT NULL,
					PRIMARY KEY (`Id`)
					) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci AUTO_INCREMENT=1;";
					
			$myresult = mysql_query($mysql, $dbConnect) or die ("<p style='text-align:center; color:red;'>Installation failed! Unable to create table ORGANIZATION. Redirecting back to System Setup Page...</p>".header('Refresh:3; url=http://localhost/CM_Demo/DM_Config.php'));
			
			$mysql = "CREATE TABLE IF NOT EXISTS `podetailtable`(
					`id` INT(11) NOT NULL AUTO_INCREMENT,
					`POtemp` VARCHAR(15) NOT NULL,
					`itemid` INT(15) NOT NULL,
					`booktitle` VARCHAR(25) NOT NULL,
					`author` VARCHAR(15) NOT NULL,
					`price` VARCHAR(15) NOT NULL,
					PRIMARY KEY (`Id`)
					) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci AUTO_INCREMENT=1;;";
					
			$myresult = mysql_query($mysql, $dbConnect) or die ("<p style='text-align:center; color:red;'>Installation failed! Unable to create table ADMIN. Redirecting back to System Setup Page...</p>".header('Refresh:3; url=http://localhost/CM_Demo/DM_Config.php'));
			
			$mysql = "CREATE TABLE IF NOT EXISTS `CreditNote`(
			`id` INT(15) NOT NULL AUTO_INCREMENT,
			`CNnumber` VARCHAR(15) NOT NULL UNIQUE,
			`BatchNumber` VARCHAR(15) NOT NULL,
			`SequenceNumber` INT(10) NOT NULL,
			`CreditorCode` VARCHAR(10) NOT NULL,
			`CreditNoteAmount` INT(15) NOT NULL,
			`CreditNoteDate` date NOT NULL,
			`CreditNoteDesc` VARCHAR(50) NOT NULL,
			PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci AUTO_INCREMENT=1;;";

			$myresult = mysql_query($mysql, $dbConnect) or die ("<p style='text-align:center; color:red;'>Installation failed! Unable to create table ADMIN. Redirecting back to System Setup Page...</p>".header('Refresh:3; url=http://localhost/CM_Demo/DM_Config.php'));
			
			$mysql = "CREATE TABLE IF NOT EXISTS `cndetailtable`(
					`id` INT(10) NOT NULL AUTO_INCREMENT,
					`CNnumber` VARCHAR(15) NOT NULL,
					`itemid` INT(10) NOT NULL,
					`GLCode` INT(15) NOT NULL,
					`Narrative` Decimal(65,0)  NOT NULL,
					`Amount` Decimal(65,0) NOT NULL,
					PRIMARY KEY (`id`)
					) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci AUTO_INCREMENT=1;;";

			$myresult = mysql_query($mysql, $dbConnect) or die ("<p style='text-align:center; color:red;'>Installation failed! Unable to create table ADMIN. Redirecting back to System Setup Page...</p>".header('Refresh:3; url=http://localhost/CM_Demo/DM_Config.php'));
			
			$mysql = "CREATE TABLE IF NOT EXISTS `Invoice`(
					`id` INT(10) NOT NULL AUTO_INCREMENT,
					`InvNumber` VARCHAR(15) NOT NULL UNIQUE,
					`BatchNumber` VARCHAR(15) NOT NULL,
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

			$myresult = mysql_query($mysql, $dbConnect) or die ("<p style='text-align:center; color:red;'>Installation failed! Unable to create table ADMIN. Redirecting back to System Setup Page...</p>".header('Refresh:3; url=http://localhost/CM_Demo/DM_Config.php'));

			
			
			$mysql = "CREATE TABLE IF NOT EXISTS `ivdetailtable`(
					`id` INT(10) NOT NULL AUTO_INCREMENT,
					`InvNumber` VARCHAR(15) NOT NULL,
					`itemid` INT(10) NOT NULL,
					`Description` VARCHAR(20) NOT NULL,
					`UOM` Decimal(65,0) NOT NULL,
					`Quantity` Decimal(65,0)  NOT NULL,
					`UnitPrice` Decimal(65,0) NOT NULL,
					`ItemPrice` Decimal(65,0)  NOT NULL,
					PRIMARY KEY (`id`)
					) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci AUTO_INCREMENT=1;;";

			$myresult = mysql_query($mysql, $dbConnect) or die ("<p style='text-align:center; color:red;'>Installation failed! Unable to create table ADMIN. Redirecting back to System Setup Page...</p>".header('Refresh:3; url=http://localhost/CM_Demo/DM_Config.php'));
			
			$mysql = "CREATE TABLE IF NOT EXISTS `BatchHeader`(
					`id` INT(10) NOT NULL AUTO_INCREMENT,
					`BatchType` VARCHAR(15) NOT NULL,
					`BatchNumber` VARCHAR(15) NOT NULL UNIQUE,
					`BatchDate` date NOT NULL,
					`BatchPeriod` Decimal(65,0) NOT NULL,
					`BatchTotal` Decimal(65,0)  NOT NULL,
					`CheckTotal` Decimal(65,0) NOT NULL,
					`Difference` Decimal(65,0) NOT NULL,
					`TransactionCount` Decimal(65,0)  NOT NULL,
					PRIMARY KEY (`id`)
					) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci AUTO_INCREMENT=1;;";

			$myresult = mysql_query($mysql, $dbConnect) or die ("<p style='text-align:center; color:red;'>Installation failed! Unable to create table ADMIN. Redirecting back to System Setup Page...</p>".header('Refresh:3; url=http://localhost/CM_Demo/DM_Config.php'));
			$mysql = "CREATE TABLE IF NOT EXISTS `payment`(
					`id` INT(10) NOT NULL AUTO_INCREMENT,
					`PaymentType` VARCHAR(25) NOT NULL,
					`BankCode` VARCHAR(25) NOT NULL,
					`CreditorCode` VARCHAR(15) NOT NULL,
					`ChequeNumber` Decimal(65,0) NOT NULL,
					`PaymentNo` Decimal(65,0)  NOT NULL UNIQUE,
					`PaymentAmount` Decimal(65,0) NOT NULL,
					`DatePaid` date NOT NULL,
					`BatchNumber` VARCHAR(15)  NOT NULL,
					`SequenceNumber` INT(15) NOT NULL,
					`BatchValue` Decimal(65,0)  NOT NULL,
					PRIMARY KEY (`id`)
					) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci AUTO_INCREMENT=1;;";

			$myresult = mysql_query($mysql, $dbConnect) or die ("<p style='text-align:center; color:red;'>Installation failed! Unable to create table ADMIN. Redirecting back to System Setup Page...</p>".header('Refresh:3; url=http://localhost/CM_Demo/DM_Config.php'));
			
			$mysql = "CREATE TABLE IF NOT EXISTS `paydetailtable`(
					`id` INT(10) NOT NULL AUTO_INCREMENT,
					`CRCode` VARCHAR(15) NOT NULL,
					`No` INT(15) NOT NULL,
					`date` date NOT NULL,
					`period` INT(15) NOT NULL,
					`invoice/creditnote_no` VARCHAR(15) NOT NULL,
					`po_number` VARCHAR(15)  NOT NULL,
					`invoice/creditnote_amount` Decimal(65,0) NOT NULL,
					`paid_period` VARCHAR(25) NOT NULL,
					`payment_amount` Decimal(65,0)  NOT NULL,
					PRIMARY KEY (`id`)
					) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci AUTO_INCREMENT=1;;";
					
			$myresult = mysql_query($mysql, $dbConnect) or die ("<p style='text-align:center; color:red;'>Installation failed! Unable to create table ADMIN. Redirecting back to System Setup Page...</p>".header('Refresh:3; url=http://localhost/CM_Demo/DM_Config.php'));

			$mysql = "CREATE TABLE IF NOT EXISTS `creditctrltable`(
					`id` INT(10) NOT NULL AUTO_INCREMENT,
					`interfacetoGL` VARCHAR(50) NOT NULL,
					`balance` Decimal(65,0) NOT NULL,	
					`period` VARCHAR(25) NOT NULL,
					`batchentry` VARCHAR(50) NOT NULL,					
					`creditGLcode` VARCHAR(15) NOT NULL,
					`bankGLcode` VARCHAR(15) NOT NULL,					
					`bankcode` VARCHAR(50) NOT NULL,				
					`amount` Decimal(65,0) NOT NULL,
					`POprinting` VARCHAR(15) NOT NULL,
					`POtype` VARCHAR(5) NOT NULL,
					PRIMARY KEY (`id`)
					) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci AUTO_INCREMENT=1;";
					
			$myresult = mysql_query($mysql, $dbConnect) or die ("<p style='text-align:center; color:red;'>Installation failed! Unable to create table ADMIN. Redirecting back to System Setup Page...</p>".header('Refresh:3; url=http://localhost/CM_Demo/DM_Config.php'));
			
			$mysql = "CREATE TABLE IF NOT EXISTS `potypetable`(
					`id` INT(10) NOT NULL AUTO_INCREMENT,					
					`POtype` VARCHAR(5) NOT NULL UNIQUE,
					`POdesc` VARCHAR(500) NOT NULL,
					PRIMARY KEY (`id`)
					) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci AUTO_INCREMENT=1;";
					
			$myresult = mysql_query($mysql, $dbConnect) or die ("<p style='text-align:center; color:red;'>Installation failed! Unable to create table ADMIN. Redirecting back to System Setup Page...</p>".header('Refresh:3; url=http://localhost/CM_Demo/DM_Config.php'));
			
			$mysql = "CREATE TABLE IF NOT EXISTS `credittypetable`(
					`id` INT(10) NOT NULL AUTO_INCREMENT,					
					`CRtype` VARCHAR(12) NOT NULL UNIQUE,
					`CRdesc` VARCHAR(500) NOT NULL,
					PRIMARY KEY (`id`)
					) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci AUTO_INCREMENT=1;";
					
			$myresult = mysql_query($mysql, $dbConnect) or die ("<p style='text-align:center; color:red;'>Installation failed! Unable to create table ADMIN. Redirecting back to System Setup Page...</p>".header('Refresh:3; url=http://localhost/CM_Demo/DM_Config.php'));
			
			$mysql = "CREATE TABLE IF NOT EXISTS `docctrlnumtable`(
					`id` INT(10) NOT NULL AUTO_INCREMENT,					
					`doctype` VARCHAR(50) NOT NULL UNIQUE,
					`docprefix` VARCHAR(5) NOT NULL,
					`docnum` INT(50) NOT NULL,
					`docyear` INT(2) NOT NULL,
					`docdesc` VARCHAR(250) NOT NULL,
					PRIMARY KEY (`id`)
					) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci AUTO_INCREMENT=1;";
					
			$myresult = mysql_query($mysql, $dbConnect) or die ("<p style='text-align:center; color:red;'>Installation failed! Unable to create table ADMIN. Redirecting back to System Setup Page...</p>".header('Refresh:3; url=http://localhost/CM_Demo/DM_Config.php'));
			
			$mysql = "CREATE TABLE IF NOT EXISTS `journal`(
			`id` INT(10) NOT NULL AUTO_INCREMENT,
			`JournalNo` VARCHAR(10) NOT NULL UNIQUE,
			`JournalDate` date NOT NULL,
			`JournalAmount` INT(20) NOT NULL,
			`CreditorCode` VARCHAR(15) NOT NULL,
			`JournalRef` VARCHAR(25) NOT NULL,
			`TransType` VARCHAR(10) NOT NULL,
			`RefAmount` INT(10) NOT NULL,
			`BatchNo` VARCHAR(15) NOT NULL,
			`SequenceNo` INT(10) NOT NULL,
			`BatchAmount` INT(10) NOT NULL,
			PRIMARY KEY (`id`)
			)ENGINE=InnoDB DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci AUTO_INCREMENT=1;;";
			
			$myresult = mysql_query($mysql, $dbConnect) or die ("<p style='text-align:center; color:red;'>Installation failed! Unable to create table ADMIN. Redirecting back to System Setup Page...</p>".header('Refresh:3; url=http://localhost/CM_Demo/DM_Config.php'));
			
			$mysql = "CREATE TABLE IF NOT EXISTS `CreditorMaster`(
			`id` INT(15) NOT NULL AUTO_INCREMENT,
			`CreditorCode` VARCHAR(15) NOT NULL,
			`CreditorName` VARCHAR(15) NOT NULL,
			`CreditorType` VARCHAR(15) NOT NULL,
			`ShortName` VARCHAR(15) NOT NULL,
			`CompanyNumber` VARCHAR(15) NOT NULL,
			`CreditPeriod` INT(15) NOT NULL,
			`Remark` VARCHAR(50) NOT NULL,
			`PaymentYTD` INT(10) NOT NULL,
			`LastPaymentDate` DATE NOT NULL,
			`InvoiceYTD` INT(10) NOT NULL,
			`LastInvoiceDate` DATE NOT NULL,
			`CreditorBalance` INT(15) NOT NULL,
			`Address` VARCHAR(20) NOT NULL,
			`ContactName` VARCHAR(15) NOT NULL,
			`Telephone1` INT(12) NOT NULL,
			`Fax` INT(12) NOT NULL,
			`Telephone2` INT(12) NOT NULL,
			`Email` VARCHAR(15) NOT NULL,
			`StartActiveDate` DATE NOT NULL,
			`LastOnHoldDate` DATE NOT NULL,
			PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci AUTO_INCREMENT=1;;";

			$myresult = mysql_query($mysql, $dbConnect) or die ("<p style='text-align:center; color:red;'>Installation failed! Unable to create table ADMIN. Redirecting back to System Setup Page...</p>".header('Refresh:3; url=http://localhost/CM_Demo/DM_Config.php'));			
			
			$mysql = "CREATE TABLE IF NOT EXISTS `J_invoice_details`(
					`id` INT(10) NOT NULL AUTO_INCREMENT,
					`InvNumber` INT(15) NOT NULL UNIQUE,
					`BatchNumber` INT(10) NOT NULL,
					`SequenceNumber` INT(100)  NOT NULL,
					`CreditorCode` INT(11) NOT NULL,
					`InvoiceDescription` VARCHAR(50) NOT NULL,
					`InvoiceTotal` INT(15) NOT NULL,
					`InvoiceDate` date NOT NULL,
					`DatePaymentDue` date NOT NULL,
					`PONumber` INT(10) NOT NULL,
					`POType` VARCHAR(25) NOT NULL,
					`BatchValue` INT(25)  NOT NULL,
					PRIMARY KEY (`id`)
					) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci AUTO_INCREMENT=1;;";

		$myresult = mysql_query($mysql) or die (mysql_error());
		
		$mysql = "CREATE TABLE IF NOT EXISTS `J_invoice_info_details`(
					`id` INT(10) NOT NULL AUTO_INCREMENT,
					`InvNumber` INT(15) NOT NULL,
					`itemid` INT(10) NOT NULL,
					`Description` VARCHAR(15) NOT NULL,
					`UOM` Decimal(65,0) NOT NULL,
					`Quantity` Decimal(65,0)  NOT NULL,
					`UnitPrice` Decimal(65,0) NOT NULL,
					`ItemPrice` Decimal(65,0)  NOT NULL,
					PRIMARY KEY (`id`)
					) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci AUTO_INCREMENT=1;;";
		
		$myresult = mysql_query($mysql) or die (mysql_error());
			//echo "<p style='text-align:center; color:green;'>System Setup Successful! Redirecting to Login Page...</p>".header('Refresh:3; url=http://localhost/finalversion1demo/index.php');
		}
			
			
	?>
	
	<div id="content">
		<br/>
		<h1>Creditor Module System</h1>
		
		<h2>System Setup</h2>
		<form id="form" method="post" action="DB_Config.php">
            <fieldset>
                <legend><strong>&nbsp; Database Details</strong></legend>
					<p><label for="database_name">Database Name :</label>
					<input class="input" type="text" name="database_name" id="database_name" size="35" autofocus required/><span class= 'important'>* This field cannot contain spaces.</span></p>
            </fieldset>
                <p>
                    <input value="Proceed" type ="submit" name="submit" class="submit_button"/>
                    <input value="Clear" type="reset" name="clear" />  
                </p>
        </form>

	</div>
</body>

</html>