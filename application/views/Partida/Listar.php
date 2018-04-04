<link rel="stylesheet" type="text/css" href="<?=base_url('assets/css/partida/listar.css');?>">
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
					<div class="col-xs-12 col-sm-3 form-group">
						<label>Locais</label><br>
						<select name="id_local" class="form-control" >
							
							<option   value="">Todos</option>
							<?foreach ($listarLocais as $key => $v):?>
							<option <?=($_GET['id_local'] == $v->id_local ? 'selected' : '');?> value='<?=$v->id_local;?>'><?=$v->nome_local;?></option>
							<?endforeach;?>
							
						</select>
					</div>
					<div class="col-xs-12 col-sm-3 col-md-2 form-group">
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
					<input class='btn btn-primary' style="margin-top: 5px;" type="submit" class="form-control" value="Filtrar Partidas">
				</div>
			</form>
			<hr>
			<?if(count($partidas) > 0):?>
			
			<h4 class='text-left'>Lista de Partidas</h4>
			
			<table class='table'>
				<thead>
					<tr>
						<td>Data</td>
						<td>Equipe</td>
						<td>Informações</td>
					</th>
				</thead>
				<tbody>
					<?foreach ($partidas as $key => $v):?>
					<tr>
						<td class='lista-convites'>
							<li >
								<a target="_BLANK" href="http://127.0.0.1/brasfut/partida/detalhes/24">
									<div class="box-calendario">
										<span class="mes"><?=date('M',strtotime($v->data_inicio));?></span>
										<span class="dia"><?=date('d',strtotime($v->data_inicio));?></span>
										<span class="semana" style="
    font-size: 10px;
"><?=date('l',strtotime($v->data_inicio));?></span>
								
										<span class="hora_comeca"><b style="color: green;"><?=date('H:i',strtotime($v->data_inicio));?></b>~<b style="color:red;"><?=date('H:i',strtotime($v->data_fim));?></b></span>
									</div>
								</a>
							</li>
						</td>
						<td style="vertical-align: middle;"> 
							<a target="_BLANK" href='<?=base_url('equipe/detalhes/'.$v->id_equipe);?>'>
							<img width="50" src='<?=$v->logo;?>'/>
		
							<?=$v->nome_equipe;?>
							
						</a>
					</td>

					<td style="vertical-align: middle;"><?= '<b>Local: </b>'.$v->nome_local .'<br><b>Modalidade: </b>'.$v->nome_modalidade.' <br> <b>Cidade: </b>'.$v->cidade.' / '.$v->uf.'<br> <b>Bairro: </b>'.$v->bairro;?></td>
				</tr>
				<?endforeach;?>
			</tbody>
		</table>
		<?else:?>
		<h2 class="text-center">Nenhuma partida encontrada.</h2>
		<?endif;?>
		
	</div>
</div>
</div>