$(function(){
	$('.opcion').hide('1000'); //modificacion por sebas
	var valor = $('.filtro').attr('nombre');
	//$('.opcion').not('.'+valor).hide('1000');
	$('.opcion').filter('.'+valor).show('1000');
	console.log('Inicio');

	$('.filtro').click(function(){
		$(this).addClass('activo').siblings().removeClass('activo');
		var valor = $(this).attr('nombre');
		console.log(valor);
		$('.opcion').not('.'+valor).hide('1000');
		$('.opcion').filter('.'+valor).show('1000');

		/*
		if( valor == 'todos'){
			$('.cont-trabajos').show();
		}else{
			$('.cont-trabajos').not('.'+valor).hide('1000');
			$('.cont-trabajos').filter('.'+valor).show('1000');
		}
		*/
	});
});