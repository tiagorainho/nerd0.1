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
        $nome_projeto=$_GET['nome_projeto'];
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
                   <h2><?php echo $nome_projeto; ?></h2>
                    <h7 style="color:grey">Adicionar inventário ao projeto</h7>
                </div>        
                
                <?php
               
                    if($_SERVER["REQUEST_METHOD"]=="POST"){
                    $raw_nome=trim($_POST['raw_nome']);
                    $raw_quantidade=trim($_POST['raw_quantidade']);
                    include('connection.php');
                    $nome_projeto=$_GET['nome_projeto'];
                        
                    $nome=filter_var($raw_nome,FILTER_SANITIZE_STRING);
                    $quantidade=filter_var($raw_quantidade,FILTER_SANITIZE_STRING);
                    
                    if(is_numeric($quantidade)){
                        $today = date("Y-m-d H:i:s");
                        $query="SELECT *FROM inventario_projetos WHERE material='$nome' and nome_projeto='$nome_projeto'";
                        $run_query= mysqli_query($connection,$query);
                        $result=mysqli_num_rows($run_query);
                    
                    
                        if($result==1){
                            $row=mysqli_fetch_array($run_query);
                            $quantidade_final=$quantidade+$row['quantidade'];
                            $id=$row['id'];

                            $query_update="UPDATE inventario_projetos SET quantidade = '$quantidade_final' WHERE id = '$id'";

                            $run_query = mysqli_query($connection,$query_update);

                            if($run_query){
                                ?>
                                    <p style="color:green">Adicionadas <?php echo $quantidade ?> unidades de <?php echo $nome ?> ao projeto <?php echo $nome_projeto ?></p>
                                <?php
                             }
                            else{
                                ?>
                                    <p style="color:red">Não foi possivel aceder à base de dados!</p>
                                <?php
                            }

                        }
                        else if($result==0){
                            $query= "INSERT INTO inventario_projetos (id,nome_projeto,quantidade,date_time,quem_adicionou,material) VALUES ('NULL','$nome_projeto','$quantidade','$today','$nome_user','$nome')";

                            $run_query = mysqli_query($connection,$query);

                            if($run_query){

                                ?>
                                    <p style="color:green"> <?php echo $quantidade ?> unidades de <?php echo $nome ?> foram registadas com sucesso!</p>
                                <?php
                             }
                            else{
                                ?>
                                    <p style="color:red">Não foi possivel aceder à base de dados!</p>
                                <?php
                            }

                        }
                    }
                    
                    else { 
                        ?>
                        <p style="color:red">A quantidade tem que ser digitos</p>
                        <?php
                    }
                    
                    mysqli_close($connection);
                }         
                ?>
                <div class="container">
                <form method="post" action="<?php echo $_SERVER['PHP_SELF']?>?nome_projeto=<?php echo $nome_projeto ?>">
                        <div class="form-group"><label class="text-secondary">Nome</label>
                        <input name=raw_nome class="form-control" type="text" required="" inputmode="text"></div>
                        <div class="form-group"><label class="text-secondary">Quantidade</label>
                        <input name=raw_quantidade class="form-control" type="text" required="" inputmode="text"></div>
                        <button class="btn btn-info mt-2" type="submit">Adicionar</button>
                </form>
                 <div align="left">
                     <p class="mt-3 mb-0"><a href="project_page.php?nome_projeto=<?php echo $nome_projeto; ?>" class="text-info small">Voltar</a></p>
                 </div>     
                                    
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

