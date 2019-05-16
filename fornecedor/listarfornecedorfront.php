<?php
if (!isset($_SESSION)) session_start();
include("../connection/connect.php");
include("../connection/verificarlogin.php");
logado();

// Falta Criar Função de Paginação!
?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8"/>
		<title>Listar Fornecedor</title>		
	</head>
	<body>
		<a href="painel.php">Painel</a><br>
		<h1>Listar Fornecedores</h1>
		<?php
		if(isset($_SESSION['cadastro_erro'])):
			?>
			<div class="notification is-info">
				<p>Erro Ao Cadastrar Produto. Tente Novamente.</p>
			</div>
			<?php
			endif;
        unset($_SESSION['cadastro_erro']);
		?>
		
		<?php
		if(isset($_SESSION['fornecedor_atualizado'])):
			?>
			<div class="notification is-info">
				<p>Fornecedor Atualizado com Sucesso!</p>
			</div>
			<?php
			endif;
        unset($_SESSION['fornecedor_atualizado']);
		?>
		
		<?php
		if(isset($_SESSION['fornecedor_erro'])):
			?>
			<div class="notification is-info">
				<p>Erro ao Atualizar Fornecedor! Tente Novamente</p>
			</div>
			<?php
			endif;
        unset($_SESSION['fornecedor_erro']);
		?>
		
		<?php
		if(isset($_SESSION['Fornecedor_Deletado'])):
			?>
			<div class="notification is-info">
				<p>Fornecedor Deletado Com Sucesso!</p>
			</div>
			<?php
			endif;
        unset($_SESSION['Fornecedor_Deletado']);
		?>

		<?php
		if(isset($_SESSION['fornecedor_errodel'])):
			?>
			<div class="notification is-info">
				<p>Erro ao Deletar Fornecedor! Tente Novamente</p>
			</div>
			<?php
			endif;
        unset($_SESSION['fornecedor_errodel']);
		?>

		<?php
		if(isset($_SESSION['produto_Deletado'])):
			?>
			<div class="notification is-info">
				<p>produto Deletado Com Sucesso!</p>
			</div>
			<?php
			endif;
        unset($_SESSION['produto_Deletado']);
		?>

		<?php
		if(isset($_SESSION['produto_errodel'])):
			?>
			<div class="notification is-info">
				<p>Erro ao Deletar produto! Tente Novamente</p>
			</div>
			<?php
			endif;
        unset($_SESSION['produto_errodel']);
		?>
		


        <?php
		//Receber o número da página
		$pagina_atual = filter_input(INPUT_GET,'pagina', FILTER_SANITIZE_NUMBER_INT);		
		$pagina = (!empty($pagina_atual)) ? $pagina_atual : 1;
		
		//Setar a quantidade de itens por pagina
		$qnt_result_pg = 2;
		//calcular o inicio visualização
        $idempresa = $_SESSION['id'];
        
        $inicio = ($qnt_result_pg * $pagina) - $qnt_result_pg;
        //Paginção - Somar a quantidade de usuários
        $result = select("fornecedor", "count(id_fornecedor) as num_result", "where empresa_id = $idempresa");
        //echo $result[0]['num_result'];
		//Quantidade de pagina 
		$quantidade_pg = ceil($result[0]['num_result'] / $qnt_result_pg);
		
		//Limitar os link antes depois
        $max_links = 5;
        
        echo "<a href='listarfornecedorfront.php?pagina=1'>Primeira</a>";
		
		for($pag_ant = $pagina - $max_links; $pag_ant <= $pagina - 1; $pag_ant++){
			if($pag_ant >= 1){
				echo "<a href='listarfornecedorfront.php?pagina=$pag_ant'>$pag_ant</a> ";
			}
		}
			
		echo "$pagina";
		
		for($pag_dep = $pagina + 1; $pag_dep <= $pagina + $max_links; $pag_dep++){
			if($pag_dep <= $quantidade_pg){
				echo "<a href='listarfornecedorfront.php?pagina=$pag_dep'>$pag_dep</a> ";
			}
		}
		
		echo "<a href='listarfornecedorfront.php?pagina=$quantidade_pg'>Ultima</a>". "<br><br>";

		$query = select("fornecedor",
		"id_fornecedor, nm_fornecedor,cnpj, nm_cidade, uf",
		"join cidade on id_cidade = cidade_id and empresa_id = '$idempresa'",
		NULL, "LIMIT $inicio, $qnt_result_pg");
		#echo $query[0]['nm_fornecedor'];
        if ($query != null){
            for ($cont = 0; $cont < count($query); $cont++) {
                echo "Fornecedor: " . $query[$cont]['nm_fornecedor'] . "<br>";
                echo "CNPJ: " . $query[$cont]['cnpj'] . "<br>" ;
                echo "cidade: " . $query[$cont]['nm_cidade'] . "<br>" ;
				echo "UF: " . $query[$cont]['uf'] . "<br>";
				echo "<a href='detalhefornecedorfront.php?id=" . $query[$cont]['id_fornecedor'] . "'>Mais</a><br>";
				echo "<a href='editarfornecedor.php?id=" . $query[$cont]['id_fornecedor'] . "'>Editar</a><br>";
				echo "<a href='../produto/cadastrarprodutofront.php?id=" . $query[$cont]['id_fornecedor'] . "'>Escolha o Fornecedor</a><br><hr>";
            }
        }else{
            echo " Sem Valores na Lista" . "<br>";
        }
        
		echo "<a href='listarfornecedorfront.php?pagina=1'>Primeira</a> ";
		
		for($pag_ant = $pagina - $max_links; $pag_ant <= $pagina - 1; $pag_ant++){
			if($pag_ant >= 1){
				echo "<a href='listarfornecedorfront.php?pagina=$pag_ant'>$pag_ant</a> ";
			}
		}
			
		echo "$pagina";
		
		for($pag_dep = $pagina + 1; $pag_dep <= $pagina + $max_links; $pag_dep++){
			if($pag_dep <= $quantidade_pg){
				echo "<a href='listarfornecedorfront.php?pagina=$pag_dep'>$pag_dep</a> ";
			}
		}
		
		echo "<a href='listarfornecedorfront.php?pagina=$quantidade_pg'>Ultima</a>";
		
		?>		
	</body>
</html>