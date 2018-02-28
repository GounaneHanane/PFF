$(document).ready(function(){
   $('#search').click(function(){
	   
		  var str ="";
		   
                $( "select option:selected" ).each(function() {
                      str += $( this ).attr('value');
					  console.log(str);
              });
			  
		   var search_input = $('#search_input').val();
			  if(str == "nom")
	        {
										 $.get("http://127.0.0.1:8000/clients/name/"+search_input,
													{
													},
													function(data, status){
														$('tbody *').remove();
														$('tbody').prepend(data);
													});
											  
											  
			  }
			  else if (str=="type_de_client")
			  {
				  $.get("http://127.0.0.1:8000/clients/type/"+search_input,
				  {},function(data,status){
					  
					  $('tbody *').remove();
														$('tbody').prepend(data);
				  });
			  }
			  
       
   });
   
   $('#refresh').click(function(){
	         $.get("http://127.0.0.1:8000/clients/all",
													{
													},
													function(data, status){
														$('tbody *').remove();
														$('tbody').prepend(data);
													});
	   
   });
});