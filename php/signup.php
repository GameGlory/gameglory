<?php
require_once("class.page.php");
require_once("class.user.php");
class SignUpPage extends Page{
		
		public function __construct($user){
			$this->signUpPageModules();
			parent::__construct($user);
			$this->printPage();
		}
		public function signUpPageModules(){
	 		if(session_status() != PHP_SESSION_ACTIVE){
		
		 session_name("fgs");
		 session_start();
		 if(isset($_SESSION["error"])){
			 
			 $error = unserialize($_SESSION["error"]);
			  $error = $error->getError();
			  
			}else{
			 
			}	
		}
    $this->body = " <section class='page_body'>
    <div class='page_body_header'>";
  		if($this->checkForErrors()){
			
			$this->body .= $this->getErrorModule();
			$_SESSION["error"] = null;
		}
		$this->body .= "</div>
		 <div class='page_body_body'>
		
   	 <div class='module_container' id='signup_module_container'>
                  <div class='content_module' id='signup_module'>
                  <header>
						<h3>
							Create The Ultimate Gaming League
						</h3>
				  </header>
                      <form  id='manager_signup_form' method='post' action='/php/addmanager.php'>
				                      <fieldset>
			 	                         <legend>
				 	                            Personal Information
				                          </legend>
					                         <label for='manager_name'>
					                             Username
					                          </label>
					                         <input type='text' name='manager_name' id='manager_name' />
					<br/>
					 <label for='manger_email'>Email</label>
					<input type='email' name='manager_email' />
					<br/>
		   <label for='manager_password'>Password</label>
					 <input type='password' name='manager_password'/>
					 <br/>
					 <label for='manager_age'>Birthday</label>
					<input type='date' name='manager_age'/>
					<input type='submit' value='Join Now!'/>
					</fieldset>
				
		
					
				</form>
		</div>
		
		<div id='gamer_signup_form_container'>
			
			<header>
				<h3>
					Game for honor and glory!
				</h3>
			</header>
			<form  id='gamer_signup_form' method='post' action='/php/addgamer.php'>
			<fieldset>
			<legend>
			Personal Information
			</legend>
				<label for='gamer_name'>Name</label>
				<input type='text' name='gamer_name'/>
				<br/>
				 <label for='gamer_email'>Email</label>
				<input type='email' name='gamer_email'/>
				<br/>
				 <label for='gamer_age'>Birthday</label>
				<input type='date' name='gamer_age'/>
				<br/>
				</fieldset>
				<fieldset>
				<legend>
				User Information
				</legend>
				 <label for='gamer_xbox_id'>Xbox Live ID</label>
				 <input type='text' name='gamer_xbox_id'/>
				 <br/>
				 <label for='gamer_psn_id'>PSN ID</label>
				 <input type='text' name='gamer_psn_id'/>
				 <br/>
				 <label for='gamer_password'>Password</label>
				 <input type='text' name='gamer_password'/>
				</fieldset>
				<input type='submit' value='Join Now!'/>
			</form>
                  </div>
             </div>
             <div>
              <div class='page_body_footer'>
			</div>
          
   ";
}
	}
try{
	if(session_status() == PHP_SESSION_ACTIVE){
		if(isset($_SESSION["user"])){ 
			$user = unserialize($_SESSION["user"]);
			if(isset($_SESSION["id"])){
					
			}
		}else{
			$user = new User();
			$_SESSION["user"] = serialize($user);
		}
	}else if(session_status() == PHP_SESSION_NONE){
		session_name("fgs");
		session_start();
		if(!isset($_SESSION['user'])){
			$user = new User();
			$_SESSION['user'] = serialize($user);
		}else{
			$user = unserialize($_SESSION["user"]);
		}
	}
	if($user instanceof Gamer || $user instanceof Manager)
		header("Location:/index.php");
	$page = new SignUpPage($user);
}catch(Exception $ex){
	print_r($ex);
}
?>