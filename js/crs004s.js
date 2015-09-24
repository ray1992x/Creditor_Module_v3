$(document).ready(function(){
	$('#INV_Date,#PAY_Due').datepicker({dateFormat:'yy-mm-dd'});
});

$(document).ready(function(){
	
	$('#Confirm, #CView, #Update, #Cancel, #CDelete').hide();
	
});


$(document).ready(function(){
	$('#Add').click(function(event){
		event.preventDefault();
		$('#CR_Code,#INV_Num,#INV_Total,#INV_Date,#INV_Desc,#PAY_Due,#PO_Number,#PO_Type,#Batch_Num').prop("disabled", false);
		$(' #Add, #View, #Edit, #Delete').hide();
		$(" #Confirm ,#Cancel").show();
	}) 
});

$(document).ready(function(){
	$('#View').click(function(event){
		event.preventDefault();
		$('#INV_Num').prop("disabled", false);
		$(' #Add, #View, #Edit, #Delete').hide();
		$("#CView, #Cancel").show();
	})
	
});
		
$(document).ready(function(){
	$('#Edit').click(function(event){
		event.preventDefault();
		$('#CR_Code,#INV_Num,#INV_Total,#INV_Date,#INV_Desc,#PAY_Due,#PO_Number,#PO_Type,#Batch_Num').prop("disabled", false);
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