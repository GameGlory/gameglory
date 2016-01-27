<?php
require_once("class.fantasygamingdatabase.php");
require_once("class.manager.php");
if($_SERVER["REQUEST_METHOD"] == "POST"){
 $mysql_connection = null;
 $name             = null;
 $password         = null;
 $email            = null;
 $birthday         = null;
 $signed_in        = null;
 class AddManagerException extends Exception{
	
	
	//end of class ///////////////
}
 try{
 	 $name     = htmlentities($_POST["manager_name"]);
		 $password = sha1(htmlentities($_POST["manager_password"]));
		 $email    = htmlentities($_POST["manager_email"]);
		 $birthday = htmlentities($_POST["manager_age"]);
		 $signed_in = 1;
 	$mysql_connection = new FantasyGamingDataBase();
 		if(empty($name) || $name == '')
		throw new AddManagerException("Invalid Username");
	else{
		$valid_username = $mysql_connection->selectQuery("select * from managers where username = {$name}");
		if(!empty($valid_email))
			throw new AddManagerException("Invalid Username. That name has already been taken. Please enter a different name.");	
	}
	if(empty($password) || $password == '' || strlen($password) < 8)
		throw new AddManagerException("Invalid Password. Passwords must contain at least 8 characters");
	if(empty($email) || $email == '')
		throw new AddManagerException("Invalid email");
	else{
		$valid_email = $mysql_connection->selectQuery("select * from gamers where email = {$email}");
		if(empty($valid_email)){
			$valid_email = $mysql_connection->selectQuery("select * from managers where email = {$email}");
			if(!empty($valid_email)){
				throw new AddManagerException("Invalid email");
			}
		}else
			throw new AddManagerException("Invalid email");
	}
	if(empty($birthday))
		throw new AddManagerException("Invalid Birthday");
	$today = time();
	$today = getdate($today);
	$age   = strtotime($birthday);
	$age = getdate($age);
	if(($today["year"] - $age["year"]) < 17){
		throw new AddManagerException("You must be 18 years of age or older to join the ranks of gamer.");
	}else{
		if(($today["year"] - $age["year"]) == 18){
			if($today["mon"] < $age["mon"])
				throw new AddManagerException("ggYou must be 18 years of age or older to join the ranks of gamer.");
			else if($today["mon"] == $age["mon"]){
				if($today["mday"] < $age["mday"])
					throw new AddManagerException("ppYou must be 18 years of age or older to join the ranks of gamer.");
			}
		}
	}
		
		
	 		   $params = array("name" =>$name , "password"=>$password,"email"=>$email,"age"=>$birthday,"signed_in"=>$signed_in);
	 		   $mysql_connection->insertQuery("insert into managers (username , password ,email , birthday,signed_in)values( ? , ? , ?,?,?)",$params);
		      $params = array("email"=>$email);
		      $result = $mysql_connection->selectQuery("select * from managers where email = ?",$params);
			$mysql_connection->close();
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
	     		if(isset($_SESSION["current_page"])){
			$_SESSION["previous_page"] = $_SESSION["current_page"];
			$_SESSION["current_page"] = $page->page_name;
		}else{
			$_SESSION["previous_page"] = null;
			$_SESSION["current_page"] = $page->page_name;
		}
	     		$_SESSION["error"] = $ex->getMessage();
			 if(!isset($_SESSION["previous_page"]))
			 	header("Location:/index.php");
	  			if($_SESSION["previous_page"] == "index.php")
				header("location:/{$_SESSION['previous_page']}");
			else
				header("location:{$_SESSION['previous_page']}");
			
	}else{
	  session_name("fgs");
	  session_start();
	  	if(isset($_SESSION["current_page"])){
			$_SESSION["previous_page"] = $_SESSION["current_page"];
			$_SESSION["current_page"] = $page->page_name;
		}else{
			$_SESSION["previous_page"] = null;
			$_SESSION["current_page"] = $page->page_name;
		}
	  $_SESSION["error"] = $ex->getMessage();
	  if($_SESSION["previous_page"] == "index.php")
				header("location:/{$_SESSION['previous_page']}");
			else
				header("location:{$_SESSION['previous_page']}");
				
	}
	exit;
}

session_name("fgs");
session_start();
$user = new Manager($result["id"] , $result["username"]);
$_SESSION['id'] =  array(session_id() => $id);
$_SESSION["user"] = serialize($user);
header("Location:/index.php");
}else{
	header("Location:404.php");
}
	
?>