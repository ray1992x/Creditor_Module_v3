<!DOCTYPE html>
<html lang="en">
<?php
include("DatabaseConnect.php");
include("Dashboard/crs003s_PSO.php");
include("Dashboard/crs003s_MSO.php");
include("Dashboard/crs003s_LPO.php");

?>

<head>

    <?php include('header.php') ?>
	
</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">Creditor Module</a>
            </div>
            <!-- /.navbar-header -->

            
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li><a href="index.php"> Dashboard</a></li>
                        <li>
                            <a href="#"></i> Data Update<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li><a href="#">Creditor Master Table</a></li>
                                <li><a href="DataUpdate/crs003s.php">Purchase Order</a></li>
                                <li><a href="DataUpdate/crs004s.php">Invoices</a></li>
                                <li><a href="#">Credit Note</a></li>
                                <li><a href="#">Journal Transfer</a></li>
                                <li><a href="#">Payment</a></li>
								<li><a href="Dataupdate/crs018s.php">Creditor Batch Header</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="#"> Setup <span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="Setup/crs001s.php">Creditor Control Table</a>
                                </li>
                                <li>
                                    <a href="Setup/crs019s.php">Purchase Order Type Table</a>
                                </li>
                                <li>
                                    <a href="Setup/crs020s.php">Maintenance of Creditor Type Table</a>
                                </li>
                                <li>
                                    <a href="Setup/crs021s.php">Creditor Document Control Number</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
						<li>
                            <a href="Enquiry/index.php"> Enquiry </a>
                        </li>
                        
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>
<!------------------------------------------------------------------------------------------------------------>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                 <?php include('Dashboard/crs003s.php') ?>

                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">

                
            </div>
            <!-- /.row -->
            <div class="row">
                
                <!-- /.col-lg-8 -->
                <div class="col-lg-4">
                    
                    
                </div>
                <!-- /.col-lg-4 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->



</body>

</html>
