<!DOCTYPE HTML>
<?php
$JanLPO = 0;
$FebLPO = 0;
$MarLPO = 0;
$AprLPO = 0;
$MayLPO = 0;
$JunLPO = 0;
$JulLPO = 0;
$AugLPO = 0;
$SepLPO = 0;
$OctLPO = 0;
$NovLPO = 0;
$DecLPO = 0;

$JanLPO = " SELECT SUM(POAmount) AS JanLPO FROM purchase WHERE MONTH(PODate) = 1 AND POType ='LPO' ";
$FebLPO = " SELECT SUM(POAmount) AS FebLPO FROM purchase WHERE MONTH(PODate) = 2 AND POType ='LPO' ";
$MarLPO = " SELECT SUM(POAmount) AS MarLPO FROM purchase WHERE MONTH(PODate) = 3 AND POType ='LPO' ";
$AprLPO = " SELECT SUM(POAmount) AS AprLPO FROM purchase WHERE MONTH(PODate) = 4 AND POType ='LPO' ";
$MayLPO = " SELECT SUM(POAmount) AS MayLPO FROM purchase WHERE MONTH(PODate) = 5 AND POType ='LPO' ";
$JunLPO = " SELECT SUM(POAmount) AS JunLPO FROM purchase WHERE MONTH(PODate) = 6 AND POType ='LPO' ";
$JulLPO = " SELECT SUM(POAmount) AS JulLPO FROM purchase WHERE MONTH(PODate) = 7 AND POType ='LPO' ";
$AugLPO = " SELECT SUM(POAmount) AS AugLPO FROM purchase WHERE MONTH(PODate) = 8 AND POType ='LPO' ";
$SepLPO = " SELECT SUM(POAmount) AS SepLPO FROM purchase WHERE MONTH(PODate) = 9 AND POType ='LPO' ";
$OctLPO = " SELECT SUM(POAmount) AS OctLPO FROM purchase WHERE MONTH(PODate) = 10 AND POType ='LPO' ";
$NovLPO = " SELECT SUM(POAmount) AS NovLPO FROM purchase WHERE MONTH(PODate) = 11 AND POType ='LPO' ";
$DecLPO = " SELECT SUM(POAmount) AS DecLPO FROM purchase WHERE MONTH(PODate) = 12 AND POType ='LPO' ";

$result1 = mysql_query($JanLPO);
$result2 = mysql_query($FebLPO);
$result3 = mysql_query($MarLPO);
$result4 = mysql_query($AprLPO);
$result5 = mysql_query($MayLPO);
$result6 = mysql_query($JunLPO);
$result7 = mysql_query($JulLPO);
$result8 = mysql_query($AugLPO);
$result9 = mysql_query($SepLPO);
$result10 = mysql_query($OctLPO);
$result12 = mysql_query($DecLPO);
$result11 = mysql_query($NovLPO);

while($row1=mysql_fetch_array($result1))
{
	if($row1['JanLPO'] == NULL)
	{
		$LPO1 = 0;
	}
	else
	{
		$LPO1 = $row1['JanLPO'];
	}
}
while($row2=mysql_fetch_array($result2))
{
	if($row2['FebLPO'] == NULL)
	{
		$LPO2 = 0;
	}
	else
	{
	$LPO2 = $row2['FebLPO'];
	}
}
while($row3=mysql_fetch_array($result3))
{
	if($row3['MarLPO'] == NULL)
	{
		$LPO3 = 0;
	}
	else
	{
		$LPO3 = $row3['MarLPO'];
	}
}
while($row4=mysql_fetch_array($result4))
{
	if($row4['AprLPO'] == NULL)
	{
		$LPO4 = 0;
	}
	else
	{
	$LPO4 = $row4['AprLPO'];
	}
}
while($row5=mysql_fetch_array($result5))
{
	if($row5['MayLPO'] == NULL)
	{
		$LPO5 = 0;
	}
	else
	{
	$LPO5 = $row5['MayLPO'];
	}
}
while($row6=mysql_fetch_array($result6))
{
	if($row6['JunLPO'] == NULL)
	{
		$LPO6 = 0;
	}
	else
	{
	$LPO6 = $row6['JunLPO'];
	}
}
while($row7=mysql_fetch_array($result7))
{
	if($row7['JulLPO'] == NULL)
	{
		$LPO7 = 0;
	}
	else
	{
		$LPO7 = $row7['JulLPO'];
	}
}
while($row8=mysql_fetch_array($result8))
{
	if($row8['AugLPO'] == NULL)
	{
		$LPO8 = 0;
	}
	else
	{
		$LPO8 = $row8['AugLPO'];
	}
}
while($row9=mysql_fetch_array($result9))
{
	if($row9['SepLPO'] == NULL)
	{
		$LPO9 = 0;
	}
	else
	{
	$LPO9 = $row9['SepLPO'];
	}
}
while($row10=mysql_fetch_array($result10))
{
	if($row10['OctLPO'] == NULL)
	{
		$LPO10 = 0;
	}
	else
	{
		$LPO10 = $row10['OctLPO'];
	}
}
while($row11=mysql_fetch_array($result11))
{
	if($row11['NovLPO'] == NULL)
	{
		$LPO11 = 0;
	}
	else
	{	
		$LPO11 = $row11['NovLPO'];

	}
}
while($row12=mysql_fetch_array($result12))
{
	if($row12['DecLPO'] == NULL)
	{
		$LPO12 = 0;
	}
	else
	{
		$LPO12 = $row12['DecLPO'];
	}
}
?>