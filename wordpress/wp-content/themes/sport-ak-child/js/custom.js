(function($) {
    $(function() {
    	$(document).ready(function() {
	    	$('.next-step').click(function(){
	    		e.preventDefault();
	    	});

	    	var form_data = {};
		    
		    $('#sui_upload_image_form').find('input').each(function(){
		        form_data[this.name] = $(this).val();
		    });

		    $('#sui_upload_image_form').ajaxForm({
		    	url: ajaxurl,
		    	data: form_data,
		    	type: 'POST',
		    	contentType: 'multipart/form-data',
		        success: function(response){
		            alert(response);
		        }
		    });
		});
    });
})(jQuery);