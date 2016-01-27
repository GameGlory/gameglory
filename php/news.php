<?php
require_once("class.page.php");
require_once("functions.php");
	class NewsPage extends Page{
		
		public function __construct($user){
			parent::__construct($user);
			$this->newsPageModules();
			$this->printPage();
		}
		
		public function newsPageModules(){
			 		$this->body = "<section class='page_body'>
		 <div class='page_body_header'>";
		 if($this->checkForErrors()){
			
			$this->body .= $this->getErrorModule();
			$_SESSION["error"] = null;
		}
		$this->body .="</div>
		 <div class='page_body_body'>
		  	<div class='module_container' id='gamer_news_module_container'>
		  		<div class='module_content' id='gamer_news'>
		  			
		  		</div>
		  	</div>
		 </div>
		
		 <div class='page_body_footer'>
		 </div>
	
		";
		}
		////end of class /////////////
	}
	try{
		setUser();
		$page = new NewsPage($user);
}catch(Exception $ex){
	print_r($ex);
}
?>