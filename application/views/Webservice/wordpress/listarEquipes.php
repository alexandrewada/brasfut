<table id='tabela' class="table">
	<thead>
		<tr>
			<th>Equipe</th>
			<th>Modalidade</th>
			<th>Categoria</th>
			<th>Cidade/SP</th>
		</tr>
	</thead>
	<tbody>
		<?foreach ($listarEquipes as $k => $v):?>
			<tr>
				<td><img height="32px;" width="32px;" src='<?=$v->logo;?>'/> <?=$v->nome_equipe;?></td>
				<td><?=$v->nome_modalidade;?></td>
				<td><?=$v->nome_categoria;?></td>
				<td><?=$v->cidade;?></td>
			</tr>
		<?endforeach;?>
	</tbody>
</table>