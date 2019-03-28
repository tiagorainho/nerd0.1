<?php
session_start();
    include('connection.php');
    $user=$_SESSION['user_info']['email'];
    $nome=$_SESSION['user_info']['nome'];
    $password=$_SESSION['user_info']['password'];
    $query="SELECT * FROM data WHERE email='$user' and password='$password'  and active='1'";
    $run_query= mysqli_query($connection,$query);
    $result=mysqli_num_rows($run_query);
    if($result==1){
        date_default_timezone_set("Europe/Lisbon");
        $material=$_GET['material'];
        $nome_projeto=$_GET['projeto'];
        $query="SELECT * FROM inventario_projetos WHERE material='$material' and active='0' and quantidade!='0' and nome_projeto='$nome_projeto'";
        $run_query= mysqli_query($connection,$query);
        $row=mysqli_fetch_array($run_query);
        $imagem=$row['imagem'];
        if($imagem!="logo_nerd.png"){
            $path="assets/img/projetos/".$imagem;
            if(!unlink($path)){
                echo "<p style='color:red; font-size:40px'>A imagem já foi apagada!</p>";
            }
            else{
                $imagem="";
                $query_update="UPDATE inventario_projetos SET imagem = '$imagem' WHERE material = '$material' and active='0' and quantidade!='0' and nome_projeto='$nome_projeto'";
                $run_query= mysqli_query($connection,$query_update);
                header("Location:material.php?nome_projeto=$nome_projeto&&material=$material");
            } 
        }
    }
    else{
        header("Location:utilizador_nao_identificado.php");
    }
?>