<?php
	require_once("class.api.php");
	class TwitchApi extends Api{
		
		public $client_id = "42imxztsarcix9g3t1yqwhuibrmr96t";
		private $client_secret = "n9k10n210a38w54l3zq7ad0rf9rzbbg";
		
		public function construct(){
			
			$this->url_root="https://api.twitch.tv/kraken";
			$this->api_name ="twitch";
			
		}
	}
?>