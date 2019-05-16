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
		<title>Listar Produtos</title>		
	</head>
	<body>
		<a href="painel.php">Painel</a><br>
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
        $result = select("loja", "count(id_loja) as num_result", "where empresa_id = $idempresa");
        //echo $result[0]['num_result'];
		//Quantidade de pagina 
		$quantidade_pg = ceil($result[0]['num_result'] / $qnt_result_pg);
		
		//Limitar os link antes depois
		$max_links = 2;
		echo "<a href='listalojafront.php?pagina=1'>Primeira</a> ";
		
		for($pag_ant = $pagina - $max_links; $pag_ant <= $pagina - 1; $pag_ant++){
			if($pag_ant >= 1){
				echo "<a href='listalojafront.php?pagina=$pag_ant'>$pag_ant</a> ";
			}
		}
			
		echo "$pagina";
		
		for($pag_dep = $pagina + 1; $pag_dep <= $pagina + $max_links; $pag_dep++){
			if($pag_dep <= $quantidade_pg){
				echo "<a href='listalojafront.php?pagina=$pag_dep'>$pag_dep</a> ";
			}
		}
		
		echo "<a href='listalojafront.php?pagina=$quantidade_pg'>Ultima</a>". "<br><hr>";
		$query = select("loja as lj",
		"*",
        "join dadoscadastrais on loja_id = id_loja and lj.empresa_id = $idempresa
        join cidade on id_cidade = cidade_id", NULL, "LIMIT $inicio, $qnt_result_pg");
		
        if ($query != null){
            for ($cont = 0; $cont < count($query); $cont++) {
				echo "Id Loja: " . $query[$cont]['loja_id'] . "<br>";
				echo "Nome Loja: " . $query[$cont]['nm_loja'] . "<br>";
				echo "CNPJ: " . $query[$cont]['cnpj'] . "<br>";
                echo "Endereço: " . $query[$cont]['endereco'] . "<br>";
                echo "Numero de Endereço: " . $query[$cont]['num_endereco'] . "<br>" ;
                echo "Cidade: " . $query[$cont]['nm_cidade'] . "<br>" ;
                echo "UF: " . $query[$cont]['uf'] . "<br>" ;
                echo "Bairro: " . $query[$cont]['bairro'] . "<br>" ;
                echo "CEP: " . $query[$cont]['cep'] . "<br>" ;
                echo "telefone: " . $query[$cont]['telefone'] . "R$<br>" ;
				#echo "<a href='editarlojafront.php?id=" . $query[$cont]['id_loja'] . "'>Editar</a><br>"; // Criar Editar Loja
            }
        }else{
            echo " Sem Valores na Lista" . "<br>";
        }
        
        //Paginção - Somar a quantidade de produtos
        $result = select("loja", "count(id_loja) as num_result", "where empresa_id = $idempresa");
        //echo $result[0]['num_result'];
        //Quantidade de pagina
		$quantidade_pg = ceil($result[0]['num_result'] / $qnt_result_pg);
		
		//Limitar os link antes depois
		$max_links = 2;
		echo "<a href='listalojafront.php?pagina=1'>Primeira</a> ";
		
		for($pag_ant = $pagina - $max_links; $pag_ant <= $pagina - 1; $pag_ant++){
			if($pag_ant >= 1){
				echo "<a href='listalojafront.php?pagina=$pag_ant'>$pag_ant</a> ";
			}
		}
			
		echo "$pagina ";
		
		for($pag_dep = $pagina + 1; $pag_dep <= $pagina + $max_links; $pag_dep++){
			if($pag_dep <= $quantidade_pg){
				echo "<a href='listalojafront.php?pagina=$pag_dep'>$pag_dep</a> ";
			}
		}
		
		echo "<a href='listalojafront.php?pagina=$quantidade_pg'>Ultima</a>";
		
		?>		
	</body>
</html>