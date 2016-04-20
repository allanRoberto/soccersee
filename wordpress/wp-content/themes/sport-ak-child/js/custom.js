(function($) {
	$(document).ready(function(){
		$('.load-states').on('change', function(){
			alert('Carregando cidades ...')
			$city = $('.load-states').closest();
			console.log($city);
		});
		$('.input-cpf').mask('999.999.999-99');
		$('.input-cep').mask('99999-999');
		$('.input-number').mask('999');
		$('.input-date').mask('99/99/9999', {placeholder : 'dd/mm/aaaa'});
	});
})(jQuery);