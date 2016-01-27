<?php
	require_once("class.api.php");
	abstract class BaseConsoleApi extends Api{
		public $console_name = null;
		public $key  = null;
		
		public function __construct(){
			
		}
		
		//public abstract function getGamerAchievementsForGame($gamer_id, $game_id);
		//public abstract function getGamerAchievements($gamer_id);
		public abstract function getGamerProfile($gamer_id);
		//public abstract function getGameId($game_id);
		
		public abstract function getGamerScore($gamer_id);
		
	}
?>