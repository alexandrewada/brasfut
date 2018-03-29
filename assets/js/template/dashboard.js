$(document).ready(function(){

	$.jMaskGlobals.watchDataMask = true;

	$('[data-toggle="tooltip"]').tooltip(); 





	$("input[name='cep']").blur(function(e){

		var cep = $(this).val();



		$.get("//api.postmon.com.br/v1/cep/"+cep,function(r){

			if(r.erro == 1) {	

				$("input[name='cep']").css('border','1px solid red');

	  			$("#aposCEP").hide();

	  		// 	$("[name='uf']").val('');

	  		// 	$("[name='cidade']").val('');

	  		// 	$("[name='rua']").val('');

	  		// 	$("[name='bairro']").val('');		

	  		 } else {

	  		 	if(r.cidade == 'Hortolândia' || r.cidade == 'Sumaré'){

		  			$("input[name='uf']").val(r.estado);

		  			$("input[name='cidade']").val(r.cidade);

		  			$("input[name='endereco']").val(r.logradouro);

		  			$("input[name='bairro']").val(r.bairro);		

		  			$("#aposCEP").show("slow");

		  			$("input[name='cep']").css('border','1px solid green');

	  			} else {

	  				alert('Infelizmente, por enquanto só estamos aceitamos cadastro de novas equipes da região de Hortolândia');

					$("input[name='cep']").css('border','1px solid red');

		  			$("#aposCEP").hide();

	  			}



	  		} 

		});



	});



});