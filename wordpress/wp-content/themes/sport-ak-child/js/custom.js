(function($) {
    $(function() {
    	$(document).ready(function() {
	    	$('.next-step').click(function(){
	    		e.preventDefault();
	    	});
	    	
	    	$('#um_form_dadospessoais').submit(function() {
	    		alert('test');
	    		var link_tab = $('li.vc_tta-tab a[href*="dados-especificos"]');

	    		link_tab.trigger('click');

	    	});
    	});
    });
})(jQuery);