<?php
	class BasePage{
		public $title = null;
		public $page_names = null;
		public $header = null;
		public $body = null;
		public $footer = null;
		public $links = null;
		
		public function __construct(){
		
  		// $this->page_names = array("index.php", "usersearch.php" , "league.php" , "gamer.php","signup.php" , "login.php");
		}
		public function changeLinks(){
			
		}
		public function printPage(){
		 	
			echo($this->header);
			$this->body .= $this->footer . "</section>";// quick fix to put footer in container of body... NOT IDEAL!!
			echo($this->body);
			
		}
		
	}
?>