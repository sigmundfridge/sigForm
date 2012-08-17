<?php 
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
 require_once("$root/template/head_top.php"); ?>

	<title>SigFrid | Nick Jones</title>
	<meta name="description" content="" />
	<meta name="keywords" content="" />
	<meta name="author" content="" />

<?php require_once("$root/template/scripts.php");?>
<script type="text/javascript" src="/scripts/sh/shCore.js"></script>
<script type="text/javascript" src="/scripts/sh/shAutoloader.js"></script>
<script type="text/javascript" src="/scripts/sh/shLegacy.js"></script>
<script type="text/javascript" src="/scripts/sh/shBrushJScript.js"></script>
<script type="text/javascript" src="/scripts/sh/shBrushXml.js"></script>
<script type="text/javascript" src="/scripts/sh/shBrushPhp.js"></script>
<link href="/css/shCore.css" rel="stylesheet" type="text/css" />
<link type="text/css" rel="Stylesheet" href="/css/shThemeEclipse.css"/>

<?php require_once("$root/template/head_bot.php");?>

<?php require_once("$root/template/top.php");?>
			<h2>sigForm - a jQuery/AJAX contact form</h2>
			<ul>
				<li><a href = "demo.php">Demo</li>
				<li><a href = "sigForm.zip">Download</a></li>
			</ul>
			<h3>Overview</h3>
			<p>A jQuery plugin that generates a fully Ajax-enabled and javaScript degradable form. Form validation and submission is performed server-side by PHP and accessed client-side with Ajax. Both client and server validation rely on the same PHP classes, avoiding the need for duplicate validation methods. Originally this plugin was designed for my own site, but if anyone has any ideas for future development please <a href = "/contact.php">get in contact.</a></p>
			<h3>Installation</h3>
			<p>This plugin requires PHP and jQuery. The setup involves both specifying the base PHP settings, and the runtime jQuery initialisation.</p>
			<ol>
				<li>Download the sigForm zip file and unzip it. Put the CSS folder, sigForm.js and control folder somewhere on your server.</li>
			<h4>Setting up the PHP</h4>
			<li>Initial setup requires two PHP files to be edited:
				<ul>
				<li>system.php - enter your site name and site email address (to which mail is sent)
					<pre class="brush: php">
					function getSettings() 
						{ 
							$settings['siteDir'] = null; //this isn't used
							$settings['domain'] = "http://" . $_SERVER["HTTP_HOST"]; // Root Domain - http://example.com
							$settings['siteName'] = "A Site Name";
							$settings['siteEmail'] = "me@example.com";
						return $settings; 
						}</pre>
				</li>
				<li>mailForm.php - setup all form and field settings 
					<pre class="brush: php">
						require_once('formClass.php');	
						$formParam = array(	'name'=>'', //form name e.g. 'contactForm'
											'id' => '', 'class'=>'', //form id and class
											'legend'=>'', //form legend e.g. 'This is a Contact Form'
											'method'=>'' //form submission method e.g. 'POST'
						);
	
						$formElements = array(
							array(	'name'=>'', //element name e.g. 'emailAddress'
									'label'=>'', //element label e.g. 'Enter your Email Address'
									'id'=>'','class'=>'', //element id and class
									'valTypes'=>array(), //a list of validation checks e.g. ('string','email')
									'type'=>'', //type of form element e.g. 'text' or 'textarea'
									'title'=>'', //element title
									'length'=>'', //length of element
									'size'=>''  // size of element
							),
						);</pre>
				</li>
				</ul>
			</li>
			<h4>Initialise the plugin</h4>
				<li>Get the latest version of <a href = "http://jquery.com/">jQuery</a> (or use a <a href = "http://docs.jquery.com/Downloading_jQuery#CDN_Hosted_jQuery">hosted version</a>)</li>
				<li>Include the references in the header
					<pre class="brush: html">
						&lt;head>
						...
						&lt;script type="text/javascript" src="path/to/sigForm.js">&lt;/script>
						&lt;link rel="stylesheet" type="text/css" media="all" href="path/to/sfbase.css" />
 						...
 						&lt;/head></pre>
 				</li>
 				<li>Add a container element to your page. Including the PHP code allows the initial form to be generated when the page is loaded. If it is not included the form will be loaded via Ajax.
					<pre class="brush: html">
						&lt;div id = "form_holder">
    						 &lt;?php require('control/mailForm.php') ?>
						&lt;/div></pre>
 				</li>
 				<li>Finally, initialise the plugin and pass the settings. You must specify paths to the two form processing files (working examples of these files are included in the control folder)
 					<pre class="brush: js">
						&lt;script>  
						jQuery(document).ready(function($) {
    						$('#form_holder').sigForm({
    							ajaxHandler :'path/to/control/ajaxValid.php',
								formHandler:'path/to/control/mailForm.php'
    						});		
    					});
						&lt;/script></pre>
				
				</li>
			</ol>
			<h3>What are all these files?</h3>
			<p>After unzipping the plugin zip file you'll find a number of files. The control folder holds a number of PHP files that handle server side form processing, whereas all of the jQuery (including the Ajax) is within <em>sigForm.js</em>. The PHP files are as follows (in order of inheritance):</p>
				<ul>
					<li>system.php: This contains the parent class of all other classes. It is a basic holder for all site wide information.</li>
					<li>validation.php: a formValidator class whose methods are the different validation checks (and a validation controller)</li>
					<li>formClass.php: Three classes.  <em>ajaxValidator</em> handles Ajax requests by reading in json variables, and passing them to the parent 'checkElement' method. <em>formController</em> is a generic form class that can generate a form, and validate a form (submitted via POST or Ajax). Finally, <em>mailForm</em> is a child class of formValidator, which specifically handles generating an email from a successfully validated form.</li>
					<li>mailForm.php: Simply a place to specify all of the form settings, and initialise the mailForm object.</p>
					<li>ajaxValid.php: Similarly, just a place to initialise the ajaxValidator object.</li>
				</ul>
 			<h3>Expanding the Plugin</h3>
 			<p>The plugin has so far been developed to match exactly my specification, but expanding it to add more validation checks, or form types is pretty simple</p>
			<ul>
				<li>To add more validation checks include them as methods of the formValidator object (found in <em>validation.php</em>), but remember to add a corresponding case to the checkElement method. Methods are of the form:
					<pre class="brush: php">
					function check_type($value) {
	 					// if the $value does not match filter
						if (/*This is the check of $value against something*/) {
							return array('ok' => false, 'msg' => "Your value is wrong");
						}
						else return array('ok'=>true,'value'=>$value);
					}</pre>
				</li>
				<li>To add more form controllers (i.e. to make it a 'something that is not a contact' form generator) you need to create a new class of the form
					<pre class="brush: php">
						class newFormClass extends formController {
							function __construct($form, $elements) {
								parent::__construct($form, $elements); //runs formController setup
								if(empty($this->errs) && !empty($this->submitted)){
									$send = $this->successMethod($this->values); //method to run if validation passed
								}
								elseif(!empty($this->errs)) $this->createForm($form, $elements, $this->errs,$this->values); //else show form with errors
								else $this->createForm($form, $elements); //or if first time initialising class, create the form
							}
							function successMethod($values) {	
								//use the validated form values to do something
							}
						}</pre>
				</li>
			</ul>
			<h3>Validation Checks</h3>
			<p>As the form was created as a simple mail form, there are only a limited number of validation methods. The existing validation methods are as follows:</p>
			<ul>
				<li>Required: checks the field has a value</li>
				<li>Email: checks the field against the PHP FILTER_VALIDATE_EMAIL</li>
				<li>String: returns a sanitised version of the input string</li>
			</ul>
			<h3>Future Updates</h3>
			<ul>
				<li>PRIORITY: Needs an 'animate' option so it doesn't have to pop-up</li>
				<li>Add some more initialisation options (e.g. target email)</li>
				<li>Add more validation methods</li>
				<li>Add different types of form controllers</li>
			</ul>
			<h3>License</h3>
			<p>This plugin is released under the <a href = "http://www.opensource.org/licenses/mit-license.php">MIT license</a></p> 
			<h3>Acknowledgements</h3>
			<p><a href = "http://jorenrapini.com/blog/css/jquery-validation-contact-form-with-modal-slide-in-transition">Joren Rapine</a> for the inspiration to make my form slide in. <a href = "http://www.islandsmooth.com/2010/04/send-and-receive-json-data-using-ajax-jquery-and-php/">James Drummond</a> for a nice tutorial on AJAX, jQuery and JSON. Finally, <a href = "http://www.elated.com/articles/slick-ajax-contact-form-jquery-php/">Matt Doyle</a> for another great AJAX, and jQuery contact form tutorial.</p>
			<script type="text/javascript">
     			SyntaxHighlighter.all()
			</script>
<?php require_once("$root/template/bottom.php") ?>