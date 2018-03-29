
<div class='row'>
	<div class='col-md-2 col-sm-6 col-xs-12'>
		<div class='quadrado-info'>
			<div class='quadrado-titulo'>JOGOS</div>
			<div class='quadrado-numero'>
				<?=$estatisticas->partidas;?>
			</div>
		</div>
	</div>
	<div class='col-md-2 col-sm-6 col-xs-12'>
		<div class='quadrado-info'>
			<div class='quadrado-titulo'>Vitórias</div>
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
