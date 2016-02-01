<?php
  require_once("class.fantasygamingdatabase.php");
  require_once("class.page.php");
  require_once("functions.php");
  class ProjectionsPage extends Page{

	  public function __construct($user){
      
		  	 		$this->projectionsPageModules();
	      	parent::__construct($user);
	      	$this->printPage();
	  }
	  
	  public function projectionsPageModules(){
	   
		$mysql_connection = new FantasyGamingDataBase();
		$leagues = $mysql_connection->selectQuery("select * from leagues where active = 1");
		
		$this->body = "<section class='page_body'>
		 <div class='page_body_header'>";
		  		if($this->checkForErrors()){
			
			$this->body .= $this->getErrorModule();
			$_SESSION["error"] = null;
		}
		$this->body .="</div>
		 <div class='page_body_body'>";
 if(empty($leagues) || !isset($leagues)){
	 $this->body .= "<div class='module_container' id='error_module_container'>
                There are no leagues right now
 <div class='content_module' id='error'	>";
	   
	}else{
		 //$leagues = $leagues->fetch_assoc();
		 $teams = null;
		//print_r($leagues);
		 foreach($leagues as $key){
				  
				 $this->body .= "{$key}";
		 }
	 $this->body.="
	  
	";
	}
				 $this->body .= "</div>
		 <div class='page_body_footer'>
		 
		 </div>
	

		";
	 }
	//////end of class///////////
}
try{
	setUser();
	$page = new ProjectionsPage($user);
}catch(Exception $ex){
	print_r($ex);
}
?>