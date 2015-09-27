$(document).ready(function(){
	$('#date, #Tdate, #JR_Date, #CR_Period').datepicker({dateFormat:'yy-mm-dd'});
});

//showing the input box and the "confirm" and "cancel" button in Journal transfer tab
$(document).ready(function(){
	$('#Confirm, #Cancel, #CView, #Cdelete').hide();
	$('#Add').click(function(event){
		event.preventDefault();
		$('#JR_Number,#JR_Date,#JR_Amount,#CR_Code,#Trans_Type,#JR_Ref,#Reference_Amount,#Batch_Number,#SEQ_Num,#Batch_Amount').prop("disabled", false);
		$("#Confirm ,#Cancel").show();
		$('#CView,#Add,#View,#delete').hide();
	}) 
});

$(document).ready(function(){
	$('#View').click(function(event){
		event.preventDefault();
		$('#CR_Code,#JR_Ref').prop("disabled", false);
		$('#CView,#Cancel').show();
		$('#Add,#View,#delete').hide();
	});
});


$(document).ready(function(){
	$('#delete').click(function(event){
		event.preventDefault();
		$('#JR_Number').prop("disabled", false);
		$('#Cdelete, #Cancel').show();
		$('#Add,#View,#delete').hide();
	})
})