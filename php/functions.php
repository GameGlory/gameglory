<?php
	
	define(DRAFT_AJAX_ON, "X-Ajax-Draft : true");
	
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
?>