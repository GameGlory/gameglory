jQuery(document).ready(function(){
	
	if(window.location.hash != ""){
		if(window.location.hash == "#gamers")
			displayGamers();
		else if(window.location.hash == "#managers")
			displayManagers();
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
});
function displayGamers(){

	if(jQuery("#gamer_search_module_container") && jQuery("#manager_search_module_container")){
			
			if(jQuery("#manager_search_module_container").css("display") == "block" && jQuery("#gamer_search_module_container").css("display") == "none" ){
				
				jQuery("#manager_search_module_container").css("display","none");
				jQuery("#gamer_search_module_container").css("display","block");
			}else{
			return;
			}
		}else{
			//have to throw error here
			return;
		}
}
function displayManagers(){
	if(jQuery("#gamer_search_module_container") && jQuery("#manager_search_module_container")){
			
			if(jQuery("#gamer_search_module_container").css("display") == "block" && jQuery("#manager_search_module_container").css("display") == "none" ){
				
				jQuery("#gamer_search_module_container").css("display","none");
				jQuery("#manager_search_module_container").css("display","block");
			}else{
			return;
			}
		}else{
			//have to throw error here
			return;
		}
}
