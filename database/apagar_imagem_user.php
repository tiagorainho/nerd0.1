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
        $row=mysqli_fetch_array($run_query);
        $imagem=$row['imagem'];
        if($imagem!="logo_nerd.png"){
            $path="assets/img/users/".$imagem;
            if(!unlink($path)){
                echo "<p style='color:red; font-size:40px'>A imagem já foi apagada!</p>";
            }
            else{
                $imagem="";
                $query_update="UPDATE data SET imagem = '$imagem' WHERE email = '$user'";
                $run_query= mysqli_query($connection,$query_update);
                header("Location:minha_conta.php");
            } 
        }
    }
    else{
        header("Location:utilizador_nao_identificado.php");
    }
?>