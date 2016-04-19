(function($) {
	$(document).ready(function(){
		$('.load-states').on('change', function(){
			alert('Carregando cidades ...')
			$city = $('.load-states').closest();
			console.log($city);
		});
		$(".input-date").mask("99/99/9999",{placeholder:"dd/mm/aaaa"});
	});
})(jQuery);