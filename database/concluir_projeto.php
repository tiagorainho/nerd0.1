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
        $query="SELECT * FROM projetos WHERE nome='$nome_projeto'";
        $run_query= mysqli_query($connection,$query);
        $result=mysqli_num_rows($run_query);

        if($result==1){
            $conc=$_GET['operacao'];
            date_default_timezone_set("Europe/Lisbon");
            $today = date("Y-m-d H:i:s");
            $query_update="UPDATE projetos SET concluido = '$conc',data_conclusao='$today' WHERE nome = '$nome_projeto'";
            $run_query = mysqli_query($connection,$query_update);
            
            if($run_query){
                header("Location:project_page.php?nome_projeto=$nome_projeto");
             }
            else{
            ?>
                <p style="color:red">Não foi possivel aceder à base de dados!</p>
            <?php
            }
        }
        else if($result==0){
            echo "O projeto ".$nome_projeto." não foi encontrado na base de dados.";
        }
        else{
            echo "Erro";
        }
    }
    else{
        header("Location:utilizador_nao_identificado.php");
    }
?>