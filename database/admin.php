<?php
    session_start();
    include('connection.php');
    $user=$_SESSION['user_info']['email'];
    $nome=$_SESSION['user_info']['nome'];
    $password=$_SESSION['user_info']['password'];
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
        
        $query="SELECT * FROM data WHERE email='$user' and password='$password' and active='1' and hierarquia='2'";
        $run_query= mysqli_query($connection,$query);
        $result=mysqli_num_rows($run_query);
        date_default_timezone_set("Europe/Lisbon");
        if($result==1){
            $hierarquia=2;
        }
        else{
            $hierarquia=0;
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
                    <li class="dropdown nav-item"><a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#"><img width="30" height="30" class="rounded-circle" src="assets/img/users/<?php echo $imagem ?>"> <?php echo $nome ?></a>
                                <div class="dropdown-menu" role="menu"><a class="dropdown-item" role="presentation" href="minha_conta.php">Minha conta</a><a class="dropdown-item" role="presentation" href="log_out.php">Log out</a>
                                <!--<a class="dropdown-item" role="presentation" href="#">Third Item</a>-->
                                </div>
                            </li>
                </ul>
            </div>
        </div>
    </nav>
    <main class="page projects-page">
        <section class="portfolio-block projects-cards" align="center">
            <div class="container">
                <div class="heading">
                    <h2>Admin</h2>
                </div>               
                <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
                       
                       
                        <div class="form-group"><label class="text-secondary"></label>
                        <input name=string_to_search class="form-control" type="text" placeholder="Procurar"></div>
                        <button class="btn btn-info mt-2" type="submit">Procurar</button>
                        
                </form>
                <?php if($hierarquia==2){ ?>
                <div align="right">
                   <button class="btn btn-info mt-2" type="button" ><a href="adicionar_admin.php" style="color:white">Adicionar</a></button>
                </div>
                            <?php
                }
                            echo "<br><br>";
                            include('connection.php');
                            if($_SERVER["REQUEST_METHOD"]=="POST"){
                                $raw_string_to_search=$_POST['string_to_search'];
                                $string_to_search=filter_var($raw_string_to_search,FILTER_SANITIZE_STRING);
                                $query="SELECT * FROM data WHERE nome LIKE '%".$string_to_search."%' and active='1' and hierarquia='2'";
                                $search_admin=mysqli_query($connection,$query);

                                $num_res=mysqli_num_rows($search_admin);
                                if($num_res==0){
                                    echo '<p style="color:orange">Não foram encontrados administradores com o nome &quot'.$string_to_search.'&quot</p>';
                                }                                
                            }
                            else{
                                $query ="SELECT * FROM data WHERE hierarquia='2' and active='1'";
                                $search_admin=mysqli_query($connection,$query); 
                            }
                            ?>
                <div class= "row">
                            <table>
                             <?php
                                while($row_users=mysqli_fetch_array($search_admin)){
                                    $nome_admin=$row_users['nome'];
                                    //$query_users="SELECT * FROM data WHERE nome='$nome_admin' and hierarquia='2' and active='1'";
                                    //$run_query_users= mysqli_query($connection,$query_users);
                                    //$row_users=mysqli_fetch_array($search_admin);
                                    $descricao_admin=$row_users['hobbies'];
                                    $imagem_admin=$row_users['imagem'];
                                    $curso_admin=$row_users['curso'];
                                    $id=$row_users['id'];
                                    
                                    if(strlen($imagem_admin)==0){
                                        $imagem_admin="logo_nerd.png";
                                    }
                                ?>    
                                <tr> 
                                    <div class="col-md-6 col-lg-4">
                                       
                                       
                                            <div class="card border-0"><a href="ver_user.php?id=<?php echo $id ?> "><img src="assets/img/users/<?php echo $imagem_admin ?>" alt="Foto de perfil de <?php echo $nome_admin ;?>" class="card-img-top scale-on-hover"></a>
                                            <div class="card-body">
                                            <h6><?php echo $row['nome'];?></h6>
                                            <p class="text-muted card-text"><?php echo $curso_admin ?></p>
                                            <p class="text-muted card-text"><?php echo $descricao_admin ?></p>
                                            <!--<p class="text-muted card-text">ID: <?php //echo $row['id'];?></p>-->
                                            </div>
                                        </div>       
                                    </div>
                                <?php };?>
                                
                            </table>
                                
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

