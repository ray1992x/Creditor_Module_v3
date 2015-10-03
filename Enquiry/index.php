<!DOCTYPE html>
<?php
include(dirname(dirname(__FILE__)) . "../DatabaseConnect.php");
$windowname = "emptyFrame.php";
?>
<html lang="en">
<?php

?>

<head>

    <?php include('inc/header.php') ?>
    <?php include('inc/dhtmlx.php') ?>
	
</head>

<body>
<?php include('inc/Nav.php') ?>

<?php
	if(isset($_POST['cbl'])){
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){			
			$_SESSION['input']= null;
			$_SESSION['Sdate']= null;
			$_SESSION['Edate']= null;
			$_SESSION['TType']= null;
			$optionsname = "crs506r_options.php";
			
			$_SESSION['OptionsName'] = $optionsname;
			$_SESSION['WindowName'] = $windowname;
			echo "<script>window.open('viewFrame.php','_blank_','menubar=0, width=1152, height=600');</script>";			
		}
	}

	if(isset($_POST['cte'])){
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){			
			$_SESSION['input']= null;
			$_SESSION['Sdate']= null;
			$_SESSION['Edate']= null;
			$_SESSION['TType']= null;
			$optionsname = "crs007s_options.php";
			
			$_SESSION['OptionsName'] = $optionsname;
			$_SESSION['WindowName'] = $windowname;
			echo "<script>window.open('viewFrame.php','_blank_','menubar=0, width=1152, height=600');</script>";			
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
			echo "<script>window.open('viewFrame.php','_blank_','menubar=0, width=1152, height=600');</script>";			
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
			echo "<script>window.open('viewFrame.php','_blank_','menubar=0, width=1152, height=600');</script>";			
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
			echo "<script>window.open('viewFrame.php','_blank_','menubar=0, width=1152, height=600');</script>";			
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
			echo "<script>window.open('viewFrame.php','_blank_','menubar=0, width=1152, height=600');</script>";			
		}
	}		
?>
	
        <div id="page-wrapper">
		<br>
		<br>
			<div class="col-lg-3 col-md-6">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-3">
								<i class="fa fa-print fa-5x"></i>
							</div>
							<div class="col-xs-9 text-right">
								Creditor Transaction Enquiry
							</div>
						</div>
					</div>
					<form name="cteForm" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
					<input type="hidden" name="cte" value="cte">
					<a href="javascript:document.cteForm.submit()">
						<div class="panel-footer">
							<span class="pull-left">View Details</span>
							<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
							<div class="clearfix"></div>
						</div>
					</a>
					</form>
				</div>
				<div class="panel panel-primary">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-3">
								<i class="fa fa-print fa-5x"></i>
							</div>
							<div class="col-xs-9 text-right">
								Cheque Payment Report
							</div>
						</div>
					</div>
					<form name="cprForm" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
					<input type="hidden" name="cpr" value="cpr">
					<a href="javascript:document.cprForm.submit()">
						<div class="panel-footer">
							<span class="pull-left">View Details</span>
							<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
							<div class="clearfix"></div>
						</div>
					</a>
					</form>
				</div>
			</div>
			<div class="col-lg-3 col-md-6">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-3">
								<i class="fa fa-print fa-5x"></i>
							</div>
							<div class="col-xs-9 text-right">
								Creditor Transaction History
							</div>
						</div>
					</div>
					<form name="cthForm" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
					<input type="hidden" name="cth" value="cth">
					<a href="javascript:document.cthForm.submit()">
						<div class="panel-footer">
							<span class="pull-left">View Details</span>
							<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
							<div class="clearfix"></div>
						</div>
					</a>
					</form>
				</div>
				<div class="panel panel-primary">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-3">
								<i class="fa fa-print fa-5x"></i>
							</div>
							<div class="col-xs-9 text-right">
								Purchase Order Master Listing
							</div>
						</div>
					</div>
					<form name="pomlForm" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
					<input type="hidden" name="poml" value="poml">
					<a href="javascript:document.pomlForm.submit()">
						<div class="panel-footer">
							<span class="pull-left">View Details</span>
							<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
							<div class="clearfix"></div>
						</div>
					</a>
					</form>
				</div>
			</div>
			<div class="col-lg-3 col-md-6">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-3">
								<i class="fa fa-print fa-5x"></i>
							</div>
							<div class="col-xs-9 text-right">
								Unfilled Purchase Order
							</div>
						</div>
					</div>
					<form name="upoForm" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
					<input type="hidden" name="upo" value="upo">
					<a href="javascript:document.upoForm.submit()">
						<div class="panel-footer">
							<span class="pull-left">View Details</span>
							<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
							<div class="clearfix"></div>
						</div>
					</a>
					</form>
				</div>
				<div class="panel panel-primary">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-3">
								<i class="fa fa-print fa-5x"></i>
							</div>
							<div class="col-xs-9 text-right">
								Invoice Overdue Report
							</div>
						</div>
					</div>
					<a href="#">
						<div class="panel-footer">
							<span class="pull-left">View Details</span>
							<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
							<div class="clearfix"></div>
						</div>
					</a>
				</div>
			</div>
			<div class="col-lg-3 col-md-6">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-3">
								<i class="fa fa-print fa-5x"></i>
							</div>
							<div class="col-xs-9 text-right">
								Creditor Batch Listing
							</div>
						</div>
					</div>
					<form name="cblForm" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
					<input type="hidden" name="cbl" value="cbl">
					<a href="javascript:document.cblForm.submit()">
						<div class="panel-footer">
							<span class="pull-left">View Details</span>
							<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
							<div class="clearfix"></div>
						</div>
					</a>
					</form>
				</div>
			</div>
        </div>



</body>

</html>
