var Draft = {//start of class
	
	league_creator : "#league_creator",
	setUp : function (){
		
		
			
	},
	
	ManagerModule : {
		
		module : "#managers_module",
		add_manager_button: "#add_manager_to_league_button",
		
			addManager : function(element , user){
					
					var host = "ws://192.168.1.150:8080";
					var web_socket = new WebSocket(host);
					console.log(web_socket);
					console.log(element);
					console.log(user);
					web_socket.onerror = function(){
						
						
					};
					web_socket.onopen = function(){
						
						web_socket.send("Ping");
					};
					web_socket.onclose = function(){
						
						console.log("closed");
					};
					web_socket.onmessage = function(){
						
					};
					jQuery(element).remove();
				
			}
		},
	GamersModule : {
		
		
	},
	Ajax : {
		
	}
	
};// end of class //////////

jQuery(document).ready(function(){
	
});