<script>
	$(function(){
		$("select[name='privado']").change(function(){
		  var v = $("select[name='privado'] option:selected").val();

		  if(v == 0) {
		   $("select[name='id_equipes_convidadas[]']").attr('disabled',true);
		  } else {
		    $("select[name='id_equipes_convidadas[]']").attr('disabled',false);
		  }

		});	
	});
</script>


<style type="text/css">
	.conteudo {
		background-color: white;
		width: 100%;
		padding: 30px;
		display: inline-block;
	}
</style>
<form class='ajax-post' action="<?=base_url('partida/agendarpost');?>" >
	<div class='row'>
		<div class='col-md-12'>
			<div class='conteudo'>
	<!-- 			<h3>Informações importantes</h3>
				<hr>
				<div class='alert alert-danger'>
					<ul>
						<li></li>
					</ul>
				</div> -->
				<h3>Criar Novo Jogo</h3>
				<hr>
				<div class='row'>
				<div class="col-md-6">
	
					<div class="form-group">
						<label>Qual é o local do jogo reservado para o seu time?</label>
						<select class='form-control' name='id_local'>
							<?foreach ($listarLocal as $key => $v):?>
							<option value='<?=$v->id_local;?>'><?=strtoupper($v->nome_local);?> # <?=strtoupper($v->cidade).' / '.strtoupper($v->bairro);?></option>
							<?endforeach;?>
						</select>
						<span style="font-size: 10px;">Não encontrou o local desejado? <a  target='_BLANK' href='<?=base_url("local/cadastrar");?>'>Clique aqui para adicionar um novo local</a></span>
					</div>
					<div class="form-group">
						<label data-toggle='tooltip' title='Partida PÚBLICA significa que qualquer equipe pode visualizar sua partida e e aceitar o seu convite. Partida PRIVADA apenas as equipes que você selecionar receberão o convite' >Sua partida será pública ou privada?</label>
						<select name='privado' id='privado' class="form-control">
							<option value=''>Selecione uma opção</option>
							<option value='1'>Privada, somente as equipes que eu convidar receberão o convite.</option>
							<option value='0'>Pública, minha partida ficará disponível para qualquer equipe.</option>
						</select>
					</div>
					<div class="form-group">
						<div class='col-md-6' style="padding-left: 0px;">
							<labeL>Data do Jogo</labeL>
							<input class='form-control' type="date"  value='<?=date('Y-m-d');?>' name="data" >
						</div>
						<div class='col-md-3'>
							<labeL class='text-center'>Começa às</labeL>
							<input type="time" name='inicio' value='<?=date('H:00',strtotime('+1 hour'));?>' class='form-control'>
						</div>
						<div class='col-md-3'>
							<labeL class='text-center'>Termina às</labeL>
							<input type="time" name='fim' value='<?=date('H:00',strtotime('+2 hour'));?>' class='form-control'>
						</div>
					</div>

					
				</div>
				<div class='col-md-6'>
					
					<div class="form-group">
						<label data-toggle='tooltip' title='Aqui você pode escolher qual equipe deseja convidar. Para selecionar múltiplas equipes, segure a tecla CTRL e em seguida vá clicando nas equipes '>Selecione as equipes que deseja convidar caso seja partida privada.</label>
						<select class="form-control" name='id_equipes_convidadas[]' multiple="" style="height: 200px;">
							<?foreach ($listarEquipes as $key => $v):?>
								<?if($v->id_equipe == $this->session->userdata('id_equipe')) {continue;};?>
								<option value="<?=trim($v->id_equipe);?>"><?=$v->nome_equipe;?> - <?=strtoupper($v->cidade .' - '.$v->uf.' - '.$v->bairro);?></option>
							<?endforeach;?>
						</select>
					</div>
				</div>

				</div>

				<div class='row'>
					<div class='col-md-12 text-center'>
						<br><br>
						<div class='alert retorno'>
						</div>
						<button class='btn btn-primary' type="submit">Criar Novo Jogo</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>