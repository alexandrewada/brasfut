<div class='row'>
	<div class='col-md-12'>
		<div class='conteudo'>
			<div class="row">
				<form method="GET">
					<div class="col-xs-12 col-sm-3 form-group">
						<label>Cidade</label><br>
						<select  name="cidade" class="form-control" >
							<option value="" selected="selected">Todos</option>
							<?foreach ($listarCidades as $key => $v):?>
								<option  <?=($_GET['cidade'] == $v->cidade ? 'selected' : '');?> ><?=$v->cidade;?></option>
							<?endforeach;?>
						</select>
					</div>
					<div class="col-xs-12 col-sm-3 form-group">
						<label>Modalidade</label><br>
						<select name="id_modalidade" class="form-control" >
						
							<option   value="">Todos</option>
							<?foreach ($listarModalidade as $key => $v):?>
							<option <?=($_GET['id_modalidade'] == $v->id_modalidade ? 'selected' : '');?> value='<?=$v->id_modalidade;?>'><?=$v->nome_modalidade;?></option>
							<?endforeach;?>
							
						</select>
					</div>
					<div class="col-xs-12 col-sm-4 form-group">
						<label>Local</label><br>
						<div class="input-group">
							<input type="text" name="nome_local" class="form-control" value="<?=$_GET['nome_local'];?>">
						</div>
					</div>	
					<div class="col-xs-12 col-sm-2 form-group">
						<br>
						<div class="input-group">
							<input type="submit" class="form-control" value="Buscar">
						</div>
					</div>
				</form>
			</div>
			<table class='table'>
				<thead>
					<tr>
						<td>Localização</td>
						<td>Modalidade</td>
						<td>Nome</td>
					</th>
				</thead>
				<tbody>

					
					<?foreach ($listarLocais as $key => $v):?>
					<tr>
						<td><?=$v->bairro.'/'.$v->uf.'<br>'.$v->cidade;?></td>
						<td><?=$v->nome_modalidade;?></td>
						<td><?=$v->nome_local;?></td>
					</tr>
					<?endforeach;?>
				</tbody>
			</table>
		</div>
	</div>
</div>