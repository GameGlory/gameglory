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
		$mysql_connection = null;
		  
	    if(isset($_GET["search_for"])){
	    	try{
	    	$search_term = htmlentities($_GET["search_for"]);
			$mysql_connection = new FantasyGamingDataBase();
			
			$this->body = "<section class='page_body'>
			        	<div class='page_body_header'>";
						if($this->checkForErrors()){
			
			$this->body .= $this->getErrorModule();
			$_SESSION["error"] = null;
		}
						$this->body .="</div>
						<div class='page_body_body'>
			        	<div class='module_container' id='user_search_module_container'>	
							<div class='content_module' id='user_search_module'>
							<header class='content_module_header' id='user_search_module_header'>
							<header>
							<div id='user_search_module_body'>
							<table>
							<tr >
								<th>
									Pic
								</th>
								<th>
									Username
								</th>
								<th>
									Xbox Tag
								</th>
								<th>
									PSN Tag
								</th>
								<th>
									Ranking
								</th>
								<th>
									Games
								</th>
							</tr>
			        	";
		    if($search_term == "gamers"){
		    	
		    	$result=$mysql_connection->selectQuery("select id , username , xbox_id , psn_id , games , rank from gamers")->fetch_all(MYSQLI_ASSOC);
			        	
			        	if($result == false){
			        		
			        		
			        			$this->body .="<div class='search_result' id='no_search_result'>
			        				<span>
			        					No Gamers Found.
			        				</span>
								</div>
			        		";
			        		
			        	}else{
						
								$fantasy_gaming_games = $mysql_connection->selectQuery("select name from games")->fetch_all(MYSQL_ASSOC);
								
							
								
								foreach($result as $r ){
									
					        	$this->body .= "
					        		
					        		<tr class='search_result' id='search_result_for_{$r['username']}'>
					        			<td class='search_result_profile_pic' id='{$r['username']}_profile_pic'>
					        				picture
										</td>
										<td class='search_result_username' id='{$r['username']}_username'>
					        				<a href='gamer.php?id={$r['id']}'>" . $r["username"] . "
										</td>
										<td class='search_result_xbox_tag' id='{$r['username']}_xbox_tag'>
					        				" . $r["xbox_id"] . "
										</td>
										<td class='search_result_psn_tag' id='{$r['username']}_psn_tag'>
					        				" . $r["psn_id"] . "
										</td>
										<td class='search_result_ranking' id='{$r['username']}_ranking'>
					        				" . $r["rank"] . "
										</td>
										<td class='search_result_games' id='{$r['username']}_games'>
					        				" . $games . "
										</td>
										<div class='hidden_content' id='hidden_search_result_games' style='display:none'>
										" . $r["games"] . "
										</div>
										
									</tr>
										
					        	";
					        }
					        
						}
					$this->body .="
					</table>
						</div>
						</div>
					</div>	
					</div>
					<div class='page_body_footer'>
             </div>
					";
			        
			        $mysql_connection->close();
			 }else{
			 	
			 	$result = $mysql_connection->selectQuery("select id , username , xbox_id , psn_id , games from gamers where username='" . $search_term ."' OR xbox_id='" . $search_term . "' OR psn_id='" . $search_term ."'")->fetch_all(MYSQLI_BOTH);
			    	
			        $this->body .="<div class='module_container' id='user_search_module_container'>
							<div class='content_module' id='user_search_module'>
			        	";
			        	if($result == false){
			        		$this->body .="<div class='search_result' id='no_search_result'>
			        				<span>
			        					No Gamers Found.
			        				</span>
								</div>
			        		";
			        		
			        	}else{
					        foreach($result as $r ){
					        	$this->body .="<tr class='search_result' id=''>
					        			<td>
					        				picture
										</td>
										<td>
					        				" . $r["username"] . "
										</td>
										<td>
					        				" . $r["xbox_id"] . "
										</td>
										<td>
					        				" . $r["psn_id"] . "
										</td>
										<td>
					        				" . $r["games"] . "
										</td>
									</tr>
					        	";
					        }
						}
					$this->body .="
					</table>
					</div>
					</div>	
					</div>
					<div class='page_body_footer'>
             </div>	
					";
			        
			        $mysql_connection->close();
			        
			  
			 }
			}catch(Exception $ex){
				print_r($ex);
		    }
		}else{
			$this->body = "<section class='page_body'>
				<div class='page_body_header'>";
				if($this->checkForErrors()){
			
			$this->body .= $this->getErrorModule();
			$_SESSION["error"] = null;
		}
				$this->body .="</div>
				<div class='page_body_body'>
				</div>
				<div class='page_body_footer'>
				</div>
		";
		}
	}else{
	echo("fuck you");	
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