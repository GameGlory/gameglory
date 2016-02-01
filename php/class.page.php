<?php
require_once("class.basepage.php");
require_once("class.user.php");
require_once("class.gamer.php");
require_once("class.manager.php");
require_once("class.fantasygamingdatabase.php");
class Page extends BasePage{
  	
  public $page_name = null;
  
  public function __construct($user){
	   $this->page_name = basename($_SERVER["PHP_SELF"]);
	   if(session_status() == PHP_SESSION_NONE){
		    session_name("fgs");
		    session_start();
	   }
	 			if(isset($_SESSION["current_page"])){
			$_SESSION["previous_page"] = $_SESSION["current_page"];
			$_SESSION["current_page"] = $this->page_name;
		}else{
			$_SESSION["previous_page"] = null;
			$_SESSION["current_page"] = $this->page_name;
		}
 	  parent::__construct();
	  
	  $this->setPageHeader($this->page_name, $user);
	  $this->setPageFooter();
   
	
  }
  public function checkForErrors(){
  	if(session_status() == PHP_SESSION_ACTIVE){
  		if(isset($_SESSION["error"]))
  			return true;
		else
  			return false;
	}else{
		session_name("fgs");
		session_start();
		if(isset($_SESSION["error"]))
  			return true;
		else
  			return false;
	}
  }
  public function getErrorModule(){
  	$module = null;
  	if(session_status() == PHP_SESSION_ACTIVE){
  		$module = "<div class='module_container' id='error_module_container'>
                 <div class='content_module' id='error'	>
                  {$_SESSION['error']}   
</div>		
			</div>";
			return $module;
  	}else{
  		session_name("fgs");
		session_start();
		$module = "<div class='module_container' id='error_module_container'>
                 <div class='content_module' id='error'	>
                  {$_SESSION['error']}   
</div>		
			</div>";
			return $module;
  	}
  }
  public function setPageCookies(){
	
  }
 
  public function setPageHeader($page_name, $user){
	$scripts      = null;
	$profile_link = null;
	$title_tag    = null;
	$login_form   = null; 	
	if($user->type == "manager"){
		$login_form = false;
		$profile_link = true;
		switch($page_name){
			case "index.php" : $scripts = array("js" => array("<script src='/js/index.js' type='text/javascript'></script>"),"css" => array("<link type='text/css' rel='stylesheet' href='/css/index.css' >")); $title_tag = "Welcome to Gaming for Glory";
	                break;
			case "usersearch.php" : $scripts = array("js" => array("<script src='/js/usersearch.js' type='text/javascript'></script>"),"css" => array("<link type='text/css' rel='stylesheet' href='/css/usersearch.css'>")); $title_tag = "Search for Gamers";
	             	break;
	             	case "gamesearch.php" : $scripts = array("js" => array("<script src='/js/gamesearch.js' type='text/javascript'></script>"),"css" => array("<link type='text/css' rel='stylesheet' href='/css/gamesearch.css'>")); $title_tag = "Search for Games";
	             	break;
	             	case "league.php" : $scripts = array("js" => array("<script src='/js/league.js' type='text/javascript'></script>" , "<script type='text/javascript' src='/js/jquery.mousewheel-3.0.6.pack.js'></script>" , "<script type='text/javascript' src='/js/jquery.fancybox.pack.js?v=2.1.5'></script>", "<script type='text/javascript'> $(document).ready(function() { $('.fancybox').fancybox(); }); </script>"),"css" => array("<link type='text/css' rel='stylesheet' href='/css/league.css'>", "<link rel='stylesheet' href='/css/jquery.fancybox.css?v=2.1.5' type='text/css' media='screen' />")); $title_tag = "Gamer Leagues";
	             	break;
	             	case "gamer.php" : $scripts = array("js" => array("<script src='/js/gamer.js' type='text/javascript'></script>"),"css" => array("<link type='text/css' rel='stylesheet' href='/css/gamer.css'>")); $title_tag = "Gamer Profile";
	             	break;
					case "projections.php" : $scripts = array("js" => array("<script src='/js/projections.js' type='text/javascript'></script>"),"css" => array("<link type='text/css' rel='stylesheet' href='/css/projections.css'>")); $title_tag = "Projections";
	             	break;
					case "news.php" : $scripts = array("js" => array("<script src='/js/news.js' type='text/javascript'></script>"),"css" => array("<link type='text/css' rel='stylesheet' href='/css/news.css'>")); $title_tag = "Gamer News";
	             	break;
	             	case "draft.php" : $scripts = array("js" => array("<script src='/js/draft.js' type='text/javascript'></script>"),"css" => array("<link type='text/css' rel='stylesheet' href='/css/draft.css'>")); $title_tag = "Draft Room";
	             	break;
	        } 


	}else if($user->type == "gamer"){
		$login_form = false;
			      $page = basename($_SERVER["PHP_SELF"]);
			      $profile_link = true;
			      switch($page){
				  case "index.php" : $scripts = array("js" => array("<script src='/js/index.js' type='text/javascript'></script>"),"css" => array("<link type='text/css' rel='stylesheet' href='/css/index.css' >"));$title_tag = "Welcome to Gaming for Glory";
			          break;
			          case "usersearch.php" : $scripts = array("js" => array("<script src='/js/usersearch.js' type='text/javascript'></script>"),"css" => array("<link type='text/css' rel='stylesheet' href='/css/usersearch.css'>")); $title_tag = "Search for Gamers";
			          break;
			          case "gamesearch.php" : $scripts = array("js" => array("<script src='/js/gamesearch.js' type='text/javascript'></script>"),"css" => array("<link type='text/css' rel='stylesheet' href='/css/gamesearch.css'>")); $title_tag = "Search for Games";
			          break;
			          case "league.php" : $scripts = array("js" => array("<script src='/js/league.js' type='text/javascript'></script>" , "<script type='text/javascript' src='/js/jquery.mousewheel-3.0.6.pack.js'></script>" , "<script type='text/javascript' src='/js/jquery.fancybox.pack.js?v=2.1.5'></script>","<script type='text/javascript'> $(document).ready(function() { $('.fancybox').fancybox(); }); </script>"),"css" => array("<link type='text/css' rel='stylesheet' href='/css/league.css'>", "<link rel='stylesheet' href='/css/jquery.fancybox.css?v=2.1.5' type='text/css' media='screen' />"));  $title_tag = "Gamer Leagues";
			          break;
			          case "gamer.php" : $scripts = array("js" => array("<script src='/js/gamer.js' type='text/javascript'></script>"),"css" => array("<link type='text/css' rel='stylesheet' href='/css/gamer.css'>")); $title_tag = "Gamer Profile";
			          break;
					  case "projections.php" : $scripts = array("js" => array("<script src='/js/projections.js' type='text/javascript'></script>"),"css" => array("<link type='text/css' rel='stylesheet' href='/css/projections.css'>")); $title_tag = "Projections";
	             	break;
					case "news.php" : $scripts = array("js" => array("<script src='/js/news.js' type='text/javascript'></script>"),"css" => array("<link type='text/css' rel='stylesheet' href='/css/news.css'>")); $title_tag = "Gamer News";
	             	break;
	             	case "draft.php" : $scripts = array("js" => array("<script src='/js/draft.js' type='text/javascript'></script>"),"css" => array("<link type='text/css' rel='stylesheet' href='/css/draft.css'>")); $title_tag = "Draft Room";
	             	break;
			      } 

	}else{
		$login_form = true;
	    $page = basename($_SERVER["PHP_SELF"]);
	    $profile_link = false;
	     switch($page){
	         
		         case "index.php" : $scripts = array("js" => array("<script src='/js/index.js' type='text/javascript'></script>" ,"<script src='/js/fb.js' type='text/javascript'></script>"),"css" => array("<link type='text/css' rel='stylesheet' href='/css/index.css'>"));
		                         
		                             $title_tag = "Welcome to Gaming for Glory";
	                              break;
	          case "signup.php" : $scripts = array("js" => array("<script src='/js/signup.js' type='text/javascript'></script>"),"css" => array("<link type='text/css' rel='stylesheet' href='/css/signup.css'>")); 
	          $title_tag = "Sign Up for Gaming Glory!";
	          break;
	          case "usersearch.php" : $scripts = array("js" => array("<script src='/js/usersearch.js' type='text/javascript'></script>"),"css" => array("<link type='text/css' rel='stylesheet' href='/css/usersearch.css'>")); $title_tag = "Search for Gamers";
	          break;
	        
	          case "league.php" : $scripts = array("js" => array("<script src='/js/league.js' type='text/javascript'></script>" , "<script type='text/javascript' src='/js/jquery.mousewheel-3.0.6.pack.js'></script>" , "<script type='text/javascript' src='/js/jquery.fancybox.pack.js?v=2.1.5'></script>","<script type='text/javascript'> $(document).ready(function() { $('.fancybox').fancybox(); }); </script>"),"css" => array("<link type='text/css' rel='stylesheet' href='/css/league.css'>", "<link rel='stylesheet' href='/css/jquery.fancybox.css?v=2.1.5' type='text/css' media='screen' />")); $title_tag = "Gamer leagues";
	          break;
	          case "login.php" : $scripts = array("js" => array("<script src='/js/login.js' type='text/javascript'></script>"),"css" => array("<link type='text/css' rel='stylesheet' href='/css/login.css'>")); $title_tag = "Login";
	          break;
	          case "gamesearch.php" : $scripts = array("js" => array("<script src='/js/gamesearch.js' type='text/javascript'></script>"),"css" => array("<link type='text/css' rel='stylesheet' href='/css/gamesearch.css'>")); $title_tag = "Search for Games";
	          break;
			  case "gamer.php" : $scripts = array("js" => array("<script src='/js/gamer.js' type='text/javascript'></script>"),"css" => array("<link type='text/css' rel='stylesheet' href='/css/gamer.css'>")); $title_tag = "Gamer Profile";
			          break;
			  case "projections.php" : $scripts = array("js" => array("<script src='/js/projections.js' type='text/javascript'></script>"),"css" => array("<link type='text/css' rel='stylesheet' href='/css/projections.css'>")); $title_tag = "Projections";
	             	break;
					case "news.php" : $scripts = array("js" => array("<script src='/js/news.js' type='text/javascript'></script>"),"css" => array("<link type='text/css' rel='stylesheet' href='/css/news.css'>")); $title_tag = "Gamer News";
	             	break;
				case "draft.php" : $scripts = array("js" => array("<script src='/js/draft.js' type='text/javascript'></script>"),"css" => array("<link type='text/css' rel='stylesheet' href='/css/draft.css'>")); $title_tag = "Draft Room";
	             	break;
	  
	}
	 }
	  $this->header = "<!DOCTYPE html>
<html>
<head>
    <title> {$title_tag} </title>
    <meta charset='utf-8'>
	<script src='/js/jquery-2.1.3.js' type='text/javascript'></script>
	<script src='/js/ajax.js' type='text/javascript'></script>
	<script src='/js/main.js' type='text/javascript'></script>";
 
	    if(isset($scripts)){
	        foreach($scripts["js"] as $value)
	             $this->header .= $value;   
	}

 $this->header .= "<link type='text/css' rel='stylesheet' href='/css/main.css'/>";
   	 
	    if(isset($scripts)){
	        foreach($scripts["css"] as $value)
	             $this->header .=$value;   
	}

$this->header .="</head>
<body>
<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '594936653992232',
      xfbml      : true,
      version    : 'v2.5'
    });
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = \"//connect.facebook.net/en_US/sdk.js\";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
</script>
	<section class='page_header' id='home_page_header'>

		<header class='header_of_page_header'>
					<div>
						<nav class='module' id='page_header_console_nav_module'>
							<ul id='page_header_console_list'>
								<li>
									<a href='/php/gamesearch.php?search_for=sony' id='page_header_sony_consoles'>
										Sony
									</a>
									<ul id='page_header_sony_console_list'>
										<li>
											<a href='' id='page_header_ps4_console'>
												Playstation 4
											</a>
											<ul id='page_header_ps4_menu'>
												<li>
													<a href='' id='page_header_ps4_gamers'>
														Gamers
													</a>
												</li>
												<li>
													<a href='' id='page_header_ps4_leagues'>
														Leagues
													</a>
												</li>
												<li>
													<a href='' id='page_header_ps4_leaderboards'>
														LeaderBoards
													</a>
												</li>
											</ul>
										</li>
										
										<li>
											<a href='' id='page_header_ps3_console'>
												Playstation 3
											</a>
												<ul id='page_header_ps3_menu'>
													<li>
														<a href='' id='page_header_ps3_gamers'>
															Gamers
														</a>
													</li>
													<li>
														<a href='' id='page_header_ps3_leagues'>
															Leagues
														</a>
													</li>
													<li>
														<a href='' id='page_header_ps3_leaderboards'>
															LeaderBoards
														</a>
													</li>
												</ul>
											</li>
										</ul>
									</li>
								<li>
								<a href='/php/gamesearch.php?search_for=microsoft' id='page_header_microsoft_consoles'>
									Microsoft
								</a>
									<ul id='page_header_microsoft_console_list'>
										<li>
											<a href='' id='page_header_xboxone_console'>
												Xbox One
											</a>
											<ul id='page_header_xboxone_menu'>
												<li>
														<a href='' id='page_header_xboxone_gamers'>
															Gamers
														</a>
													</li>
													<li>
														<a href='' id='page_header_xboxone_leagues'>
															Leagues
														</a>
													</li>
													<li>
														<a href='' id='page_header_xboxone_leaderboards'>
															LeaderBoards
														</a>
													</li>
											</ul>
										</li>
										<li>
											<a href='' id='page_header_xbox360_console'>
												Xbox 360
											</a>
											<ul id='page_header_xbox360_menu'>
												<li>
														<a href='' id='page_header_xbox360_gamers'>
															Gamers
														</a>
													</li>
													<li>
														<a href='' id='page_header_xbox360_leagues'>
															Leagues
														</a>
													</li>
													<li>
														<a href='' id='page_header_xbox360_leaderboards'>
															LeaderBoards
														</a>
													</li>
											</ul>
										</li>
										
									</ul>
								
								</li>
								
							</ul>
						</nav>
						<nav class='module' id='page_header_main_nav_module'>
							<ul id='page_header_main_nav_list'>
								<li>
									<a href='' id='page_header_observe'>
										Observe
									</a>
									<ul id='page_header_observe_menu'>
										<li>
											<a href='' id='page_header_observe_menu_gameglory'>
												GameGlory
											</a>
										</li>
										<li>
											<a href='' id='page_header_observe_menu_twitch'>
												Twitch
											</a>
										</li>
										<li>
											<a href='' id='page_header_observe_menu_youtube'>
												YouTube
											</a>
										</li>
										<li>
											<a href='' id='page_header_observe_menu_recent_videos'> 
												Recent Videos
											</a>
										</li>
									</ul>
								</li>
								
								<li>
									<a href='' id='page_header_glory'>
										Glory
									</a>
									<ul id='page_header_glory_menu'>
										<li>
											<a href='' id='page_header_glory_menu_leagues'>
												Leagues
											</a>
										</li>
										<li>
											<a href='' id='page_header_glory_menu_stats'>
												Stats
											</a>
										</li>
										<li>
											<a href='' id='page_header_glory_menu_ranks'>
												Ranks
											</a>
										</li>
										<li>
											<a href='' id='page_header_glory_menu_leaderboards'>
												LeaderBoards
											</a>
										</li>
									</ul>
								</li>
							
						";
			   
			      if($login_form == true){
				         $this->header .= "
				         				<li>
				         				<a href='#' id='page_header_login' onclick='Page.PageHeader.Header.Events.click(this)'>
				         					Log In
				         				</a>
				         				<form action='/php/login.php' method='post' class='login-form' id='home_page_login_form'>
							             	<fieldset>
								            	<input type='text' name='email' class='text_box' id='home_page_login_username_text_box' placeholder='Enter your email address'/>
							            		<input type='password' name='password' class='text_box' id='home_page_login_password_text_box' placeholder='Enter your password'/>
								 	          <input type='submit' class='submit_button' id='home_page_login_submit_button' value='login' /> 
								            </fieldset>	
							            </form>
							            </li>
							            ";
				     }else{
				     	$this->header .="
				     		<li>
				     			<a href='/php/logout.php'>
				     				Sign out
				     			</a>
				     		</li>
				     	";
					    } 
			   
				$this->header .= "
				</ul>	
				</nav>
				</div>
				
		</header>

		<footer class='page_header_footer'>
		<div id='header_of_page_header_bottom'>
					<nav class ='module' id='page_header_sub_nav'>
						<ul id=''>
							<li>
								<a href='/index.php'>
									<span>
										Home
									</span>
								</a>
							</li>
							<li>
								<a href='/php/usersearch.php#gamers' id='page_header_footer_gamers'>
									<span>
										Grinders
									</span>
								</a>
							</li>
							<li>
								<a href='/php/usersearch.php#managers' id='page_header_footer_managers'>
									<span>
										Officials
									</span>
								</a>
							</li>
							<li>
								<a href='/php/league.php'>
									<span>
										Leagues
									</span>
								</a>
							</li>
							<li>
								<a href='/php/news.php'>
									<span>
										News
									</span>
								</a>
							</li>
							<li>
								<a href=''>
									<span>
										More
									</span>
								</a>
								<ul>
									<li>
										<a href=''>
											Stategy
										</a>
									</li>
									<li>
										<a href=''>
											Apps
										</a>
									</li>
									<li>
										<a href=''>
											Rules
										</a>
									</li>
								</ul>
							</li>
							<li id='page_header_footer_search_form'>
								<form action='/php/usersearch.php' method='get'>
								<input type='search' name='search_for' class='search_box' id='home_page_search_box' placeholder='Enter a Gamer's username , Xbox Live Tag, or PSN Tag'/>
								<input type='submit' class='' id='page_header_footer_search_button' value=''/>
							</form>
							</li>
						</ul>
					</nav>
				</div>
			</footer>
		</section>";
 }

 public function setPageFooter(){
 	$this->footer = "<section class='page_footer'>
    
    <nav class='navigation' id='footer_navigation'>
        
        <ul>
        	<li>
				<a href='php/help.php'>
					Help
				</a>
			</li>
			<li>
				<a href=''>
					Advertise
				</a>
			</li>
			<li>
				<a href=''>
					Report a Bug
				</a>
			</li>
            <li>
                <a href='/html/aboutus.html' class='footer_link' id='aboutus_footer_link'>
                    About Us
                </a>
            </li>
            <li>
				<a href='/html/contact.html' class='footer_link' id='contact_footer_link'>
					Contact
				</a>
			</li>
			<li>
				<a href =''>
					Site Map
				</a>
			</li>
			<li>
				<a href=''>
					Jobs
				</a>
			</li>
			<li>
				<a href='#' class='footer_link' id='contact_footer_link'>
					Social Media
				</a>
			</li>
			</br>
			<li>
				&copy 2016 Game Glory LLC
				<a href=''>
					Terms of Use
				</a>
				and 
				<a href=''>
					Privacy Policy.
				</a>
				 All Right Reserved.
			</li> 
        </ul>
    </nav>

</section>
</body>
</html>";
 }


}

?>