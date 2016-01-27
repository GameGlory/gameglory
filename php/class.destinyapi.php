<?php
	require_once("class.gamer.php");
	require_once("class.basegameapi.php");
	require_once("class.destinyapiexception.php");
	require_once("class.fantasygamingdatabase.php");
	class DestinyApi extends BaseGameApi{
		
		private $post_game_carnage_report_url         = "/Stats/PostGameCarnageReport/{activityId}/";
		private $membership_id_url                    = "/{membershipType}/Stats/GetMembershipIdByDisplayName/{displayName}/?ignorecase=true";
		private $all_character_stats_url              = "/Stats/Account/{membershipType}/{destinyMembershipId}/";
		private $one_character_stats_url              = "/Stats/{membershipType}/{destinyMembershipId}/{characterId}/";
		private $grimoire_stats_url                   = "/Vanguard/Grimoire/{membershipType}/{membershipId}/";
		private $one_character_stats_and_activies_url = "/Stats/AggregateActivityStats/{membershipType}/{destinyMembershipId}/{characterId}/";
		private $one_character_summary_url            = "/{membershipType}/Account/{destinyMembershipId}/Character/{characterId}/";
		private $one_character_progression_report_url = "/{membershipType}/Account/{destinyMembershipId}/Character/{characterId}/Progression/";
		private $one_character_inventory_summary_url  = "/{membershipType}/Account/{destinyMembershipId}/Character/{characterId}/Inventory/Summary/";
		private $one_character_current_inventory_url  = "/{membershipType}/Account/{destinyMembershipId}/Character/{characterId}/Activities/";
		private $all_character_items_url              = "/{membershipType}/Account/{destinyMembershipId}/Items/";
		private $one_character_activity_history_url   = "/Stats/ActivityHistory/{membershipType}/{destinyMembershipId}/{characterId}/";
		private $get_destiny_account_url              = "/{membershipType}/Account/{destinyMembershipId}/Summary/";                        
		
		private $stats                                = array("Activity Stats" => array("General Stats" => array("Activities Cleared" , "Weapon Kills Super" , "Activities Entered" , "Weapon Kills Melee" , "Weapon Kills Grenade" , "Ability Kills" , "Assists" , "Total Death Distance" , "Average Death Distance" , "Total Kill Distance" , "Kills" , "Average Kill Distance" , "Seconds Played" , "Deaths" , "Average Life Span" , "Best Single Game Kills" , "Kills Deaths Ratio" , "Kills Deaths Assists" , "Objectives Completed" , "Precision Kills" , "Resurrections Performed" , "Resurrections Received", "Suicides" , "Weapon Kills Auto Rifle" , "Weapon Kills Fusion Rifle" , "Weapon Kills Hand Cannon" , "Weapon Kills Machinegun" , "Weapon Kills Pulse Rifle" , "Weapon Kills Rocket Launcher", "Weapon Kills Scout Rifle" , "Weapon Kills Shotgun", "Weapon Kills Sniper","Weapon Kills Submachinegun" , "Weapon Kills Relic", "Weapon Kills Side Arm" ,"Weapon Kills Sword", "Weapon Best Type", "All Participants Count" , "All Participants Time Played" , "Longest Kill Spree" , "Longest Single Life", "Most Precision Kills" , "Orbs Dropped" , "Orbs Gathered" , "Public Events Completed" , "Public Events Joined" , "Remaining Time After Quit Seconds" , "Total Activity Duration Seconds" , "Fastest Completion" , "Court Of Oryx Wins Tier1" , "Court Of Oryx Wins Tier2" , "Court Of Oryx Wins Tier3" , "Court Of Oryx Attempts" , "CourtOf Oryx Completions" , "Longest Kill Distance" , "Highest Character Level" , "Highest Light Level") ,"Weapon Stats" => array("Weapon Precision Kills Auto Rifle" , "Weapon Precision Kills Fusion Rifle" , "Weapon Precision Kills Grenade" , "Weapon Precision Kills Hand Cannon" , "Weapon Precision Kills Machinegun" , "Weapon Precision Kills Melee" , "Weapon Precision Kills Pulse Rifle" , "Weapon Precision Kills Rocket Launcher" , "Weapon Precision Kills Scout Rifle", "Weapon Precision Kills Shotgun" , "Weapon Precision Kills Sniper" , "Weapon Precision Kills Submachinegun" , "Weapon Precision Kills Super" , "Weapon Precision Kills Relic" , "Weapon Precision Kills Side Arm" , "Weapon Kills Precision Kills Auto Rifle", "Weapon Kills Precision Kills Fusion Rifle" , "Weapon Kills Precision Kills Grenade" , "Weapon Kills Precision Kills Hand Cannon" , "Weapon Kills Precision Kills Machinegun" , "Weapon Kills Precision Kills Melee" , "Weapon Kills Precision Kills Pulse Rifle" , "Weapon Kills Precision Kills Rocket Launcher" , "Weapon Kills Precision Kills Scout Rifle" , "Weapon Kills Precision Kills Shotgun" , "Weapon Kills Precision Kills Sniper" , "Weapon Kills Precision Kills Submachinegun", "Weapon Kills Precision Kills Super" , "Weapon Kills Precision Kills Relic" , "Weapon Kills Precision Kills Side Arm") , "Enemy Stats" => array(" Precision Kill Of Cabal Centurion"," Precision Kill Of Cabal Centurion Elite"," Precision Kill Of Cabal Colossus"," Precision Kill Of Cabal Colossus Elite"," Precision Kill Of Cabal Goliath"," Precision Kill Of Cabal Legionary"," Precision Kill Of Cabal Phalanx"," Precision Kill Of Cabal Psion"," Precision Kill Of Cabal Psion Elite"," Precision Kill Of Fallen CaPtain"," Precision Kill Of Fallen CaPtain Elite"," Precision Kill Of Fallen CaPtain Elite Shock Blade"," Precision Kill Of Fallen Dreg"," Precision Kill Of Fallen Pike"," Precision Kill Of Fallen Servitor"," Precision Kill Of Fallen Servitor Elite"," Precision Kill Of Fallen Shank"," Precision Kill Of Fallen Vandal"," Precision Kill Of Fallen Vandal Elite"," Precision Kill Of Fallen Vandal Elite Shock Blade"," Precision Kill Of Fallen Vandal Stealth"," Precision Kill Of Hive Knight"," Precision Kill Of Hive Knight Elite"," Precision Kill Of Hive Shrieker"," Precision Kill Of Hive Ogre"," Precision Kill Of Hive Thrall"," Precision Kill Of Hive Thrall ExPloder"," Precision Kill Of Hive Acolyte"," Precision Kill Of Hive Wizard"," Precision Kill Of R1 S1 Event Cosmo Major3"," Precision Kill Of R1 S1 Event Cosmo Major4"," Precision Kill Of R1 S1 Event Cosmo Major5"," Precision Kill Of R1 S1 Event Mars Major0"," Precision Kill Of R1 S1 Event Mars Major2"," Precision Kill Of R1 S1 Event Mars Major3"," Precision Kill Of R1 S1 Event Moon Ultra0"," Precision Kill Of R1 S1 Event Venus Major0"," Precision Kill Of R1 S1 Event Venus Major1"," Precision Kill Of R1 S1 Event Venus Major2"," Precision Kill Of R1 S1 Event Venus Ultra0"," Precision Kill Of R1 S1 Event Venus Ultra1"," Precision Kill Of R1 S1 Raid Venus0 Major0"," Precision Kill Of R1 S1 Raid Venus0 Major1"," Precision Kill Of R1 S1 Raid Venus0 Major2"," Precision Kill Of R1 S1 Raid Venus0 Major3"," Precision Kill Of R1 S1 Raid Venus0 Major4"," Precision Kill Of R1 S1 Raid Venus0 Major5"," Precision Kill Of R1 S1 Raid Venus0 Major6"," Precision Kill Of R1 S1 Raid Venus0 Major7"," Precision Kill Of R1 S1 Raid Venus0 Major8"," Precision Kill Of R1 S1 Raid Venus0 Ultra0"," Precision Kill Of R1 S1 Raid Venus0 Ultra1"," Precision Kill Of R1 S1 Story Cosmo0 Ultra0"," Precision Kill Of R1 S1 Story Mars1 Major0"," Precision Kill Of R1 S1 Story Mars3 Major0"," Precision Kill Of R1 S1 Story Mars5 Ultra0"," Precision Kill Of R1 S1 Story Mars6 Major0"," Precision Kill Of R1 S1 Story Mars7 Major0"," Precision Kill Of R1 S1 Story Mars7 Ultra0"," Precision Kill Of R1 S1 Story Mars7 Ultra1"," Precision Kill Of R1 S1 Story Mars7 Ultra2"," Precision Kill Of R1 S1 Story Moon1 Minor0"," Precision Kill Of R1 S1 Story Moon3 Major0"," Precision Kill Of R1 S1 Story Moon4 Major0"," Precision Kill Of R1 S1 Story Moon4 Major1"," Precision Kill Of R1 S1 Story Moon5 Major0"," Precision Kill Of R1 S1 Story Moon5 Minor0"," Precision Kill Of R1 S1 Story Moon6 Major0"," Precision Kill Of R1 S1 Story Moon6 Ultra0"," Precision Kill Of R1 S1 Story Venus2 Major0"," Precision Kill Of R1 S1 Story Venus5 Major0"," Precision Kill Of R1 S1 Story Venus5 Major1"," Precision Kill Of R1 S1 Story Venus6 Major0"," Precision Kill Of R1 S1 Story Venus6 Ultra0"," Precision Kill Of R1 S1 Story Venus7 Ultra0"," Precision Kill Of R1 S1 Strike Cosmo1 Ultra0"," Precision Kill Of R1 S2 Strike Mars3 Ultra0"," Precision Kill Of R1 S1 Strike Mars1 Major0"," Precision Kill Of R1 S1 Strike Mars1 Major1"," Precision Kill Of R1 S1 Strike Mars1 Major10"," Precision Kill Of R1 S1 Strike Mars1 Major2"," Precision Kill Of R1 S1 Strike Mars1 Major3"," Precision Kill Of R1 S1 Strike Mars1 Major4"," Precision Kill Of R1 S1 Strike Mars1 Major5"," Precision Kill Of R1 S1 Strike Mars1 Major6"," Precision Kill Of R1 S1 Strike Mars1 Major7"," Precision Kill Of R1 S1 Strike Mars1 Major8"," Precision Kill Of R1 S1 Strike Mars1 Major9"," Precision Kill Of R1 S1 Strike Mars2 Major0"," Precision Kill Of R1 S1 Strike Mars2 Major1"," Precision Kill Of R1 S1 Strike Mars2 Major2"," Precision Kill Of R1 S1 Strike Mars2 Ultra0"," Precision Kill Of R1 S1 Strike Moon2 Major0"," Precision Kill Of R1 S1 Strike Moon2 Ultra0"," Precision Kill Of R1 S1 Strike Venus1 Ultra0"," Precision Kill Of R1 S1 Strike Venus2 Ultra0"," Precision Kill Of R1 S2 Raid Moon0 Major0"," Precision Kill Of R1 S2 Raid Moon0 Major1"," Precision Kill Of R1 S2 Raid Moon0 Major2"," Precision Kill Of R1 S2 Raid Moon0 Major3"," Precision Kill Of R1 S2 Raid Moon0 Ultra0"," Precision Kill Of R1 S2 Strike Cosmo1 Major0"," Precision Kill Of Vex Goblin"," Precision Kill Of Vex HarPy"," Precision Kill Of Vex Hobgoblin"," Precision Kill Of Vex Minotaur"," Precision Kill Of Vex Minotaur Elite"," Precision Kill Of Vex Hydra"," Precision Kill Of Vex Hydra Elite"," Precision Kill Of Cabal Major Centurion A"," Precision Kill Of Cabal Major Gladiator A"," Precision Kill Of Cabal Major Legionary A"," Precision Kill Of Cabal Major Phalanx A"," Precision Kill Of Cabal Major Psion A"," Precision Kill Of Cabal Ultra Centurion A"," Precision Kill Of Cabal Ultra Gladiator A"," Precision Kill Of Fallen Ultra Servitor A"," Precision Kill Of Fallen Ultra CaPtain A"," Precision Kill Of Fallen Major Shank A"," Precision Kill Of Fallen Major Servitor A"," Precision Kill Of Fallen Major CaPtain A"," Precision Kill Of Fallen Major CaPtain A Shock Blade"," Precision Kill Of Fallen Major Vandal A"," Precision Kill Of Fallen Major Vandal A Shock Blade"," Precision Kill Of Fallen Major Dreg A ShraPnel Launcher"," Precision Kill Of Fallen Major Dreg A"," Precision Kill Of Fallen Major Dreg A Shock Dagger"," Precision Kill Of R1 S1 Story Cosmo0 Minor0"," Precision Kill Of Fallen Major Stealth Vandal A Wire Rifle"," Precision Kill Of Fallen Major Stealth Vandal A"," Precision Kill Of Hive Ultra Ogre A"," Precision Kill Of Hive Ultra Knight A"," Precision Kill Of Hive Major Wizard A"," Precision Kill Of Hive Major Acolyte A"," Precision Kill Of Hive Major Thrall A"," Precision Kill Of Hive Major Ogre A"," Precision Kill Of Hive Major Knight A"," Precision Kill Of Hive Major Knight A Cleaver"," Precision Kill Of R1 S1 Story Moon1 Major0"," Precision Kill Of Ultra Hydra A"," Precision Kill Of Vex Ultra Minotaur A"," Precision Kill Of Major Hydra A"," Precision Kill Of R1 S1 Raid Venus0 HarPy Missile"," Precision Kill Of R1 S1 Raid Venus0 Bobgoblin Future"," Precision Kill Of Vex Major Minotaur A"," Precision Kill Of Vex Major Hobgoblin A"," Precision Kill Of Vex Major HarPy A"," Precision Kill Of Vex Major Goblin A"," Precision Kill Of R1 S1 Event Cosmo Major0"," Precision Kill Of R1 S1 Event Cosmo Major1"," Precision Kill Of R1 S1 Event Cosmo Major2"," Precision Kill Of R1 S1 Event Cosmo Major6"," Precision Kill Of R1 S1 Event Cosmo Major7"," Precision Kill Of R1 S1 Event Cosmo Major8"," Precision Kill Of R1 S1 Story Moon4 Major2"," Precision Kill Of R1 S1 Story Moon4 Major3"," Precision Kill Of Fallen Major Stealth Vandal A Shock Blade"," Precision Kill Of R1 S1 Story Cosmo1 Major1"," Precision Kill Of R1 S3 Story Cosmo7 Major2"," Precision Kill Of R1 S3 Story Cosmo7 Major1"," Precision Kill Of R1 S3 Story Cosmo7 Major0"," Precision Kill Of R1 S3 Arena Reef Ultra1"," Precision Kill Of R1 S3 Arena Reef Ultra8"," Precision Kill Of R1 S3 Strike Moon Ultra1"," Precision Kill Of R1 S3 Arena Reef Ultra4"," Precision Kill Of R1 S3 Arena Reef Ultra5"," Precision Kill Of R1 S3 Arena Reef Ultra6"," Precision Kill Of R1 S3 Arena Reef Ultra3"," Precision Kill Of R1 S3 Arena Reef Ultra9"," Precision Kill Of R1 S3 Arena Reef Ultra2"," Precision Kill Of R1 S3 Arena Reef Ultra11"," Precision Kill Of R1 S3 Arena Reef Ultra12"," Precision Kill Of R1 S2 Bounty Cosmo Major0"," Precision Kill Of R1 S2 Bounty Cosmo Major1"," Precision Kill Of R1 S2 Bounty Cosmo Ultra0"," Precision Kill Of R1 S2 Bounty Cosmo Major2"," Precision Kill Of R1 S2 Bounty Cosmo Major7"," Precision Kill Of R1 S2 Bounty Cosmo Major4"," Precision Kill Of R1 S2 Bounty Cosmo Major5"," Precision Kill Of R1 S2 Bounty Moon Ultra0"," Precision Kill Of Cabal IntercePtor"," Precision Kill Of Fallen Reaver"," Precision Kill Of Vex CycloPs"," Precision Kill Of R1 S1 Event Mars Major1"," Precision Kill Of R1 S1 Event Mars Minor0"," Precision Kill Of R1 S1 Event Mars Minor1"," Precision Kill Of R1 S1 Event Mars Minor2"," Precision Kill Of R1 S1 Story Mars2 Major0"," Precision Kill Of Taken Centurion"," Precision Kill Of Taken Gladiator"," Precision Kill Of Taken Legionary"," Precision Kill Of Taken Phalanx"," Precision Kill Of Taken Psion"," Precision Kill Of Elite Shank A"," Precision Kill Of R1 S1 Story Cosmo1 Major0"," Precision Kill Of R1 S1 Story Cosmo2 Major0"," Precision Kill Of R1 S1 Story Cosmo3 Ultra0"," Precision Kill Of R1 S2 Event Any Major1"," Precision Kill Of R1 S2 Event Cosmo Minor0"," Precision Kill Of R1 S2 Event Cosmo Minor1"," Precision Kill Of R1 S2 Event Cosmo Minor2"," Precision Kill Of R1 S2 Event Cosmo Minor3"," Precision Kill Of Taken CaPtain"," Precision Kill Of Taken Dreg"," Precision Kill Of Taken Servitor"," Precision Kill Of Taken Shank"," Precision Kill Of Taken Vandal"," Precision Kill Of Elite Ogre A"," Precision Kill Of Hive Elite Acolyte A"," Precision Kill Of R1 S1 Strike HiveshiP1 Ultra0"," Precision Kill Of R1 S2 Raid HiveshiP0 Major0"," Precision Kill Of R1 S2 Raid HiveshiP0 Major1"," Precision Kill Of R1 S2 Raid HiveshiP0 Major2"," Precision Kill Of R1 S2 Raid HiveshiP0 Major3"," Precision Kill Of R1 S2 Raid HiveshiP0 Major4"," Precision Kill Of R1 S2 Raid HiveshiP0 Major5"," Precision Kill Of R1 S2 Raid HiveshiP0 Major6"," Precision Kill Of R1 S2 Raid HiveshiP0 Ultra0"," Precision Kill Of R1 S2 Raid HiveshiP0 Ultra1"," Precision Kill Of R1 S2 Raid HiveshiP0 Ultra2"," Precision Kill Of Taken Knight"," Precision Kill Of Taken Ogre"," Precision Kill Of Taken Thrall"," Precision Kill Of Taken Thrall ExPloder"," Precision Kill Of Taken Acolyte"," Precision Kill Of Taken Wizard"," Precision Kill Of Elite HarPy A"," Precision Kill Of Taken HarPy"," Precision Kill Of Taken Minotaur"," Precision Kill Of Taken Hydra"," Precision Kill Of Taken Goblin"," Precision Kill Of Taken Hobgoblin"," Precision Kill Of Major Stealth Valdal A Shock Blade"," Precision Kill Of R1 S1 Bounty Moon2 Major0"," Precision Kill Of Fallen SPider Shank"," Precision Kill Of R1 S1 Story Venus6 Major1"," Precision Kill Of R1 S2 Bounty Cosmo Major3"," Precision Kill Of R1 S2 Bounty Cosmo Major6"," Precision Kill Of R1 S2 Bounty Cosmo Minor0"," Precision Kill Of R1 S2 Bounty Cosmo Minor1"," Precision Kill Of R1 S2 Bounty Cosmo Minor2"," Precision Kill Of R1 S2 Bounty Moon Minor0"," Precision Kill Of R1 S2 Bounty Moon Turret0"," Precision Kill Of R1 S2 Raid Moon0 Major4"," Precision Kill Of R1 S2 Raid Moon0 Major5"," Precision Kill Of R1 S2 Story Cosmo5 Major0"," Precision Kill Of R1 S2 Story Cosmo6 Ultra0"," Precision Kill Of R1 S2 Story Moon7 Major0"," Precision Kill Of R1 S2 Story Moon7 Major1"," Precision Kill Of R1 S2 Strike Cosmo Major0"," Precision Kill Of R1 S2 Strike Cosmo1 Major1"," Precision Kill Of R1 S2 Strike Cosmo2 Major0"," Precision Kill Of R1 S2 Strike Cosmo2 Major1"," Precision Kill Of R1 S2 Strike Cosmo2 Major2"," Precision Kill Of R1 S2 Strike Cosmo2 Major3"," Precision Kill Of R1 S2 Strike Mars3 Major0"," Precision Kill Of R1 S2 Strike Mars3 Minor0"," Precision Kill Of R1 S2 Strike Mars3 Minor1"," Precision Kill Of R1 S2 Bounty Moon Minor1"," Precision Kill Of R1 S2 Bounty Moon Minor2"," Precision Kill Of R1 S2 Raid Moon0 Lantern DisPlay Name"," Precision Kill Of R1 S3 Strike Moon Ultra0"," Precision Kill Of Ai Shank ExPloder"," Precision Kill Of Ai Shank Shock Turret"," Precision Kill Of Ai Shank Wire Rifle"," Precision Kill Of Ai Major Shank Shock Turret"," Precision Kill Of R1 S3 Arena Reef Major0"," Precision Kill Of R1 S3 Story Persuit Major0"," Precision Kill Of R1 S3 Story Persuit Major1"," Precision Kill Of R1 S3 Story Persuit Major2"," Precision Kill Of R1 S3 Story Pact Major0"," Precision Kill Of R1 S3 Story Pact Major1"," Precision Kill Of R1 S3 Story Traitor Major0"," Precision Kill Of R1 S3 Story Traitor Major1"," Precision Kill Of R1 S3 Story Nightcrawler Ultra0"," Precision Kill Of R1 S3 Strike Moon Major0"," Precision Kill Of Ai Major CaPtain SPear Launcher House Of Wolves"," Precision Kill Of R1 S3 Wanted Major0"," Precision Kill Of R1 S3 Wanted Major1"," Precision Kill Of R1 S3 Wanted Major2"," Precision Kill Of R1 S3 Wanted Major3"," Precision Kill Of R1 S3 Wanted Major4"," Precision Kill Of R1 S3 Wanted Major5"," Precision Kill Of R1 S3 Wanted Major6"," Precision Kill Of R1 S3 Wanted Major8"," Precision Kill Of R1 S3 Wanted Major10"," Precision Kill Of R1 S3 Wanted Major12"," Precision Kill Of R1 S3 Wanted Major13"," Precision Kill Of R1 S3 Wanted Event Major0"," Precision Kill Of R1 S3 Wanted Event Major1"," Precision Kill Of R1 S3 Wanted Event Major2"," Precision Kill Of R1 S3 Wanted Event Major3"," Precision Kill Of R1 S3 Wanted Event Major4"," Precision Kill Of R1 S3 Wanted Event Major5"," Precision Kill Of R1 S3 Wanted Event Major6"," Precision Kill Of R1 S3 Wanted Event Major7"," Precision Kill Of R1 S3 Wanted Event Major8"," Precision Kill Of R1 S3 Wanted Event Major9"," Precision Kill Of R1 S3 Wanted Event Major10"," Precision Kill Of R1 S3 Wanted Event Minor0"," Precision Kill Of R1 S3 Wanted Event Minor1"," Precision Kill Of R1 S3 Wanted Event Minor2"," Precision Kill Of R1 S3 Wanted Event Minor3"," Precision Kill Of R1 S3 Wanted Event Minor4"," Precision Kill Of R1 S3 Wanted Event Minor5"," Precision Kill Of R1 S3 Wanted Event Minor6"," Precision Kill Of R1 S3 Wanted Event Minor7"," Precision Kill Of R1 S4 Story Cosmo Elevator Ultra0"," Precision Kill Of R1 S4 Story HiveshiP ToPknot Ultra0"," Precision Kill Of R1 S4 Story Phobos Darksnow Major2"," Precision Kill Of R1 S4 Raid EPiPhany Dead King"," Precision Kill Of R1 S4 Strike Cosmo Reliquary Ultra0"," Precision Kill Of R1 S4 Strike Venus Tracker Ultra0"," Precision Kill Of R1 S4 Strike HiveshiP Pandora Ultra0"," Precision Kill Of R1 S4 Strike HiveshiP Overlord Ultra0"," Precision Kill Of R1 S4 Strike HiveshiP Overlord Ultra1"," Precision Kill Of R1 S4 Event Rob HiveshiP Major0"," Precision Kill Of R1 S4 Event Rob HiveshiP Major1"," Precision Kill Of R1 S4 Event Rob HiveshiP Major2"," Precision Kill Of R1 S4 Event Rob HiveshiP Major3"," Precision Kill Of R1 S4 Event Rob HiveshiP Major4"," Precision Kill Of R1 S4 Event Rob HiveshiP Major5"," Precision Kill Of R1 S4 Event Rob HiveshiP Major6"," Precision Kill Of R1 S4 Event Rob HiveshiP Major7"," Precision Kill Of R1 S4 Event Rob HiveshiP Major8"," Precision Kill Of R1 S4 Event Rob HiveshiP Major9"," Precision Kill Of R1 S4 Event Rob HiveshiP Major10"," Precision Kill Of R1 S4 Event Rob HiveshiP Major11"," Precision Kill Of R1 S4 Event Rob HiveshiP Major12"," Precision Kill Of Taken Blight Disturbance"," Precision Kill Of Taken Turret"," Precision Kill Of Hive Cutter"," Precision Kill Of Cabal DroPshiP"," Precision Kill Of Fallen Skiff"," Precision Kill Of R1 S4 Raid EPiPhany Ultra Knight"," Precision Kill Of R1 S4 Raid EPiPhany Ultra Ogre"," Precision Kill Of R1 S4 Raid EPiPhany Twin Wizard"," Precision Kill Of R1 S4 Raid EPiPhany Twin Wizard A"," Deaths From Cabal Interceptor"," Deaths From Fallen Reaver"," Deaths From Vex Cyclops"," Deaths From R1 S1 Event Mars Major1"," Deaths From R1 S1 Event Mars Minor0"," Deaths From R1 S1 Event Mars Minor1"," Deaths From R1 S1 Event Mars Minor2"," Deaths From R1 S1 Story Mars2 Major0"," Deaths From Taken Centurion"," Deaths From Taken GlaDiator"," Deaths From Taken Legionary"," Deaths From Taken Phalanx"," Deaths From Taken Psion"," Deaths From Elite Shank A"," Deaths From R1 S1 Story Cosmo1 Major0"," Deaths From R1 S1 Story Cosmo2 Major0"," Deaths From R1 S1 Story Cosmo3 Ultra0"," Deaths From R1 S2 Event Any Major1"," Deaths From R1 S2 Event Cosmo Minor0"," Deaths From R1 S2 Event Cosmo Minor1"," Deaths From R1 S2 Event Cosmo Minor2"," Deaths From R1 S2 Event Cosmo Minor3"," Deaths From Taken Captain"," Deaths From Taken Dreg"," Deaths From Taken Servitor"," Deaths From Taken Shank"," Deaths From Taken VanDal"," Deaths From Elite Ogre A"," Deaths From Hive Elite Acolyte A"," Deaths From R1 S1 Strike Hiveship1 Ultra0"," Deaths From R1 S2 RaiD Hiveship0 Major0"," Deaths From R1 S2 RaiD Hiveship0 Major1"," Deaths From R1 S2 RaiD Hiveship0 Major2"," Deaths From R1 S2 RaiD Hiveship0 Major3"," Deaths From R1 S2 RaiD Hiveship0 Major4"," Deaths From R1 S2 RaiD Hiveship0 Major5"," Deaths From R1 S2 RaiD Hiveship0 Major6"," Deaths From R1 S2 RaiD Hiveship0 Ultra0"," Deaths From R1 S2 RaiD Hiveship0 Ultra1"," Deaths From R1 S2 RaiD Hiveship0 Ultra2"," Kills Of TaKen Centurion"," Kills Of TaKen Gladiator"," Kills Of TaKen Legionary"," Kills Of TaKen Phalanx"," Kills Of TaKen Psion"," Kills Of TaKen Captain"," Kills Of TaKen Dreg"," Kills Of TaKen Servitor"," Kills Of TaKen ShanK"," Kills Of TaKen Vandal"," Kills Of TaKen Knight"," Kills Of TaKen Ogre"," Kills Of TaKen Thrall"," Kills Of TaKen Thrall Exploder"," Kills Of TaKen Acolyte"," Kills Of TaKen Wizard"," Kills Of TaKen Harpy"," Kills Of TaKen Minotaur"," Kills Of TaKen Hydra"," Kills Of TaKen Goblin"," Kills Of TaKen Hobgoblin"," Kills Of TaKen Champions"," Kills Of TaKen Blight Disturbance"," Kills Of TaKen Turret"," Kills Of TaKen"," Deaths From Taken Knight"," Deaths From Taken Ogre"," Deaths From Taken Thrall"," Deaths From Taken Thrall ExploDer"," Deaths From Taken Acolyte"," Deaths From Taken WizarD"," Deaths From Taken Harpy"," Deaths From Taken Minotaur"," Deaths From Taken HyDra"," Deaths From Taken Goblin"," Deaths From Taken Hobgoblin"," Deaths From Taken Blight Disturbance"," Deaths From Taken Turret"," Deaths From Taken Champions"," Deaths From Taken"," Kills Deaths Ratio TaKen"," Kills Deaths Ratio TaKen Thrall"," Kills Deaths Ratio TaKen Acolyte"," Kills Deaths Ratio TaKen Knight"," Kills Deaths Ratio TaKen Wizard"," Kills Deaths Ratio TaKen Psion"," Kills Deaths Ratio TaKen Phalanx"," Kills Deaths Ratio TaKen Centurion"," Kills Deaths Ratio TaKen Vandal"," Kills Deaths Ratio TaKen Captain"," Kills Deaths Ratio TaKen Goblin"," Kills Deaths Ratio TaKen Hobgoblin"," Kills Deaths Ratio TaKen Minotaur"," Deaths From Elite Harpy A"," Deaths From Major Stealth ValDal A Shock BlaDe"," Deaths From R1 S1 Bounty Moon2 Major0"," Deaths From Fallen SpiDer Shank"," Deaths From R1 S1 Story Venus6 Major1"," Deaths From R1 S2 Bounty Cosmo Major3"," Deaths From R1 S2 Bounty Cosmo Major6"," Deaths From R1 S2 Bounty Cosmo Minor0"," Deaths From R1 S2 Bounty Cosmo Minor1"," Deaths From R1 S2 Bounty Cosmo Minor2"," Deaths From R1 S2 Bounty Moon Minor0"," Deaths From R1 S2 Bounty Moon Turret0"," Deaths From R1 S2 RaiD Moon0 Major4"," Deaths From R1 S2 RaiD Moon0 Major5"," Deaths From R1 S2 Story Cosmo5 Major0"," Deaths From R1 S2 Story Cosmo6 Ultra0"," Deaths From R1 S2 Story Moon7 Major0"," Deaths From R1 S2 Story Moon7 Major1"," Deaths From R1 S2 Strike Cosmo Major0"," Deaths From R1 S2 Strike Cosmo1 Major1"," Deaths From R1 S2 Strike Cosmo2 Major0"," Deaths From R1 S2 Strike Cosmo2 Major1"," Deaths From R1 S2 Strike Cosmo2 Major2"," Deaths From R1 S2 Strike Cosmo2 Major3"," Deaths From R1 S2 Strike Mars3 Major0"," Deaths From R1 S2 Strike Mars3 Minor0"," Deaths From R1 S2 Strike Mars3 Minor1"," Deaths From R1 S2 Bounty Moon Minor1"," Deaths From R1 S2 Bounty Moon Minor2"," Deaths From R1 S2 RaiD Moon0 Lantern Display Name"," Deaths From R1 S3 Strike Moon Ultra0"," Deaths From Ai Shank ExploDer"," Deaths From Ai Shank Shock Turret"," Deaths From Ai Shank Wire Rifle"," Deaths From Ai Major Shank Shock Turret"," Deaths From R1 S3 Arena Reef Major0"," Deaths From R1 S3 Story Persuit Major0"," Deaths From R1 S3 Story Persuit Major1"," Deaths From R1 S3 Story Persuit Major2"," Deaths From R1 S3 Story Pact Major0"," Deaths From R1 S3 Story Pact Major1"," Deaths From R1 S3 Story Traitor Major0"," Deaths From R1 S3 Story Traitor Major1"," Deaths From R1 S3 Story Nightcrawler Ultra0"," Deaths From R1 S3 Strike Moon Major0"," Deaths From Ai Major Captain Spear Launcher House Of Wolves"," Deaths From R1 S3 WanteD Major0"," Deaths From R1 S3 WanteD Major1"," Deaths From R1 S3 WanteD Major2"," Deaths From R1 S3 WanteD Major3"," Deaths From R1 S3 WanteD Major4"," Deaths From R1 S3 WanteD Major5"," Deaths From R1 S3 WanteD Major6"," Deaths From R1 S3 WanteD Major8"," Deaths From R1 S3 WanteD Major10"," Deaths From R1 S3 WanteD Major12"," Deaths From R1 S3 WanteD Major13"," Deaths From R1 S3 WanteD Event Major0"," Deaths From R1 S3 WanteD Event Major1"," Deaths From R1 S3 WanteD Event Major2"," Deaths From R1 S3 WanteD Event Major3"," Deaths From R1 S3 WanteD Event Major4"," Deaths From R1 S3 WanteD Event Major5"," Deaths From R1 S3 WanteD Event Major6"," Deaths From R1 S3 WanteD Event Major7"," Deaths From R1 S3 WanteD Event Major8"," Deaths From R1 S3 WanteD Event Major9"," Deaths From R1 S3 WanteD Event Major10"," Deaths From R1 S3 WanteD Event Minor0"," Deaths From R1 S3 WanteD Event Minor1"," Deaths From R1 S3 WanteD Event Minor2"," Deaths From R1 S3 WanteD Event Minor3"," Deaths From R1 S3 WanteD Event Minor4"," Deaths From R1 S3 WanteD Event Minor5"," Deaths From R1 S3 WanteD Event Minor6"," Deaths From R1 S3 WanteD Event Minor7"," Deaths From R1 S4 Story Cosmo Elevator Ultra0"," Deaths From R1 S4 Story Hiveship Topknot Ultra0"," Deaths From R1 S4 Story Phobos Darksnow Major2"," Deaths From R1 S4 RaiD Epiphany DeaD King"," Deaths From R1 S4 Strike Cosmo Reliquary Ultra0"," Deaths From R1 S4 Strike Venus Tracker Ultra0"," Deaths From R1 S4 Strike Hiveship PanDora Ultra0"," Deaths From R1 S4 Strike Hiveship OverlorD Ultra0"," Deaths From R1 S4 Strike Hiveship OverlorD Ultra1"," Deaths From R1 S4 Event Rob Hiveship Major0"," Deaths From R1 S4 Event Rob Hiveship Major1"," Deaths From R1 S4 Event Rob Hiveship Major2"," Deaths From R1 S4 Event Rob Hiveship Major3"," Deaths From R1 S4 Event Rob Hiveship Major4"," Deaths From R1 S4 Event Rob Hiveship Major5"," Deaths From R1 S4 Event Rob Hiveship Major6"," Deaths From R1 S4 Event Rob Hiveship Major7"," Deaths From R1 S4 Event Rob Hiveship Major8"," Deaths From R1 S4 Event Rob Hiveship Major9"," Deaths From R1 S4 Event Rob Hiveship Major10"," Deaths From R1 S4 Event Rob Hiveship Major11"," Deaths From R1 S4 Event Rob Hiveship Major12"," Deaths From R1 S4 Event Rob Hiveship WizarDs"," Deaths From Hive Cutter"," Deaths From Cabal Dropship"," Deaths From Fallen Skiff"," Deaths From R1 S4 RaiD Epiphany Ultra Knight"," Deaths From R1 S4 RaiD Epiphany Ultra Ogre"," Deaths From R1 S4 RaiD Epiphany Twin WizarD"," Deaths From R1 S4 RaiD Epiphany Twin WizarD A"," Kills Of Cabal Interceptor"," Kills Of Fallen Reaver"," Kills Of Vex Cyclops"," Kills Of R1 S1 Event Mars Major1"," Kills Of R1 S1 Event Mars Minor0"," Kills Of R1 S1 Event Mars Minor1"," Kills Of R1 S1 Event Mars Minor2"," Kills Of R1 S1 Story Mars2 Major0"," Kills Of Elite ShanK A"," Kills Of R1 S1 Story Cosmo1 Major0"," Kills Of R1 S1 Story Cosmo2 Major0"," Kills Of R1 S1 Story Cosmo3 Ultra0"," Kills Of R1 S2 Event Any Major1"," Kills Of R1 S2 Event Cosmo Minor0"," Kills Of R1 S2 Event Cosmo Minor1"," Kills Of R1 S2 Event Cosmo Minor2"," Kills Of R1 S2 Event Cosmo Minor3"," Kills Of Elite Ogre A"," Kills Of Hive Elite Acolyte A"," Kills Of R1 S1 StriKe Hiveship1 Ultra0"," Kills Of R1 S2 Raid Hiveship0 Major0"," Kills Of R1 S2 Raid Hiveship0 Major1"," Kills Of R1 S2 Raid Hiveship0 Major2"," Kills Of R1 S2 Raid Hiveship0 Major3"," Kills Of R1 S2 Raid Hiveship0 Major4"," Kills Of R1 S2 Raid Hiveship0 Major5"," Kills Of R1 S2 Raid Hiveship0 Major6"," Kills Of R1 S2 Raid Hiveship0 Ultra0"," Kills Of R1 S2 Raid Hiveship0 Ultra1"," Kills Of R1 S2 Raid Hiveship0 Ultra2"," Kills Of Elite Harpy A"," Kills Of Major Stealth Valdal A ShocK Blade"," Kills Of Fallen Spider ShanK"," Kills Of R1 S1 Story Venus6 Major1"," Kills Of R1 S2 Bounty Cosmo Major3"," Kills Of R1 S2 Bounty Cosmo Major6"," Kills Of R1 S2 Bounty Cosmo Minor0"," Kills Of R1 S2 Bounty Cosmo Minor1"," Kills Of R1 S2 Bounty Cosmo Minor2"," Kills Of R1 S2 Bounty Moon Minor0"," Kills Of R1 S2 Bounty Moon Turret0"," Kills Of R1 S2 Raid Moon0 Major4"," Kills Of R1 S2 Raid Moon0 Major5"," Kills Of R1 S2 Story Cosmo5 Major0"," Kills Of R1 S2 Story Cosmo6 Ultra0"," Kills Of R1 S2 Story Moon7 Major0"," Kills Of R1 S2 Story Moon7 Major1"," Kills Of R1 S2 StriKe Cosmo Major0"," Kills Of R1 S2 StriKe Cosmo1 Major1"," Kills Of R1 S2 StriKe Cosmo2 Major0"," Kills Of R1 S2 StriKe Cosmo2 Major1"," Kills Of R1 S2 StriKe Cosmo2 Major2"," Kills Of R1 S2 StriKe Cosmo2 Major3"," Kills Of R1 S2 StriKe Mars3 Major0"," Kills Of R1 S2 StriKe Mars3 Minor0"," Kills Of R1 S2 StriKe Mars3 Minor1"," Kills Of R1 S2 Bounty Moon Minor1"," Kills Of R1 S2 Bounty Moon Minor2"," Kills Of R1 S2 Raid Moon0 Lantern Display Name"," Kills Of R1 S3 StriKe Moon Ultra0"," Kills Of Ai ShanK Exploder"," Kills Of Ai ShanK ShocK Turret"," Kills Of Ai ShanK Wire Rifle"," Kills Of Ai Major ShanK ShocK Turret"," Kills Of R1 S3 Arena Reef Major0"," Kills Of R1 S3 Story Persuit Major0"," Kills Of R1 S3 Story Persuit Major1"," Kills Of R1 S3 Story Persuit Major2"," Kills Of R1 S3 Story Pact Major0"," Kills Of R1 S3 Story Pact Major1"," Kills Of R1 S3 Story Traitor Major0"," Kills Of R1 S3 Story Traitor Major1"," Kills Of R1 S3 Story Nightcrawler Ultra0"," Kills Of R1 S3 StriKe Moon Major0"," Kills Of Ai Major Captain Spear Launcher House Of Wolves"," Kills Of R1 S3 Wanted Major0"," Kills Of R1 S3 Wanted Major1"," Kills Of R1 S3 Wanted Major2"," Kills Of R1 S3 Wanted Major3"," Kills Of R1 S3 Wanted Major4"," Kills Of R1 S3 Wanted Major5"," Kills Of R1 S3 Wanted Major6"," Kills Of R1 S3 Wanted Major8"," Kills Of R1 S3 Wanted Major10"," Kills Of R1 S3 Wanted Major12"," Kills Of R1 S3 Wanted Major13"," Kills Of R1 S3 Wanted Event Major0"," Kills Of R1 S3 Wanted Event Major1"," Kills Of R1 S3 Wanted Event Major2"," Kills Of R1 S3 Wanted Event Major3"," Kills Of R1 S3 Wanted Event Major4"," Kills Of R1 S3 Wanted Event Major5"," Kills Of R1 S3 Wanted Event Major6"," Kills Of R1 S3 Wanted Event Major7"," Kills Of R1 S3 Wanted Event Major8"," Kills Of R1 S3 Wanted Event Major9"," Kills Of R1 S3 Wanted Event Major10"," Kills Of R1 S3 Wanted Event Minor0"," Kills Of R1 S3 Wanted Event Minor1"," Kills Of R1 S3 Wanted Event Minor2"," Kills Of R1 S3 Wanted Event Minor3"," Kills Of R1 S3 Wanted Event Minor4"," Kills Of R1 S3 Wanted Event Minor5"," Kills Of R1 S3 Wanted Event Minor6"," Kills Of R1 S3 Wanted Event Minor7"," Kills Of R1 S4 Story Cosmo Elevator Ultra0"," Kills Of R1 S4 Story Hiveship TopKnot Ultra0"," Kills Of R1 S4 Story Phobos DarKsnow Major2"," Kills Of R1 S4 Raid Epiphany Dead King"," Kills Of R1 S4 StriKe Cosmo Reliquary Ultra0"," Kills Of R1 S4 StriKe Venus TracKer Ultra0"," Kills Of R1 S4 StriKe Hiveship Pandora Ultra0"," Kills Of R1 S4 StriKe Hiveship Overlord Ultra0"," Kills Of R1 S4 StriKe Hiveship Overlord Ultra1"," Kills Of R1 S4 Event Rob Hiveship Major0"," Kills Of R1 S4 Event Rob Hiveship Major1"," Kills Of R1 S4 Event Rob Hiveship Major2"," Kills Of R1 S4 Event Rob Hiveship Major3"," Kills Of R1 S4 Event Rob Hiveship Major4"," Kills Of R1 S4 Event Rob Hiveship Major5"," Kills Of R1 S4 Event Rob Hiveship Major6"," Kills Of R1 S4 Event Rob Hiveship Major7"," Kills Of R1 S4 Event Rob Hiveship Major8"," Kills Of R1 S4 Event Rob Hiveship Major9"," Kills Of R1 S4 Event Rob Hiveship Major10"," Kills Of R1 S4 Event Rob Hiveship Major11"," Kills Of R1 S4 Event Rob Hiveship Major12"," Kills Deaths Ratio R1 S4 Event Rob Hiveship Major0"," Kills Of R1 S4 Event Rob Hiveship Wizards"," Kills Of Mengoor And Craadug"," Deaths From Mengoor AnD CraaDug"," Kills Deaths Ratio Mengoor And Craadug"," Kills Of Primus Taaun"," Kills Of Baxx"," Deaths From Baxx"," Kills Deaths Ratio Baxx"," Kills Of Kagoor"," Deaths From Kagoor"," Kills Deaths Ratio Kagoor"," Kills Of Hive Champions"," Deaths From Hive Champions"," Kills Deaths Ratio Hive Champions"," Kills Of Cabal Champions"," Deaths From Cabal Champions"," Kills Deaths Ratio Cabal Champions"," Kills Deaths Ratio TaKen Champions"," Kills Of Hive Cutter"," Kills Of Cabal Dropship"," Kills Of Fallen SKiff"," Kills Of R1 S4 Raid Epiphany Ultra Knight"," Kills Of R1 S4 Raid Epiphany Ultra Ogre"," Kills Of R1 S4 Raid Epiphany Twin Wizard"," Kills Of R1 S4 Raid Epiphany Twin Wizard A"," Deaths From Cabal Centurion"," Deaths From Cabal Centurion Elite"," Deaths From Cabal Colossus"," Deaths From Cabal Colossus Elite"," Deaths From Cabal Goliath"," Deaths From Cabal Legionary"," Deaths From Cabal Phalanx"," Deaths From Cabal Psion"," Deaths From Cabal Psion Elite"," Deaths From Cabal Major Centurion A"," Deaths From Cabal Major GlaDiator A"," Deaths From Cabal Major Legionary A"," Deaths From Cabal Major Phalanx A"," Deaths From Cabal Major Psion A"," Deaths From Cabal Ultra Centurion A"," Deaths From Cabal Ultra GlaDiator A"," Deaths From Cabal"," Deaths From Fallen Captain"," Deaths From Fallen Captain Elite"," Deaths From Fallen Captain Elite Shock BlaDe"," Deaths From Fallen Dreg"," Deaths From Fallen Pike"," Deaths From Fallen Servitor"," Deaths From Fallen Servitor Elite"," Deaths From Fallen Shank"," Deaths From Fallen VanDal"," Deaths From Fallen VanDal Elite"," Deaths From Fallen VanDal Elite Shock BlaDe"," Deaths From Fallen VanDal Stealth"," Deaths From Fallen Ultra Servitor A"," Deaths From Fallen Ultra Captain A"," Deaths From Fallen Major Shank A"," Deaths From Fallen Major Servitor A"," Deaths From Fallen Major Captain A"," Deaths From Fallen Major Captain A Shock BlaDe"," Deaths From Fallen Major VanDal A"," Deaths From Fallen Major VanDal A Shock BlaDe"," Deaths From Fallen Major Dreg A Shrapnel Launcher"," Deaths From Fallen Major Dreg A"," Deaths From Fallen Major Dreg A Shock Dagger"," Deaths From Fallen Major Stealth VanDal A Wire Rifle"," Deaths From Fallen Major Stealth VanDal A"," Deaths From Fallen Major Stealth VanDal A Shock BlaDe"," Deaths From Fallen"," Deaths From Hive Knight"," Deaths From Hive Knight Elite"," Deaths From Hive Shrieker"," Deaths From Hive Ogre"," Deaths From Hive Thrall"," Deaths From Hive Thrall ExploDer"," Deaths From Hive Acolyte"," Deaths From Hive WizarD"," Deaths From Hive Ultra Ogre A"," Deaths From Hive Ultra Knight A"," Deaths From Hive Major WizarD A"," Deaths From Hive Major Acolyte A"," Deaths From Hive Major Thrall A"," Deaths From Hive Major Ogre A"," Deaths From Hive Major Knight A"," Deaths From Hive Major Knight A Cleaver"," Deaths From Hive"," Deaths From R1 S1 Event Cosmo Major3"," Deaths From R1 S1 Event Cosmo Major4"," Deaths From R1 S1 Event Cosmo Major5"," Deaths From R1 S1 Event Mars Major0"," Deaths From R1 S1 Event Mars Major2"," Deaths From R1 S1 Event Mars Major3"," Deaths From R1 S1 Event Moon Ultra0"," Deaths From R1 S1 Event Venus Major0"," Deaths From R1 S1 Event Venus Major1"," Deaths From R1 S1 Event Venus Major2"," Deaths From R1 S1 Event Venus Ultra0"," Deaths From R1 S1 Event Venus Ultra1"," Deaths From R1 S1 RaiD Venus0 Major0"," Deaths From R1 S1 RaiD Venus0 Major1"," Deaths From R1 S1 RaiD Venus0 Major2"," Deaths From The Gorgons"," Kills Of R1 S1 Raid Venus0 Major0"," Kills Of R1 S1 Raid Venus0 Major1"," Kills Of R1 S1 Raid Venus0 Major2"," Kills Of The Gorgons"," Deaths From R1 S1 RaiD Venus0 Major3"," Deaths From R1 S1 RaiD Venus0 Major4"," Deaths From R1 S1 RaiD Venus0 Major5"," Deaths From R1 S1 RaiD Venus0 Major6"," Deaths From R1 S1 RaiD Venus0 Major7"," Deaths From R1 S1 RaiD Venus0 Major8"," Deaths From R1 S1 RaiD Venus0 Ultra0"," Deaths From R1 S1 RaiD Venus0 Ultra1"," Deaths From R1 S1 Story Cosmo0 Ultra0"," Deaths From R1 S1 Story Mars1 Major0"," Deaths From R1 S1 Story Mars3 Major0"," Deaths From R1 S1 Story Mars5 Ultra0"," Deaths From R1 S1 Story Mars6 Major0"," Deaths From R1 S1 Story Mars7 Major0"," Deaths From R1 S1 Story Mars7 Ultra0"," Deaths From R1 S1 Story Mars7 Ultra1"," Deaths From R1 S1 Story Mars7 Ultra2"," Deaths From R1 S1 Story Moon1 Minor0"," Deaths From R1 S1 Story Moon3 Major0"," Deaths From R1 S1 Story Moon4 Major0"," Deaths From R1 S1 Story Moon4 Major1"," Deaths From R1 S1 Story Moon5 Major0"," Deaths From R1 S1 Story Moon5 Minor0"," Deaths From R1 S1 Story Moon6 Major0"," Deaths From R1 S1 Story Moon6 Ultra0"," Deaths From R1 S1 Story Venus2 Major0"," Deaths From R1 S1 Story Venus5 Major0"," Deaths From R1 S1 Story Venus5 Major1"," Deaths From R1 S1 Story Venus6 Major0"," Deaths From R1 S1 Story Venus6 Ultra0"," Deaths From R1 S1 Story Venus7 Ultra0"," Deaths From R1 S1 Strike Cosmo1 Ultra0"," Deaths From R1 S2 Strike Mars3 Ultra0"," Deaths From R1 S1 Strike Mars1 Major0"," Deaths From R1 S1 Strike Mars1 Major1"," Deaths From R1 S1 Strike Mars1 Major10"," Deaths From R1 S1 Strike Mars1 Major2"," Deaths From R1 S1 Strike Mars1 Major3"," Deaths From R1 S1 Strike Mars1 Major4"," Deaths From R1 S1 Strike Mars1 Major5"," Deaths From R1 S1 Strike Mars1 Major6"," Deaths From R1 S1 Strike Mars1 Major7"," Deaths From R1 S1 Strike Mars1 Major8"," Deaths From R1 S1 Strike Mars1 Major9"," Deaths From Dust Palace Bosses"," Deaths From R1 S1 Strike Mars2 Major0"," Deaths From R1 S1 Strike Mars2 Major1"," Deaths From R1 S1 Strike Mars2 Major2"," Deaths From R1 S1 Story Cosmo0 Minor0"," Deaths From R1 S1 Story Moon1 Major0"," Deaths From Ultra HyDra A"," Deaths From Vex Ultra Minotaur A"," Deaths From Major HyDra A"," Deaths From R1 S1 RaiD Venus0 Harpy Missile"," Deaths From R1 S1 RaiD Venus0 Bobgoblin Future"," Deaths From Vex Major Minotaur A"," Deaths From Vex Major Hobgoblin A"," Deaths From Vex Major Harpy A"," Deaths From Vex Major Goblin A"," Deaths From R1 S1 Event Cosmo Major0"," Deaths From R1 S1 Event Cosmo Major1"," Deaths From R1 S1 Event Cosmo Major2"," Deaths From R1 S1 Event Cosmo Major6"," Deaths From R1 S1 Event Cosmo Major7"," Deaths From R1 S1 Event Cosmo Major8"," Deaths From R1 S1 Story Moon4 Major2"," Deaths From R1 S1 Story Moon4 Major3"," Deaths From R1 S1 Story Cosmo1 Major1"," Deaths From The Psion Flayers"," Kills Of R1 S1 StriKe Mars1 Major0"," Kills Of R1 S1 StriKe Mars1 Major1"," Kills Of R1 S1 StriKe Mars1 Major2"," Kills Of The Psion Flayers"," Deaths From R1 S1 Strike Mars2 Ultra0"," Deaths From R1 S1 Strike Moon2 Major0"," Deaths From R1 S1 Strike Moon2 Ultra0"," Deaths From R1 S1 Strike Venus1 Ultra0"," Deaths From R1 S1 Strike Venus2 Ultra0"," Deaths From R1 S2 RaiD Moon0 Major0"," Deaths From R1 S2 RaiD Moon0 Major1"," Deaths From R1 S2 RaiD Moon0 Major2"," Deaths From R1 S2 RaiD Moon0 Major3"," Deaths From R1 S2 RaiD Moon0 Ultra0"," Deaths From R1 S2 Strike Cosmo1 Major0"," Deaths From Vex Goblin"," Deaths From Vex Harpy"," Deaths From Vex Hobgoblin"," Deaths From Vex Minotaur"," Deaths From Vex Minotaur Elite"," Deaths From Vex HyDra"," Deaths From Vex HyDra Elite"," Deaths From Vex"," Deaths From R1 S3 Story Cosmo7 Major2"," Deaths From R1 S3 Story Cosmo7 Major1"," Deaths From R1 S3 Story Cosmo7 Major0"," Deaths From R1 S3 Arena Reef Ultra1"," Deaths From R1 S3 Arena Reef Ultra8"," Deaths From R1 S3 Strike Moon Ultra1"," Deaths From R1 S3 Arena Reef Ultra4"," Deaths From R1 S3 Arena Reef Ultra5"," Deaths From R1 S3 Arena Reef Ultra6"," Deaths From R1 S3 Arena Reef Ultra3"," Deaths From R1 S3 Arena Reef Ultra9"," Deaths From R1 S3 Arena Reef Ultra2"," Deaths From R1 S3 Arena Reef Ultra11"," Deaths From R1 S3 Arena Reef Ultra12"," Deaths From R1 S2 Bounty Cosmo Major0"," Deaths From R1 S2 Bounty Cosmo Major1"," Deaths From R1 S2 Bounty Cosmo Ultra0"," Deaths From R1 S2 Bounty Cosmo Major2"," Deaths From R1 S2 Bounty Cosmo Major7"," Deaths From R1 S2 Bounty Cosmo Major4"," Deaths From R1 S2 Bounty Cosmo Major5"," Deaths From R1 S2 Bounty Moon Ultra0"," Kills Of Cabal Major Centurion A"," Kills Of Cabal Major Gladiator A"," Kills Of Cabal Major Legionary A"," Kills Of Cabal Major Phalanx A"," Kills Of Cabal Major Psion A"," Kills Of Cabal Ultra Centurion A"," Kills Of Cabal Ultra Gladiator A"," Kills Of Cabal Centurion"," Kills Of Cabal Centurion Elite"," Kills Of Cabal Colossus"," Kills Of Cabal Colossus Elite"," Kills Of Cabal Goliath"," Kills Of Cabal Legionary"," Kills Of Cabal Phalanx"," Kills Of Cabal Psion"," Kills Of Cabal Psion Elite"," Kills Of Cabal"," Kills Deaths Ratio Cabal"," Kills Deaths Ratio Cabal Centurion"," Kills Deaths Ratio Cabal Colossus"," Kills Deaths Ratio Cabal Goliath"," Kills Deaths Ratio Cabal Legionary"," Kills Deaths Ratio Cabal Phalanx"," Kills Deaths Ratio Cabal Psion"," Kills Of Fallen Ultra Servitor A"," Kills Of Fallen Ultra Captain A"," Kills Of Fallen Major ShanK A"," Kills Of Fallen Major Servitor A"," Kills Of Fallen Major Captain A"," Kills Of Fallen Major Captain A ShocK Blade"," Kills Of Fallen Major Vandal A"," Kills Of Fallen Major Vandal A ShocK Blade"," Kills Of Fallen Major Dreg A Shrapnel Launcher"," Kills Of Fallen Major Dreg A"," Kills Of Fallen Major Dreg A ShocK Dagger"," Kills Of Fallen Major Stealth Vandal A Wire Rifle"," Kills Of Fallen Major Stealth Vandal A"," Kills Of Fallen Major Stealth Vandal A ShocK Blade"," Kills Of Fallen Captain"," Kills Of Fallen Captain Elite"," Kills Of Fallen Captain Elite ShocK Blade"," Kills Of Fallen Dreg"," Kills Of Fallen PiKe"," Kills Of Fallen Servitor"," Kills Of Fallen Servitor Elite"," Kills Of Fallen ShanK"," Kills Of Fallen Vandal"," Kills Of Fallen Vandal Elite"," Kills Of Fallen Vandal Elite ShocK Blade"," Kills Of Fallen Vandal Stealth"," Kills Of Fallen"," Kills Deaths Ratio Fallen"," Kills Deaths Ratio Fallen Captain"," Kills Deaths Ratio Fallen Dreg"," Kills Deaths Ratio Fallen PiKe"," Kills Deaths Ratio Fallen Servitor"," Kills Deaths Ratio Fallen ShanK"," Kills Deaths Ratio Fallen Vandal"," Kills Of Hive Ultra Ogre A"," Kills Of Hive Ultra Knight A"," Kills Of Hive Major Wizard A"," Kills Of Hive Major Acolyte A"," Kills Of Hive Major Thrall A"," Kills Of Hive Major Ogre A"," Kills Of Hive Major Knight A"," Kills Of Hive Major Knight A Cleaver"," Kills Of Hive Knight"," Kills Of Hive Knight Elite"," Kills Of Hive ShrieKer"," Kills Of Hive Ogre"," Kills Of Hive Thrall"," Kills Of Hive Thrall Exploder"," Kills Of Hive Acolyte"," Kills Of Hive Wizard"," Kills Of Hive"," Kills Deaths Ratio Hive"," Kills Deaths Ratio Hive Knight"," Kills Deaths Ratio Hive ShrieKer"," Kills Deaths Ratio Hive Ogre"," Kills Deaths Ratio Hive Thrall"," Kills Deaths Ratio Hive Thrall Exploder"," Kills Deaths Ratio Hive Acolyte"," Kills Deaths Ratio Hive Wizard"," Kills Of Vex Ultra Minotaur A"," Kills Of Vex Major Minotaur A"," Kills Of Vex Major Hobgoblin A"," Kills Of Vex Major Harpy A"," Kills Of Vex Major Goblin A"," Kills Of Vex Goblin"," Kills Of Vex Harpy"," Kills Of Vex Hobgoblin"," Kills Of Vex Minotaur"," Kills Of Vex Minotaur Elite"," Kills Of Vex Hydra"," Kills Of Vex Hydra Elite"," Kills Of Vex"," Kills Deaths Ratio Vex"," Kills Deaths Ratio Vex Goblin"," Kills Deaths Ratio Vex Harpy"," Kills Deaths Ratio Vex Hobgoblin"," Kills Deaths Ratio Vex Minotaur"," Kills Deaths Ratio Vex Hydra"," Kills Of R1 S1 Story Cosmo0 Minor0"," Kills Of R1 S1 Story Moon1 Major0"," Kills Of Ultra Hydra A"," Kills Of Major Hydra A"," Kills Of R1 S1 Raid Venus0 Harpy Missile"," Kills Of R1 S1 Raid Venus0 Bobgoblin Future"," Kills Of R1 S1 Event Cosmo Major0"," Kills Of R1 S1 Event Cosmo Major1"," Kills Of R1 S1 Event Cosmo Major2"," Kills Of R1 S1 Event Cosmo Major6"," Kills Of R1 S1 Event Cosmo Major7"," Kills Of R1 S1 Event Cosmo Major8"," Kills Of R1 S1 Story Moon4 Major2"," Kills Of R1 S1 Story Moon4 Major3"," Kills Of R1 S1 Story Cosmo1 Major1"," Deaths From Swarm Princes"," Kills Of R1 S1 Story Moon4 Major1"," Kills Of R1 S1 Story Moon4 Major0"," Kills Of Swarm Princes"," Kills Of R1 S1 Event Cosmo Major3"," Kills Of R1 S1 Event Cosmo Major4"," Kills Of R1 S1 Event Cosmo Major5"," Kills Of R1 S1 Event Mars Major0"," Kills Of R1 S1 Event Mars Major2"," Kills Of R1 S1 Event Mars Major3"," Kills Of R1 S1 Event Moon Ultra0"," Kills Of R1 S1 Event Venus Major0"," Kills Of R1 S1 Event Venus Major1"," Kills Of R1 S1 Event Venus Major2"," Kills Of R1 S1 Event Venus Ultra0"," Kills Of R1 S1 Event Venus Ultra1"," Kills Of R1 S1 Raid Venus0 Major3"," Kills Of R1 S1 Raid Venus0 Major4"," Kills Of R1 S1 Raid Venus0 Major5"," Kills Of R1 S1 Raid Venus0 Major6"," Kills Of R1 S1 Raid Venus0 Major7"," Kills Of R1 S1 Raid Venus0 Major8"," Kills Of R1 S1 Raid Venus0 Ultra0"," Kills Of Bosses At Vault Of Glass"," Kills Of Raid Bosses"," Kills Of R1 S1 Raid Venus0 Ultra1"," Kills Of R1 S1 Story Cosmo0 Ultra0"," Kills Of R1 S1 Story Mars1 Major0"," Kills Of R1 S1 Story Mars3 Major0"," Kills Of R1 S1 Story Mars5 Ultra0"," Kills Of R1 S1 Story Mars6 Major0"," Kills Of R1 S1 Story Mars7 Major0"," Kills Of R1 S1 Story Mars7 Ultra0"," Kills Of R1 S1 Story Mars7 Ultra1"," Kills Of R1 S1 Story Mars7 Ultra2"," Kills Of Sol Progeny"," Deaths From Sol Progeny"," Kills Of R1 S1 Story Moon1 Minor0"," Kills Of R1 S1 Story Moon3 Major0"," Kills Of R1 S1 Story Moon5 Major0"," Kills Of R1 S1 Story Moon5 Minor0"," Kills Of R1 S1 Story Moon6 Major0"," Kills Of R1 S1 Story Moon6 Ultra0"," Kills Of R1 S1 Story Venus2 Major0"," Kills Of R1 S1 Story Venus5 Major0"," Kills Of R1 S1 Story Venus5 Major1"," Kills Of R1 S1 Story Venus6 Major0"," Kills Of R1 S1 Story Venus6 Ultra0"," Kills Of R1 S1 Story Venus7 Ultra0"," Kills Of R1 S1 StriKe Cosmo1 Ultra0"," Kills Of R1 S2 StriKe Mars3 Ultra0"," Kills Of R1 S1 StriKe Mars1 Major10"," Kills Of R1 S1 StriKe Mars1 Major3"," Kills Of R1 S1 StriKe Mars1 Major4"," Kills Of R1 S1 StriKe Mars1 Major5"," Kills Of R1 S1 StriKe Mars1 Major6"," Kills Of R1 S1 StriKe Mars1 Major7"," Kills Of R1 S1 StriKe Mars1 Major8"," Kills Of R1 S1 StriKe Mars1 Major9"," Kills Of R1 S1 StriKe Mars2 Major0"," Kills Of R1 S1 StriKe Mars2 Major1"," Kills Of R1 S1 StriKe Mars2 Major2"," Kills Of R1 S1 StriKe Mars2 Ultra0"," Kills Of R1 S1 StriKe Moon2 Major0"," Kills Of R1 S1 Bounty Moon2 Major0"," Kills Of R1 S1 StriKe Moon2 Ultra0"," Kills Of R1 S1 StriKe Venus1 Ultra0"," Kills Of R1 S1 StriKe Venus2 Ultra0"," Kills Of R1 S2 Raid Moon0 Major0"," Kills Of R1 S2 Raid Moon0 Major1"," Kills Of R1 S2 Raid Moon0 Major2"," Kills Of R1 S2 Raid Moon0 Major3"," Kills Of R1 S2 Raid Moon0 Ultra0"," Kills Of R1 S2 StriKe Cosmo1 Major0"," Kills Of R1 S3 Story Cosmo7 Major2"," Kills Of R1 S3 Story Cosmo7 Major1"," Kills Of R1 S3 Story Cosmo7 Major0"," Kills Of R1 S3 Arena Reef Ultra1"," Kills Of R1 S3 Arena Reef Ultra8"," Kills Of R1 S3 StriKe Moon Ultra1"," Kills Of R1 S3 Arena Reef Ultra4"," Kills Of R1 S3 Arena Reef Ultra5"," Kills Of R1 S3 Arena Reef Ultra6"," Kills Of R1 S3 Arena Reef Ultra3"," Kills Of R1 S3 Arena Reef Ultra9"," Kills Of R1 S3 Arena Reef Ultra2"," Kills Of R1 S3 Arena Reef Ultra11"," Kills Of R1 S3 Arena Reef Ultra12"," Kills Of R1 S2 Bounty Cosmo Major0"," Kills Of R1 S2 Bounty Cosmo Major1"," Kills Of R1 S2 Bounty Cosmo Ultra0"," Kills Of R1 S2 Bounty Cosmo Major2"," Kills Of R1 S2 Bounty Cosmo Major7"," Kills Of R1 S2 Bounty Cosmo Major4"," Kills Of R1 S2 Bounty Cosmo Major5"," Kills Of R1 S2 Bounty Moon Ultra0"," Deaths From Elite Hobgoblin A"," Deaths From Elite WizarD A"," Deaths From R1 S1 Event Mars Major4"," Deaths From R1 S1 RaiD Venus0 Goblin Future"," Deaths Fromr1 S1 RaiD Venus0 Goblin HeaDless"," Deaths From R1 S1 RaiD Venus0 Goblin Past"," Deaths From R1 S1 RaiD Venus0 Hobgoblin Past"," Deaths From R1 S1 Strike Cosmo1 Major0"," Deaths From Unknown"," Kills Of Elite Hobgoblin A"," Kills Of Elite Wizard A"," Kills Of R1 S1 Event Mars Major4"," Kills Of R1 S1 Raid Venus0 Goblin Future"," Kills Ofr1 S1 Raid Venus0 Goblin Headless"," Kills Of R1 S1 Raid Venus0 Goblin Past"," Kills Of R1 S1 Raid Venus0 Hobgoblin Past"," Kills Of R1 S1 StriKe Cosmo1 Major0"," Kills Of UnKnown"," Precision Kills Of Elite Hobgoblin A"," Precision Kills Of Elite Wizard A"," Precision Kills Of R1 S1 Event Mars Major4"," Precision Kills Of R1 S1 Raid Venus0 Goblin Future"," Precision Kills Ofr1 S1 Raid Venus0 Goblin Headless"," Precision Kills Of R1 S1 Raid Venus0 Goblin Past"," Precision Kills Of R1 S1 Raid Venus0 Hobgoblin Past"," Precision Kills Of R1 S1 Strike Cosmo1 Major0"," Precision Kills Of Unknown")  , "Specialized Activity Stats" => array("Strike" => array( ) , "Raid" => array( ) , "AllPvP" => array() ,"Patrol" => array( ) , "AllPvE" => array( ), "PvPIntroduction" => array( ) , "ThreeVsThree" => array( ) ,"Control" => array( ) ,"Lockdown" => array( ) , "Team" => array( ), "FreeForAll" => array( ),"Nightfall" => array( ), "Heroic" => array( ) ,"IronBanner" => array( ) ,"Arena" => array( ) ,"ArenaChallenge" => array( ) ,"TrialsOfOsiris" => array( ), "Elimination" => array( ) ,"Rift" => array( ) , "Mayhem" => array( ) ,"ZoneControl" => array( )) , "Post Game Carnage Reports" => array()) , "Character Stats" => array("Defense" , "Intellect" , "Discipline" ,"Strength" ,"Light","Armor","Agility","Recovery","Optics" ,"Level") , "Grimoire Score" => array() ,"Item Stats" => array() );
		
		public function __construct($user = null){
			
			if($user != null){
				
					if(isset($user->xbox_id)){
						$user->api_data["Destiny"]["xboxone"]["membershipid"] = $this->getUserMembershipId("1", $user->xbox_id);
						array_push($this->users["xboxone"],$user); 
						$this->gamer = $user;
					}
					if(isset($user->psn_id)){
						$user->api_data["Destiny"]["ps4"]["membershipid"] = $user->getUserMembershipId("2", $user->psn_id);
				array_push($this->users["ps4"],$user); 
						$this->gamer= $user;
					}
				
			}
			 
			 
			$this->key = "ac51c7e09da042978b2bc134172c4aa2";
			$this->url_root = "http://www.bungie.net/Platform/Destiny";
			$this->api_name = "Destiny";
			
			
		}
		public function setPostGameCarnageUrl($activity_id){
			
			$this->post_game_carnage_report_url = $this->url_root . str_replace("{activityId}", $activity_id,$this->post_game_carnage_report_url);
		}
		public function setMembershipIdUrl($membership_type,$gamer_id){
			
			$this->membership_id_url = $this->url_root . str_replace("{membershipType}", $membership_type,$this->membership_id_url);
			$this->membership_id_url = str_replace("{displayName}", $gamer_id,$this->membership_id_url);
			
		}
		public function setAllCharacterStatsUrl($membership_type,$membership_id){
			
			$this->all_character_stats_url = $this->url_root . str_replace("{membershipType}", $membership_type,$this->all_character_stats_url);
			$this->all_character_stats_url = str_replace("{destinyMembershipId}", $membership_id,$this->all_character_stats_url);
			
		}
		public function setOneCharacterStatsUrl($membership_type,$membership_id,$character_id){
			
			$this->one_character_stats_url = $this->url_root . str_replace("{membershipType}", $membership_type,$this->one_character_stats_url);
			$this->one_character_stats_url = str_replace("{destinyMembershipId}", $membership_id,$this->one_character_stats_url);
			$this->one_character_stats_url = str_replace("{characterId}", $character_id,$this->one_character_stats_url);
		}
		public function setGromireStatsUrl($membership_type,$membership_id){
			
			$this->membership_id_url = $this->url_root . str_replace("{membershipType}", $membership_type,$this->grimoire_stats_url);
			$this->membership_id_url = str_replace("{destinyMembershipId}", $membership_id,$this->grimoire_stats_url);
		}
		
		public function setOneCharacterStatsAndActiviesUrl($membership_type,$membership_id,$character_id){		
			$this->one_character_stats_and_activies_url = $this->url_root . str_replace("{membershipType}", $membership_type,$this->one_character_stats_and_activies_url);
			$this->one_character_stats_and_activies_url = str_replace("{destinyMembershipId}", $membership_id,$this->one_character_stats_and_activies_url);
			$this->one_character_stats_and_activies_url = str_replace("{characterId}", $character_id ,$this->one_character_stats_and_activies_url);
		}
		public function setOneCharacterProgressionReportUrl($membership_type,$membership_id,$character_id){
			
			$this->one_character_progression_report_url  = $this->url_root . str_replace("{membershipType}", $membership_type,$this->one_character_progression_report_url);
			$this->one_character_progression_report_url  = str_replace("{destinyMembershipId}", $membership_type,$this->one_character_progression_report_url);
			$this->one_character_progression_report_url  = str_replace("{characterId}", $character_id,$this->one_character_progression_report_url);
		}
		public function setOneCharacterInventorySummaryUrl($membership_type,$membership_id,$character_id){
			
			$this->one_character_inventory_summary_url  = $this->url_root . str_replace("{membershipType}", $membership_type,$this->one_character_inventory_summary_url);
			$this->one_character_inventory_summary_url  = str_replace("{destinyMembershipId}", $membership_type,$this->one_character_inventory_summary_url);
			$this->one_character_inventory_summary_url  = str_replace("{characterId}", $character_id,$this->one_character_inventory_summary_url);
		}
		public function setOneCharacterCurrentInventoryUrl($membership_type,$membership_id,$character_id){
			
			$this->one_character_current_inventory_url  = $this->url_root . str_replace("{membershipType}", $membership_type,$this->one_character_current_inventory_url);
			$this->one_character_current_inventory_url  = str_replace("{destinyMembershipId}", $membership_type,$this->one_character_current_inventory_url);
			$this->one_character_current_inventory_url  = str_replace("{characterId}", $character_id,$this->one_character_current_inventory_url);
		}
		public function setAllCharactersItemsUrl($membership_type,$membership_id){
			
			$this->all_character_items_url   = $this->url_root . str_replace("{membershipType}", $membership_type,$this->all_character_items_url);
			$this->all_character_items_url  =  str_replace("{destinyMembershipId}", $membership_type,$this->all_character_items_url);
			
		}
		public function setOneCharacterActivityHistoryUrl($membership_type,$membership_id,$character_id){
			
			$this->one_character_activity_history_url   = $this->url_root . str_replace("{membershipType}", $membership_type,$this->one_character_activity_history_url);
			$this->one_character_activity_history_url   = str_replace("{destinyMembershipId}", $membership_type,$this->one_character_activity_history_url);
			$this->one_character_activity_history_url   = str_replace("{characterId}", $character_id,$this->one_character_activity_history_url);
		}
		public function setGetDestinyAccountUrl($membership_type,$membership_id){
			
			$this->$get_destiny_account_url   = $this->url_root . str_replace("{membershipType}", $membership_type,$this->$get_destiny_account_url);
			$this->$get_destiny_account_url   = str_replace("{destinyMembershipId}", $membership_type,$get_destiny_account_url);
			
		}
		public function addGamer($user){
			
			if(isset($user->xbox_id)){
						$user->api_data["Destiny"]["xboxone"]["membershipid"] = $this->getUserMembershipId("1", $user->xbox_id);
						
						$this->gamer = $user;
						 	 	
					}
					if(isset($user->psn_id)){
						$user->api_data["Destiny"]["ps4"]["membershipid"] = $user->getUserMembershipId("2", $user->psn_id);
						
						$this->gamer = $user;
					}
		}
		private function addHeadersToRequest($url){
			curl_setopt($url,CURLOPT_RETURNTRANSFER,true);
			curl_setopt($url,CURLOPT_HTTPHEADER, array("X-API-Key: {$this->key}"));
		}
		public function getGamerStats($console){
			
			$url = null;
			$membership_type = null;
			$response = null;
			try{
				
				if($console == "xboxone")
					$membership_type = "1";
				else if($console == "ps4")
					$membership_type = "2";
				else if($console != "1" || $console != "2")
					throw new DestinyApiException("Invalid Membership Type");
					
				if($membership_type== "1"){
					
					$membership_id = $this->gamer->api_data["Destiny"]["xboxone"]["membershipid"];
					}
				else if($membership_type == "2")
					$membership_id = $this->gamer->api_data["Destiny"]["ps4"]["membershipid"];
				
				$this->setAllCharacterStatsUrl($membership_type, $membership_id);
				$url = $this->all_character_stats_url . "?groups=General,Weapons,Medals,Enemies";
				
				$url = curl_init($url);
				$this->addHeadersToRequest($url);
				if($response = curl_exec($url)){
					$response = json_decode($response,true);
					$stats = array();
					//print_r($membership_id);
					//print_r($response);
					
					foreach($response["Response"]["mergedAllCharacters"]["merged"]["allTime"] as $key){
						
							if(empty($key))
								continue;
							foreach ($key as $k => $value) {
								if($k == "statId")
									$stat = $value;
								if($k == "basic")
									$stats[$stat] = $value["value"];
								
							}
						}
					
					return $stats;
				}else{
					print_r(curl_getinfo($url));
				}
			}catch(Exception $ex){
				
			}
			
		}
		public function getApiStats(){
			return $this->stats;
		}
		
		public function getGamerEnemyStats($console){
			$url 			 = null;
			$membership_id 	 = null;
			$membership_type = null;
			$response        = null;
			
			try{
				
				if($console == "xboxone")
					$membership_type = "1";
				else if($console == "ps4")
					$membership_type = "2";
				else if($console != "1" || $console != "2")
					throw new DestinyApiException("Invalid Membership Type");
					
				if($membership_type== "1")
					$membership_id = $this->gamer->api_data["Destiny"]["xboxone"]["membershipid"];
				else if($membership_type == "2")
					$membership_id = $this->gamer->api_data["Destiny"]["ps4"]["membershipid"];
				
				$this->setAllCharacterStatsUrl($membership_type, $membership_id);
				$url = $this->all_character_stats_url . "?groups=Enemies";
				$url = curl_init($url);
				$this->addHeadersToRequest($url);
				if($response = curl_exec($url)){
					
					$response = json_decode($response,true);
					if($response["ErrorStatus" ]== "Success"){
						$stats = array();
						//got to check for errors here
						foreach($response["Response"] as $key){
							if(empty($key))
								continue;
							foreach ($key as $k) {
								foreach ($k as $stat => $v) {
									
										
										
										$stats[$stat] = $v["basic"]["value"];
									
									
								}
							}
						}
						
					}
					return $stats;
				}else{
				}
			}catch(Exception $ex){
				print_r($ex);
			}
		}
static public function getGamerGeneralStats($console){
			$url 			 = null;
			$membership_id 	 = null;
			$membership_type = null;
			$response        = null;
			
			try{
				
				if($console == "xboxone")
					$membership_type = "1";
				else if($console == "ps4")
					$membership_type = "2";
				else if($console != "1" || $console != "2")
					throw new DestinyApiException("Invalid Membership Type");
				
				if($membership_type == "1")
					$membership_id = $this->gamer->api_data["Destiny"]["xboxone"]["membershipid"];
				else if($membership_type == "2")
					$membership_id = $this->gamer->api_data["Destiny"]["ps4"]["membershipid"];
				
				$this->setAllCharacterStatsUrl($console, $membership_id);
				$url = $this->all_character_stats_url;
				$url = curl_init($url);
				$this->addHeadersToRequest($url);
				
				if($response = curl_exec($url)){
					$response = json_decode($response,true);
					if($response["ErrorStatus"] == "Success"){
						$stats = array();
						//got to check for errors here
						foreach($response["Response"]["mergedAllCharacters"]["results"]["allPvE"]["allTime"] as $key => $value){
							$stats[$key] = $value["basic"]["value"];
							
						}
						
					}
					return $stats;
				}else{
				}
			}catch(Exception $ex){
				print_r($ex);
			}
		}
public function getGamerItemStats($membership_type,$membership_id){
	
	try{
		if($membership_id =="xboxone")
			$membership_id = "1";
		else if($membership_id == "ps4")
			$membership_id = "2";
					$tag_name = rawurlencode($tag_name);
	}catch(Exception $ex){
		
	}
}
static public function getGamerWeaponStats($console){
			$url 			 = null;
			$membership_id 	 = null;
			$membership_type = null;
			$response        = null;
			
			try{
				
				if($console == "xboxone")
					$membership_type = "1";
				else if($console == "ps4")
					$membership_type = "2";
				else
					throw new DestinyApiException("Invalid Membership Type");
				
				if($membership_type == "1")
					$membership_id = $this->gamer->api_data["Destiny"]["xboxone"]["membershipid"];
				else if($membership_type == "2")
					$membership_id = $this->gamer->api_data["Destiny"]["ps4"]["membershipid"];
			    
				$this->setAllCharacterStatsUrl($membership_type, $membership_id);
				$url = $this->all_character_stats_url . "?groups=Weapons";
				$url = curl_init($url);
				$this->addHeadersToRequest($url);
				if($response = curl_exec($url)){
					
					$response = json_decode($response,true);
					if($response["ErrorStatus"] == "Success"){
						$stats = array();
						//got to check for errors here
						foreach($response["Response"]["mergedAllCharacters"]["results"]["allPvE"]["allTime"] as $key => $value){
							$stats[$key] = $value["basic"]["value"];
							
						}
						
					}
					return $stats;
				}else{
				}
			}catch(Exception $ex){
				print_r($ex);
			}
		}
		private function getUserMembershipId($membership_type,$tag_name){
			$url              = null;
			$response         = null;
			$membership_id    = null;
			try{
				$tag_name = rawurlencode($tag_name);
				if($membership_type =="xboxone")
					$membership_id = "1";
				else if($membership_type == "ps4")
					$membership_id = "2";
				
				$this->setMembershipIdUrl($membership_type, $tag_name);
				$url = $this->membership_id_url;
				
				$url = curl_init($url);
				$this->addHeadersToRequest($url);
				
				if($response = curl_exec($url)){
					$response = json_decode($response,true);
					if($response["ErrorStatus"] == "Success"){
						if(empty($response))
							throw new DestinyApiException("Response came back empty");
						if(isset($response["Response"])){
							if($response["Response"] == "0" || $response["Response"] == 0 )
								throw new DestinyApiException($response["Message"]);
							else
								$membership_id = $response["Response"];
						}else
							throw new DestinyApiException("Invalid response came back from Destiny.");
					
						return($membership_id);
					}else
						throw new DestinyApiException($response["Message"]);
				}
				else
					throw new DestinyApiException("Something is wrong!");
			}catch(Exception $ex){
				print_r($ex);
			}
		}
		
		//end of class /////////////////////////////
	}

if($_SERVER["REQUEST_METHOD"] == "GET" && $_SERVER["REMOTE_ADDR"] =="::1" && $_GET['ajax']== true){
	if($_GET["destiny_stats"] == true ){
			$api = new DestinyApi();
			echo("<ul class='game_stat_categories' id='destiny_stat_categories'>");
		foreach($api->getApiStats() as $key => $value){
			echo("<li> 
					<a href='#' class='game_stat_category' onclick='LeagueForm.toggleFieldCollapse(\"#destiny_".strtolower(str_replace(" " ,"" , $key)) ."_subcategories\")'>
						{$key}
					</a>
					<input type='checkbox' class='game_stat_category_check_box' id='destiny_" . strtolower(str_replace(" ", "",$key))."_category_check_box' name='destiny_stats[]' '/> 
					<ul class='game_stat_subcategories' id='destiny_".strtolower(str_replace(" " ,"" , $key)) ."_subcategories' style='display:none'>");
					
						foreach($value as $k => $v){
							echo("<li>
									<a href='#' class='game_stat_subcategory' onclick='LeagueForm.toggleFieldCollapse(\"#destiny_".strtolower(str_replace(" " ,"" , $k)) ."_" . strtolower(str_replace(" " ,"" , $key)) ."_stats\")'>
										{$k}
									</a>
									<input type='checkbox' class='game_stat_subcategory_check_box' id='destiny_" . strtolower(str_replace(" ", "",$k))."_subcategory_check_box' name='destiny_stats[]'/> 
									<ul class='game_category_stats' id='destiny_".strtolower(str_replace(" " ,"" , $k)) ."_" .strtolower(str_replace(" " ,"" , $key)) ."_stats' style='display:none'>");
										foreach($v as $stat_key => $stat){
											echo("
												<li class='game_stat' >
													{$stat}<input type='checkbox' class='game_stat_check_box' id='destiny_stat_check_box' name='destiny_stats[]'/> 
												</li>
												
												
											");		
										}
										
									echo("
										</ul>
									</li>
							   ");
					}
						
					echo("</ul>
					
				</li>");
		}
		echo("</ul>
			
		");
	echo("<script>
	
	LeagueForm.CheckBoxes.game_stat_category_check_box  = jQuery('.game_stat_categories').find(jQuery('.game_stat_category_check_box'));
	LeagueForm.CheckBoxes.game_stat_subcategory_check_box = jQuery('.game_stat_categories').find(jQuery('.game_stat_subcategory_check_box'));
			
			var i = 0;
			LeagueForm.CheckBoxes.game_stat_category_check_box.each(function(){
					
				LeagueForm.CheckBoxes.Events.click(LeagueForm.CheckBoxes.game_stat_category_check_box[i].id);
				i++;
			});
			i = 0;
			LeagueForm.CheckBoxes.game_stat_subcategory_check_box.each(function(){
					
				LeagueForm.CheckBoxes.Events.click(LeagueForm.CheckBoxes.game_stat_subcategory_check_box[i].id);
				i++;
				
			});
			//console.log(LeagueForm.CheckBoxes.game_stat_subcategory_check_box );
			</script>");
		
		}
}

?>