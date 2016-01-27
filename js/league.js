var LeagueForm = {
 
 	number_of_teams_number_text_box :"#number_of_teams_number_text_box",
	draft_start_date_date_box : "#draft_start_date_date_box",
	draft_end_date_date_box   : "#draft_end_date_date_box",
	league_name_text_box     : "#league_name_text_box",
	form					 : "#create_league_form",
	type_container           : "#league_type_container",
	draft_type_container     : "#league_draft_type_container",
	access_container         : "#league_access_container",
	draft_date_container     : "#league_draft_date_container",
	games_container          : "#league_games_container",
	selected_games           : [],
	
	Ajax : {
		
		league_name : "",
		verifyLeagueName :function(event,element){
			try{
				
				
					
					
			
			}catch(ex){
				console.log(ex);
			}
		},
		Events : {
			
			
			blur: function(){
				jQuery(document).on("blur",LeagueForm.league_name_text_box,function(){
					
					
					if(jQuery(LeagueForm.league_name_text_box).prop("value") == "")
						this.league_name = "";
					
				});
			},
			keypress : function(){
				
				jQuery(document).on("keypress",LeagueForm.league_name_text_box,function(){
				
					if(event.keyCode >= 65 || event.keyCode <= 117){
						this.league_name += String.fromCharCode(event.keyCode);
						Ajax.makeRequest("get","/php/league.php?league_name="+this.league_name+"&league_name_valid=true&ajax=true",LeagueForm.league_name_text_box);
					}
				});
				
			},
			keydown : function(){
				
				jQuery(document).on("keydown" ,LeagueForm.league_name_text_box,function(){
					
					
					if(event.keyCode == 8){
						if(thisleague_name.length == 0)
							return;
						else if(jQuery(LeagueForm.league_name_text_box).prop("value") == ""){
								
								this.league_name = "";
								return;
						}
						this.league_name = Ajax.LeagueAjax.league_name.substring(0,this.league_name.length-1);
					}
				});
				
			}
		}	
	},
	toggleFieldCollapse : function(element){
		
		if(jQuery(element).css("display") == "none")
			jQuery(element).css("display","block");
		else
			jQuery(element).css("display","none");
	},
	verifyLeagueForm : function(){
		var errors = [];
		if(jQuery(this.league_name_text_box).prop("value") == "")
			errors.push("League Name cannot be left blank");
				if(jQuery(this.CheckBoxes.online_draft_check_box).prop("checked") == false && jQuery(this.CheckBoxes.auto_draft_check_box).prop("checked") == false && jQuery(this.CheckBoxes.raffle_draft_check_box).prop("checked") == false)
					errors.push("A Draft Type must be selected.");
				if(jQuery(this.draft_start_date_date_box).prop("value") == "")
					errors.push("A Draft Start Date must be set.");
				if(jQuery(this.draft_end_date_date_box).prop("value") == "")
					errors.push("A Draft End Date must be set.");
				if(jQuery(this.draft_start_date_date_box).prop("value") != "" && jQuery(this.draft_end_date_date_box).prop("value") != ""){
						
						var draft_start_date = new Date(jQuery(this.draft_start_date_date_box).prop("value").substring(0,4),jQuery(this.draft_start_date_date_box).prop("value").substring(5,7) - 1,jQuery(this.draft_start_date_date_box).prop("value").substring(8,11));
						var draft_end_date = new Date(jQuery(this.draft_end_date_date_box).prop("value").substring(0,4),jQuery(this.draft_end_date_date_box).prop("value").substring(5,7) - 1,jQuery(this.draft_end_date_date_box).prop("value").substring(8,11));
						var today = new Date();
						if(today.getFullYear() <= draft_start_date.getFullYear() && today.getMonth() <= draft_start_date.getMonth() && today.getDate() <= draft_start_date.getDate()){
							
								if(today.getFullYear() <= draft_end_date.getFullYear() && today.getMonth() <= draft_end_date.getMonth() && today.getDate() <= draft_end_date.getDate()){
									if(draft_end_date.getFullYear() >= draft_start_date.getFullYear() ){
										
										if(draft_end_date.getMonth() >= draft_start_date.getMonth()){
											
											if(draft_end_date.getDate() < draft_start_date.getDate())
												errors.push("The Draft End Date cannot be before the Draft Start Date.");
										}else
											errors.push("The Draft End Date cannot be before the Draft Start Date.");
									}else
										errors.push("The Draft End Date cannot be before the Draft Start Date.");
								}else
									errors.push("The Draft End Date cannot be befor today.");
							}else
								errors.push("The Draft Start Date cannot be before today.");
								draft_start_date = null;
								draft_end_date = null;
								today = null;
				}
				if(jQuery(this.CheckBoxes.ps4_console_check_box).prop("checked") == false && jQuery(this.CheckBoxes.ps3_console_check_box).prop("checked") == false && jQuery(this.CheckBoxes.xboxone_console_check_box).prop("checked") == false && jQuery(this.CheckBoxes.xbox360_console_check_box).prop("checked") == false)
					errors.push("At least one console must be selected for the league");
				if(this.selected_games.length == 0)
					errors.push("At least one Game must be selected for the League.");
				if(jQuery(this.CheckBoxes.public_access_check_box).prop("checked") == false && jQuery(this.CheckBoxes.private_access_check_box).prop("checked") == false)
					errors.push("A Access type for the League must be set");
				if(jQuery(this.number_of_teams_number_text_box).prop("value") == "")
					errors.push("The number of Teams in the league cannot be blank.");
				
		if(jQuery(this.CheckBoxes.glory_type_check_box).prop("checked") == true){
				
		}else if(jQuery(this.CheckBoxes.standard_type_check_box).prop("checked") == true){
			
			if(jQuery(this.CheckBoxes.StandardLeagueFormCheckBoxes.custom_check_box).prop("checked") == false && jQuery(this.CheckBoxes.StandardLeagueFormCheckBoxes.standard_check_box).prop("checked") == false)
				errors.push("A sub-type for the Standard League must be set.");
			if(jQuery(this.CheckBoxes.StandardLeagueFormCheckBoxes.custom_check_box).prop("checked") == true){
				if(jQuery(this.CheckBoxes.StandardLeagueFormCheckBoxes.game_completion_check_box).prop("checked") == false && jQuery(this.CheckBoxes.StandardLeagueFormCheckBoxes.time_played_check_box).prop("checked") == false && jQuery(this.CheckBoxes.StandardLeagueFormCheckBoxes.gamer_points_check_box ).prop("checked") == false && jQuery(this.CheckBoxes.StandardLeagueFormCheckBoxes.game_achievements_check_box).prop("checked") == false && jQuery(this.CheckBoxes.StandardLeagueFormCheckBoxes.ingame_stats_check_box).prop("checked") == false)
					errors.push("A Scoring Method must be set for a custom league.");
			}
		}else{
			
			errors.push("A League type must be selected.");
		}
		
		if(errors.length > 0){
			console.log(errors);
					return false;
		}
	},
	CheckBoxes :{
			
			ps4_console_check_box			: "#ps4_console_check_box",
			ps3_console_check_box			: "#ps3_console_check_box",
			xboxone_console_check_box       : "#xbox360_console_check_box",
			xbox360_console_check_box       : "#xbox360_console_check_box",
			glory_type_check_box            : "#glory_type_check_box",
			standard_type_check_box         : "#standard_type_check_box",
			online_draft_check_box          : "#online_draft_check_box",
			auto_draft_check_box            : "#auto_draft_check_box",
			raffle_draft_check_box          : "#raffle_draft_check_box",
			public_access_check_box         : "#public_access_check_box",
			private_access_check_box        : "#private_access_check_box",
			locked_check_box                : "#locked_check_box",
			xbox360_console_check_box       : "#xbox360_console_check_box",
			xboxone_console_check_box       : "#xboxone_console_check_box",
			ps3_console_check_box           : "#ps3_console_check_box",
			ps4_console_check_box           : "#ps4_console_check_box",
				
			
			isCheckBoxChecked : function (element){
		
				if(jQuery(element).prop("checked") == true)
					return true;
				else 
					return false;
			},
			toggleCheckBox : function (element){
		
				if(jQuery(element).prop("checked") == true)
					jQuery(element).prop("checked",false);
				else
					jQuery(element).prop("checked",true);
			},
				GloryLeagueFormCheckBoxes:{
				
			},
			
			StandardLeagueFormCheckBoxes:{
				
				
				game_completion_check_box       : "#game_completion_check_box",
				time_played_check_box           : "#time_played_check_box",
				gamer_points_check_box          : "#gamer_points_check_box",
				game_achievements_check_box     : "#game_achievements_check_box",
				ingame_stats_check_box          : "#ingame_stats_check_box",
				custom_check_box                : "#standard_league_custom_check_box",
				standard_check_box              : "#standard_league_standard_check_box",
				game_stat_category_check_box    : null,
				game_stat_subcategory_check_box : null,
				game_stat_check_box 	        : null,
			},
			Events :{
				
					click : function(element){
					
					if(element[0] != "#"){
						
						if(jQuery(".game_stat_category_check_box").filter("#"+element)[0] === undefined){
							if(jQuery(".game_stat_subcategory_check_box").filter("#"+element)[0] === undefined)
								return;
							else{
							
								if(element == jQuery(".game_stat_subcategory_check_box").filter("#"+element)[0].id){
								
								jQuery("#"+element).on("click" ,function(){
							
							var check_boxes = jQuery(this).siblings().children();
							check_boxes = jQuery(check_boxes).children();
		
							if(LeagueForm.CheckBoxes.isCheckBoxChecked("#"+jQuery(this).attr("id"))){
								check_boxes.each(function(){
									jQuery(this).prop('checked', true);				
								});	
							}else{			
								check_boxes.each(function(){
									jQuery(this).prop('checked', false);
								});
							}
							// Need to Fix this part
							if(LeagueForm.CheckBoxes.isCheckBoxChecked(jQuery(this).closest("game_stat_category_check_box").id))
								LeagueForm.CheckBoxes.toggleCheckBox(jQuery(this).closest("game_stat_category_check_box").id);
						});
							}
							}
						}else{
					
							if(element == jQuery(".game_stat_category_check_box").filter("#"+element)[0].id){
								jQuery("#"+element).on("click" ,function(){
							
							var check_boxes = jQuery(this).siblings(".game_stat_subcategories").find("li > input[type='checkbox']");
							
							if(LeagueForm.CheckBoxes.isCheckBoxChecked("#"+jQuery(this).attr("id"))){
								check_boxes.each(function(){
									jQuery(this).prop('checked', true);				
								});	
							}else{			
								check_boxes.each(function(){
									jQuery(this).prop('checked', false);
								});
							}
						});
							} 
						}
						
						
					}
					try{
					switch(element){
						case LeagueForm.CheckBoxes.glory_type_check_box : jQuery(element).on("click",function(){
							if(LeagueForm.CheckBoxes.isCheckBoxChecked(LeagueForm.CheckBoxes.standard_type_check_box)){
						
																		LeagueForm.CheckBoxes.toggleCheckBox(LeagueForm.CheckBoxes.standard_type_check_box);
																	}
					
																	if(LeagueForm.CheckBoxes.isCheckBoxChecked(LeagueForm.CheckBoxes.glory_type_check_box)){
																		if(jQuery(LeagueForm.GloryLeagueForm.form_settings).length > 0)
																		jQuery(LeagueForm.GloryLeagueForm.form_settings).css("display","block");
																		else{
																			jQuery(LeagueForm.form).append(LeagueForm.GloryLeagueForm.form);
																			jQuery(LeagueForm.GloryLeagueForm.form_settings).css("display","block");
																		}
																		if(jQuery(LeagueForm.StandardLeagueForm.form_settings)){
																			jQuery(LeagueForm.StandardLeagueForm.form_settings).remove();
																			LeagueForm.selected_games = [];
																		}
																		//jQuery(LeagueForm.type_container).attr("value","custom");
																	}else{
																		jQuery(LeagueForm.GloryLeagueForm.form_settings).remove();
																		LeagueForm.selected_games = [];
																	}
						});
						break;
						case LeagueForm.CheckBoxes.standard_type_check_box : jQuery(element).on("click", function(){
						
							if(LeagueForm.CheckBoxes.isCheckBoxChecked(LeagueForm.CheckBoxes.glory_type_check_box)){
						
																		LeagueForm.CheckBoxes.toggleCheckBox(LeagueForm.CheckBoxes.glory_type_check_box);
																	}
					
																	if(LeagueForm.CheckBoxes.isCheckBoxChecked(LeagueForm.CheckBoxes.standard_type_check_box)){
																		if(jQuery(LeagueForm.StandardLeagueForm.form_settings).length > 0)
																		jQuery(LeagueForm.StandardLeagueForm.form_settings).css("display","block");
																		else{
																			jQuery(LeagueForm.form).append(LeagueForm.StandardLeagueForm.form);
																			jQuery(LeagueForm.StandardLeagueForm.form_settings).css("display","block");
																		}
																		if(jQuery(LeagueForm.GloryLeagueForm.form_settings)){
																			jQuery(LeagueForm.GloryLeagueForm.form_settings).remove();
																			LeagueForm.selected_games = [];
																		}
																		//jQuery(LeagueForm.type_container).attr("value","custom");
																	}else{
																		jQuery(LeagueForm.StandardLeagueForm.form_settings).remove();
																		LeagueForm.selected_games = [];
																	}
						});
						break;
						case LeagueForm.CheckBoxes.StandardLeagueFormCheckBoxes.custom_check_box : jQuery(document).on("click",element , function(){
					
								  							  		if(LeagueForm.CheckBoxes.isCheckBoxChecked(LeagueForm.CheckBoxes.StandardLeagueFormCheckBoxes.standard_check_box)){
						
																		LeagueForm.CheckBoxes.toggleCheckBox(LeagueForm.CheckBoxes.StandardLeagueFormCheckBoxes.standard_check_box);
																	}
					
																	if(LeagueForm.CheckBoxes.isCheckBoxChecked(LeagueForm.CheckBoxes.StandardLeagueFormCheckBoxes.custom_check_box)){
																		jQuery("#custom_league_form_data").css("display","block");
																		jQuery(LeagueForm.type_container).attr("value","custom");
																	}else{
																		jQuery("#custom_league_form_data").css("display","none");
																		if(jQuery("#game_stats_edit_box").css("display") != "none")
																			jQuery("#game_stats_edit_box").css("display","none");
																		jQuery(LeagueForm.StandardLeagueForm.type_container).attr("value","");
																	}
																	
								  								});
						break;
						case LeagueForm.CheckBoxes.StandardLeagueFormCheckBoxes.standard_check_box : jQuery(document).on("click" ,element, function(){
																	
																	if(LeagueForm.CheckBoxes.isCheckBoxChecked(LeagueForm.CheckBoxes.StandardLeagueFormCheckBoxes.custom_check_box )){
																		LeagueForm.CheckBoxes.toggleCheckBox(LeagueForm.CheckBoxes.StandardLeagueFormCheckBoxes.custom_check_box);
																		jQuery(LeagueForm.type_container).attr("value","standard");
																		jQuery("#custom_league_form_data").css("display","none");
																		if(jQuery("#game_stats_edit_box").css("display") != "none")
																				jQuery("#game_stats_edit_box").css("display","none");
																	}
																	if(!LeagueForm.CheckBoxes.isCheckBoxChecked(LeagueForm.CheckBoxes.StandardLeagueFormCheckBoxes.standard_check_box))
																		jQuery(LeagueForm.StandardLeagueForm.type_container).attr("value","");
																 });
						break;
						case LeagueForm.CheckBoxes.online_draft_check_box :
						jQuery(document).on("click", element , function(){
							if(LeagueForm.CheckBoxes.isCheckBoxChecked(LeagueForm.CheckBoxes.auto_draft_check_box))
								LeagueForm.CheckBoxes.toggleCheckBox(LeagueForm.CheckBoxes.auto_draft_check_box);
							
							if(LeagueForm.CheckBoxes.isCheckBoxChecked(LeagueForm.CheckBoxes.raffle_draft_check_box)){
								LeagueForm.CheckBoxes.toggleCheckBox(LeagueForm.CheckBoxes.raffle_draft_check_box);
							}
								
						});
						break;
						case LeagueForm.CheckBoxes.auto_draft_check_box : 
						jQuery(document).on("click" ,element, function(){
							if(LeagueForm.CheckBoxes.isCheckBoxChecked(LeagueForm.CheckBoxes.online_draft_check_box)){
								LeagueForm.CheckBoxes.toggleCheckBox(LeagueForm.CheckBoxes.online_draft_check_box);
							}
							if(LeagueForm.CheckBoxes.isCheckBoxChecked(LeagueForm.CheckBoxes.raffle_draft_check_box)){
								LeagueForm.CheckBoxes.toggleCheckBox(LeagueForm.CheckBoxes.raffle_draft_check_box);
							}
						});
						break;
						case LeagueForm.CheckBoxes.raffle_draft_check_box : 
						jQuery(document).on("click",element , function(){
							if(LeagueForm.CheckBoxes.isCheckBoxChecked(LeagueForm.CheckBoxes.online_draft_check_box))
								LeagueForm.CheckBoxes.toggleCheckBox(LeagueForm.CheckBoxes.online_draft_check_box);
							
							if(LeagueForm.CheckBoxes.isCheckBoxChecked(LeagueForm.CheckBoxes.auto_draft_check_box))
								LeagueForm.CheckBoxes.toggleCheckBox(LeagueForm.CheckBoxes.auto_draft_check_box);
							
						});
						break;
						case LeagueForm.CheckBoxes.public_access_check_box :
						jQuery(document).on("click",element , function(){
							if(LeagueForm.CheckBoxes.isCheckBoxChecked(LeagueForm.CheckBoxes.private_access_check_box))
								LeagueForm.CheckBoxes.toggleCheckBox(LeagueForm.CheckBoxes.private_access_check_box);
							
						});
						break;
						case LeagueForm.CheckBoxes.private_access_check_box  : 
						jQuery(document).on("click",element , function(){
							if(LeagueForm.CheckBoxes.isCheckBoxChecked(LeagueForm.CheckBoxes.public_access_check_box))
								LeagueForm.CheckBoxes.toggleCheckBox(LeagueForm.CheckBoxes.public_access_check_box);
						});
						break;
						case LeagueForm.CheckBoxes.locked_check_box:
						jQuery(document).on("click" ,element, function(){
							
						});
						break;
						case LeagueForm.CheckBoxes.game_stat_check_box : 
						jQuery(element).on("click" , function(){
							
						});
						break;
						default : "";
				}
				}catch(ex){
					console.log(ex);
					
				}
				},
				GloryLeagueFormCheckboxEvents:{
					
				},
				StandardLeagueFormCheckBoxEvents : {
				}
				
			}
		},
		Events : {
			
			
			gameSelect : function(league_form){
				if(league_form == "StandardLeagueForm"){
					jQuery(document).on("click","#league_game_dropdown_box",function(){
							var game = jQuery("#league_game_dropdown_box").prop("value");
							if(game == "" || game.length == 0 || game == "Choose A Game")
								return;
							else {
								for(var i in LeagueForm.selected_games ){
									if(LeagueForm.selected_games[i] === game)
										return;
									
								}
							}
							var selected_game = "<span class='selected_league_game'> <a onclick='LeagueForm.StandardLeagueForm.createGameStatsEditBox(\""+ game.toLowerCase() + "\")' href='#' > " +game+"</a> <a class='close_button' role='button'></a></span>";
								if(jQuery("#selected_league_games_container").css("display") == "none"){
									jQuery("#selected_league_games_container").css("display","block");
									jQuery("#selected_league_games_container").append(selected_game);
									LeagueForm.selected_games.push(game);
								}else if(jQuery("#selected_league_games_container").css("display") !="none"){	
									jQuery("#selected_league_games_container").append(selected_game);
									LeagueForm.selected_games.push(game);
								}
						});
				}else if(league_form == "GloryLeagueForm"){
					jQuery(document).on("click",".glory_league_game_dropdown_box",function(e){
							console.log("."+e.target.className);
							var game = jQuery("."+e.target.className).prop("value");
							if(game == "" || game.length == 0 || game == "Choose A Game")
								return;
							else{
								for(var i in LeagueForm.selected_games ){
									if(LeagueForm.selected_games[i] === game)
										return;
									
								}
							}
							var selected_game = "<span > <a href='#' > " +game+"</a> <a class='close_button' role='button'></a></span>";
									jQuery("."+e.target.className).parents(".glory_league_game_dropdown_box_container").append(selected_game);
									jQuery("."+e.target.className).remove();
								
									LeagueForm.selected_games.push(game);
								
								
						});
				}
			}
		},
	GloryLeagueForm :{
		form_settings             : "#glory_league_settings",
		form 					  : "<fieldset class='league_settings' id='glory_league_settings' style='display: none;'> 													<legend> 														League Settings 													</legend> 													<label for='league_name'> 														League Name 													</label> 													<input type='text' class='text_box' id='league_name_text_box' name='league_name'> 													 													<label for='league_draft_type'> 														Draft Type 													</label> 													<div class='form_content_container' id='league_draft_type_container' name='league_draft_type'> 														<label for='online_draft'> 															Online Draft 														</label> 														<input type='checkbox' class='check_box' id='online_draft_check_box' name='online_draft'> 														<label for='auto_draft'> 															Auto 														</label> 														<input type='checkbox' class='check_box' id='auto_draft_check_box' name='auto_draft'> 														<label for='raffle_draft'> 															Raffle Draft 														</label> 														<input type='checkbox' class='check_box' id='raffle_draft_check_box' name='raffle_draft'> 														<input type='hidden' class='hidden_input' id='hidden_input_league_draft_type' name='hidden_league_draft_type'> 													</div> 													<div class='form_content_container' id='league_draft_date_container'> 													<label for='draft_start_date'> 														Draft Start Date 													</label> 													<input type='date' class='date_box' id='draft_start_date_date_box' name='draft_start_date'> 													<label for='draft_end_date'> 														Draft End Date 													</label> 													<input type='date' class='date_box' id='draft_end_date_date_box' name='draft_end_date'> 													</div> 													<div class='form_content_container' id='league_games_container'> 													<label for='league_game'> 														Game 													</label> 													<div class='form_content' id='league_games' name='league_games'> 													 													 																		<div> 																			<span> 																				Shooter 																			</span> 																		</div> 																		<div id='league_form_add_game_button_container'> 																			<button id='league_form_add_game_button' onclick='LeagueForm.GloryLeagueForm.addGameSelectBox(this.id)'> 																				Add Game 																			</button> 																			 																		</div> 																	 													 													</div> 													</div> 													<div class='form_content_container' id='selected_league_games_container' style='display:none'> 														 													</div> 													 													 													<label for='league_access'> 														Access 													</label> 													<div class='form_content_container' id='league_access_container' name='league_access'> 														<label for='public_acces'> 															Public 														</label> 														<input type='checkbox' class='check_box' id='public_access_check_box' name='public_access'> 														<label for='private_access'> 															Private 														</label> 														<input type='checkbox' class='check_box' id='private_access_check_box' name='private_access'> 														<input type='hidden' class='hidden_input' id='hidden_input_league_access' name='hidden_league_access'> 													</div> 													<label for='locked'> 														Do you want to lock this league? 													</label> 													<input type='checkbox' class='check_box' id='locked_check_box' name='locked'> 													 													<label for='number_of_teams'> 														Enter the number of teams to participate in this league 													</label> 													<input type='number' class='number_text_box' id='number_of_teams_number_text_box' name='number_of_teams'> 													<label for='league_consoles'> 														Consoles 													</label> 													<div class='form_content_container' id='league_consoles_container' name='league_consoles'> 													<label for='xbox_console'> 														Xbox 													</label> 													<input type='checkbox' class='check_box' id='xbox_console_check_box' name='xbox_console'> 													 <label for='ps_console'> 													 	Playstation 													 </label> 													 <input type='checkbox' class='check_box' id='ps_console_check_box' name='ps_console'> 													  <label for='xbox_and_ps_console'> 													 	Xbox and Playstation 													 </label> 													 <input type='checkbox' class='check_box' id='xbox_and_ps_console_check_box' name='xbox_and_ps_console'> 													 </div> 													 													 												</fieldset>",
		add_game_button_container : "#league_form_add_game_button_container",
		add_game_button           : "#league_form_add_game_button",
		add_game_element		  : "<div id='league_form_add_game_button_container'><button id='league_form_add_game_button' onclick='LeagueForm.GloryLeagueForm.addGameSelectBox(this.id)'>Add Game</button></div>",
		game_select_box           : "<div class='hidden_glory_league_game_dropdown_box_container'><select class='form_dropdown_box' id='glory_league_game_dropdown_box' name='league_games[]' form='create_league_form'><option selected>Choose A Game</option></select></div>",
		
		addGameSelectBox : function(add_game_button){
			
			
			jQuery(".hidden_glory_league_game_dropdown_box_container").clone().attr("class","glory_league_game_dropdown_box_container").css("display","block").appendTo(jQuery("#"+add_game_button).parents(".glory_league_form_game_genre"));
			//not the best solution but its what I could come up with now!
			jQuery(".glory_league_game_dropdown_box_container").children(".hidden_glory_league_game_dropdown_box").css("display","block");
			jQuery(".glory_league_game_dropdown_box_container").children(".hidden_glory_league_game_dropdown_box").attr("class","glory_league_game_dropdown_box");
			event.preventDefault();
			
		}
	},
	StandardLeagueForm:{
		selected_games_container : "#selected_league_games_container",
		type_container           : "#standard_league_type_container",
		form_settings             : "#standard_league_settings",
		form                     : "<fieldset class='league_setting' id='standard_league_settings' style='display: none;'> 													<legend> 														League Settings 													</legend> 													<label for='league_name'> 														League Name 													</label> <input type='text' class='text_box' id='league_name_text_box' name='league_name'/>	<label for='standard_league_type'>Type</label>											 	<div class='form_content_container' id='standard_league_type_container' name='standard_league_type'> 												 		<label for='standard_league_standard_check_box'> Normal												 		</label> 												 		<input type='checkbox' class='checkbox' id='standard_league_custom_check_box' name='standard_league_standard_check_box'/> 												  		<label for='standard_league_custom_check_box'> Custom												 		</label> 												 		<input type='checkbox' class='checkbox' id='standard_league_custom_check_box' name='standard_league_custom_check_box'/> 												 	</div> 																	 													<label for='league_draft_type'> 														Draft Type 													</label> 													<div class='form_content_container' id='league_draft_type_container' name='league_draft_type'> 														<label for='online_draft'> 															Online Draft 														</label> 														<input type='checkbox' class='check_box' id='online_draft_check_box' name='online_draft'> 														<label for='auto_draft'> 															Auto 														</label> 														<input type='checkbox' class='check_box' id='auto_draft_check_box' name='auto_draft'/> 														<label for='raffle_draft'> 															Raffle Draft 														</label> 														<input type='checkbox' class='check_box' id='raffle_draft_check_box' name='raffle_draft'/> 														<input type='hidden' class='hidden_input' id='hidden_input_league_draft_type' name='hidden_league_draft_type'/> 													</div> 													<div class='form_content_container' id='league_draft_date_container'> 													<label for='draft_start_date'> 														Draft Start Date 													</label> 													<input type='date' class='date_box' id='draft_start_date_date_box' name='draft_start_date'> 													<label for='draft_end_date'> 														Draft End Date 													</label> 													<input type='date' class='date_box' id='draft_end_date_date_box' name='draft_end_date'> 													</div> 													<div class='form_content_container' id='league_games_container'> 													<label for='league_game'> 														Game 													</label> 													<select class='form_dropdown_box' id='league_game_dropdown_box' name='league_games[]' form='create_league_form'> 													<option selected=''> 													 													</option><option class='league_game_option' click='LeagueForm.Events.OptionBoxEvents.click(' .league_game_option')='' value='Destiny' '=''>Destiny</option><option class='league_game_option' click='LeagueForm.Events.OptionBoxEvents.click(' .league_game_option')='' value='Battlefield Hardline' '=''>Battlefield Hardline</option><option class='league_game_option' click='LeagueForm.Events.OptionBoxEvents.click(' .league_game_option')='' value='Minecraft: Xbox One Edition' '=''>Minecraft: Xbox One Edition</option><option class='league_game_option' click='LeagueForm.Events.OptionBoxEvents.click(' .league_game_option')='' value='Terraria' '=''>Terraria</option><option class='league_game_option' click='LeagueForm.Events.OptionBoxEvents.click(' .league_game_option')='' value='Neverwinter' '=''>Neverwinter</option><option class='league_game_option' click='LeagueForm.Events.OptionBoxEvents.click(' .league_game_option')='' value='EA SPORTS NBA LIVE 15' '=''>EA SPORTS NBA LIVE 15</option><option class='league_game_option' click='LeagueForm.Events.OptionBoxEvents.click(' .league_game_option')='' value='Assassin' s='' creed='' iv='' black='' flag'='' '=''>Assassin's Creed IV Black Flag</option><option class='league_game_option' click='LeagueForm.Events.OptionBoxEvents.click(' .league_game_option')='' value='WATCH_DOGS' '=''>WATCH_DOGS</option><option class='league_game_option' click='LeagueForm.Events.OptionBoxEvents.click(' .league_game_option')='' value='Rayman Legends' '=''>Rayman Legends</option><option class='league_game_option' click='LeagueForm.Events.OptionBoxEvents.click(' .league_game_option')='' value='DRAGON BALL XENOVERSE' '=''>DRAGON BALL XENOVERSE</option><option class='league_game_option' click='LeagueForm.Events.OptionBoxEvents.click(' .league_game_option')='' value='Tomb Raider: Definitive Edition' '=''>Tomb Raider: Definitive Edition</option><option class='league_game_option' click='LeagueForm.Events.OptionBoxEvents.click(' .league_game_option')='' value='State of Decay: Year-One' '=''>State of Decay: Year-One</option><option class='league_game_option' click='LeagueForm.Events.OptionBoxEvents.click(' .league_game_option')='' value='Call of Duty: Advanced Warfare' '=''>Call of Duty: Advanced Warfare</option><option class='league_game_option' click='LeagueForm.Events.OptionBoxEvents.click(' .league_game_option')='' value='Grand Theft Auto V' '=''>Grand Theft Auto V</option><option class='league_game_option' click='LeagueForm.Events.OptionBoxEvents.click(' .league_game_option')='' value='Dragon Age: Inquisition' '=''>Dragon Age: Inquisition</option><option class='league_game_option' click='LeagueForm.Events.OptionBoxEvents.click(' .league_game_option')='' value='LEGO Jurassic World' '=''>LEGO Jurassic World</option><option class='league_game_option' click='LeagueForm.Events.OptionBoxEvents.click(' .league_game_option')='' value='Lords of the Fallen' '=''>Lords of the Fallen</option><option class='league_game_option' click='LeagueForm.Events.OptionBoxEvents.click(' .league_game_option')='' value='The Elder Scrolls Online: Tamriel Unlimited' '=''>The Elder Scrolls Online: Tamriel Unlimited</option><option class='league_game_option' click='LeagueForm.Events.OptionBoxEvents.click(' .league_game_option')='' value='Far Cry 4' '=''>Far Cry 4</option><option class='league_game_option' click='LeagueForm.Events.OptionBoxEvents.click(' .league_game_option')='' value='Warframe' '=''>Warframe</option><option class='league_game_option' click='LeagueForm.Events.OptionBoxEvents.click(' .league_game_option')='' value='Project Spark' '=''>Project Spark</option><option class='league_game_option' click='LeagueForm.Events.OptionBoxEvents.click(' .league_game_option')='' value='Ryse: Son of Rome' '=''>Ryse: Son of Rome</option><option class='league_game_option' click='LeagueForm.Events.OptionBoxEvents.click(' .league_game_option')='' value='Happy Wars' '=''>Happy Wars</option><option class='league_game_option' click='LeagueForm.Events.OptionBoxEvents.click(' .league_game_option')='' value='The Witcher 3: Wild Hunt' '=''>The Witcher 3: Wild Hunt</option><option class='league_game_option' click='LeagueForm.Events.OptionBoxEvents.click(' .league_game_option')='' value='Game of Thrones - A Telltale Games Series' '=''>Game of Thrones - A Telltale Games Series</option><option class='league_game_option' click='LeagueForm.Events.OptionBoxEvents.click(' .league_game_option')='' value='Middle-earth: Shadow of Mordor' '=''>Middle-earth: Shadow of Mordor</option><option class='league_game_option' click='LeagueForm.Events.OptionBoxEvents.click(' .league_game_option')='' value='Evolve' '=''>Evolve</option><option class='league_game_option' click='LeagueForm.Events.OptionBoxEvents.click(' .league_game_option')='' value='Assassin' s='' creed='' unity'='' '=''>Assassin's Creed Unity</option></select> 													</div> 													<div class='form_content_container' id='selected_league_games_container' style='display:none'> 														 													</div> 													 													 													<label for='league_access'> 														Access 													</label> 													<div class='form_content_container' id='league_access_container' name='league_access'> 														<label for='public_acces'> 															Public 														</label> 														<input type='checkbox' class='check_box' id='public_access_check_box' name='public_access'> 														<label for='private_access'> 															Private 														</label> 														<input type='checkbox' class='check_box' id='private_access_check_box' name='private_access'> 														<input type='hidden' class='hidden_input' id='hidden_input_league_access' name='hidden_league_access'> 													</div> 													<label for='locked'> 														Do you want to lock this league? 													</label> 													<input type='checkbox' class='check_box' id='locked_check_box' name='locked'> 													 													<label for='number_of_teams'> 														Enter the number of teams to participate in this league 													</label> 													<input type='number' class='number_text_box' id='number_of_teams_number_text_box' name='number_of_teams'> 													<label for='league_consoles'> 														Consoles 													</label> 													<div class='form_content_container' id='league_consoles_container' name='league_consoles'> 													<label for='xbox_console'> 														Xbox 													</label> 													<input type='checkbox' class='check_box' id='xbox_console_check_box' name='xbox_console'> 													 <label for='ps_console'> 													 	Playstation 													 </label> 													 <input type='checkbox' class='check_box' id='ps_console_check_box' name='ps_console'> 													  <label for='xbox_and_ps_console'> 													 	Xbox and Playstation 													 </label> 													 <input type='checkbox' class='check_box' id='xbox_and_ps_console_check_box' name='xbox_and_ps_console'> 													 </div> 													 													 												</fieldset>",
		createGameStatsEditBox : function(game){
			if(LeagueForm.CheckBoxes.isCheckBoxChecked(LeagueForm.CheckBoxes.StandardLeagueFormCheckBoxes.custom_check_box )){
					
				if(jQuery(".selected_league_game").children().last().is("#game_stats_edit_box") == true){
						
					if(jQuery("#game_stats_edit_box").css("display") == "block"){
						
						this.toggleFieldCollapse("#game_stats_edit_box");
						return;
					}
						
					else{
						jQuery("#game_stats_edit_box").css("display","block");
						return;
					}
				}
						
				var edit_box = "<div id='game_stats_edit_box'> </div>";
				jQuery(".selected_league_game").append(edit_box);
					Ajax.makeRequest("get","/php/class." +game+"api.php?get_stat_catagories=true" ,"#game_stats_edit_box") ;
				
				
						
			}else
				return;
		}
		
		
	}
};
jQuery(document).ready(function(){
	//$(document).on("click", LeagueForm.CheckBoxes.glory_type_check_box, handler)
	LeagueForm.CheckBoxes.Events.click(LeagueForm.CheckBoxes.glory_type_check_box);
	LeagueForm.CheckBoxes.Events.click(LeagueForm.CheckBoxes.standard_type_check_box);
	LeagueForm.CheckBoxes.Events.click(LeagueForm.CheckBoxes.StandardLeagueFormCheckBoxes.standard_check_box);
	LeagueForm.CheckBoxes.Events.click(LeagueForm.CheckBoxes.StandardLeagueFormCheckBoxes.custom_check_box);
	LeagueForm.CheckBoxes.Events.click(LeagueForm.CheckBoxes.online_draft_check_box);
	LeagueForm.CheckBoxes.Events.click(LeagueForm.CheckBoxes.auto_draft_check_box);
	LeagueForm.CheckBoxes.Events.click(LeagueForm.CheckBoxes.raffle_draft_check_box);
	LeagueForm.CheckBoxes.Events.click(LeagueForm.CheckBoxes.public_access_check_box);
	LeagueForm.CheckBoxes.Events.click(LeagueForm.CheckBoxes.private_access_check_box) ;
	LeagueForm.CheckBoxes.Events.click(LeagueForm.CheckBoxes.locked_check_box);
	LeagueForm.Events.gameSelect("StandardLeagueForm");
	LeagueForm.Events.gameSelect("GloryLeagueForm");
	LeagueForm.Ajax.Events.keypress();
	LeagueForm.Ajax.Events.keydown();
	LeagueForm.Ajax.Events.blur();
	

});