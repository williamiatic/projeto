<?php
if (!isset($_SESSION)) session_start();
include("connection/connect.php");
include("connection/verificarlogin.php");
logado();
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<title>Editar Fornecedor</title>		
	</head>
	<body>
		<a href="../painel.php">Painel</a><br>
        <h1>Editar Fornecedor</h1>
        
        <form action="editarfornecedorback.php?id=<?= $id ?>" method="POST">
            <?php   
                $query = select("fornecedor", "*", "where id_fornecedor = '$id' and empresa_id = {$_SESSION['id']}");
                $query1 = select("dadoscadastrais", "*", "where fornecedor_id = '$id'")
            ?>
            <br><br>
			<label>Fornecedor: </label>
            <input type="text" name="nomefornecedor" placeholder="Digite o nome do Fornecedor" value="<?php echo $query[0]['nm_fornecedor']; ?>"><br><br>
            
            <label>CNPJ: </label>
            <input type="number" name="cnpj" placeholder="Digite o CNPJ" value="<?php echo $query[0]['cnpj']; ?>"><br><br>
            
            <label>Endereço: </label>
            <input type="text" name="endereco" placeholder="Digite o endereço" value="<?php echo $query1[0]['endereco']; ?>"><br><br>
            
            <label>Numero de Endereço: </label>
            <input type="text" name="num_endereco" placeholder="Digite o numero do endereço" value="<?php echo $query1[0]['num_endereco']; ?>"><br><br>
            
            <label> Cidades: </label>
            <select name="cidade">
                <option> ->Cidades<- </option> 
                    <?php $query2 = select("cidade", "*");
                        for($cont = 0; $cont < count($query2); $cont++){ ?>
                    <option value="<?php echo $query2[$cont]['id_cidade']; ?>"> <?php echo $query2[$cont]['nm_cidade']; ?> </option>               
                <?php }?>
            </select>
            <br><br>
            <label>Bairro: </label>
            <input type="text" name="bairro" placeholder="Digite o Bairro" value="<?php echo $query1[0]['bairro']; ?>"><br><br>
            
            <label>Cep: </label>
            <input type="number" name="cep" placeholder="Digite o CEP" value="<?php echo $query1[0]['cep']; ?>"><br><br>
            
            <label>Telefone: </label>
            <input type="text" name="telefone" placeholder="Digite o Telefone" value="<?php echo $query1[0]['telefone']; ?>"><br><br>
        
			<input type="submit" value="Editar Fornecedor">
		</form>
	</body>
</html>