<?php
	require_once("class.api.php");
	abstract class BaseGameApi extends Api{
		
	 private $key        = null;
	 public  $url        = null;
	 public  $gamer      = null; 
	 
	 public function setUrl($url){
	    
		 $this->url = $this->url_root . $url; 
	 }
	 
	 public abstract function getGamerStats($gamer);
	 
	}
?>