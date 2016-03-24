<?php
require_once("class.page.php");
require_once("class.user.php");
require_once("class.fantasygamingdatabase.php");
require_once("functions.php");
	class UserSearchPage extends Page{
		
		public function __construct($user){
			
			
			$this->userSearchPageModules();
			parent::__construct($user);
			$this->printPage();
			
		}
		public function userSearchPageModules(){
	
	  if($_SERVER["REQUEST_METHOD"] == "GET"){
		
		  try{
	    	
			$mysql_connection = new FantasyGamingDataBase();
			
			$this->body = "<section class='page_body'>
			        	<div class='page_body_header'>";
						if($this->checkForErrors()){
			
			$this->body .= $this->getErrorModule();
			$_SESSION["error"] = null;
		}
				$this->body .="</div>
						<div class='page_body_body'>
						<div class='module_container' id='user_search_catagory_module_container'>
							<div class='module' id='user_search_catagory_module'>
								
								<div class='user_search_catagory' id='user_search_gamers_catagory'>
									<span>
										<a href='#gamers'>
											Grinders
										</a>
									</span>
								</div>
								<div class='user_search_catagory' id='user_search_managers_catagory'>
									<span>
										<a href='#managers'>
											Officials
										</a>
									</span>
								</div>
								<div class='user_search_catagory' id='user_search_games_catagory'>
									<span>
										<a href='#'>
											Games
										</a>
									</span>
								</div>
							</div>
						</div>
						<div class='module_container' id='gamer_search_module_container'>	
							<div class='module' id='gamer_search_module'>
							<header class='module_header' id='user_search_module_header'>
							</header>
							<div id='gamer_search_module_body'>
							
						";
						if(isset($_GET["search_for"]) && !empty($_GET["search_for"])){
							$search_term = htmlentities($_GET["search_for"]);
							$gamers   = $mysql_connection->selectQuery("select id , username , xbox_id,psn_id, rank from gamers where username like '%{$search_term}%'");
						$managers = $mysql_connection->selectQuery("select id, username from managers where username like '%{$search_term}%'");
						$games = $mysql_connection->selectQuery("select id,name,console,details from games where name like '%{$search_term}%'");
						}else if(empty($_GET["search_for"])){
							$gamers   = $mysql_connection->selectQuery("select id , username , xbox_id,psn_id, rank from gamers");
						$managers = $mysql_connection->selectQuery("select id, username from managers");
						$games = $mysql_connection->selectQuery("select id,name,console,details from games");
						}else{
							
						}
						if($gamers->num_rows == 0){
							
								$this->body .="
								<div class='search_result' id='no_search_results'>
			        				<span>
			        					No Gamers Found.
			        				</span>
								</div>
								</div>
								</div>
								
			        		";
						}else{
								$this->body .= "
							<table>
								<tbody>
							<tr class='table_header'>
								<th>
									Username
								</th>
								<th>
									XBL Name
								</th>
								<th>
									PSN Name
								</th>
								<th>
									Ranking
								</th>
							</tr>
			        	";
							
								
								foreach($gamers as $gamer ){
									
					        	$this->body .= "
					        		
					        		<tr class='table_data_row'>
										<td class='table_data' >
					        				<a href='gamer.php?id={$gamer['id']}'>" . $gamer["username"] . "
										</td>
										<td class='table_data'>
					        				" . $gamer["xbox_id"] . "
										</td>
										<td class='table_data'>
					        				" . $gamer["psn_id"] . "
										</td>
										<td class='table_data' >
					        				" . $gamer["rank"] . "
										</td>
									</tr>
										
					        	";
					        }
					        
						
					$this->body .="
					</tbody>
					</table>
						</div>
						</div>
					</div>	
					
					
					";
			 }
			 if($games->num_rows == 0){
							
								$this->body .="
								<div class='search_result' id='no_search_results'>
			        				<span>
			        					No Games Found.
			        				</span>
								</div>
								</div>
								</div>
								
			        		";
						}else{
								$this->body .= "
							<table>
								<tbody>
							<tr class='table_header'>
								<th>
									Name
								</th>
								<th>
									Console
								</th>
								<th>
									Players
								</th>
								<th>
									Summary
								</th>
							</tr>
			        	";
							
								
								foreach($games as $game ){
									
					        	$this->body .= "
					        		
					        		<tr class='table_data_row'>
										<td class='table_data' >
					        				<a href=''>" . $game["username"] . "
										</td>
										<td class='table_data'>
					        				" . $game["console"] . "
										</td>
										<td class='table_data'>
					        				" . $game["number_of_players"] . "
										</td>
										<td class='table_data' >
					        				" . $game["details"] . "
										</td>
									</tr>
										
					        	";
					        }
					        
						
					$this->body .="
					</tbody>
					</table>
						</div>
						</div>
					</div>	
					
					
					";
			 }
			 if($managers->num_rows == 0){
							
								$this->body .="<div class='module_container' id='manager_search_module_container'>	
							<div class='module' id='manager_search_module'>
							<header class='module_header' id='user_search_module_header'>
							</header>
							<div id='manager_search_module_body'>
								<div class='search_result' id='no_search_results'>
			        				<span>
			        					No Officials Found.
			        				</span>
								</div>
								</div>
								</div>
								</div>
								</div>
								
			        		";
						}else{
								$this->body .= "<div class='module_container' id='manager_search_module_container'>	
							<div class='module' id='manager_search_module'>
							<header class='module_header' id='user_search_module_header'>
							</header>
							<div id='manager_search_module_body'>
							<table>
								<tbody>
							<tr class='table_header'>
								<th>
									Username
								</th>
								
							</tr>
			        	";
							
								
								foreach($managers as $manager ){
									
					        	$this->body .= "
					        		
					        		<tr class='table_data_row'>
										<td class='table_data' >
					        				<a href='manager.php?id={$manager['id']}'>" . $manager["username"] . "
										</td>
										
									</tr>
										
					        	";
					        }
					        
						
					$this->body .="
					</tbody>
					</table>
						</div>
						</div>
					</div>	
					</div>
					<div class='page_body_footer'>
             </div>
					";
			        
			        $mysql_connection->close();
			 }
		  }catch(Exception $ex){
		  	
		  }
	}else{
		header("Location:php/404.php");
		exit;
	}
}
	}
try{
	setUser();
	$page = new UserSearchPage($user);
	 if(isset($_SESSION["current_page"])){
}
}catch(Exception $ex){
	print_r($ex);
}
?>