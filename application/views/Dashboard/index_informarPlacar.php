<script type="text/javascript">
	$(function(){
		

		$(".enviar-placar").click(function(){
				
			var id_partida 				= $(this).data('id_partida');
			var id_equipe_informou      = $(this).data('id_equipe_informou');
			var ponto_desafiante 		= $("select[name='ponto_desafiante']").val();
			var ponto_desafiado 		= $("select[name='ponto_desafiado']").val();
			var botaoPropio 	= $(this);
			
			if(confirm("Tem certeza que deseja enviar este placar?") == false){
				return false;
			}
			$.ajax({
				url:base_url+'partida/placar',
				method:'POST',
				data:{'id_partida':id_partida,'id_equipe_informou':id_equipe_informou,'ponto_desafiado':ponto_desafiado,'ponto_desafiante':ponto_desafiante},
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


		$(".confirmar-placar").click(function(){
				
			var id_resultado 				= $(this).data('id_resultado');
			var status 						= $(this).data('status');
			var botaoPropio 				= $(this);
			
			if(confirm("Tem certeza que deseja confirmar este placar?") == false){
				return false;
			}

			$.ajax({
				url:base_url+'partida/confirmarplacar',
				method:'POST',
				data:{'id_resultado':id_resultado,'status':status},
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
	
	


	});
</script>
<?if($resultadoPendente != false):?>









<?if($resultadoPendente->id_equipe_informou == NULL):?>
<div class='row'>
	<div class='col-md-offset-3 col-md-6'>
		<div class="panel panel-default">
			<div class="panel-body text-center" style="padding: 20px;">
				<div class='row'>
					<div class='col-md-12 text-center'>
						<h5>A partida <a href='<?=base_url("partida/detalhes/".$resultadoPendente->id_partida);?>'>#<?=$resultadoPendente->id_partida;?></a> terminou, informe o placar do jogo</h5>
						
					</div>
				</div>
				<hr>
				<style type="text/css">
					.pontuacao {
						font-size: 32px;
					}
				</style>
				<div class='row'>
					<div class='col-md-4 text-center'>
						<img height="100px" src="<?=$resultadoPendente->logo_desafiante;?>"><br>
						
						<div>
							<a href="<?=base_url('equipe/detalhes/'.$resultadoPendente->id_equipe_desafiante);?>" ><?=$resultadoPendente->nome_equipe_desafiada;?></a></div>
							<div class="pontuacao">
								<select class="form-control"   style="width: 100px;margin: 0 auto;text-align: center;" name="ponto_desafiante">
									<option value="-3">W.O</option>
									<?for($i=0;$i<20;$i++):?>
									<option value='<?=$i;?>'><?=$i;?></option>
									<?endfor;?>
								</select>
							</div>
						</div>
						
						
						<div class='col-md-4 text-center'><h1>VS</h1></div>
						
						<div class='col-md-4 text-center'>
							<img height="100px" src="<?=$resultadoPendente->logo_desafiado;?>"><br>
							
							<div>
								<a href="<?=base_url('equipe/detalhes/'.$resultadoPendente->id_equipe_desafiado);?>" ><?=$resultadoPendente->nome_equipe_desafiante;?></a></div>
								<div class="pontuacao">
									
									<select class="form-control"   style="width: 100px;margin: 0 auto;text-align: center;" name="ponto_desafiado">
										<option value="-3">W.O</option>
										<?for($i=0;$i<20;$i++):?>
										<option value='<?=$i;?>'><?=$i;?></option>
										<?endfor;?>
									</select>
								</div>
							</div>
							
						</div>
						<div class="row">
							<div class="col-md-12 text-center">
								<button data-id_partida='<?=$resultadoPendente->id_partida;?>' data-id_equipe_informou='<?=$this->session->userdata('id_equipe');?>' class="enviar-placar btn btn-success">Enviar placar</button>
							</div>
						</div>
						
					</div>
				</div>
			</div>
		</div>
		<?else:?>
		<div class='row'>
			<div class='col-md-offset-3 col-md-6'>
				<div class="panel panel-default">
					<div class="panel-body text-center" style="padding: 20px;">
						<div class='row'>
							<div class='col-md-12 text-center'>
								<h5>A partida <a href='<?=base_url("partida/detalhes/".$resultadoPendente->id_partida);?>'>#<?=$resultadoPendente->id_partida;?></a> terminou, informe o placar do jogo</h5>
								
							</div>
						</div>
						<hr>
						<style type="text/css">
							.pontuacao {
								font-size: 32px;
							}
						</style>
						<div class='row'>
							<div class='col-md-4 text-center'>
								<img height="100px" src="<?=$resultadoPendente->logo_desafiante;?>"><br>
								
								<div>
									<a href="<?=base_url('equipe/detalhes/'.$resultadoPendente->id_equipe_desafiante);?>" ><?=$resultadoPendente->nome_equipe_desafiada;?></a></div>
									<div class="pontuacao">
									<?=($resultadoPendente->ponto_desafiante == -3) ? 'W.O' : $resultadoPendente->ponto_desafiante;?>
									<!-- 	<select class="form-control"   style="width: 100px;margin: 0 auto;text-align: center;" name="ponto_desafiante">
											<option value="-1">W.O</option>
											<?for($i=0;$i<20;$i++):?>
											<option value='<?=$i;?>'><?=$i;?></option>
											<?endfor;?>
										</select> -->
									</div>
								</div>
								
								
								<div class='col-md-4 text-center'><h1>VS</h1></div>
								
								<div class='col-md-4 text-center'>
									<img height="100px" src="<?=$resultadoPendente->logo_desafiado;?>"><br>
									
									<div>
										<a href="<?=base_url('equipe/detalhes/'.$resultadoPendente->id_equipe_desafiado);?>" ><?=$resultadoPendente->nome_equipe_desafiante;?></a></div>
										<div class="pontuacao">
											
											<?=($resultadoPendente->ponto_desafiado == -3) ? 'W.O' : $resultadoPendente->ponto_desafiado;?>
											<!-- <select class="form-control"   style="width: 100px;margin: 0 auto;text-align: center;" name="ponto_desafiado">
												<option value="-1">W.O</option>
												<?for($i=0;$i<20;$i++):?>
												<option value='<?=$i;?>'><?=$i;?></option>
												<?endfor;?>
											</select> -->
										</div>
									</div>
									
								</div>
								<div class="row">

									<?if($resultadoPendente->id_equipe_informou != $this->session->userdata('id_equipe')):?>
										<div class="col-md-12 text-center">
											<button data-id_resultado='<?=$resultadoPendente->id_resultado;?>' data-status='1' class="confirmar-placar btn btn-success">Confirmar </button>
											<button data-id_resultado='<?=$resultadoPendente->id_resultado;?>' data-status='4' class="confirmar-placar btn btn-danger">Recusar </button>
										</div>
									<?else:?>
										<div class="col-md-12 text-center">
											<h5>Aguardando a equipe adversária confirmar o placar.</h5>
										</div>
									<?endif;?>
								


								</div>
								
							</div>
						</div>
					</div>
				</div>
				<?endif;?>






				<?endif;?>