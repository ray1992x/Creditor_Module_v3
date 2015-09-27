<?php	if ($_SERVER["REQUEST_METHOD"] == "POST") {

		

		if(empty($_POST["CR_Code"])) {
			$CR_Code_ERR = "Required";
		}else {
			$CR_Code = strip_tags($_POST['CR_Code']);
		}
		if(empty($_POST["PO_Number"])) {
			$POnumErr = "Required";
		}else {
			$PO_Number = strip_tags($_POST['PO_Number']);
		}
		
		if(empty($_POST["PO_Date"])) {
			$POdateErr = "Required";
		}else {
			$PO_Date = strip_tags($_POST['PO_Date']);
		}
		
		if(empty($_POST["PO_Type"])) {
			$POtypeErr = "Required";
		}else {
			$PO_Type = strip_tags($_POST['PO_Type']);
		}
		
		if(empty($_POST["PO_Amount"])) {
			$POamtErr = "Required";
		}else{
			$PO_Amount = strip_tags($_POST['PO_Amount']);
		}
	}
	
	if((!empty($_POST["CR_Code"])) && (!empty($_POST["PO_Number"])) && (!empty($_POST["PO_Date"])) && (!empty($_POST["PO_Type"])) && (!empty($_POST["PO_Amount"]))){
		
		
		$query = " Select * FROM purchase";
		$result = mysql_query($query) or die(mysql_error());
		$exists = "no";
		
		while($row = mysql_fetch_array($result)){
			if($row['POtemp'] == $PO_Number){
				$exists = "yes";
				break;
			}
		}
		
		if($exists == "no"){
			$query = "Insert INTO `purchase`( `CreditorCode`,`POtemp`, `PODate`, `POType`, `POAmount`)
			values('$CR_Code','$PO_Number','$PO_Date','$PO_Type','$PO_Amount')";
			
			$result = mysql_query($query) or die(mysql_error());
			if(!$result)
			{
				$msg = "not Inserted";

			}
			else
			{
				$added="Added!";
				$query = "Insert INTO `podetailtable` (`CreditorCode`,`POtemp`) values ('$CR_Code','$PO_Number')";
				$result = mysql_query($query) or die(mysql_error()); 

				
				if(!$result)
				{
					$msg = "not Inserted";
				}
				else
				{
					$_SESSION['number']=$PO_Number;//store $po number 
					$query="SELECT * FROM `purchase` WHERE `POtemp`='$PO_Number'";
					$records = mysql_query($query) or die(mysql_error());	
					while($row=mysql_fetch_array($records))
					{
						$CR_Code = $row['CreditorCode'];
						$PO_Number = $row['POtemp'];
						$PO_Date = $row['PODate'];
						$PO_Type = $row['POType'];
						$PO_Amount = $row['POAmount'];
					}
				}
			}
		}else{
			
			$CR_Code = NULL;
			$PO_Allocation = NULL;
			$PO_Number = NULL;
			$PO_Date= NULL;
			$PO_Type = NULL;
			$PO_Amount =NULL;
			$_SESSION['number']=NULL;
			$POExist = "Already exists";
		}
		
		


	}
?>