<?php
	require_once("class.fantasygamingdatabase.php");
	require_once("class.user.php");
	class Manager extends User{
		
		public $id       = null;
  		public $username = null;
  		public $rank     = null;
  		public $url      = null;
   		public $activity = null;
		
		public function __construct($id , $name ){
			$this->id=$id;
			$this->username=$name;
			$this->type = "manager";
		}
	}
?>