<?php
    session_start();
    include('connection.php');
    $user=$_SESSION['user_info']['email'];
    $password=$_SESSION['user_info']['password'];
    $nome=$_SESSION['user_info']['nome'];
    $query="SELECT * FROM data WHERE email='$user' and password='$password' and active='1'";
    $run_query= mysqli_query($connection,$query);
    $result=mysqli_num_rows($run_query);
    if($result==1){
        $nome_projeto=$_GET['nome_projeto'];
        date_default_timezone_set("Europe/Lisbon");
        $query="SELECT * FROM inventario_projetos WHERE nome_projeto='$nome_projeto' and user='$nome' and active='0'";
        $run_query= mysqli_query($connection,$query);
        $result=mysqli_num_rows($run_query);
        if($result==0){
        
            $today=date("Y-m-d H:i:s");
            $query= "INSERT INTO inventario_projetos (id,nome_projeto,user,date_time) VALUES ('NULL','$nome_projeto','$nome','$today')";
            $run_query = mysqli_query($connection,$query);
            if(!$run_query){
                echo "Erro ao tentar adicionar $nome ao projeto $nome_projeto";
            }
        }
        header("Location:project_page.php?nome_projeto=$nome_projeto");
        
}
else{
    header("Location:utilizador_nao_identificado.php");
}
?>

