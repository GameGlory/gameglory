<?php
	class League{
		public $id = null;
		public $name = null;
		public $creator = null;
		public $type = null;
		public $draft_type = null;
		public $games = null;
		public $privacy = null;
		public $teams = null;
		public $number_of_teams = null;
		public $consoles = null;
		public $sub_type = null;
		public $scoring_methods = null;
		public $status = null;
		public $draft = null;
		
		public function __construct($name,$creator,$type,$draft_type,$games,$privacy,$number_of_teams,$consoles,$sub_type=null,$scoring_methods=null){
			
			$this->name = $name;
			$this->creator = $creator;
			$this->type = $type;
			$this->draft_type = $draft_type;
			$this->games = $games;
			$this->privacy = $privacy;
			$this->number_of_teams = $number_of_teams;
			$this->consoles = $consoles;
			if(isset($sub_type)){
				$this->sub_type = $sub_type;
				if($this->sub_type == "custom"){
					if($scoring_methods == null || !is_array($scoring_methods))
						throw new Exception("Scoring Method fucked up");
					else
						$this->scoring_methods = $scoring_methods;
					
				}
			}
			$this->status = "drafting";
		}
	}//////////////////end of class
?>