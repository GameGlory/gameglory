<?php    
function xmlstr_to_array($xmlstr) {
  $doc = new DOMDocument();
  $doc->loadXML($xmlstr);
  return domnode_to_array($doc->documentElement);
}
function domnode_to_array($node) {
  $output = "";
  switch ($node->nodeType) {
   case XML_CDATA_SECTION_NODE:
   case XML_TEXT_NODE:
    $output = trim($node->textContent);
   break;
   case XML_ELEMENT_NODE:
    for ($i=0, $m=$node->childNodes->length; $i<$m; $i++) {
     $child = $node->childNodes->item($i);
     $v = domnode_to_array($child);
     if(isset($child->tagName)) {
       $t = $child->tagName;
       if(!isset($output[$t])) {
        $output[$t] = array();
       }
       $output[$t][] = $v;
     }
     elseif($v || $v == 0) {
      $output = (string) $v;
     }
    }
    if(is_array($output)) {
     if($node->attributes->length) {
      $a = array();
      foreach($node->attributes as $attrName => $attrNode) {
       $a[$attrName] = (string) $attrNode->value;
      }
      $output['@attributes'] = $a;
     }
     foreach ($output as $t => $v) {
      if(is_array($v) && count($v)==1 && $t!='@attributes') {
       $output[$t] = $v[0];
      }
     }
    }
   break;
  }
  if ($output == '' || (empty($output) && $output != 0)){ 
  		return false;
  } else {
	  	return $output;
  }
}

function stripEmptyNode($node_var){if ($node_var != 'Empty Node'){return true;} else {return false;}}
function clean($string){$string = preg_replace("/[^a-z0-9_-]+/i", '', $string);return $string;}



function recursive_array_filter($input) { 
	foreach ($input as &$value) 
	{ 
	  if (is_array($value)) 
	  { 
		$value = recursive_array_filter($value); 
	  } 
	} 
	
	return array_filter($input, 'stripEmptyNode'); 
}

function process_game_images($returned_data, $query_data){
	if(isset($query_data['game_image_storge_location']) && isset($query_data['trophy_image_storge_location']) && isset($returned_data['content_type'])){
		if($query_data['game_image_storge_location'] && $query_data['trophy_image_storge_location']){
			$query_data['game_image_storge_location'] = rtrim($query_data['game_image_storge_location'],DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR;
			$query_data['trophy_image_storge_location'] = rtrim($query_data['trophy_image_storge_location'],DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR;
			if($returned_data['content_type'] == 'game' && isset($returned_data['image_b64'])){
				if (!is_dir($query_data['game_image_storge_location'])) {
					mkdir($query_data['game_image_storge_location']); 
				}
				if (!is_dir($query_data['game_image_storge_location'])) {
					die('The directory "'.$query_data['game_image_storge_location'].'" is not writable'); 
				}
				if (!is_writable($query_data['game_image_storge_location'])) {
					die('The directory "'.$query_data['game_image_storge_location'].'" was not created.  Please create this yourself and CHMOD');
				}
				if (!is_dir($query_data['game_image_storge_location'].$returned_data['game_hash'])) {
					mkdir($query_data['game_image_storge_location'].$returned_data['game_hash']); 
				}
				if (!is_dir($query_data['game_image_storge_location'].$returned_data['game_hash'])) {
					die('Failed to create "'.$query_data['game_image_storge_location'].'".  You probably need to CHMOD "'.$query_data['game_image_storge_location'].'"'); 
				}
				
				file_put_contents($query_data['game_image_storge_location'].$returned_data['game_hash'].DIRECTORY_SEPARATOR.$returned_data['image_hash'].'.PNG', base64_decode($returned_data['image_b64']));
				if(!file_exists($query_data['game_image_storge_location'].$returned_data['game_hash'].DIRECTORY_SEPARATOR.$returned_data['image_hash'].'.PNG')){
					die('Failed to save PNG at: "'.$query_data['game_image_storge_location'].$returned_data['game_hash'].DIRECTORY_SEPARATOR.$returned_data['image_hash'].'.PNG".  You probably need to CHMOD "'.$query_data['game_image_storge_location'].'".'); 
				}
			}
			
			
			
			
			
			if($returned_data['content_type'] == 'trophies'){
				if (!is_dir($query_data['trophy_image_storge_location'])) {
					mkdir($query_data['trophy_image_storge_location']); 
				}
				if (!is_dir($query_data['trophy_image_storge_location'])) {
					die('The directory "'.$query_data['trophy_image_storge_location'].'" was not created'); 
				}
				if (!is_writable($query_data['trophy_image_storge_location'])) {
					die('The directory "'.$query_data['trophy_image_storge_location'].'" is not writable. CHMOD');
				}
				if (!is_dir($query_data['trophy_image_storge_location'].$returned_data['game_hash'])) {
					mkdir($query_data['trophy_image_storge_location'].$returned_data['game_hash']); 
				}
				if (!is_dir($query_data['trophy_image_storge_location'].$returned_data['game_hash'])) {
					die('Failed to create "'.$query_data['trophy_image_storge_location'].'".  You probably need to CHMOD "'.$query_data['trophy_image_storge_location'].'"'); 
				}

				foreach ($returned_data['trophies'] as $value){
					if (isset($value['image_b64']) && isset($value['image_hash'])){
						file_put_contents($query_data['trophy_image_storge_location'].$value['game_hash'].DIRECTORY_SEPARATOR.$value['image_hash'].'.PNG', base64_decode($value['image_b64']));
					}
				}
			}
		}
	}
}

function fetch_data($data_type, $data_reference, $additional_data_reference, $example = false){

$curl_base_url = ('https://www.happynation.co.uk/api');




	if ($data_reference != ''){
		
		if ($data_type == 'psnGetUser'){
			$curlurl = $curl_base_url.'/psnGetUser';
			$curlpost['user_id'] = $data_reference;
			$curlpost['timestamp'] = $additional_data_reference;
		}
		
		if ($data_type == 'psnGetUserGames'){
			$curlurl = $curl_base_url.'/psnGetUserGames';
			$curlpost['user_id'] = $data_reference;
		}
		
		if ($data_type == 'psnGetUserTrophies'){
			$curlurl = $curl_base_url.'/psnGetUserTrophies';
			$curlpost['npcommid'] = $data_reference;
			$curlpost['user_id'] = $additional_data_reference;
		}
		
		if ($data_type == 'psnGetUserUpdates'){
			$curlurl = $curl_base_url.'/psnGetUserUpdates';
			$curlpost['user_id'] = $data_reference;
			$curlpost['api_timestamp'] = $additional_data_reference;
		}
		
		if ($data_type == 'psnGetTrophies'){
			$curlurl = $curl_base_url.'/psnGetTrophies';
			$curlpost['npcommid'] = $data_reference;
		}
		
		if ($data_type == 'psnImportUser'){
			$curlurl = $curl_base_url.'/psnImportUser';
			$curlpost['user_id'] = $data_reference;
		}
		
		if ($data_type == 'psnAuthUser'){
			$curlurl = $curl_base_url.'/psnAuthUser';
			$curlpost['user_id'] = $data_reference;
		}
		
		if ($data_type == 'psnGetGame'){
			$curlurl = $curl_base_url.'/psnGetGame';
			$curlpost['npcommid'] = $data_reference;
		}
		
		if ($data_type == 'psnListGames'){
			$curlurl = $curl_base_url.'/psnListGames';
			$curlpost['platform'] = $data_reference;
		}
		
		if ($data_type == "psnPopularThisWeek"){
			$curlurl = $curl_base_url.'/psnPopularThisWeek';
			$curlpost['list'] = "all";
		}
		
		
		
		
		if ($example){
			$curlpost['example'] = 1;
		}
		
		//$curlpost['game_image_storge_location'] = 'images/games/';
		//$curlpost['trophy_image_storge_location'] = 'images/trophies/';

			/*###########################################################################
			#																		  	#
			#	Leave blank if you would only like a URL to the online images.  Use  	#
			#	locations relative to the running script.  If locations are given,	  	#
			#	the API will attempt to save the images	on your server for you.		  	#
			#																		  	#
			#	     ** WORKS ONLY IF 'response_type' IS SET TO 'php_array' **	 	 	#
			#																		  	#
			########################################################################## */

		$curlpost['api_key'] = 'c44e28e9345840acfd4784a863e6f6fb28903b72';
		$curlpost['api_secret'] = 'blonko100';
		//$curlpost['response_type'] = 'xml';
		$curlpost['response_type'] = 'php_array';

		
			/*###########################################################################
			#																		  	#
			#     $curlpost['response_type'] = 'php_array', 'xml', or 'json'	  		#
			#																		  	#
			########################################################################## */
		
		
		if ((isset($curlurl) && isset($curlpost)) || $data_type == 'push'){
			
			if ($data_type == 'push'){
				
				$code = '200';
				$data = $data_reference['main_xml'];
				
			} else {
				$curluserpass = ('blonko100:sdlnti48lsvn');
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $curlurl);
				curl_setopt($ch, CURLOPT_TIMEOUT, 70); 
				curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3); 
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
				curl_setopt($ch, CURLOPT_POST, 1); 
				curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC); 
				curl_setopt($ch, CURLOPT_USERPWD, $curluserpass); 
				curl_setopt($ch, CURLOPT_POSTFIELDS, $curlpost); 
				$data = curl_exec($ch); 
				$code = curl_getinfo($ch, CURLINFO_HTTP_CODE); 
				curl_close($ch); 
			}
			
			if((!empty($data)) && ($code == '200')){ 
				if ($curlpost['response_type'] == 'php_array'){
					$xml = xmlstr_to_array($data);
					$xml = recursive_array_filter($xml);
					if ($data_type == 'push'){
						if (isset($data_reference['api_secret'])){
							if ($data_reference['api_secret'] != $curlpost['api_secret']){
								$xml = '';
								$xml['success'] = 0;
								$xml['error_message'] = 'Response did not contain a valid API secret.';
								return $xml;
							} else {
								ignore_user_abort(true);
								set_time_limit(0);
							}

						} else {
							$xml = '';
							$xml['success'] = 0;
							$xml['error_message'] = 'Response did not contain an API secret.';
							return $xml;
						}
					} 
					
					process_game_images($xml, $curlpost);
					
				} else {

						$xml = $data;
				}
				if(!isset($xml['success'])){
					$xml['success'] = 0;
					$xml['error_type'] = 3;
					$xml['error_message'] = 'Server returned a response but did not contain the expected data.';
				}
			} else if (($code == '200')){
				$xml['success'] = 0;
				$xml['error_type'] = 1;
				$xml['error_message'] = 'Server returned a response but the data was empty.';
			} else {
				$xml['success'] = 0;
				$xml['error_type'] = 2;
				$xml['error_message'] = 'Failed to get a response from the server.';
			}
		} else {
			$xml['success'] = 0;
			$xml['error_type'] = 5;
			$xml['error_message'] = 'No request sent because we did not understand your request.';			
		}
		
	} else {
		$xml['success'] = 0;
		$xml['error_type'] = 4;
		$xml['error_message'] = 'No request sent because we did not understand your request.';		
	}
	
	return $xml;
}

function psnGetUser($user_id, $timestamp = 0, $example = false){

	return fetch_data('psnGetUser', clean($user_id), $timestamp, $example);

}

function psnGetGame($npcommid, $example = false){

	return fetch_data('psnGetGame', clean($npcommid), false, $example);

}

function psnGetUserGames($user_id, $example = false){

	return fetch_data('psnGetUserGames', clean($user_id), false, $example);

}

function psnGetUserTrophies($npcommid, $user_id, $example = false){

	return fetch_data('psnGetUserTrophies', clean($npcommid), clean($user_id), $example);

}

function psnListGames($platform = 'all', $example = false){

	return fetch_data('psnListGames', $platform, false, $example);

}

function psnImportUser($user_id, $example = false){

	return fetch_data('psnImportUser', clean($user_id), false, $example);

}

function psnAuthUser($user_id, $example = false){

	return fetch_data('psnAuthUser', clean($user_id), false, $example);

}

function psnGetTrophies($npcommid, $example = false){

	return fetch_data('psnGetTrophies', clean($npcommid), false, $example);

}

function psnPopularThisWeek($example = false){

	return fetch_data('psnPopularThisWeek', 'all', false, $example);

}

function psnPushNotification($post_content){
	return fetch_data('push', $post_content, false);
}



/* #####################################################################################
				  Remove below this line to use this script in production
				 use include('psnAPI.php'); on any page that requires data
				   and use whatever function you need to obtain the data
   ##################################################################################### */
   
   
//echo ('<pre>');
/*
$example_username = ('blonko100');
$example_npcommid = ('NPWR00584_00');

$userdetails = psnGetUser($example_username);
//$userdetails = psnGetGame($example_npcommid);
//$userdetails = psnImportUser($example_username);
//$userdetails = psnListGames(); // Optionally pass 'ps3', ps4, or 'psp2' for specific results 
//$userdetails = psnAuthUser($example_username);
//$userdetails = psnGetTrophies($example_npcommid);
//$userdetails = psnGetUserTrophies($example_npcommid, $example_username);
//$userdetails = psnGetUserGames($example_username);
//$userdetails = psnPopularThisWeek();
//$userdetails = psnPushNotification($_POST);
print_r($userdetails);
echo ('</pre>');
*/

?>