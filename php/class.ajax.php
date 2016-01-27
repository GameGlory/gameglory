<?php

	
	require_once("class.fantasygamingdatabase.php");
	require_once("php/class.xboxapi.php");
	require_once("php/class.psnapi.php");
	class Ajax{
		
		private $mysql_connection = null;
		
		public function __construct(){
			
			$this->mysql_connetion = new FantasyGamingDataBase();
		}
		public function __autoload($class){
		   include_once("class.{$class}.php");
		}
		public function getGamesStats($game){
			
			$stats = null;
			try{
			if($this->mysql_connetion == null)
				throw new Exception("Error");
			
			if($this->mysql_connection->selectQuery("select {$game} from games where has_stats = 1")){
				
			}
			}catch(Exception $ex){
				print_r($ex);
			}
		}
		
	}


?>