<?php
	
	class Socket {
		
		public $socket = null;
		
		public function __construct(){
			
			$this->socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
			
		}
		
		public function init($address,$port){
			
			socket_connect($this->socket, $address,$port);
		}
	}
?>