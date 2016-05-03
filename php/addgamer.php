<?php
$start = microtime(true);
require_once("class.fantasygamingdatabase.php");
require_once("class.user.php");
require_once("class.gamer.php");
require_once("class.xboxapi.php");
require_once("class.psnapi.php");
require_once("functions.php");
require_once("class.email.php");
class AddGamerException extends Exception{///Start of class ////////////////////
	
	
	
};//////End of class ////////////////////////////////////


class AddGamer{///Start of class ///////////////////////
	
	public  $mail                = null;
	public  $database_connection = null;
	public  $gamer               = null;
	private $name            	 = null;
	private $email           	 = null;
	private $password         	 = null;
	private $birthday         	 = null;
	private $xbox_tag         	 = null;
 	private $psn_tag          	 = null;
	
       
	
	public function __construct($name,$email,$password,$birthday,$xbox_tag=null,$psn_tag=null){
		
		$this->name     		   = $name;
		$this->email    		   = $email;
		$this->password 	 	   = $password;
		$this->birthday 		   = $birthday;
		$this->xbox_tag 	 	   = $xbox_tag;
		$this->psn_tag  	  	   = $psn_tag;
		$this->database_connection = new FantasyGamingDataBase();
		if($this->xbox_tag == null && $this->psn_tag == null)
			throw new AddGamerException("A Xbox Live or PSN username must be specified.");
		
	}

	public function insertGamerIntoDatabase(){
		
		$this->password = sha1($this->password);
		$params = array("name" =>$this->name , "password"=>$this->password, "xbox_id" =>$this->xbox_tag,"psn_id"=>$this->psn_tag,"email"=>$this->email,"age"=>$this->birthday,"signed_in"=>0);
		$insert = $this->database_connection->insertQuery("insert into gamers (username , password   , xbox_id , psn_id ,email , birthday,signed_in)values( ? , ? , ? , ? , ?,?,?)",$params);
		
		if(!$insert)
			throw new AddGamerException("A database error occurred.");
	}
	public function setGamerData(){
			
		$xbox_api    = null;
		$psn_api     = null;
		$profile     = null;
		$users_games = null;
		$xuid        = null;
		$id          = null; 
		$gamer       = null;
		$params      = null;
		
		$profile = array("xbox" => array("gamercard" => array() , "profile" => array()) , "ps" => array());
		$users_games = array("xbox" => array("xbox360" => array() , "xboxone" => array() ) , "ps" => array("ps3" => array() , "ps4" => array()));
		if(!empty($this->xbox_tag) && !empty($this->psn_tag)){
				
			$psn_api  = new PsnApi();
			$xbox_api = new XboxApi();
			$xuid = $xbox_api->getGamerUserId(urlencode($this->xbox_tag));
			$profile["xbox"]["gamercard"] = $xbox_api->getGamerCard($xuid);
			$profile["xbox"]["profile"] = $xbox_api->getGamerProfile($xuid);
			$profile["ps"]=$psn_api->getGamerProfile(urlencode($this->psn_tag));
			$users_games["xbox"]["xbox360"] = $xbox_api->getGamer360Games($xuid); 
			$users_games["xbox"]["xboxone"] = $xbox_api->getGamerXboxOneGames($xuid);
			$users_games["ps"]["ps3"] = $psn_api->getGamersPs3Games(urlencode($this->psn_tag)); 
			$users_games["ps"]["ps4"] = $psn_api->getGamersPs4Games(urlencode($this->psn_tag));
			$params = array("name" =>$this->name , "password"=>$this->password, "xbox_id" =>$this->xbox_tag,"xuid" =>$xuid,"psn_id"=>$this->psn_tag,"games" => serialize($users_games),"email"=>$this->email,"age"=>$this->birthday,"signed_in"=>1,"profile" => serialize($profile));
			$this->database_connection->insertQuery("insert into gamers ( username , password   , xbox_id , xbox_uid , psn_id ,games,email , birthday,signed_in,profile)values( ?,?,? , ? , ? , ? , ?,?,?,?)",$params); 
			
			foreach($users_games["xbox"]["xboxone"] as $key){
					
					$game_id = dechex($xbox_api->getGameId($key,$xuid));
					$details = serialize($xbox_api->getGameDetails($game_id));
					$old_game = $this->database_connection->selectQuery("select * from games where name = '{$key}'");
					if(empty($old_game) || $old_game->num_rows == 0)
						$this->database_connection->insertQuery("insert into games (name,console,has_stats,xbox_title_id,details) values('{$this->database_connection->connection->real_escape_string($key)}','xboxone',0,'{$game_id}','{$this->database_connection->connection->real_escape_string($details)}')");
					
			}
			foreach($users_games["xbox"]["xbox360"] as $key){
					
					$game_id = $xbox_api->getGameId($key,$xuid);
					$details = serialize($xbox_api->getGameDetails($game_id));
					$old_game = $this->database_connection->selectQuery("select * from games where name = '{$key}'");
					echo $game_id;
					print_r($details);
					if(empty($old_game) || $old_game->num_rows == 0)
						$this->database_connection->insertQuery("insert into games (name,console,has_stats,xbox_title_id,details) values('{$this->database_connection->connection->real_escape_string($key)}','xbox360',0,'{$game_id}','{$this->database_connection->connection->real_escape_string($details)}')");
			}
			foreach($users_games["ps"]["ps3"] as $key){
					
					$game_id = $key["npcommid"];
					echo($game_id);
					//$details = serialize($psn_api->getGameDetails($game_id));
					//$old_game = $this->database_connection->selectQuery("select * from games where name = '{$key['title']}'");
					//(empty($old_game) || $old_game->num_rows == 0)
						//$this->database_connection->insertQuery("insert into games (name,console,has_stats,psn_title_id,details) values('{$this->database_connection->connection->real_escape_string($key['title'])}','{$key['platform']}',0,'{$game_id}' , '{$this->database_connection->connection->real_escape_string($details)}')");
			}
			foreach($users_games["ps"]["ps4"] as $key){
					
					$game_id = $key["npcommid"];
					$details = serialize($psn_api->getGameDetails($game_id));
					$old_game = $this->database_connection->selectQuery("select * from games where name = '{$key['title']}'");
					if(empty($old_game) || $old_game->num_rows == 0)
						$this->database_connection->insertQuery("insert into games (name,console,has_stats,psn_title_id,details) values('{$this->database_connection->connection->real_escape_string($key['title'])}','{$key['platform']}',0,'{$game_id}' , '{$this->database_connection->connection->real_escape_string($details)}')");
			}
			
		}else if(!empty($this->xbox_tag)){
			
			$xbox_api = new XboxApi();
			$xuid = $xbox_api->getGamerUserId(urlencode($this->xbox_tag));
			$profile["xbox"]["gamercard"]=$xbox_api->getGamerCard($xuid);
			$profile["xbox"]["profile"]=$xbox_api->getGamerProfile($xuid);
			$users_games["xbox"]["xbox360"] = $xbox_api->getGamer360Games($xuid) ; 
			$users_games["xbox"]["xboxone"] = $xbox_api->getGamerXboxOneGames($xuid) ; 
			$params = array("name" =>$this->name , "password"=>$this->password, "xbox_id" =>$this->xbox_tag,"xuid" =>$xuid,"games" => serialize($users_games),"email"=>$this->email,"age"=>$this->birthday,"signed_in"=>1,"profile" => serialize($profile));
			$this->database_connection->insertQuery("insert into gamers ( username , password   , xbox_id , xbox_uid , psn_id ,games,email , birthday,signed_in,profile)values( ?,?,? , ? , ? , ? , ?,?,?)",$params); 
			foreach($users_games["xbox"]["xbox360"] as $key){
					
					$game_id = $xbox_api->getGameId($key,$xuid);
					$details = serialize($xbox_api->getGameDetails($game_id));
					$old_game = $this->database_connection->selectQuery("select * from games where name = '{$key}'");
					
				
					if(empty($old_game) || $old_game->num_rows == 0)
						$this->database_connection->insertQuery("insert into games (name,console,has_stats,xbox_title_id,details) values('{$this->database_connection->connection->real_escape_string($key)}','xbox360',0,'{$game_id}','{$this->database_connection->connection->real_escape_string($details)}')");
					
			}	
			
			foreach($users_games["xbox"]["xboxone"] as $key){
					
					$game_id = $xbox_api->getGameId($key,$xuid);
					$details = serialize($xbox_api->getGameDetails($game_id));
					$old_game = $this->database_connection->selectQuery("select * from games where name = '{$key}'");
					if(empty($old_game) || $old_game->num_rows == 0)
						$this->database_connection->insertQuery("insert into games (name,console,has_stats,xbox_title_id,details) values('{$this->database_connection->connection->real_escape_string($key)}','xboxone',0,'{$game_id}','{$this->database_connection->connection->real_escape_string($details)}')");
					
			}
		}else if(!empty($this->psn_tag)){
			
			$psn_api = new PsnApi();
			$profile["ps"]=$psn_api->getGamerProfile(urlencode($this->psn_tag));
			
			$users_games["ps"]["ps3"]=$psn_api->getGamersPs3Games(urlencode($this->psn_tag)); 
			$users_games["ps"]["ps4"]=$psn_api->getGamersPs4Games(urlencode($this->psn_tag));
			$params = array("name" =>$this->name , "password"=>$this->password,"psn_id"=>$this->psn_tag,"games" => serialize($users_games),"email"=>$this->email,"age"=>$this->birthday,"signed_in"=>1,"profile" => serialize($profile));
			$this->database_connection->insertQuery("insert into gamers ( username , password   , xbox_id , xbox_uid , psn_id ,games,email , birthday,signed_in,profile)values( ?,?,? , ? , ? , ? , ?,?)",$params);
				
				foreach($users_games["ps"]["ps3"] as $key){
					
					$game_id = $key["npcommid"];
					echo "game id =  " . $key;
					//$details = serialize($psn_api->getGameDetails($game_id));
					//$old_game = $this->database_connection->selectQuery("select * from games where name = '{$key['title']}'");
					//if(empty($old_game) || $old_game->num_rows == 0)
						//$this->database_connection->insertQuery("insert into games (name,console,has_stats,psn_title_id,details) values('{$this->database_connection->connection->real_escape_string($key['title'])}','{$key['platform']}',0,'{$game_id}' , '{$this->database_connection->connection->real_escape_string($details)}')");
				}	
				foreach($users_games["ps"]["ps4"] as $key){
					
					$game_id = $key["npcommid"];
					$details = serialize($psn_api->getGameDetails($game_id));
					$old_game = $this->database_connection->selectQuery("select * from games where name = '{$key['title']}'");
					if(empty($old_game) || $old_game->num_rows == 0)
						$this->database_connection->insertQuery("insert into games (name,console,has_stats,psn_title_id,details) values('{$this->database_connection->connection->real_escape_string($key['title'])}','{$key['platform']}',0,'{$game_id}' , '{$this->database_connection->connection->real_escape_string($details)}')");
				}
		
	
		}
		//$id = $this->database_connection->selectQuery("select id  from gamers where username ='{$this->name}'")->fetch_row();
		
		//$this->gamer = new Gamer($id[0],$this->name,$this->xbox_tag,$this->psn_tag);
		echo(microtime(true) - $start);
	//	session_name("fgs");
		//	session_start();
		//if(session_regenerate_id(true)){
		//	$_SESSION["user"] = null;
		//	$_SESSION["user"] = serialize($this->gamer);
		//	$_SESSION["id"] =  array(session_id() => $this->gamer->id);
			//header("Location:gamer.php?id=${id[0]}");
			
		//}else{
			//do something
		//}
		
		
	}
	public function validateBirthday(){
		
		if(empty($this->birthday))
			throw new AddGamerException("A date for your birthday was not specified. Please specify a date for your bithday.");
		$today = time();
		$today = getdate($today);
		$age   = strtotime($birthday);
		$age   = getdate($age);
		
		if(($today["year"] - $age["year"]) < 17){
			throw new AddGamerException("You must be 18 years of age or older to join the ranks of gamer.");
		}else{
			if(($today["year"] - $age["year"]) == 18){
				if($today["mon"] < $age["mon"])
					throw new AddGamerException("You must be 18 years of age or older to join the ranks of gamer.");
				else if($today["mon"] == $age["mon"]){
					if($today["mday"] < $age["mday"])
						throw new AddGamerException("You must be 18 years of age or older to join the ranks of gamer.");
				}
			}
		}
	}
	public function validateData(){
			
		$this->validateBirthday();
		$this->validateEmail();
		$this->validatePassword();
		$this->validateUsername();
	}
	public function validateEmail(){
			$message = null;
			if(empty($this->email) || $this->email == "" )//need to check if email format is right and check for duplicate emails
				throw new AddGamerException("A valid email was not entered. Please Enter a valid email address.");
			$message = "<div>This is a div.</div>";
			$this->mail = new EMail("bennydorlisme@gaming-for-glory.com", $this->email);
			$this->mail->sendEmail("Confirmation",$message);
			echo "<div class='module_container' id='email_confirmation_module_container'><div class='module' id='email_confirmation_module'><span>An email has been sent to {$this->email}. Please confirm this email address.</div></div>";
	}
	
	public function validatePassword(){
	
		if(empty($this->password) || $this->password == "" || strlen($this->password) < 8)
			throw new AddGamerException("Your password must be at least 8 characters long.");
		$this->password = sha1($this->password);
	}
	
	public function validateUsername(){
		
		$params 		= null;
		$valid_username = null;
		
		if(empty($this->name) || $this->name == "" || strlen($this->name) < 2)
			throw new AddGamerException("An username must be two or more characters long.");
		
		$params = array($this->name);
		$valid_username = $this->database_connection->selectQuery("select username from gamers where username = ?" ,$params);
		if($valid_username){
			if(!empty($valid_username))
				throw new AddGamerException("Invalid Username. The specified username is already being used. Please enter a different username.");	
		}
	}
	public function validatePsnUsername(){
		
		if($this->psn_tag == "" || str_len($this->psn_tag) < 2 || !isset($this->psn_tag))
			throw new AddGamerException("An invalid PSN username was entered. Please enter a valid PSN username.");
		if(!PsnApi::isGamerTagValid($psn_usernmae))
			throw new AddGamerException("An invalid PSN username was entered. Please enter a valid PSN username.");
	}
	public function validateXboxLiveUsername(){
		
		$valid_name = $this->database_connection->selectQuery("select * from gamers where xbox_id ='{$this->xbox_tag}'");
		print_r($valid_name);
			if($this->xbox_tag == "" || str_len($this->xbox_tag) < 2 || !isset($this->xbox_tag) || $valid_name)
				 throw new AddGamerException("An invalid Xbox Live username was entered. Please enter a valid Xbox Live username.");
		if(!XboxApi::isGamerTagValid($this->xbox_tag))
			throw new AddGamerException("An invalid Xbox Live username was entered. Please enter a valid Xbox Live username.");
	}
	
	
	
};//end of class ///////////////


if($_SERVER["REQUEST_METHOD"] == "POST"){
	
 
 $name             = null;
 $password 		   = null;
 $email            = null;
 $birthday         = null;
 $xbox_tag         = null;
 $psn_tag          = null;
 $addgamer         = null;
 
 try{
	
	$name     	   = htmlentities($_POST["gamer_name"]);
	$password 	   = htmlentities($_POST["gamer_password"]);
	$email    	   = htmlentities($_POST["gamer_email"]);
	$birthday      = htmlentities($_POST["gamer_age"]);
	$xbox_tag 	   = htmlentities($_POST["gamer_xbox_id"]);
	$psn_tag  	   = htmlentities($_POST["gamer_psn_id"]);
	$addgamer 	   = new AddGamer($name,$email,$password,$birthday,$xbox_tag,$psn_tag);
		
	$addgamer->validateData();
	$addgamer->setGamerData();
	
}catch(Exception $ex){
 
	if(session_status() == PHP_SESSION_ACTIVE){
		$_SESSION["error"] = $ex->getMessage();
		$_SESSION["user"] = serialize(new User());
	}else{
		session_name("fgs");
		session_start();
		$_SESSION["error"] = $ex->getMessage();
		$_SESSION["user"] = serialize(new User());
	} 		

	     
	 exit;
}
 }else{
 	header("Location:404.php");
 	exit;
 }

?>