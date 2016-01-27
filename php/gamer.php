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
	public function gamerProfilePageModules(){
		
		if( $_SERVER["REQUEST_METHOD"] == "GET"){
	if(!isset($_GET['id'])){
		
	}else{
		session_name("fgs");
		session_start();
		$id = null;
			$id = $_GET["id"];
		
				if(isset($_SESSION["user"])){
					 $user = unserialize($_SESSION["user"]);
				$mysql = new FantasyGamingDataBase();
				$result = $mysql->selectQuery("select * from gamers where id ='" .$id ."'")->fetch_assoc();
				$email = $result['email'];
				$name = $result['username'];
				$xbox_tag = $result['xbox_id'];
				$psn_tag = $result['psn_id'];
				$rank = $result['rank'];
				$games = unserialize($result["games"]);
				if(!empty($xbox_tag)){
					$xuid = $result["xbox_uid"];
					$xbox_api = new XboxApi();
					$xbox_profile = unserialize($result["xbox_profile"]);
					$xbox_activity = $xbox_api->getGamerActivity($xuid);
					
				}
				if(!empty($psn_tag)){
					$psn_profile = unserialize($result["psn_profile"]);
				}
				if($user->type == "gamer"){
					
				$this->body="
					<section class='page_body'>
					<div class='page_body_header'>";
					if($this->checkForErrors()){
			
						$this->body .= $this->getErrorModule();
						$_SESSION["error"] = null;
					}
					
					$this->body .="</div>
					<div class='module_container' id='gamer_profile_module_container'>
						<div class='module_content' id='gamer_profile_module'>
							<header class='module_header' id='gamer_profile_module_header'>
								<span class='username_display'>
									{$name}
								</span>
							";
				
			
							if(isset($xbox_profile)){
								$this->body .="<div>
								<img class='xbox_profile_pic' id='{$name}_xbox_profile_pic' src='{$xbox_profile['AppDisplayPicRaw']}'/>
								</div>";
							}
							if(isset($psn_profile)){
								$this->body .="<div>
								<img class='psn_profile_pic' id='{$name}_psn_profile_pic' src=''/>
								</div>";
							}
							$this->body .="
							<div class='profile_page_contact_information'>
								<div>
									<span>
										Email:
										<a href='mailto:{$email}'>
											{$email}
										</a>
									<span>
								</div>
							
							</div>
							</header>
							<div class='module_body' id='gamer_profile_module_body'>
								<div class='module_body_header' id='gamer_profile_module_body_header'>
								<div>
								<div class='module_body_body' id='gamer_profile_module_body_body'>
									<div class='gamer_profile_rank_section'>
										<img />
										<span class='gamer_rank_display'>
											{$rank}
										</span>
									</div>
									<div class='gamer_profile_games_played_section'>
										<table class='gamer_games'>
											<tr class='gamer_games_header'>
												<th>
													Name
												</th>
												<th>
													Console
												</th>
												<th>
													Genre
												</th>
												<th>
													Stats
												</th>
											</tr>
											<tbody>";
											
											if(!empty($games["xbox"]["xboxone"])){
												
												foreach($games["xbox"]["xboxone"] as $key =>$value){
													//print_r($value);
													if($key == "gamerscore")
														continue;
														
													$game_details = $mysql->selectQuery("select details from games where name = '{$mysql->connection->real_escape_string($key)}' ")->fetch_assoc();
													
													
													$genre = unserialize($game_details["details"]);
												
													$this->body .="
													<tr class='gamer_game'>
														<td class='game_name'>
															{$key}
														</td>
														<td class='game_console'>
															Xbox One
														</td>
														<td class='game_genre'>
														{$genre['genres'][0]}
														</td>
														<td class='game_stats'>
														<ul>
															
														";
														if(!empty($value["ingamestats"])){
															$this->body .="
																<li class='game_in_game_stats'>
																	In-Game Stats
																	<ul>";
																	foreach($value["ingamestats"] as $k => $v) {
																		$this->body .="
																				<li>
																				{$k} : {$v}
																				</li>
																			
																		";
																	}
																		
																$this->body .="</ul>
																</li>
																
																<li class='game_general_stats'>
																	General Stats
																	<ul>";
																		foreach($value["generalstats"] as $k => $v) {
																			if($k == "MinutesPlayed" || $k == "GameProgress")
																				continue;
																		$this->body .="
																				<li>
																				{$k} : {$v}
																				</li>
																			
																		";
																	}
																$this->body .="
																</ul>
																</li>
																<li class='game_achievements'>
																	Achievements
																	<ul>";
																	foreach($value["achievements"] as $k => $v) {
																		
																			$this->body .="
																				<li>
																					{$v['name']} : {$v['description']} 
																				</li>
																			
																		";
																		
																		
																		
																	}
																$this->body .="
																</ul>
																</li>
																<li>
																	Game Completion
																		<div>
																			<span>
																				{$value["generalstats"]["GameProgress"]}
																			</span>
																		<div>
																</li>
																<li>
																	Time Played
																	<div>
																			<span>
																				{$value["generalstats"]["MinutesPlayed"]}
																			</span>
																		<div>
																</li>
																";
																	
															}else{
																$this->body .="
																<li>
																	General Stats
																	<ul>";
																		foreach($value["generalstats"] as $k => $v) {
																			if($k == "MinutesPlayed" || $k == "GameProgress")
																				continue;
																		$this->body .="
																				<li>
																				{$k} : {$v}
																				</li>
																			
																		";
																	}
																$this->body .="
																</ul>
																</li>
																<li>
																	Achievements
																	<ul>";
																	foreach($value["achievements"] as $k => $v) {
																		
																			$this->body .="
																				<li>
																					{$v['name']} : {$v['description']}
																				</li>
																			
																		";
																		
																	}
																$this->body .="
																</ul>
																</li>
																<li>
																	Game Completion
																		<div>
																			<span>
																				{$value["generalstats"]["GameProgress"]}
																			</span>
																		<div>
																</li>
																<li>
																	Time Played
																	<div>
																			<span>
																				{$value["generalstats"]["MinutesPlayed"]}
																			</span>
																		<div>
																</li>
																";
															}
															
														$this->body.= "
														</ul>
														</td>
													</tr>
													";
												}
											}
											$this->body .="</tbody>
										</table>
									</div>
									<div class='gamer_profile_leagues_section'>
										<table>
											<tr>
												<th>
													Name
												</th>
												<th>
													Teams
												</th>
												<th>
													Status
												</th>
												<th>
													Performance
												</th>
											</tr>
										</table>
									</div>
									
								</div>
								<div class='module_body_footer' id='gamer_profile_module_body_footer'>
								<div>
							</div>
							<div class='module_footer' id='gamer_profile_module_footer'>
									<header class='module_footer_header'>";
									$twitch_api = new TwitchApi();
										$this->body .="<div class='module_footer_header_account_query' id='module_footer_header_twitch_account_query'>
											<hgroup>
												<h1>
													Do You Have a Twitch account?
												</h1>
												<h3>
													Sign in so everyone can see your channels glory
												</h3>
											</hgroup>
											<div id='twitch_signin_button'>
			                                        <span>
				                                           <a href='#'>
				                                               Sign In
				                                           </a>
			                                        </span>
		                                    </div>
										</div>
									</header
							</div>
							<div class='page_body_footer'>
							
							</div>
							
					";
					
					
					$mysql->close();
					
			}else{
			
					$this->body .="
					<section class='page_body'>
					<div class='page_body_header'>";
					if($this->checkForErrors()){
			
						$this->body .= $this->getErrorModule();
						$_SESSION["error"] = null;
					}
					
					$this->body .="</div>
					<div class='module_container' id='gamer_profile_module_container'>
						<div class='module_content' id='gamer_profile_module'>
							<header class='module_header' id='gamer_profile_module_header'>
								<span class='username_display'>
									{$name}
								</span>
							";
							
							if(isset($xbox_profile)){
								$this->body .="<div>
								<img class='xbox_profile_pic' id='{$name}_xbox_profile_pic' src='{$xbox_profile['AppDisplayPicRaw']}'/>
								<div>";
							}
							if(isset($psn_profile )){
								$this->body .="<div>
								<img class='psn_profile_pic' id='{$name}_psn_profile_pic' src=''/>
								<div>";
							}
							$this->body .="
							<div class='profile_page_contact_information'>
								<div>
									<span>
										Email:
										<a href='mailto:{$email}'>
											{$email}
										</a>
									<span>
								</div>
							
							</div>
							</header>
							<div class='module_body' id='gamer_profile_module_body'>
								<div class='module_body_header' id='gamer_profile_module_body_header'>
								<div>
								<div class='module_body_body' id='gamer_profile_module_body_body'>
									<div class='gamer_profile_rank_section'>
										<img />
										<span class='gamer_rank_display'>
											{$rank}
										</span>
									</div>
									<div class='gamer_profile_games_played_section'>
										<table>
											<tr>
												<th>
													Name
												</th>
												<th>
													Console
												</th>
												<th>
													Genre
												</th>
												<th>
													Stats
												</th>
											</tr>
											<tbody>";
											
											if(!empty($games["xbox"]["xboxone"])){
												
												foreach($games["xbox"]["xboxone"] as $key =>$value){
													//print_r($value);
													if($key == "gamerscore")
														continue;
														
													$game_details = $mysql->selectQuery("select details from games where name = '{$mysql->connection->real_escape_string($key)}' ")->fetch_assoc();
													
													
													$genre = unserialize($game_details["details"]);
												
													$this->body .="
													<tr>
														<td>
															{$key}
														</td>
														<td>
															Xbox One
														</td>
														<td>
														{$genre['genres'][0]}
														</td>
														<td>
														<ul>
															
														";
														if(!empty($value["ingamestats"])){
															$this->body .="
																<li>
																	In-Game Stats
																	<ul>";
																	foreach($value["ingamestats"] as $k => $v) {
																		$this->body .="
																				<li>
																				{$k} : {$v}
																				</li>
																			
																		";
																	}
																		
																$this->body .="</ul>
																</li>
																
																<li>
																	General Stats
																	<ul>";
																		foreach($value["generalstats"] as $k => $v) {
																			if($k == "MinutesPlayed" || $k == "GameProgress")
																				continue;
																		$this->body .="
																				<li>
																				{$k} : {$v}
																				</li>
																			
																		";
																	}
																$this->body .="
																</ul>
																</li>
																<li>
																	Achievements
																	<ul>";
																	foreach($value["achievements"] as $k => $v) {
																		
																			$this->body .="
																				<li>
																					{$v['name']} : {$v['description']} 
																				</li>
																			
																		";
																		
																		
																		
																	}
																$this->body .="
																</ul>
																</li>
																<li>
																	Game Completion
																		<div>
																			<span>
																				{$value["generalstats"]["GameProgress"]}
																			</span>
																		<div>
																</li>
																<li>
																	Time Played
																	<div>
																			<span>
																				{$value["generalstats"]["MinutesPlayed"]}
																			</span>
																		<div>
																</li>
																";
																	
															}else{
																$this->body .="
																<li>
																	General Stats
																	<ul>";
																		foreach($value["generalstats"] as $k => $v) {
																			if($k == "MinutesPlayed" || $k == "GameProgress")
																				continue;
																		$this->body .="
																				<li>
																				{$k} : {$v}
																				</li>
																			
																		";
																	}
																$this->body .="
																</ul>
																</li>
																<li>
																	Achievements
																	<ul>";
																	foreach($value["achievements"] as $k => $v) {
																		
																			$this->body .="
																				<li>
																					{$v['name']} : {$v['description']}
																				</li>
																			
																		";
																		
																	}
																$this->body .="
																</ul>
																</li>
																<li>
																	Game Completion
																		<div>
																			<span>
																				{$value["generalstats"]["GameProgress"]}
																			</span>
																		<div>
																</li>
																<li>
																	Time Played
																	<div>
																			<span>
																				{$value["generalstats"]["MinutesPlayed"]}
																			</span>
																		<div>
																</li>
																";
															}
															
														$this->body.= "
														</ul>
														</td>
													</tr>
													";
												}
											}
											$this->body .="</tbody>
										</table>
									</div>
									<div class='gamer_profile_leagues_section'>
										<table>
											<tr>
												<th>
													Name
												</th>
												<th>
													Teams
												</th>
												<th>
													Status
												</th>
												<th>
													Performance
												</th>
											</tr>
										</table>
									</div>
									<div class='gamer_activity_section'>
										<div class='xboxone_activity'>";
											foreach ($xbox_activity as $key => $value) {
													$this->body .="
														<div class='gamer_activity'>
															<span>
																{$value['description']} for  {$value['platform']} on {$value['date']}
															</span>
														</div>
													";
											}
										$this->body.="</div>
									</div>
								</div>
								<div class='module_body_footer' id='gamer_profile_module_body_footer'>
								<div>
							</div>
							<div class='module_footer' id='gamer_profile_module_footer'>
									<header class='module_footer_header'>
									</header>
							</div>
							<div class='page_body_footer'>
							
							</div>
							
					";
					
					
					$mysql->close();
			}
				
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