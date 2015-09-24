<!DOCTYPE HTML>
<?php
include("../DatabaseConnect.php");
include("../Dashboard/crs006s_Report.php");

?>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Creditor Module</title>
		<link rel="shortcut icon" href="img/icon.ico">
		<link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<link href="../bootstrap/css/logo-nav.css" rel="stylesheet">
		<link href="../css/custom.css" rel="stylesheet">


		<script src="../bootstrap/js/jquery.js"></script>
		<script src="../bootstrap/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
		<script src="http://code.highcharts.com/highcharts.js"></script>
		<script src="../js/exporting.js"></script>
		<style type="text/css">${demo.css}</style>
		<script type="text/javascript">
			$(function () {
				$('#container').highcharts({
					chart: {
						type: 'column'
					},
					title: {
						text: 'Journal Chart'
					},
					xAxis: {
						categories: [
							'Jan',
							'Feb',
							'Mar',
							'Apr',
							'May',
							'Jun',
							'Jul',
							'Aug',
							'Sep',
							'Oct',
							'Nov',
							'Dec'
						],
						crosshair: true
					},
					yAxis: {
						min: 0,
						title: {
							text: 'Amount(RM)'
						}
					},
					tooltip: {
						headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
						pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
							'<td style="padding:0"><b>{point.y:.1f} mm</b></td></tr>',
						footerFormat: '</table>',
						shared: true,
						useHTML: true
					},
					plotOptions: {
						column: {
							pointPadding: 0.2,
							borderWidth: 0
						}
					},
					series: [{
						name: 'Journal',
						data: [<?php echo $Journal1 ;?>,<?php echo $Journal2 ;?>,<?php echo $Journal3 ;?>,<?php echo $Journal4 ;?>,<?php echo $Journal5 ;?>,<?php echo $Journal6 ;?>,<?php echo $Journal7 ;?>,<?php echo $Journal8 ;?>,<?php echo $Journal9 ;?>,<?php echo $Journal10 ;?>,<?php echo $Journal11 ;?>,<?php echo $Journal12 ;?>]
					}
					
					
					
					]
				});
			});
		</script>
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
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
	<div class="container">
  <center>
			<a href="../Dashboard/crs003s.php"><button type="button" class="btn btn-default"id = "PODash" style="width: 250px; height: 50px"><b>Purchase Order Chart</b></button></a>
			<a href="../Dashboard/crs004s.php"><button type="button" class="btn btn-default"id = "PODash" style="width: 250px; height: 50px"><b>Invoice Chart</b></button></a>
			<a href="../Dashboard/crs005s.php"><button type="button" class="btn btn-default"id = "PODash" style="width: 250px; height: 50px"><b>Credit Note Chart</b></button></a>
			<a href="../Dashboard/crs006s.php"><button type="button" class="btn btn-default"id = "PODash" style="width: 250px; height: 50px"><b>Journal Chart</b></button></a>
			<a href="../Dashboard/crs008s.php"><button type="button" class="btn btn-default"id = "PODash" style="width: 250px; height: 50px"><b>Payment Chart</b></button></a>
		
		</center>
	</div>
	<br>
<fieldset>
	
					<div class="panel-body">
  <script src="http://code.highcharts.com/highcharts.js"></script>
  <script src="http://code.highcharts.com/modules/exporting.js"></script>
		<div id="container" style="min-width: 400px; height: 400px; margin: 0 auto"></div>
	</div>
</fieldset>

<nav class="navbar  navbar-fixed-bottom" role="navigation">
<a href="../index.php"><button style="width:100%; height:50px" class="btn btn-default">Return To Home Page</button></a>
</nav>
    </body>
</html>