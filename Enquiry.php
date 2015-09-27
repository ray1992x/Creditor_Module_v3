<!DOCTYPE html>
<?php
include(dirname(__FILE__) . "../DatabaseConnect.php");
$windowname = "emptyFrame.php";
?>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Creditor Module</title>
	<link rel="shortcut icon" href="img/icon.ico">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="bootstrap/css/logo-nav.css" rel="stylesheet">
    <link href="css/custom.css" rel="stylesheet">

</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="index.php">Home</a>
                    </li>
                    <li>
                        <a href="#">Help</a>
                    </li>
                    <li>
                        <a href="#">About</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

<?php
	if(isset($_POST['cte'])){
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){			
			$_SESSION['input']= null;
			$_SESSION['Sdate']= null;
			$_SESSION['Edate']= null;
			$_SESSION['TType']= null;
			$optionsname = "crs007s_options.php";
			
			$_SESSION['OptionsName'] = $optionsname;
			$_SESSION['WindowName'] = $windowname;
			echo "<script>window.open('Enquiry/viewFrame.php','_blank_','menubar=0, width=1152, height=600');</script>";			
		}
	}

	if(isset($_POST['upo'])){
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){			
			$_SESSION['AllCreditors']= null;
			$_SESSION['CR_Code_First']= null;
			$_SESSION['CR_Code_Last']= null;
			$_SESSION['CML_Order']= null;
			$optionsname = "crs504r_options.php";
			
			$_SESSION['OptionsName'] = $optionsname;
			$_SESSION['WindowName'] = $windowname;
			echo "<script>window.open('Enquiry/viewFrame.php','_blank_','menubar=0, width=1152, height=600');</script>";			
		}
	}

	if(isset($_POST['cth'])){
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){			
			$_SESSION['CML_Range']= null;
			$_SESSION['CML_Zero']= null;
			$_SESSION['CML_Code_First']= null;
			$_SESSION['CML_Code_Last']= null;
			$optionsname = "crs502r_options.php";
			
			$_SESSION['OptionsName'] = $optionsname;
			$_SESSION['WindowName'] = $windowname;
			echo "<script>window.open('Enquiry/viewFrame.php','_blank_','menubar=0, width=1152, height=600');</script>";			
		}
	}
	
	if(isset($_POST['poml'])){
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){			
			$_SESSION['PO_PrintOp']= null;
			$_SESSION['CR_Code']= null;
			$_SESSION['PO_From']= null;
			$_SESSION['PO_To']= null;
			$optionsname = "crs503r_options.php";
			
			$_SESSION['OptionsName'] = $optionsname;
			$_SESSION['WindowName'] = $windowname;
			echo "<script>window.open('Enquiry/viewFrame.php','_blank_','menubar=0, width=1152, height=600');</script>";			
		}
	}

	if(isset($_POST['cpr'])){
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){			
			$_SESSION['ChequePrint'] = null;
			$_SESSION['PaymentDateFrom'] = null;
			$_SESSION['PaymentDateTo'] = null;
			$_SESSION['FiscalPeriodM'] = null;
			$_SESSION['FiscalPeriodY'] = null;
			$_SESSION['GroupBy'] = null;
			$_SESSION['IncludeSummary'] = null;
			
			$optionsname = "crs022s_options.php";
			
			$_SESSION['OptionsName'] = $optionsname;
			$_SESSION['WindowName'] = $windowname;
			echo "<script>window.open('Enquiry/viewFrame.php','_blank_','menubar=0, width=1152, height=600');</script>";			
		}
	}		
?>
	
    <!-- Page Content -->
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
				<center><img src="img/logo.gif" width="100" height="100"></center>
                <center><h1>Enquiry</h1></center>
				<form id="form" name="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
				<center><button name="cte" value="cte" class="btn btn-default"id = "datatype" style="width: 300px; height: 50px"><b>Creditor Transaction Enquiry</b></button>
						<button name="cpr" value="cpr" class="btn btn-default"id = "datatype" style="width: 300px; height: 50px"><b>Cheque Payment Report</b></button></center>
				<center><button name="cth" value="cth" class="btn btn-default"id = "datatype" style="width: 300px; height: 50px"><b>Creditor Transaction History</b></button>
						<button name="poml" value="poml" class="btn btn-default"id = "datatype" style="width: 300px; height: 50px"><b>Purchase Order Master Listing</b></button></center>
				<center><button name = "upo" value="upo" class="btn btn-default"id = "datatype" style="width: 300px; height: 50px"><b>Unfilled Purchase Order</b></button>
						<a href="Enquiry/crs505r.php"><button type="button" class="btn btn-default"id = "datatype" style="width: 300px; height: 50px"><b>Invoice Overdue Report</b></button></a></center>
				<center><a href="Enquiry/crs506r.php"><button type="button" class="btn btn-default"id = "datatype" style="width: 300px; height: 50px"><b>Creditor Batch Listing</b></button></a>
				
						<a href="index.php"><button type="button" class="btn btn-default"id = "datatype" style="width: 300px; height: 50px"><b>Back</b></button></a></center>
				</form>
				<p></p>
			</div>
        </div>
    </div>
	
    <!-- /.container -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

</html>
