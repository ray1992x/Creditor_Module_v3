<!DOCTYPE HTML>
<?php
$JanPSO = 0;
$FebPSO = 0;
$MarPSO = 0;
$AprPSO = 0;
$MayPSO = 0;
$JunPSO = 0;
$JulPSO = 0;
$AugPSO = 0;
$SepPSO = 0;
$OctPSO = 0;
$NovPSO = 0;
$DecPSO = 0;

$JanPSO = " SELECT SUM(POAmount) AS JanPSO FROM purchase WHERE MONTH(PODate) = 1 AND POType ='PSO' ";
$FebPSO = " SELECT SUM(POAmount) AS FebPSO FROM purchase WHERE MONTH(PODate) = 2 AND POType ='PSO' ";
$MarPSO = " SELECT SUM(POAmount) AS MarPSO FROM purchase WHERE MONTH(PODate) = 3 AND POType ='PSO' ";
$AprPSO = " SELECT SUM(POAmount) AS AprPSO FROM purchase WHERE MONTH(PODate) = 4 AND POType ='PSO' ";
$MayPSO = " SELECT SUM(POAmount) AS MayPSO FROM purchase WHERE MONTH(PODate) = 5 AND POType ='PSO' ";
$JunPSO = " SELECT SUM(POAmount) AS JunPSO FROM purchase WHERE MONTH(PODate) = 6 AND POType ='PSO' ";
$JulPSO = " SELECT SUM(POAmount) AS JulPSO FROM purchase WHERE MONTH(PODate) = 7 AND POType ='PSO' ";
$AugPSO = " SELECT SUM(POAmount) AS AugPSO FROM purchase WHERE MONTH(PODate) = 8 AND POType ='PSO' ";
$SepPSO = " SELECT SUM(POAmount) AS SepPSO FROM purchase WHERE MONTH(PODate) = 9 AND POType ='PSO' ";
$OctPSO = " SELECT SUM(POAmount) AS OctPSO FROM purchase WHERE MONTH(PODate) = 10 AND POType ='PSO' ";
$NovPSO = " SELECT SUM(POAmount) AS NovPSO FROM purchase WHERE MONTH(PODate) = 11 AND POType ='PSO' ";
$DecPSO = " SELECT SUM(POAmount) AS DecPSO FROM purchase WHERE MONTH(PODate) = 12 AND POType ='PSO' ";

$result1 = mysql_query($JanPSO);
$result2 = mysql_query($FebPSO);
$result3 = mysql_query($MarPSO);
$result4 = mysql_query($AprPSO);
$result5 = mysql_query($MayPSO);
$result6 = mysql_query($JunPSO);
$result7 = mysql_query($JulPSO);
$result8 = mysql_query($AugPSO);
$result9 = mysql_query($SepPSO);
$result10 = mysql_query($OctPSO);
$result12 = mysql_query($DecPSO);
$result11 = mysql_query($NovPSO);

while($row1=mysql_fetch_array($result1))
{
	if($row1['JanPSO'] == NULL)
	{
		$PSO1 = 0;
	}
	else
	{
		$PSO1 = $row1['JanPSO'];
	}
}
while($row2=mysql_fetch_array($result2))
{
	if($row2['FebPSO'] == NULL)
	{
		$PSO2 = 0;
	}
	else
	{
	$PSO2 = $row2['FebPSO'];
	}
}
while($row3=mysql_fetch_array($result3))
{
	if($row3['MarPSO'] == NULL)
	{
		$PSO3 = 0;
	}
	else
	{
		$PSO3 = $row3['MarPSO'];
	}
}
while($row4=mysql_fetch_array($result4))
{
	if($row4['AprPSO'] == NULL)
	{
		$PSO4 = 0;
	}
	else
	{
	$PSO4 = $row4['AprPSO'];
	}
}
while($row5=mysql_fetch_array($result5))
{
	if($row5['MayPSO'] == NULL)
	{
		$PSO5 = 0;
	}
	else
	{
	$PSO5 = $row5['MayPSO'];
	}
}
while($row6=mysql_fetch_array($result6))
{
	if($row6['JunPSO'] == NULL)
	{
		$PSO6 = 0;
	}
	else
	{
	$PSO6 = $row6['JunPSO'];
	}
}
while($row7=mysql_fetch_array($result7))
{
	if($row7['JulPSO'] == NULL)
	{
		$PSO7 = 0;
	}
	else
	{
		$PSO7 = $row7['JulPSO'];
	}
}
while($row8=mysql_fetch_array($result8))
{
	if($row8['AugPSO'] == NULL)
	{
		$PSO8 = 0;
	}
	else
	{
		$PSO8 = $row8['AugPSO'];
	}
}
while($row9=mysql_fetch_array($result9))
{
	if($row9['SepPSO'] == NULL)
	{
		$PSO9 = 0;
	}
	else
	{
	$PSO9 = $row9['SepPSO'];
	}
}
while($row10=mysql_fetch_array($result10))
{
	if($row10['OctPSO'] == NULL)
	{
		$PSO10 = 0;
	}
	else
	{
		$PSO10 = $row10['OctPSO'];
	}
}
while($row11=mysql_fetch_array($result11))
{
	if($row11['NovPSO'] == NULL)
	{
		$PSO11 = 0;
	}
	else
	{	
		$PSO11 = $row11['NovPSO'];

	}
}
while($row12=mysql_fetch_array($result12))
{
	if($row12['DecPSO'] == NULL)
	{
		$PSO12 = 0;
	}
	else
	{
		$PSO12 = $row12['DecPSO'];
	}
}
?>