<?php
require_once("class.fantasygamingdatabase.php");
require_once("class.destinyapi.php");
require_once("class.xboxapi.php");
require_once("class.psnapi.php");

	class StatTracker{
		
		public $console        = null;
		public $game           = null;
		public $gamer          = null;
		public $original_stats = null;
		public $new_stats      = null;
		private $instance      = null;
		
		public function __construct(){
			
		}
		public function getConsoleStats(){
			if($this->console == "xboxone"){
				 $api = new XboxApi();
				 $console_stats = $api->getGamerStats();
				
				}else if ($this->console == "ps4"){
					}
					return $console_stats;
		}
		
		public function getGameStats(){
		   
		}
	}
?>