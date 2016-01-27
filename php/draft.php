<?php
require_once("class.fantasygamingdatabase.php");
require_once("class.draft.php");
require_once("class.manager.php");
require_once("class.page.php");
require_once("class.league.php");
require_once("functions.php");
class DraftPage extends Page{
	
	public $draft  = null;
	public $league = null;
	public function __construct($user){
		
		$this->draftPageModules();
		parent::__construct($user);
		$this->printPage();	
	}
	public function draftPageModules(){
	
		$mysql_connection = null;
		$availible_gamers = null;
		$current_user     = null;
		$league           = null;

	if($_SERVER["REQUEST_METHOD"] == "GET"){
		session_name("fgs");
		session_start();
		if(!isset($_SESSION["user"])){
			header("Location:404.php");
			exit;
		}
	
		
		try{
			
			if(empty($_GET["draft_session_name"])){
				header("Location:404.php");
				exit;
			}
				
			if(isset($_GET["draft_session_name"])){
				$draft_session_name = htmlentities($_GET["draft_session_name"]);
				$mysql_connection = new FantasyGamingDataBase();
				$params = array($draft_session_name);
				$league = $mysql_connection->selectQuery("select * from leagues where name = ?", $params);
				
				if($league["name"] == $draft_session_name){
				$current_user = unserialize($_SESSION["user"]); 
				
					$this->league = unserialize($league["league"]);
							if(empty($league["draft"]))
								 $this->draft = new Draft($league['creator'],$league['name'] ,$this->league->draft_type);
					  else
						   $this->draft = unserialize($league["draft"]);
			
				
				$creator = $mysql_connection->selectQuery("select * from managers where username ='{$league['creator']}'")->fetch_assoc();
				
				$this->body ="<section class='page_body'>
								<div class='page_body_header'>
								</div>
								<div class='page_body_body'>
									<div class='module_container' id='managers_module_container'>
									<div class='module' id='managers_module'>
									<header id='managers_module_header'>
										<span>
												League Creator
											</span>
											<span>
												<a href='manager.php?id={$creator['id']} ' class='draft_member_name' id='league_creator'>
													{$league['creator']}
												</a>
											</span>
									</header>
									<div class='module_body' id='managers_module_body'>
									";
										//if(count($this->draft->members) < $this->league->number_of_teams && $current_user->username != $league["creator"]){
				    						
										//}	
					$this->body .="
						<h2>
							League Members
						</h2>
					";
					///print_r($current_user->username);
					$managers = $mysql_connection->selectQuery("select * from managers ");
					
							$this->body .="
								<div class='draft_member' id=''>
									";
									$amember = false;
							foreach($this->draft->members as $key){
								
									if($key == $current_user->username)
										$amember = true;
								$this->body .="
											<span>
												<a href='manager.php?id='' ' class='draft_member'>
													{$key}
												</a>
											</span>";
											echo var_dump($amember);
							}
							$this->body .="
										</div>
										</div>";
										
										if($amember == false && $current_user->type == "manager"){
											$this->body .="<button id ='add_manager_to_league_button' onclick='Draft.ManagerModule.addManager(this,\"{$current_user->username}\")'>
												Join League
											</button>
											";
										}
										$this->body .="<div class='module_footer' id='managers_module_footer'>
										
										</div>
										</div>
										</div>
							";
							
						
						
					
					
					if($this->league->type == "standard" && $this->league->sub_type == "custom"){
						  	$scoring_method_achievements = false;
							$scoring_method_in_game_stats = false;
							$scoring_method_time_played = false;
							$scoring_method_game_completion = false;
							$scoring_method_gamer_score = false;
					     foreach(unserialize($league["league"])->scoring_methods as $key){
					     	
					        switch($key){
					            case "Game Achievements" : 
									$scoring_method_achievements = true;
					            break; 
								case "Gamer Points" :
									$scoring_method_gamer_score = true;
								break;
								case "Time Played" :
									$scoring_method_time_played  = true;
								break;
								case "Game Completion" :
									$scoring_method_game_completion = true;
								break;
								case "In-Game Stats" :
								$scoring_method_in_game_stats = true;
								break;
					        }
					    }
				    
				                                                                                                                                                         
				   $this->body .="
				  
				  
				    <div class='module_container' id='availible_gamers_module_container'>
				    	<div class='module' id='availible_gamers_module'>
				    	<header id='availible_gamers_module_header'>
				    	</header>
				    		<table>
				    		<tbody>
				    			<tr>
				    			<th>
				    				Gamer
				    				 
				    			</th>
				    			<th>
				    				Game
				    				 
				    			</th>
				    			";
									
				    				if($scoring_method_achievements){
										$this->body .="
											<th>
												Achievements
											</th>
										";
									}
									if($scoring_method_time_played){
										$this->body .="
											<th>
												Time Played
											</th>
										";
									}
									if($scoring_method_game_completion){
										$this->body .="
											<th>
												Game Completions
											</th>
										";
									}
				    				if($scoring_method_gamer_score){
										$this->body .="
											<th>
												Gamer Score
											</th>
										";
									}
				    				if($scoring_method_in_game_stats){
										$this->body .="<th>
													In-Game Stats
											</th>
										";
									}
				    			$this->body .="</tr>
				    			
				    		";
							
						}
					
					$consoles=array();
					$availible_gamers = array();
					
					foreach($this->league->consoles as $key){
							array_push($consoles,$key);
					}
					$gamers = $mysql_connection->selectQuery("select id,username,games from gamers")->fetch_all(MYSQL_ASSOC);
					$games = $mysql_connection->selectQuery("select * from games")->fetch_all(MYSQL_ASSOC);
					
					foreach($gamers as $row){
					
						$g = unserialize($row["games"]);
						$availible_gamers[$row["username"]];
						if($consoles[array_search("xboxone", $consoles)] ){
								foreach ($games as $key) {
										
										foreach (unserialize($key["console"]) as $k) {
											if($k == "xboxone"){
												
												foreach ($g["xbox"]["xboxone"] as $z => $y) {
													
														if(!is_array($value) && $key != "gamerscore")
															//unset($g["xbox"]["xboxone"][$z]);
														if($z == 0 || $z == "0"){
															if(!is_array($value))
																unset($g["xbox"]["xboxone"][0]);	
														}
													for($i =0; $i < count($this->league->games); $i++){
														if($z == $this->league->games[$i]){
															$availible_gamers[$row["username"]][$z] = $g["xbox"]["xboxone"][$z];
															$availible_gamers[$row["username"]]["gamerscore"] = $g["xbox"]["xboxone"]["gamerscore"];
															$availible_gamers[$row["username"]]["ingamestats"] = $g["xbox"]["xboxone"][$z]["ingamestats"];
															break;
														}
													}
												}
											}
										}
									
								}	
						}
						if($consoles[array_search("xbox360", $consoles)] ){
								foreach ($games as $key) {
										foreach (unserialize($key["console"]) as $k) {
											if($k == "xbox360"){
												foreach ($g["xbox"]["xbox360"] as $z => $y) {
														if(!is_array($y) && $z != "gamerscore")
															unset($g["xbox"]["xbox360"][$z]);
													for($i =0; $i < count($this->league->games); $i++){
														if($z == $this->league->games[$i]){
															array_push($availible_gamers[$row["username"]],$g["xbox"]["xbo360"][$z]);
															break;
														}
													}
												}
											}
										}
									
								}	
						}
						if(!empty($g["ps"]["ps4"])){
							foreach($g["ps"]["ps4"] as $key => $value){
								if(!is_array($value) && $key != "gamerscore")
									unset($g["ps"]["ps4"][$key]);
							}
						}
						if(!empty($g["ps"]["ps3"])){
							foreach($g["ps"]["ps3"] as $key => $value){
								if(!is_array($value) && $key != "gamerscore")
									unset($g["ps"]["ps3"][$key]);
							}
						}
						if($availible_gamers[$row["username"]])
						$availible_gamers[$row["username"]]["id"] = $row["id"];
				} 
			
			
			if(count($availible_gamers) < 1 ){
				$this->body .="
					<tr>
						<td>
							There are not enough gamers availible for this league.
							The draft will be postponed until enough gamers are availible.
						</td>
					</tr>
				";
			}else if(count($this->draft->members) < $this->league->number_of_teams){
				$this->body .="
					<tr>
						<td>
							Waiting for Managers to join league.
						</td>
					</tr>
				";
			}else{
      		$this->draft->setGamers($availible_gamers);
		    if(unserialize($_SESSION["user"])->username != $league['creator']){
			    
			   }else{
			   }
			 	   
			 	  $this->body .="
			 	  	<h2>
			 	  		Gamers Avaliable For Pick 
			 	  	</h2>
			 	  "; 
			 	  if($this->league->type == "standard" && $this->league->sub_type == "custom"){
				    foreach ($availible_gamers as $key => $value) {
				    			
								$this->body .= "
									<tr class='availible_gamer_in_draft' id='{$key}'>
										<td>
											<a href='gamer.php?id={$value['id']}'>
												{$key}
											</a>
											<input type='checkbox' class='checkbox' id='' name=''/>
										</td>
										";
											foreach ($value as $k => $v) {
														$this->body .= "
															<td>
																{$k}
															</td>";
															break;
											}
									
									if($scoring_method_achievements){
											
													foreach ($value as $k => $v) {
													
														foreach ($v as $a => $b) {
															
															if($a == "achievements"){
																$this->body .= "<td>";
																for($i = 0; $i < count($b);$i++){
																		$this->body .= "
																		
																	{$b[$i]['name']}
																	
															";
																}
															
															}
														}
													break;
													}
												$this->body .= "
															</td>
														";
												
									
									}	
									if($scoring_method_time_played ){
										foreach ($value as $k => $v) {
													
														foreach ($v as $a => $b) {
															
															if($a == "generalstats"){
															
																$this->body .= "<td>
																	{$b['MinutesPlayed']}
																	
															";
															break;
															}
														}
													break;
													}
											$this->body .= "
															</td>
														";
									}
									if($scoring_method_game_completion){
										
										$gc = 0;
										foreach ($value as $k => $v) {
													
														foreach ($v as $a => $b) {
															
															if($a == "generalstats"){
																
																	if($b["GameProgress"] == 100)
																		$gc++;
																
																
															
															}
														}
													break;
													}
											$this->body .= "<td>
																	{$gc}
																</td>	
															";
									
									}
									if($scoring_method_gamer_score){
										$this->body .= "<td>
											{$value['gamerscore']}
											</td>
										";
								
													
										
									}
									if($scoring_method_in_game_stats){
											if($value["ingamestats"]){
												
												$this->body .= "
													<td>";
												foreach ($value["ingamestats"]as $stat => $s) {
													$this->body .= "
														{$stat} = {$s}";
												}
												$this->body .= "
													
													</td>
												";		
											}else{
												$this->body .= "
													<td>
														Nothing to see here.
													</td>
												";
											}
									}
							}
						}
					}
									$this->body .="</tr>
									</tbody>
									 	</table>
									 	</div>
			   		</div>
									";
									
					
					 
			    $this->body .="	
			  
			  
			   			
			   	<footer class='page_body_footer'>
			   	</footer>
			   </div>
			 
				";
			
				$this->draft = serialize($this->draft);
				$mysql_connection->updateQuery("update leagues set draft = '{$this->draft}' where name = '{$league['name']}' ");
				$mysql_connection->close();
				
				}else{
					header("Location:404.php");
					exit;
				}
				
			}

		}catch(Exception $ex){
			print_r($ex);
		}
		
	}
}
}//end of class
try{
	 	
	setUser();
	$page = new DraftPage($user);
}catch(Exception $ex){
print_r($ex);
}
?>