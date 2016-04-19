(function($) {
	$(document).ready(function(){
		$('.load-states').on('change', function(){
			alert('Carregando cidades ...')
			$city = $('.load-states').closest();
			console.log($city);
		});
	});
})(jQuery);