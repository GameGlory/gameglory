<?php
	require_once("class.fantasygamingdatabase.php");
	require_once("class.manager.php");
	require_once("class.league.php");
	
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		session_name("fgs");
		session_start();
		if(!isset($_SESSION["user"])){
			header("Location:../index.php");
			exit;	
		}
		$mysql_connection = null;
		$user = null;
		$creator = null;
		$league_name = null;
		$standard_type = null;
		$glory_type = null;
		$league_type = null;
		$standard_custom_type = null;
		$standard_normal_type = null;
		$online_draft_type = null;
		$auto_draft_type = null;
		$raffle_draft_type = null;
		$league_draft_type = null;
		$games = null;
		$public_access = null;
		$private_access = null;
		$league_access = null;
		$locked = null;
		$number_of_teams = null;
		$xbox360 = null;
		$xboxone = null;
		$ps3 = null;
		$ps4 = null;
		$consoles = null;
		$league_factors = null;
		$league_draft_start_date = null;
		$league_draft_end_date = null;
		$league=null;
		
		
		try{
			
			$user = unserialize($_SESSION["user"]);
			if($user->type != "manager"){
				header("Location:../index.php");
				exit;
			}
			$creator = $user->username;
			$league_name = htmlentities($_POST["league_name"]);
			$mysql_connection = new FantasyGamingDataBase();
			$param = array($league_name);
			//print_r($mysql_connection->selectQuery("select name from leagues where name = ?",$param));
			//exit;
			if($mysql_connection->selectQuery("select name from leagues where name = ?",$param))
				throw new Exception("bad league name");
			
			$standard_type = htmlentities($_POST["standard_type"]);
			$glory_type = htmlentities($_POST["glory_type"]);
			if($standard_type != "on"){
				if(empty($standard_type) || !isset($standard_type)){
					if($glory_type != "on"){
						if(empty($glory_type) || !isset($glory_type)){
							throw new Exception("ERROR");
						}
					}else{
						$league_type = "glory";
					}
				}else{
					throw new Exception("ERROR");
				}
			}else{
				if($glory_type != "on"){
					$league_type = "standard";	
				}else{
					throw new Exception("ERROR");
				}
			}
			$online_draft_type = htmlentities($_POST['online_draft']);
			$auto_draft_type = htmlentities($_POST['auto_draft']);
			$raffle_draft_type = htmlentities($_POST['raffle_draft']);
			if($online_draft_type != "on"){
				if(empty($online_draft_type) || !isset($online_draft_type)){
					if($auto_draft_type != "on"){
						if(empty($auto_draft_type) || !isset($auto_draft_type)){
							if($raffle_draft_type != "on"){
								throw new Exception("ERROR");
							}else{
								$league_draft_type = "raffle";
							}
						}
					}else{
						if($raffle_draft_type == "on")
							throw new Exception("ERROR");
						$league_draft_type = "auto";
					}
				}else{
					throw new Exception("ERROR");
				}
			}else{
				if($auto_draft_type == "on" || $raffle_draft_type == "on")
					throw new Exception("ERROR");
				$league_draft_type = "online";
			}
			$games = array();
			for($i = 0; $i < count($_POST["league_games"]); $i++){
				array_push($games , htmlentities($_POST["league_games"][$i]));
			}
			;
			$private_access = htmlentities($_POST["private_access"]);
			$public_access = htmlentities($_POST["public_access"]);
			if($private_access != "on"){
				if(empty($private_access) || !isset($private_access)){
					if($public_access != "on"){
						throw new Exception("ERROR");
					}else{
						$league_access = "public";
					}
				}else{
					throw new Exception("ERROR");
				}
			}else{
				if($public_access == "on")
					throw new Exception("ERROR");
				$league_access = "private";
			}
			$league_draft_start_date = $_POST["draft_start_date"];
			$league_draft_end_date = $_POST["draft_end_date"];
			$locked = htmlentities($_POST["locked"]);
			if($locked != "on"){
				if(empty($locked) || !isset($locked))
					$locked = 0;
				else
					throw new Exception("ERROR");
			}else{
				if($locked == "on")
					$locked = 1;
				else
					throw new Exception("ERROR");
			}
			$number_of_teams = htmlentities($_POST["number_of_teams"]);
			if($number_of_teams < 2){
				header("Location:" . $_SESSION["previous_page"]);//need to display error when going back!!
				exit;
			}
			$xbox360 = htmlentities($_POST["xbox360_console"]);
			$xboxone = htmlentities($_POST["xboxone_console"]);
			$ps3 = htmlentities($_POST["ps3_console"]);
			$ps4 = htmlentities($_POST["ps4_console"]);
			$consoles = array();
			if($xbox360 == "on")
				array_push($consoles,"xbox360");
			if($xboxone == "on")
				array_push($consoles,"xboxone");
			if($ps3 == "on")
				array_push($consoles,"ps3");
			if($ps4== "on")
				array_push($consoles,"ps4");	
					
			if($league_type == "glory")
				$league = new League($league_name,$creator,$league_type,$league_draft_type,$games,$league_access,$number_of_teams,$consoles);
			else if($league_type == "standard"){
				$standard_normal_type = htmlentities($_POST["standard_league_standard_check_box"]);
				$standard_custom_type = htmlentities($_POST["standard_league_custom_check_box"]);
				
				if($standard_normal_type != "on"){
				if(empty($standard_normal_type) || !isset($standard_normal_type)){
					if($standard_custom_type != "on"){
						throw new Exception("ERROR");
					}else{
						$league_sub_type = "custom";
					}
				}else{
					throw new Exception("ERROR");
				}
			}else{
				if($standard_custom_type == "on")
					throw new Exception("ERROR");
				$league_sub_type= "normal";
			}
				if($league_sub_type == "custom"){
					
					$league_factors = array();
					if($_POST["ingame_stats"] == "on")
						array_push($league_factors,"In-Game Stats");
					if($_POST["game_achievements"] == "on")
						array_push($league_factors,"Game Achievements");
					if($_POST["gamer_points"] == "on")
						array_push($league_factors,"Gamer Points");
					if($_POST["time_played"] == "on")
						array_push($league_factors,"Time Played");
					if($_POST["time_played"] == "on")
						array_push($league_factors,"time_played");
					if($_POST["game_completion"] == "on")
						array_push($league_factors,"Game Completion");
					if(count($league_factors) > 0)
						$league = new League($league_name,$creator,$league_type,$league_draft_type,$games,$league_access,$number_of_teams,$consoles,$league_sub_type,$league_factors);
					else{
						echo "yeah";
					exit;
						$league_sub_type = "normal";
						$league = new League($league_name,$creator,$league_type,$league_draft_type,$games,$league_access,$number_of_teams,$consoles,$league_sub_type);
				
					}
				}else
					$league = new League($league_name,$creator,$league_type,$league_draft_type,$games,$league_access,$number_of_teams,$consoles,$league_sub_type);
				
			}
			
			$params = array($creator,$league_name,$locked,0,$league_draft_start_date,$league_draft_end_date , serialize($league));
			
			$mysql_connection-> insertQuery("insert into leagues (creator , name , locked,active,draft_date_start,draft_date_end,league) values (?,?,?,?,?,?,?)",$params);
		
			$mysql_connection->close();
			$league_draft_start_date = getdate(strtotime($league_draft_start_date));
			$today = getdate(time());
			if($league_draft_start_date["year"] > $today["year"])
				header("Location:league.php");
			else if($league_draft_start_date["mon"] > $today["mon"])
				header("Location:league.php");
			else if($league_draft_start_date["mday"] > $today["mday"])
				header("Location:league.php");
			else
				header("Location:draft.php?draft_session_name={$league_name}");
		}catch(Exception $ex){
			print_r($ex);
		}
	}else{
		header("Location:404.php");
	}
?>