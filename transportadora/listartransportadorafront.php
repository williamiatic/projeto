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
        if(isset($_SESSION['transportadora_Deletada'])):
        ?>
        	<p>Transportadora Deletada com Sucesso!</p>
        <?php
        endif;
        unset($_SESSION['transportadora_Deletada'])
		?>
		
		<?php
        if(isset($_SESSION['transportadora_errodel'])):
        ?>
        	<p>Erro ao Deletar Transportadora!</p>
        <?php
        endif;
        unset($_SESSION['transportadora_errodel'])
		?>
		
		<?php
		if(isset($_SESSION['transportadora_erro'])):
		?>
			<p>Erro em editar Transportadora! Tente Novamente!</p>
		<?php
		endif;
		unset($_SESSION['transportadora_erro'])
		?>

		<?php
		if(isset($_SESSION['transportadora_editada'])):
		?>
			<p>Transportadora editada com Sucesso</p>
		<?php
		endif;
		unset($_SESSION['transportadora_editada'])
		?>
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
        $result = select("transpotadora", "count(id_transpotadora) as num_result", "where empresa_id = $idempresa");
        //echo $result[0]['num_result'];
		//Quantidade de pagina 
		$quantidade_pg = ceil($result[0]['num_result'] / $qnt_result_pg);
		
		//Limitar os link antes depois
		$max_links = 2;
		echo "<a href='listartransportadorafront.php?pagina=1'>Primeira</a> ";
		
		for($pag_ant = $pagina - $max_links; $pag_ant <= $pagina - 1; $pag_ant++){
			if($pag_ant >= 1){
				echo "<a href='listartransportadorafront.php?pagina=$pag_ant'>$pag_ant</a> ";
			}
		}
			
		echo "$pagina";
		
		for($pag_dep = $pagina + 1; $pag_dep <= $pagina + $max_links; $pag_dep++){
			if($pag_dep <= $quantidade_pg){
				echo "<a href='listartransportadorafront.php?pagina=$pag_dep'>$pag_dep</a> ";
			}
		}
		
		echo "<a href='listartransportadorafront.php?pagina=$quantidade_pg'>Ultima</a>". "<br><hr>";
		$query = select("transportadora as tr",
		"nm_transportadora, id_transportadora, cnpj, nm_cidade, uf, endereco, bairro, cep, telefone",
        "join dadoscadastrais on id_transportadora = transportadora_id and tr.empresa_id = $idempresa
        join cidade on id_cidade = cidade_id", NULL, "LIMIT $inicio, $qnt_result_pg");
		
        if ($query != null){
            for ($cont = 0; $cont < count($query); $cont++) {
				echo "Id Transportardora: " . $query[$cont]['id_transportadora'] . "<br>";
				echo "Nome Transportadora: " . $query[$cont]['nm_transportadora'] . "<br>";
                echo "CNPJ: " . $query[$cont]['cnpj'] . "<br>";
                echo "Endereço: " . $query[$cont]['endereco'] . "<br>" ;
                echo "nm_cidade: " . $query[$cont]['nm_cidade'] . "<br>" ;
                echo "uf: " . $query[$cont]['uf'] . "<br>" ;
                echo "Bairro: " . $query[$cont]['bairro'] . "<br>" ;
                echo "Cep: " . $query[$cont]['cep'] . "<br>";
				echo "Telefone: " . $query[$cont]['telefone'] . "<br>";
				echo "<a href='editartransportadorafront.php?id=" . $query[$cont]['id_transportadora'] . "'>Editar</a><br>";
				echo "<a href='deletartransportadoraback.php?id=" . $query[$cont]['id_transportadora'] . "'>Deletar</a><br><hr>";
            }
        }else{
            echo " Sem Valores na Lista" . "<br>";
        }
        
        //Paginção - Somar a quantidade de produtos
        $result = select("transpotadora", "count(id_transpotadora) as num_result", "where empresa_id = $idempresa");
        //echo $result[0]['num_result'];
		//Quantidade de pagina 
		$quantidade_pg = ceil($result[0]['num_result'] / $qnt_result_pg);
		
		//Limitar os link antes depois
		$max_links = 2;
		echo "<a href='listartransportadorafront.php?pagina=1'>Primeira</a> ";
		
		for($pag_ant = $pagina - $max_links; $pag_ant <= $pagina - 1; $pag_ant++){
			if($pag_ant >= 1){
				echo "<a href='listartransportadorafront.php?pagina=$pag_ant'>$pag_ant</a> ";
			}
		}
			
		echo "$pagina ";
		
		for($pag_dep = $pagina + 1; $pag_dep <= $pagina + $max_links; $pag_dep++){
			if($pag_dep <= $quantidade_pg){
				echo "<a href='listartransportadorafront.php?pagina=$pag_dep'>$pag_dep</a> ";
			}
		}
		
		echo "<a href='listartransportadorafront.php?pagina=$quantidade_pg'>Ultima</a>";
		
		?>		
	</body>
</html>