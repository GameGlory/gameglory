jQuery(document).ready(function(){
	
	if(window.location.hash != ""){
		if(window.location.hash == "#gamers")
			displayGamers();
		else if(window.location.hash == "#managers")
			displayManagers();
		else if(window.location.hash == "#games")
			displayGames();
		else
			window.location.hash = "";
	}
	jQuery("#page_header_footer_managers").on("click",function(){
		
		displayManagers();
		
	});
	jQuery("#page_header_footer_gamers").on("click",function(){
		
		displayGamers();
		
	});
	jQuery("#user_search_gamers_catagory a").on("click",function(){
		
		displayGamers();
		
	});
	jQuery("#user_search_managers_catagory a").on("click",function(){
		
		displayManagers();
		
	});
	jQuery("#page_header_footer_games").on("click",function(){
		
		displayGames();
		
	});
	jQuery("#user_search_games_catagory a").on("click",function(){
		
		displayGames();
		
	});
});
function displayGamers(){

	if(jQuery("#gamer_search_module_container") && jQuery("#manager_search_module_container") && jQuery("#games_search_module_container")){
			
			if(jQuery("#manager_search_module_container").css("visibility") == "visible" && jQuery("#games_search_module_container").css("visibility") == "hidden" && jQuery("#gamer_search_module_container").css("visibility") == "hidden" || jQuery("#manager_search_module_container").css("visibility") == "hidden" && jQuery("#games_search_module_container").css("visibility") == "visible" && jQuery("#gamer_search_module_container").css("visibility") == "hidden"  ){
				
				jQuery("#manager_search_module_container").css("visibility","hidden");
				jQuery("#games_search_module_container").css("visibility","hidden");
				jQuery("#gamer_search_module_container").css("visibility","visible");
			}else{
			return;
			}
		}else{
			//have to throw error here
			return;
		}
}
function displayManagers(){
	if(jQuery("#gamer_search_module_container") && jQuery("#manager_search_module_container") && jQuery("#games_search_module_container")){
			
			if(jQuery("#manager_search_module_container").css("visibility") == "hidden" && jQuery("#games_search_module_container").css("visibility") == "hidden" && jQuery("#gamer_search_module_container").css("visibility") == "visible" || jQuery("#manager_search_module_container").css("visibility") == "hidden" && jQuery("#games_search_module_container").css("visibility") == "visible" && jQuery("#gamer_search_module_container").css("visibility") == "hidden"  ){
				
				jQuery("#games_search_module_container").css("visibility","hidden");
				jQuery("#gamer_search_module_container").css("visibility","hidden");
				jQuery("#manager_search_module_container").css("visibility","visible");
			}else{
			return;
			}
		}else{
			//have to throw error here
			return;
		}
}
function displayGames(){

	if(jQuery("#gamer_search_module_container") && jQuery("#manager_search_module_container") && jQuery("#games_search_module_container")){
			
			if(jQuery("#manager_search_module_container").css("visibility") == "hidden" && jQuery("#games_search_module_container").css("visibility") == "hidden" && jQuery("#gamer_search_module_container").css("visibility") == "visible" || jQuery("#manager_search_module_container").css("visibility") == "visible" && jQuery("#games_search_module_container").css("visibility") == "hidden" && jQuery("#gamer_search_module_container").css("visibility") == "hidden"  ){
				
				jQuery("#games_search_module_container").css("visibility","visible");
				jQuery("#gamer_search_module_container").css("visibility","hidden");
				jQuery("#manager_search_module_container").css("visibility","hidden");
			}else{
			return;
			}
		}else{
			//have to throw error here
			return;
		}
}