<?php
    session_start();
    include('connection.php');
    $user=$_SESSION['user_info']['email'];
    $password=$_SESSION['user_info']['password'];
    $nome=$_SESSION['user_info']['nome'];
    $query="SELECT * FROM data WHERE email='$user' and password='$password' and active='1'";
    $run_query= mysqli_query($connection,$query);
    $result=mysqli_num_rows($run_query);
    $row=mysqli_fetch_array($run_query);
    $imagem_proprio=$row['imagem'];
    $ultimo_comunicado_visto=$row['ultimo_comunicado'];

    if($result==1){
        date_default_timezone_set("Europe/Lisbon");
        $query_notificacao="SELECT * FROM comunicados ORDER BY ID DESC LIMIT 1";
        $run_query_notificacao= mysqli_query($connection,$query_notificacao);
        $ult_id=mysqli_fetch_array($run_query_notificacao);
        $ultimo_comunicado=$ult_id['id'];
        
        $row=mysqli_fetch_array($run_query);
        $imagem_proprio=$row['imagem'];
        $id=$_GET['id'];
        $query="SELECT * FROM data WHERE id='$id' and active='1'";
        $run_query= mysqli_query($connection,$query);
        
        $result_search=mysqli_num_rows($run_query);
        if($result_search>0){
        
             $row=mysqli_fetch_array($run_query);
                $nome_user=$row['nome'];
                $email_user=$row['email'];
                $imagem_user=$row['imagem'];
                $hobbies=$row['hobbies'];
                $date_time=$row['date_time'];
                $curso=$row['curso'];
                $facebook=$row['facebook'];
                $instagram=$row['instagram'];
                $slack=$row['slack'];
                $twitter=$row['twitter'];
                $telemovel=$row['telemovel'];
                $reddit=$row['reddit'];
                $date=date('d-m-Y', strtotime($date_time));

                if(strlen($imagem_user)==0){
                    $imagem_user="logo_nerd.png";
                }
                if(strlen($imagem_proprio)==0){
                    $imagem_proprio="logo_nerd.png";
                }
        
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
                    <li class="dropdown nav-item"><a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#"><img width="30" height="30" class="rounded-circle" src="assets/img/users/<?php echo $imagem_proprio ?>"> <?php echo $nome ?></a>
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
                    <h2><?php echo $nome_user ?></h2> 
                </div>
                <div align="left">
                    <div class="row people">
                            <div class="col-md-6 col-lg-4 item"><img alt="Fotografia de <?php echo $nome_user ?>" width="200" height="200" class="rounded-circle" src="assets/img/users/<?php echo $imagem_user ?>">
                            <h3 class="name"><?php echo $nome_user ?></h3>
                            <p class="title">Curso: <?php echo $curso ?></p>
                            <p class="description">Hobbies: <?php echo $hobbies ?> </p>
                            <p class="title">Data de registo no NerD: <?php echo $date ?></p>
                            <div class="social"><a href="#"><i class="fa fa-facebook-official"></i></a><a href="#"><i class="fa fa-twitter"></i></a><a href="#"><i class="fa fa-instagram"></i></a></div>
                            
                        </div>
                        <div class="col-md-6 col-lg-4 item">
                           <?php echo "<br><br><br><br>"; ?>
                            <h3 class="name">Contactos</h3>
                            <p class="description">Email: <?php echo $email_user ?></p>
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
        
        
                        $query="SELECT * FROM data WHERE email='$email_user' and hierarquia='2' and active='1'";
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
                <div align="left">
                    <p class="mt-3 mb-0" style="font-size:20px"><a href="users.php" class="text-info small">Voltar</a></p>
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
        echo "Utilizador não encontrado";
    }
                            
}
else{
    header("Location:utilizador_nao_identificado.php");
}
?>