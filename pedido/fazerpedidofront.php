<?php
if (!isset($_SESSION)) session_start();
include("../connection/connect.php");
include("../connection/verificarlogin.php");
logado();
$empresa = $_SESSION['id'];
?>

<!DOCTYPE html>
<html>
    
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Fazer Pedido de Produtos</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
    <link rel="stylesheet" href="../css/bulma.min.css" />
    <link rel="stylesheet" type="../text/css" href="../css/login.css">
</head>

<body>
    <section class="hero is-success is-fullheight">
        <div class="hero-body">
            <div class="container has-text-centered">
                <div class="column is-4 is-offset-4">
                    <h3 class="title has-text-grey">Fazer Pedido de Produtos</h3>
                    <?php
                    if(isset($_SESSION['pedido_cadastrado'])):
                    ?>
                    <div class="notification is-success">
                      <p>Pedido Cadastrado com Sucesso!. <a href="../painel.php">Painel</a></p>
                    </div>
                    <?php
                    endif;
                    unset($_SESSION['pedido_cadastrado'])
                    ?>
                    <?php
                    if(isset($_SESSION['pedido_erro'])):
                    ?>
                    <div class="notification is-info">
                        <p>Erro Ao Fazer Pedido. Tente Novamente</p>
                    </div>
                    <?php
                    endif;
                    unset($_SESSION['pedido_erro'])
                    ?>
                    
                    <div class="box">
                        <form action="fazerpedidoback.php" method="POST">


                            <div class="field">
                                <div class="select is-large">
                                    <select name="Select_produto">
                                        <option> Produto - Fornecedor </option>
                                            <?php $query = select("produto", "nm_fornecedor, id_produto, nm_produto",
                                            "join fornecedor on id_fornecedor = fornecedor_id and fornecedor.empresa_id = '$empresa'");
                                                for($cont = 0; $cont < count($query); $cont++){ ?>
                                                <option value="<?php echo $query[$cont]['id_produto']; ?>"> <?php echo $query[$cont]['nm_produto']. " - " . $query[$cont]['nm_fornecedor']; ?> </option>
                                                <?php  }?>
                                    </select>
                                </div>
                            </div>

                            <div class="field">
                                <div class="control">
                                    <input name="quantidade" class="input is-large" type="number" placeholder="Quantidade">
                                </div>
                            </div>

                            <div class="field">
                                <div class="control">
                                    <input name="frete" type="text" class="input is-large" placeholder="Frete">
                                </div>
                            </div>

                            <div class="field">
                                <div class="control">
                                    <input name="notafiscal" type="text" class="input is-large" placeholder="Numero de Nota Fiscal">
                                </div>
                            </div>

                            <div class="field">
                                <div class="control">
                                    <input name="preco" type="number" class="input is-large" placeholder="Preço">
                                </div>
                            </div>

                            <div class="field">
                                <div class="control">
                                    <input name="imposto" type="number" class="input is-large" placeholder="Valor Imposto">
                                </div>
                            </div>


                            <div class="field">
                                <div class="select is-large">
                                    <select name="transportadora">
                                    <option value="0">Nenhuma Das Opções</option>
                                            <?php $query = select("transportadora", "*");
                                                for($cont = 0; $cont < count($query); $cont++){ ?>
                                                <option value="<?php echo $query[$cont]['id_transportadora']; ?>"> <?php echo $query[$cont]['nm_transportadora']; ?> </option>
                                            <?php } ?>
                                    </select>
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