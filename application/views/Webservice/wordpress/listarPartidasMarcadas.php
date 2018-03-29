<link rel="stylesheet" type="text/css" href="<?=base_url('assets/css/webservice/wordpress/sportpress.css');?>">
<link rel="stylesheet" type="text/css" href="http://www.brasfut.com.br/wp-content/plugins/js_composer/assets/css/js_composer.min.css?ver=4.11.2.1">


<form>

<div class='row'>
	<div class='col-md-2'>
		<div class='form-group'>
			<label>Modalidade</label>
			<select name='id_modalidade' class='form-control'>
				<?foreach ($listarModalidades as $key => $v):?>
					<option  <?=($_GET[id_modalidade] == $v->id_modalidade) ? 'selected' : '';?> value="<?=$v->id_modalidade;?>"><?=$v->nome_modalidade;?></option>
				<?endforeach;?>
			</select>
		</div>
	</div>
	<div class='col-md-2'>
	
		<div class='form-group'>
			<label>Tipo</label>
			<select name='id_equipe_tipo' class='form-control'>
				<?foreach ($listarTipos as $key => $v):?>
					<option  <?=($_GET[id_equipe_tipo] == $v->id_equipe_tipo) ? 'selected' : '';?> value="<?=$v->id_equipe_tipo;?>"><?=$v->tipo;?></option>
				<?endforeach;?>
			</select>
		</div>
	</div>

</div>
<div class='row'>
	<div class='col-md-12'>
		<div class='form-group'>
			<button type="submit" class='btn btn-primary'>Filtrar</button>
		</div>
	</div>
</div>




</form>


<?if($listarPartidas != false):?>
<div class="sportspress sp-widget-align-none"><div class="sp-template sp-template-event-blocks">
	<div class="sp-table-wrapper">
		<table class="sp-event-blocks sp-data-table sp-paginated-table" >
			<thead><tr><th></th></tr></thead> 			<tbody>
			<?foreach ($listarPartidas as $key => $v):?>
				<tr class="sp-row sp-post">
					<td>
						<a class="team-logo logo-odd" href="#" title="<?=$v->equipe_desafiado;?>" >
						
							<img width="60" height="60" src="<?=$v->logo_desafiado;?>" class="attachment-sportspress-fit-icon 
						size-sportspress-fit-icon wp-post-image" alt="">
						
						</a>

						<a class="team-logo logo-even" href="#" title="<?=$v->equipe_desafiante;?>">

							<img width="60" height="60" src="<?=$v->logo_desafiante;?>" class="attachment-sportspress-fit-icon size-sportspress-fit-icon wp-post-image" alt="" >

						</a>

						<time class="sp-event-date" >
							<a href="#"><?=date('d/m/Y',strtotime($v->data_inicio));?></a>							
						</time>
						
						<h5 class="sp-event-results">
							<a href="#"><span class="sp-result"><?=date('H:i',strtotime($v->data_inicio));?></span></a>							</h5>
						<div class="sp-event-league"><?=$v->nome_modalidade;?></div>
						
						<div class="sp-event-venue"><?=$v->nome_local . ' - '.$v->cidade;?></div>
						
						<h4 class="sp-event-title">
							<a href="#"><?=$v->equipe_desafiado;?> vs <?=$v->equipe_desafiante;?></a>							
						</h4>
					</td>
				</tr>
			<?endforeach;?>

		</tbody>
	</table>
</div>
</div></div>

<?else:?>
<div class="sportspress sp-widget-align-none"><h4 class="sp-table-caption">Próximas partidas agendadas...</h4><div class="sp-template sp-template-event-blocks">
	<div class="sp-table-wrapper">
		<table class="sp-event-blocks sp-data-table sp-paginated-table" >
			<thead><tr><th></th></tr></thead> 			

		<tbody>
		<tr>
			<td><h5>Nenhum partida agendada.</h5></td>
		</tr>	

		</tbody>
	</table>
</div>
</div></div>
<?endif;?>