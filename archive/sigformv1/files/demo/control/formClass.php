<?php

require_once ('validation.php');

class ajaxValidator extends formValidator {

	function __construct() {
		$json = json_decode(file_get_contents("php://input"), true);
		$input = $json;
		$input['error']=false;
		$input['msg'] = $input['title'];
		$result = parent::checkElement($input['value'],$input['valTypes'],$input['id'] );
		echo json_encode($result);
	}

}

class formController extends formValidator {
	public $errs=array();
	public $values=array();
	public $submitted =false;
	
	function __construct($form, $elements){
		//basically the same, but gives mechanism to differentiate ajax/php for more complex future work
		if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest')
		{
			$this->submitted = 'ajax';
			$input = $_POST;
			$success = $this->processForm($form, $elements, $submitted, $input);
		}
		elseif(isset($_POST["submitButton"])){
			$this->submitted = 'php';
			$input = $_POST;
			$success = $this->processForm($form, $elements, $submitted, $input);
		}
	}
	
	function processForm($form, $elements, $method, $input = null) {
		foreach($elements as $name => $element){
			$result	=$this->checkElement($input[$name], $element['valTypes'], $element['id'], 1, $element['maxLength']);	
			$this->values[$name] = $result['value'];
			if(!$result['ok'])	$this->errs[$name] = $result['msg'];
		}
		return true;
	}
	
	public function createForm($form, $elements, $errors=null, $values=null) {
		echo '<form action="' . $_SERVER["REQUEST_URI"] . '" method="'.$form['method'].'" name="'.$form['name'].'" class = "'.$form['class'].'" id="'.$form['id'].'">';
		echo '<fieldset><legend>'.$form['legend'].'</legend><ul>';
		foreach($elements as $name=>$element) {
			$validation = implode(" ", $element['valTypes']);
			echo '<li><label for="'.$name.'">'.$element['label'].'</label>';			
			switch($element['type']){
				case 'text':
					echo '<input name="'.$name.'" id = "'.$element['id'].'" class ="'.$element['class'].' '.$validation.'" type = "text" size="'.$element['size'].'" maxlength="'.$element['maxLength'].'" value = "'.$values[$name].'" title = "'.$element['title'].'" />';
					break;
				case 'textarea':
					echo '<textarea name="'.$name.'" id = "'.$element['id'].'"  class ="'.$element['class'].' '.$validation.'" cols="'.$element['columns'].'" rows="'.$element['rows'].'" title = "'.$element['title'].'">'.$values[$name].'</textarea>';
					break;
			}
			if(!empty($errors[$name])) echo '<span class = "error_msg">'.$errors[$name].'</span>';
			else echo '<span class = "ok_msg"></span>';
			echo '</li>';
		}
		echo '</ul></fieldset>';
		echo '	<fieldset class="submit">
					<input name="submitButton" type="submit" value="Send Message" />
				</fieldset>
				</form>';
	}
	

}
/*
			if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
				echo 'Ajax?';
			}	
			else {
				$formValues = $_POST;
				echo 'not ajax';
			}
				echo 'not ajax';

*/
class mailForm extends formController {

	function __construct($form, $elements) {
		parent::__construct($form, $elements);
		if(empty($this->errs) && !empty($this->submitted)){
			$send = $this->sendMail($this->values);			
		}
		elseif(!empty($this->errs)) $this->createForm($form, $elements, $this->errs,$this->values);
		else $this->createForm($form, $elements);
	}
	
	function sendMail($values) {	
		$settings = $this->getSettings();
		$siteName=$settings['siteName'];
		$siteEmail=$settings['siteEmail'];
		$contactName = $values['contactName'];
		$contactEmail = $values['contactEmail'];

		$message =
		'<html>
			<head>
			<title>' . $siteName . ': Message from site</title>
			</head>
			<body>
			' . wordwrap($values['messageContent'], 70) . '
			</body>
		</html>';
		
		/*
		 * We are sending the E-mail using PHP's mail function
		 * To make the E-mail appear more legit, we are adding several key headers
		 * You can add additional headers later to futher customize the E-mail
		 */

		$to = $siteName . ' Contact Form <' . $siteEmail . '>';

		// To send HTML mail, the Content-type header must be set
		$headers = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

		// Additional Headers
		$headers .= 'From: ' . $contactName . ' <' . $contactEmail . '>' . "\r\n";
		$headers .= 'Reply-To: ' . $contactName . ' <' . $contactEmail . '>' . "\r\n";
		$headers .= 'Return-Path: ' . $contactName . ' <' . $contactEmail . '>' . "\r\n";
		$headers .= 'Date: ' . date("r") . "\r\n";
		$headers .= 'X-Mailer: ' . $siteName . "\r\n";
		
			// And now, mail it
		if (mail($to, $values['messageSubject'], $message, $headers)){
			echo '<p>Thank you for contacting ' . $siteName . '. We will read your message and contact you if necessary.</p>';
			echo  '<p>If you\'d like to send another message, please go to <a href="contact.php">our contact page</a>';
		}
		else {
			echo '<p>We weren\'t able to send your message. Please contact ' . $siteEmail . '</p>';
		}
		
	}
}
?>
