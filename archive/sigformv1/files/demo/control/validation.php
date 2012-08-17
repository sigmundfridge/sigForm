<?php

require_once ('system.php');

class formValidator extends SystemComponent {
			
	function checkElement($value, $valTypes, $fieldName, $minLength = 1, $maxLength = 32 ){	
		foreach($valTypes as $type) {
			switch($type) {
				case 'required':
					$result = $this->check_required($value,$fieldName,$minLength,$maxLength);
					break;
				case 'email':
					$result = $this->check_email($value);
					break;
				case 'string':
					$result = $this->safe_string($value);
					break;
			}
			if(!$result['ok']) break;	
		}
		return $result;
	}		
			
			
	function safe_email($email) {
		$email = filter_var($email, FILTER_SANITIZE_EMAIL);  
	}
	
    public function check_required($value, $fieldName, $min=1,$max=32) {
        if(!isset($value)||trim($value)==''||strlen($value)<$min||strlen($value)>$max) {
			if(empty($fieldName)) $fieldName = 'This field';
			return array('ok'=>false,'msg'=>$fieldName.' is required');
		}
		else return array('ok'=>true,'value'=>$value);
	}
	
	function check_email($value) {
	  // if the email does not match filter
		if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
		return array('ok' => false, 'msg' => "Your email is not valid");
		}
		else return array('ok'=>true,'value'=>$value);
	}
	
	function safe_string($string) {
	 	return array('ok'=>true, 'value'=>filter_var($string, FILTER_SANITIZE_STRING),'msg'=>'string sanitised');
	}
}
?>