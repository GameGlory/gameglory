<?php
require_once("class.fantasygamingdatabase.php");
require_once("class.gamer.php");
require_once("class.page.php");
require_once("class.user.php");
require_once("class.manager.php");
require_once("class.xboxapi.php");
require_once("class.loginexception.php");
require_once("functions.php");
class LoginPage extends Page{
	
	public function __construct($user){
		$this->loginPageModules();
		parent::__construct($user);
		$this->printPage();
	}
	public function loginPageModules(){
		
		$this->body = "<section class='page_body'>
		 <div class='page_body_header'>";
		  if($this->checkForErrors()){
			
			$this->body .= $this->getErrorModule();
			$_SESSION["error"] = null;
		}
		$this->body.="</div>
		 <div class='page_body_body'>
		
		<div class='module_container' id='login_module_container'>
        	<div class='content_module' id='login_module'>
				<form action='/php/login.php' method='post'>
					<legend>
						Login
					</legend>
				  	<fieldset>
				  		<label for='email'>
				  			Email
				  		</label>
						<input type='text' name='email' />
						<label for='password'>
				  			Password
				  		</label>
						<input type='password' name='password' />
						<input type='submit' value='login' /> 
					</fieldset>	
					</form>
			</div>
		</div>
		</div>
		 <div class='page_body_footer'>
		</div>
	";
}
	////end of class //////////////
}
$email    = null;
$password = null;
$user     = null; 
if($_SERVER["REQUEST_METHOD"] == "POST"){
try{
	$email               = htmlentities($_POST['email']);
	$password            = sha1(htmlentities($_POST['password']));
	$mysql_connection    = new FantasyGamingDataBase();
	$params = array($email,$password);
	if(empty($email) || empty($password))
		throw new LoginException("Invalid username or password");
	$params = $mysql_connection->selectQuery("select * from managers where email = ? and password = ?",$params);
	
	
	 if(!empty($params)){
	 		
		 if($params["email"] == $email && $password == $password){
			$id = $params["id"];
			$name = $params["username"];
			$mysql_connection->updateQuery("update managers set signed_in=1 where id=" .$id);
			 $mysql_connection->close();
			 session_name("fgs");
			session_start();
			if(isset($_SESSION["current_page"])){
			$_SESSION["previous_page"] = $_SESSION["current_page"];
			$_SESSION["current_page"] = $page->page_name;
		}else{
			$_SESSION["previous_page"] = null;
			$_SESSION["current_page"] = $page->page_name;
		}
			if(isset($_SESSION['id'])){
			if(isset($_SESSION["user"])){
				$user = unserialize($_SESSION["user"]);
				if($user->getUserType() == "visitor" || $user->getUserType() == "gamer" ){
					$user = new Manager($id , $name);
					$_SESSION["user"] = serialize($user);
				}
				
				if($_SESSION["previous_page"] == "index.php" || $_SESSION["previous_page"] == "login.php")
		      	header("Location:../index.php");
			else
			   			header("Location:" . $_SESSION["previous_page"]);
			}else{
				$user = new Manager($id , $name);
				$_SESSION["user"] = serialize($user);
				$mysql_connection->close();
			}
		}else{
			$_SESSION['id'] =  array(session_id() => $id);
			if(isset($_SESSION["user"])){
				$user = unserialize($_SESSION["user"]);
				if($user->getUserType() == "visitor" || $user->getUserType() == "gamer" ){
					$user = new Manager($id , $name);
					$_SESSION["user"] = serialize($user);
				}
				$mysql_connection->close();
				if($_SESSION["previous_page"] == "index.php" || $_SESSION["previous_page"] == "login.php")
		      	header("Location:../index.php");
			else
			   			header("Location:" . $_SESSION["previous_page"]);
				
			}
			else{
				$user = new Manager($id , $name);
				$_SESSION["user"] = serialize($user);
				$mysql_connection->close();
				if($_SESSION["previous_page"] == "index.php" || $_SESSION["previous_page"] == "login.php" )
		      	header("Location:../index.php");
			else
			   			header("Location:" . $_SESSION["previous_page"]);
			}
			
		}
		}else{
			throw new LoginException("Invalid email or password");
		}
	}else{
		$params = array($email,$password);
		$params = $mysql_connection->selectQuery(("select * from gamers where email = ? and password = ?"),$params);
		if(empty($params))
			throw new LoginException("Invalid email or password");
		if($params["email"] == $email && $params["password"]  == $password){
			$mysql_connection->updateQuery(("update gamers set signed_in=1 where id= {$params["id"]}"));
			
			$id       = $params["id"];
			$name     = $params["username"];
			$xbox_tag = $params["xbox_id"];
			$psn_tag  = $params["psn_id"];
			$games    = unserialize($params["games"]);
		
			//need to check for psn tag as well
			if(!empty($xbox_tag)){
				$gamer = new Gamer($id,$name,$xbox_tag,$psn_tag);
				$xbox_api = new XboxApi($gamer);
				$gamer->xuid = $params["xbox_uid"];
				$gamer->games = $games; 
				$gamer->activity = $xbox_api->getGamerActivity($gamer->xuid);
			}else{
				
				$gamer = new Gamer($id,$name,$xbox_tag,$psn_tag);
			}
				
			
		session_name("fgs");
		session_start();
		if(isset($_SESSION["current_page"])){
			$_SESSION["previous_page"] = $_SESSION["current_page"];
			$_SESSION["current_page"] = $page->page_name;
		}else{
			$_SESSION["previous_page"] = null;
			$_SESSION["current_page"] = $page->page_name;
		}
		if(isset($_SESSION['id'])){
			if(isset($_SESSION["user"])){
				$user = unserialize($_SESSION["user"]);
				if($user->getUserType() == "visitor" || $user->getUserType() == "manager" ){
					$_SESSION["user"] = serialize($gamer);
				}
				$mysql_connection->close();
   if($_SESSION["previous_page"] == "index.php" || $_SESSION["previous_page"] == "login.php" )
		      	header("Location:../index.php");
			else
			   			header("Location:" . $_SESSION["previous_page"]);
			}else{
				$_SESSION["user"] = serialize($gamer);
				$mysql_connection->close();
			}
		}else{
			$_SESSION['id'] =  array(session_id() => $id);
			if(isset($_SESSION["user"])){
				$user = unserialize($_SESSION["user"]);
				if($user->getUserType() == "visitor" || $user->getUserType() == "manager" ){
					
					$_SESSION["user"] = serialize($gamer);
				}
				$mysql_connection->close();
			 if($_SESSION["previous_page"] == "index.php" || $_SESSION["previous_page"] == "login.php" )
		      	header("Location:../index.php");
			else
			   			header("Location:" . $_SESSION["previous_page"]);
				
			}
			else{
				
				$_SESSION["user"] = serialize($gamer);
				$mysql_connection->close();
    if($_SESSION["previous_page"] == "index.php" || $_SESSION["previous_page"] == "login.php" )
		      	header("Location:../index.php");
			else
			   			header("Location:" . $_SESSION["previous_page"]);
			}
			
		}
			
			
		}else{
			throw new LoginException("Invalid email or password");
		}
	}
	

	}catch(Exception $ex){
			if(session_status() == PHP_SESSION_ACTIVE){
	     
	     		$_SESSION["error"] = $ex->getMessage();
			 if(!isset($_SESSION["previous_page"]))
			 	header("Location:/index.php");
	  			if($_SESSION["previous_page"] == "index.php")
				header("location:/{$_SESSION['previous_page']}");
			else if($_SESSION["previous_page"] == "login.php")
				header("location:{$_SESSION['previous_page']}");
			else
				header("location:{$_SESSION['current_page']}");
			
	}else{
	  session_name("fgs");
	  session_start();
	  	
	  $_SESSION["error"] = $ex->getMessage();
	  if($_SESSION["previous_page"] == "index.php")
				header("location:/{$_SESSION['previous_page']}");
			else
				header("location:{$_SESSION['previous_page']}");
				
	}
	exit;
	}

}else{
	try{
		setUser();
		$page = new LoginPage($user);                                                             
	}catch(Exception $ex){
	print_r($ex);
	}
}
?>