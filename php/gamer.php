<?php
require_once("class.fantasygamingdatabase.php");
require_once("class.user.php");
require_once("class.gamer.php");
require_once("class.page.php");
require_once("class.xboxapi.php");
require_once("class.psnapi.php");
require_once("class.twitchapi.php");
require_once("functions.php");
class GamerProfilePage extends Page{
	
	public function __construct($user){
		
		$this->gamerProfilePageModules();
		parent::__construct($user);
		$this->printPage();
	}
	public function pageWithNoGameData(){
		
		$this->body="
					<section class='page_body'>
					<div class='page_body_header'>";
					if($this->checkForErrors()){
			
						$this->body .= $this->getErrorModule();
						$_SESSION["error"] = null;
				}
					$this->body .="</div>
					<div class='module_container' id='gamer_profile_module_container'>
						<div class='module' id='gamer_profile_module'>
							<header class='module_header' id='gamer_profile_module_header'>
								<span class='gamer_profile_header_username'>
									
								</span>
								<footer class='module_header_footer' id='gamer_profile_header_footer'>
							
							</footer>
							</header>
							";
				
	}
	public function gamerProfilePageModules(){
		
		if( $_SERVER["REQUEST_METHOD"] == "GET"){
	if(!isset($_GET["id"]) || $_GET['id'] == "" || empty($_GET)){
		session_name("fgs");
		session_start();
		if(isset($_SESSION["id"])){
			header("Location:gamer.php?id=".$_SESSION["id"][session_id()]);
		
		}else{
			header("Location:404.php");
			exit;
		}
			
	}else{
		session_name("fgs");
		session_start();
		
		if(isset($_SESSION["user"])){
			
			$user_id = null;
			$user_email = null;
			$database_gamer_data = null;
			$username = null;
			$xbox_username = null;
			$psn_username  = null;
			$users_games       = null;
			$users_rank = null;
			$session_user_data = null;
			$mysql_database_connection = null;
			
			$user_id  = htmlentities($_GET["id"]);
			$session_user_data = unserialize($_SESSION["user"]);
			$mysql_database_connection = new FantasyGamingDataBase();
			
			if($session_user_data == "" || $session_user_data == null || empty($session_user_data) || !isset($session_user_data)){
					
			}else if(!($session_user_data instanceof Gamer)){
				
				
			}
			$database_gamer_data = $mysql_database_connection->selectQuery("select * from gamers where id ='" .$user_id  ."'")->fetch_assoc();	
				if($database_gamer_data == "" || $database_gamer_data == null || empty($database_gamer_data) || !isset($database_gamer_data)){
					
				}
				//print_r($database_gamer_data);
				//print_r("session object :");
				//print_r($session_user_data);
				//print_r("database object :");
				//print_r($database_gamer_data);
				$user_email = $database_gamer_data['email'];
				$username = $database_gamer_data['username'];
				$xbox_username = $database_gamer_data['xbox_id'];
				$psn_username = $database_gamer_data['psn_id'];
				$users_rank = $database_gamer_data['rank'];
				//$users_games = json_decode($database_gamer_data["games"]);
				$users_games = unserialize($database_gamer_data["games"]);
				$profiles = unserialize($database_gamer_data["profile"]);
				$game_data = false;
				
				
				
				if(!empty($xbox_username) ){
						
					
						
						//$xbox360_games = json_decode($users_games->xbox->xbox360);
						//$xboxone_games = json_decode($users_games->xbox->xboxone);
						$xbox360_games = $users_games["xbox"]["xbox360"];
						$xboxone_games = $users_games["xbox"]["xboxone"];
						$xuid = $database_gamer_data["xbox_uid"];
						
						print_r($users_games);
						$xbox_profile   = $profiles["xbox"];
						$card = $xbox_profile["gamercard"];
						
						$profile = $xbox_profile["profile"];
						$xbox_profile = array("name" => $card["name"],"gamertag" => $card["gamertag"],"location"=>$card["location"],"bio" =>$card["bio"],"gamerscore" => $card["gamerscore"], "tier"=>$card["tier"], "motto" => $card["motto"] ,"avatar" => $card["avatarBodyImagePath"], "host" => $profile["hostId"], "rep" => $profile["XboxOneRep"], "mainpic" => $profile["GameDisplayPicRaw"], "pic" => $card["gamerpicLargeSslImagePath"], "sponsored" => $profile["isSponsoredUser"]);
						
						////$xbox_activity = $xbox_api->getGamerActivity($xuid);
						//$xbox_api = new XboxApi();
						$game_data = true;
					
					
						
				}
				if(!empty($psn_username)){
					
					if( game_data == true ){
						
						$ps3_games = $users_games["ps"]["ps3"];
					
						$ps4_games = $users_games["ps"]["ps4"];
						
					}
					if($profiles){
						$psn_profile = $profiles["ps"];
						$psn_profile = array("about_me" => $psn_profile["about_me"], "name" => $psn_profile["psn_id"],"location"=>$psn_profile["country"],"gamerscore" => $psn_profile["points"] ,"avatar" => $psn_profile["avatar"] ,"total_games" =>$psn_profile["total_games"],"total_trophies"=>$psn_profile["total"]);
						
			
					}else{
						$profiles = unserialize($database_gamer_data["profile"]);
						$psn_profile = $profiles["ps"];
					$psn_profile = array("about_me" => $psn_profile["about_me"], "name" => $psn_profile["psn_id"],"location"=>$psn_profile["country"],"gamerscore" => $psn_profile["points"] ,"avatar" => $psn_profile["avatar"] ,"total_games" =>$psn_profile["total_games"],"total_trophies"=>$psn_profile["total"]);
						
					}
					
					
				}
			
				
					$this->body="
					<section class='page_body'>
					<header class='page_body_header'>";
					if($this->checkForErrors()){
			
						$this->body .= $this->getErrorModule();
						$_SESSION["error"] = null;
				}
					$this->body .="</header>
					<div class='page_body_body'>
					<div class='profile_container' id='gamer_profile_container'>
						<div class='profile' id='gamer_profile'>
							";
				
							if($game_data){
									 
								$this->body .= "
								
							<header class='profile_header' id='gamer_profile_header'>
								<header>
									<span id='profile_header_username'>
										{$username}
									<span>
									<span>	
									 Grinds On 
									 </span>
								</header>
								<div id='gamer_profile_header_body'>
									
								<div>";
								if($xbox_profile){
									
									$this->body .="<div id='xbox_profile_pic'>
										
											<img src='{$xbox_profile['mainpic']}'/>
											
										</div>";
									}
								if($psn_profile){
								
									$this->body .="<div id='psn_profile_pic'>
										
										<img src='{$psn_profile['avatar']}'/>
										</div>
								</div>";
								}

								$this->body .="<div id='ps4_container'>
									<div id='ps4'>
										 	<img src='/img/' />
									</div>
									<div id='xboxone'>
										<img src='/img/' />
									</div>
								</div>
									
								</div>
								<footer class='profile_header_footer' id='gamer_profile_header_footer'>
								<div>
									<nav id='gamer_profile_header_footer'_nav	'>
										<ul>
											<li>
												<a href='' />
													Profiles
												</a>
												<ul id='gamer_profile_profiles_list'>		
												";
													if($xbox_profile){
														$this->body .="
															<li>
																<a href='' id='gamer_profile_xbox_profile_link'>
																	Xbox
																</a>
															</li>
														
														";
													}
													if($psn_profile){
														$this->body .="
															<li>
																<a href='' id='gamer_profile_psn_profile_link'>
																	PSN
																</a>
															</li>
															
															
														";
													}
												$this->body .= "</ul>
											</li>
											<li>
												<a href='' id='gamer_profile_games_link' />
													Games
												</a>
												<div id='gamer_profile_games_container'>
														<table id='gamer_profile_games_table'>
														<tbody>
															<tr class='table_header' id='gamer_profile_games_table_header'>
																<th>
																	Console
																</th>
																<th>
																	Genre
																</th>
																<th>
																	Name
																</th>
																<th>
																	Stats
																</th>
																
															</tr>
															";
															if($xbox360_games){
																foreach($xbox360_games as $key ){
																	
																	$this->body .= "
																	<tr>
																		<td>
																			<a href=''>
																				Xbox360
																			</a>
																		</td>
																		<td>
																			<a href=''>
																				?
																			</a>
																		</td>
																		<td>
																			<a href=''>
																				{$key->name}
																			</a>
																		</td>
																		<td>
																			<a href=''>
																				?
																			</a>
																		</td>
																	</tr>
																	";
																}
																}
																if($xboxone_games){
																foreach($xboxone_games as $key ){
																	
																	$this->body .= "
																	<tr>
																		<td>
																			<a href=''>
																				XboxOne
																			</a>
																		</td>
																		<td>
																			<a href=''>
																				?
																			</a>
																		</td>
																		<td>
																			<a href=''>
																				{$key->name}
																			</a>
																		</td>
																		<td>
																			<a href=''>
																				?
																			</a>
																		</td>
																	</tr>
																	";
																}
																}
																if($ps3_games){
																foreach($ps3_games as $key ){
																	
																	$this->body .= "
																	<tr>
																		<td>
																			<a href=''>
																				PS3
																			</a>
																		</td>
																		<td>
																			<a href=''>
																				?
																			</a>
																		</td>
																		<td>
																			<a href=''>
																				?
																			</a>
																		</td>
																		<td>
																			<a href=''>
																				?
																			</a>
																		</td>
																	</tr>
																	";
																}
																}
																if($ps4_games){
																foreach($ps4_games as $key ){
																	
																	$this->body .= "
																	<tr>
																		<td>
																			<a href=''>
																				PS4
																			</a>
																		</td>
																		<td>
																			<a href=''>
																				?
																			</a>
																		</td>
																		<td>
																			<a href=''>
																				?
																			</a>
																		</td>
																		<td>
																			<a href=''>
																				?
																			</a>
																		</td>
																	</tr>
																	";
																}
																}
															$this->body .= "</tbody>
														</table>
														
														
												</div>
												
											</li>
											<li>
												<a href='' />
													Leagues
												</a>
											</li>
											<li>
												<a href='' />
													News
												</a>
											</li>
										</ul>	
									</nav>
								</div>
							</footer>
							</header>
						<div class='profile_body' id='gamer_profile_module_body'>
							<div id='profile1'>
							<header>
								<div>
									{$rank}
								</div>
								
								<div>
									
								</div>
							</header>
							<div > 
								
								<div>
									<video>
										
									</video>
								</div>	
								<div>
									activity
								</div>
							</div>
						</div>
						
						
						
						
						
						
						
						
						
						<div id='profile2'>
							<header class='profile_header' id='xbox_profile_header'>
								
								<div id='xbox_profile_header_info_containter'>
									<div id='xbox_profile_header_basic_info'>
									<span class='xbox_profile_header' id='xbox_profile_name'>
									{$xbox_profile['name']}
									</span>
									</br>
									<span class='xbox_profile_header' id='xbox_profile_gamertag'>
									{$xbox_profile['gamertag']}
									</span>
									<span class='xbox_profile_header' id='xbox_profile_location'>
									</br >
									{$xbox_profile['location']}
									</span>
									</div>
									<div id='xbox_profile_header_stat_info'>
									
										 	<span id='xbox_profile_reputation_header'>
										 		Reputation
										 	</span>
										 	<br />
										 	<span id='xbox_profile_reputation'>
										{$xbox_profile['rep']}
									</span id='xbox_profile_gs'>
									<br />
									<span>
										GS = {$xbox_profile['gamerscore']}
									</span>
								
									<span id='xbox_profile_tg'>
										TG = 0
									</span>
									
									<span id='xbox_profile_ta'>
										TA = 0
									</span>
									<br />
									
										
								
									
									</div>
								</div>
							</header>
								<div class='profile_body' id='xbox_profile_body'> 
									
								  
								<div id='xbox_profile_avatar'>
										<img src='{$xbox_profile['avatar']}' />
										<div id='xbox_profile_avatar_bubble'>
										<span id='xbox_profile_motto'>
										{$xbox_profile['motto']}
										</span>
										<br />
										<span id='xbox_profile_bio'>
									{$xbox_profile['bio']}
										</span>
										
									</div>
									
									
								
								</div>
								
							</div>
							
						</div>
						<div id='profile3'>
							<header class='profile_header' id='psn_profile_header'>
								
								<div id='psn_profile_header_info_containter'>
									<div id='psn_profile_header_basic_info'>
									<span class='psn_profile_header' id='psn_profile_name'>
									{$psn_profile['name']}
									</span>
									</br>
									
									<span class='psn_profile_header' id='psn_profile_location'>
									</br >
											{$psn_profile['country']}
									</span>
									</div>
									<div id='psn_profile_header_stat_info'>
									
										 	<span id='psn_profile_reputation_header'>
										 		Reputation
										 	</span>
										 	<br />
										 	<span id='psn_profile_reputation'>
										
									</span id='psn_profile_gs'>
									<br />
									<span>
										Points ={$psn_profile['gamerscore']}
									</span>
								
									<span id='psn_profile_tg'>
										TG = {$psn_profile['total_games']}
									</span>
									
									<span id='psn_profile_ta'>
										TT = {$psn_profile['total']}
									</span>
									<br />
									
										
								
									
									</div>
								</div>
							</header>
								<div class='profile_body' id='psn_profile_body'> 
									
								<div id='psn_profile_avatar'>
									<img src='{$psn_profile['avatar']}' />
										<div id='psn_profile_avatar_bubble'>
										<span id='psn_profile_motto'>
											{$psn_profile['about_me']}
										</span>
									
								</div>
							</div>
						</div>
							</div>
						</div>
						
						
						<footer class='profile_footer' id='gamer_profile_footer'>
								<nav>
									<ul>
										<li>
											<a href=''>
												Twitch
											</a>
										</li>
										<li>
											<a href=''>
												Youtube
											</a>
										</li>
										<li>
											<a href=''>
												Facebook
											</a>
										</li>
										<li>
											<a href=''>
												Twitter
											</a>
										</li>
									</ul>
								</nav>
							</footer>
							</div>
							</div>
							</div>
							";
					
						}else{// if game data
				
					$this->body .= "
						<div class='module_body' id='no_gamer_profile_module_body'>
							<div>
								Waiting For Gamer Data...
							<div>
							<div class='waiting_for_data_container'>
								
								<div class='waiting_for_data'>
									
								</div>
							</div>
						</div>
					";
					
				}
					$this->body .= "
					
					<footer class='page_body_footer'>
								
								</footer>
								</div>
								"; 
								
				}else{
					header("Location:404.php");
					exit;
				}
			
			
		}
	}else{
		header("Location:404.php");
		exit;
	}
		}
}

try{
	setUser();
	$page = new GamerProfilePage($user);
}catch(Exception $ex){
	print_r($ex);
}
?>