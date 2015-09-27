
$(document).ready(function(){
	$('#PO_Date,#INV_Date, #PAY_Due,#Date_Paid, #Start_Active_Date, #Last_On_Hold_Date,#CR_NoteDate ').datepicker({dateFormat:'yy-mm-dd'});
});

$(document).ready(function(){
	
	$('#Confirm, #CView, #Update, #Cancel, #CDelete').hide();
	
});
$(document).ready(function(){
	$('#Add').click(function(event){
		event.preventDefault();
		$('#PO_Number,#PO_Date,#PO_Type,#PO_Amount').prop("disabled", false);
		$('#CR_Code,#CR_Name,#CR_Type,#ShortName,#CompanyNo,#CR_Period,#Remark,#Payment_YTD,#Last_Payment_Date,#Invoice_YTD,#Last_Invoice_Date,#CR_Balance,#Contact_Address,#Contact_Address,#Contact_Name,#Tel1,#Tel2,#Fax,#Contact_Email,#Start_Active_Date,#Last_On_Hold_Date').prop("disabled", false);
		$(' #Add, #View, #Edit, #Delete').hide();
		$(" #Confirm ,#Cancel").show();
	}) 
});

$(document).ready(function(){
	$('#View').click(function(event){
		event.preventDefault();
		$('#PO_Number').prop("disabled", false);
		$(' #Add, #View, #Edit, #Delete').hide();
		$("#CView, #Cancel").show();
	})
	
});
		
$(document).ready(function(){
	$('#Edit').click(function(event){
		event.preventDefault();
		$('#PO_Number,#PO_Date,#PO_Type,#PO_Amount').prop("disabled", false);
		$(' #Add, #View, #Edit, #Delete').hide();
		$('#Update, #Cancel').show();
	})
});

$(document).ready(function(){
	$('#Delete').click(function(event){
		event.preventDefault();
		$('#PO_Number').prop("disabled", false);
		$(' #Add, #View, #Edit, #Delete').hide();
		$('#CDelete, #Cancel').show();
	})
});