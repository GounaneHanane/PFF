$(document).ready(function(){

$(".trash").click(function(){
	  $('#CustomerTable').find('input[type="checkbox"]:checked').each(function () {
		 var id =  $( this ).parent().parent().attr('alt');
		 alert(id);
		 
        $( this ).parent().parent().remove();
		  $.get("http://127.0.0.1:8000//clients/delete/"+id,
													{
													},
													function(data, status){
														alert(data);
													});
    });
	
});
});

