
<script type="text/javascript">
	$(function(){
		$("input[name='cep_responsavel']").blur(function(e){
				var cep 		= $(this).val();
				var cepObj 	 	= $(this);
				$.get('/painel/webservice/CEP/'+cep,function(r){
					if(r.erro == 1) {	
						$(cepObj).css('border','1px solid red');
			  			$("#aposCEP_responsavel").hide();
			 			$("input[name='uf_responsavel']").val('');
			  			$("input[name='cidade_responsavel']").val('');
			  			$("input[name='endereco_responsavel']").val('');
			  			$("input[name='bairro_responsavel']").val('');		
			 
			  		 } else {
			  			$("input[name='uf_responsavel']").val(r.estado);
			  			$("input[name='cidade_responsavel']").val(r.cidade);
			  			$("input[name='endereco_responsavel']").val(r.logradouro);
			  			$("input[name='bairro_responsavel']").val(r.bairro);		
			  			$("#aposCEP_responsavel").show("slow");
			  			$(cepObj).css('border','1px solid green');
			  		} 
				});

			});
	});
</script>




<form class='ajax-post'   action="<?=base_url('perfil/atualizar');?>" >
	<div class='container'>
		<div class='panel'>
			<div class='panel-body'>
				
				
				<h3 class="text-left">EDITAR DADOS PESSOAIS</h3>
				<hr>
				<div class="row">
					<div class="col-md-6">
						<div class='form-group'>
							<label>Nome do(a) responsável pelo time:</label>
							<input type="text" class='form-control' value='<?=$pessoa->nome_pessoa;?>' name="nome_responsavel">
						</div>
						<div class='form-group'>
							<label>Sexo:</label>
							<select class="form-control" name='sexo_responsavel'>
								<option value="masculino">Masculino</option>
								<option value="feminino">Feminino</option>
							</select>
						</div>
				<!-- 		<div class='form-group'>
							<label>CPF:</label>
							<input type="text" data-mask='000.000.000.00' value='<?=$pessoa->cpf;?>'  class='form-control' name="cpf_responsavel">
						</div> -->
						<div class='form-group'>
							<label>Data de Nascimento:</label>
							<input type="date" class='form-control' value='<?=$pessoa->data_nascimento;?>' name="data_nascimento_responsavel">
						</div>
						<!-- <div class='form-group'>
							<label>Email:</label>
							<input type="text" class='form-control' value='<?=$pessoa->email;?>'  name="email_responsavel" readonly="true" >
						</div> -->
						<div class='form-group'>
							<label>Alterar Minha Senha:</label>
							<input type="password" class='form-control' value='<?=$pessoa->senha;?>' name="senha_responsavel">
						</div>
					</div>
					<div class="col-md-6">
						<div class='form-group'>
							<label>Celular:</label>
							<input type="text" data-mask='(00) 00000-0000' value='<?=$pessoa->celular;?>'  class='form-control' name="celular_responsavel">
						</div>
						<div class='form-group'>
							<label>Telefone:</label>
							<input type="text" data-mask='(00) 00000-0000' value='<?=$pessoa->telefone;?>' class='form-control' name="telefone_responsavel">
						</div>
						<div class='form-group'>
							<label>CEP:</label>
							<input type="text" value='<?=$pessoa->cep;?>' data-mask='00000-000' class='form-control' name="cep_responsavel">
						</div>
						<div id='aposCEP_responsavel'>
							<div class='form-group'>
								<label>Cidade:</label>
								<input type="text" readonly="true" value='<?=$pessoa->cidade;?>' class='form-control' name="cidade_responsavel">
							</div>
							<div class='form-group'>
								<label>UF:</label>
								<input type="text" readonly="true"  value='<?=$pessoa->uf;?>' class='form-control' name="uf_responsavel">
							</div>
							<div class='form-group'>
								<label>Bairro:</label>
								<input type="text" readonly="true" class='form-control'  value='<?=$pessoa->bairro;?>' name="bairro_responsavel">
							</div>
							<div class='form-group'>
								<label>Endereço:</label>
								<input type="text" readonly="true" class='form-control' value='<?=$pessoa->rua;?>'  name="endereco_responsavel">
							</div>
							<div class='form-group'>
								<label>N° do endereço:</label>
								<input type="text"  class='form-control' name="numero_responsavel" value='<?=$pessoa->rua_numero;?>'>
							</div>
						</div>
					</div>
				</div>
				<h3 hidden class="text-left">EDITAR INFORMAÇÕES DO SEU TIME</h3>
				<hr>
				<div hidden class='row'>
					
					<div class='col-md-6'>
						
						
						
						
						<h5 class="text-center">Alterar os dias de disponibilidade de seu time.</h5>
						
		<!-- 				<div class="text-center botoes-remover" style="margin-bottom: 20px; margin-top: 10px;">
							<div style="margin-top: 24px;" onclick='$("#horarios_adicionais").html($(".clone").clone());' class="btn btn-primary">Adicionar</div>
							<div style="margin-top: 24px;" onclick='if($("#horarios_adicionais .clone").length > 0){$(".clone")[$("#horarios_adicionais .clone").length].remove();}' class="btn btn-primary">Remover</div>
						</div>
				 -->		
						<?foreach ($disponibilidades as $key => $v):?>
						<div class="clone form-group">
							<div class="col-md-4">
								<input type="hidden" name="id_disponibilidade[]" value="<?=$v->id_disponibilidade;?>">
								<label class="text-center">Dia de semana</label>
								<select name='dia_da_semana[]' class="form-control">
									<option <?=($v->id_semana == 1) ? 'selected' : '';?> value='1'>Segunda</option>
									<option <?=($v->id_semana == 2) ? 'selected' : '';?>  value='2'>Terça</option>
									<option <?=($v->id_semana == 3) ? 'selected' : '';?>  value='3'>Quarta</option>
									<option <?=($v->id_semana == 4) ? 'selected' : '';?>  value='4'>Quinta</option>
									<option <?=($v->id_semana == 5) ? 'selected' : '';?>  value='5'>Sexta</option>
									<option <?=($v->id_semana == 6) ? 'selected' : '';?>  value='6'>Sábado</option>
									<option <?=($v->id_semana == 7) ? 'selected' : '';?>  value='7' >Domingo</option>
								</select>
							</div>
							<div class="col-md-3">
								<label>Ìnicio</label>
								<input class="form-control" type="time" value="<?=$v->hora_inicio;?>" name="hora_inicio[]">
							</div>
							<div class="col-md-3">
								<label>Fim</label>
								<input class="form-control" type="time"  value="<?=$v->hora_fim;?>" name="fim_inicio[]">
							</div>
						</div>
						<?endforeach;?>
						<div id='horarios_adicionais'>
						</div>
						
					</div>
					
				</div>
				<hr>
				<div class="row">
					<div class="col-md-12">
						
						<div id='retorno' class="retorno alert">
						</div>
						
						<input type="hidden" name="id_equipe" value="<?=$equipe->id_equipe;?>">
						<input type="hidden" name="id_pessoa" value="<?=$pessoa->id_pessoa;?>">
						
						<button type="submit" class="btn btn-block btn-success btn-lg">Atualizar Informações</button>
						
					</div>
				</div>
			</div>
		</div>
	</div>
</form>