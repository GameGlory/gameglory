<?php
	class Error{
		
		private $errors = array("addgamer" => array());
		
		public function __contruct(){
			
		}
		public function addError($type,$error){
			
			foreach($this->errors as $key => $value){
				if($type == $key){
					array_push($value,$error);
					break;
				}
			}
		}
		public function getError(){
			$error = null;
			foreach ($this->errors as $key => $value) {
				if(!empty($value)){
					for($i = 0; $i < count($value); $i++){
						$error = $value[$i];
						break;
					} 
					break;
				}
			}
			return $error;
		}
		///end of class///////
	}
	
	
?>