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
</style>
<script type="text/javascript">
		$(function(){
			
			$(".aceitar-convite").click(function(){
				
				var id_convite 		= $(this).data('id_convite');
				var botaoPropio 	= $(this);
			
				if(confirm("Você tem certeza que deseja jogar com está equipe?") == false){
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
				<h3>Detalhes da Partida - <b>N° <?=$partida->id_partida;?></b></h3><br>
				<hr>
				
				<?if($this->session->userdata('id_equipe') == $partida->id_equipe_desafiante AND $partida->status == 0):?>
				<div class='alert alert-success'>Você criou esta partida! Fique atento na aba <b>'Convites Aceitos'</b> para acompanhar o retorno.</div>
				<?if($partida->privado == 0):?>
					<div class='alert alert-info'>Esta é uma partida pública! Todas as equipes tem a possibilidade de visualizar e aceitar o convite.</div>
				<?endif;?>
				<ul class="nav nav-tabs">
					
					<li ><a href="#equipes_convidadas" data-toggle="tab"> Convites Enviados <span class="badge"><?=($equipesConvidadas != false) ? count($equipesConvidadas) : '0';?></span></a></li>
					
					<li><a href="#equipes_aceitaram" data-toggle="tab"> Convites Aceitos <span class="badge"><?=($convitesAceitos != false) ? count($convitesAceitos) : '0';?></span></a></li>
					<li><a href="#equipes_recusaram" data-toggle="tab"> Convites Recusados <span class="badge"><?=($convitesRecusados != false) ? count($convitesRecusados) : '0';?></span></a></li>
					<li><a href="#equipes_visualizaram" data-toggle="tab"> Equipes que visualizaram esta partida <span class="badge"><?=($listarEquipesVisualizaramPartida != false) ? count($listarEquipesVisualizaramPartida) : '0';?></span></a></li>
				</ul>
				<div class="tab-content panel-body" style="margin-bottom: 150px; border: 1px solid #ddd;border-top: 0px;">
					<!-- <div class='gerenciar-partida panel panel-default' style="border-top: 0px; border-radius: 0px;"> -->
					<!-- <div class="panel-body"> -->
					
					<div id="equipes_convidadas" class="tab-pane fade">
						
						<?if($equipesConvidadas != false):?>
						<table class='table table-striped text-center'>
							<thead>
								<tr>
									<td>Equipes convidadas</td>
									<td>Data do envio convite</td>
								</tr>
							</thead>
							<tbody>
								<?foreach ($equipesConvidadas as $key => $e):?>
								<tr>
									<td><a target="_BLANK" href="<?=base_url('equipe/detalhes/'.$e->id_equipe);?>">
									<img width='20' src='<?=$e->logo;?>'/>  <b><?=$e->nome_equipe;?></b></a></td>
									<td><?=date('d/m/Y H:i:s',strtotime($e->data));?></td>
								</tr>
								<?endforeach;?>
							</tbody>
						</table>
						<?else:?>
						<h5 class="text-center">Nenhum convite foi enviado</h5>
						<?endif;?>
					</div>
					<div id="equipes_aceitaram" class="tab-pane fade">
						<?if($convitesAceitos != false):?>
						<table class='table table-striped text-center'>
							<thead>
								<tr>
									<td>Equipes que aceitaram o convite</td>
									<td>Ação</td>
									<td>Data resposta convite</td>
									<td>Data do envio convite</td>
								</tr>
							</thead>
							<tbody>
								<?foreach ($convitesAceitos as $key => $e):?>
								<tr>
									<td class="text-left"><a target="_BLANK" href="<?=base_url('equipe/detalhes/'.$e->id_equipe);?>"><img width='20' src='<?=$e->logo;?>'/>  <b><?=$e->nome_equipe;?></b></a></td>
									<td><button data-id_convite='<?=$e->id_convite;?>' class="aceitar-convite btn btn-sm btn-success">Jogar com esta equipe.</button> <!-- <button class="btn btn-sm btn-danger">Recusar</button> --></td>
									<td><?=date('d/m/Y H:i:s',strtotime($e->data_rsp_desafiada));?></td>
									<td><?=date('d/m/Y H:i:s',strtotime($e->data));?></td>
								</tr>
								<?endforeach;?>
							</tbody>
						</table>
						<?else:?>
						<h5 class="text-center">Nenhum convite foi aceito ainda...</h5>
						<?endif;?>
					</div>
					<div id="equipes_recusaram" class="tab-pane fade">
						<?if($convitesRecusados != false):?>
						
						<table class='table table-striped text-center'>
							<thead>
								<tr>
									<td>Equipes convidadas</td>
									<td>Data do envio convite</td>
								</tr>
							</thead>
							<tbody>
								<?foreach ($convitesRecusados as $key => $e):?>
								<tr>
									<td><a target="_BLANK" href="<?=base_url('equipe/detalhes/'.$e->id_equipe);?>"><img width='20' src='<?=$e->logo;?>'/>  <b><?=$e->nome_equipe;?></b></a></td>
									<td><?=date('d/m/Y H:i:s',strtotime($e->data));?></td>
								</tr>
								<?endforeach;?>
							</tbody>
						</table>
						<?else:?>
						<h5 class="text-center">Nenhum convite foi recusado</h5>
						<?endif;?>
					</div>
					<div id="equipes_visualizaram" class="tab-pane fade">
						<?if($listarEquipesVisualizaramPartida != false):?>
						
						<table class='table table-striped text-center'>
							<thead>
								<tr>
									<td>Equipes que visualizaram esta partida</td>
									<td>Data da visualização</td>
								</tr>
							</thead>
							<tbody>
								<?foreach ($listarEquipesVisualizaramPartida as $key => $e):?>
								<tr>
									<td><a target="_BLANK" href="<?=base_url('equipe/detalhes/'.$e->id_equipe);?>"><img width='20' src='<?=$e->logo;?>'/>  <b><?=$e->nome_equipe;?></b></a></td>
									<td><?=$e->data;?></td>
								</tr>
								<?endforeach;?>
							</tbody>
						</table>
						<?else:?>
						<h5 class="text-center">Nenhuma equipe visualizou esta partida</h5>
						<?endif;?>
					</div>
					
				<!-- </div>
			</div> -->
		</div>
		<?endif;?>
		<h4 class="text-center">
		Status da Partida  <br>
		<?if($partida->status == 0):?>
		<span class="label label-success">Em aberto, aguardando alguma equipe aceitar o convite.</span>
		<?elseif($partida->status == 1):?>
		<span class="label label-info">Aguardando a equipe desafiante confirmar a partida.</span>
		<?elseif($partida->status == 2):?>
		<span class="label label-info">Partida Confirmada. Aguardando até a data do jogo.</span>
		<?elseif($partida->status == 3):?>
		<span class="label label-default">Partida Concluída. Aguardando as equipes informarem o placar.</span>
		<?elseif($partida->status == 4):?>
		<span class="label label-default">Partida Finalizada e Computada.</span>
		<?elseif($partida->status == 5):?>
		<span class="label label-danger">Partida Cancelada.</span>
		<?endif;?>
		</h4>
		<div class='panel panel-default'>
			<div class="panel-body">
				<div class='row'>
					<div class='col-md-12 text-center'>
						<h4>Equipes</h4>
					</div>
				</div>
				<div class='row'>
					<div class='col-md-4 col-sm-4 col-xs-4 text-center'>
						<div class="equipe_partida">
							<img src='<?=$partida->logo_desafiante;?>'/>
							
								<H2>
								<?=$partida->pontuacao_desafiante;?>
								</H2>
							<div class="titulo"><span class='tipo_desafiante'>Desafiante</span><br><a target="_BLANK" href="<?=base_url('equipe/detalhes/'.$partida->id_equipe_desafiante);?>"><?=$partida->nome_equipe_desafiante;?></a></div>
						</div>
					</div>
					<div class='col-md-4 col-sm-4 col-xs-4 text-center'>
						<h1>VS</h1>
					</div>
					<div class='col-md-4 col-sm-4 col-xs-4 text-center'>
						<div class="equipe_partida">
							<?if(!empty($partida->nome_equipe_desafiada)):?>
							<img src='<?=$partida->logo_desafiado;?>'/>
							<H2>
								<?=$partida->pontuacao_desafiado;?>
								</H2>
							<div class="titulo"><span class='tipo_desafiante'>Desafiado</span><br><a target="_BLANK" href="<?=base_url('equipe/detalhes/'.$partida->id_equipe_desafiada);?>"><?=$partida->nome_equipe_desafiada;?></a></div>
							<?else:?>
							<h1>???</h1>
							<h6>Aguardando alguma equipe aceitar o convite.</h6>
							<?endif;?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class='panel panel-default'>
			<div class="panel-body">
				
				<div class='row'>
					<div class='col-md-6'>
						<div class="table-responsive">
							<table id='informacoes_partida' class="table table-striped" border="0">
								<tbody>
									<tr>
										<td class='strong' >Modalidade:</td>
										<td><?=$partida->nome_modalidade;?></td>
									</tr>
									<tr>
										<td class='strong' >Convite feito por:</td>
										<td><?=ucwords($partida->responsavel);?> <a target="_BLANK" href="<?=base_url('equipe/detalhes/'.$partida->id_equipe_desafiante);?>">[<?=$partida->nome_equipe_desafiante;?>]</a></td>
									</tr>
									<tr>
										<td class='strong' >Data do Jogo:</td>
										<td><?=$partida->data_partida;?></td>
									</tr>
									<tr>
										<td class='strong' >Início:</td>
										<td><?=$partida->hora_inicio_partida;?></td>
									</tr>
									<tr>
										<td class='strong' >Término:</td>
										<td><?=$partida->hora_fim_partida;?></td>
									</tr>
									<tr>
										<td class='strong' >Convite enviado em:</td>
										<td><?=date('d/m/Y H:i:s',strtotime($partida->data_criacao));?></td>
									</tr>
									<tr>
										<td class='strong' >Local do Jogo:</td>
										<td><?=$partida->nome_local;?></td>
									</tr>
									<tr>
										<td class='strong' >Endereço:</td>
										<td><?=$partida->endereco;?>, <?=$partida->numero;?></td>
									</tr>
									<tr>
									    <td class='strong' >Bairro:</td>
										<td><?=$partida->bairro;?></td>
									</tr>
									<tr>
									    <td class='strong' >Cidade:</td>
										<td><?=$partida->cidade;?></td>
									</tr>
									<tr>
									    <td class='strong' >Estado:</td>
										<td><?=$partida->uf;?></td>
									</tr>
									<tr>
										
										
									
									
									
								</tbody>
							</table>
						</div>
					</div>
					<div class='col-md-6'>
						<iframe width="100%" height="405px" frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/place?key=AIzaSyAP2f0yMBUUnmS96U9uvDceYIynExe2oME%20&q=<?=$partida->cep;?>,<?=$partida->endereco;?> <?=$partida->numero;?> " allowfullscreen></iframe>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
</form>