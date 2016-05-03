Ajax = {
	
	
	makeRequest : function(type ,page, element){
		var request = null;
		try{
			type = type.toUpperCase();
			if(window.XMLHttpRequest){
				
				request = new XMLHttpRequest();
				request.open(type,page,true);
				request.onreadystatechange = function(){
					
					if(request.readyState == 4 && request.status == 200){
					
							jQuery(element).html(request.responseText);
							//request.responseText;
						
					}
					
				};
				
				request.send();
				
			}else{
					request = new ActiveXObject("Microsoft.HTTP");
					request.open(type,page,true );
				request.onReadyStateChange = function(){
					
					if(request.readyState == 4 && request.status == 200)
						console.log(request);
						
					
				};
				request.send();
			}
		}catch(ex){
			console.log(ex);
		}
	}
	
	
};
jQuery(document).ready(function(){
		
		

		
});
