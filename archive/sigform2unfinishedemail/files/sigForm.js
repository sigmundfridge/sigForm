(function($) {	
	$.fn.sigForm = function(options) {

		var defaults = {
			},
		settings = $.extend({},defaults,options);
		$back = $('<div id = "contact_lightsoff"></div>').appendTo('body')
	
		var scriptSource = (function(scripts) {
   			 var scripts = document.getElementsByTagName('script'),
    	    script = scripts[scripts.length - 2];

	    	if (script.getAttribute.length !== undefined) {
	    	    return script.src
    		}
	
	    	return script.getAttribute('src', -1)
		}());
		
		this.each(function(){
			var $this=$(this),
			$wrapper = $('<div id = "wrapper"/>').appendTo($this),
			$holder = $('<div id="form_wrapper"/>').appendTo($wrapper),
			$tab = $('<div id = "form_tab" class = "closed"><a href = "contact.php"></a></div>').appendTo($wrapper)
			$loader = $('<div class = "form_loader"/>').appendTo($holder)
			$formHolder = $('<div id = "contact_form"/>').appendTo($holder)
			
			$back.click(function(event){tabClose(); });
			$tab.click(function(event){contact(event); });
			
			initAjaxForm();
				
			//see if form exists, and move to correct location	
							
			function initAjaxForm() {
				$form = $this.find('form').appendTo($formHolder);
				$formHolder.find('p').remove(); //remove any previous success messages.
				// blank for now, but loop for removing existing forms and puttin in AJAX gen'd one.
				//if(false) {
				if($form.length>0) {
				//there is a form
					$form.get(0).setAttribute('action', ''); //this works
				}
				else processAjaxForm();
				//}
				attachFormHandlers();
				return $form
			}	
			
			function contact(ev) {
				ev.preventDefault();
   				$tab.toggleClass('open').toggleClass('closed');
				if ($holder.is(":hidden"))	tabOpen();
  				else tabClose();
			}
			
			function tabOpen(){
				$holder.slideDown("slow");
				$back.css({"opacity": "0.7"}).fadeIn("slow");
  				initAjaxForm();
			}
			
			
			function tabClose() {	
				$holder.slideUp("slow");
   				$back.fadeOut("slow"); 
			}
			
			function processAjaxForm() {
				$form = $this.find('form')
				formData = $form.serialize();
				sendParams = {email:'soggytaxi@example.co.uk', example:'ec'}}
				formData = sendParams.serializeArray();
				$.ajax({
 					type: 'POST',
			  		url:settings.formHandler,
  					data: formData,
  					success:function(result) {
		   					$loader.fadeOut("fast", function(){
		   					$form.remove(); //remove submitted form
							$formHolder.append(result);
							attachFormHandlers();
		   				});
					}
				});
			}
			
			function attachFormHandlers() {
				$form = $this.find('form')
				if ($form.length > 0){
					if (document.getElementsByTagName){ //make sure were on a newer browser
						var objInput = $form.find(':input:not(:submit)');
						for (var iCounter=0; iCounter<objInput.length; iCounter++){
							objInput[iCounter].onblur=function(){validateMe(this)} //attach the onchange to each input field
						}
						$form.get(0).setAttribute('action', ''); //this works
						$form.unbind('submit');
						$form.submit(function(){formClick();  return false;}) //attach validate() to the form
					}
				}
			}	
			
			function formClick () {
				var counter=0;
				$this.find('form').fadeOut("fast");
				$loader.fadeIn("fast", function(){
			   		processAjaxForm();
				});
			}
			function validateMe(objInput) {

				var JSONObj = new Object;
				JSONObj.value = $(objInput).val();
				var valTypes = $(objInput).attr('class').split(' ');
				valTypes = valTypes.filter(function(e){return e});
				JSONObj.valTypes = valTypes;
				JSONObj.title = $(objInput).attr('title');
				JSONObj.name = $(objInput).attr('name');
				JSONObj.id = $(objInput).attr('id');
				JSONObj.method = 'ajaxValidate';

				$.ajax({
					type: "POST",  
					url:settings.ajaxHandler, 
					data: JSON.stringify(JSONObj), 
					processData:false,
					dataType:'json',
					beforeSend: function(x) {if(x && x.overrideMimeType) {x.overrideMimeType("application/json;charset=UTF-8");}},
					success:function(result) {
					if ($(objInput).siblings('span').length > 0){
  						$(objInput).siblings('span').remove()
					}
					if(!result.ok) {
						$(objInput).parent().append('<span class = "error_msg">'+result.msg+'</span>');
					}
					else{
						$(objInput).parent().append('<span class = "ok_msg"></span>');
					}
				},
  				error:function() {}    
  				});
			}
		});
				
	return this;
	}	
})(jQuery);