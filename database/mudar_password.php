<?php
    session_start();
    include('connection.php');
    $user=$_SESSION['user_info']['email'];
    $password=$_SESSION['user_info']['password'];
    $nome=$_SESSION['user_info']['nome'];
    $nome_user=$nome;
    $query="SELECT * FROM data WHERE email='$user' and password='$password' and active='1'";
    $run_query= mysqli_query($connection,$query);
    $result=mysqli_num_rows($run_query);
    if($result==1){
        date_default_timezone_set("Europe/Lisbon");
        $row=mysqli_fetch_array($run_query);
        $codigo_validacao=$row['password_confirmacao'];
        $tentativa=$row['tentativa'];
        $imagem=$row['imagem'];
        if(strlen($imagem)==0){
            $imagem="logo_nerd.png";
        }
        $ultimo_comunicado_visto=$row['ultimo_comunicado'];
        $query_notificacao="SELECT * FROM comunicados ORDER BY ID DESC LIMIT 1";
        $run_query_notificacao= mysqli_query($connection,$query_notificacao);
        $ult_id=mysqli_fetch_array($run_query_notificacao);
        $ultimo_comunicado=$ult_id['id'];
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Projects - NerD</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:300,400,700">
    <link rel="stylesheet" href="assets/fonts/ionicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pikaday/1.6.1/css/pikaday.min.css">
    
    
    <style>
        tr:hover td {
              background-color: #F2F0EB; <?php //#E9DFCA  #D8CDB5 EEE8D7?>
              color:#000000;
        }
        input[type="checkbox"]{
          width: 20px;
          height: 20px;
          cursor: pointer;
            <?php
          //-webkit-appearance: none;
          //appearance: none;
        ?>
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-dark navbar-expand-lg fixed-top bg-white portfolio-navbar gradient">
        <div class="container"><a class="navbar-brand logo" href="#">Brand</a><button class="navbar-toggler" data-toggle="collapse" data-target="#navbarNav"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse"
                id="navbarNav">
                <ul class="nav navbar-nav ml-auto">
                    <li class="nav-item" role="presentation"><a class="nav-link" href="comunicados.php">Comunicados
                    <?php
                    if($ultimo_comunicado>$ultimo_comunicado_visto){
                        ?>
                            <img width="20px" src="assets/img/estrutura/notificacao.png">
                        <?php
                    }
                    ?>
                    </a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link active" href="projects_images_grid.php">Projectos</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link" href="users.php">Users</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link" href="inventario.php">Inventário</a></li>
                    <li class="dropdown nav-item"><a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#"><img width="30" height="30" class="rounded-circle" src="assets/img/users/<?php echo $imagem ?>"> <?php echo $nome ?></a>
                                <div class="dropdown-menu" role="menu"><a class="dropdown-item" role="presentation" href="minha_conta.php">Minha conta</a><a class="dropdown-item" role="presentation" href="log_out.php">Log out</a>
                                <!--<a class="dropdown-item" role="presentation" href="#">Log out</a>-->
                                </div>
                            </li>
                </ul>
            </div>
        </div>
    </nav>
    <main class="page users-page">
        <section class="portfolio-block projects-cards">
            <div class="container" align="center">
                <div class="heading">
                    <h5 style="color:grey">Inserir password</h5>
                </div>        
                
                <?php
               
                    if($_SERVER["REQUEST_METHOD"]=="POST"){
                        $raw_password1=$_POST['raw_password1'];
                        $raw_password2=$_POST['raw_password2'];
                        $raw_password=$_POST['raw_password'];
                        
                        $password_antiga_filtered=filter_var($raw_password,FILTER_SANITIZE_STRING);
                        $password_antiga=hash("sha256",$password_antiga_filtered);
                        $password_filtered=filter_var($raw_password1,FILTER_SANITIZE_STRING);
                        $password_nova=hash("sha256",$password_filtered);

                            if(strlen($codigo_validacao)!=0){
                                if($raw_password1==$raw_password2){
                                    if($password_antiga==$password){
                                        if($codigo_validacao==$tentativa){
                                            $query_update="UPDATE data SET password='$password_nova', password_confirmacao = '', tentativa='' WHERE nome = '$nome' and password='$password'";
                                            $run_query = mysqli_query($connection,$query_update);

                                            //$query_update="UPDATE data SET password = '$password' WHERE nome = '$nome' and password='$password'";
                                            //$run_query2 = mysqli_query($connection,$query_update);
                                            if($run_query){
                                                ?>
                                                    <p style="color:green">Password alterada com sucesso !</p>
                                                <?php
                                                //unset($_SESSION['password']);
                                                $_SESSION['user_info']['password']=$password_nova;
                                                header("Location:minha_conta.php");
                                             }
                                            else{
                                                ?>
                                                    <p style="color:red">Não foi possivel aceder à base de dados!</p>
                                                <?php
                                            }
                                        }
                                        else{
                                            echo "Código de validação errado!";
                                        }
                                    }
                                    else{
                                        echo "Password atual errada.";
                                    }
                                }
                                else{
                                    echo "<p style='color:orange'>Passwords não são iguais.</p>";
                                }


                            }
                            else if($result==0){
                               echo "Não solicitaste mudança de password!";

                            }
                            else{
                                echo "erro !!";
                            }

                        mysqli_close($connection);
                    }
                    ?>
                <div class="container">
                <form method="post" action="<?php echo $_SERVER['PHP_SELF']?>">
                       <input name=raw_password class="form-control" type="password" required="" placeholder="Password atual"><br>
                        <input name=raw_password1 class="form-control" type="password" required="" placeholder="Nova password"><br>
                        <input name=raw_password2 class="form-control" type="password" required="" placeholder="Repita">
                        <button class="btn btn-info mt-2" type="submit">Confirmar</button>
                </form>
                      
                                    
                </div>
            </div>
        </section>
    </main>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pikaday/1.6.1/pikaday.min.js"></script>
    <script src="assets/js/theme.js"></script>
</body>

</html>
<?php
}
else{
    header("Location:utilizador_nao_identificado.php");
}
?>

