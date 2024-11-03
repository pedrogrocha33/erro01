<?php
require_once("../../../conexao.php");
$tabela = 'produtos';

$query = $pdo->query("SELECT * FROM $tabela order by id desc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if ($total_reg > 0) {

	echo <<<HTML
	<small>
	<table class="table table-hover" id="tabela">
	<thead> 
	<tr> 
	<th>Nome</th>	
	<th class="esc">Categoria</th> 	
	<th class="esc">Valor Compra</th> 
	<th class="esc">Valor Venda</th>	
	<th class="esc">Estoque</th>	
	
	<th>Ações</th>
	</tr> 
	</thead> 
	<tbody>	
HTML;

	for ($i = 0; $i < $total_reg; $i++) {
		foreach ($res[$i] as $key => $value) {
		}
		$id = $res[$i]['id'];
		$nome = $res[$i]['nome'];
		$descricao = $res[$i]['descricao'];
		$categoria = $res[$i]['categoria'];
		$valor_compra = $res[$i]['valor_compra'];
		$valor_venda = $res[$i]['valor_venda'];
		$foto = $res[$i]['foto'];
		$estoque = $res[$i]['estoque'];
		$nivel_estoque = $res[$i]['nivel_estoque'];
		$tem_estoque = $res[$i]['tem_estoque'];
		$ativo = $res[$i]['ativo'];
		$guarnicoes = $res[$i]['guarnicoes'];
		$combo = $res[$i]['combo'];
		$promocao = $res[$i]['promocao'];
		// $preparado = $res[$i]['preparado'];
		// $delivery = $res[$i]['delivery'];

		$nomeF = mb_strimwidth($nome, 0, 25, "...");

		$valor_vendaF = number_format($valor_venda, 2, ',', '.');
		$valor_compraF = number_format($valor_compra, 2, ',', '.');


		if ($ativo == 'Sim') {
			$icone = 'fa-check-square';
			$titulo_link = 'Desativar Item';
			$acao = 'Não';
			$classe_linha = '';
		} else {
			$icone = 'fa-square-o';
			$titulo_link = 'Ativar Item';
			$acao = 'Sim';
			$classe_linha = 'text-muted';
		}


		$query2 = $pdo->query("SELECT * FROM categorias where id = '$categoria'");
		$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
		$total_reg2 = @count($res2);
		if ($total_reg2 > 0) {
			$nome_cat = $res2[0]['nome'];
			$mais_sabores = $res2[0]['mais_sabores'];
		} else {
			$nome_cat = 'Sem Referência!';
			$mais_sabores = '';
		}

		$ocultar_ad = '';
		if ($mais_sabores == 'Sim') {
			$ocultar_ad = 'ocultar';
		}


		if ($nivel_estoque >= $estoque and $tem_estoque == 'Sim') {
			$alerta_estoque = 'text-danger';
		} else {
			$alerta_estoque = '';
		}

		$classe_promo = 'ocultar';
		if ($promocao == "Sim") {
			$classe_promo = '';
		}

		$ocultar_grade = '';
		$ocultar_var = 'ocultar';
		if ($mais_sabores == 'Sim') {
			$ocultar_grade = 'ocultar';
			$ocultar_var = '';
		}

		echo <<<HTML
<tr class="{$alerta_estoque} {$classe_linha}">
<td>
<img src="images/produtos/{$foto}" width="27px" class="mr-2">
{$nomeF} <span class="{$classe_promo} text-primary" style="font-size: 10px">(Promoção)</span>
</td>
<td class="esc">{$nome_cat}</td>
<td class="esc">R$ {$valor_compraF}</td>
<td class="esc">R$ {$valor_vendaF}</td>
<td class="esc">{$estoque}</td>

<td>
	<big><a href="#" onclick="editar('{$id}','{$nome}', '{$categoria}', '{$descricao}', '{$valor_compra}', '{$valor_venda}', '{$foto}', '{$nivel_estoque}', '{$tem_estoque}', '{$guarnicoes}', '{$combo}', '{$promocao}')" title="Editar Dados"><i class="fa fa-edit text-primary"></i></a></big>

		<big><a href="#" onclick="mostrar('{$nome}', '{$nome_cat}', '{$descricao}', '{$valor_compraF}',  '{$valor_vendaF}', '{$estoque}', '{$foto}', '{$nivel_estoque}', '{$tem_estoque}', '{$guarnicoes}', '{$combo}', '{$promocao}')" title="Ver Dados"><i class="fa fa-info-circle text-secondary"></i></a></big>


	<li class="dropdown head-dpdn2" style="display: inline-block;">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><big><i class="fa-solid fa-trash" style="color: gray;"></i></big></a>
		
		<ul class="dropdown-menu" style="margin-left:-230px;">
		<li>
		<div class="notification_desc2">
		<p>Confirmar Exclusão? <a href="#" onclick="excluir('{$id}')"><span class="text-danger">Sim</span></a></p>
		</div>
		</li>										
		</ul>
		</li>


		 <big><a href="#" onclick="ativar('{$id}', '{$acao}')" title="{$titulo_link}"><i class="fa {$icone} text-success"></i></a></big> 


		<big><a href="#" onclick="saida('{$id}','{$nome}', '{$estoque}')" title="Saída de Produto"><i class="fa fa-sign-out text-danger"></i></a></big>

		<big><a href="#" onclick="entrada('{$id}','{$nome}', '{$estoque}')" title="Entrada de Produto"><i class="fa fa-sign-in text-verde"></i></a></big> 

 
		<a class="{$ocultar_grade}" href="#" onclick="grades('{$id}','{$nome}','{$categoria}')" title="Grade de Produtos"><i class="fa fa-list text-primary"></i></a>

		<a class="{$ocultar_var}" href="#" onclick="variacoes('{$id}','{$nome}','{$categoria}')" title="Variações do Produto"><i class="fa fa-list text-primary"></i></a>  

		


</td>
</tr>
HTML;

	}

	echo <<<HTML
	</tbody>
	<small><div align="center" id="mensagem-excluir"></div></small>
	</table>
	</small>
HTML;


} else {
	echo 'Não possui registros cadastrados!';
}


?>


<script type="text/javascript">
	$(document).ready(function () {
		$('#tabela').DataTable({
			"ordering": false,
			"stateSave": true
		});
		$('#tabela_filter label input').focus();
	});
</script>




<script type="text/javascript">
	function editar(id, nome, categoria, descricao, valor_compra, valor_venda, foto, nivel_estoque, tem_estoque, guarnicoes, combo, promocao, preparado, delivery) {
		$('#id').val(id);
		$('#nome').val(nome);
		$('#valor_venda').val(valor_venda);
		$('#valor_compra').val(valor_compra);
		$('#categoria').val(categoria).change();
		$('#descricao').val(descricao);
		$('#nivel_estoque').val(nivel_estoque);
		$('#tem_estoque').val(tem_estoque).change();
		$('#guarnicoes').val(guarnicoes);
		$('#combo').val(combo).change();
		$('#promocao').val(promocao).change();
		$('#preparado').val(preparado).change();
		$('#delivery').val(delivery).change();

		$('#titulo_inserir').text('Editar Registro');
		$('#modalForm').modal('show');
		$('#foto').val('');
		$('#target').attr('src', 'images/produtos/' + foto);
	}

	function limparCampos() {
		$('#id').val('');
		$('#nome').val('');
		$('#valor_compra').val('');
		$('#valor_venda').val('');
		$('#descricao').val('');
		$('#foto').val('');
		$('#guarnicoes').val('');
		$('#combo').val('Não').change();
		$('#promocao').val('Não').change();
		$('#preparado').val('Sim').change();
		$('#delivery').val('Sim').change();
		$('#target').attr('src', 'images/produtos/sem-foto.jpg');
	}
</script>



<script type="text/javascript">
	function mostrar(nome, categoria, descricao, valor_compra, valor_venda, estoque, foto, nivel_estoque, tem_estoque, guarnicoes, combo, promocao) {

		$('#nome_dados').text(nome);
		$('#valor_compra_dados').text(valor_compra);
		$('#categoria_dados').text(categoria);
		$('#valor_venda_dados').text(valor_venda);
		$('#descricao_dados').text(descricao);
		$('#estoque_dados').text(estoque);
		$('#nivel_estoque_dados').text(nivel_estoque);
		$('#tem_estoque_dados').text(tem_estoque);
		$('#guarnicoes_dados').text(guarnicoes);

		$('#combo_dados').text(combo);
		$('#promocao_dados').text(promocao);


		$('#target_mostrar').attr('src', 'images/produtos/' + foto);

		$('#modalDados').modal('show');
	}
</script>





<script type="text/javascript">
	function saida(id, nome, estoque) {

		$('#nome_saida').text(nome);
		$('#estoque_saida').val(estoque);
		$('#id_saida').val(id);

		$('#modalSaida').modal('show');
	}
</script>


<script type="text/javascript">
	function entrada(id, nome, estoque) {

		$('#nome_entrada').text(nome);
		$('#estoque_entrada').val(estoque);
		$('#id_entrada').val(id);

		$('#modalEntrada').modal('show');
	}
</script>


<script type="text/javascript">
	function variacoes(id, nome, cat) {

		$('#titulo_nome_var').text(nome);
		$('#id_var').val(id);

		listarVariacoes(id);
		listarVarCat(cat);
		$('#modalVariacoes').modal('show');
		limparCamposVar();
	}
</script>


<script type="text/javascript">
	function grades(id, nome, cat) {

		$('#titulo_nome_grades').text(nome);
		$('#id_grades').val(id);

		listarGrades(id);

		$('#id_grade_editar').val('');
		$('#btn_grade').text('Salvar');
		$('#modalGrades').modal('show');
		limparCamposGrades();
	}
</script>