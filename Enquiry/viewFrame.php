<?php
//require(dirname(dirname(__FILE__)) . '../fpdf/fpdf.php');
require(dirname(dirname(__FILE__)) . '../fpdf/mysql_table.php');
require(dirname(dirname(__FILE__)) . '../fpdf/cellfit.php');
include(dirname(dirname(__FILE__)) . "../DatabaseConnect.php");
?>
<html>
 <head>
  <title>Report Preview</title>
 </head>
 <frameset cols="320,*">
   
     <frame name="options" src="<?php echo $_SESSION['OptionsName']?>">
	 <frame name="view" src="<?php echo $_SESSION['WindowName']?>">
   <noframes>
     <i>error to display to those who cannot see frames</i>
   </noframes>
 </frameset>
</html>