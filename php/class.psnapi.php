<?php
	require_once("class.gamer.php");
	require_once("class.baseconsoleapi.php");
	require_once("psnAPI.php");
	require_once("class.psnexception.php");
	require_once("class.fantasygamingdatabase.php");
	class PsnApi extends BaseConsoleApi{
		
		public function __construct($gamer=null){
			if($gamer != null){
			if($gamer instanceof Gamer){
			  		$this->url_root = null;
					$gamer->api_data["psn"] = array();
					$this->user = $gamer;
					$this->api_name = "psn";
					
				}else{
					throw new PsnApiException("Invalid user type.");
					exit;
				}
			}
		}
		public function getAllTheGamersGames($psn_id){
				
			$games = null;
			try{
				$games = psnGetUserGames($psn_id);
				if($games["success"] == 0){
					if($games["error_message"])
						throw new PsnException($games["error_message"]);
					else
						throw new PsnException($games . "\nThe PSN API came back with some fucked up data... I don't know what this shit is.");
				}else if($games["success"] == 1)
					return $games;
				else
					throw new PsnException("The PSN API came back with some fucked up data... I don't know what this shit is.");
				
			}catch(Exception $ex){
				print_r($ex);
			}
		}
		public function getGamersPs4Games($psn_id){
				
			$all_games = null;
			$ps4_games = null;
			try{
			$games = $this->getAllTheGamersGames($psn_id);
			$ps4_games = array();
			foreach($games["games"] as $key){
				foreach($key as $k => $value){
					if($k == "platform" && $value == "ps4")
						array_push($ps4_games , $key["title"]);
					else
						continue;
				}
			}
			return $ps4_games;
			}catch(Exception $ex){
				print_r($ex);
			}
		}
		public function getGamersPs3Games($psn_id){
				
			$all_games = null;
			$ps3_games = null;
			try{
			$games = PsnApi::getAllTheGamersGames($psn_id);
			$ps3_games = array();
			foreach($games["games"] as $key){
				foreach($key as $k => $value){
					if($k == "platform" && $value == "ps3")
						array_push($ps3_games , $key["title"]);
					else
						continue;
				}
			}
			return $ps3_games;
			}catch(Exception $ex){
				print_r($ex);
			}
		}
		public function getGamerLevel($psn_id){
			
			$level = null;
			$profile = null;
			try{
				if($profile = PsnApi::getGamerProfile($psn_id)){
					$level = $profile->offsetGet("real_level");
					return $level;	
				}else
					throw new Exception("WTF!");
			}catch(Exception $ex){
				print_r($ex);
			}
		}
		public function getGamerScore($psn_id){
			
			$points = null;
			$profile = null;
			try{
				if($profile = PsnApi::getGamerProfile($psn_id)){
					$points = $profile->offsetGet("real_points");
					return $points;	
				}else
					throw new Exception("WTF!");
			}catch(Exception $ex){
				print_r($ex);
			}
		}
		public function getNumberOfGamersCompletedGames($psn_id){
			
			$number = null;
			$profile = null;
			try{
				if($profile = PsnApi::getGamerProfile($psn_id)){
					$number = $profile->offsetGet("games_complete");
					return $number;	
				}else
					throw new Exception("WTF!");
			}catch(Exception $ex){
				print_r($ex);
			}
		}
		public function getNumberOfGamersTrophies($psn_id){
			
			$number = null;
			$profile = null;
			try{
				if($profile = PsnApi::getGamerProfile($psn_id)){
					$number = $profile->offsetGet("total");
					return $number;	
				}else
					throw new Exception("WTF!");
			}catch(Exception $ex){
				print_r($ex);
			}
		}
		public function getGamerTrophies($psn_id){
			
			$trophies = null;
			$profile = null;
			try{
				if($profile = $this->getGamerProfile($psn_id)){
					print_r($profile);
				}else
					throw new Exception("WTF!");
			}catch(Exception $ex){
				print_r($ex);
			}
		}
		
		public function getGamerProfile($psn_id){
				
			$profile = null;
			try{
				$profile = psnGetUser($psn_id);
				if($profile["success"] == 0){
					if($profile["error_message"])
						throw new PsnException($profile["error_message"]);
					else
						throw new PsnException($profile);
				}else if($profile["success"] == 1)
							return $profile;
				else
					throw new Exception("The PSN API came back with some fucked up data... I don't know what this shit is.");
			}catch(Exception $ex){
				print_r($ex);
			}
		}
		public function getGamersRegionalRank($psn_id){
			
			$rank = null;
			$profile = null;
			try{
				if($profile = PsnApi::getGamerProfile($psn_id)){
					$rank = $profile->offsetGet("regionrank");
					return $rank;	
				}else
					throw new Exception("WTF!");
			}catch(Exception $ex){
				print_r($ex);
			}
		}
		public function getGamerStatsForGame(){
			
		}
		public function getGamersWorldRank($psn_id){
			
			$rank = null;
			$profile = null;
			try{
				if($profile = PsnApi::getGamerProfile($psn_id)){
					$rank = $profile->offsetGet("worldrank");
					return $rank;	
				}else
					throw new Exception("WTF!");
			}catch(Exception $ex){
				print_r($ex);
			}
		}
		static public function isGamerTagValid($psn_id){
			
			$response = null;
			
				
				if($response = psnGetUser($psn_id)){
					if($response["success"] == 1){
						if($response["psn_id"])
							return true;
						else
							return false;
					}else if($response["success"] == 0){
						if($response["error_message"])
							throw new PsnException($response["error_message"]);
						else
							throw new PsnException($response);
					}else
						throw new Exception($response);
				}else
					throw new Exception("");
			
		}
		///end of  class //////////////////////
	}
//print_r(psnGetGame("NPWR02631_00"));
?>