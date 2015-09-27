<!DOCTYPE HTML>
<?php
$JanMSO = 0;
$FebMSO = 0;
$MarMSO = 0;
$AprMSO = 0;
$MayMSO = 0;
$JunMSO = 0;
$JulMSO = 0;
$AugMSO = 0;
$SepMSO = 0;
$OctMSO = 0;
$NovMSO = 0;
$DecMSO = 0;

$JanMSO = " SELECT SUM(POAmount) AS JanMSO FROM purchase WHERE MONTH(PODate) = 1 AND POType ='MSO' ";
$FebMSO = " SELECT SUM(POAmount) AS FebMSO FROM purchase WHERE MONTH(PODate) = 2 AND POType ='MSO' ";
$MarMSO = " SELECT SUM(POAmount) AS MarMSO FROM purchase WHERE MONTH(PODate) = 3 AND POType ='MSO' ";
$AprMSO = " SELECT SUM(POAmount) AS AprMSO FROM purchase WHERE MONTH(PODate) = 4 AND POType ='MSO' ";
$MayMSO = " SELECT SUM(POAmount) AS MayMSO FROM purchase WHERE MONTH(PODate) = 5 AND POType ='MSO' ";
$JunMSO = " SELECT SUM(POAmount) AS JunMSO FROM purchase WHERE MONTH(PODate) = 6 AND POType ='MSO' ";
$JulMSO = " SELECT SUM(POAmount) AS JulMSO FROM purchase WHERE MONTH(PODate) = 7 AND POType ='MSO' ";
$AugMSO = " SELECT SUM(POAmount) AS AugMSO FROM purchase WHERE MONTH(PODate) = 8 AND POType ='MSO' ";
$SepMSO = " SELECT SUM(POAmount) AS SepMSO FROM purchase WHERE MONTH(PODate) = 9 AND POType ='MSO' ";
$OctMSO = " SELECT SUM(POAmount) AS OctMSO FROM purchase WHERE MONTH(PODate) = 10 AND POType ='MSO' ";
$NovMSO = " SELECT SUM(POAmount) AS NovMSO FROM purchase WHERE MONTH(PODate) = 11 AND POType ='MSO' ";
$DecMSO = " SELECT SUM(POAmount) AS DecMSO FROM purchase WHERE MONTH(PODate) = 12 AND POType ='MSO' ";

$result1 = mysql_query($JanMSO);
$result2 = mysql_query($FebMSO);
$result3 = mysql_query($MarMSO);
$result4 = mysql_query($AprMSO);
$result5 = mysql_query($MayMSO);
$result6 = mysql_query($JunMSO);
$result7 = mysql_query($JulMSO);
$result8 = mysql_query($AugMSO);
$result9 = mysql_query($SepMSO);
$result10 = mysql_query($OctMSO);
$result12 = mysql_query($DecMSO);
$result11 = mysql_query($NovMSO);

while($row1=mysql_fetch_array($result1))
{
	if($row1['JanMSO'] == NULL)
	{
		$MSO1 = 0;
	}
	else
	{
		$MSO1 = $row1['JanMSO'];
	}
}
while($row2=mysql_fetch_array($result2))
{
	if($row2['FebMSO'] == NULL)
	{
		$MSO2 = 0;
	}
	else
	{
	$MSO2 = $row2['FebMSO'];
	}
}
while($row3=mysql_fetch_array($result3))
{
	if($row3['MarMSO'] == NULL)
	{
		$MSO3 = 0;
	}
	else
	{
		$MSO3 = $row3['MarMSO'];
	}
}
while($row4=mysql_fetch_array($result4))
{
	if($row4['AprMSO'] == NULL)
	{
		$MSO4 = 0;
	}
	else
	{
	$MSO4 = $row4['AprMSO'];
	}
}
while($row5=mysql_fetch_array($result5))
{
	if($row5['MayMSO'] == NULL)
	{
		$MSO5 = 0;
	}
	else
	{
	$MSO5 = $row5['MayMSO'];
	}
}
while($row6=mysql_fetch_array($result6))
{
	if($row6['JunMSO'] == NULL)
	{
		$MSO6 = 0;
	}
	else
	{
	$MSO6 = $row6['JunMSO'];
	}
}
while($row7=mysql_fetch_array($result7))
{
	if($row7['JulMSO'] == NULL)
	{
		$MSO7 = 0;
	}
	else
	{
		$MSO7 = $row7['JulMSO'];
	}
}
while($row8=mysql_fetch_array($result8))
{
	if($row8['AugMSO'] == NULL)
	{
		$MSO8 = 0;
	}
	else
	{
		$MSO8 = $row8['AugMSO'];
	}
}
while($row9=mysql_fetch_array($result9))
{
	if($row9['SepMSO'] == NULL)
	{
		$MSO9 = 0;
	}
	else
	{
	$MSO9 = $row9['SepMSO'];
	}
}
while($row10=mysql_fetch_array($result10))
{
	if($row10['OctMSO'] == NULL)
	{
		$MSO10 = 0;
	}
	else
	{
		$MSO10 = $row10['OctMSO'];
	}
}
while($row11=mysql_fetch_array($result11))
{
	if($row11['NovMSO'] == NULL)
	{
		$MSO11 = 0;
	}
	else
	{	
		$MSO11 = $row11['NovMSO'];

	}
}
while($row12=mysql_fetch_array($result12))
{
	if($row12['DecMSO'] == NULL)
	{
		$MSO12 = 0;
	}
	else
	{
		$MSO12 = $row12['DecMSO'];
	}
}
?>