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
        date_default_timezone_set("Europe/Lisbon");
        $nome_projeto=$_GET['nome_projeto'];
                            
        $query_apagar="UPDATE inventario_projetos SET active = '1' WHERE user = '$nome' and nome_projeto='$nome_projeto'";
        $run_query_a = mysqli_query($connection,$query_apagar);
                
        $query_quem_apagou="UPDATE inventario_projetos SET quem_apagou = '$user' WHERE user = '$nome' and nome_projeto='$nome_projeto'";
        $run_query_quem_apagou = mysqli_query($connection,$query_quem_apagou);
                            
        $query_date="UPDATE inventario_projetos SET date_time = '$today' WHERE user = '$nome'";
        $run_query_data = mysqli_query($connection,$query_date);
                            
        if($run_query_a && $run_query_quem_apagou && $run_query_data){
            header("Location:project_page.php?nome_projeto=$nome_projeto");
        }
        else{
            echo "Erro";
        }
}
else{
    header("Location:utilizador_nao_identificado.php");
}
?>

