(function($){   

	jQuery.camposFocus = function(){ 
	
		$("input[type='text'], input[type='password'], textarea").focus(function(){
			$(this).addClass("inputTxt_focus");
		}).blur(function(){
			$(this).removeClass("inputTxt_focus");
		});
		
	};

})(jQuery);  