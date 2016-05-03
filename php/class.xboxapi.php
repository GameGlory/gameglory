<?php
require_once("class.gamer.php");
require_once("class.baseconsoleapi.php");
require_once("class.xboxapiexception.php");
require_once("class.fantasygamingdatabase.php");
	class XboxApi extends BaseConsoleApi{
		
		  const KEY = "2f09c59923776d3e5a262bd6b7b14a6ce1c99134";
		  const URL_ROOT = "https://xboxapi.com";
		  
		  public function __construct($gamer = null){
		    	if($gamer != null){
			    if($gamer instanceof Gamer){
			  		$this->url_root = "https://xboxapi.com";
					$gamer->api_data["xbox"] = array();
					$this->user = $gamer;
					$this->api_name = "xbox";
					
				}else{
					throw new XboxApiException("Invalid user type.");
					exit;
				}
				}
		    }
		 
		 	static public function isGamerTagValid($gamer_tag){
		 	$mysql_connection = null;
			try{
			$tag = rawurlencode($gamer_tag);
			$url = curl_init(XboxApi::URL_ROOT . "/v2/xuid/{$tag}");
			$options = array(CURLOPT_HTTPHEADER => array("X-AUTH:".XboxApi::KEY) , CURLOPT_RETURNTRANSFER => true);
			curl_setopt_array($url, $options);
			$response = json_decode(curl_exec($url),true);
			
			if(isset($response["error_message"])){
				if($response["error_message"] == "XUID not found"){
					curl_close($url);
					return false;
				}else{
					curl_close($url);
					throw new XboxApiException($response["error_message"],1);
				}
			}else if(empty($response)){
				curl_close($url);
				throw new XboxApiException("No data returned from xbox",1);
			}else{
				$mysql_connection = new FantasyGamingDataBase();
				$params = array($gamer_tag);
				$result = $mysql_connection->selectQuery("select * from gamers where xbox_id = ?",$params);
				
				if(empty($result)){
					curl_close($url);
					return true;
				}
				else{
					curl_close($url);
					return false;
				}
				$mysql_connection->close();
			}
			}catch(Exception $ex){
	    		
				if($ex->getCode()){
					$url = curl_init(XboxApi::URL_ROOT . "/v2/xuid/{$tag}");
					$options = array(CURLOPT_HTTPHEADER => array("X-AUTH:".XboxApi::KEY) , CURLOPT_RETURNTRANSFER => true);
					curl_setopt_array($url, $options);
					$response = json_decode(curl_exec($url),true);
					
					if(isset($response["error_message"])){
						if($response["error_message"] == "XUID not found"){
							
							return false;
						}
						
					}
				}
			}
		 }
		 public function getGamerUserId($gamer_tag){
		 	
			try{
			$url = curl_init(XboxApi::URL_ROOT . "/v2/xuid/{$gamer_tag}");
			curl_setopt($url,CURLOPT_RETURNTRANSFER , true);
			curl_setopt($url,CURLOPT_HTTPHEADER , array("X-AUTH:" . XboxApi::KEY));
			
				if($response = curl_exec($url)){
					
					if(is_object(json_decode($response,true))){
						
						if(isset($response["error_message"])){
						if($response["error_message"] == "XUID not found"){
							curl_close($url);
								throw new XboxApiException($response["error_message"],1);
							}else{
								curl_close($url);
								throw new XboxApiException("What the hell just happen?",1);
							}
						}else{
							curl_close($url);
					 		throw new XboxApiException("What the hell just happen?",1);
						}
						
					}else{
						
						curl_close($url);
						$this->user->api_data["xbox"]["xuid"] = $response;
						return $this->user->api_data["xbox"]["xuid"];
					}
					
				}else{
					throw new XboxApiException("Could not make request to get gamer id.",1);
				}
				}catch(Exception $ex){
						if($ex->getCode() == 1){
	     					$url = curl_init(XboxApi::URL_ROOT . "/v2/xuid/{$gamer_tag}");
							curl_setopt($url,CURLOPT_RETURNTRANSFER , true);
							curl_setopt($url,CURLOPT_HTTPHEADER , array("X-AUTH:" . XboxApi::KEY));
			
							if($response = curl_exec($url)){
					
							if(is_object(json_decode($response,true))){
										
									curl_close($url);
	
							}else{
						
								curl_close($url);
								$this->user->api_data["xbox"]["xuid"] = $response;
								return $this->user->api_data["xbox"]["xuid"];
							}
					
							}else{
								curl_close($url);
								
							}
						}

					
				}
		 }
		 public function getGamerTag($uid){
		 	
			try{
			$url = curl_init(XboxApi::URL_ROOT . "/v2/gamertag/{$uid}");
			curl_setopt($url,CURLOPT_RETURNTRANSFER , true);
			curl_setopt($url,CURLOPT_HTTPHEADER , array("X-AUTH:" . XboxApi::KEY));
			
				if($response = curl_exec($url)){
					
					if(is_object(json_decode($response,true))){
						
						if(isset($response["error_message"])){
							curl_close($url);
							throw new XboxApiException($response["error_message"],1);
						}else if(empty($response)){
							curl_close($url);
							throw new XboxApiException("What the hell just happen?");
						}else{
							curl_close($url);
					 		throw new XboxApiException("What the hell just happen?");
						}
						
					}else{
						$this->user->api_data["xbox"]["gamertag"] = $response;
						return $this->user->api_data["xbox"]["gamertag"];
					}
					
				}else{
					curl_close($url);
					throw new XboxApiException("Could not make request to get gamer tag",1);
				}
			}catch(Exception $ex){
				
				if($ex->getCode()){
					$url = curl_init(XboxApi::URL_ROOT . "/v2/gamertag/{$uid}");
					curl_setopt($url,CURLOPT_RETURNTRANSFER , true);
					curl_setopt($url,CURLOPT_HTTPHEADER , array("X-AUTH:" . XboxApi::KEY));
					if($response = curl_exec($url)){
					
					if(is_object(json_decode($response,true))){
						
							curl_close($url);
					}else{
						$this->user->api_data["xbox"]["gamertag"] = $response;
						return $this->user->api_data["xbox"]["gamertag"];
					}
					
				}else{
					
					curl_close($url);
				}
				}
				
			}
		 }
		 public function getGamerActivity($uid){
		 	
			try{
			$url = curl_init(XboxApi::URL_ROOT . "/v2/{$uid}/activity/recent");
			curl_setopt($url,CURLOPT_RETURNTRANSFER , true);
			curl_setopt($url,CURLOPT_HTTPHEADER , array("X-AUTH:" . XboxApi::KEY));
			
				if($response = curl_exec($url)){
					$activities = null;
					$response = json_decode($response,true);	
						if(isset($response["error_message"])){
								curl_close($url);
								throw new XboxApiException($response["error_message"]);
						}else{
					 		$activities =  array();
							$i=0;
							$a = 0;
						
							for($a; $a<count($response); $a++){
								$i=0;
								foreach($response["".$a] as $key => $value){
									
										if($key == "description" || $key == "date" || $key == "contentImageUri" || $key == "contentTitle" || $key == "platform"){
											if($response["".$a]["contentType"] == "App")
												break;
											$activities[$a][$key] = $value;
										}
										
									$i++;
								}
							}
							if(empty($activities)){
								curl_close($url);
								throw new XboxApiException("I dont know what the fuck happen like...");
							}else{
								curl_close($url);
								return $activities;
							}
						}
					
				}else{
					throw new XboxApiException("Could not make request to get gamer xbox activity",1);
				}
				}catch(Exception $ex){
					if($ex->getCode()){
						$url = curl_init(XboxApi::URL_ROOT . "/v2/{$uid}/activity/recent");
						curl_setopt($url,CURLOPT_RETURNTRANSFER , true);
						curl_setopt($url,CURLOPT_HTTPHEADER , array("X-AUTH:" . XboxApi::KEY));
			
				if($response = curl_exec($url)){
					$activities = null;
					$response = json_decode($response,true);	
						if(isset($response["error_message"])){
								curl_close($url);
							
						}else{
					 		$activities =  array();
							$i=0;
							foreach($response["".$i] as $key => $value){
								
									if($key == "description" || $key == "date" || $key == "contentImageUri" || $key == "contentTitle" || $key == "platform")
										$activities[$key] = $value;
									else 
										"nothing";
								$i++;
							}
							if(empty($activities)){
								curl_close($url);
								
							}else{
								curl_close($url);
								return $activities;
							}
						}
					
				}else{
					curl_close($url);
				
				}
					}
				}
				
				
		 }
		 public function getGamerCard($uid){
		 	try{
			$url = curl_init(XboxApi::URL_ROOT . "/v2/{$uid}/gamercard");
			curl_setopt($url,CURLOPT_RETURNTRANSFER , true);
			curl_setopt($url,CURLOPT_HTTPHEADER , array("X-AUTH:" . XboxApi::KEY));
			
				if($response = curl_exec($url)){
						
						$response = json_decode($response,true);
					
						if(isset($response["description"])){
								curl_close($url);
								throw new XboxApiException($response["description"],1);
							}else{
								
								$gamecard = array();
								foreach ($response as $key => $value) {
									
									if($key == "avatarManifest")
										continue;
									else
										$gamecard[$key] = $value;
								}
								
								if(empty($gamecard)){
									curl_close($url);
									throw new XboxApiException("WTF!");
								}
								else{
									curl_close($url);
									return $gamecard;
								}
							}
					
				}else{
					throw new XboxApiException("Could not make request to get xbox gamercard",1);
				}
			}catch(Exception $ex){
				if($ex->getCode()){
					$url = curl_init(XboxApi::URL_ROOT . "/v2/{$uid}/gamercard");
			curl_setopt($url,CURLOPT_RETURNTRANSFER , true);
			curl_setopt($url,CURLOPT_HTTPHEADER , array("X-AUTH:" . XboxApi::KEY));
			
				if($response = curl_exec($url)){
						$response = json_decode($response,true);
						if(isset($response["description"])){
								curl_close($url);
								
							}else{
								$gamecard = array();
								foreach ($response as $key => $value) {
									
									if($key == "avatarManifest")
										continue;
									else
										$gamecard[$key] = $value;
								}
								if(empty($gamecard)){
									curl_close($url);
									
								}
								else{
									curl_close($url);
									return $gamecard;
								}
							}
					
				}else{
					curl_close($url);
				}
				}
			
			}
			
		 }
		  public function getGamerProfile($uid){
		 	try{
			$url = curl_init(XboxApi::URL_ROOT . "/v2/{$uid}/profile");
			curl_setopt($url,CURLOPT_RETURNTRANSFER , true);
			curl_setopt($url,CURLOPT_HTTPHEADER , array("X-AUTH:" . XboxApi::KEY));
			
				if($response = curl_exec($url)){
						$response = json_decode($response,true);
						if(isset($response["description"])){
								curl_close($url);
								throw new XboxApiException($response["description"]);
							}else{
								$profile = array();
								foreach ($response as $key => $value) 
									$profile[$key] = $value;
								
								if(empty($profile)){
									curl_close($url);
									throw new XboxApiException("WTF!");
								}
								else{
									curl_close($url);
									return $profile;
								}
							}
					
				}else{
					curl_close($url);
				}
			}catch(Exception $ex){
				
				$url = curl_init(XboxApi::URL_ROOT . "/v2/{$uid}/profile");
			curl_setopt($url,CURLOPT_RETURNTRANSFER , true);
			curl_setopt($url,CURLOPT_HTTPHEADER , array("X-AUTH:" . XboxApi::KEY));
			
				if($response = curl_exec($url)){
						$response = json_decode($response,true);
						if(isset($response["description"])){
								curl_close($url);
								
							}else{
								$profile = array();
								foreach ($response as $key => $value) 
									$profile[$key] = $value;
								
								if(empty($profile)){
									curl_close($url);
								
								}
								else{
									curl_close($url);
									return $profile;
								}
							}
					
				}else{
					curl_close($url);
				}
			}
		 }
		  public function getGamerScore($uid){
		  	
			$profile = $this->getGamerProfile($uid);
			$gamer_score = $profile["Gamerscore"];
			return $gamer_score;
		  }
		 static public function getGamerGameClips($uid){
		 	
			try{
			$url = curl_init(XboxApi::URL_ROOT . "/v2/{$uid}/game-clips");
			curl_setopt($url,CURLOPT_RETURNTRANSFER , true);
			curl_setopt($url,CURLOPT_HTTPHEADER , array("X-AUTH:" . XboxApi::KEY));
			
				if($response = curl_exec($url)){
						$response = json_decode($response,true);
						if(isset($response["error_message"]))
							throw new XboxApiException($response["error_message"]);
						else if(empty($response))
							throw new XboxApiException("WTF!");
						else{
								$gameclips = array();
								foreach ($response as $key => $value) 
									$gameclips[$key] = $value;
								
								if(empty($gameclips)){
									curl_close($url);
									throw new XboxApiException("WTF!");
								}
								else{
									curl_close($url);
									return $gameclips;
								}
							}
					
				}else{
					curl_close($url);
				}
		 }catch(Exception $ex){
		 	
		 }
		 }
		 public function getGamer360Games($uid){
		 	
			try{
			$url = curl_init(XboxApi::URL_ROOT . "/v2/{$uid}/xbox360games");
			curl_setopt($url,CURLOPT_RETURNTRANSFER , true);
			curl_setopt($url,CURLOPT_HTTPHEADER , array("X-AUTH:" . XboxApi::KEY));
			
				if($response = curl_exec($url)){
						$response = json_decode($response,true);
						if(isset($response["description"]))
							throw new XboxApiException($response["description"]);
						else if(empty($response))
							throw new XboxApiException("WTF!");
						else{
								$games = array();
								foreach ($response["titles"] as $key => $value){
									if(is_array($value)){
										foreach ($value as $k => $v) {
											if($k == "name")
												array_push($games , iconv("UTF-8", "ASCII//IGNORE", $v));
											else
												continue;
										}
									}else	 
										continue;
								}
								if(empty($games)){
									curl_close($url);
									throw new XboxApiException("WTF!");
								}
								else{
									curl_close($url);
									return $games;
								}
							}
					
				}else{
					curl_close($url);
				}
				}catch(Exception $ex){
					$url = curl_init(XboxApi::URL_ROOT . "/v2/{$uid}/xbox360games");
					curl_setopt($url,CURLOPT_RETURNTRANSFER , true);
					curl_setopt($url,CURLOPT_HTTPHEADER , array("X-AUTH:" . XboxApi::KEY));
			
				if($response = curl_exec($url)){
						$response = json_decode($response,true);
						if(isset($response["description"]))
							curl_close($url);
						else if(empty($response))
							curl_close($url);
						else{
								$games = array();
								foreach ($response["titles"] as $key => $value){
									if(is_array($value)){
										foreach ($value as $k => $v) {
											if($k == "name")
												array_push($games , iconv("UTF-8", "ASCII//IGNORE", $v));
											else
												continue;
										}
									}else	 
										continue;
								}
								if(empty($games)){
									curl_close($url);
									throw new XboxApiException("WTF!");
								}
								else{
									curl_close($url);
									return $games;
								}
							}
					
				}else{
					curl_close($url);
				}
				}
		 }
		 public function getGamerXboxOneGames($uid){
		 	
			try{
			$url = curl_init(XboxApi::URL_ROOT . "/v2/{$uid}/xboxonegames");
			curl_setopt($url,CURLOPT_RETURNTRANSFER , true);
			curl_setopt($url,CURLOPT_HTTPHEADER , array("X-AUTH:" . XboxApi::KEY));
				if($response = curl_exec($url)){
					
						$response = json_decode($response,true);
						if(isset($response["error_message"]) )
							throw new XboxApiException($response["error_message"]);
						else if(empty($response))
							throw new XboxApiException("WTF!");
						else{
								$games = array();
								foreach ($response["titles"] as $key => $value){
									if(is_array($value)){
										foreach ($value as $k => $v) {
											if($value["titleType"]  == "DGame"){
											if($k == "name")
												array_push($games , iconv("UTF-8", "ASCII//IGNORE", $v));
											else
												continue;
											}else{
												continue;
											}
										}
									}else	 
										continue;
								}
								
								if(empty($games)){
									curl_close($url);
									throw new XboxApiException("WTF!");
								}
								else{
									curl_close($url);
								//	print_r($games);
									
									return $games;
								}
							}
					
				}else{
					curl_close($url);
				}
				}catch(Exception $ex){
					$url = curl_init(XboxApi::URL_ROOT . "/v2/{$uid}/xboxonegames");
				curl_setopt($url,CURLOPT_RETURNTRANSFER , true);
				curl_setopt($url,CURLOPT_HTTPHEADER , array("X-AUTH:" . XboxApi::KEY));
				if($response = curl_exec($url)){
					
						$response = json_decode($response,true);
						if(isset($response["error_message"]) )
							curl_close($url);
						else if(empty($response))
							curl_close($url);
						else{
								$games = array();
								foreach ($response["titles"] as $key => $value){
									if(is_array($value)){
										foreach ($value as $k => $v) {
											if($value["titleType"]  == "DGame"){
											if($k == "name")
												array_push($games , iconv("UTF-8", "ASCII//IGNORE", $v));
											else
												continue;
											}else{
												continue;
											}
										}
									}else	 
										continue;
								}
								
								if(empty($games)){
									curl_close($url);
									
								}
								else{
									curl_close($url);
								//	print_r($games);
									
									return $games;
								}
							}
					
				}else{
					curl_close($url);
				}
				}
		 }
		 public function getAchievementsForGame($uid,$gameid){
		 		try{
		 	
			$url = curl_init(XboxApi::URL_ROOT . "/v2/{$uid}/achievements/{$gameid}");
			curl_setopt($url,CURLOPT_RETURNTRANSFER , true);
			curl_setopt($url,CURLOPT_HTTPHEADER , array("X-AUTH:" . XboxApi::KEY));
			
				if($response = curl_exec($url)){
						$response = json_decode($response,true);
						if(isset($response["error_message"]))
							throw new XboxApiException($response["error_message"]);
						else if(empty($response)){
							curl_close($url);
							throw new XboxApiException("WTF!");
						}else{
								$achievements = array();
								foreach ($response as $key => $value){
									
									if($value["progressState"] != "Achieved")
										continue;
									$name = $value["name"];
									$description = $value["description"];
									array_push($achievements,array("name"=>$name,"description"=>$description));
									
									
								}
							
									curl_close($url);
									return $achievements;
								
							}
					
				}else{
					curl_close($url);
				}
				}catch(Exception $ex){
					$url = curl_init(XboxApi::URL_ROOT . "/v2/{$uid}/achievements/{$gameid}");
			curl_setopt($url,CURLOPT_RETURNTRANSFER , true);
			curl_setopt($url,CURLOPT_HTTPHEADER , array("X-AUTH:" . XboxApi::KEY));
			
				if($response = curl_exec($url)){
						$response = json_decode($response,true);
						if(isset($response["error_message"]))
							curl_close($url);
						else if(empty($response)){
							curl_close($url);
							throw new XboxApiException("WTF!");
						}else{
								$achievements = array();
								foreach ($response as $key => $value){
									
									if($value["progressState"] != "Achieved")
										continue;
									$name = $value["name"];
									$description = $value["description"];
									array_push($achievements,array("name"=>$name,"description"=>$description));
									
									
								}
							
									curl_close($url);
									return $achievements;
								
							}
					
				}else{
					curl_close($url);
				}
				}
		 }
		 public function getGameId($game,$console,$uid){
		 	
			$game_id = null;
			try{
				if($console == "xboxone")
					$url = curl_init(XboxApi::URL_ROOT . "/v2/{$uid}/xboxonegames");
				else
					$url = curl_init(XboxApi::URL_ROOT . "/v2/{$uid}/xbox360games");
			curl_setopt($url,CURLOPT_RETURNTRANSFER , true);
			curl_setopt($url,CURLOPT_HTTPHEADER , array("X-AUTH:" . XboxApi::KEY));
			if($response = curl_exec($url)){
					$response = json_decode($response,true);
						if(isset($response["error_message"]) )
							throw new XboxApiException($response["error_message"]);
						else if(empty($response))
							throw new XboxApiException("WTF!");
						else{
								
								foreach ($response["titles"] as $key => $value){
									if(is_array($value)){
										if($value["titleType"] == 5 || $value["titleType"] == "LiveApp" )
											continue;
										foreach ($value as $k => $v) {
											if($k == "name"){
												if(iconv("UTF-8", "ASCII//IGNORE",$value[$k]) == $game){
													$game_id = $value["TitleId"];
												
												}
											}else
												continue;
										}
									}else	 
										continue;
								}
								
								if(!isset($game_id) || empty($game_id)){
									curl_close($url);
									throw new XboxApiException("WTF!");
								}
								else{
								
									curl_close($url);
									return dechex($game_id);
								}
							}
			}else{
				curl_close($url);
			}
			}catch(Exception $ex){
				$game_id = null;
				$url = curl_init(XboxApi::URL_ROOT . "/v2/{$uid}/xboxonegames");
			curl_setopt($url,CURLOPT_RETURNTRANSFER , true);
			curl_setopt($url,CURLOPT_HTTPHEADER , array("X-AUTH:" . XboxApi::KEY));
			if($response = curl_exec($url)){
					$response = json_decode($response,true);
						if(isset($response["error_message"]) )
							curl_close($url);
						else if(empty($response))
							curl_close($url);
						else{
								
								foreach ($response["titles"] as $key => $value){
									if(is_array($value)){
										foreach ($value as $k => $v) {
											if($k == "name"){
												if(iconv("UTF-8", "ASCII//IGNORE",$value[$k]) == $game){
													$game_id = $value["TitleId"];
												
												}
											}else
												continue;
										}
									}else	 
										continue;
								}
								
								if(!isset($game_id) || empty($game_id)){
									curl_close($url);
									
								}
								else{
								
									curl_close($url);
									return dechex($game_id);
								}
							}
			}else{
				curl_close($url);
			}
			}
			
			
		 }
		 public function getGameDetails($hex_game_id){
		 	
			try{
				$url = curl_init(XboxApi::URL_ROOT . "/v2/game-details-hex/{$hex_game_id}");
				curl_setopt($url,CURLOPT_RETURNTRANSFER , true);
				curl_setopt($url,CURLOPT_HTTPHEADER , array("X-AUTH:" . XboxApi::KEY));
				if($response = curl_exec($url)){
					$response = json_decode($response,true);
					if(isset($response["error_message"]))
							throw new XboxApiException($response["error_message"]);
						else if(empty($response)){
							curl_close($url);
							throw new XboxApiException("WTF!");
						}else{
							
							if(!isset($response["Items"])){
								print_r($response);
								exit;
							}
							
							$game_details = array("genres" =>array());
							
							$game_details["name"] = $response["Items"]["0"]["Name"];
							$game_details["reduceddescription"] = $response["Items"]["0"]["ReducedDescription"];
							$game_details["publishername"] = $response["Items"]["0"]["PublisherName"];
							$game_details["developername"] = $response["Items"]["0"]["DeveloperName"];
							$game_details["releasedate"] = $response["Items"]["0"]["ReleaseDate"];
						
							foreach ($response["Items"]["0"]["Genres"] as $key => $value){
							
									array_push($game_details["genres"],$value["Name"] );	
							
							
							}
								//print_r($game_details);
								//echo("<br>");
								//echo("<br>");
							return $game_details;
						}
				}else{
					print_r(curl_getinfo($url));
				}
			}catch(Exception $ex){
				$url = curl_init(XboxApi::URL_ROOT . "/v2/game-details-hex/{$hex_game_id}");
				curl_setopt($url,CURLOPT_RETURNTRANSFER , true);
				curl_setopt($url,CURLOPT_HTTPHEADER , array("X-AUTH:" . XboxApi::KEY));
				if($response = curl_exec($url)){
					$response = json_decode($response,true);
					if(isset($response["error_message"]))
							curl_close($url);
						else if(empty($response)){
							curl_close($url);
							
						}else{
							
							if(!isset($response["Items"])){
								curl_close($url);
								exit;
							}
							
							$game_details = array("genres" =>array());
							
							$game_details["name"] = $response["Items"]["0"]["Name"];
							$game_details["reduceddescription"] = $response["Items"]["0"]["ReducedDescription"];
							$game_details["publishername"] = $response["Items"]["0"]["PublisherName"];
							$game_details["developername"] = $response["Items"]["0"]["DeveloperName"];
							$game_details["releasedate"] = $response["Items"]["0"]["ReleaseDate"];
						
							foreach ($response["Items"]["0"]["Genres"] as $key => $value){
							
									array_push($game_details["genres"],$value["Name"] );	
							
							
							}
								//print_r($game_details);
								//echo("<br>");
								//echo("<br>");
							return $game_details;
						}
				}else{
					curl_close($url);
				}
			}
		 }	
		 public function getGamerStatsForGame($uid,$game_id){
		 		try{
		 	
			$url = curl_init(XboxApi::URL_ROOT . "/v2/{$uid}/game-stats/{$game_id}");
			curl_setopt($url,CURLOPT_RETURNTRANSFER , true);
			curl_setopt($url,CURLOPT_HTTPHEADER , array("X-AUTH:" . XboxApi::KEY));
			
				if($response = curl_exec($url)){
					$response = json_decode($response,true);
					if(isset($response["error_message"]))
							throw new XboxApiException($response["error_message"]);
						else if(empty($response)){
							curl_close($url);
							throw new XboxApiException("WTF!");
						}else{
							
							$stats = array();
								foreach ($response["groups"] as $key => $value){
									foreach($response["groups"][$key]["statlistscollection"] as $k=> $v){
										foreach ($v["stats"] as $stat => $s) {
											$stats[$s["name"]] = $s["value"];
											continue;	
										}
									}
									
									
								}
								foreach($response["statlistscollection"] as $key => $value){
									foreach($value["stats"] as $stat => $s){
										$stats[$s["name"]] = $s["value"];
											continue;
									}
								}
								return $stats;
							}
				}else{
					curl_close($url);
				}
				}catch(Exception $ex){
					
					$url = curl_init(XboxApi::URL_ROOT . "/v2/{$uid}/game-stats/{$game_id}");
			curl_setopt($url,CURLOPT_RETURNTRANSFER , true);
			curl_setopt($url,CURLOPT_HTTPHEADER , array("X-AUTH:" . XboxApi::KEY));
			
				if($response = curl_exec($url)){
					$response = json_decode($response,true);
					if(isset($response["error_message"]))
							curl_close($url);
						else if(empty($response)){
							curl_close($url);
							
						}else{
							
							$stats = array();
								foreach ($response["groups"] as $key => $value){
									foreach($response["groups"][$key]["statlistscollection"] as $k=> $v){
										foreach ($v["stats"] as $stat => $s) {
											$stats[$s["name"]] = $s["value"];
											continue;	
										}
									}
									
									
								}
								foreach($response["statlistscollection"] as $key => $value){
									foreach($value["stats"] as $stat => $s){
										$stats[$s["name"]] = $s["value"];
											continue;
									}
								}
								return $stats;
							}
				}else{
					curl_close($url);
				}
				}
		 }
/////////end of class ///////////////////end of class////////////////////////////end of class//
	}

?>