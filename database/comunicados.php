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
        
        
        $query_notificacao="SELECT * FROM comunicados ORDER BY ID DESC LIMIT 1";
        $run_query_notificacao= mysqli_query($connection,$query_notificacao);
        $ult_id=mysqli_fetch_array($run_query_notificacao);
        $ultimo_comunicado=$ult_id['id'];
        
        $query_update_comunicados="UPDATE data SET ultimo_comunicado = '$ultimo_comunicado' WHERE email = '$user'";
        $run_query_comunicados = mysqli_query($connection,$query_update_comunicados);
        
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
                    <li class="nav-item" role="presentation"><a class="nav-link" href="comunicados.php">Comunicados</a></li>
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
                    <h2>Comunicados</h2>
                </div>
                <div align="right">
                   <button class="btn btn-info mt-2" type="button" ><a href="fazer_comunicado.php" style="color:white">Adicionar comunicado</a></button>
                </div>
                <?php
                
                
                echo "<br><br>";
                include('connection.php');
                $query ="SELECT * FROM comunicados ORDER BY id DESC";
                $search_comunicados=mysqli_query($connection,$query);
                $num_res=mysqli_num_rows($search_comunicados);
                if($num_res==0){
                    echo '<p style="color:green">Ainda não foram encontrados feitos comunicados!</p>';
                }
                else{
                    ?>
                    <table>
                     <tr>
                      <th>Mensagem</th> 
                      <th></th>
                      <th style="color:grey">Nome</th>
                      <th style="color:grey">Dia</th>
                      <th style="color:grey">Hora</th>
                     </tr>
                     <?php
                        while($row=mysqli_fetch_array($search_comunicados)){
                            $hora=date('H:i:s', strtotime($row['date_time']));
                            $dia=date('d-m-Y', strtotime($row['date_time']));
                            
                            $nome_quem_escreveu=$row['nome'];
                            $query="SELECT * FROM data WHERE nome='$nome_quem_escreveu' and hierarquia='2'";
                            $search_admin=mysqli_query($connection,$query);
                            $num_admin=mysqli_num_rows($search_admin);
                            if($num_admin==1){ ?>
                            <tr class="card-img-top scale-on-hover">
                                <td style='width: 500px ; color:red'><?php echo $row['comunicado'];?></td>
                                <td style='width: 100px ; color:red'>admin</td>
                                <td style='width: 180px ; color:red'><?php echo $row['nome'];?></td>
                                <td style='width: 180px ; color:red'><?php echo $dia ?></td>
                                <td style='width: 180px ; color:red'><?php echo $hora ?></td>
                            <?php }
                            else{
                                ?>
                            <tr class="card-img-top scale-on-hover">    
                                <td style='width: 500px'><?php echo $row['comunicado'];?></td>
                                <td style='width: 100px'></td>
                                <td style='width: 180px ; color:grey'><?php echo $row['nome'];?></td>
                                <td style='width: 180px ; color:grey'><?php echo $dia ?></td>
                                <td style='width: 180px ; color:grey'><?php echo $hora ?></td>
                            <?php }
                        }
                
                            ?>
                            
                    </table>
                    <?php
                }
                ?>
                
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