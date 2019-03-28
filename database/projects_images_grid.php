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
        $ultimo_comunicado_visto=$row['ultimo_comunicado'];
        $imagem=$row['imagem'];
        if(strlen($imagem)==0){
            $imagem="logo_nerd.png";
        }
        
        $query_notificacao="SELECT * FROM comunicados ORDER BY ID DESC LIMIT 1";
        $run_query_notificacao= mysqli_query($connection,$query_notificacao);
        $ult_id=mysqli_fetch_array($run_query_notificacao);
        $ultimo_comunicado=$ult_id['id'];
        
        $query="SELECT * FROM data WHERE email='$user' and password='$password' and active='1' and hierarquia='2'";
        $run_query= mysqli_query($connection,$query);
        $result=mysqli_num_rows($run_query);
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
                    <h2>Projetos</h2>
                </div>
                <?php if($hierarquia==2){  ?>             
                <div align="right">
                   <button class="btn btn-info mt-2" type="button" ><a href="apagar_projeto.php" style="color:white">Apagar</a></button>
                </div>
                <?php  } ?>
                <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
                       
                       
                        <div class="form-group"><label class="text-secondary"></label>
                        <input name=string_to_search class="form-control" type="text" placeholder="Procurar"></div>
                        <button class="btn btn-info mt-2" type="submit">Procurar</button>
                        
                </form>
                <?php if($hierarquia==2){  ?>  
                <div align="right">
                   <button class="btn btn-info mt-2" type="button" ><a href="criar_projeto.php" style="color:white">Criar</a></button>
                </div>
                           <?php  
                            }
                            echo "<br><br>";
                            include('connection.php');
                            if($_SERVER["REQUEST_METHOD"]=="POST"){
                                $raw_string_to_search=$_POST['string_to_search'];
                                $string_to_search=filter_var($raw_string_to_search,FILTER_SANITIZE_STRING);

                                $query="SELECT * FROM projetos WHERE nome LIKE '%".$string_to_search."%' ORDER BY id DESC";
                                $search_project=mysqli_query($connection,$query);

                                $num_res=mysqli_num_rows($search_project);
                                if($num_res==0){
                                    echo '<p style="color:orange">Não foram encontrados projetos com o nome &quot'.$string_to_search.'&quot</p>';
                                }                                
                            }
                            else{
                                $query ="SELECT * FROM projetos ORDER BY id DESC";
                                $search_project=mysqli_query($connection,$query); 
                            }
                            ?>
                <div class= "row">
                            <table>
                             <?php
                                while($row=mysqli_fetch_array($search_project)){
                                $imagem_projeto=$row['imagem'];
                                if(strlen($row['imagem'])==0){
                                    $imagem_projeto="projetos.jpg";
                                }
                                ?>
                                <tr> 
                                    <div class="col-md-6 col-lg-4">
                                        <div class="card border-0"><a href="project_page.php?nome_projeto=<?php echo $row['nome'];?>"><img src="assets/img/projetos/<?php echo $imagem_projeto ?>" alt="Imagem do projeto <?php echo $row['nome'];?>" class="card-img-top scale-on-hover"></a>
                                            <div class="card-body">
                                            <h6><?php echo $row['nome'];
                                                if($row['concluido']==1){
                                                    ?>
                                                        <img style="box-shadow: 0px 0px" width="20" src="assets/img/estrutura/tick3.png" alt="Projeto acabado">
                                                    <?php
                                                }
                                                ?></h6>
                                            <p class="text-muted card-text"><?php echo $row['descricao'];?></p>
                                            <!--<p class="text-muted card-text">ID: <?php // echo $row['id'];?></p>-->
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

