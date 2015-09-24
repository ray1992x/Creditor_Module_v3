<!DOCTYPE HTML>
<?php
$JournalReport1 = " SELECT SUM(JournalAmount) AS JTotal1 FROM journal WHERE MONTH(JournalDate) = 1 ";
$JournalReport2 = " SELECT SUM(JournalAmount) AS JTotal2 FROM journal WHERE MONTH(JournalDate) = 2 ";
$JournalReport3 = " SELECT SUM(JournalAmount) AS JTotal3 FROM journal WHERE MONTH(JournalDate) = 3 ";
$JournalReport4 = " SELECT SUM(JournalAmount) AS JTotal4 FROM journal WHERE MONTH(JournalDate) = 4 ";
$JournalReport5 = " SELECT SUM(JournalAmount) AS JTotal5 FROM journal WHERE MONTH(JournalDate) = 5 ";
$JournalReport6 = " SELECT SUM(JournalAmount) AS JTotal6 FROM journal WHERE MONTH(JournalDate) = 6 ";
$JournalReport7 = " SELECT SUM(JournalAmount) AS JTotal7 FROM journal WHERE MONTH(JournalDate) = 7 ";
$JournalReport8 = " SELECT SUM(JournalAmount) AS JTotal8 FROM journal WHERE MONTH(JournalDate) = 8 ";
$JournalReport9 = " SELECT SUM(JournalAmount) AS JTotal9 FROM journal WHERE MONTH(JournalDate) = 9 ";
$JournalReport10 = " SELECT SUM(JournalAmount) AS JTotal10 FROM journal WHERE MONTH(JournalDate) = 10 ";
$JournalReport11 = " SELECT SUM(JournalAmount) AS JTotal11 FROM journal WHERE MONTH(JournalDate) = 11 ";
$JournalReport12 = " SELECT SUM(JournalAmount) AS JTotal12 FROM journal WHERE MONTH(JournalDate) = 12 ";

$JResult1 = mysql_query($JournalReport1);
$JResult2 = mysql_query($JournalReport2);
$JResult3 = mysql_query($JournalReport3);
$JResult4 = mysql_query($JournalReport4);
$JResult5 = mysql_query($JournalReport5);
$JResult6 = mysql_query($JournalReport6);
$JResult7 = mysql_query($JournalReport7);
$JResult8 = mysql_query($JournalReport8);
$JResult9 = mysql_query($JournalReport9);
$JResult10 = mysql_query($JournalReport10);
$JResult11 = mysql_query($JournalReport11);
$JResult12 = mysql_query($JournalReport12);


while($row1=mysql_fetch_array($JResult1))
{
	if($row1['JTotal1'] == NULL)
	{
		$Journal1 = 0;
	}
	else
	{
	$Journal1 = $row1['JTotal1'];
	}
}
while($row2=mysql_fetch_array($JResult2))
{
	if($row2['JTotal2'] == NULL)
	{
		$Journal2 = 0;
	}
	else
	{
	$Journal2 = $row2['JTotal2'];
	}
}
while($row3=mysql_fetch_array($JResult3))
{
	if($row3['JTotal3'] == NULL)
	{
		$Journal3 = 0;
	}
	else
	{
	$Journal3 = $row3['JTotal3'];
	}
}
while($row4=mysql_fetch_array($JResult4))
{
	if($row4['JTotal4'] == NULL)
	{
		$Journal4 = 0;
	}
	else
	{
	$Journal4 = $row4['JTotal4'];
	}
}
while($row5=mysql_fetch_array($JResult5))
{
	if($row5['JTotal5'] == NULL)
	{
		$Journal5 = 0;
	}
	else
	{
	$Journal5 = $row5['JTotal5'];
	}
}
while($row6=mysql_fetch_array($JResult6))
{
	if($row6['JTotal6'] == NULL)
	{
		$Journal6 = 0;
	}
	else
	{
	$Journal6 = $row6['JTotal6'];
	}
}
while($row7=mysql_fetch_array($JResult7))
{
	if($row7['JTotal7'] == NULL)
	{
		$Journal7 = 0;
	}
	else
	{
	$Journal7 = $row7['JTotal7'];
	}
}
while($row8=mysql_fetch_array($JResult8))
{
	if($row8['JTotal8'] == NULL)
	{
		$Journal8 = 0;
	}
	else
	{
	$Journal8 = $row8['JTotal8'];
	}
}
while($row9=mysql_fetch_array($JResult9))
{
	if($row9['JTotal9'] == NULL)
	{
		$Journal9 = 0;
	}
	else
	{
	$Journal9 = $row9['JTotal9'];
	}
}
while($row10=mysql_fetch_array($JResult10))
{
	if($row10['JTotal10'] == NULL)
	{
		$Journal10 = 0;
	}
	else
	{
	$Journal10 = $row10['JTotal10'];
	}
}
while($row11=mysql_fetch_array($JResult11))
{
	if($row11['JTotal11'] == NULL)
	{
		$Journal11 = 0;
	}
	else
	{	
	$Journal11 = $row11['JTotal11'];

	}
}
while($row12=mysql_fetch_array($JResult12))
{
	if($row12['JTotal12'] == NULL)
	{
		$Journal12 = 0;
	}
	else
	{
	$Journal12 = $row12['JTotal12'];
	}
}
?>