<?php

if (!isset($_SESSION)) session_start();
function logado(){
    if(!empty($_SESSION['id'])){
        //Logado
        }else{
        // Não logado
        header('location: ../index.php');
    }
}