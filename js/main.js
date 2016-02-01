var Page = {
	
	PageHeader : {
		
		Header : {
	
			Events : {
				
				hover : function(element){
					jQuery(element).on("mouseover", function(){
						if(jQuery(element).parents().children().is("#page_header_console_nav_module") || jQuery(element).parents().children().is("#page_header_main_nav_module")){
						if(jQuery(element).is("ul")){
							if(element == "#page_header_sony_console_list"){
								if(jQuery(element).css("display") == "block"){
									jQuery(this).css("display","block");
								}
							}
						}
						}
					});
					jQuery(element).on("mouseenter", function(){
						
						if(element == "#page_header_sony_console_list"){
							clearTimeout(jQuery("#page_header_sony_consoles").data('timeoutId'));
							return;
							
						}else if(element == "#page_header_ps4_menu"){
							clearTimeout(jQuery("#page_header_ps4_console").data('timeoutId'));
							
							jQuery("#page_header_ps3_console").animate({opacity: 0.2},200);
							return;
							
						}else if(element == "#page_header_ps3_menu"){
							clearTimeout(jQuery("#page_header_ps3_console").data('timeoutId'));
							jQuery("#page_header_ps4_console" ).animate({opacity: 0.2},200);
							return;
							
						}else if(element == "#page_header_ps4_gamers" || element == "#page_header_ps4_leagues" || element == "#page_header_ps4_leaderboards" || element == "#page_header_ps3_gamers" || element == "#page_header_ps3_leagues" || element == "#page_header_ps3_leaderboards" ){
							clearTimeout(jQuery("#page_header_ps4_leagues").data('timeoutId'));
								clearTimeout(jQuery("#page_header_ps4_gamers").data('timeoutId'));
								clearTimeout(jQuery("#page_header_ps4_leaderboards").data('timeoutId'));
								clearTimeout(jQuery("#page_header_ps3_leagues").data('timeoutId'));
								clearTimeout(jQuery("#page_header_ps3_gamers").data('timeoutId'));
								clearTimeout(jQuery("#page_header_ps3_leaderboards").data('timeoutId'));
						return;
						}
						else if(element == "#page_header_microsoft_console_list"){
						
							clearTimeout(jQuery("#page_header_microsoft_consoles").data('timeoutId'));
							
							return;
						}else if(element == "#page_header_xboxone_menu"){
							clearTimeout(jQuery("#page_header_xboxone_console").data('timeoutId'));
							
							jQuery("#page_header_xbox360_console").animate({opacity: 0.2},200);
							return;
						}else if(element == "#page_header_xbox360_menu"){
							clearTimeout(jQuery("#page_header_xbox360_console").data('timeoutId'));
							jQuery("#page_header_xboxone_console" ).animate({opacity: 0.2},200);
							return;
						}else if(element == "#page_header_xboxone_gamers" || element == "#page_header_xboxone_leagues" || element == "#page_header_xboxone_leaderboards" || element == "#page_header_xbox360_gamers" || element == "#page_header_xbox360_leagues" || element == "#page_header_xbox360_leaderboards" ){
							clearTimeout(jQuery("#page_header_xboxone_leagues").data('timeoutId'));
								clearTimeout(jQuery("#page_header_xboxone_gamers").data('timeoutId'));
								clearTimeout(jQuery("#page_header_xboxone_leaderboards").data('timeoutId'));
								clearTimeout(jQuery("#page_header_xbox360_leagues").data('timeoutId'));
								clearTimeout(jQuery("#page_header_xbox360_gamers").data('timeoutId'));
								clearTimeout(jQuery("#page_header_xbox360_leaderboards").data('timeoutId'));
							return;
						}else if(element == "#page_header_observe_menu" ){
							
							clearTimeout(jQuery("#page_header_observe").data('timeoutId'));
							
								return;
						}else if(element == "#page_header_observe_menu_gameglory"){
							
							clearTimeout(jQuery("#page_header_observe_menu_twitch").data('timeoutId'));
							
						}else if(element == "#page_header_observe_menu_twitch"){
							clearTimeout(jQuery("#page_header_observe_menu_gameglory").data('timeoutId'));
							clearTimeout(jQuery("#page_header_observe_menu_youtube").data('timeoutId'));
						}else if(element == "#page_header_observe_menu_youtube"){
							clearTimeout(jQuery("#page_header_observe_menu_twitch").data('timeoutId'));
							clearTimeout(jQuery("#page_header_observe_menu_recent_videos").data('timeoutId'));
							
						}else if(element == "#page_header_observe_menu_recent_videos"){
							clearTimeout(jQuery("#page_header_observe_menu_youtube").data('timeoutId'));
							
							
						}
						else if(element == "#page_header_glory_menu" ){
							clearTimeout(jQuery("#page_header_glory").data('timeoutId'));
								
						}else if(element == "#page_header_glory_menu_leagues" ){
							clearTimeout(jQuery("#page_header_glory_menu_stats").data('timeoutId'));
								
						}else if(element == "#page_header_glory_menu_stats" ){
							clearTimeout(jQuery("#page_header_glory_menu_leagues").data('timeoutId'));
							clearTimeout(jQuery("#page_header_glory_menu_ranks").data('timeoutId'));
						}
						else if(element == "#page_header_glory_menu_ranks" ){
							clearTimeout(jQuery("#page_header_glory_menu_stats").data('timeoutId'));
							clearTimeout(jQuery("#page_header_glory_menu_leaderboards").data('timeoutId'));
								
						}else if(element == "#page_header_glory_menu_leaderboards" ){
							clearTimeout(jQuery("#page_header_glory_menu_ranks").data('timeoutId'));
							
						}
						if(jQuery(element).next().is("ul")){
							if(element == "#page_header_sony_consoles"){
								clearTimeout(jQuery("#page_header_ps4_console").data('timeoutId'));
								clearTimeout(jQuery("#page_header_ps3_console").data('timeoutId'));
								jQuery("#page_header_microsoft_consoles , #page_header_observe , #page_header_glory, #page_header_login" ).animate({opacity: 0.2},200);
								jQuery(element).next().css({position: "absolute", display: "block"});
								
							}else if(element == "#page_header_ps4_console" || element == "#page_header_ps3_console" ){
								//
								//
								jQuery(element).next().css({position: "absolute", display: "block"});
								if(element == "#page_header_ps4_console"){
									
									clearTimeout(jQuery("#page_header_ps4_gamers").data('timeoutId'));
									jQuery("#page_header_ps4_console" ).animate({opacity: 1},100);
									clearTimeout(jQuery("#page_header_ps3_console").data('timeoutId'));
									jQuery("#page_header_ps3_console" ).animate({opacity: 0.2},200);
									jQuery("#page_header_ps3_console").next().css("display","none");
									
								}
								else{
									jQuery("#page_header_ps3_console" ).animate({opacity: 1},100);
									clearTimeout(jQuery("#page_header_ps4_console").data('timeoutId'));
									jQuery("#page_header_ps4_console").animate({opacity: 0.2},200);
									jQuery("#page_header_ps4_console").next().css("display","none");
								}
							}else if(element == "#page_header_microsoft_consoles"){
								clearTimeout(jQuery("#page_header_xboxone_console").data('timeoutId'));
								clearTimeout(jQuery("#page_header_xbox360_console").data('timeoutId'));
								jQuery("#page_header_sony_consoles , #page_header_observe , #page_header_glory , #page_header_login" ).animate({opacity: 0.2},200);
								jQuery(element).next().css({position: "absolute", display: "block"});
								
								
							}else if(element == "#page_header_xboxone_console" || element == "#page_header_xbox360_console" ){
								jQuery(element).next().css({position: "absolute", display: "block"});
								
								if(element == "#page_header_xboxone_console"){
									
									clearTimeout(jQuery("#page_header_xboxone_gamers").data('timeoutId'));
									jQuery("#page_header_xboxone_console" ).animate({opacity: 1},100);
									clearTimeout(jQuery("#page_header_xbox360_console").data('timeoutId'));
									jQuery("#page_header_xbox360_console" ).animate({opacity: 0.2},200);
									jQuery("#page_header_xbox360_console").next().css("display","none");
									
								}
								else{
									jQuery("#page_header_xbox360_console" ).animate({opacity: 1},100);
									clearTimeout(jQuery("#page_header_xboxone_console").data('timeoutId'));
									jQuery("#page_header_xboxone_console").animate({opacity: 0.2},200);
									jQuery("#page_header_xboxone_console").next().css("display","none");
								}
							}
							
							else if(element == "#page_header_observe"){
								clearTimeout(jQuery("#page_header_observe_menu_gameglory").data('timeoutId'));
								//clearTimeout(jQuery("#page_header_xbox360_console").data('timeoutId'));
								jQuery("#page_header_sony_consoles , #page_header_microsoft_consoles , #page_header_glory , #page_header_login" ).animate({opacity: 0.2},200);
								jQuery(element).next().css({position: "absolute", display: "block"});
								
								
							}else if(element == "#page_header_glory"){
								//clearTimeout(jQuery("#page_header_xboxone_console").data('timeoutId'));
								//clearTimeout(jQuery("#page_header_xbox360_console").data('timeoutId'));
								jQuery("#page_header_sony_consoles , #page_header_microsoft_consoles , #page_header_observe , #page_header_login" ).animate({opacity: 0.2},200);
								jQuery(element).next().css({position: "absolute", display: "block"});
								
								
							}
						}
							if(jQuery(element).parents().is("#page_header_ps4_menu")){
								jQuery(this).parent().css("background","transparent");
								jQuery(this).parent().css("background-color","#5dc21c");
								jQuery(this).css("color","#000000");
							}else if(jQuery(element).parents().is("#page_header_ps3_menu")){
								jQuery(this).parent().css("background","transparent");
								jQuery(this).parent().css("background-color","#5dc21c");
								jQuery(this).css("color","#000000");
							}else if(jQuery(element).parents().is("#page_header_xboxone_menu")){
								jQuery(this).parent().css("background","transparent");
								jQuery(this).parent().css("background-color","#5dc21c");
							}else if(jQuery(element).parents().is("#page_header_xbox360_menu")){
								jQuery(this).parent().css("background","transparent");
								jQuery(this).parent().css("background-color","#5dc21c");
							}else if(jQuery(element).parents().is("#page_header_observe_menu")){
								jQuery(this).parent().css("background","transparent");
								jQuery(this).parent().css("background-color","#5dc21c");
							}else if(jQuery(element).parents().is("#page_header_glory_menu")){
								jQuery(this).parent().css("background","transparent");
								jQuery(this).parent().css("background-color","#5dc21c");
							}
							
					});	
					
					jQuery(element).on("mouseout", function(){
						
						if(element == "#page_header_sony_consoles"){
							
							var t = setTimeout(function(){
							jQuery(element).next().fadeOut(50,function(){
								jQuery(this).css("display" , "none");
								jQuery("#page_header_microsoft_consoles , #page_header_observe , #page_header_glory , #page_header_login" ).animate({opacity: 1},100);
							});
						},100);
							jQuery(this).data("timeoutId",t);
							
						}else if(element == "#page_header_ps4_console"){
							
							var t = setTimeout(function(){
							jQuery(element).next().fadeOut(50,function(){
								jQuery(element).parent().parent().css("display" , "none");
								jQuery(this).css("display" , "none");
								jQuery("#page_header_ps3_console" ).animate({opacity: 1},100);
								jQuery("#page_header_microsoft_consoles , #page_header_observe , #page_header_glory , #page_header_login" ).animate({opacity: 1},100);
							});
						},100);
							jQuery(this).data("timeoutId",t);
						}else if(element == "#page_header_ps3_console"){
							
							var t = setTimeout(function(){
							jQuery(element).next().fadeOut(50,function(){
								jQuery(element).parent().parent().css("display" , "none");
								jQuery(this).css("display" , "none");
								jQuery("#page_header_ps4_console" ).animate({opacity: 1},100);
								jQuery("#page_header_microsoft_consoles , #page_header_observe , #page_header_glory , #page_header_login" ).animate({opacity: 1},100);
							});
						},100);
							jQuery(this).data("timeoutId",t);
						}
						if(element == "#page_header_ps4_gamers" ){
							jQuery("#page_header_ps4_gamers").parent().css("background","linear-gradient(90deg, #0072CE,#004C87 )");
								jQuery("#page_header_ps4_gamers").css("color","#FFFFFF");
								var t = setTimeout(function(){
								jQuery(element).parent().parent().fadeOut(50,function(){
								//jQuery(element).parent().css("display" , "none");
								//jQuery(element).parent().parent().css("display" , "none");
								jQuery(element).parent().parent().parent().parent().css("display" , "none");
								jQuery("#page_header_ps3_console" ).animate({opacity: 1},100);
								jQuery("#page_header_microsoft_consoles , #page_header_observe , #page_header_glory , #page_header_login" ).animate({opacity: 1},100);
								
							});
						},100);
							jQuery(this).data("timeoutId",t);
							
						}else if(element == "#page_header_ps4_leagues"){
							jQuery("#page_header_ps4_leagues").parent().css("background","linear-gradient(90deg, #0072CE,#004C87 )");
								jQuery("#page_header_ps4_leagues").css("color","#FFFFFF");
								var t = setTimeout(function(){
								jQuery(element).parent().parent().fadeOut(50,function(){
								//jQuery(element).parent().css("display" , "none");
								//jQuery(element).parent().parent().css("display" , "none");
								jQuery(element).parent().parent().parent().parent().css("display" , "none");
								jQuery("#page_header_ps3_console" ).animate({opacity: 1},100);
								jQuery("#page_header_microsoft_consoles , #page_header_observe , #page_header_glory , #page_header_login" ).animate({opacity: 1},100);
								
							});
						},100);
						jQuery(this).data("timeoutId",t);
						}
						else if(element == "#page_header_ps4_leaderboards"){
							jQuery("#page_header_ps4_leaderboards").parent().css("background","linear-gradient(90deg, #0072CE,#004C87 )");
								jQuery("#page_header_ps4_leaderboards").css("color","#FFFFFF");
								var t = setTimeout(function(){
								jQuery(element).parent().parent().fadeOut(50,function(){
								//jQuery(element).parent().css("display" , "none");
								//jQuery(element).parent().parent().css("display" , "none");
								jQuery(element).parent().parent().parent().parent().css("display" , "none");
								jQuery("#page_header_ps3_console" ).animate({opacity: 1},100);
								jQuery("#page_header_microsoft_consoles , #page_header_observe , #page_header_glory , #page_header_login" ).animate({opacity: 1},100);
								
							});
						},100);
						jQuery(this).data("timeoutId",t);
						}else if(element == "#page_header_ps3_gamers"){
							jQuery("#page_header_ps3_gamers").parent().css("background","linear-gradient(90deg, #0072CE,#004C87 )");
								jQuery("#page_header_ps3_gamers").css("color","#FFFFFF");
								var t = setTimeout(function(){
								jQuery(element).parent().parent().fadeOut(50,function(){
								//jQuery(element).parent().css("display" , "none");
								//jQuery(element).parent().parent().css("display" , "none");
								jQuery(element).parent().parent().parent().parent().css("display" , "none");
								jQuery("#page_header_ps3_console" ).animate({opacity: 1},100);
								jQuery("#page_header_microsoft_consoles , #page_header_observe , #page_header_glory ,#page_header_login" ).animate({opacity: 1},100);
								
							});
						},100);
						jQuery(this).data("timeoutId",t);
						}else if(element == "#page_header_ps3_leagues"){
							jQuery("#page_header_ps3_leagues").parent().css("background","linear-gradient(90deg, #0072CE,#004C87 )");
								jQuery("#page_header_ps3_leagues").css("color","#FFFFFF");
								var t = setTimeout(function(){
								jQuery(element).parent().parent().fadeOut(50,function(){
								//jQuery(element).parent().css("display" , "none");
								//jQuery(element).parent().parent().css("display" , "none");
								jQuery(element).parent().parent().parent().parent().css("display" , "none");
								jQuery("#page_header_ps3_console" ).animate({opacity: 1},100);
								jQuery("#page_header_microsoft_consoles , #page_header_observe , #page_header_glory , #page_header_login" ).animate({opacity: 1},100);
								
							});
						},100);
						jQuery(this).data("timeoutId",t);
						}else if(element == "#page_header_ps3_leaderboards"){
							jQuery("#page_header_ps3_leaderboards").parent().css("background","linear-gradient(90deg, #0072CE,#004C87 )");
								jQuery("#page_header_ps3_leaderboards").css("color","#FFFFFF");
								var t = setTimeout(function(){
								jQuery(element).parent().parent().fadeOut(50,function(){
								//jQuery(element).parent().css("display" , "none");
								//jQuery(element).parent().parent().css("display" , "none");
								jQuery(element).parent().parent().parent().parent().css("display" , "none");
								jQuery("#page_header_ps3_console" ).animate({opacity: 1},100);
								jQuery("#page_header_microsoft_consoles , #page_header_observe , #page_header_glory , #page_header_login" ).animate({opacity: 1},100);
								
							});
						},100);
						jQuery(this).data("timeoutId",t);
						}
						
						
						
						
						
						
						
						else if(element == "#page_header_microsoft_consoles"){
							
							var t = setTimeout(function(){
							jQuery(element).next().fadeOut(50,function(){
								jQuery(this).css("display" , "none");
								jQuery("#page_header_sony_consoles , #page_header_observe , #page_header_glory , #page_header_login" ).animate({opacity: 1},100);
							});
						},100);
							jQuery(this).data("timeoutId",t);
							
						}else if(element == "#page_header_xboxone_console"){
							
							var t = setTimeout(function(){
							jQuery(element).next().fadeOut(50,function(){
								jQuery(element).parent().parent().css("display" , "none");
								jQuery(this).css("display" , "none");
								jQuery("#page_header_xbox360_console" ).animate({opacity: 1},100);
								jQuery("#page_header_sony_consoles , #page_header_observe , #page_header_glory , #page_header_login" ).animate({opacity: 1},100);
							});
						},100);
							jQuery(this).data("timeoutId",t);
						}else if(element == "#page_header_xbox360_console"){
							
							var t = setTimeout(function(){
							jQuery(element).next().fadeOut(50,function(){
								jQuery(element).parent().parent().css("display" , "none");
								jQuery(this).css("display" , "none");
								jQuery("#page_header_xboxone_console" ).animate({opacity: 1},100);
								jQuery("#page_header_sony_consoles , #page_header_observe , #page_header_glory , #page_header_login" ).animate({opacity: 1},100);
							});
						},100);
							jQuery(this).data("timeoutId",t);
						}
						
						
						else if(element == "#page_header_xboxone_gamers" ){
							jQuery("#page_header_xboxone_gamers").parent().css("background","linear-gradient(90deg, #0072CE,#004C87 )");
								jQuery("#page_header_xboxone_gamers").css("color","#FFFFFF");
								var t = setTimeout(function(){
								jQuery(element).parent().parent().fadeOut(50,function(){
								//jQuery(element).parent().css("display" , "none");
								//jQuery(element).parent().parent().css("display" , "none");
								jQuery(element).parent().parent().parent().parent().css("display" , "none");
								jQuery("#page_header_xbox360_console" ).animate({opacity: 1},100);
								jQuery("#page_header_sony_consoles , #page_header_observe , #page_header_glory , #page_header_login" ).animate({opacity: 1},100);
								
							});
						},100);
							jQuery(this).data("timeoutId",t);
							
						}else if(element == "#page_header_xboxone_leagues"){
							jQuery("#page_header_xboxone_leagues").parent().css("background","linear-gradient(90deg, #0072CE,#004C87 )");
								jQuery("#page_header_xboxone_leagues").css("color","#FFFFFF");
								var t = setTimeout(function(){
								jQuery(element).parent().parent().fadeOut(50,function(){
								//jQuery(element).parent().css("display" , "none");
								//jQuery(element).parent().parent().css("display" , "none");
								jQuery(element).parent().parent().parent().parent().css("display" , "none");
								jQuery("#page_header_xbox360_console" ).animate({opacity: 1},100);
								jQuery("#page_header_sony_consoles , #page_header_observe , #page_header_glory , #page_header_login" ).animate({opacity: 1},100);
								
							});
						},100);
						jQuery(this).data("timeoutId",t);
						}
						else if(element == "#page_header_xboxone_leaderboards"){
							jQuery("#page_header_xboxone_leaderboards").parent().css("background","linear-gradient(90deg, #0072CE,#004C87 )");
								jQuery("#page_header_xboxone_leaderboards").css("color","#FFFFFF");
								var t = setTimeout(function(){
								jQuery(element).parent().parent().fadeOut(50,function(){
								//jQuery(element).parent().css("display" , "none");
								//jQuery(element).parent().parent().css("display" , "none");
								jQuery(element).parent().parent().parent().parent().css("display" , "none");
								jQuery("#page_header_xbox360_console" ).animate({opacity: 1},100);
								jQuery("#page_header_sony_consoles , #page_header_observe , #page_header_glory , #page_header_login" ).animate({opacity: 1},100);
								
							});
						},100);
						jQuery(this).data("timeoutId",t);
						}else if(element == "#page_header_xbox360_gamers"){
							jQuery("#page_header_xbox360_gamers").parent().css("background","linear-gradient(90deg, #0072CE,#004C87 )");
								jQuery("#page_header_xbox360_gamers").css("color","#FFFFFF");
								var t = setTimeout(function(){
								jQuery(element).parent().parent().fadeOut(50,function(){
								//jQuery(element).parent().css("display" , "none");
								//jQuery(element).parent().parent().css("display" , "none");
								jQuery(element).parent().parent().parent().parent().css("display" , "none");
								jQuery("#page_header_xbox360_console" ).animate({opacity: 1},100);
								jQuery("#page_header_microsoft_consoles , #page_header_observe , #page_header_glory , #page_header_login" ).animate({opacity: 1},100);
								
							});
						},100);
						jQuery(this).data("timeoutId",t);
						}else if(element == "#page_header_xbox360_leagues"){
							jQuery("#page_header_xbox360_leagues").parent().css("background","linear-gradient(90deg, #0072CE,#004C87 )");
								jQuery("#page_header_xbox360_leagues").css("color","#FFFFFF");
								var t = setTimeout(function(){
								jQuery(element).parent().parent().fadeOut(50,function(){
								//jQuery(element).parent().css("display" , "none");
								//jQuery(element).parent().parent().css("display" , "none");
								jQuery(element).parent().parent().parent().parent().css("display" , "none");
								jQuery("#page_header_xbox360_console" ).animate({opacity: 1},100);
								jQuery("#page_header_microsoft_consoles , #page_header_observe , #page_header_glory , #page_header_login" ).animate({opacity: 1},100);
								
							});
						},100);
						jQuery(this).data("timeoutId",t);
						}else if(element == "#page_header_xbox360_leaderboards"){
							jQuery("#page_header_xbox360_leaderboards").parent().css("background","linear-gradient(90deg, #0072CE,#004C87 )");
								jQuery("#page_header_xbox360_leaderboards").css("color","#FFFFFF");
								var t = setTimeout(function(){
								jQuery(element).parent().parent().fadeOut(50,function(){
								//jQuery(element).parent().css("display" , "none");
								//jQuery(element).parent().parent().css("display" , "none");
								jQuery(element).parent().parent().parent().parent().css("display" , "none");
								jQuery("#page_header_xbox360_console" ).animate({opacity: 1},100);
								jQuery("#page_header_sony_consoles , #page_header_observe , #page_header_glory , #page_header_login" ).animate({opacity: 1},100);
								
							});
						},100);
						jQuery(this).data("timeoutId",t);
						}else if(element == "#page_header_observe"){
							
							var t = setTimeout(function(){
							jQuery(element).next().fadeOut(50,function(){
								jQuery(this).css("display" , "none");
								jQuery("#page_header_microsoft_consoles , #page_header_sony_consoles, #page_header_glory , #page_header_login" ).animate({opacity: 1},100);
							});
						},100);
							jQuery(this).data("timeoutId",t);
							
						}else if(element == "#page_header_observe_menu_gameglory"){
							jQuery("#page_header_observe_menu_gameglory").parent().css("background","linear-gradient(90deg,#004C87 ,#0072CE)");
								jQuery("#page_header_observe_menu_gameglory").css("color","#FFFFFF");
								var t = setTimeout(function(){
								jQuery(element).parent().parent().fadeOut(50,function(){
								//jQuery(element).parent().css("display" , "none");
								//jQuery(element).parent().parent().css("display" , "none");
								jQuery("#page_header_microsoft_consoles , #page_header_sony_consoles,#page_header_observe , #page_header_glory , #page_header_login" ).animate({opacity: 1},100);
								
							});
						},100);
						jQuery(this).data("timeoutId",t);
						}
						else if(element == "#page_header_observe_menu_twitch"){
							jQuery("#page_header_observe_menu_twitch").parent().css("background","linear-gradient(90deg,#004C87 ,#0072CE)");
								jQuery("#page_header_observe_menu_twitch").css("color","#FFFFFF");
								var t = setTimeout(function(){
								jQuery(element).parent().parent().fadeOut(50,function(){
								//jQuery(element).parent().css("display" , "none");
								//jQuery(element).parent().parent().css("display" , "none");
							
								
								jQuery("#page_header_microsoft_consoles ,#page_header_sony_consoles, #page_header_observe , #page_header_glory , #page_header_login" ).animate({opacity: 1},100);
								
							});
						},100);
						jQuery(this).data("timeoutId",t);
						}else if(element == "#page_header_observe_menu_youtube"){
							jQuery("#page_header_observe_menu_youtube").parent().css("background","linear-gradient(90deg,#004C87 ,#0072CE)");
								jQuery("#page_header_observe_menu_youtube").css("color","#FFFFFF");
								var t = setTimeout(function(){
								jQuery(element).parent().parent().fadeOut(50,function(){
								//jQuery(element).parent().css("display" , "none");
								//jQuery(element).parent().parent().css("display" , "none");
							
								
								jQuery("#page_header_microsoft_consoles , #page_header_sony_consoles,#page_header_observe , #page_header_glory , #page_header_login" ).animate({opacity: 1},100);
								
							});
						},100);
						jQuery(this).data("timeoutId",t);
						}else if(element == "#page_header_observe_menu_recent_videos"){
							jQuery("#page_header_observe_menu_recent_videos").parent().css("background","linear-gradient(90deg,#004C87 ,#0072CE)");
								jQuery("#page_header_observe_menu_recent_videos").css("color","#FFFFFF");
								var t = setTimeout(function(){
								jQuery(element).parent().parent().fadeOut(50,function(){
								//jQuery(element).parent().css("display" , "none");
								//jQuery(element).parent().parent().css("display" , "none");
								jQuery("#page_header_microsoft_consoles , #page_header_sony_consoles,#page_header_observe , #page_header_glory , #page_header_login" ).animate({opacity: 1},100);
								
							});
						},100);
						jQuery(this).data("timeoutId",t);
						}		
						else if(element == "#page_header_glory"){
							
							var t = setTimeout(function(){
							jQuery(element).next().fadeOut(50,function(){
								jQuery(this).css("display" , "none");
								jQuery("#page_header_microsoft_consoles , #page_header_sony_consoles, #page_header_observe , #page_header_login" ).animate({opacity: 1},100);
							});
						},100);
							jQuery(this).data("timeoutId",t);
							
						}else if(element == "#page_header_glory_menu_leagues"){
							jQuery("#page_header_glory_menu_leagues").parent().css("background","linear-gradient(90deg,#004C87 ,#0072CE)");
								jQuery("#page_header_glory_menu_leagues").css("color","#FFFFFF");
								var t = setTimeout(function(){
								jQuery(element).parent().parent().fadeOut(50,function(){
								//jQuery(element).parent().css("display" , "none");
								//jQuery(element).parent().parent().css("display" , "none");
								jQuery("#page_header_microsoft_consoles , #page_header_sony_consoles,#page_header_observe , #page_header_glory , #page_header_login" ).animate({opacity: 1},100);
								
							});
						},100);
						jQuery(this).data("timeoutId",t);
						}
						else if(element == "#page_header_glory_menu_stats"){
							jQuery("#page_header_glory_menu_stats").parent().css("background","linear-gradient(90deg,#004C87 ,#0072CE)");
								jQuery("#page_header_glory_menu_stats").css("color","#FFFFFF");
								var t = setTimeout(function(){
								jQuery(element).parent().parent().fadeOut(50,function(){
								//jQuery(element).parent().css("display" , "none");
								//jQuery(element).parent().parent().css("display" , "none");
							
								
								jQuery("#page_header_microsoft_consoles ,#page_header_sony_consoles, #page_header_observe , #page_header_glory , #page_header_login" ).animate({opacity: 1},100);
								
							});
						},100);
						jQuery(this).data("timeoutId",t);
						}else if(element == "#page_header_glory_menu_ranks"){
							jQuery("#page_header_glory_menu_ranks").parent().css("background","linear-gradient(90deg,#004C87 ,#0072CE)");
								jQuery("#page_header_glory_menu_ranks").css("color","#FFFFFF");
								var t = setTimeout(function(){
								jQuery(element).parent().parent().fadeOut(50,function(){
								//jQuery(element).parent().css("display" , "none");
								//jQuery(element).parent().parent().css("display" , "none");
							
								
								jQuery("#page_header_microsoft_consoles ,#page_header_sony_consoles, #page_header_observe , #page_header_glory , #page_header_login" ).animate({opacity: 1},100);
								
							});
						},100);
						jQuery(this).data("timeoutId",t);
						}else if(element == "#page_header_glory_menu_leaderboards"){
							jQuery("#page_header_glory_menu_leaderboards").parent().css("background","linear-gradient(90deg,#004C87 ,#0072CE)");
								jQuery("#page_header_glory_menu_leaderboards").css("color","#FFFFFF");
								var t = setTimeout(function(){
								jQuery(element).parent().parent().fadeOut(50,function(){
								//jQuery(element).parent().css("display" , "none");
								//jQuery(element).parent().parent().css("display" , "none");
								jQuery("#page_header_microsoft_consoles ,#page_header_sony_consoles , #page_header_observe , #page_header_glory , #page_header_login" ).animate({opacity: 1},100);
								
							});
						},100);
						jQuery(this).data("timeoutId",t);
						}
					});
				},
				click : function(element){
					
					if(jQuery(element).is("a")){
						jQuery(element).parent().prev().css("visibility","hidden");
						jQuery(element).parent().prev().prev().css("visibility","hidden");
						jQuery(element).next().css({position:"relative",display:"inline-block",bottom:"290%"});
					}
			}
			},
			
		},
		Footer : {
			Events:{
				click: function(){
					jQuery("#page_header_footer_officials").on("click",function(){
						
						window.location.hash = "#managers";
		
					});
				}
			}
		}
	},
	
	PageBody : {
		
	},
	PageFooter : {
		
	}
};

jQuery(document).ready(function(){
	Page.PageHeader.Header.Events.hover("#page_header_ps4_gamers");
	Page.PageHeader.Header.Events.hover("#page_header_ps4_leagues");
	Page.PageHeader.Header.Events.hover("#page_header_ps4_leaderboards");
	Page.PageHeader.Header.Events.hover("#page_header_ps3_gamers");
	Page.PageHeader.Header.Events.hover("#page_header_ps3_leagues");
	Page.PageHeader.Header.Events.hover("#page_header_ps3_leaderboards");
	
		Page.PageHeader.Header.Events.hover("#page_header_xboxone_gamers");
	Page.PageHeader.Header.Events.hover("#page_header_xboxone_leagues");
	Page.PageHeader.Header.Events.hover("#page_header_xboxone_leaderboards");
	Page.PageHeader.Header.Events.hover("#page_header_xbox360_gamers");
	Page.PageHeader.Header.Events.hover("#page_header_xbox360_leagues");
	Page.PageHeader.Header.Events.hover("#page_header_xbox360_leaderboards");
	Page.PageHeader.Header.Events.hover("#page_header_ps4_menu");
	Page.PageHeader.Header.Events.hover("#page_header_ps3_menu");
	Page.PageHeader.Header.Events.hover("#page_header_sony_consoles");
	Page.PageHeader.Header.Events.hover("#page_header_ps4_console");
	Page.PageHeader.Header.Events.hover("#page_header_ps3_console");
	Page.PageHeader.Header.Events.hover("#page_header_ps4_menu li a");
	Page.PageHeader.Header.Events.hover("#page_header_ps3_menu li a");
	Page.PageHeader.Header.Events.hover("#page_header_microsoft_consoles");
	Page.PageHeader.Header.Events.hover("#page_header_xboxone_console");
	Page.PageHeader.Header.Events.hover("#page_header_xbox360_console");
	Page.PageHeader.Header.Events.hover("#page_header_xboxone_menu li a");
	Page.PageHeader.Header.Events.hover("#page_header_xbox360_menu li a");
	Page.PageHeader.Header.Events.hover("#page_header_xboxone_menu");
	Page.PageHeader.Header.Events.hover("#page_header_xbox360_menu");
	
	Page.PageHeader.Header.Events.hover("#page_header_sony_console_list");
	Page.PageHeader.Header.Events.hover("#page_header_microsoft_console_list");
	
	Page.PageHeader.Header.Events.hover("#page_header_observe");
	Page.PageHeader.Header.Events.hover("#page_header_observe_menu");

	Page.PageHeader.Header.Events.hover("#page_header_observe_menu_gameglory");
	Page.PageHeader.Header.Events.hover("#page_header_observe_menu_youtube");
	Page.PageHeader.Header.Events.hover("#page_header_observe_menu_recent_videos");
	Page.PageHeader.Header.Events.hover("#page_header_observe_menu_twitch");

	Page.PageHeader.Header.Events.hover("#page_header_glory");
	Page.PageHeader.Header.Events.hover("#page_header_glory_menu");
	Page.PageHeader.Header.Events.hover("#page_header_glory_menu_leagues");
	Page.PageHeader.Header.Events.hover("#page_header_glory_menu_stats");
	Page.PageHeader.Header.Events.hover("#page_header_glory_menu_ranks");
	Page.PageHeader.Header.Events.hover("#page_header_glory_menu_leaderboards");
	
});
