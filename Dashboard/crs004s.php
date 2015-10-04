<!DOCTYPE HTML>
<?php
//include("../DatabaseConnect.php");
//include("../Dashboard/crs004s_Report.php");

?>

<html>
    <head>
		<script type="text/javascript">
			$(function () {
				$('#container').highcharts({
					chart: {
						type: 'line'
					},
					title: {
						text: 'Invoice Chart'
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
							'<td style="padding:0"><b>RM {point.y:.1f}</b></td></tr>',
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
						name: 'Invoice',
						data: [<?php echo $Invoice1 ;?>,<?php echo $Invoice2 ;?>,<?php echo $Invoice3 ;?>,<?php echo $Invoice4 ;?>,<?php echo $Invoice5 ;?>,<?php echo $Invoice6 ;?>,<?php echo $Invoice7 ;?>,<?php echo $Invoice8 ;?>,<?php echo $Invoice9 ;?>,<?php echo $Invoice10 ;?>,<?php echo $Invoice11 ;?>,<?php echo $Invoice12 ;?>]
					}
					
					
					
					]
				});
			});
		</script>
    </head>
    <body>

<fieldset>
	
					<div class="panel-body">
  <script src="http://code.highcharts.com/highcharts.js"></script>
  <script src="http://code.highcharts.com/modules/exporting.js"></script>
		<div id="container" style="min-width: 400px; height: 400px; margin: 0 auto"></div>
	</div>
</fieldset>

<nav class="navbar  navbar-fixed-bottom" role="navigation">
</nav>
    </body>
</html>