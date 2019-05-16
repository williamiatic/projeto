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
		<title>Listar Pedidos de Envios</title>		
	</head>
	<body>
		<a href="../painel.php">Painel</a><br>
		<h1>Listar Pedidos de Envios</h1>
		<?php
		//Receber o número da página
		$pagina_atual = filter_input(INPUT_GET,'pagina', FILTER_SANITIZE_NUMBER_INT);		
		$pagina = (!empty($pagina_atual)) ? $pagina_atual : 1;
		
		//Setar a quantidade de itens por pagina
		$qnt_result_pg = 2;
		//calcular o inicio visualização
		$inicio = ($qnt_result_pg * $pagina) - $qnt_result_pg;
		//Paginção - Somar a quantidade de Saidas
        $result = select("saida", "count(id_entrada) as num_result",
		"where concluido = 0 and empresa_id = {$_SESSION['id']}");
        //echo $result[0]['num_result'];
		//Quantidade de pagina 
		$quantidade_pg = ceil($result[0]['num_result'] / $qnt_result_pg);
		
		//Limitar os link antes depois
		$max_links = 2;
		echo "<a href='listarenviofront.php?pagina=1'>Primeira</a> ";
		
		for($pag_ant = $pagina - $max_links; $pag_ant <= $pagina - 1; $pag_ant++){
			if($pag_ant >= 1){
				echo "<a href='listarenviofront.php?pagina=$pag_ant'>$pag_ant</a> ";
			}
		}
			
		echo "$pagina ";
		
		for($pag_dep = $pagina + 1; $pag_dep <= $pagina + $max_links; $pag_dep++){
			if($pag_dep <= $quantidade_pg){
				echo "<a href='listarenviofront.php?pagina=$pag_dep'>$pag_dep</a> ";
			}
		}
		
		echo "<a href='listarenviofront.php?pagina=$quantidade_pg'>Ultima</a>". "<br><hr>";
		$query = select("saida as said",
		"id_saida, nm_produto, dateped, said.quantidade, frete, num_notafiscal, preco, produto_id",
		"join produto on id_produto = produto_id and concluido = 0 and said.empresa_id = {$_SESSION['id']}", NULL, "LIMIT $inicio, $qnt_result_pg");
		
        if ($query != null){
            for ($cont = 0; $cont < count($query); $cont++) {
				echo "Id Produto: " . $query[$cont]['produto_id'] . "<br>";
				echo "Id Pedido: " . $query[$cont]['id_saida'] . "<br>";
				echo "Nome Produto: " . $query[$cont]['nm_produto'] . "<br>";
                echo "dataped: " . $query[$cont]['dateped'] . "<br>";
                echo "Quantidade: " . $query[$cont]['quantidade'] . "<br>" ;
                echo "frete: " . $query[$cont]['frete'] . "<br>" ;
                echo "Numero Nota Fiscal: " . $query[$cont]['num_notafiscal'] . "<br>" ;
                echo "preco: " . $query[$cont]['preco'] . "R$<br>" ;
				#echo "<a href='editarproduto.php?id=" . $query[$cont]['id_produto'] . "'>Editar</a><br>";
				echo "<a href='concluirevnioback.php?id=" . $query[$cont]['id_saida'] . "'>Envio Concluido</a><br><hr>";
            }
        }else{
            echo " Sem Valores na Lista" . "<br>";
        }
        
		echo "<a href='listarenviofront.php?pagina=1'>Primeira</a> ";
		
		for($pag_ant = $pagina - $max_links; $pag_ant <= $pagina - 1; $pag_ant++){
			if($pag_ant >= 1){
				echo "<a href='listarenviofront.php?pagina=$pag_ant'>$pag_ant</a> ";
			}
		}
			
		echo "$pagina ";
		
		for($pag_dep = $pagina + 1; $pag_dep <= $pagina + $max_links; $pag_dep++){
			if($pag_dep <= $quantidade_pg){
				echo "<a href='listarenviofront.php?pagina=$pag_dep'>$pag_dep</a> ";
			}
		}
		
		echo "<a href='listarenviofront.php?pagina=$quantidade_pg'>Ultima</a>";
		
		?>		
	</body>
</html>