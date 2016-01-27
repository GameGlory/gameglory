<?php
require_once("class.fantasygamingdatabase.php");
require_once("class.user.php");
require_once("class.gamer.php");
require_once("class.xboxapi.php");
require_once("class.psnapi.php");

class AddGamerException extends Exception{
	
	
	//end of class ///////////////
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
if($_SERVER["REQUEST_METHOD"] == "POST"){
	
 $mysql_connection = null;
 $gamer            = null;
 $name             = null;
 $password         = null;
 $email            = null;
 $birthday         = null;
 $xbox_tag         = null;
 $psn_tag          = null;        
 $signed_in        = null;
 $rank             = null;
 $xbox_api         = null;
 $psn_api          = null;

 $name     = htmlentities($_POST["gamer_name"]);
 $password = $_POST["gamer_password"];
 $email    = htmlentities($_POST["gamer_email"]);
 $birthday = $_POST["gamer_age"];
 $xbox_tag    = htmlentities($_POST["gamer_xbox_id"]);
 $psn_tag = htmlentities($_POST["gamer_psn_id"]);
 $signed_in = 1;
$mysql_connection = new FantasyGamingDataBase();
  try{
 
  	if(empty($name) || $name == '')
		throw new AddGamerException("Invalid Username");
	else{
		$params = array($name);
		$valid_username = $mysql_connection->selectQuery("select * from gamers where username = ?" ,$params);
		
		if(!empty($valid_username))
			throw new AddGamerException("Invalid Username. That name has already been taken. Please enter a different name.");	
	}
	if(empty($password) || $password == '' || strlen($password) < 8)
		throw new AddGamerException("Invalid Password. Passwords must contain at least 8 characters");
	if(empty($email) || $email == '')
		throw new AddGamerException("Invalid email");
	else{
		$params = array($email);
		$valid_email = $mysql_connection->selectQuery("select * from gamers where email = ?" ,$params);
		if(empty($valid_email)){
			$valid_email = $mysql_connection->selectQuery("select * from managers where email = ?",$params);
			if(!empty($valid_email)){
				throw new AddGamerException("Invalid email. That email address is already being used.");
			}
		}else
			throw new AddGamerException("Invalid email. That email address is already being used. ");
	}
	if(empty($birthday))
		throw new AddGamerException("Invalid Birthday");
	$today = time();
	$today = getdate($today);
	$age   = strtotime($birthday);
	$age = getdate($age);
	
	if(($today["year"] - $age["year"]) < 17){
		throw new AddGamerException("You must be 18 years of age or older to join the ranks of gamer.");
	}else{
		if(($today["year"] - $age["year"]) == 18){
			if($today["mon"] < $age["mon"])
				throw new AddGamerException("ggYou must be 18 years of age or older to join the ranks of gamer.");
			else if($today["mon"] == $age["mon"]){
				if($today["mday"] < $age["mday"])
					throw new AddGamerException("You must be 18 years of age or older to join the ranks of gamer.");
			}
		}
	}
	

	 $password = sha1(htmlentities($_POST["gamer_password"]));
	 if(!empty($xbox_tag) && $xbox_tag != ''){
	 	if(!empty($psn_tag) && $psn_tag != ''){
	 		
	 		$valid_xbox_id = XboxApi::isGamerTagValid($xbox_tag);
			$valid_psn_id = PsnApi::isGamerTagValid($psn_tag);
			if( $valid_xbox_id  == true && $valid_psn_id  == true ){
				
				// $mysql_connection->insertQuery("insert into gamers (username , password   , email,birthday,xbox_id , psn_id ,signed_in)values( ? , ? , ? , ? , ?,?,?)",$params);
			     $params = array("name" =>$name , "password"=>$password, "xbox_id" =>$xbox_tag,"psn_id"=>$psn_tag,"email"=>$email,"age"=>$birthday,"signed_in"=>$signed_in);
				 $mysql_connection->insertQuery("insert into gamers (username , password   , xbox_id , psn_id ,email , birthday,signed_in)values( ? , ? , ? , ? , ?,?,?)",$params);
				 
				 $params = array("email"=>$email);	
				$result = $mysql_connection->selectQuery("select * from gamers where email = ?",$params);
				if(empty($result))
					throw new AddGamerException("An Database error occurred");
				$id = $result["id"];
				$gamer = new Gamer($id , $name , $xbox_tag , $psn_tag);
				$xbox_api = new XboxApi($gamer);
				$psn_api = new PsnApi($gamer);
				$xuid = $xbox_api->getGamerUserId($xbox_tag);
				$gamer->xuid = $xuid;
				$mysql_connection->updateQuery("update gamers set xbox_uid = {$xuid} where id = {$gamer->id}");
				$games = array("xbox"=> array( "xboxone" => $xbox_api->getGamerXboxOneGames($xuid), "xbox360" => $xbox_api->getGamer360Games($xuid)) , /*"ps" => array("ps4" => $psn_api->getGamersPs4Games($psn_tag) , "ps3" => $psn_api->getGamersPs3Games($psn_tag))*/ );
				setXboxOneGames($mysql_connection, $games, $gamer,$xbox_api);
				//setPs4Games($mysql_connection, $games, $gamer);
				$xbox_profile = $xbox_api->getGamerProfile($gamer->xuid);
				$xbox_gamer_card = $xbox_api->getGamerCard($gamer->xuid);
				$psn_profile = $psn_api->getGamerProfile($gamer->psn_id);
				$xbox_activity = $xbox_api->getGamerActivity($gamer->xuid);
				$gamer->profiles["xbox"] = $xbox_profile;
				$xbox_pics = array("avatar"=>$xbox_gamer_card["avatarBodyImagePath"],"small" => $xbox_gamer_card["gamerpicSmallSslImagePath"], "large" => $xbox_gamer_card["gamerpicLargeSslImagePath"], "profile" => $xbox_profile["GameDisplayPicRaw"]);
				$xbox_pics = serialize($xbox_pics);
				//$gamer->profiles["psn"] = $psn_profile;
				$xbox_profile = serialize($xbox_profile);
				$mysql_connection->updateQuery("update gamers set xbox_pics = '{$xbox_pics}' where id = {$gamer->id}" );
				//$mysql_connection->updateQuery("update gamers set psn_pics = {$psn_pics} where id = {$id}" );
				$mysql_connection->updateQuery("update gamers set xbox_profile = '{$xbox_profile}' where id = {$gamer->id}" );		
}else if($valid_xbox_id == false || $valid_psn_id == false){
			
			if($valid_xbox_id == false && $valid_psn_id == false)
				throw new AddGamerException("No Valid Game Ids Entered");
			else if($valid_xbox_id == true && $valid_psn_id == false)
				throw new AddGamerException("Invalid PSN ID");
			else if($valid_xbox_id == false && $valid_psn_id == true)
				throw new AddGamerException("Invalid Xbox ID");
		} 
	 	}else{
	 		$psn_tag = '';
					$valid_xbox_id = XboxApi::isGamerTagValid($xbox_tag);
					
			if( $valid_xbox_id == true){
				$params = array("name" =>$name , "password"=>$password, "xbox_id" =>$xbox_tag,"psn_id"=>$psn_tag,"email"=>$email,"age"=>$birthday,"signed_in"=>$signed_in);
				$mysql_connection->insertQuery("insert into gamers (username , password   , xbox_id , psn_id ,email , birthday,signed_in) values( ? , ? , ? , ? , ?,?,?)",$params);
				 $params = array("email"=>$email);	
				 $result = $mysql_connection->selectQuery("select * from gamers where email = ?",$params);		
				 if(empty($result))
					throw new AddGamerException("An Database error occurred");
				 $id = $result["id"];
				 $gamer = new Gamer($id , $name , $xbox_tag , $psn_tag);
				 $xbox_api = new XboxApi($gamer);
				 $xuid = $xbox_api->getGamerUserId($xbox_tag);
				 $gamer->xuid = $xuid;
				 $mysql_connection->updateQuery("update gamers set xbox_uid = {$xuid} where id = {$gamer->id}");
				 $games = array("xbox"=> array("xboxone" => $xbox_api->getGamerXboxOneGames($xuid), "xbox360" => $xbox_api->getGamer360Games($xuid)) , "ps" => array() );
			  	 setXboxOneGames($mysql_connection, $games, $gamer,$xbox_api);
	 			 $xbox_profile = $xbox_api->getGamerProfile($gamer->xuid);
				 $xbox_gamer_card = $xbox_api->getGamerCard($gamer->xuid);
				 $xbox_activity = $xbox_api->getGamerActivity($gamer->xuid);
			
				$gamer->profiles["xbox"] = $xbox_profile;
				$xbox_pics = array("avatar"=>$xbox_gamer_card["avatarBodyImagePath"],"small" => $xbox_gamer_card["gamerpicSmallSslImagePath"], "large" => $xbox_gamer_card["gamerpicLargeSslImagePath"], "profile" => $xbox_profile["GameDisplayPicRaw"]);
				$xbox_pics = serialize($xbox_pics);
				$xbox_profile = serialize($xbox_profile);
				$mysql_connection->updateQuery("update gamers set xbox_pics = '{$xbox_pics}' where id = {$gamer->id}" );
				$mysql_connection->updateQuery("update gamers set xbox_profile = '{$xbox_profile}' where id = {$gamer->id}" );
			
			}else{
	 		
	 		   throw new AddGamerException("Invalid Xbox Live ID");
	 	}
		
		}
		}else if(isset($psn_tag) && $psn_tag != ''){
		$xbox_tag = '';
		
			$valid_psn_id = PsnApi::isGamerTagValid($psn_tag);
			if( $valid_psn_id  == true ){
				$params = array("name" =>$name , "password"=>$password, "xbox_id" =>$xbox_tag,"psn_id"=>$psn_tag,"email"=>$email,"age"=>$birthday,"signed_in"=>$signed_in);
				$mysql_connection->insertQuery("insert into gamers (username , password   , xbox_id , psn_id ,email , birthday,signed_in)values( ? , ? , ? , ? , ?,?,?)",$params);
				$params = array("email"=>$email);
			   $result = $mysql_connection->selectQuery("select * from gamers where email = ?",$params);
				$id = $result["id"];
				$gamer = new Gamer($id , $name , $xbox_tag , $psn_tag);
				$psn_api = new PsnApi($gamer);
				$games = array("xbox"=> array() , "ps" => array("ps4" => $psn_api->getGamersPs4Games($psn_tag) , "ps3" => $psn_api->getGamersPs3Games($psn_tag)) );
				//setPs4Games($mysql_connection, $games, $gamer);
		 		}else{
		 			throw new AddGamerException("Invaild PSN ID");
		 		}
	}else{
		throw new AddGamerException("No Valid Gamer IDs Entered! ");
	}
}catch(Exception $ex){
 
	     if($id != null){
	     	if(!isset($mysql_connection)){
			$mysql_connection = new FantasyGamingDataBase();
			$mysql_connection->deleteQuery("delete from gamers where id={$id}");
			$mysql_connection->close();
			}else{
				$mysql_connection->deleteQuery("delete from gamers where id={$id}");
				$mysql_connection->close();
			}
		}
	     if(session_status() == PHP_SESSION_ACTIVE){
	   
	     		$_SESSION["error"] = $ex->getMessage();
			 if(!isset($_SESSION["previous_page"]))
			 	header("Location:/index.php");
	  			if($_SESSION["previous_page"] == "index.php")
				header("location:/{$_SESSION['previous_page']}");
			else
				header("location:{$_SESSION['previous_page']}");
			
			$_SESSION["user"] = serialize(new User());
	}else{
	  session_name("fgs");
	  session_start();
	  $_SESSION["error"] = $ex->getMessage();
	  if($_SESSION["previous_page"] == "index.php")
				header("location:/{$_SESSION['previous_page']}");
			else
				header("location:{$_SESSION['previous_page']}");
				$_SESSION["user"] = serialize(new User());
	}
	exit;
}


$mysql_connection->close();
session_name("fgs");
session_start();

$_SESSION['user'] = serialize($gamer);
$_SESSION['id'] =  array(session_id() => $id);
header("Location:gamer.php?id=".$gamer->id );
 }else{
 	header("Location:404.php");
 }

?>