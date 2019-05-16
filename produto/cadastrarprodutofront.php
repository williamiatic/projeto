<?php
if (!isset($_SESSION)) session_start();
include("../connection/connect.php");
include("../connection/verificarlogin.php");
logado();
?>

<!DOCTYPE html>
<html>
    
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cadastrar Produto</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
    <link rel="stylesheet" href="../css/bulma.min.css" />
    <link rel="stylesheet" type="../text/css" href="../css/login.css">
</head>

<body>
    <section class="hero is-success is-fullheight">
        <div class="hero-body">
            <div class="container has-text-centered">
                <div class="column is-4 is-offset-4">
                    <h3 class="title has-text-grey">Cadastrar Produto</h3>
                    <?php
                    if(isset($_SESSION['cadastro_sucesso'])):
                    ?>
                    <div class="notification is-success">
                      <p>Produto Cadastrado com Sucesso <a href="../painel.php"> Painel</a></p>
                    </div>
                    <?php
                    endif;
                    unset($_SESSION['cadastro_sucesso'])
                    ?>
                    <?php
                    if(isset($_SESSION['produto_existe'])):
                    ?>
                    <div class="notification is-info">
                        <p>O produto escolhido já existe. Informe outro e tente novamente.</p>
                    </div>
                    <?php
                    endif;
                    unset($_SESSION['produto_existe'])
                    ?>

                    <div class="box">
                        <?php $id = filter_input(INPUT_GET,'id', FILTER_SANITIZE_NUMBER_INT);?>
                        <form action="cadastrarprodutoback.php?id=<?= $id ?>" method="POST">

                            <div class="field">
                                <div class="select is-large">
                                    <select name="select_categoria">
                                        <option> -> Categorias <- </option>
                                            <?php $query = select("categoria", "*");
                                                for($cont = 0; $cont < count($query); $cont++){ ?>
                                                <option value="<?php echo $query[$cont]['id_categoria']; ?>"> <?php echo $query[$cont]['nm_categoria']; ?> </option>
                                            <?php } ?>
                                    </select>
                                </div>
                            </div>


                            <div class="field">
                                <div class="control">
                                    <input name="nomeproduto" type="text" class="input is-large" placeholder="Nome do Produto">
                                </div>
                            </div>

                            <div class="field">
                                <div class="control">
                                    <input name="marca" class="input is-large" type="text" placeholder="Marca">
                                </div>
                            </div>

                            <div class="field">
                                <div class="control">
                                    <input name="descricao" type="text" class="input is-large" placeholder="Descrição" autofocus>
                                </div>
                            </div>

                            <div class="field">
                                <div class="control">
                                    <input name="peso" type="text" class="input is-large" placeholder="Peso" autofocus>
                                </div>
                            </div>

                            <select name="controlado" class="input is-large field">
                                    <option> ->Controlado<- </option> 
                                    <option value="True">True</option>
                                    <option value="False">False</option> 
                            </select>

                            <div class="field">
                                <div class="control">
                                    <input name="quantidademinima" type="number" class="input is-large" placeholder="Quantidade Minima" autofocus>
                                </div>
                            </div>
  
                            <div class="field">
                                <div class="control">
                                    <input type="number" name="lote" class = "input is-large" placeholder="Lote">
                                </div>
                            </div>

                            <div class="field">
                                <div class="control">
                                    <input type="number" name="precounidade" class = "input is-large" placeholder="Preço Unidade">
                                </div>
                            </div>

                            <div class="field">
                                <div class="control">
                                    <input type="number" name="precolote" class = "input is-large" placeholder="Preço Lote">
                                </div>
                            </div>

                            <button type="submit" class="button is-block is-link is-large is-fullwidth">Cadastrar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>