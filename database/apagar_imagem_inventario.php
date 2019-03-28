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
        $query="SELECT * FROM inventario WHERE nome='$material' and active='1'";
        $run_query= mysqli_query($connection,$query);
        $row=mysqli_fetch_array($run_query);
        $imagem=$row['imagem'];
        if($imagem!="logo_nerd.png"){
            $path="assets/img/inventario/".$imagem;
            if(!unlink($path)){
                echo "<p style='color:red; font-size:40px'>A imagem já foi apagada!</p>";
            }
            else{
                $imagem="";
                $query_update="UPDATE inventario SET imagem = '$imagem' WHERE nome = '$material' and active='1'";
                $run_query= mysqli_query($connection,$query_update);
                header("Location:material_inventario.php?material=$material");
            } 
        }
    }
    else{
        header("Location:utilizador_nao_identificado.php");
    }
?>