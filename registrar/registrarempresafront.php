<?php
session_start();
include("../Connection/connect.php");
?>

<!DOCTYPE html>
<html>
    
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistema de Cadastro</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
    <link rel="stylesheet" href="../css/bulma.min.css" />
    <link rel="stylesheet" type="../text/css" href="../css/login.css">
</head>

<body>
    <section class="hero is-success is-fullheight">
        <div class="hero-body">
            <div class="container has-text-centered">
                <div class="column is-4 is-offset-4">
                    <h3 class="title has-text-grey">Sistema de Cadastro</h3>
                    
                    <?php
                    if(isset($_SESSION['email_existe'])):
                    ?>
                    <div class="notification is-success">
                      <p>E-mail ja cadastrado! Informe outro e tente novamente</p>
                    </div>
                    <?php
                    endif;
                    unset($_SESSION['email_existe'])
                    ?>

                    <?php
                    if(isset($_SESSION['cnpj_existe'])):
                    ?>
                    <div class="notification is-info">
                        <p>CNPJ ja cadastrado! Informe outro e tente novamente</p>
                    </div>
                    <?php
                    endif;
                    unset($_SESSION['cnpj_existe'])
                    ?>

                    <?php
                    if(isset($_SESSION['cadastrado'])):
                    ?>
                    <div class="notification is-info">
                        <p>Cadastro Concluido com Sucesso!</p>
                        <p>Faça Login Informando seus dados em <a href="login.php">AQUI</a> </p>
                    </div>
                    <?php
                    endif;
                    unset($_SESSION['cadastrado'])
                    ?>

                    <?php
                    if(isset($_SESSION['cadastro_erro'])):
                    ?>
                    <div class="notification is-info">
                        <p>Erro Ao Cadastrar Empresa</p>
                        <p>Tente Novamente! Caso o Erro Persista nos envie um FEEDBACK</p>
                    </div>
                    <?php
                    endif;
                    unset($_SESSION['cadastro_erro'])
                    ?>

                    <div class="box">
                        <form action="registrarempresaback.php" method="POST">
                            <div class="field">
                                <div class="control">
                                    <input name="name" type="text" class="input is-large" placeholder="Nome Da Empresa" autofocus>
                                </div>
                            </div>

                            <div class="field">
                                <div class="control">
                                    <input name="email" type="text" class="input is-large" placeholder="E-mail">
                                </div>
                            </div>

                            <div class="field">
                                <div class="control">
                                    <input name="password" class="input is-large" type="password" placeholder="Senha">
                                </div>
                            </div>

                            <div class="field">
                                <div class="control">
                                    <input name="cnpj" type="text" class="input is-large" placeholder="cnpj" autofocus>
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
                                    <input name="num_endereco" type="text" class="input is-large" placeholder="Numero" autofocus>
                                </div>
                            </div>

                            <div class="field">
                                <div class="control">
                                    <input name="bairro" type="text" class="input is-large" placeholder="Bairro" autofocus>
                                </div>
                            </div>

                            <div class="field">
                                <div class="control">
                                    <input name="cep" type="text" class="input is-large" placeholder="Cep" autofocus>
                                </div>
                            </div>

                            <div class="field">
                                <div class="control">
                                    <input name="telefone" type="text" class="input is-large" placeholder="Telefone" autofocus>
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