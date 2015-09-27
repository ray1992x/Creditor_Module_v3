<!DOCTYPE HTML>
<?php

$PaymentReport1 = " SELECT SUM(PaymentAmount) AS GrandTotal1 FROM payment WHERE MONTH(DatePaid) = 1 ";
$PaymentReport2 = " SELECT SUM(PaymentAmount) AS GrandTotal2 FROM payment WHERE MONTH(DatePaid) = 2 ";
$PaymentReport3 = " SELECT SUM(PaymentAmount) AS GrandTotal3 FROM payment WHERE MONTH(DatePaid) = 3 ";
$PaymentReport4 = " SELECT SUM(PaymentAmount) AS GrandTotal4 FROM payment WHERE MONTH(DatePaid) = 4 ";
$PaymentReport5 = " SELECT SUM(PaymentAmount) AS GrandTotal5 FROM payment WHERE MONTH(DatePaid) = 5 ";
$PaymentReport6 = " SELECT SUM(PaymentAmount) AS GrandTotal6 FROM payment WHERE MONTH(DatePaid) = 6 ";
$PaymentReport7 = " SELECT SUM(PaymentAmount) AS GrandTotal7 FROM payment WHERE MONTH(DatePaid) = 7 ";
$PaymentReport8 = " SELECT SUM(PaymentAmount) AS GrandTotal8 FROM payment WHERE MONTH(DatePaid) = 8 ";
$PaymentReport9 = " SELECT SUM(PaymentAmount) AS GrandTotal9 FROM payment WHERE MONTH(DatePaid) = 9 ";
$PaymentReport10 = " SELECT SUM(PaymentAmount) AS GrandTotal10 FROM payment WHERE MONTH(DatePaid) = 10 ";
$PaymentReport11 = " SELECT SUM(PaymentAmount) AS GrandTotal11 FROM payment WHERE MONTH(DatePaid) = 11 ";
$PaymentReport12 = " SELECT SUM(PaymentAmount) AS GrandTotal12 FROM payment WHERE MONTH(DatePaid) = 12 ";

$PaymentResult1 = mysql_query($PaymentReport1);
$PaymentResult2 = mysql_query($PaymentReport2);
$PaymentResult3 = mysql_query($PaymentReport3);
$PaymentResult4 = mysql_query($PaymentReport4);
$PaymentResult5 = mysql_query($PaymentReport5);
$PaymentResult6 = mysql_query($PaymentReport6);
$PaymentResult7 = mysql_query($PaymentReport7);
$PaymentResult8 = mysql_query($PaymentReport8);
$PaymentResult9 = mysql_query($PaymentReport9);
$PaymentResult10 = mysql_query($PaymentReport10);
$PaymentResult11 = mysql_query($PaymentReport11);
$PaymentResult12 = mysql_query($PaymentReport12);


while($row1=mysql_fetch_array($PaymentResult1))
{
	if($row1['GrandTotal1'] == NULL)
	{
		$Payment1 = 0;
	}
	else
	{
	$Payment1 = $row1['GrandTotal1'];
	}
}
while($row2=mysql_fetch_array($PaymentResult2))
{
	if($row2['GrandTotal2'] == NULL)
	{
		$Payment2 = 0;
	}
	else
	{
	$Payment2 = $row2['GrandTotal2'];
	}
}
while($row3=mysql_fetch_array($PaymentResult3))
{
	if($row3['GrandTotal3'] == NULL)
	{
		$Payment3 = 0;
	}
	else
	{
	$Payment3 = $row3['GrandTotal3'];
	}
}
while($row4=mysql_fetch_array($PaymentResult4))
{
	if($row4['GrandTotal4'] == NULL)
	{
		$Payment4 = 0;
	}
	else
	{
	$Payment4 = $row4['GrandTotal4'];
	}
}
while($row5=mysql_fetch_array($PaymentResult5))
{
	if($row5['GrandTotal5'] == NULL)
	{
		$Payment5 = 0;
	}
	else
	{
	$Payment5 = $row5['GrandTotal5'];
	}
}
while($row6=mysql_fetch_array($PaymentResult6))
{
	if($row6['GrandTotal6'] == NULL)
	{
		$Payment6 = 0;
	}
	else
	{
	$Payment6 = $row6['GrandTotal6'];
	}
}
while($row7=mysql_fetch_array($PaymentResult7))
{
	if($row7['GrandTotal7'] == NULL)
	{
		$Payment7 = 0;
	}
	else
	{
	$Payment7 = $row7['GrandTotal7'];
	}
}
while($row8=mysql_fetch_array($PaymentResult8))
{
	if($row8['GrandTotal8'] == NULL)
	{
		$Payment8 = 0;
	}
	else
	{
	$Payment8 = $row8['GrandTotal8'];
	}
}
while($row9=mysql_fetch_array($PaymentResult9))
{
	if($row9['GrandTotal9'] == NULL)
	{
		$Payment9 = 0;
	}
	else
	{
	$Payment9 = $row9['GrandTotal9'];
	}
}
while($row10=mysql_fetch_array($PaymentResult10))
{
	if($row10['GrandTotal10'] == NULL)
	{
		$Payment10 = 0;
	}
	else
	{
	$Payment10 = $row10['GrandTotal10'];
	}
}
while($row11=mysql_fetch_array($PaymentResult11))
{
	if($row11['GrandTotal11'] == NULL)
	{
		$Payment11 = 0;
	}
	else
	{	
	$Payment11 = $row11['GrandTotal11'];

	}
}
while($row12=mysql_fetch_array($PaymentResult12))
{
	if($row12['GrandTotal12'] == NULL)
	{
		$Payment12 = 0;
	}
	else
	{
	$Payment12 = $row12['GrandTotal12'];
	}
}


?>