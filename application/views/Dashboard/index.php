<style type="text/css">

	.quadrado-info {

		background: white;

		padding: 5px;

		/*max-height: 150px;*/

		border-bottom: 5px solid #0f679f;

		margin-bottom: 30px;

	}

	.quadrado-info .quadrado-titulo {

		text-transform: uppercase;

		font-size: 1.0em;

		font-family: Verdana;

		color: #0f679f;

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

	#tabela-informacoes-time tr td {

		padding-top: 0px;

		padding-bottom: 0px;

		font-size: 15px;

		font-family: Verdana;

	}

	.titulo-esquerda {

		text-align: right;

		font-weight: 900;

		font-family: Verdana;

	}

	.titulo-direito {

		text-align: left;

	}

	.lista-convites {

		padding: 0px;

		margin: 0px;

		overflow-y: scroll;

		max-height: 210px;

	}

	.lista-convites li {

	list-style: none;

	display: flex;

	/* border-bottom: 1px solid #ccc; */

	padding-top: 20px;

	padding-bottom: 20px;

		padding-left: 10px;

	}

	.lista-convites li:hover {

		background-color: rgba(221, 221, 221, 0.29);

		border: 1px solid rgba(221, 221, 221, 0.29);

		border-left: 0px;

		border-right: 0px;

	}

	.lista-convites  .box-calendario {

		width: 60px;

		text-align: center;

		float: left;

		border: 1px solid #c8d8d8;

	border-top: 0;

	border-top: 4px solid red;

		height: 60px;

	background-color: #f7f9f9;

	background-image: -moz-linear-gradient(top, #ffffff, #ecefef);

	background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#ffffff), to(#ecefef));

	background-image: -webkit-linear-gradient(top, #ffffff, #ecefef);

	background-image: -o-linear-gradient(top, #ffffff, #ecefef);

	background-image: linear-gradient(to bottom, #ffffff, #ecefef);

	background-repeat: repeat-x;

	filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffffffff', endColorstr='#ffecefef', GradientType=0);

	text-align: center;

	}

	.lista-convites  .box-calendario span.mes {

		font-size: 20px;

		/*font-family: verdana;*/

		color: gray;

		display: block;

	}

	.lista-convites  .box-calendario span.dia {

		font-size: 15px;

		display: block;

	}

	.lista-convites .box-calendario span.hora_comeca {

	font-size: 10px;

	margin-top: 11px;

	display: block;

	}

	.lista-convites .box-descricao {

		margin-left: 10px;

		border-left: 2px solid #ccc;

		padding-left: 10px;

	}

	.lista-convites .box-descricao span.title{

		color: #4285f4;

		font-family: Verdana;

		font-weight: 500;

		display: block;

	}

	.lista-convites .box-descricao span.descricao{

		font-size: 11px;

		display: block;

	}

	.lista-convites .box-descricao span.title:hover{

		text-decoration: underline;

		cursor: pointer;

	}

	.lista-convites .box-descricao div.botoes{

		display: block;

		text-align: left;

	}

	.panel-body {

		padding: 3px;

	}



	.partidas_realizadas {

		margin-top: 35px;

	    margin-bottom: 35px;

	    border: 1px solid #ccc;

	    margin: 10px;

	    padding:15px;

	    border-radius:0;	

	}



	.partidas_realizadas:hover {

		background-color: rgba(221, 221, 221, 0.18);

		cursor: pointer;

	}



</style>

<script type="text/javascript">

	$(function(){

		$(".resposta-convite").click(function(){

				

																					var id_convite 		= $(this).data('id_convite');

																														var status 	   		= $(this).data('status');

												var botaoPropio 	= $(this);

			if(status == 1) {

				var status_text = 'aceitar';

			} else {

				var status_text = 'recusar';

			}

			if(confirm("Você tem certeza que deseja '"+status_text+"' este convite?") == false){

				return false;

			}

			$.ajax({

				url:base_url+'convite/resposta',

				method:'POST',

				data:{'id_convite':id_convite,'status':status},

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

		

		$(".cancelar-convite").click(function(){

				

																var id_convite 		= $(this).data('id_convite');

												var botaoPropio 	= $(this);

			if(confirm("Você tem certeza que deseja 'cancelar' a participação desta partida?") == false){

				return false;

			}

			$.ajax({

				url:base_url+'convite/cancelar',

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

		

		$(".cancelar-partida").click(function(){

				

											var id_partida 		= $(this).data('id_partida');

							var botaoPropio 	= $(this);

			

			if(confirm("Você tem certeza que deseja 'cancelar' esta partida?") == false){

				return false;

			}

			

			$.ajax({

				url:base_url+'partida/cancelar',

				method:'POST',

				data:{'id_partida':id_partida},

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

					$("li[data-id_partida='"+id_partida+"']").remove();

					alert(e.msg);

					window.location.reload();

					} else if(e.erro == true){

					alert(e.msg);

					window.location.reload();

					}

				}

			});

		});

		$(".enviar-resultado-partida").click(function(){

				

											var id_partida 		= $(this).data('id_partida');

							var botaoPropio 	= $(this);

			

			if(confirm("Você tem certeza que deseja enviar o seu placar?") == false){

				return false;

			}

			

			$.ajax({

				url:base_url+'partida/resultado',

				method:'POST',

				data:{'id_partida':id_partida,'placar':$("#placar_partida").val()},

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

					$("button[data-id_partida='"+id_partida+"']").remove();

					alert(e.msg);

					window.location.reload();

					} else if(e.erro == true){

					alert(e.msg);

					window.location.reload();

					}

				}

			});

		});

		

		$(".partida-mandante").click(function(){

				

												var id_local 					= $(this).data('id_local');

									var id_equipe_desafiante 		= $(this).data('id_equipe_desafiante');

											var data_inicio 				= $(this).data('data_inicio');

												var data_fim 					= $(this).data('data_fim');

											var botaoPropio 				= $(this);

			

			if(confirm("Você tem certeza que deseja continuar?") == false){

				return false;

			}

			

			$.ajax({

				url:base_url+'partida/criarpartidamandante',

				method:'POST',

				data:{'id_local':id_local,'id_equipe_desafiante':id_equipe_desafiante,'data_inicio':data_inicio,'data_fim':data_fim},

				beforeSend: function(){

					botaoPropio.hide();

				},

				fail: function(e){

				},

				complete: function(){

					botaoPropio.show("hide");

				},

				success: function(e){

					if(e.erro == false){

						alert(e.msg);

						window.location.reload();

					} else if(e.erro == true){

						alert(e.msg);

						window.location.reload();

					}

				}

			});

		});

		$(".cancelar-reserva").click(function(){

				

								var id_equipe 					= $(this).data('id_equipe_desafiante');

							var data_inicio 				= $(this).data('data_inicio');

							var botaoPropio 				= $(this);

	

			

			if(confirm("Você tem certeza que deseja cancelar esta reserva?") == false){

				return false;

			}

			

			$.ajax({

				url:base_url+'partida/cancelarreserva',

				method:'POST',

				data:{'id_equipe':id_equipe,'data_inicio':data_inicio},

				beforeSend: function(){

					botaoPropio.hide();

				},

				fail: function(e){

				},

				complete: function(){

					botaoPropio.show("hide");

				},

				success: function(e){

					if(e.erro == false){

						alert(e.msg);

						window.location.reload();

					} else if(e.erro == true){

						alert(e.msg);

						window.location.reload();

					}

				}

			});

		});

		$(".convite-partida-mandante").click(function(){

				

											var id_partida 					= $(this).data('id_partida');

								var id_equipe_desafiante 		= $(this).data('id_equipe_desafiante');

								var id_equipe_desafiada 		= $(this).data('id_equipe_desafiada');

										var botaoPropio 				= $(this);

			

			if(confirm("Você tem certeza que deseja enviar um convite para participar desta partida?") == false){

				return false;

			}

			

			$.ajax({

				url:base_url+'partida/autoconvidarmandante',

				method:'POST',

				data:{'id_partida':id_partida,'id_equipe_desafiante':id_equipe_desafiante,'id_equipe_desafiada':id_equipe_desafiada},

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

						alert(e.msg);

						window.location.reload();

					} else if(e.erro == true){

						alert(e.msg);

						window.location.reload();

					}

				}

			});

						});

		$(".cancelar-partida-mandate").click(function(){

				

											var id_partida 					= $(this).data('id_partida');

								var id_equipe_desafiante 		= $(this).data('id_equipe_desafiante');

										var data_inicio 				= $(this).data('data_inicio');

										var botaoPropio 				= $(this);

			

			if(confirm("Você tem certeza que deseja cancelar esta partida?") == false){

				return false;

			}

			

			$.ajax({

				url:base_url+'partida/cancelarpartidamandante',

				method:'POST',

				data:{'id_partida':id_partida,'id_equipe_desafiante':id_equipe_desafiante,'data_inicio':data_inicio},

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

						alert(e.msg);

						window.location.reload();

					} else if(e.erro == true){

						alert(e.msg);

						window.location.reload();

					}

				}

			});

				});

		$(".enviar-convite").click(function(){

				

											var id_partida 		= $(this).data('id_partida');

											var id_equipe 		= $(this).data('id_equipe_desafiante');

							var botaoPropio 	= $(this);

			

			if(confirm("Você tem certeza que deseja jogar esta partida?") == false){

				return false;

			}

			

			$.ajax({

				url:base_url+'partida/autoconvidar',

				method:'POST',

				data:{'id_partida':id_partida,'id_equipe_desafiante':id_equipe},

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

					$("li[data-id_partida='"+id_partida+"']").remove();

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

<!-- Informar placar -->

<?include_once "index_informarPlacar.php";?>

<!-- informar placar -->

<!-- Relatorio -->

<?include_once "index_relatorio.php";?>

<!-- Fim Relatorio -->

<div class='row'>

	<div class='col-md-5'>

		<div class="panel panel-default">

			<div class="panel-body">

				<ul class="nav nav-tabs">

					<li data-toggle="tooltip"  data-original-title="Aqui fica todos convites recebidos de outras equipes desafiando você para uma partida." class="active"><a href="#convites_recebidos" data-toggle="tab">Convites Recebidos <span class="badge"><?=($listarConvitesRecebidos != false) ? count($listarConvitesRecebidos) : '0';?></span></a></li>

					<li data-toggle="tooltip"  data-original-title="Aqui fica todos convites que você aceitou de outras equipes, aguardando a mesma confirmar.." ><a href="#convites_aceitos" data-toggle="tab">Convites Aceitos <span class="badge"><?=($listarConvitesAceitos != false) ? count($listarConvitesAceitos) : '0';?></span></a></li>

				</ul>

				<div class="tab-content panel-body" style="border: 1px solid #ddd;border-top: 0px;">

					<div id="convites_aceitos" class="tab-pane">

						

						<ul class='lista-convites'>

							<?if($listarConvitesAceitos == false):?>

							<li class="text-center">Não há convites aceitos</li>

							<?else:?>

							<?foreach ($listarConvitesAceitos as $key => $c):?>

							<li data-id_convite='<?=$c->id_convite;?>'>

								<a target="_BLANK" href="<?=base_url('partida/detalhes/'.$c->id_partida);?>">

									<div class='box-calendario'>

										<span class='mes'><?=$c->mes;?></span>

										<span class='dia'><?=$c->dia;?></span>

										<span class='hora_comeca'><b style="color: green;"><?=$c->horas_inicio;?></b>~<b style="color:red;"><?=$c->horas_fim;?></b></span>

									</div>

								</a>

								<div class='box-descricao'>

									<div style="float: left;">

										<span class='title'><a target="_BLANK" href="<?=base_url('partida/detalhes/'.$c->id_partida);?>"><?=$c->localidade;?></a></span>

										<span class='descricao'>

											Você aceitou o convite contra a equipe <b><?=$c->nome_equipe;?></b>, aguarde até eles confirmarem a partida!<br>

										</span>

										<div class='botoes'>

											<button data-id_convite='<?=$c->id_convite;?>' class='cancelar-convite btn btn-sm btn-danger'>Cancelar</button>

										</div>

									</div>

								</div>

							</li>

							<?endforeach;?>

							<?endif;?>

						</ul>

					</div>

					<div id="convites_recebidos" class="tab-pane fade in active">

						<ul class='lista-convites'>

							<?if($listarConvitesRecebidos == false):?>

							<li class="text-center">Não há convites recebidos</li>

							<?else:?>

							<?foreach ($listarConvitesRecebidos as $key => $c):?>

							<li data-id_convite='<?=$c->id_convite;?>'>

								<a target="_BLANK" href="<?=base_url('partida/detalhes/'.$c->id_partida);?>">

									<div class='box-calendario'>

										<span class='mes'><?=$c->mes;?></span>

										<span class='dia'><?=$c->dia;?></span>

										<span class='hora_comeca'><b style="color: green;"><?=$c->horas_inicio;?></b>~<b style="color:red;"><?=$c->horas_fim;?></b></span>

									</div>

								</a>

								<div class='box-descricao'>

									<div style="float: left;">

										<span class='title'><a target="_BLANK" href="<?=base_url('partida/detalhes/'.$c->id_partida);?>"><?=$c->localidade;?></a></span>

										<span class='descricao'>

											A equipe <b><?=$c->nome_equipe;?></b> convidou você para uma partida!<br>

										</span>

										<div class='botoes'>

											<button data-id_convite='<?=$c->id_convite;?>' data-status='1' class='resposta-convite btn btn-sm btn-success'>Aceitar</button>

											<button data-id_convite='<?=$c->id_convite;?>' data-status='2' class='resposta-convite btn btn-sm btn-danger'>Recusar</button>

											<!-- 	<a target="_BLANK" href="<?=base_url('partida/detalhes/'.$c->id_partida);?>">

												<button class='btn btn-sm btn-default'>Detalhes</button>

											</a>

											-->

										</div>

									</div>

								</div>

							</li>

							<?endforeach;?>

							<?endif;?>

						</ul>

					</div>

				</div>

			</div>

		</div>

	</div>

	

	

	<div class='col-md-7'>

		<div class="panel panel-default">

			<div class="panel-body">

				

				<!-- TABS -->

				<ul class="nav nav-tabs">

					<?if(in_array($this->session->userdata('id_equipe_tipo'), array(1,3))):?>

					<li  data-toggle="tooltip"  data-original-title="Aqui fica todas suas partidas reservadas, aguardando alguma outra equipe enviar um convite."><a href="#partidas_reservadas" data-toggle="tab">Meus jogos reservados <span class="badge"><?=($listarMinhasPartidasMandantes != false) ? count($listarMinhasPartidasMandantes) : '0';?></span></a></li>

					<?endif;?>

					<?if(in_array($this->session->userdata('id_equipe_tipo'), array(2,3))):?>

					<li  data-toggle="tooltip"  data-original-title="Aqui fica todas as partidas criadas por você aguardando o aceite ou recusa das outras equipes" ><a href="#partidas_criadas" data-toggle="tab">Meus Jogos <span class="badge"><?=($listarMinhasPartidas != false) ? count($listarMinhasPartidas) : '0';?></span></a></li>

					<?endif;?>

					<?if(in_array($this->session->userdata('id_equipe_tipo'), array(2,3))):?>
<!-- 
					<li data-toggle="tooltip"  data-original-title="Aqui fica todas as partidas das equipes mandantes, as equipes mandantes são equipes que possui um local de jogo já reservado, horário e data fixa na semana." ><a href="#partidas_entre_mandantes" data-toggle="tab">Jogos contra mandates <span class="badge"><?=($listarPartidasMandantes != false) ? count($listarPartidasMandantes) : '0';?></span></a></li>

					<?endif;?> -->

					

					<?if(in_array($this->session->userdata('id_equipe_tipo'), array(2,3))):?>

					<li data-toggle="tooltip"  data-original-title="Aqui fica todas as partidas disponíveis criadas por outras equipes." ><a href="#partidas_visitantes" data-toggle="tab">Jogos Disponíveis <span class="badge"><?=($listarEntreVisitantes != false) ? count($listarEntreVisitantes) : '0';?></span></a></li>

					<?endif;?>

				</ul>

				<!-- FINAL TABS -->

				<!-- TAB CONTENT -->

				<div class="tab-content panel-body" style="border: 1px solid #ddd;border-top: 0px;">

					

					<!-- MINHAS PARTIDAS CRIADAS -->

					<?if(in_array($this->session->userdata('id_equipe_tipo'), array(2,3))):?>

					

					<div id="partidas_criadas" class="tab-pane">

						<ul class='lista-convites'>

							<?if($listarMinhasPartidas == false):?>

							<li class="text-center">Nenhuma partida criada até o momento.</li>

							<?else:?>

							<?foreach ($listarMinhasPartidas as $key => $c):?>

							<li data-id_convite='<?=$c->id_convite;?>'>

								<a target="_BLANK" href="<?=base_url('partida/detalhes/'.$c->id_partida);?>">

									<div class='box-calendario'>

										<span class='mes'><?=$c->mes;?></span>

										<span class='dia'><?=$c->dia;?></span>

										<span class='hora_comeca'><b style="color: green;"><?=$c->horas_inicio;?></b>~<b style="color:red;"><?=$c->horas_fim;?></b></span>

									</div>

								</a>

								<div class='box-descricao'>

									<div style="float: left;">

										<span class='title'><a target="_BLANK" href="<?=base_url('partida/detalhes/'.$c->id_partida);?>"><?=$c->localidade;?></a></span>

										<span class='descricao'>

											Você é o mandante desta partida.

										</span>

										<div class='botoes'>

											<a target="_BLANK" href="<?=base_url('partida/detalhes/'.$c->id_partida);?>">

												<button data-id_partida='<?=$c->id_partida;?>' class='btn btn-sm btn-default'>Detalhes</button>

											</a>

											<button data-id_partida='<?=$c->id_partida;?>' class='cancelar-partida btn btn-sm btn-danger'>Cancelar</button>

										</div>

									</div>

								</li>

								<?endforeach;?>

								<?endif;?>

							</ul>

						</div>

						<?endif;?>

						<!-- PARTIDAS RESERVADAS MANDANTES -->

						<?if(in_array($this->session->userdata('id_equipe_tipo'), array(1,3))):?>

						

						<div id="partidas_reservadas" class="tab-pane">

							<ul class='lista-convites'>

								<?if($listarMinhasPartidasMandantes == false):?>

								<li class="text-center">Nenhuma partida foi encontrada</li>

								<?else:?>

								<?foreach ($listarMinhasPartidasMandantes as $key => $c):?>

								<?//echo '<pre>';?>

									<?//var_dump($c);?>

									<li>

										<a href='<?=($c[partida] != NULL) ? '/painel/partida/detalhes/'.$c[partida]->id_partida : 'javascript: alert("Você não pode visualizar está partida, nenhuma equipe solicitou um convite ainda...");';?>' target="_BLANK">

											<div class='box-calendario'>

												<span class='mes'><?=$c[mes];?></span>

												<span class='dia'><?=$c[dia]?></span>

												<span class='hora_comeca'><b style="color: green;"><?=substr($c[horas_inicio],0,5);?></b>~<b style="color:red;"><?=substr($c[horas_fim],0,5);?></b></span>

											</div>

										</a>

										<div class='box-descricao'>

											<div style="float: left;">

												<span class='title'>

													<a href='<?=($c[partida] != NULL) ? '/painel/partida/detalhes/'.$c[partida]->id_partida : 'javascript: alert("Você não pode visualizar está partida, nenhuma equipe solicitou um convite ainda...");';?>' target="_BLANK">

														<?=$c[localidade];?>

													</a>

												</span>

												<span class='descricao'>

													A equipe <b><?=$c[nome_equipe];?></b> tem um local e data disponível para uma partida.

												</span>

												<div class='botoes'>

													

													<?if($c[partida] == NULL):?>

													<button  data-id_equipe_desafiante='<?=$c[id_equipe_desafiante];?>' data-data_inicio='<?=$c[data_inicio];?>' data-data_fim='<?=$c[data_fim];?>' data-id_local='<?=$c[id_local];?>' class='cancelar-reserva btn btn-sm btn-danger'>Cancelar esta reserva.</button>

													<?else:?>

													<button  data-id_partida='<?=$c[partida]->id_partida;?>' data-data_inicio='<?=$c[data_inicio];?>' data-data_fim='<?=$c[data_fim];?>'  data-id_equipe_desafiante='<?=$c[partida]->id_equipe_desafiante;?>'  data-id_equipe_desafiada="<?=$this->session->userdata('id_equipe');?>" class='cancelar-partida-mandate btn btn-sm btn-danger'>Cancelar esta partida.</button>

													<?endif;?>

												</div>

											</div>

										</li>

										<?endforeach;?>

										<?endif;?>

									</ul>

								</div>

								<?endif;?>

								

								<?if(in_array($this->session->userdata('id_equipe_tipo'), array(2,3))):?>

								

								<div id="partidas_visitantes" class="tab-pane">

									<ul class='lista-convites'>

										<?if($listarEntreVisitantes == false):?>

										<li class="text-center">Nenhuma partida disponível momento</li>

										<?else:?>

										<?foreach ($listarEntreVisitantes as $key => $c):?>

										<li data-id_partida='<?=$c->id_partida;?>'>

											<a target="" href="<?=base_url('partida/detalhes/'.$c->id_partida);?>">

												<div class='box-calendario'>

													<span class='mes'><?=$c->mes;?></span>

													<span class='dia'><?=$c->dia;?></span>

													<span class='hora_comeca'><b style="color: green;"><?=$c->horas_inicio;?></b>~<b style="color:red;"><?=$c->horas_fim;?></b></span>

												</div>

											</a>

											<div class='box-descricao'>

												<div style="float: left;">

													<span class='title'><a target="" href="<?=base_url('partida/detalhes/'.$c->id_partida);?>"><?=$c->localidade;?></a></span>

													<span class='descricao'>

														Esta é uma partida pública criado pela equipe <b><?=$c->nome_equipe;?></b>

													</span>

													<div class='botoes'>

														<button data-id_partida='<?=$c->id_partida;?>' data-id_equipe_desafiante='<?=$c->id_equipe;?>'  class='enviar-convite btn btn-sm btn-success'>Eu quero jogar!</button>

													</div>

												</div>

											</li>

											<?endforeach;?>

											<?endif;?>

										</ul>

									</div>

									<?endif;?>

									

									<?if(in_array($this->session->userdata('id_equipe_tipo'), array(2,3))):?>

									

									<div id="partidas_entre_mandantes" class="tab-pane">

										<ul class='lista-convites'>

											<?if($listarPartidasMandantes == false):?>

											<li class="text-center">Nenhuma partida foi encontrada</li>

											<?else:?>

											<?foreach ($listarPartidasMandantes as $key => $c):?>

											<?//echo '<pre>';?>

												<?//var_dump($c);?>

												<li>

													<a href='<?=($c[partida] != NULL) ? '/painel/partida/detalhes/'.$c[partida]->id_partida : '#';?>' target="_BLANK">

														<div class='box-calendario'>

															<span class='mes'><?=$c[mes];?></span>

															<span class='dia'><?=$c[dia]?></span>

															<span class='hora_comeca'><b style="color: green;"><?=substr($c[horas_inicio],0,5);?></b>~<b style="color:red;"><?=substr($c[horas_fim],0,5);?></b></span>

														</div>

													</a>

													<div class='box-descricao'>

														<div style="float: left;">

															<span class='title'>

																<a href='<?=($c[partida] != NULL) ? '/painel/partida/detalhes/'.$c[partida]->id_partida : '#';?>' target="_BLANK">

																	<?=$c[localidade];?>

																</a>

															</span>

															<span class='descricao'>

																A equipe <b><?=$c[nome_equipe];?></b> tem um local e data disponível para uma partida.

															</span>

															<div class='botoes'>

																

																<?if($c[partida] == NULL):?>

																<button  data-id_equipe_desafiante='<?=$c[id_equipe_desafiante];?>' data-data_inicio='<?=$c[data_inicio];?>' data-data_fim='<?=$c[data_fim];?>' data-id_local='<?=$c[id_local];?>' class='partida-mandante btn btn-sm btn-success'>Solicitar uma reserva.</button>

																<?else:?>

																<button  data-id_partida='<?=$c[partida]->id_partida;?>' data-id_equipe_desafiante='<?=$c[partida]->id_equipe_desafiante;?>' data-id_equipe_desafiada="<?=$this->session->userdata('id_equipe');?>" class='convite-partida-mandante btn btn-sm btn-success'>Solicitar um convite.</button>

																<?endif;?>

															</div>

														</div>

													</li>

													<?endforeach;?>

													<?endif;?>

												</ul>

											</div>

											<?endif;?>

										</div>

									</div>

								</div>

							</div>

						</div>

						<div class="row">

							<div class='col-md-5'>

								<div class="panel panel-default">

									<div class="panel-body">

										<ul class="nav nav-tabs">

											<li data-toggle="tooltip"  data-original-title="Aqui fica todas as partidas confirmadas." class="active"><a href="#partida_agendadas" data-toggle="tab">Meus Jogos Agendados <span class="badge"><?=($listarPartidasAgendadas != false) ? count($listarPartidasAgendadas) : '0';?></span></a></li>

										</ul>

										<div class="tab-content panel-body" style="border: 1px solid #ddd;border-top: 0px;">

											<div id="partida_agendadas" class="tab-pane fade in active">

												

												<ul class='lista-convites'>

													<?if($listarPartidasAgendadas == false):?>

													<li class="text-center">Não há nenhuma partida marcada.</li>

													<?else:?>

													<?foreach ($listarPartidasAgendadas as $key => $c):?>

													<li>

														<a target="" href="<?=base_url('partida/detalhes/'.$c->id_partida);?>">

															<div class='box-calendario'>

																<span class='mes'><?=$c->mes;?></span>

																<span class='dia'><?=$c->dia;?></span>

																<span class='hora_comeca'><b style="color: green;"><?=$c->horas_inicio;?></b>~<b style="color:red;"><?=$c->horas_fim;?></b></span>

															</div>

														</a>

														<div class='box-descricao'>

															<div style="float: left;">

																<span class='title'><a target="" href="<?=base_url('partida/detalhes/'.$c->id_partida);?>"><?=$c->nome_equipe . ' vs '. $c->nome_equipe_desafiada;?></a></span>

																<span class='descricao'>

																	<?=$c->localidade;?><br>

																	<button data-id_partida='<?=$c->id_partida;?>'  class="btn btn-danger cancelar-partida">Cancelar</button>

																</span>

																

															</div>

														</div>

													</li>

													<?endforeach;?>

													<?endif;?>

												</ul>

											</div>

										</div>

									</div>

								</div>

							</div>

							<div class='col-md-7'>

								<div class="panel panel-default">

									<div class="panel-body">

										<ul class="nav nav-tabs">

											<li data-toggle="tooltip"  data-original-title="Aqui fica as partidas realizadas pela sua equipe." ><a href="#partida_realizadas" data-toggle="tab">Meus Jogos Realizados <span class="badge"><?=($listarMinhasPartidasRealizadas != false) ? count($listarMinhasPartidasRealizadas) : '0';?></span></a></li>

											<li data-toggle="tooltip"  data-original-title="Aqui fica as últimas partidas realizadas de todas as equipes." ><a href="#ultimas_partidas_realizadas" data-toggle="tab">Últimos Jogos Realizados <span class="badge"><?=($listarUltimasPartidasRealizadas != false) ? count($listarUltimasPartidasRealizadas) : '0';?></span></a></li>

										</ul>

										<div class="tab-content panel-body" style="border: 1px solid #ddd;border-top: 0px;">

											











											<div id="partida_realizadas" class="tab-pane">

												<div class="panel-body" style="overflow-y: scroll;max-height: 210px;">

													

													<?if($listarMinhasPartidasRealizadas == false):?>

													<h4>Nenhum partida realizada foi encontrada</h4>

													<?else:?>

													<?foreach ($listarMinhasPartidasRealizadas as $key => $v):?>

														<div class="partidas_realizadas row" 

															onclick="window.location.href = '<?=base_url('partida/detalhes/'.$v->id_partida);?>'">													<div class="col-md-4 col-sm-4 col-xs-4 text-center">

															<div class="equipe_partida">

																	<img  width='60px' src="<?=$v->desafiante_logo;?>">

																	

																	<h2>

																	</h2>

																	<div class="titulo"><a target="_BLANK" href="<?=base_url('equipe/detalhes/'.$v->id_equipe_desafiante);?>"><?=$v->equipe_desafiante;?></a></div>

																</div>

															</div>

															<div class="col-md-4 col-sm-4 col-xs-4 text-center">

																<h6><b><?=date('d/m/Y H:i:s',strtotime($v->data));?></b></h6>

																<h3>

																	<span style="font-size: 30px;"> <?=$v->ponto_desafiante;?></span>

																	x

																	<span style="font-size: 30px;"> <?=$v->ponto_desafiado;?></span>

																</h3>

															</div>

															<div class="col-md-4 col-sm-4 col-xs-4 text-center">

																<div class="equipe_partida">

																		<img  width='60px' src="<?=$v->desafiado_logo;?>">

																	<h2>

																	</h2>

																					<div class="titulo"><a target="_BLANK" href="<?=base_url('equipe/detalhes/'.$v->id_equipe_desafiado);?>"><?=$v->equipe_desafiado;?></a></div>

																</div>

															</div>

														</div>

													<?endforeach;?>

													<?endif;?>



												</div>

											</div>









											<div id="ultimas_partidas_realizadas" class="tab-pane">

												<div class="panel-body" style="overflow-y: scroll;max-height: 210px;">

													

													<?if($listarUltimasPartidasRealizadas == false):?>

													<h4>Nenhum partida realizada foi encontrada</h4>

													<?else:?>

													<?foreach ($listarUltimasPartidasRealizadas as $key => $v):?>

														<div class="partidas_realizadas row" 

															onclick="window.location.href = '<?=base_url('partida/detalhes/'.$v->id_partida);?>'">													<div class="col-md-4 col-sm-4 col-xs-4 text-center">

															<div class="equipe_partida">

																	<img  width='60px' src="<?=$v->desafiante_logo;?>">

																	

																	<h2>

																	</h2>

																	<div class="titulo"><a target="_BLANK" href="<?=base_url('equipe/detalhes/'.$v->id_equipe_desafiante);?>"><?=$v->equipe_desafiante;?></a></div>

																</div>

															</div>

															<div class="col-md-4 col-sm-4 col-xs-4 text-center">

																<h6><b><?=date('d/m/Y H:i:s',strtotime($v->data));?></b></h6>

																<h3>

																	<span style="font-size: 30px;"> <?=$v->ponto_desafiante;?></span>

																	x

																	<span style="font-size: 30px;"> <?=$v->ponto_desafiado;?></span>

																</h3>

															</div>

															<div class="col-md-4 col-sm-4 col-xs-4 text-center">

																<div class="equipe_partida">

																		<img  width='60px' src="<?=$v->desafiado_logo;?>">

																	<h2>

																	</h2>

																					<div class="titulo"><a target="_BLANK" href="<?=base_url('equipe/detalhes/'.$v->id_equipe_desafiado);?>"><?=$v->equipe_desafiado;?></a></div>

																</div>

															</div>

														</div>

													<?endforeach;?>

													<?endif;?>



												</div>

											</div>

























										</div>

									</div>

								</div>

							</div>

						</div>