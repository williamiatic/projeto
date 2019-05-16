<?php
if (!isset($_SESSION)) session_start();
include("../connection/connect.php");
include("../connection/verificarlogin.php");
logado();
?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8"/>
		<title>Listar</title>		
	</head>
	<body>
		<a href="../painel.php">Painel</a><br>
		<h1>Listar Produtos</h1>
		<?php
		$idempresa = $_SESSION['id'];

		//Receber o número da página
		$pagina_atual = filter_input(INPUT_GET,'pagina', FILTER_SANITIZE_NUMBER_INT);		
		$pagina = (!empty($pagina_atual)) ? $pagina_atual : 1;
		
		//Setar a quantidade de itens por pagina
		$qnt_result_pg = 2;
		//calcular o inicio visualização
		$inicio = ($qnt_result_pg * $pagina) - $qnt_result_pg;
		//Paginção - Somar a quantidade de produtos
        $result = select("produto", "count(id_produto) as num_result", "where empresa_id = {$_SESSION['id']}");
        //echo $result[0]['num_result'];
		//Quantidade de pagina 
		$quantidade_pg = ceil($result[0]['num_result'] / $qnt_result_pg);
		
		//Limitar os link antes depois
		$max_links = 2;
		echo "<a href='listarprodutoscadastradofront.php?pagina=1'>Primeira</a> ";
		
		for($pag_ant = $pagina - $max_links; $pag_ant <= $pagina - 1; $pag_ant++){
			if($pag_ant >= 1){
				echo "<a href='listarprodutoscadastradofront.php?pagina=$pag_ant'>$pag_ant</a> ";
			}
		}
			
		echo "$pagina ";
		
		for($pag_dep = $pagina + 1; $pag_dep <= $pagina + $max_links; $pag_dep++){
			if($pag_dep <= $quantidade_pg){
				echo "<a href='listarprodutoscadastradofront.php?pagina=$pag_dep'>$pag_dep</a> ";
			}
		}
		
		echo "<a href='listarprodutoscadastradofront.php?pagina=$quantidade_pg'>Ultima</a>". "<br><hr>";
		$query = select("produto",
		"nm_fornecedor, id_produto, nm_produto, nm_categoria, marca, descricao, peso, controlado, quantidademinima, lote, precounidade, precolote",
		"join fornecedor on id_fornecedor = fornecedor_id and fornecedor.empresa_id = {$_SESSION['id']}
		join categoria on id_categoria = categoria_id", NULL, "LIMIT $inicio, $qnt_result_pg");
		
        if ($query != null){
            for ($cont = 0; $cont < count($query); $cont++) {
				echo "Id Produto: " . $query[$cont]['id_produto'] . "<br>";
				echo "Fornecedor: " . $query[$cont]['nm_fornecedor'] . "<br>";
                echo "Categoria: " . $query[$cont]['nm_categoria'] . "<br>";
                echo "Nome Produto: " . $query[$cont]['nm_produto'] . "<br>" ;
                echo "Marca: " . $query[$cont]['marca'] . "<br>" ;
                echo "Descrição: " . $query[$cont]['descricao'] . "<br>" ;
                echo "Peso: " . $query[$cont]['peso'] . "Kg<br>" ;
                echo "Controlado: " . $query[$cont]['controlado'] . "<br>" ;
                echo "Quantidade Minima: " . $query[$cont]['quantidademinima'] . "<br>";
				echo "Lote: " . $query[$cont]['lote'] . "<br>";
				echo "Preço Unidade: " . $query[$cont]['precounidade'] . "<br>";
				echo "Preço Lote: " . $query[$cont]['precolote'] . "<br>";
				echo "<a href='editarproduto.php?id=" . $query[$cont]['id_produto'] . "'>Editar</a><br>";
				echo "<a href='../backendscreen/deletarproduto.php?id=" . $query[$cont]['id_produto'] . "'>Deletar</a><br><hr>";
            }
        }else{
            echo " Sem Valores na Lista" . "<br>";
        }
        
		echo "<a href='listarprodutoscadastradofront.php?pagina=1'>Primeira</a> ";
		
		for($pag_ant = $pagina - $max_links; $pag_ant <= $pagina - 1; $pag_ant++){
			if($pag_ant >= 1){
				echo "<a href='listarprodutoscadastradofront.php?pagina=$pag_ant'>$pag_ant</a> ";
			}
		}
			
		echo "$pagina ";
		
		for($pag_dep = $pagina + 1; $pag_dep <= $pagina + $max_links; $pag_dep++){
			if($pag_dep <= $quantidade_pg){
				echo "<a href='listarprodutoscadastradofront.php?pagina=$pag_dep'>$pag_dep</a> ";
			}
		}
		
		echo "<a href='listarprodutoscadastradofront.php?pagina=$quantidade_pg'>Ultima</a>";
		
		?>		
	</body>
</html>