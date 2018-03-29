<style type="text/css">
	.equipe_partida {
		text-align: center;
	}
	.equipe_partida img {
		height: 100px;
	}
	.equipe_partida .titulo {
		cursor: pointer;
		font-weight: 900;
		font-family: Verdana;
		margin-top: 10px;
	}
	#informacoes_partida .strong {
		font-weight: 900;
		font-family: Verdana;
	}
	.tipo_desafiante {
		font-size: 10px;
	}
	.gerenciar-partida {
		margin-bottom: 80px;
	}
	.quadrado-info {
		background: #eee;
		padding: 5px;
		/*max-height: 150px;*/
		border-bottom: 5px solid #0f679f;
		margin-bottom: 30px;
	}
	.quadrado-info .quadrado-titulo {
		text-transform: uppercase;
		font-size: 1.0em;
		font-family: Verdana;
		color: #777;
		text-align: center;
		padding-top: 4px;
		padding-bottom: 5px;
		border-bottom: 1px solid rgba(128, 128, 128, 0.06);
		/*background-color: #f8f8f8;*/
		}
	.quadrado-info .quadrado-numero {
		font-size: 2.5em;
		text-align: center;
		font-family: Arial black;
	}
	.glyphicon-info-sign {
		color: #ccc;
	}
</style>
<script type="text/javascript">
		$(function(){
			
			$(".aceitar-convite").click(function(){
				
						var id_convite 		= $(this).data('id_convite');
					var botaoPropio 	= $(this);
			
				if(confirm("Você tem certeza que deseja jogar com esta equipe?") == false){
					return false;
				}
				
				$.ajax({
					url:base_url+'partida/confirmada',
					method:'POST',
					data:{'id_convite':id_convite},
					beforeSend: function(){
						botaoPropio.hide();
					},
					fail: function(e){
					},
					complete: function(){
											// 	botaoPropio.show("hide");
					},
					success: function(e){
						if(e.erro == false){
						$("li[data-id_convite='"+id_convite+"']").remove();
						alert(e.msg);
						window.location.reload();
						} else if(e.erro == true){
						alert(e.msg);
						window.location.reload();
						}
					}
				});
			});
		});
</script>

<form class='ajax-post' action="<?=base_url('partida/agendarpost');?>" >
	<div class='row'>
		<div class='col-md-12'>
			<div class='conteudo'>
				<div class='panel panel-default'>
					<div class="panel-body">

						
<div class='row'>
<h3 class="text-center">Estatísticas da Equipe</h3>
<hr>
	<div class='col-md-2 col-sm-6 col-xs-12'>
		<div class='quadrado-info'>
			<div class='quadrado-titulo'>PARTIDAS</div>
			<div class='quadrado-numero'>
				<?=$estatisticas->partidas;?>
			</div>
		</div>
	</div>
	<div class='col-md-2 col-sm-6 col-xs-12'>
		<div class='quadrado-info'>
			<div class='quadrado-titulo'>VITÓRIAS</div>
			<div class='quadrado-numero'>
				<?=$estatisticas->vitoria;?>
			</div>
		</div>
	</div>
	<div class='col-md-2 col-sm-6 col-xs-12'>
		<div class='quadrado-info'>
			<div class='quadrado-titulo'>DERROTAS</div>
			<div class='quadrado-numero'>
				<?=$estatisticas->derrota;?>
			</div>
		</div>
	</div>
	<div class='col-md-2 col-sm-6 col-xs-12'>
		<div class='quadrado-info'>
			<div class='quadrado-titulo'>EMPATES</div>
			<div class='quadrado-numero'>
				<?=$estatisticas->empate;?>
			</div>
		</div>
	</div>
	<div class='col-md-2 col-sm-6 col-xs-12'>
		<div class='quadrado-info'>
			<div class='quadrado-titulo'>Aproveitamento</div>
			<div class='quadrado-numero'>
				<?=round($estatisticas->pontos/($estatisticas->partidas*3)*100);?>%
			</div>
		</div>
	</div>
	<div class='col-md-2 col-sm-6 col-xs-12'>
		<div class='quadrado-info'>
			<div class='quadrado-titulo'>PONTOS</div>
			<div class='quadrado-numero'>
				<?=$estatisticas->pontos;?>
			</div>
		</div>
	</div>
</div>						
<h3 class="text-center">Dados da Equipe</h3>
<hr>
						<div class='row'>
							<div class='col-md-6'>
								<div class='text-center' style="padding-top: 20px;">
								 <img height="300px;" width="300px;" src='<?=$equipe->logo;?>'/><br>
								 <h1><?=$equipe->nome_equipe;?></h1>
								</div>
							</div>
							<div class='col-md-6' >
								<div class="table-responsive">
								
									<table id='informacoes_partida' class="table table-striped" border="0">
										<tbody>
											<tr>
												<td class='strong' >Nome:</td>
												<td><?=$equipe->nome_equipe;?></td>
											</tr>
											<tr>
												<td class='strong' >Responsável:</td>
												<td><?=ucwords($equipe->nome_pessoa);?></td>
											</tr>
<!-- 											<tr>
												<td class='strong' >Telefone responsável:</td>
												<td><?=$equipe->telefone;?></td>		
											</tr>
											<tr>
												<td class='strong' >Celular responsável:</td>
												<td><?=$equipe->celular;?></td>		
											</tr>
 -->											<tr>
												<td class='strong' >Fundação:</td>
												<td><?=date('d/m/Y',strtotime($equipe->data_fundacao));?></td>
											</tr>
											<tr>
												<td class='strong' >Modalidade:</td>
												<td><?=$equipe->nome_modalidade;?></td>
											</tr>
											<tr>
												<td class='strong' >Categoria:</td>
												<td><?=$equipe->nome_categoria;?></td>
											</tr>
											<tr>
												<td class='strong' >Sexo:</td>
												<td><?=$equipe->sexo;?></td>
											</tr>
											<tr>
												<td class='strong' >Cores:</td>
												<td><?=$equipe->cores_predominantes;?></td>
											</tr>
											<tr>
												<td class='strong' >Cidade:</td>
												<td><?=$equipe->cidade;?></td>
											</tr>
											<tr>
												<td class='strong' >UF:</td>
												<td><?=$equipe->uf;?></td>
											</tr>
											<tr>
												<td class='strong' >Bairro:</td>
												<td><?=$equipe->bairro;?></td>
											</tr>			
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>