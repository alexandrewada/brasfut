<style type="text/css">
	.conteudo {
		background-color: white;
		width: 100%;
		padding: 30px;
		display: inline-block;
	}
</style>
<form class='ajax-post' action="<?=base_url('local/cadastrarpost');?>" >
	<div class='row'>
		<div class='col-md-12'>
			<div class='conteudo'>
				<h3>Cadastrar Nova Quadra/Campo</h3>
				<hr>
				<div class='row'>
					<div class="col-md-4">
						
						<div class="form-group">
							<label>Nome do Local</label>
							<input type="text" class='form-control' placeholder="Ex: Clube Castelo Branco"  style="width: 300px;" name="nome_local">
						</div>
						
						<div class="form-group">
							<label>Modalidade</label>
							<select class='form-control' name='id_modalidade' style="width: 300px;">
								<?foreach ($listarModalidade as $key => $v):?>
								<option value="<?=$v->id_modalidade;?>"><?=$v->nome_modalidade;?></option>
								<?endforeach;?>
							</select>
						</div>
						<div class="form-group">
							<label>Digite o CEP</label>
							<input type="text" class='form-control' data-mask='00000-000' style="width: 200px;" name="cep">
						</div>
						<div class="form-group">
							<label>N° do Local</label>
							<input type="text" class='form-control' style="width: 80px;" name="numero">
						</div>
					</div>
					<div class='col-md-4'>
						<div hidden id='aposCEP'>
							<div class="form-group">
								<label>UF</label>
								<input type="text" class='form-control' style="width: 50px;" readonly name="uf">
							</div>
							
							<div class="form-group">
								<label>Cidade</label>
								<input type="text" class='form-control' style="width: 150px;" readonly  name="cidade">
							</div>
							<div class="form-group">
								<label>Bairro</label>
								<input type="text" class='form-control' style="width: 200px;"  readonly  name="bairro">
							</div>
							<div class="form-group">
								<label>Endereço</label>
								<input type="text" class='form-control' style="width: 200px;" readonly  name="endereco">
							</div>
							<div class="form-group">
							    <label>Ponto de Referência</label>
							    <input type="text" class='form-control' placeholder="Ex: Próximo a escola ETEC"  style="width: 300px;" name="nome_referencia">
						    </div>
						</div>
					</div>
				</div>
				<div class='row'>
					<div class='col-md-12 text-center'>
						<br><br>
						<div class='alert retorno'>
						</div>
						<button class='btn btn-primary' type="submit">Cadastrar Novo Local</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</form>