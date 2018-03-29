$(function(){
	$(".ajax-post").submit(function(e){
		e.preventDefault();

		var urlPost   = $(this).attr('action');
		var dados = $(this).serialize();

	 	$.ajax({
		 	url:urlPost,
		 	method: 'POST',
		 	data: $(".ajax-post").serialize(),
		 	complete: function(e){
				$("body").css('opacity','');
				$("button[type='submit']").show();
		 	},
		 	done: function(e){
		 		$("body").css('opacity','');
		 		$("button[type='submit']").show();
		 	},
		 	success: function(e){
		 		if(e.error == true) {
		 			$(".retorno").removeClass('alert-success').addClass('alert-danger').html("").hide().html(e.msg).show();
		 		} else if(e.error == false) {
		 			$(".retorno").removeClass('alert-danger').addClass('alert-success').html("").hide().html(e.msg).show();
		 			$(this).trigger("reset");
		 		} else {
		 			$(".retorno").removeClass('alert-success').addClass('alert-danger').html("").hide().html("Erro não conseguimos processar.").show();
		 		}

				$("body").css('opacity','');
				$("button[type='submit']").show();
		
		 	},
		 	beforeSend: function(){
		 		$("body").css('opacity','0.3');
		 		$("button[type='submit']").hide();
		 	}
		 	,
		 	fail: function(){
		 		$("body").css('opacity','');
		 		$(".retorno").removeClass('alert-danger').addClass('alert-success').html("").hide().html("Erro não conseguimos processar.").show();
		 
		 		$("button[type='submit']").show();
		 	}
		 });
	});
});