$(document).ready(function(){
	$('#CR_NoteDate').datepicker({dateFormat:'yy-mm-dd'});
});

$(document).ready(function(){
	
	$('#Confirm, #CView, #Update, #Cancel, #CDelete').hide();
	
});


$(document).ready(function(){
	$('#Add').click(function(event){
		event.preventDefault();
		$('#CR_Code,#CR_NoteNo,#CR_BatchNo,#CR_SeqNo,#CR_NoteAmt,#CR_NoteDate,#CR_NoteDesc').prop("disabled", false);
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
		$('#CR_Code,#CR_NoteNo,#CR_BatchNo,#CR_SeqNo,#CR_NoteAmt,#CR_NoteDate,#CR_NoteDesc').prop("disabled", false);
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