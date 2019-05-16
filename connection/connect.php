<?php 
// Função para connectar ao banco de dados
function connect($database="e_web",$user="root",$password="",$hostname="localhost"){
    // Tentar Connectar ao banco de dados
    $connect = mysqli_connect($hostname, $user, $password);
    // Conseguiu Connectar?
    if(!$connect){
        die(trigger_error("Não Foi possivel estabelecer a conexão!"));
        return false;
    }else{
        // Tenta selecionar o banco de dados
        $db = mysqli_select_db($connect, $database);
        // Conseguiu Selecionar o Banco?
        if(!$db){
            die(trigger_error("Não foi possivel selecionar o banco de dados!"));
            return false;
        }else{
            return $connect;
        }
    }
}

//Função Para Fechar Conexão
function CloseConnection($connection){
    // tenta fechar a Conexão
    $close = mysqli_close($connection);
    // Fechou a Conexão?
    if(!$close){
        // Caso der Erro
        echo "Impossivel Fechar a Conexão";
        return false;
    }else{
        // Caso Fechar a conexão
        return true;
    }
}

function insert($column, $value, $table){
    // Todos os Dados são Arrays?
    if((is_array($column)) and (is_array($value))){
        // Tem os mesmos numeros de elementos? 
        if(count($column) == count($value)){
            // Montar a SQL  INSERT INTO usuario (nome, email, senha) VALUES ('william', 'williamiatic@gmail.com', '123');
            $insert = "INSERT INTO {$table} (".implode(', ', $column).")
            VALUES ('".implode('\', \'',$value)."')";
        }else{
            return false;
        }
    }else{
        // montar SQL   INSERT INTO (usuario) (nome) VALUES (william);
        $insert = "INSERT INTO {$table} ({$column}) VALUES ('{$value}')";
    }
    // Connectou?
    if($connection = connect()){
        // Dados Inseridos?
        if(mysqli_query($connection, $insert)){
            // Fecha a Conexão
            CloseConnection($connection);
            return true;
        }else {
            echo "Query Invalida!";
            return false;
        }
    }else{
        return false;
    }
}
// Deletar Itens do banco de Dados
function delete($table, $where=Null){
    // Montar a SQL
    $delete = "DELETE from {$table} {$where}";
    // Conectou?
    if($connection = connect()){
        // Deletou?
        if(mysqli_query($connection, $delete)){
            //Fecha Conexao
            CloseConnection($connection);
            return true;
        }else{
            // Mostrar Mensagem de Erro
            echo "Query Invalida {$delete}";
            return false;
        }
    }else{
        return false;
    }
}

//Alterar Valores dentro do banco de dados
function update($column, $value, $table, $where){
    // Todos os Dados são Arrays?
    if((is_array($column)) and (is_array($value))){
        // Tem os mesmos numeros de elementos? 
        if(count($column) == count($value)){

            $value_column = NULL;

            // Colocar Arrays em uma string
            for($cont = 0; $cont < count($column); $cont++ ){

                $value_column .= "{$column[$cont]} = '{$value[$cont]}',";
            }

            // Tirando a virgula da ultima posição
            $value_column = substr($value_column, 0, -1);

            // Montar a SQL SE VINHER EM ARRAYS
            $update = "UPDATE {$table} SET {$value_column} {$where}";

        }else{
            return false;
        }
    }else{
        // montar SQL CASO NÃO VENHA EM ARRAYS
    $update = "UPDATE {$table} SET {$column} = '{$value}' {$where}";
    }
    // Connectou?
    if($connection = connect()){
        // Dados Inseridos?
        if(mysqli_query($connection, $update)){
            // Fecha a Conexão
            CloseConnection($connection);
            return true;
        }else {
            echo "Query Invalida!";
            return false;
        }
    }else{
        return false;
    }
}

//Listar valores do banco de dados
function select($table, $column="*", $where=NULL, $order=NULL, $limit=NULL){
    
    // SQL DA CONSULTA
    $select = "SELECT {$column} FROM {$table} {$where} {$order} {$limit}";

    // Conseguiu Connectar?
    if($connection = connect()){

        //Conseguiu Consultar?
        if($query = mysqli_query($connection, $select)){
            // Encontrou o Valor?
            if(mysqli_num_rows($query) > 0){
                
                $all_result = array();

                while($result = mysqli_fetch_assoc($query)){

                    $all_result[] = $result;
                }
                // Fecha Conexão
                CloseConnection($connection);

                return $all_result;

            }else{
                return false;
            }
        }else{
            return false;
        }
    }else{
        return false;
    }
}

function nulo($dados){
    return (empty($dados) ? null : $dados );
}
?>