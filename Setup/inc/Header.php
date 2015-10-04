
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Creditor Module</title>
	<link rel="shortcut icon" href="../img/icon.ico">
    <link rel="stylesheet" type="text/css" href="../Bootstrap/ui-lightness/jquery-ui-1.9.2.custom.css">
	<link href="../Bootstrap/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../Bootstrap/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">
    <link href="../Bootstrap/dist/css/timeline.css" rel="stylesheet">
    <link href="../Bootstrap/dist/css/sb-admin-2.css" rel="stylesheet">
    <link href="../Bootstrap/bower_components/morrisjs/morris.css" rel="stylesheet">
    <link href="../Bootstrap/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    
	<script src="../Bootstrap/bower_components/jquery/dist/jquery.min.js"></script>
	<script src="../Bootstrap/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="../Bootstrap/bower_components/metisMenu/dist/metisMenu.min.js"></script>
    <script src="../Bootstrap/dist/js/sb-admin-2.js"></script>
	<script type="text/javascript" src='../js/jquery-ui-1.9.2.custom.js'></script>
	
	<style type="text/css">




@media (min-width: 1200px) {
  .container {
    width: 1000px;
  }
}
table#tb1 {
	border-collapse: collapse;
}

td {
	padding: 6px;
}

table#tb1 td{
	border:2px solid black;
	align:center;
}

table#tb1 th{
	background-color:gray;
	color:black;
	border:2px solid black;
	padding: 6px;
}

div.table_config{
	float: center;
	background:#FFF;
	height:750px;
	width:100%;
	overflow:scroll;
	margin-left:auto;
	margin-right:auto;
}

div.footer{
	position:fixed;
	bottom:0;
	right:auto;
	left:auto;
	width:100%;
	height:40px;
	background-color:grey;
}



	</style>
			
<script>
function startTime() {
    var today=new Date();
    var h=today.getHours();
    var m=today.getMinutes();
    var s=today.getSeconds();
	var y=today.getYear();
	var mo=today.getMonth();
	var d=today.getDay();
    m = checkTime(m);
    s = checkTime(s);
    document.getElementById('time').innerHTML = h+":"+m+":"+s;
    var t = setTimeout(function(){startTime()},500);
}

function checkTime(i) {
    if (i<10) {i = "0" + i};  // add zero in front of numbers < 10
    return i;
}
</script>

<style>
	div#footer{
	position:fixed;
	bottom:0;
	right:auto;
	left:auto;
	width:100%;
	height:40px;
	background-color:grey;
}

	table#tb2 td{
	border: 5px solid black;
	width:100%;
	background-color:#D8D8D8;
}
</style>
	

