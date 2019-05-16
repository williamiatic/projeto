<?php
if (!isset($_SESSION)) session_start();
include("../connection/connect.php");
include("../connection/verificarlogin.php");
logado();
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<title>Editar Transportadora</title>		
	</head>
	<body>
		<a href="../painel.php">Painel</a><br>
        <h1>Editar Transportadora</h1>
        
        <form action="editartransportadoraback.php?id=<?= $id ?>" method="POST">
        <label>Cidade: </label>
			<select name="cidade">
                <option> --Cidades-- </option> 
                    <?php $query = select("cidade", "*");
                        for($cont = 0; $cont < count($query); $cont++){ ?>
                    <option value="<?php echo $query[$cont]['id_cidade']; ?>"> <?php echo $query[$cont]['nm_cidade']; ?> </option>               
                <?php }?>
            </select>
            <br> <br>
            <?php
            $query = select("transportadora as tr", "*",
            "join dadoscadastrais on id_transportadora = $id and tr.empresa_id = '{$_SESSION['id']}'");
            ?>
			<label>Nome Transportadora: </label>
            <input type="text" name="transportadora" placeholder="Digite o nome do produto" value="<?php echo $query[0]['nm_transportadora']; ?>"><br><br>
            
            <label>CNPJ: </label>
            <input type="text" name="cnpj" placeholder="Digite a Marca" value="<?php echo $query[0]['cnpj']; ?>"><br><br>
            
            <label>Endereço: </label>
            <input type="text" name="endereco" placeholder="Digite a descrição" value="<?php echo $query[0]['endereco']; ?>"><br><br>
            
            <label>Numero de Endereço: </label>
            <input type="number" name="num_endereco" placeholder="Digite o peso " value="<?php echo $query[0]['num_endereco']; ?>"><br><br>
            
            <label>bairro: </label>
            <input type="text" name="bairro" placeholder="Digite a Quantidade Minima" value="<?php echo $query[0]['bairro']; ?>"><br><br>
            
            <label>CEP: </label>
            <input type="number" name="cep" placeholder="Digite a quantidade" value="<?php echo $query[0]['cep']; ?>"><br><br>

            <label>Telefone: </label>
            <input type="text" name="telefone" placeholder="Digite a quantidade" value="<?php echo $query[0]['telefone']; ?>"><br><br>
            
			<input type="submit" value="Editar Transportadora">
		</form>
	</body>
</html>