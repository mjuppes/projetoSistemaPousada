/*
* Price Format jQuery Plugin
* By Eduardo Cuducos
* cuducos [at] gmail [dot] com
* Version: 1.0
* Release: 2009-01-21
*/

(function($) {

	$.fn.priceFormat = function(options) {  

		var defaults = {  
			prefix: 'US$ ',
			centsSeparator: '.',  
			thousandsSeparator: ','
		};  
		var options = $.extend(defaults, options);
		
		return this.each(function() {
			
			var obj = $(this);

			function price_format () {

				// format definitions
				var prefix = options.prefix;
				var centsSeparator = options.centsSeparator;
				var thousandsSeparator = options.thousandsSeparator;
				var formatted = '';
				var thousandsFormatted = '';
				var str = obj.val();

				// skip everything that isn't a number
				// and skip left 0
				var isNumber = /[0-9]/;
				for (var i=0;i<(str.length);i++) {
					char = str.substr(i,1);
					if (formatted.length==0 && char==0) char = false;
					if (char && char.match(isNumber)) formatted = formatted+char;
				}
				
				// format to fill with zeros when < 100
				while (formatted.length<3) formatted = '0'+formatted;
				var centsVal = formatted.substr(formatted.length-2,2);
				var integerVal = formatted.substr(0,formatted.length-2);
			
				// apply cents pontuation
				formatted = integerVal+centsSeparator+centsVal;
			
				// apply thousands pontuation
				if (thousandsSeparator) {
					var thousandsCount = 0;
					for (var j=integerVal.length;j>0;j--) {
						char = integerVal.substr(j-1,1);
						thousandsCount++;
						if (thousandsCount%3==0) char = thousandsSeparator+char;
						thousandsFormatted = char+thousandsFormatted;
					}
					if (thousandsFormatted.substr(0,1)==thousandsSeparator) thousandsFormatted = thousandsFormatted.substring(1,thousandsFormatted.length);
					formatted = thousandsFormatted+centsSeparator+centsVal;
				}
				
				// apply the prefix
				if (prefix) formatted = prefix+formatted;
				
				// replace the value
				obj.val(formatted);
			
			}

			$(this).bind('keyup',price_format);
			if ($(this).val().length>0) price_format();

		});

	}; 		
		
})(jQuery);


/**
 * moeda
 * 
 * @abstract Classe que formata de desformata valores monetários em float e formata valores 
 * de float em moeda.
 * 
 * @author anselmo
 * 
 * @example 
 * 		moeda.formatar(1000) 
 *      	>> retornar 1.000,00
 * 		moeda.desformatar(1.000,00) 
 * 			>> retornar 1000
 * 
 * @version 1.0
 **/
 var moeda = {
 	
	/**
	 * retiraFormatacao
	 * 
	 * Remove a formatação de uma string de moeda e retorna um float
	 * 
	 * @param {Object} num
	 */
	 desformatar: function(num){
	 
	   num = num.replace("R$ ","");
	   
	   num = num.replace(".","");
	
	   num = num.replace(",",".");
	
	   return parseFloat(num);
	},

	/**
	 * formatar
	 * 
	 * Deixar um valor float no formato monetário
	 * 
	 * @param {Object} num
	 */
	formatar: function(num){
	   x = 0;
	
	   if(num<0){
	      num = Math.abs(num);
	      x = 1;
	   }
	
	   if(isNaN(num)) num = "0";
	      cents = Math.floor((num*100+0.5)%100);

	   num = Math.floor((num*100+0.5)/100).toString();
	
	   if(cents < 10) cents = "0" + cents;
	      for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++)
	         num = num.substring(0,num.length-(4*i+3))+'.'
	               +num.substring(num.length-(4*i+3));
	
	   ret = num + ',' + cents;
	
	   if (x == 1) ret = ' - ' + ret;return ret;
	},
	
	/**
	 * arredondar
	 * 
	 * @abstract Arredonda um valor quebrado para duas casas decimais.
	 * 
	 * @param {Object} num
	 */
	arredondar: function(num){
		return Math.round(num*Math.pow(10,2))/Math.pow(10,2);
	}
 }
 
