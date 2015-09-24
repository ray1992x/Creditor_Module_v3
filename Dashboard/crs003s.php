<!DOCTYPE HTML>
<?php
/*
include("../DatabaseConnect.php");
include("../Dashboard/crs003s_PSO.php");
include("../Dashboard/crs003s_MSO.php");
include("../Dashboard/crs003s_LPO.php");*/

?>

<html>
    <head>
        <?php /*include('../header.php') */?>


		<script type="text/javascript">
			$(function () {
				$('#container').highcharts({
					chart: {
						type: 'column'
					},
					title: {
						text: 'Purchase Order Chart'
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
							'<td style="padding:0"><b>RM {point.y:.1f} </b></td></tr>',
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
						name: 'PSO',
						data: [<?php echo $PSO1 ;?>,<?php echo $PSO2 ;?>,<?php echo $PSO3 ;?>,<?php echo $PSO4 ;?>,<?php echo $PSO5 ;?>,<?php echo $PSO6 ;?>,<?php echo $PSO7 ;?>,<?php echo $PSO8 ;?>,<?php echo $PSO9 ;?>,<?php echo $PSO10 ;?>,<?php echo $PSO11 ;?>,<?php echo $PSO12 ;?>]
					}, {
						name: 'MSO',
						data: [<?php echo $MSO1 ;?>,<?php echo $MSO2 ;?>,<?php echo $MSO3 ;?>,<?php echo $MSO4 ;?>,<?php echo $MSO5 ;?>,<?php echo $MSO6 ;?>,<?php echo $MSO7 ;?>,<?php echo $MSO8 ;?>,<?php echo $MSO9 ;?>,<?php echo $MSO10 ;?>,<?php echo $MSO11 ;?>,<?php echo $MSO12 ;?>]
					}, {
						name: 'PSO',
						data: [<?php echo $LPO1 ;?>,<?php echo $LPO2 ;?>,<?php echo $LPO3 ;?>,<?php echo $LPO4 ;?>,<?php echo $LPO5 ;?>,<?php echo $LPO6 ;?>,<?php echo $LPO7 ;?>,<?php echo $LPO8 ;?>,<?php echo $LPO9 ;?>,<?php echo $LPO10 ;?>,<?php echo $LPO11 ;?>,<?php echo $LPO12 ;?>]
					},
					
					
					
					]
				});
			});
		</script>
		

    </head>
    <body>
	
	<div class="container">
   <center>
			
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
</nav>

</html>