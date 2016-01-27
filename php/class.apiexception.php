<?php
	class ApiException extends Exception{
		
			public function goToPreviousPage(){
			 if(session_status() == PHP_SESSION_ACTIVE){
	     
	     		$_SESSION["error"] = $this->getMessage();
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
	  $_SESSION["error"] = $this->getMessage();
	  if($_SESSION["previous_page"] == "index.php")
				header("location:/{$_SESSION['previous_page']}");
			else
				header("location:{$_SESSION['previous_page']}");
				
	}
	
		}
		
	}
	}
?>