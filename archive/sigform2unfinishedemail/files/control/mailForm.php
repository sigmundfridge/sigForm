<?php
	require_once('formClass.php');
	
	$formParam = array('name'=>'', 'id' => '', 'class'=>'', 'legend'=>'', 'method'=>'');
	
	$formElements = array(
		array('name'=>'','label'=>'','id'=>'','class'=>'','valTypes'=>array(),''=>'','type'=>'','title'=>'','length'=>'','size'=>''),	
	);
	
	$form = new mailForm($formParam, $formElements);	
?>