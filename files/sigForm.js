(function($) {	
	$.fn.sigForm = function(options) {

		var defaults = {
			animate:true
			},
		settings = $.extend({},defaults,options);
		if(settings.animate) {var $back = $('<div class = "contact_lightsoff"></div>').appendTo('body');}
	
		this.each(function(){
			var $this=$(this);
	
			if(settings.animate) {
				var $wrapper = $('<div class = "wrapper"/>').appendTo(this),
				 	$holder = $('<div class="form_wrapper"/>').appendTo($wrapper),
				 	$tab = $('<div class = "form_tab closed"><a href = "contact.php"></a></div>').appendTo($wrapper);
				
				$back.click(function(event){contact(event); });
				$tab.click(function(event){contact(event); });
			}
			else {var $holder = $('<div class="form_wrapper"/>').appendTo(this);}

		var	$loader = $('<div class = "form_loader"/>').appendTo($holder),
			$formHolder = $('<div class = "contact_form"/>').appendTo($holder);
			
			initAjaxForm();
				
							
			function initAjaxForm() {
				//see if form exists, and move to correct location	
			var	$form = $this.find('form').appendTo($formHolder);
				$formHolder.find('p').remove(); //remove any previous success messages.
				if($form.length>0) {
				//there is a form so remove any existing action attribute
					$form.get(0).setAttribute('action', '');
					attachFormHandlers();
				}
				else processAjaxForm(); //generate a form
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
			
			function formClick () {
				var counter=0;
				$this.find('form').fadeOut("fast");
				$loader.fadeIn("fast", function(){
			   		processAjaxForm();
				});
			}
	
			function processAjaxForm() {
				var $form = $this.find('form')
				formData = $form.serialize(); //get form data
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