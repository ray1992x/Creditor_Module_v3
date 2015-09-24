<!DOCTYPE HTML>
<?php

$InvoiceReport1 = 0;
$InvoiceReport2 = 0;
$InvoiceReport3 = 0;
$InvoiceReport4 = 0;
$InvoiceReport5 = 0;
$InvoiceReport6 = 0;
$InvoiceReport7 = 0;
$InvoiceReport8 = 0;
$InvoiceReport9 = 0;
$InvoiceReport10 = 0;
$InvoiceReport11 = 0;
$InvoiceReport12 = 0;

$InvoiceReport1 = " SELECT SUM(InvoiceTotal) AS GrandTotal1 FROM invoice WHERE MONTH(InvoiceDate) = 1 ";
$InvoiceReport2 = " SELECT SUM(InvoiceTotal) AS GrandTotal2 FROM invoice WHERE MONTH(InvoiceDate) = 2 ";
$InvoiceReport3 = " SELECT SUM(InvoiceTotal) AS GrandTotal3 FROM invoice WHERE MONTH(InvoiceDate) = 3 ";
$InvoiceReport4 = " SELECT SUM(InvoiceTotal) AS GrandTotal4 FROM invoice WHERE MONTH(InvoiceDate) = 4 ";
$InvoiceReport5 = " SELECT SUM(InvoiceTotal) AS GrandTotal5 FROM invoice WHERE MONTH(InvoiceDate) = 5 ";
$InvoiceReport6 = " SELECT SUM(InvoiceTotal) AS GrandTotal6 FROM invoice WHERE MONTH(InvoiceDate) = 6 ";
$InvoiceReport7 = " SELECT SUM(InvoiceTotal) AS GrandTotal7 FROM invoice WHERE MONTH(InvoiceDate) = 7 ";
$InvoiceReport8 = " SELECT SUM(InvoiceTotal) AS GrandTotal8 FROM invoice WHERE MONTH(InvoiceDate) = 8 ";
$InvoiceReport9 = " SELECT SUM(InvoiceTotal) AS GrandTotal9 FROM invoice WHERE MONTH(InvoiceDate) = 9 ";
$InvoiceReport10 = " SELECT SUM(InvoiceTotal) AS GrandTotal10 FROM invoice WHERE MONTH(InvoiceDate) = 10 ";
$InvoiceReport11 = " SELECT SUM(InvoiceTotal) AS GrandTotal11 FROM invoice WHERE MONTH(InvoiceDate) = 11 ";
$InvoiceReport12 = " SELECT SUM(InvoiceTotal) AS GrandTotal12 FROM invoice WHERE MONTH(InvoiceDate) = 12 ";


$INVResult1 = mysql_query($InvoiceReport1);
$INVResult2 = mysql_query($InvoiceReport2);
$INVResult3 = mysql_query($InvoiceReport3);
$INVResult4 = mysql_query($InvoiceReport4);
$INVResult5 = mysql_query($InvoiceReport5);
$INVResult6 = mysql_query($InvoiceReport6);
$INVResult7 = mysql_query($InvoiceReport7);
$INVResult8 = mysql_query($InvoiceReport8);
$INVResult9 = mysql_query($InvoiceReport9);
$INVResult10 = mysql_query($InvoiceReport10);
$INVResult11 = mysql_query($InvoiceReport11);
$INVResult12 = mysql_query($InvoiceReport12);


while($row1=mysql_fetch_array($INVResult1))
{
	if($row1['GrandTotal1'] == NULL)
	{
		$Invoice1 = 0;
	}
	else
	{
		$Invoice1 = $row1['GrandTotal1'];
	}
}
while($row2=mysql_fetch_array($INVResult2))
{
	if($row2['GrandTotal2'] == NULL)
	{
		$Invoice2 = 0;
	}
	else
	{
	$Invoice2 = $row2['GrandTotal2'];
	}
}
while($row3=mysql_fetch_array($INVResult3))
{
	if($row3['GrandTotal3'] == NULL)
	{
		$Invoice3 = 0;
	}
	else
	{
	$Invoice3 = $row3['GrandTotal3'];
	}
}
while($row4=mysql_fetch_array($INVResult4))
{
	if($row4['GrandTotal4'] == NULL)
	{
		$Invoice4 = 0;
	}
	else
	{
	$Invoice4 = $row4['GrandTotal4'];
	}
}
while($row5=mysql_fetch_array($INVResult5))
{
	if($row5['GrandTotal5'] == NULL)
	{
		$Invoice5 = 0;
	}
	else
	{
	$Invoice5 = $row5['GrandTotal5'];
	}
}
while($row6=mysql_fetch_array($INVResult6))
{
	if($row6['GrandTotal6'] == NULL)
	{
		$Invoice6 = 0;
	}
	else
	{
	$Invoice6 = $row6['GrandTotal6'];
	}
}
while($row7=mysql_fetch_array($INVResult7))
{
	if($row7['GrandTotal7'] == NULL)
	{
		$Invoice7 = 0;
	}
	else
	{
	$Invoice7 = $row7['GrandTotal7'];
	}
}
while($row8=mysql_fetch_array($INVResult8))
{
	if($row8['GrandTotal8'] == NULL)
	{
		$Invoice8 = 0;
	}
	else
	{
	$Invoice8 = $row8['GrandTotal8'];
	}
}
while($row9=mysql_fetch_array($INVResult9))
{
	if($row9['GrandTotal9'] == NULL)
	{
		$Invoice9 = 0;
	}
	else
	{
	$Invoice9 = $row9['GrandTotal9'];
	}
}
while($row10=mysql_fetch_array($INVResult10))
{
	if($row10['GrandTotal10'] == NULL)
	{
		$Invoice10 = 0;
	}
	else
	{
	$Invoice10 = $row10['GrandTotal10'];
	}
}
while($row11=mysql_fetch_array($INVResult11))
{
	if($row11['GrandTotal11'] == NULL)
	{
		$Invoice11 = 0;
	}
	else
	{	
	$Invoice11 = $row11['GrandTotal11'];

	}
}
while($row12=mysql_fetch_array($INVResult12))
{
	if($row12['GrandTotal12'] == NULL)
	{
		$Invoice12 = 0;
	}
	else
	{
	$Invoice12 = $row12['GrandTotal12'];
	}
}


?>