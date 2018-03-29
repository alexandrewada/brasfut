<!DOCTYPE html>
<html lang="pt">
	<head>
		<meta charset="utf-8">
		<meta name="viewport"
		content="width=device-width, initial-scale=1, user-scalable=yes">
		<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
		<script src="//code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
		<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
		<script src="<?=base_url('assets/js/utilidades/ajax.js');?>" type="text/javascript"></script>
		<script src="<?=base_url('assets/js/utilidades/mask.js');?>" type="text/javascript"></script>
		<script src="<?=base_url('assets/js/template/dashboard.js');?>" type="text/javascript"></script>
		<link rel="stylesheet" type="text/css" href="<?=base_url('');?>">
		<script src='//www.google.com/recaptcha/api.js'></script>
		<title><?=(empty($title)) ? 'Brasfut @ Gerenciador de jogos.' : $title;?></title>
		<script type="text/javascript">
		var base_url = '<?=base_url();?>';
		$(function(){
		atualizarLocais = function(){
		var id_modalidade = $("select[name='id_modalidade']").val();
		$.get('/painel/local/listarlocalmodalidade/'+id_modalidade,function(e){
		$("select[name='local_existente']").html(e);
		});
		}
		$("input[name='nome_local_existente']").on('input',function(e){
		});
		$("select[name='id_modalidade']").change(function(){
		atualizarLocais();
		});
		$("select[name='tipo']").change(function(){
		var valor = $(this).val();
		switch(valor){
		case '1':
		atualizarLocais();
		$("#mostrarMandante").show();
		$(".botoes-remover").hide();
		break;
		case '3':
		$("#mostrarMandante").show();
		$(".botoes-remover").show();
		break;
		case '2':
		$("#mostrarMandante").hide();
		$(".botoes-remover").show();
		break;
		}
		});
		$("input[name='cep_responsavel']").blur(function(e){
			var cep 		= $(this).val();
			var cepObj 	 	= $(this);
			$.get('http://api.postmon.com.br/v1/cep/'+cep,function(r){
				if(r.erro == 1) {
					$(cepObj).css('border','1px solid red');
					$("#aposCEP_responsavel").hide();
					$("input[name='uf_responsavel']").val('');
					$("input[name='cidade_responsavel']").val('');
					$("input[name='endereco_responsavel']").val('');
					$("input[name='bairro_responsavel']").val('');
				
				} else {
					if(r.cidade == 'Hortolândia' || r.cidade == 'Sumaré'){
						$("input[name='uf_responsavel']").val(r.estado);
						$("input[name='cidade_responsavel']").val(r.cidade);
						$("input[name='endereco_responsavel']").val(r.logradouro);
						$("input[name='bairro_responsavel']").val(r.bairro);
						$("#aposCEP_responsavel").show("slow");
						$(cepObj).css('border','1px solid green');
					} else {
						alert('Infelizmente, por enquanto só estamos aceitamos cadastro de novas equipes da região de Hortolândia/Sumaré');
						$("input[name='cep_responsavel']").css('border','1px solid red');
		  				$("#aposCEP_responsavel").hide();
					}
				}
			});
		});
		$("input[name='cep_local_mandante']").blur(function(e){
		var cep 		= $(this).val();
		var cepObj 	 	= $(this);
		$.get('http://api.postmon.com.br/v1/cep/'+cep,function(r){
		if(r.erro == 1) {
		$(cepObj).css('border','1px solid red');
		$("#aposCEP_mandante").hide();
		$("input[name='uf_mandante']").val('');
		$("input[name='cidade_mandante']").val('');
		$("input[name='endereco_mandante']").val('');
		$("input[name='bairro_mandante']").val('');
		
		} else {
		$("input[name='uf_mandante']").val(r.estado);
		$("input[name='cidade_mandante']").val(r.cidade);
		$("input[name='endereco_mandante']").val(r.logradouro);
		$("input[name='bairro_mandante']").val(r.bairro);
		$("#aposCEP_mandante").show("slow");
		$(cepObj).css('border','1px solid green');
		}
		});
		});
		});
		</script>
	</head>
	<body>
		<form class='ajax-post'  enctype="multipart/form-data" action="<?=base_url('equipe/cadastrar');?>" >
			<div class='container'>
				<div class='panel'>
					<div class='panel-body'>
						<div class="text-center" style="margin-top: 20px; margin-bottom: 20px;">
							<img src='/logo-brasfut.png'/><br>
							<h1>CADASTRO DE FILIAÇÃO</h1>
							<hr>
						</div>
						<div class="alert alert-danger">
                         <p>ATENÇÃO: Olá! Por enquanto o cadastro está liberado apenas para cidade de Hortolândia e Sumaré/SP. Em breve estará disponível para as outras regiões</a>.
					    	</p></div>
						<div class="alert alert-info">
                         <p>Antes de realizar seu cadastro, recomendamos que leia o <a target="_BLANK" href="http://www.ligabrasfut.com.br/regulamento">Regulamento do Brasfut</a>.
					    	</p></div>
					    	<hr>
						
						<h3 class="text-left">DADOS PESSOAIS</h3>
						<hr></p>
					  </div>
					  <div class="row">
						<div class="col-md-6">
							<div class='form-group'>
								<label>Nome do(a) responsável pelo time:</label>
								<input type="text" class='form-control' name="nome_responsavel">
							</div>
							<div class='form-group'>
								<label>Sexo:</label>
								<select class="form-control" name='sexo_responsavel'>
									<option value="masculino">Masculino</option>
									<option value="feminino">Feminino</option>
								</select>
							</div>
							<div class='form-group'>
								<label>CPF:</label>
								<input type="text" data-mask='000.000.000.00'  class='form-control' name="cpf_responsavel">
							</div>
							<div class='form-group'>
								<label>Data de Nascimento:</label>
								<input type="date" class='form-control' name="data_nascimento_responsavel">
							</div>
							<div class='form-group'>
								<label>Email:</label>
								<input type="text" class='form-control' name="email_responsavel">
							</div>
							<div class='form-group'>
								<label>Senha:</label>
								<input type="password" class='form-control' name="senha_responsavel">
							</div>
						</div>
						<div class="col-md-6">
							<div class='form-group'>
								<label>Celular:</label>
								<input type="text" data-mask='(00) 00000-0000'  class='form-control' name="celular_responsavel">
							</div>
							<div class='form-group'>
								<label>Telefone:</label>
								<input type="text" data-mask='(00) 0000-0000' class='form-control' name="telefone_responsavel">
							</div>
							<div class='form-group'>
								<label>CEP:</label>
								<input type="text" data-mask='00000-000' class='form-control' name="cep_responsavel">
							</div>
							<div hidden id='aposCEP_responsavel'>
								<div class='form-group'>
									<label>Cidade:</label>
									<input type="text" readonly="true" class='form-control' name="cidade_responsavel">
								</div>
								<div class='form-group'>
									<label>UF:</label>
									<input type="text" readonly="true" class='form-control' name="uf_responsavel">
								</div>
								<div class='form-group'>
									<label>Bairro:</label>
									<input type="text" readonly="true" class='form-control' name="bairro_responsavel">
								</div>
								<div class='form-group'>
									<label>Endereço:</label>
									<input type="text" readonly="true" class='form-control' name="endereco_responsavel">
								</div>
								<div class='form-group'>
									<label>N° do Endereço:</label>
									<input type="text"  class='form-control' name="numero_responsavel">
								</div>
							</div>
						</div>
					</div>
					<hr>
					<h3 class="text-left">INFORMAÇÕES DO SEU TIME</h3>
					<hr>
					<div class='row'>
						
						<div class='col-md-6'>
							
							<div class='form-group'>
								<label>Nome da Equipe:</label>
								<input type="text" class='form-control'  name="nome_equipe">
							</div>
							<div class='form-group'>
								<label>Data da Fundação:</label>
								<input type="date" class='form-control' name="data_fundacao" >
							</div>
							<div class='form-group'>
								<label>Modalidade:</label>
								<select class='form-control' name='id_modalidade' >
									<?foreach ($listarModalidade as $key => $v):?>
									<option value="<?=$v->id_modalidade;?>"><?=$v->nome_modalidade;?></option>
									<?endforeach;?>
								</select>
							</div>
							<div class='form-group'>
								<label>Sexo:</label>
								<select class="form-control" name='sexo_equipe'>
									<option value="masculino">Masculino</option>
									<option value="feminino">Feminino</option>
								</select>
							</div>
							<div class='form-group'>
								<label>Categoria:</label>
								<select class='form-control' name='id_categoria' >
									<?foreach ($listarCategoria as $key => $v):?>
									<option value="<?=$v->id_categoria;?>"><?=$v->nome_categoria;?></option>
									<?endforeach;?>
								</select>
							</div>
							<!-- 			<div class='form-group'>
									<label>Escudo do time:</label>
									<input type="file"  class="form-control" name="logo_time">
							</div>
							-->
						</div>
						<div class='col-md-6'>
							
							<div class='form-group'>
								<label>Cores do Uniforme:</label>
								<input type="text" placeholder="Ex: Azul, Branco e Verde" class='form-control' name="cores">
							</div>
							
							<div class='form-group' hidden>
								<div class="alert alert-info">
									<b>Mandante:</b> Possui local de jogo, dia da semana e horário fixo.<br><b>Visitante:</b> Não possui local de jogo podendo jogar qualquer dia e hora.
								</div>
								<label>O seu time tem um local de jogo fixo?</label>
								<select class='form-control' name='tipo'>
									<option value="1">Sim, eu tenho local, dia e horário fixo reservado</option>
									<option value="2" selected="" >Não, eu sou visitante.</option>
									<option value="3" >Ambos.</option>
								</select>
							</div>
							
							<div id='mostrarMandante'>
								
								<div class="form-group" id='removerLocalNovo' hidden>
									<label>Selecione um local existente:</label>
									<select name='local_existente' class="form-control">
										
									</select>
									<span>não encontrou o local? <a onclick="if(confirm('Tem certeza que deseja criar um novo local') == true) { $('.criarNovoLocal').toggle();$('#removerLocalNovo').remove();}">clique aqui para criar um local</a></span>
								</div>
								<div class='criarNovoLocal' hidden>
									<hr>
									<h4>Crie um novo local</h4>
									<div class="form-group">
										<label>Nome do local:</label>
										<input type="text" class="form-control" name="nome_local_mandate"/>
									</div>
									
									<div class="form-group">
										<label>Modalidade do local:</label>
										<select class='form-control' name='id_modalidade_mandante' >
											<?foreach ($listarModalidade as $key => $v):?>
											<option value="<?=$v->id_modalidade;?>"><?=$v->nome_modalidade;?></option>
											<?endforeach;?>
										</select>
									</div>
									
									<div class="form-group">
										<label>CEP do local:</label>
										<input type="text" data-mask='00000-000' class="form-control" style="width: 150px;" name="cep_local_mandante"/>
									</div>
									
									<div hidden id='aposCEP_mandante'>
										<div class='form-group'>
											<label>Cidade:</label>
											<input type="text" readonly="true" class='form-control' name="cidade_mandante">
										</div>
										<div class='form-group'>
											<label>UF:</label>
											<input type="text" readonly="true" class='form-control' name="uf_mandante">
										</div>
										<div class='form-group'>
											<label>Bairro:</label>
											<input type="text" readonly="true" class='form-control' name="bairro_mandante">
										</div>
										<div class='form-group'>
											<label>Endereço:</label>
											<input type="text" readonly="true" class='form-control' name="endereco_mandante">
										</div>
										<div class='form-group'>
											<label>N° do endereço:</label>
											<input type="text"  class='form-control' name="numero_mandante">
										</div>
									</div>
								</div>
								
							</div>
							
					<!-- 		<hr>
							<h5 class="text-center" >Informe os dias e horários da semana que sua equipe tem disponibilidade para jogar</h5>
							
							<div class="text-center botoes-remover" style="margin-bottom: 20px; margin-top: 10px;">
								<div style="margin-top: 24px;" onclick='$("#horarios_adicionais").html($(".clone").clone());' class="btn btn-primary">Adicionar</div>
								<div style="margin-top: 24px;" onclick='if($("#horarios_adicionais .clone").length > 0){$(".clone")[$("#horarios_adicionais .clone").length].remove();}' class="btn btn-primary">Remover</div>
							</div>
							
							<hr>
							<div class="clone form-group">
								<div class="col-md-4">
									<label class="text-center">Dia de semana</label>
									<select name='dia_da_semana[]' class="form-control">
										<option value='1'>Segunda</option>
										<option value='2'>Terça</option>
										<option value='3'>Quarta</option>
										<option value='4'>Quinta</option>
										<option value='5'>Sexta</option>
										<option value='6'>Sábado</option>
										<option value='7' >Domingo</option>
									</select>
								</div>
								<div class="col-md-3">
									<label>Ìnicio</label>
									<input class="form-control" type="time" name="hora_inicio[]">
								</div>
								<div class="col-md-3">
									<label>Fim</label>
									<input class="form-control" type="time" name="fim_inicio[]">
								</div>
							</div>
							<div id='horarios_adicionais'>
							</div>
					 -->		
						</div>
						
					</div>
					<hr>
					<div class="row">
						<div class="col-md-12">
							<div class='alert alert-info'>
							<input type='checkbox' name='concordo'> Li e concordo com o regulamento da Brasfut</p>
						</div>
						<div id='retorno' class="retorno alert">
						</div>
						<div class="g-recaptcha" data-sitekey="6LcXvhkUAAAAADBRiiy5FdBgE9VG88w_nrMxejdu"  style="
							margin: 0 auto;
						width: 30%;""></div>
						<hr>
						<button type="submit" class="btn btn-block btn-success btn-lg">Cadastrar Meu Time</button>
						<hr>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>
<script type="text/javascript">
$(function(){
modalAjax = function(url) {
$.get(url,function(e){
$(".modal-body").html("").html(e);
$('.modal').modal('show');
});
}
});
</script>

</body>
</html>