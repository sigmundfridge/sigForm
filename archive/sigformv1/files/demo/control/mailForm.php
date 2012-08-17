<?php
	require_once('formClass.php');
	$formParam = array('name'=>'contactForm', 'id' => 'aj_form', 'class'=>'contact', 'legend'=>'Via email', 'method'=>'post');
	
	$formElements = array(
		'contactName'=>		array('label'=>'Name',	'id'=>'Name',	'class'=>'',	'valTypes'=>array('string'),'type'=>'text','title'=>'Enter your name','maxLength'=>'100','size'=>'20'),	
		'contactEmail'=>	array('label'=>'E-Mail<span class = "required">*</span>',	'id'=>'Email',	'class'=>'',	'valTypes'=>array('required', 'email'),	'type'=>'text',	'title'=>'Enter a valid email',	'maxLength'=>'100',	'size'=>'20'),	
		'messageSubject'=>	array('label'=>'Subject',	'id'=>'Subject','class'=>'','valTypes'=>array('string'),'type'=>'text','title'=>'Enter a subject for your message','maxLength'=>'100','size'=>'20'),	
		'messageContent'=>	array('label'=>'Your Message<span class = "required">*</span>',	'id'=>'Comment',	'class'=>'',	'valTypes'=>array('required','string'),	'type'=>'textarea',	'title'=>'Enter your comment',	'columns'=>'35','rows'=>'8','maxLength'=>'10000')
//		array('name'=>'','label'=>'','id'=>'','class'=>'','valTypes'=>array(),''=>'','type'=>'','title'=>'','length'=>'','size'=>''),	
	);
/*	$formParam = array('name'=>'', 'id' => '', 'class'=>'', 'legend'=>'', 'method'=>'');
	
	$formElements = array(
//		array('name'=>'','label'=>'','id'=>'','class'=>'','valTypes'=>array(),''=>'','type'=>'','title'=>'','length'=>'','size'=>''),	
	);
*/	
	$form = new mailForm($formParam, $formElements);	
?>