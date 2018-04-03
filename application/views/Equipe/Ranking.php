<div class='row'>
	<div class='col-md-12'>
		<div class='conteudo'>
			<div class="row">
				<form method="GET">
					<div class="col-xs-12 col-md-3 col-sm-4 form-group">
						<label>Equipe</label><br>
							<input type="text" name="equipe_nome" class="form-control" value="<?=$_GET['equipe_nome'];?>">
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

					<div class="col-xs-12 col-sm-3 form-group">
						<label>Categoria</label><br>
						<select name="id_categoria" class="form-control" >
						
							<option   value="">Todos</option>
							<?foreach ($listarCategorias as $key => $v):?>
							<option <?=($_GET['id_categoria'] == $v->id_categoria ? 'selected' : '');?> value='<?=$v->id_categoria;?>'><?=$v->nome_categoria;?></option>
							<?endforeach;?>
							
						</select>
					</div>
					<div class="col-xs-12 col-sm-3 col-md-1 form-group">
						<label>Estado</label><br>
						<select  name="estado" class="form-control" >
							<option value="" selected="selected">Todos</option>
							<?foreach ($listarEstados as $key => $v):?>
								<option  <?=($_GET['estado'] == $v->uf ? 'selected' : '');?> ><?=$v->uf;?></option>
							<?endforeach;?>
						</select>
					</div>
					<div class="col-xs-12 col-sm-3 form-group">
						<label>Cidade</label><br>
						<select  name="cidade" class="form-control" >
							<option value="" selected="selected">Todos</option>
							<?foreach ($listarCidades as $key => $v):?>
								<option  <?=($_GET['cidade'] == $v->cidade ? 'selected' : '');?> ><?=$v->cidade;?></option>
							<?endforeach;?>
						</select>
					</div>
					
			</div>
			<div class='text-center'>
				<input class='btn btn-primary' style="margin-top: 5px;" type="submit" class="form-control" value="Filtrar Ranking">
			</div>
							</form>

			<hr>
		<?if(count($ranking) > 0):?>
	
			<h4 class='text-left'>Ranking Geral</h4>
			
			<table class='table'>
				<thead>
					<tr>
						<td>Pos</td>
						<td>Equipe</td>
						<td>Pontos</td>
						<td>Modalidade</td>
						<td>Categoria</td>
						<td>Localização</td>
					</th>
				</thead>
				<tbody>
					<?foreach ($ranking as $key => $v):?>
					<tr>
						<td><?=$key+1;?>° </td>
						<td> <a target="_BLANK" href='<?=base_url('equipe/detalhes/'.$v->id_equipe);?>'>
								<img width="32" height="32" src='<?=$v->logo;?>'/>  
							
								<?=$v->nome_equipe;?>
									
							</a>
						</td>
						<td><?=($v->pontos) ? $v->pontos : 0;?></td>
						<td><?=$v->nome_modalidade;?></td>
						<td><?=$v->nome_categoria;?></td>
						<td><?=$v->bairro.' / '.$v->uf.'<br>'.$v->cidade;?></td>
					</tr>
					<?endforeach;?>
				</tbody>
			</table>
			<?else:?>
				<h2 class="text-center">Nenhuma equipe encontrada.</h2>
			<?endif;?>
	
		</div>
	</div>
</div>