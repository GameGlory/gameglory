<?php
require_once("class.user.php");
require_once("class.xboxapi.php");
require_once("class.psnapi.php");
require_once("class.destinyapi.php");


	class Gamer extends User{
   
    	public $id       = null;
  		public $username = null;
  		public $psn_id   = null;
  		public $xbox_id  = null;
  		public $rank     = null;
  		public $url      = null;
   		public $activity = null;
		public $profiles = null;
		public $xbox_one_games = null;
		public $xbox_360_games = null;
		public $ps4_games = null;
		public $ps3_games = null;
		public $xbox_achievements = null;
		public $ps_achievements = null;
		public $xuid = null;
		public $games = null;
		
		public $api_data = null;
		
   		public function __construct($id , $name , $xbox_tag , $psn_tag,$xuid = null, $profiles = array()){
	  		
			$this->id = $id;
			$this->username = $name;
			$this->xbox_id = $xbox_tag;
			$this->psn_id = $psn_tag;
			$this->xuid = $xuid;
			$this->games = array();
			$this->api_data= array();
			$this->type = "gamer";
			$this->profiles = array("xbox" => array() , "psn" =>array());
	 	}
		
		public function __call($method , $args){
			
		}
   		public function changeXboxGamerTag($new_gamer_tag){
   			$this->xbox_id = $new_gamer_tag;
   		}
   		public function getAchievementForGame($uid,$game_id){
   			$url = curl_init();
   		}
		public function setGameStats($game,$console_api,$game_api = null){
			//print_r($this->games);
			
			$mysql_connection = new FantasyGamingDataBase();
			if($game_api != null){
				if($game_api instanceof DestinyApi){
					
					
					if($console_api instanceof XboxApi){	
						foreach($this->games["xbox"]["xboxone"] as $key => $value){
			
							if($value == $game){
								
								unset($this->games["xbox"]["xboxone"][$key]);
								
								break;
							}
			   		
			   		}
						
						
						$this->games["xbox"]["xboxone"][$game] = array();
						$game_id = $mysql_connection->selectQuery("select xbox_title_id from games where name = '{$game}' ")->fetch_assoc();
						
						$stats = $console_api->getGamerStatsForGame($this->xuid, $game_id["xbox_title_id"]);
						$this->games["xbox"]["xboxone"][$game]["ingamestats"] = $game_api->getGamerStats("xboxone");
						$this->games["xbox"]["xboxone"][$game]["achievements"] = $console_api->getAchievementsForGame($this->xuid,$game_id["xbox_title_id"]);
						
						$keys = array_keys($stats);
						for($i=0;$i<count($keys);$i++){
							$this->games["xbox"]["xboxone"][$game]["generalstats"][$keys[$i]] = $stats[$keys[$i]];
						}
						if(!isset($this->games["xbox"]["xboxone"]["gamerscore"])){
							$gamer_score = $console_api->getGamerScore($this->xuid);
							$this->games["xbox"]["xboxone"]["gamerscore"]= $gamer_score;
						}
			
						
						
					}else if($console_api instanceof PsnApi){
						
						$game_id = $mysql_connection->selectQuery("select psn_title_id from games where name = 'Destiny' ")->fecth_assoc();
						$time = $console_api->getGamerStatsForGame($this->psn_id, $game_id["psn_title_id"]);
						$time = $time["MinutesPlayed"];
						$completion = $console_api->getGamerStatsForGame($this->psn_id, $game_id["psn_title_id"]);
						$completion = $completion[GameProgress];
						$this->game[$game]["ingamestats"] = $game_api->getGamerStats("ps4");
						$this->game[$game]["achievements"] = $console_api->getAchievementsForGame($this->xuid,$game_id["psn_title_id"]);
						$this->game[$game]["timeplayed"] = $time; 
						$this->game[$game]["gamecompletion"] = $completion;
					}
				}
			}else{
				if($console_api instanceof XboxApi){
						
						
					
						foreach($this->games["xbox"]["xboxone"] as $key => $value){
			
							if($value == $game){
								unset($this->games["xbox"]["xboxone"][$key]);
							
								break;
							}
			   		
			   		}
						
						
						$this->games["xbox"]["xboxone"][$game] = array();
						$game_id = $mysql_connection->selectQuery("select xbox_title_id from games where name = '{$mysql_connection->connection->real_escape_string($game)}' ")->fetch_assoc();
						$stats = $console_api->getGamerStatsForGame($this->xuid, $game_id["xbox_title_id"]);
						
						$this->games["xbox"]["xboxone"][$game]["achievements"] = $console_api->getAchievementsForGame($this->xuid,$game_id["xbox_title_id"]);
						if(!empty($stats)){
						$keys = array_keys($stats);
						for($i=0;$i<count($keys);$i++){
							$this->games["xbox"]["xboxone"][$game]["generalstats"][$keys[$i]] = $stats[$keys[$i]];
						}
						}
						if(!isset($this->games["xbox"]["xboxone"]["gamerscore"])){
							$gamer_score = $console_api->getGamerScore($this->xuid);
							$this->games["xbox"]["xboxone"]["gamerscore"] = $gamer_score;
						} 
						
						
						
					}else if($console_api instanceof PsnApi){
						
						$game_id = $mysql_connection->selectQuery("select psn_title_id from games where name = 'Destiny' ")->fecth_assoc();
						$time = $console_api->getGamerStatsForGame($this->psn_id, $game_id["psn_title_id"]);
						$time = $time["MinutesPlayed"];
						$completion = $console_api->getGamerStatsForGame($this->psn_id, $game_id["psn_title_id"]);
						$completion = $completion[GameProgress];
						$this->game[$game]["achievements"] = $console_api->getAchievementsForGame($this->xuid,$game_id["psn_title_id"]);
						$this->game[$game]["timeplayed"] = $time; 
						$this->game[$game]["gamecompletion"] =$completion;
					}
			}
			
		}
   		public function setRank($rank){
   		$this->rank = $rank;
   		}
		
   
	}
	
?>