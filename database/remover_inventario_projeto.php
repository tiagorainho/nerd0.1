<?php
    session_start();
    include('connection.php');
    $user=$_SESSION['user_info']['email'];
    $password=$_SESSION['user_info']['password'];
    $nome=$_SESSION['user_info']['nome'];
    $nome_proprio=$nome;
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
        $nome_projeto=$_GET['nome_projeto'];
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
                    <h7 style="color:grey">Remover material do projeto</h7>
                </div>        
                
                <?php
                if(isset($_POST["submit"]))
                    if(!empty($_POST['user'])){
                        foreach($_POST['user'] as $user){
                            $today = date("Y-m-d H:i:s");
                            
                            
                            $query_apagar="UPDATE inventario_projetos SET active = '1' WHERE material = '$user' and quantidade!='0'";
                            $run_query_a = mysqli_query($connection,$query_apagar);
                            
                            $query_quem_apagou="UPDATE inventario_projetos SET quem_apagou = '$nome_proprio' WHERE material = '$user' and quantidade!='0'";
                            $run_query_quem_apagou = mysqli_query($connection,$query_quem_apagou);
                            
                            $query_date="UPDATE inventario_projetos SET date_time = '$today' WHERE material = '$user' and quantidade!='0'";
                            $run_query_data = mysqli_query($connection,$query_date);
                            
                             if($run_query_a && $query_date && $run_query_quem_apagou){
                                ?>
                                    <p style="color:green"><?php echo $user ?> foi removido com sucesso!</p>
                                    
                                <?php
                            }
                            else{
                                ?>
                                <p style="color:red ; font-size=25px"><?php echo $user ?> não foi removido com sucesso!</p>
                                <?php
                            }
                        }
                    }
                    else{
                        echo "<p style='color:red; font-size:20px' >Ninguém removido</p>";
                    }
                ?>
                <div class="container">
                <form action="<?php echo $_SERVER['PHP_SELF']?>?nome_projeto=<?php echo $nome_projeto; ?>" method="post">
                  <?php
                        $query= "SELECT * FROM inventario_projetos WHERE nome_projeto='$nome_projeto' and active='0' and material!='' and quantidade!='0'";
                            
                       $search_users=mysqli_query($connection,$query);
                       $result_table=mysqli_num_rows($search_users);
                        if($result_table>0){
                           ?>
                           <table>
                       <tr>
                          <th style="color:grey" >Remover</th> 
                          <th style="color:grey" >Material</th>
                          <th style="color:grey" >Quantidade</th>
                          <!--<th style="color:grey" >Email</th>-->
                          <th style="color:grey" >Adquirido em</th>
                         </tr>
                          <?php
                           while($row=mysqli_fetch_array($search_users)){
                               ?>
                            
                           
                            <!--    <tr class="card-img-top scale-on-hover">    -->
                                <tr>
                                   
                                    <td style='width: 120px'><div class="form-check"><input class="form-check-input" type="checkbox" name="user[]" value="<?php echo $row['material']; ?>"><label class="form-check-label" for="formCheck-1"><!-- ALGUM TIPO DE COMMENTARIO  --></label></div></td>
                              
                                  
                                  
                                    <td style='width: 180px' name="user[]" ><?php echo $row['material']; ?></td>
                                    <!--<td style='width: 180px' name="user[]" ><?php //echo $row['email']; ?></td>-->
                                    <?php  $date=date('d-m-Y', strtotime($row['date_time'])); ?>
                                    <td style='width: 180px' name="user[]" ><?php echo $row['quantidade']; ?></td>
                                    <td style='width: 180px' name="user[]" ><?php echo $date ?></td>
                               </tr>
                                    
                           <?php
                                }
                           ?>
                           <p><input class="btn btn-info mt-2" type="submit" name="submit" value="Remover"/></p>
                       </table>
                          <?php  
                       }
                       else{
                           echo "<p style='color:orange ; font-size:20px'>Projeto sem inventário</p>";
                       }
                       ?>
                       
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



