<?php
	function setUser(){
		global $user;
		if(session_status() == PHP_SESSION_ACTIVE){
			if(isset($_SESSION["user"])){ 
				$user = unserialize($_SESSION["user"]);
				if(isset($_SESSION["id"])){
					///do somethig because user is logged in	
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
	}
	function isIdSet(){
		
		if(!isset($_GET["id"]) || $_GET['id'] == "" || empty($_GET))
			return false;
		else 
			return true;
		
	}
	function __autoload($class){
	$class = strtolower($class);
	include("class.{$class}.php");
	}
	function setXboxOneGames($mysql_connection,$games,$gamer,$xbox_api){
	
	 $gamer->games = $games;
	
	$console = serialize(array("xboxone"));
	foreach($games["xbox"]["xboxone"] as $key => $value){
		$r = $mysql_connection->selectQuery("select * from games where name = '{$mysql_connection->connection->real_escape_string($value)}'");
		if(empty($r) || $r->num_rows == 0){
			//print_r($value);
			$game_id = $xbox_api->getGameId($value,$gamer->xuid);
			$game_details = serialize($xbox_api->getGameDetails(dechex($game_id)));
			
			
			if(!empty($game_details)){
				
				if($value == "Destiny"){
					//print_r(var_dump($game_details));
					$mysql_connection->insertQuery("insert into games (name,console,has_stats,xbox_title_id,details) values('{$mysql_connection->connection->real_escape_string($value)}','{$console}',1,{$game_id},'{$mysql_connection->connection->real_escape_string($game_details)}')");
				}else{
					//print_r(var_dump($game_details));
					
					$mysql_connection->insertQuery("insert into games (name,console,has_stats,xbox_title_id,details) values('{$mysql_connection->connection->real_escape_string($value)}','{$console}',0,{$game_id},'{$mysql_connection->connection->real_escape_string($game_details)}')");
					
				}
		
			}else{
				
				if($value == "Destiny"){
					
					$mysql_connection->insertQuery("insert into games (name,console,has_stats,xbox_title_id) values('{$mysql_connection->connection->real_escape_string($value)}','{$console}',1,{$game_id})");
				}else{
					
					$mysql_connection->insertQuery("insert into games (name,console,has_stats,xbox_title_id) values('{$mysql_connection->connection->real_escape_string($value)}','{$console}',0,{$game_id})");
					
				}
			}
		}
		$r = $r->fetch_assoc();
		if($r["has_stats"] == 1){
			$api = strtolower($r["name"]."Api");
			$api = new $api;
			$api->addGamer($gamer);
			$game_rank = 0;
			$gamer->setGameStats($value,$xbox_api,$api);
			
		}else{
			$gamer->setGameStats($value,$xbox_api);
		}
			
	}


	$gamer->games =serialize($gamer->games);
	$mysql_connection->updateQuery(("update gamers set games = '" . $mysql_connection->connection->real_escape_string($gamer->games) . "' where id = {$gamer->id} "));
	$gamer->games = unserialize($gamer->games);
	
	}
	function setPs4Games($mysql_connection,$games,$gamer){
	$psn_api = new PsnApi($gamer);
	$console = serialize(array("ps4"));
	foreach($games["ps"]["ps4"] as $key => $value){
		$r = $mysql_connection->selectQuery("select * from games where name = '{$value}'");
		if(empty($r) || $r->num_rows == 0){
			//print_r($value);
			$game_id = $psn_api->getGameId($value,$gamer->xuid);
			if($value == "Destiny")
				$mysql_connection->insertQuery("insert into games (name,console,has_stats,xbox_title_id) values('{$mysql_connection->connection->real_escape_string($value)}','{$console}',1,{$game_id})");
			else
				$mysql_connection->insertQuery("insert into games (name,console,has_stats,xbox_title_id) values('{$mysql_connection->connection->real_escape_string($value)}','{$console}',0,{$game_id})");
			continue;
		}
		$r = $r->fetch_assoc();
		if($r["has_stats"] == 1){
			$api = strtolower($r["name"]."Api");
			$api = new $api;
			$api->addGamer($gamer);
			$game_rank = 0;
			$gamer->setGameStats($value,$psn_api,$api);
		}else
			continue;
	}
	$mysql_connection->updateQuery(("update gamers set games = '" . $mysql_connection->connection->real_escape_string($gamer->games) . "' where id = {$gamer->id} "));
	}

?>