<?php
require_once("class.fantasygamingdatabase.php");
require_once("class.page.php");
require_once("class.user.php");
require_once("class.gamer.php");
require_once("class.manager.php");
require_once("class.league.php");
require_once("functions.php");
class LeaguePage extends Page{
	
	public function __construct($user){
		
		$this->leaguePageModules($user);
		parent::__construct($user);
		$this->printPage();
	}
	public function leaguePageModules($user){
	
	$mysql_connection = new FantasyGamingDataBase();
	
	
	$this->body = "<section class='page_body'>
	 				<div class='page_body_header'>";
					 if($this->checkForErrors()){
			
			$this->body .= $this->getErrorModule();
			$_SESSION["error"] = null;
		}
					$this->body .="</div>
		 			<div class='page_body_body'>
					<div class='module_container' id='league_module_container'>
        			<div class='content_module' id='league_header_module'>
					<div class='content_module_header' id='league_module_header'>
					<div>";
					if($user->type == "manager"){
						$this->body .="<span>
										Create a League
										<a href='#league_form_container' class='fancybox' >
											+
										</a>
									  </span>
										<div class='form_container' id='league_form_container' style='display:none'>
										
											
											<form id='create_league_form' action='/php/addleague.php'  method='post' onsubmit='return LeagueForm.verifyLeagueForm();'>
											<div class='form_content_container' id='league_type_container' name='league_type'/>
													 <h1>
													 	Choose Your League
													 </h1>
														<label for='glory_type'>
															Glory Leauge
														</label>
														<input type='checkbox' class='check_box' id='glory_type_check_box' name='glory_type'/>
														<label for='standard_type'>
															Standard League
														</label>
														<input type='checkbox' class='check_box' id='standard_type_check_box' name='standard_type'/>
													</div>
												<fieldset class='league_settings' id='glory_league_settings'>
													<legend>
														League Settings
													</legend>
													<label for='league_name'>
														League Name
													</label>
													<input type='text' class='text_box' id='league_name_text_box' name='league_name'/>
													<div id='league_name_errors'>
													
													<div>
													<label for='league_draft_type'>
														Draft Type
													</label>
													<div class='form_content_container' id='league_draft_type_container' name='league_draft_type'/>
														<label for='online_draft'>
															Online Draft
														</label>
														<input type='checkbox' class='check_box' id='online_draft_check_box' name='online_draft'/>
														<label for='auto_draft'>
															Auto
														</label>
														<input type='checkbox' class='check_box' id='auto_draft_check_box' name='auto_draft'/>
														<label for='raffle_draft'>
															Raffle Draft
														</label>
														<input type='checkbox' class='check_box' id='raffle_draft_check_box' name='raffle_draft'/>
														
													</div>
													<div class='form_content_container' id='league_draft_date_container'>
													<label for='draft_start_date'>
														Draft Start Date
													</label>
													<input type='date' class='date_box' id='draft_start_date_date_box' name='draft_start_date'/>
													<label for='draft_end_date'>
														Draft End Date
													</label>
													<input type='date' class='date_box' id='draft_end_date_date_box' name='draft_end_date'/>
													</div>
													<div class='form_content_container' id='league_games_container'>
													<label for='league_game'>
														Game
													</label>
													<div class='form_content' id='league_games' name='league_games'>
													
													";
													$result = $mysql_connection->selectQuery("select details from games where has_stats = 1")->fetch_all();
													
													foreach ($result as $key => $value){
														
														$genre = null;
														$game = unserialize($value[0]);

														foreach($game["genres"] as $k => $v){
													
										
																		$genre = $v; 
				
														
																$this->body .="
																		<div class='glory_league_form_game_genre'>
																			<span>
																				{$genre}
																			</span>
																			<div id='league_form_add_game_button_container'>
																			<button id='league_form_add_game_button' onclick='LeagueForm.GloryLeagueForm.addGameSelectBox(this.id)'>
																				Add Game
																			</button>
																			
																		</div>
																		
																		
																	
																	";
															
															$result = $mysql_connection->selectQuery("select name from games where has_stats = 1")->fetch_all();
													$this->body .="
													<div class='hidden_glory_league_game_dropdown_box_container'>
													<select class='form_dropdown_box hidden_glory_league_game_dropdown_box'   name='league_games[]' form='create_league_form' style='display:none'>
													<option selected>
														Choose A Game
													</option>";
													foreach ($result as $key => $value)
															$this->body .= "<option class='glory_league_game_option' click='LeagueForm.Events.OptionBoxEvents.click('.glory_league_game_option') value='{$value[0]}' '>".$value[0] . "</option>";
															
														$this->body .="
													</select>
													</div>
													</div>
													";
														}
														
														//print_r(unserialize($value[0]));
														
													}
													
															
														
													$this->body .="
													
													
													<div class='selected_glory_league_game' style='display:none'>
														
													</div>
													</div>
													</div>
													<div class='form_content_container' id='selected_league_games_container' style='display:none'>
														
													</div>
													
													
													<label for='league_access'>
														Access
													</label>
													<div class='form_content_container' id='league_access_container' name='league_access'>
														<label for='public_acces'>
															Public 
														</label>
														<input type='checkbox' class='check_box' id='public_access_check_box' name='public_access'/>
														<label for='private_access'>
															Private
														</label>
														<input type='checkbox' class='check_box' id='private_access_check_box' name='private_access'/>
														
													</div>
													<label for='locked'>
														Do you want to lock this league?
													</label>
													<input type='checkbox' class='check_box' id='locked_check_box' name='locked'/>
													
													<label for='number_of_teams'> 
														Enter the number of teams to participate in this league 
													</label>
													<input type='number' class='number_text_box' id='number_of_teams_number_text_box' name='number_of_teams'/> 
													<label for='league_consoles'>
														Consoles
													</label>
													<div class='form_content_container' id='league_consoles_container' name='league_consoles'>
													<label for='xbox360_console'>
														Xbox 360
													</label>
													<input type='checkbox' class='check_box' id='xbox360_console_check_box' name='xbox360_console' />
													 <label for='xboxone_console'>
														Xbox One
													</label>
													<input type='checkbox' class='check_box' id='xboxone_console_check_box' name='xboxone_console' />
													 <label for='ps3_console'>
													 	Playstation 3
													 </label>
													 <input type='checkbox' class='check_box' id='ps3_console_check_box' name='ps3_console' /> 
													  <label for='ps4_console'>
													 	Playstation 4
													 </label>
													 <input type='checkbox' class='check_box' id='ps4_console_check_box' name='ps4_console' /> 
													 </div>
													 
													
												</fieldset>
												
												<fieldset class='league_setting' id='standard_league_settings'>
													<legend>
														League Settings
													</legend>
													<label for='league_name'>
														League Name
													</label>
														<input type='text' class='text_box' id='league_name_text_box' name='league_name'/>
												 	<label for='standard_league_type'>
												 	Type
												 	</label>
												 	<div class='form_content_container' id='standard_league_type_container' name='standard_league_type'>
												 		<label for='standard_league_standard_check_box'>
												 			Normal
												 		</label>
												 		<input type='checkbox' class='checkbox' id='standard_league_standard_check_box' name='standard_league_standard_check_box'/>
												  		
												  		<label for='standard_league_custom_check_box'>
												  		Custom
												 		</label>
												 		<input type='checkbox' class='checkbox' id='standard_league_custom_check_box' name='standard_league_custom_check_box'/>
												 	</div>
													
													
													<label for='league_draft_type'>
														Draft Type
													</label>
													<div class='form_content_container' id='league_draft_type_container' name='league_draft_type'/>
														<label for='online_draft'>
															Online Draft
														</label>
														<input type='checkbox' class='check_box' id='online_draft_check_box' name='online_draft'/>
														<label for='auto_draft'>
															Auto
														</label>
														<input type='checkbox' class='check_box' id='auto_draft_check_box' name='auto_draft'/>
														<label for='raffle_draft'>
															Raffle Draft
														</label>
														<input type='checkbox' class='check_box' id='raffle_draft_check_box' name='raffle_draft'/>
														<input type='hidden' class='hidden_input' id='hidden_input_league_draft_type' name='hidden_league_draft_type'/>
													</div>
													<div class='form_content_container' id='league_draft_date_container'>
													<label for='draft_start_date'>
														Draft Start Date
													</label>
													<input type='date' class='date_box' id='draft_start_date_date_box' name='draft_start_date'/>
													<label for='draft_end_date'>
														Draft End Date
													</label>
													<input type='date' class='date_box' id='draft_end_date_date_box' name='draft_end_date'/>
													<label for='league_end_date'>
														League End Date
													</label>
													<input type='date' class='date_box' id='league_end_date_date_box' name='league_end_date'/>
													</div>
													<div class='form_content_container' id='league_games_container'>
													<label for='league_game'>
														Game
													</label>
													<select class='form_dropdown_box' id='league_game_dropdown_box' name='league_games[]' form='create_league_form'>
													<option selected>
													Choose A Game
													</option>";
													$result = $mysql_connection->selectQuery("select name from games")->fetch_all();
													
													foreach ($result as $key => $value)
															$this->body .= "<option class='league_game_option' click='LeagueForm.Events.OptionBoxEvents.click('.league_game_option') value='{$value[0]}' '>".$value[0] . "</option>";
															
														
													$this->body .="</select>
													</div>
													<div class='form_content_container' id='selected_league_games_container' style='display:none'>
														
													</div>
													
													
													<label for='league_access'>
														Access
													</label>
													<div class='form_content_container' id='league_access_container' name='league_access'>
														<label for='public_acces'>
															Public 
														</label>
														<input type='checkbox' class='check_box' id='public_access_check_box' name='public_access'/>
														<label for='private_access'>
															Private
														</label>
														<input type='checkbox' class='check_box' id='private_access_check_box' name='private_access'/>
														
													</div>
													<label for='locked'>
														Do you want to lock this league?
													</label>
													<input type='checkbox' class='check_box' id='locked_check_box' name='locked'/>
													
													<label for='number_of_teams'> 
														Enter the number of teams to participate in this league 
													</label>
													<input type='number' class='number_text_box' id='number_of_teams_number_text_box' name='number_of_teams'/> 
													<label for='league_consoles'>
														Consoles
													</label>
													<div class='form_content_container' id='league_consoles_container' name='league_consoles'>
													<label for='xbox360_console'>
														Xbox 360
													</label>
													<input type='checkbox' class='check_box' id='xbox360_console_check_box' name='xbox360_console' />
													 <label for='xboxone_console'>
														Xbox One
													</label>
													<input type='checkbox' class='check_box' id='xboxone_console_check_box' name='xboxone_console' />
													 <label for='ps3_console'>
													 	Playstation 3
													 </label>
													 <input type='checkbox' class='check_box' id='ps3_console_check_box' name='ps3_console' /> 
													  <label for='ps4_console'>
													 	Playstation 4
													 </label>
													 <input type='checkbox' class='check_box' id='ps4_console_check_box' name='ps4_console' /> 
													 </div>
													 <div class='hidden_form_data' id='custom_league_form_data' style='display:none'>
													
													 <label for='league_factors'>
													 	League Scoring Methods
													 </label>
													 <div class='form_dropdown_box' id='league_factors_drop_down_box'> 
													
													<label for='ingame_stats'>
														In-Game Stats
													</label>
													 <input type='checkbox' id='ingame_stats_check_box' name='ingame_stats'/>
													<label for='game_achievements'>
														Game Achievements
													</label>
													 <input type='checkbox' id='game_achievements_check_box' name='game_achievements'/>
													<label for='gamer_points'>
														Gamer Points
													</label>
													 <input type='checkbox' id='gamer_points_check_box' name='gamer_points'/>
													 <label for='time_played'>
														Time Played
													</label>
													 <input type='checkbox' id='time_played_check_box' name='time_played'/>
													 	
													 <label for='game_completion'>
														Game Completion
													</label>
													 <input type='checkbox' id='game_completion_check_box' name='game_completion'/>
													 </div>
													 
													 </div>
													 
													
												</fieldset>
												
												
													
												<input type='submit' class='submit_button' id='league_form_submit_button' value='Submit' />
												
											</form>
										</div>
										</div>
					<div>
						<span>
							Edit a League
							<a href='#my_leagues' class='fancybox'>+</a>
						</span>
					</div>
					<div class='' id='my_leagues' style='display:none'>
						<header>
						</header>
						<div>";
						$my_leagues = $mysql_connection->selectQuery("select creator from leagues where id= {$user->id}");
							if(empty($my_leagues))
								$this->body .= "<span> You have no active leagues to edit</span>";
							else{
								foreach ($my_leagues as $key => $value) 
									$this->body .="<div>{$key}</div>";
							
							}
						$this->body .= "</div>
					</div>
					
					</div>
				</div>";
							}else if($user->type == "gamer"){
						
						
						
						}else{
							$this->body .="<span>
									Create a League
									<a href='#league_form_container' class='fancybox' id='inline'>
										+
									</a>
								</span>
								<div class='form_container' id='league_form_container' style='display:none'>
										
											<form  id='manager_signup_form' method='post' action='/php/addmanager.php'>
				                      			<fieldset>
			 	                         			<legend>
				 	                            		Personal Information
				                          			</legend>
					                         		<label for='manager_name'>
					                             		Username
					                          		</label>
					                         		<input type='text' name='manager_name' id='manager_name' />
													<br/>
					 								<label for='manger_email'>Email</label>
													<input type='email' name='manager_email' />
													<br/>
		   											<label for='manager_password'>Password</label>
					 								<input type='password' name='manager_password'/>
					 								<br/>
					 								<label for='manager_age'>Birthday</label>
													<input type='date' name='manager_age'/>
													<input type='submit' value='Join Now!'/>
												</fieldset>
											</form>
											
											<form action='/php/login.php' method='post'>
													<legend>
														Login
													</legend>
				  									<fieldset>
				  									<label for='email'>
				  										Email
				  									</label>
													<input type='text' name='email' />
													<label for='password'>
				  										Password
				  									</label>
													<input type='password' name='password' />
													<input type='submit' value='login' /> 
													</fieldset>	
												</form>
								</div>
								
								</div>
					<div>
						<span>
							Edit a League
							<a href='#league_form_container' class='fancybox'>+</a>
						</span>
					</div>
					
				</div>
						";
						}
						
						$leagues = $mysql_connection->selectQuery("select * from leagues");
						
						$this->body .="
					
				<div class='content_module_body' id='league_module_body'>
					<div id='league_module_body_header'>
						<div id='search_for_league_module'>
							<header id='search_for_league_header'>
								<span>
									Search For a League
								</span>
								<div>";
								
									
							$this->body .= "</div>
							<footer id='search_for_league_header_footer'>
								<form rel='async' method='post' action='#' onsubmit=''>
									<input type='text' id='league_search_text_box' name='league_search' placeholder='Enter the name of a league'/>
									<input type='submit' id='league_search_submit_button' />
								</form>
							</footer>
							</header>";
							
						$this->body .= "
						<div id='search_for_league_body'>
							
						<div>
						<footer id='search_for_league_footer'>
							
						<footer>
						</div>
					</div>
					";
						$this->body .= "
					<div id='league_module_body_body'>
					<div id='league_table'>
						<header id='league_table_header'>
							<span>
								Leagues
							</span>
						</header>
						<table>
							<tbody>
								<tr>
									<th>
										Name
									</th>
									<th>
										Creator
									</th>
									<th>
										Type
									</th>
									<th>
										Privacy
									</th>
									<th>
										Status
									</th>
								</tr>
								
								";
								foreach ($leagues as $row) {
										$l=unserialize($row['league']);
										
									$this->body .="
										<tr>
											<td>
												{$l->name}
											</td>
											<td>
												{$l->creator}
											</td>
											<td>
												{$l->type}
											</td>
											<td>
												{$l->privacy}
											</td>";
											if($l->status == "drafting"){
													
												$this->body .= "
													<td>
														<a href='draft.php?draft_session_name={$l->name}'>
															{$l->status}
														</a>
												";
											}else{
												$this->body .= "
													<td>
															{$l->status}
												";
											}
												
											
												
											$this->body .="</td>
										</tr>
									";
								}
								
							
							$this->body .="</tbody>
						</table>
					</div>
				</div>
				
				<div class='module_footer' id='league_module_footer'>
				</div>
			</div>
		</div>
		</div>
		</div>
		</div>
		</div>
		 <div class='page_body_footer'>
		</div>
	
	";
	
	$mysql_connection->close();
	$mysql_connection = null;
}
}

try{
	

		setUser();
		$page = new LeaguePage($user);
	
}catch(Exception $ex){
	print_r($ex);
}
?>