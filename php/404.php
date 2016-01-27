<?php
require_once("class.page.php");
require_once("functions.php");
class PageNotFoundPage extends Page{

	public function __construct($user){
	
		$this->pageNotFoundModules();
		parent::__construct($user);
		$this->printPage();
	}
	
	public function pageNotFoundModules(){
		
		$this->body = "<section class='page_body'>
		 <div class='page_body_header'>
		</div>
		 <div class='page_body_body'>
		  Page not found
		 </div>
		
		 <div class='page_body_footer'>
		 </div>
		
		";
	}
}
try{
	setUser();
	$page = new PageNotFoundPage($user);

}catch(Exception $ex){
	print_r($ex);
}
?>