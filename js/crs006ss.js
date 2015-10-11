$(document).ready(function(){
	$('#CR_NoteDate').datepicker({dateFormat:'yy-mm-dd'});
});

$(document).ready(function(){
	
	$('#Confirm, #CView, #Update, #Cancel, #CDelete').hide();
	
});


$(document).ready(function(){
	$('#Add').click(function(event){
		event.preventDefault();
		$('#JR_Number,#JR_Date,#JR_Amount,#CR_Code,#JR_Ref,#Trans_Type,#Reference_Amount,#Batch_Number,#Batch_Amount').prop("disabled", false);
		$(' #Add, #View, #Edit, #Delete').hide();
		$(" #Confirm ,#Cancel").show();
	}) 
});

$(document).ready(function(){
	$('#View').click(function(event){
		event.preventDefault();
		$('#JR_Number').prop("disabled", false);
		$(' #Add, #View, #Edit, #Delete').hide();
		$("#CView, #Cancel").show();
	})
	
});
		
$(document).ready(function(){
	$('#Edit').click(function(event){
		event.preventDefault();
		$('#JR_Number,#JR_Date,#JR_Amount,#CR_Code,#JR_Ref,#Trans_Type,#Reference_Amount,#Batch_Number,#Batch_Amount').prop("disabled", false);
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