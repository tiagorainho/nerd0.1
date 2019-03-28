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
        /*
        $min=10000000;
        $max=99999999;
        $num_random=rand ( int $min , int $max ) : int
        */
        
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $num_random = '';
        $num;
        for ($i = 0; $i < 14; $i++) {
            $num = $characters[rand(0, strlen($characters))];
            $num_random=$num_random.$num;
        }
        $query_update="UPDATE data SET password_confirmacao = '$num_random' WHERE nome = '$nome' and password='$password'";
        $run_query = mysqli_query($connection,$query_update);
        if(!$run_query){
            echo "erro";
        }
        /*
        $to      = $user;
        $subject = 'Código de autentificação';
        $message = 'Código de autentificação para mudar de password: '.$num_random;
        //$headers = 'From: nerd@ua.pt' . "\r\n" .'Reply-To: webmaster@example.com' . "\r\n" .'X-Mailer: PHP/' . phpversion();
        $headers = 'From: nerd@ua.pt' . "\r\n" . "\r\n" .'X-Mailer: PHP/' . phpversion();
        
        $mail=mail($to, $subject, $message, $headers);    
        if($mail){  */
            header("Location:validar_codigo_autentificacao.php");
/*        }
        else{
            echo "Houve algum erro a mandar o email";
        } */
    }
    else{
        header("Location:utilizador_nao_identificado.php");
    }
?>