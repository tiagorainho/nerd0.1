<?php
session_start();
    include('connection.php');
    $user=$_SESSION['user_info']['email'];
    $nome=$_SESSION['user_info']['nome'];
    $password=$_SESSION['user_info']['password'];
    $query="SELECT * FROM data WHERE email='$user' and password='$password' and active='1'";
    $run_query= mysqli_query($connection,$query);
    $result=mysqli_num_rows($run_query);
    if($result==1){
        $imagem=$_GET['imagem'];
        $nome_projeto=$_GET['projeto'];
        $path="assets/img/projetos/".$imagem;
        if(!unlink($path)){
            echo "<p style='color:red; font-size:40px'>A imagem já foi apagada!</p>";
        }
        else{
            $imagem="";
            $query_update="UPDATE projetos SET imagem = '$imagem' WHERE nome = '$nome_projeto'";
            $run_query= mysqli_query($connection,$query_update);
            header("Location:project_page.php?nome_projeto=$nome_projeto");
        } 
    }
    else{
        header("Location:utilizador_nao_identificado.php");
    }
?>