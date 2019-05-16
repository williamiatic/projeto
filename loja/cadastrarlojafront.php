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
    <title>Cadastrar Loja</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
    <link rel="stylesheet" href="../css/bulma.min.css" />
    <link rel="stylesheet" type="../text/css" href="../css/login.css">
</head>

<body>
    <section class="hero is-success is-fullheight">
        <div class="hero-body">
            <div class="container has-text-centered">
                <div class="column is-4 is-offset-4">
                    <h3 class="title has-text-grey">Cadastrar Loja</h3>
                    <?php
                    if(isset($_SESSION['user_not_exists'])):
                    ?>
                    <div class="notification is-success">
                      <p>Loja Cadastrado com Sucesso. <a href="painel.php">Painel</a></p>
                    </div>
                    <?php
                    endif;
                    unset($_SESSION['user_not_exists'])
                    ?>
                    <?php
                    if(isset($_SESSION['loja_existe'])):
                    ?>
                    <div class="notification is-info">
                        <p>A Loja já existe. Informe outra e tente novamente.</p>
                    </div>
                    <?php
                    endif;
                    unset($_SESSION['loja_existe'])
                    ?>
                    <?php
                    if(isset($_SESSION['loja_erro'])):
                    ?>
                    <div class="notification is-info">
                        <? echo "teste"; ?>
                        <p>Erro Ao Cadastrar. Loja ja Existente. Tente Novamente.</p>
                    </div>
                    <?php
                    endif;
                    unset($_SESSION['loja_erro'])
                    ?>

                    <div class="box">
                        <form action="cadastrarlojaback.php" method="POST">

                            <div class="field">
                                <div class="control">
                                    <input name="nomeloja" type="text" class="input is-large" placeholder="Nome da Loja">
                                </div>
                            </div>

                            <div class="field">
                                <div class="control">
                                    <input name="cnpj" class="input is-large" type="number" placeholder="CNPJ(Sem Pontuação)">
                                </div>
                            </div>

                            <div class="field">
                                <div class="control">
                                    <input name="endereco" type="text" class="input is-large" placeholder="Endereço" autofocus>
                                </div>
                            </div>

                            <div class="field">
                                <div class="select is-large">
                                    <select name="Select_Cidades">
                                        <option> -> Cidades <- </option>
                                            <?php $query = select("cidade", "*");
                                                for($cont = 0; $cont < count($query); $cont++){ ?>
                                                <option value="<?php echo $query[$cont]['id_cidade']; ?>"> <?php echo $query[$cont]['nm_cidade']; ?> </option>
                                            <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="field">
                                <div class="control">
                                    <input name="num_endereco" type="number" class="input is-large" placeholder="Numero" autofocus>
                                </div>
                            </div>

                            <div class="field">
                                <div class="control">
                                    <input name="bairro" type="text" class="input is-large" placeholder="Bairro" autofocus>
                                </div>
                            </div>

                            <div class="field">
                                <div class="control">
                                    <input name="cep" type="number" class="input is-large" placeholder="Cep" autofocus>
                                </div>
                            </div>

                            <div class="field">
                                <div class="control">
                                    <input name="telefone" type="text" class = "input is-large" placeholder="Telefone">
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