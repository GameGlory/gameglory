<?php
require_once("class.fantasygamingdatabase.php");
require_once("class.page.php");
require_once("class.user.php");
class GameSearchPage extends Page{
	public function gameSearchPageModules(){
	if($_SERVER["REQUEST_METHOD"] == "GET"){
		require_once("constants.php");
	    $mysql_connection = null;
	    if(isset($_GET["search_for"])){
			$mysql_connection = new FantasyGamingDataBase();
		    if($_GET["search_for"] == "games"){
		    $games = $mysql_connection->selectQuery("select * from games");
			    	
			        echo("
			        	<section class='page_body'>
			        	 <div class='page_body_header'>
						</div>
						 <div class='page_body_body'>
						
			        	<div class='module_container' id='game_search_module_container'	>
							<div class='content_module' id='game_search_module'>
			        	");
			           if($games->num_rows == 0){
			        		echo("
			        			<div class='search_result' id='no_search_result'>
			        				<span>
			        					No Games Found.
			        				</span>
								</div>
			        		");
			        		}else{
			        	$games->fetch_assoc();
					        foreach($games as $key => $value){
					        	echo("
					        		<div class='search_result' id=''>
					        			<span>
					        				picture
										</span>
										<span>
					        				" . $row['name'] . "
										</span>
										<span>
					        				" . $row['console'] . "
										</span>
										<span>
					        				" . $row['number_of_players'] . "
										</span>
										
									</div>
					        	");
					        }
						}
					echo("
						</div>
					</div>		
					");
			        $mysql_statment_object->close();
			        $mysql_connection->close();
			        
			        
			     
			   
				 
			
			 }else{
			 	if($mysql_statment_object = $mysql_connection->prepare("select  name , console , number_of_players from games where name='" . $_GET['search_for'] ."' OR console='" . $_GET['search_for'] ."'")){
			    	$mysql_statment_object->execute();
			        $mysql_statment_object->bind_result($name,$console,$number_of_players);
			        echo("
			        	<div class='module_container' id='game_search_module_container'	
							<div class='content_module' id='game_search_module'>
			        	");
			        	if($mysql_statment_object->fetch() == 0){
			        		echo("
			        			<div class='search_result' id='no_search_result'>
			        				<span>
			        					No Games Found.
			        				</span>
								</div>
			        		");
			        		
			        	}else{
					        while($row = $mysql_statment_object->fetch()){
					        	echo("
					        		<div class='search_result' id=''>
					        			<span>
					        				picture
										</span>
										<span>
					        				" . $row['username'] . "
										</span>
										<span>
					        				" . $row['xbox_id'] . "
										</span>
										<span>
					        				" . $row['psn_id'] . "
										</span>
										<span>
					        				" . $row['games'] . "
										</span>
									</div>
					        	");
					        }
						}
					echo("
						</div>
					</div>	
					</div>
					 <div class='page_body_footer'>
						</div>
				
					");
			        $mysql_statment_object->close();
			        $mysql_connection->close();
			        
			        
			     }else{
			   
				 }
			 }
		}
	}
}
}
try{
	if(session_status() == PHP_SESSION_ACTIVE){
		if(isset($_SESSION["user"])){ 
			$user = unserialize($_SESSION["user"]);
			if(isset($_SESSION["id"])){
					
			}
		}else{
			$user = new User();
			$_SESSION["user"] = serialize($user);
		}
	}else if(session_status() == PHP_SESSION_NONE){
		session_name("fgs");
		session_start();
		if(!isset($_SESSION['user'])){
			$user = new User();
			$_SESSION['user'] = serialize($user);
		}else{
			$user = unserialize($_SESSION["user"]);
		}
	}

	$page = new GameSearchPage($user);
}catch(Exception $ex){
	print_r($ex);
}
?>