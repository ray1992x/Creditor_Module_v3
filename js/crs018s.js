$(document).ready(function(){
	$('#Batch_Date').datepicker({dateFormat:'yy-mm-dd'});
});

$(document).ready(function(){
	
	$('#Confirm, #CView, #Update, #Cancel, #CDelete').hide();
	
});


$(document).ready(function(){
	$('#Add').click(function(event){
		event.preventDefault();
		$('#Batch_Type,#Batch_Number,#Batch_Date,#Batch_Period,#Batch_Total,#Transaction_Count').prop("disabled", false);
		$(' #Add, #View, #Edit, #Delete').hide();
		$(" #Confirm ,#Cancel").show();
	}) 
});

$(document).ready(function(){
	$('#View').click(function(event){
		event.preventDefault();
		$('#Batch_Number').prop("disabled", false);
		$(' #Add, #View, #Edit, #Delete').hide();
		$("#CView, #Cancel").show();
	})
	
});
		
$(document).ready(function(){
	$('#Edit').click(function(event){
		event.preventDefault();
		$('#Batch_Type,#Batch_Number,#Batch_Date,#Batch_Period,#Batch_Total,#Transaction_Count').prop("disabled", false);
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