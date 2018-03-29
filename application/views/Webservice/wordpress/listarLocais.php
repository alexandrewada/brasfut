<table id='tabela' class="table">
	<thead>
		<tr>
			<th>Nome local</th>
			<th>Modalidade</th>
			<th>Bairro</th>
			<th>Cidade</th>
			<th>UF</th>
		</tr>
	</thead>
	<tbody>
		<?foreach ($listarLocais as $k => $v):?>
			<tr>
				<td><?=$v->nome_local;?></td>
				<td><?=$v->modalidade;?></td>
				<td><?=$v->bairro;?></td>
				<td><?=$v->cidade;?></td>
				<td><?=$v->uf;?></td>
			</tr>
		<?endforeach;?>
	</tbody>
</table>