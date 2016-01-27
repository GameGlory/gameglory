<?php
	class Draft{
		
		public $name    = null;
		public $members = null;
		public $type    = null;
		public $gamers  = null;
		public $pick    = null;
		public $turn    = null;
		public $teams   = null;
		  
		public function __construct($creator,$name,$type){
			$this->name = $name;
			$this->members = array($creator);
			$this->type = $type;
			$this->turn = $creator;
			
		}
		public function setGamers($gamers){
			
			$this->gamers = $gamers;
		}
		public function addMember($member){
			
			if($this->members == null)
				$this->members = array($member);
			else
				array_push($this->members,$member);
		}
		
	}
?>