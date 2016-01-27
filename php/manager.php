<?php
require_once("class.fantasygamingdatabase.php");
require_once("class.user.php");
require_once("class.manager.php");
require_once("class.page.php");
require_once("functions.php");
class ManagerProfilePage extends Page{
	
	public function __construct($user){
		$this->ManagerProfilePageModules();
		parent::__construct($user);
		$this->printPage();
	}
	public function managerProfilePageModules(){
		
		if( $_SERVER["REQUEST_METHOD"] == "GET"){
	if(!isset($_GET['id'])){
		
	}else{
		session_name("fgs");
		session_start();
		$id = null;
		if(isset($_SESSION['id'])){
			
			$id = $_SESSION['id'][session_id()];
			if($id == $_GET['id']){
				if(isset($_SESSION["user"])){
					 $user = unserialize($_SESSION["user"]);
				$mysql = new FantasyGamingDataBase();
			if($user->type == "manager"){
		
				$result = $mysql->selectQuery("select * from managers where id ='" .$id ."'")->fetch_assoc();
				$email = $result['email'];
				$this->body="
					<section class='page_body'>
					<div class='page_body_header'>
					</div>
					<div class='module_container' id='manager_profile_module_container'>
						<div class='module_content' id='manager_profile_module'>
							<header class='module_header' id='manager_profile_module_header'>
								<span class='username_display'>
									{$user->username}
								</span>
							";
							$this->body .="
							<div class='profile_page_contact_information'>
								<div>
									<span>
										Email:
										<a href='mailto:{$email}'>
											{$email}
										</a>
									<span>
								</div>
							
							</div>
							</header>
							<div class='module_body' id='manager_profile_module_body'>
								<div class='module_body_header' id='manager_profile_module_body_header'>
								<div>
								<div class='module_body_body' id='manager_profile_module_body_body'>
									<div class='manager_profile_rank_section'>
										<img />
										<span class='manager_rank_display'>
											{$user->rank}
										</span>
									</div>
									
									<div class='manager_profile_leagues_section'>
										<table>
											<tr>
												<th>
													Name
												</th>
												<th>
													Teams
												</th>
												<th>
													Status
												</th>
											</tr>
										</table>
									</div>
									
								</div>
								<div class='module_body_footer' id='manager_profile_module_body_footer'>
								<div>
							</div>
							<div class='module_footer' id='manager_profile_module_footer'>
									<header class='module_footer_header'>";
									//$fb_api = new FacebookApi();
										$this->body .="<div class='module_footer_header_account_query' id='module_footer_header_Facebook_account_query'>
											<hgroup>
												<h1>
													Do You Have a Facebook account?
												</h1>
												<h3>
													Sign in so you can share your Leagues
												</h3>
											</hgroup>
											<div id='facebook_signin_button'>
			                                        <span>
				                                           <a href='#'>
				                                               Sign In
				                                           </a>
			                                        </span>
		                                    </div>
										</div>
									</header
							</div>
							<div class='page_body_footer'>
							
							</div>
						
					";
					
					
					$mysql->close();
					
			}else if($user->type == "gamer"){
					$result = $mysql->selectQuery("select * from gamers where id ='" .$id ."'")->fetch_assoc();
					$email = $result['email'];
					$name = $result['username'];
					$xbox_tag = $result['xbox_id'];
					$psn_tag = $result['psn_id'];
					$mysql->close();
			}else{
					$result = $mysql->selectQuery("select * from gamers where id ='" .$id ."'")->fetch_assoc();
					$email = $result['email'];
					$name = $result['username'];
					$xbox_tag = $result['xbox_id'];
					$psn_tag = $result['psn_id'];
					$mysql->close();
			}
				
			}else{
				header("Location:404.php");
			}
		}else{
			
		}
		}else{
			
		}
	}
}else{
	header("Location:404.php");
}
	}
}

try{
	setUser();
	$page = new ManagerProfilePage($user);
}catch(Exception $ex){
	print_r($ex);
}
?>