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
                    <h2>Recrutas</h2>
                </div>        
                
                <?php
                if(isset($_POST["submit"]))
                    if(!empty($_POST['user'])){
                        //echo "escolheste<br>";
                        foreach($_POST['user'] as $user){
                            $query_procurar = "SELECT * FROM data WHERE nome='$user' and active='0' ORDER BY id DESC";
                            $run_query_procurar= mysqli_query($connection,$query_procurar);
                            $row=mysqli_fetch_array($run_query_procurar);
                            $email=$row['email'];
                            $password=$row['password'];
                            $today=$row['date_time'];
                            
                            $query_update="UPDATE data SET active = '1' WHERE nome ='$user'";                            
                             $run_query = mysqli_query($connection,$query_update);
                            
                             if($run_query && $run_query_procurar){
                                ?>
                                <p style="color:green"><?php echo $user ?> foi registado com sucesso!</p>
                                <?php
                            }
                            else{
                                ?>
                                <p style="color:red ; font-size=25px"><?php echo $user ?> não foi registado com sucesso!</p>
                                <?php
                            }
                            if(strlen($email)==0){
                                $query_apagar="DELETE FROM data WHERE email='$email'";
                                $run_query_apagar= mysqli_query($connection,$query_apagar);
                            }
                        }
                    }
                    else{
                        echo "<p style='color:red; font-size:20px' >Nenhum recruta adicionado</p>";
                    }
                ?>
                <div class="container">
                <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
                  <?php
                       $query="SELECT * FROM data WHERE active='0'";
                       $search_users=mysqli_query($connection,$query);
                       $result=mysqli_num_rows($search_users);
                       ?>
                   
                       <?php
                       if($result>0){
                           ?>
                           <table>
                       <tr>
                          <th style="color:grey" >Aceitar</th> 
                          <th style="color:grey" >Nome</th>
                          <th style="color:grey" >Email</th>
                          <th style="color:grey" >Dia de pedido</th>
                         </tr>
                          <?php
                           while($row=mysqli_fetch_array($search_users)){ ?>
                        
                           
                            <!--    <tr class="card-img-top scale-on-hover">    -->
                                <tr>
                                   
                                    <td style='width: 120px'><div class="form-check"><input class="form-check-input" type="checkbox" name="user[]" value="<?php echo $row['nome']; ?>"><label class="form-check-label" for="formCheck-1"><!-- ALGUM TIPO DE COMMENTARIO  --></label></div></td>
                              
                                  
                                  
                                    <td style='width: 180px' name="user[]" ><?php echo $row['nome']; ?></td>
                                    <td style='width: 180px' name="user[]" ><?php echo $row['email']; ?></td>
                                    <?php  $date=date('d-m-Y', strtotime($row['date_time'])); ?>
                                    <td style='width: 180px' name="user[]" ><?php echo $date ?></td>

                           <?php
                                }
                           ?>
                           <p><input class="btn btn-info mt-2" type="submit" name="submit" value="Adicionar"/></p>
                       </table>
                          <?php 
                       }
                       else{
                           echo "<p style='color:orange ; font-size:20px'>Não há novos recrutas</p>";
                       }
                       ?>
                       
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

