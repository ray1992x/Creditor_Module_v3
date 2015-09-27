<!DOCTYPE HTML>
<?php
$CNReport1 = " SELECT SUM(CreditNoteAmount) AS CNTotal1 FROM creditnote WHERE MONTH(CreditNoteDate) = 1 ";
$CNReport2 = " SELECT SUM(CreditNoteAmount) AS CNTotal2 FROM creditnote WHERE MONTH(CreditNoteDate) = 2 ";
$CNReport3 = " SELECT SUM(CreditNoteAmount) AS CNTotal3 FROM creditnote WHERE MONTH(CreditNoteDate) = 3 ";
$CNReport4 = " SELECT SUM(CreditNoteAmount) AS CNTotal4 FROM creditnote WHERE MONTH(CreditNoteDate) = 4 ";
$CNReport5 = " SELECT SUM(CreditNoteAmount) AS CNTotal5 FROM creditnote WHERE MONTH(CreditNoteDate) = 5 ";
$CNReport6 = " SELECT SUM(CreditNoteAmount) AS CNTotal6 FROM creditnote WHERE MONTH(CreditNoteDate) = 6 ";
$CNReport7 = " SELECT SUM(CreditNoteAmount) AS CNTotal7 FROM creditnote WHERE MONTH(CreditNoteDate) = 7 ";
$CNReport8 = " SELECT SUM(CreditNoteAmount) AS CNTotal8 FROM creditnote WHERE MONTH(CreditNoteDate) = 8 ";
$CNReport9 = " SELECT SUM(CreditNoteAmount) AS CNTotal9 FROM creditnote WHERE MONTH(CreditNoteDate) = 9 ";
$CNReport10 = " SELECT SUM(CreditNoteAmount) AS CNTotal10 FROM creditnote WHERE MONTH(CreditNoteDate) = 10 ";
$CNReport11 = " SELECT SUM(CreditNoteAmount) AS CNTotal11 FROM creditnote WHERE MONTH(CreditNoteDate) = 11 ";
$CNReport12 = " SELECT SUM(CreditNoteAmount) AS CNTotal12 FROM creditnote WHERE MONTH(CreditNoteDate) = 12 ";

$CNResult1 = mysql_query($CNReport1);
$CNResult2 = mysql_query($CNReport2);
$CNResult3 = mysql_query($CNReport3);
$CNResult4 = mysql_query($CNReport4);
$CNResult5 = mysql_query($CNReport5);
$CNResult6 = mysql_query($CNReport6);
$CNResult7 = mysql_query($CNReport7);
$CNResult8 = mysql_query($CNReport8);
$CNResult9 = mysql_query($CNReport9);
$CNResult10 = mysql_query($CNReport10);
$CNResult11 = mysql_query($CNReport11);
$CNResult12 = mysql_query($CNReport12);


while($row1=mysql_fetch_array($CNResult1))
{
	if($row1['CNTotal1'] == NULL)
	{
		$CNote1 = 0;
	}
	else
	{
	$CNote1 = $row1['CNTotal1'];
	}
}
while($row2=mysql_fetch_array($CNResult2))
{
	if($row2['CNTotal2'] == NULL)
	{
		$CNote2 = 0;
	}
	else
	{
	$CNote2 = $row2['CNTotal2'];
	}
}
while($row3=mysql_fetch_array($CNResult3))
{
	if($row3['CNTotal3'] == NULL)
	{
		$CNote3 = 0;
	}
	else
	{
	$CNote3 = $row3['CNTotal3'];
	}
}
while($row4=mysql_fetch_array($CNResult4))
{
	if($row4['CNTotal4'] == NULL)
	{
		$CNote4 = 0;
	}
	else
	{
	$CNote4 = $row4['CNTotal4'];
	}
}
while($row5=mysql_fetch_array($CNResult5))
{
	if($row5['CNTotal5'] == NULL)
	{
		$CNote5 = 0;
	}
	else
	{
	$CNote5 = $row5['CNTotal5'];
	}
}
while($row6=mysql_fetch_array($CNResult6))
{
	if($row6['CNTotal6'] == NULL)
	{
		$CNote6 = 0;
	}
	else
	{
	$CNote6 = $row6['CNTotal6'];
	}
}
while($row7=mysql_fetch_array($CNResult7))
{
	if($row7['CNTotal7'] == NULL)
	{
		$CNote7 = 0;
	}
	else
	{
	$CNote7 = $row7['CNTotal7'];
	}
}
while($row8=mysql_fetch_array($CNResult8))
{
	if($row8['CNTotal8'] == NULL)
	{
		$CNote8 = 0;
	}
	else
	{
	$CNote8 = $row8['CNTotal8'];
	}
}
while($row9=mysql_fetch_array($CNResult9))
{
	if($row9['CNTotal9'] == NULL)
	{
		$CNote9 = 0;
	}
	else
	{
	$CNote9 = $row9['CNTotal9'];
	}
}
while($row10=mysql_fetch_array($CNResult10))
{
	if($row10['CNTotal10'] == NULL)
	{
		$CNote10 = 0;
	}
	else
	{
	$CNote10 = $row10['CNTotal10'];
	}
}
while($row11=mysql_fetch_array($CNResult11))
{
	if($row11['CNTotal11'] == NULL)
	{
		$CNote11 = 0;
	}
	else
	{	
	$CNote11 = $row11['CNTotal11'];

	}
}
while($row12=mysql_fetch_array($CNResult12))
{
	if($row12['CNTotal12'] == NULL)
	{
		$CNote12 = 0;
	}
	else
	{
	$CNote12 = $row12['CNTotal12'];
	}
}
?>