<?php
 require_once("class.fantasygamingdatabase.php");
 class User{
  
	 public $type = null;
	 
	 public function __construct(){
		$this->type = "visitor";
		
	 }
	 public function getUserType(){
		return $this->type;
	 }
	 static public function isUserLoggedIn($id){
	 	$mysql = new FantasyGamingDataBase();
   		$result = $mysql->selectQuery("select * from managers where id='" . $id."'");
	  	$is_signed_in = $result->fetch_assoc();
	  	
	  	if($is_signed_in['signed_in'] == 1){
			$mysql->close();
			return true;
		}
	  	else {
			$result = $mysql->selectQuery("select * from gamers where id='" . $id."'");
	   		$is_signed_in = $result->fetch_assoc();
	   		if($is_signed_in['signed_in'] == 1){
		   		$mysql->close();
		   		return true;
			}else{
				$mysql->close(); 
			  	return false;
			}
		}	
	}
	static public function verifyUserEmail($email){
		$mysql_connection = null;
		$params = null;
		try{
			$mysql_connection = new FantasyGamingDatabase();
			$params = array();
			array_push($params,$email);
			$params = $mysql_connection->selectQuery("select id , password , email from managers where email = ? join gamers on email ",$params);
			$mysql_connection->close();
			if(empty($params))
				return false;
			else
				return true;
			
		}catch(Exception $ex){
			
		}
	}
		//end of class
 }
?>