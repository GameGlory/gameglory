<?php
require_once("class.fantasygamingdatabase.php");
require_once("class.user.php");
require_once("class.gamer.php");
require_once("class.manager.php");
session_name("fgs");
	session_start();
	$mysql = new FantasyGamingDataBase();
	
	$id = $_SESSION["id"][session_id()];
	if(isset($_SESSION['user'])){
		
		$user = unserialize($_SESSION['user']);
		if($user->type == "gamer"){
			 
				$_SESSION['user'] = null;
	 			$mysql->updateQuery("update gamers set signed_in = 0 where id='" . $id ."'");
		  $_SESSION["id"] = null;    	
			$mysql->close();
			
		}else if($user->type == "manager"){
			
				$_SESSION['user'] = null;
	 			$mysql->updateQuery("update managers set signed_in = 0 where id='" . $id ."'");
		     	 $_SESSION["id"] = null;
			$mysql->close();
			
		}else{
			
		}
	}else{
		
	}
	

 
 
	
	header("Location:../index.php");
?>