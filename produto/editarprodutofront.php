<?php
if (!isset($_SESSION)) session_start();
include("../connection/connect.php");
include("../connection/verificarlogin.php");
logado();
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$query = select("produto", "*", "where empresa_id = '{$_SESSION['id']}' and id_produto = $id");
?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<title>Editar Produto</title>		
	</head>
	<body>
		<a href="../painel.php">Painel</a><br>
        <h1>Editar Produto</h1>
        
        <form action="editarprodutoback.php?id=<?= $id ?>" method="POST">
        <label>Categoria: </label>
			<select name="categoria">
                <option> --Categorias-- </option> 
                    <?php $query = select("categoria", "*");
                        for($cont = 0; $cont < count($query); $cont++){ ?>
                    <option value="<?php echo $query[$cont]['id_categoria']; ?>"> <?php echo $query[$cont]['nm_categoria']; ?> </option>               
                <?php }?>
            </select>
            <br> <br>
            <?php   
                $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
                $query = select("produto", "*", "where empresa_id = '{$_SESSION['id']}' and id_produto = $id");
            ?>
			<label>Nome Produto: </label>
            <input type="text" name="produto" placeholder="Digite o nome do produto" value="<?php echo $query[0]['nm_produto']; ?>"><br><br>
            
            <label>Marca: </label>
            <input type="text" name="marca" placeholder="Digite a Marca" value="<?php echo $query[0]['marca']; ?>"><br><br>
            
            <label>Drescrição: </label>
            <input type="text" name="descricao" placeholder="Digite a descrição" value="<?php echo $query[0]['descricao']; ?>"><br><br>
            
            <label>Peso: </label>
            <input type="number" name="peso" placeholder="Digite o peso " value="<?php echo $query[0]['peso']; ?>"><br><br>
            
            <label>--Controlado--<label>
            <select name="controlado">
                <option> ->Controlado<- </option> 
                    <option value="True">True</option>
                    <option value="False">False</option> 
            </select><br><br>

            <label>Quantidade Minima: </label>
            <input type="number" name="quantidademinima" placeholder="Digite a Quantidade Minima" value="<?php echo $query[0]['quantidademinima']; ?>"><br><br>
            
            <label>Quantidade: </label>
            <input type="number" name="quantidade" placeholder="Digite a quantidade" value="<?php echo $query[0]['quantidade']; ?>"><br><br>
            
            <label>Lote: </label>
            <input type="number" name="lote" placeholder="Digite a quantidade do Lote" value="<?php echo $query[0]['lote']; ?>"><br><br>
            
            <label>Preço Unidade: </label>
            <input type="number" name="precounidade" placeholder="Digite a quantidade" value="<?php echo $query[0]['precounidade']; ?>"><br><br>
            
            <label>Preço Lote: </label>
            <input type="number" name="precolote" placeholder="Digite a quantidade do Lote" value="<?php echo $query[0]['precolote']; ?>"><br><br>
        
			<input type="submit" value="Editar Produto">
		</form>
	</body>
</html>