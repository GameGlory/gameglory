<?php
require_once("php/class.fantasygamingdatabase.php");
require_once("php/class.page.php");
require_once("php/class.user.php");
require_once("php/class.gamer.php");
require_once("php/class.manager.php");
require_once("php/class.error.php");
require_once("php/class.destinyapi.php");
require_once("php/functions.php");
require_once("Gumer/PSN/Http/Connection.php");

class HomePage extends Page{
		
	public function __construct($user){
		
		$this->homePageModules();
		parent::__construct($user);
		$this->printPage();
		
	}
	
	public function homePageModules(){

    $mysql_connection = null;
	$result           = null;
	try{
		$mysql_connection = new FantasyGamingDataBase();
		$result = $mysql_connection->selectQuery("select * from gamers order by rank desc limit 0,10")->fetch_all(MYSQL_BOTH);
		
		$this->body = "
		<section class='page_body'>
		<div class='page_body_header'>";
		if($this->checkForErrors()){
			
			$this->body .= $this->getErrorModule();
			$_SESSION["error"] = null;
		}
		$this->body .= "</div>
		<div class='page_body_body'>
		<div class='module_container' id='top_ten_module_container'>
                  <div class='module' id='top_ten_module'>
                  	<header class='module_header' id='top_ten_module_header'>
                  		<span>
                  			Top Ten Gamers
                  		</span>
                  	</header>
                  	<div class='module_body' id='top_ten_module_body'>
                  		<table>
                  			<tbody>
                  			<tr class='table_header' id='top_ten_module_table_header'>
                  			<th>
                  			</th>
	                  			<th>
	                  				Username
	                  			</th>
	                  			<th>
	                  				Xbox Tag
	                  			</th>
	                  			<th>
	                  				PSN Tag
	                  			</th>
	                  			<th>
	                  				Ranking
	                  			</th>
                  			</tr>
                  		";
                  		if(!isset($result) || $result == false){
                  			$this->body .= "No Users";
                  			}else{
                  			
                  			
                  			
	                  		foreach ($result as $key ) {
								 		$profile = unserialize($key["profile"]);
						 	
								
								 if(!empty($profile['xbox']['gamercard']['gamerpicSmallImagePath']) && !empty($profile['ps']["avatar"])){
								 $this->body .="<tr class='table_data_row' id='top_ten_module_table_data'>
								 	<td class='table_data'>
								 		
								 		<img src='{$profile['xbox']['gamercard']['gamerpicSmallImagePath']}' id='small_xbox_pic'/>
								 	<img src='{$profile['ps']['avatar']}' id='small_ps_pic'/> 
								 		
								 	  
								 	</td>";
								 }else if(!empty($profile['xbox']['gamercard']['gamerpicSmallImagePath'])){
								 	 $this->body .="<tr class='table_data_row' id='top_ten_module_table_data'>
								 	<td class='table_data'>
								 	<img src='{$profile['xbox']['gamercard']['gamerpicSmallImagePath']}' id='small_xbox_pic'/>
								 		
								 	  
								 	</td>";
								 }else{
								 	 $this->body .="<tr class='table_data_row' id='top_ten_module_table_data'>
								 	<td class='table_data'>
								 	<img src='{$profile['ps']['avatar']}' id='small_ps_pic'/>
					
								 	 
								 	</td>";
								
								 }
									
								 	$this->body .="
								 	<td class='table_data'>
								 	<a href='php/gamer.php?id={$key['id']} '>
								 		{$key['username']}
								 		</a>
								 		</td>
									<td class='table_data'>
									{$key['xbox_id']}
									</td>
										<td>
								 	{$key['psn_id']}
									</td>
									<td class='table_data'>
									{$key['rank']}
									</td>
								 </tr>
								 ";
							  }
						  }
                  	
                  	$this->body .="
                  	</tbody>
                  	</table>
                  	</div>
                  	<footer class='module_footer' id='top_ten_module_footer'>
                  	</footer>
                  </div>
             </div>
             
             <div class='module_container' id='homepage_signup_module_container'>
                  <div class='module' id='homepage_signup_module'>
                                      		<header class='module_header' id='homepage_signup_module_header'>
			                                         	<div>
			                                               <span>
			                                                   Game With Purpose
			                                               </span>
			                                             </div>
			                                             <div>
			                                               <span>
			 	                                                  Game Glory
			                                               </span>
			                                          </div>
		                                     </header>
		                                     <div class='module_body' id='homepage_signup_module_body'>
			                                        <span id='homepage_signup_module_button'>
				                                           <a href='#'>
				                                               Join Now
				                                           </a>
			                                        </span>
		                                    </div>
		                                    <footer class='module_footer' id='homepage_signup_module_footer'>
			                        
		                                    </footer>
                  </div>
             </div>
             
             <div class='module_container' id='gamer_news_module_container'>
                  <div class='module' id='gamer_news_module'>
                  	<header class='module_header' id='gamer_news_module_header'>
                  	
                  			<span>
                  				Gamer News
                  			</span>
                  			<span>
                  				Check Out Whats New
                  			</span>
                  	
                  	</header>
                  	<div class='module_body' id='gamer_news_module_body'>
                  	 
                  	</div>
                  	<footer class='module_footer' id='gamer_news_module_footer'>
                  	</footer>
                  </div>
             </div>
                
             <div class='module_container' id='promo_video_module_container'>
                  <div class='module' id='promo_video_module'>
                        <video>
                        </video>              
                  </div>
             </div>
             </div>
             <div class='page_body_footer'>
             </div>
       ";
 
	   $mysql_connection->close();
	   }catch(Exception $ex){
	   		print_r($ex);
	   }
	}
// end of class
}

try{
	
	setUser();	
	$page = new HomePage($user);
		// Setup the connections and instances.

$connection = new Connection;

$provider   = new Gumer\PSN\Authentication\UserProvider($connection);
$auth       = Gumer\PSN\Authentication\Manager::instance($provider);

// Attempt to login.
$auth->attempt('blonko100', 'Rakande101!');


// Get the current user profile.
$request    = new Gumer\PSN\Requests\GetMyInfoRequest;
$response   = $connection->call($request);
$info       = json_decode($response->getBody(true), true);

// Get the friends list for the current 
$request    = new Gumer\PSN\Requests\TrophyDataRequest;
$request->setUserId($info['onlineId']);
$response   = $connection->call($request);
	
print_r($response);

}catch(Exception $ex){
	print_r($ex);
}
?>