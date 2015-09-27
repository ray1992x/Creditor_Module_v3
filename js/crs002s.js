$(document).ready(function(){
	
	$('#Confirm, #CView, #Update, #Cancel, #CDelete').hide();
	
});


$(document).ready(function(){
	$('#Add').click(function(event){
		event.preventDefault();
		$('#CR_Code,#CR_Name,#CR_Type,#ShortName,#CompanyNo,#CR_Period,#PO_Require,#Remark,#Contact_Address,#Contact_Name,#Tel1,#Fax,#Tel2,#Contact_Email').prop("disabled", false);
		$(' #Add, #View, #Edit, #Delete').hide();
		$(" #Confirm ,#Cancel").show();
	}) 
});

$(document).ready(function(){
	$('#View').click(function(event){
		event.preventDefault();
		$('#CR_Code').prop("disabled", false);
		$(' #Add, #View, #Edit, #Delete').hide();
		$("#CView, #Cancel").show();
	})
	
});
		
$(document).ready(function(){
	$('#Edit').click(function(event){
		event.preventDefault();
		$('#CR_Code,#CR_Name,#CR_Type,#ShortName,#CompanyNo,#CR_Period,#PO_Require,#Remark,#Contact_Address,#Contact_Name,#Tel1,#Fax,#Tel2,#Contact_Email').prop("disabled", false);
		$(' #Add, #View, #Edit, #Delete').hide();
		$('#Update, #Cancel').show();
	})
});

$(document).ready(function(){
	$('#Delete').click(function(event){
		event.preventDefault();
		$(' #Add, #View, #Edit, #Delete').hide();
		$('#CDelete, #Cancel').show();
	})
});