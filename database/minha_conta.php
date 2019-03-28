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
         $row=mysqli_fetch_array($run_query);
            $ultimo_comunicado_visto=$row['ultimo_comunicado'];
            $imagem=$row['imagem'];
            $hobbies=$row['hobbies'];
            $date_time=$row['date_time'];
            $curso=$row['curso'];
            $facebook=$row['facebook'];
            $instagram=$row['instagram'];
            $slack=$row['slack'];
            $twitter=$row['twitter'];
            $telemovel=$row['telemovel'];
            $reddit=$row['reddit'];
            $codigo_confirmacao=$row['password_confirmacao'];
            $date=date('d-m-Y', strtotime($date_time));
        
            if(strlen($imagem)==0){
                $imagem="logo_nerd.png";
            }
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
                                <!--<a class="dropdown-item" role="presentation" href="#">Third Item</a>-->
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
                    <!--<h2>Olá <?php //echo $nome ?></h2>-->
                    <h2>Minha conta</h2>
                    
                <?php
                if($_SERVER["REQUEST_METHOD"]=="POST"){
                    $raw_telemovel=trim($_POST['raw_telemovel']);
                    $telemovel_filtered=filter_var($raw_telemovel,FILTER_SANITIZE_STRING);
                    
                  /*  if(is_numeric($telemovel_filtered) || strlen($telemovel_filtered)==0){
                        if(strlen($telemovel_filtered)==9 || strlen($telemovel_filtered)==0){
                            */
                            $raw_curso=trim($_POST['raw_curso']);
                            $raw_hobbies=trim($_POST['raw_hobbies']);
                            $raw_slack=trim($_POST['raw_slack']);
                            $raw_facebook=trim($_POST['raw_facebook']);
                            $raw_instagram=trim($_POST['raw_instagram']);
                            $raw_twitter=trim($_POST['raw_twitter']);
                            $raw_reddit=trim($_POST['raw_reddit']);

                            $curso_filtered=filter_var($raw_curso,FILTER_SANITIZE_STRING);
                            $hobbies_filtered=filter_var($raw_hobbies,FILTER_SANITIZE_STRING);
                            $slack_filtered=filter_var($raw_slack,FILTER_SANITIZE_STRING);
                            $facebook_filtered=filter_var($raw_facebook,FILTER_SANITIZE_STRING);
                            $instagram_filtered=filter_var($raw_instagram,FILTER_SANITIZE_STRING);
                            $twitter_filtered=filter_var($raw_twitter,FILTER_SANITIZE_STRING);
                            $reddit_filtered=filter_var($raw_reddit,FILTER_SANITIZE_STRING);
                            if(strlen($telemovel)!=0 && is_numeric($telemovel_filtered)){
                                if(strlen($telemovel_filtered)==9){
                                    $query_update="UPDATE data SET telemovel = '$telemovel_filtered' WHERE email = '$user'";
                                    $run_query = mysqli_query($connection,$query_update);
                                    if(!$run_query){
                                         echo "<p style='color:red; font-size:20px'>Telémovel não foi atualizado!</p>";
                                    }
                                }
                                else{
                                    echo "<p style='color:red'>Número de telémovel não aceite, certifique-se que tem 9 digitos</p>";
                                }
                            }
                            else{
                                ?>
                                <script>
                                    alert("<p style='color:red; font-size:20px'>Telémovel não foi atualizado!</p>");
                                    alert("<p style='color:red'>Número de telémovel é apenas constituido por números</p>");
                                </script>
                                <?php
                            }
                            if(strlen($curso_filtered)!=0){  
                                $query_update="UPDATE data SET curso = '$curso_filtered' WHERE email = '$user'";
                                $run_query = mysqli_query($connection,$query_update);
                                if(!$run_query){
                                    echo "<p style='color:red; font-size:20px'>Curso não foi atualizado!</p>";
                                }
                            }
                            if(strlen($hobbies_filtered)!=0){
                                $query_update="UPDATE data SET hobbies = '$hobbies_filtered' WHERE email = '$user'";
                                $run_query = mysqli_query($connection,$query_update);
                                if(!$run_query){
                                    echo "<p style='color:red; font-size:20px'>Hobbies não foram atualizados!</p>";
                                }
                            }
                            if(strlen($slack_filtered)!=0){
                                $query_update="UPDATE data SET slack = '$slack_filtered' WHERE email = '$user'";
                                $run_query = mysqli_query($connection,$query_update);
                                if(!$run_query){
                                    echo "<p style='color:red; font-size:20px'>Slack não foi atualizado!</p>";
                                }
                            }
                            if(strlen($facebook_filtered)!=0){
                                $query_update="UPDATE data SET facebook = '$facebook_filtered' WHERE email = '$user'";
                                $run_query = mysqli_query($connection,$query_update);
                                if(!$run_query){
                                    echo "<p style='color:red; font-size:20px'>Facebook não foi atualizado!</p>";
                                }
                            }
                            if(strlen($instagram_filtered)!=0){
                                $query_update="UPDATE data SET instagram = '$instagram_filtered' WHERE email = '$user'";
                                $run_query = mysqli_query($connection,$query_update);
                                if(!$run_query){
                                    echo "<p style='color:red; font-size:20px'>Instagram não foi atualizado!</p>";
                                }
                            }
                            if(strlen($twitter_filtered)!=0){
                                $query_update="UPDATE data SET twitter = '$twitter_filtered' WHERE email ='$user'";
                                $run_query = mysqli_query($connection,$query_update);
                                if(!$run_query){
                                    echo "<p style='color:red; font-size:20px'>Twitter não foi atualizado!</p>";
                                }
                            }
                            if(strlen($reddit_filtered)!=0){
                                $query_update="UPDATE data SET reddit = '$reddit_filtered' WHERE email ='$user'";
                                $run_query = mysqli_query($connection,$query_update);
                                if(!$run_query){
                                    echo "<p style='color:red; font-size:20px'>Reddit não foi atualizado!</p>";
                                }
                            }
                            header("Location:minha_conta.php");
                       /* }
                        else{
                            echo "<p style='color:red ; font-size:25px'>Operação cancelada!</p>";
                            echo "<p style='color:red'>Número de telémovel não aceite, certifique-se que tem 9 digitos</p>";
                        }
                    }
                    else{
                        echo "<p style='color:red ; font-size:25px'>Operação cancelada!</p>";
                        echo "<p style='color:red'>Número de telémovel é apenas constituido por números</p>";
                    }  */
                }
                ?>   
                </div>
                <div align="left">
                    <div class="row people">
                        <!--<div class="col-md-6 col-lg-4 item"><img alt="Fotografia de <?php //echo $nome?>" width="225" class="" src="assets/img/users/<?php //echo $imagem ?>">-->
                            <div class="col-md-6 col-lg-4 item"><img alt="Fotografia de <?php echo $nome ?> (adicionar uma foto quadrada para melhor resolução)" width="200" height="200" class="rounded-circle" src="assets/img/users/<?php echo $imagem ?>">
                            <h3 class="name"><?php echo $nome ?></h3>
                            <p class="title">Curso: <?php echo $curso ?></p>
                            <p class="description">Hobbies: <?php echo $hobbies ?> </p>
                            <p class="title">Data de registo no NerD: <?php echo $date ?></p>
                            <div class="social"><a href="#"><i class="fa fa-facebook-official"></i></a><a href="#"><i class="fa fa-twitter"></i></a><a href="#"><i class="fa fa-instagram"></i></a></div>
                            
                        </div>
                        <div class="col-md-6 col-lg-4 item">
                           <?php echo "<br><br><br><br>"; ?>
                            <h3 class="name">Contactos</h3>
                            <p class="description">Email: <?php echo $user ?></p>
                            <p class="description">Slack: <?php echo $slack ?></p>
                            <p class="description">Facebook: <?php echo $facebook ?></p>
                            <p class="description">Instagram: <?php echo $instagram ?> </p>
                            <p class="description">Twitter: <?php echo $twitter ?></p>
                            <p class="description">Reddit: <?php echo $reddit ?></p>
                            <p class="description">Telemóvel: <?php 
                                    if(($telemovel!=0)){
                                    echo $telemovel;
                                    }
                                    ?></p>
                            <div class="social"><a href="#"><i class="fa fa-facebook-official"></i></a><a href="#"><i class="fa fa-twitter"></i></a><a href="#"><i class="fa fa-instagram"></i></a></div>
                            
                        </div>
                        <?php
        
        
                        $query="SELECT * FROM data WHERE email='$user' and active='1' and hierarquia='2'"; //and nome='$nome'
                        $run_query= mysqli_query($connection,$query);
                        $result=mysqli_num_rows($run_query);
                        
                        if($result==1){
                            
                        
                        ?>
                       <div class="col-md-6 col-lg-4 item">
                           <?php echo "<br>"; ?>
                            <h1 class="name" style="color:red"><tt style="color:#B2725B ; font-size:60px">ADMIN</tt></h1>
                            <p class="description" style="color:#D18468">SUPER POWERS GRANTED!</p>
                            <div class="social"><a href="#"><i class="fa fa-facebook-official"></i></a><a href="#"><i class="fa fa-twitter"></i></a><a href="#"><i class="fa fa-instagram"></i></a></div>
                            
                        </div>
                        <?php
                        }
                        ?>
                        
                    </div>
                </div>
                <?php echo "<br><br>" ?>
                <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
                        <div class="form-group"><label class="text-secondary"><p style="font-size:20px">Adicionar/alterar informação</p></label>
                        <input name=raw_curso class="form-control" type="text" placeholder="Curso"><br>
                        <input name=raw_hobbies class="form-control" type="text" placeholder="Hobbies"><br>
                        <input name=raw_telemovel class="form-control" type="text" placeholder="Telemóvel"><br>
                        <input name=raw_slack class="form-control" type="text" placeholder="Slack"><br>
                        <input name=raw_facebook class="form-control" type="text" placeholder="Facebook"><br>
                        <input name=raw_instagram class="form-control" type="text" placeholder="Instagram"><br>
                        <input name=raw_twitter class="form-control" type="text" placeholder="Twitter"><br>
                        <input name=raw_reddit class="form-control" type="text" placeholder="Reddit"><br>
                        </div>
                        <button class="btn btn-info mt-2" type="submit">Guardar</button>
                </form>
            </div>
        </section>
        <div align="right">
            <?php if(strlen($codigo_confirmacao)==0){ ?>
             <form action="criar_codigo_autentificacao.php" method="post">
                  <button class="btn btn-info mt-2" type="submit" name="submit">Mudar password</button>
              </form>
              <?php }
                else if(strlen($codigo_confirmacao)!=0){ ?>
                    <form action="validar_codigo_autentificacao.php" method="">
                        <button class="btn btn-info mt-2" type="submit" name="submit">Validar código para mudar de password</button>
                    </form> <?php
                }   
                else{ ?>
                    <form action="criar_codigo_autentificacao.php" method="post">
                        <button class="btn btn-info mt-2" type="submit" name="submit">Mudar password</button>
                    </form> <?php
                }
                ?>
              <p></p>
              <form action="upload_imagem_users.php" method="post" enctype="multipart/form-data">
                    <input type="file" name="file" id="fileToUpload">
                    <button  class="btn btn-info mt-2" type="submit" name="submit">Upload Foto Perfil</button>
              </form>
              <form action="apagar_imagem_user.php" method="post">
                  <button class="btn btn-info mt-2" type="submit" name="submit">Apagar Foto de perfil atual</button>
              </form>
        </div>
        <?php echo "<br><br>" ?>
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