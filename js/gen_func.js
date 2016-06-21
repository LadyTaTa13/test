$(document).ready(function() {
	$('#loading').displayAtCenter();
	precall({method:'form_login',output:'html',display:'showData'});
});

(function($) {
	
	$.fn.bindAutoComplete = function(o) { 
	 	
		var source=o.data;
		return this.each(function() {


			$(this).autocomplete(
			{
					selectFirst: true,
					source:o.data,
					dataType: 'json',
					highlight: false,
					scroll: true,
					scrollHeight: 300,
					width:300,
					minLength: 0,                           
					select: function( event, ui ) {
							$('#'+o.p.obj_value).val(ui.item.id);
							$(this).val(ui.item.value);
							
							if(o.p.callback===undefined){
								return false;
							}else{
								eval(o.p.callback(ui.item));
							}
					}
			});
			$(this).click(function(){
				$(this).val('').autocomplete("search","");	
			});
			$(this).addClass('txt-autocomplete');
		});
	 
	}
	
	
	$.fn.displayAtCenter = function(options) {
	 
		  return this.each(function() {
		
			var _obj_w=parseFloat($(this).css('width'))*0.5;
			var _obj_h=parseFloat($(this).css('height'))*0.5;
			var _l=(parseFloat(screen.width)*0.5)-_obj_w;
			var _t=(parseFloat(screen.height)*0.5)-_obj_h;	
			$(this).css({left:_l,top:_t});
		
		});
	  
	}	
 
})(jQuery);