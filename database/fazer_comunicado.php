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
        $row=mysqli_fetch_array($run_query);
        $imagem=$row['imagem'];
        if(strlen($imagem)==0){
            $imagem="logo_nerd.png";
        }
        $ultimo_comunicado_visto=$row['ultimo_comunicado'];
        $query_notificacao="SELECT * FROM comunicados ORDER BY ID DESC LIMIT 1";
        $run_query_notificacao= mysqli_query($connection,$query_notificacao);
        $ult_id=mysqli_fetch_array($run_query_notificacao);
        $ultimo_comunicado=$ult_id['id'];
        date_default_timezone_set("Europe/Lisbon");
        
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
        table,tr,th,td{
           <?php  // ATRIBUTOS DA TABELA
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
    <?php echo "<br><br><br><br><br><br><br><br><br>"; ?>
    <main class="page users-page" align="center">
        <div class="container-fluid">
            <div class="row mh-100vh">
                <div class="m-auto w-lg-75 w-xl-50">
                <h2 class="text-info font-weight-light mb-5"><i class="fa fa-diamond"></i>&nbsp;Fazer comunicado</h2>
                <?php
                if($_SERVER["REQUEST_METHOD"]=="POST"){
                    $today = date("Y-m-d H:i:s");
                    $raw_texto=trim($_POST['texto']);
                    $texto=filter_var($raw_texto,FILTER_SANITIZE_STRING);
                    $query= "INSERT INTO comunicados (id,comunicado,nome,date_time) VALUES ('NULL','$texto','$nome','$today')";
                    $run_query = mysqli_query($connection,$query);
                    
                    $query_notificacao="SELECT * FROM comunicados ORDER BY ID DESC LIMIT 1";
                    $run_query_notificacao= mysqli_query($connection,$query_notificacao);
                    $ult_id=mysqli_fetch_array($run_query_notificacao);
                    $ultimo_comunicado=$ult_id['id'];

                    $query_update_comunicados="UPDATE data SET ultimo_comunicado = '$ultimo_comunicado' WHERE email = '$user'";
                    $run_query_comunicados = mysqli_query($connection,$query_update_comunicados);
                    
                    if($run_query){
                        echo "<p style='color:green ; font-size:20px'>Comunicado efetuado com sucesso</p>";
                        header("Location:comunicados.php");
                    }
                    else{
                        echo "<p style='color:red ; font-size:20px'>Erro ao enviar o comunicado</p>";
                    }
                }
                    ?>
                <div class="heading">
                    <!--<h2>Fazer comunicado</h2>-->
                </div>  
                <?php echo "<br>"?>     
                <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
                    <div class="form-group"><label class="text-secondary"></label>
                        <textarea name="texto" placeholder="Comunicado" rows="10" cols=60% maxlength="2000"></textarea>
                        <div align="left">
                            <p class="mt-3 mb-0"><a href="comunicados.php" class="text-info">Voltar</a></p>
                        </div>
                    </div> 
                    <button class="btn btn-info mt-2" type="submit">Enviar</button>
                </form>
                    </div>
              </div>
        </div>
        <?php echo "<br><br>"; ?>        
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