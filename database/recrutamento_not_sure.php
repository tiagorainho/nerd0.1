<?php
    session_start();
    include('connection.php');
    $nome=$_SESSION['user_info']['nome'];
    if(true){
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
                    <li class="dropdown nav-item"><a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#"><?php echo $nome ?></a>
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
                    <h2>Recrutas</h2>
                </div>        
                <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
                       
                        <div class="form-group"><label class="text-secondary"></label>
                        <input name=string_to_search class="form-control" type="text" placeholder="Procurar"></div>
                        <button class="btn btn-info mt-2" type="submit">Procurar</button>
                </form>
                <?php
                
                
                
                echo "<br><br>";
                include('connection.php');
                if($_SERVER["REQUEST_METHOD"]=="POST"){
                    $raw_string_to_search=$_POST['string_to_search'];
                    $string_to_search=filter_var($raw_string_to_search,FILTER_SANITIZE_STRING);
                    
                     $query="SELECT * FROM possiveis_users WHERE nome LIKE '%".$string_to_search."%' or email LIKE '%".$string_to_search."%' or id LIKE '%".$string_to_search."%'  ORDER BY id DESC";
                    $search_users=mysqli_query($connection,$query);
                    $num_res=mysqli_num_rows($search_users);
                    if($num_res==0){
                        echo '<p style="color:orange">Não foram encontrados Utilizados com o nome &quot'.$string_to_search.'&quot</p>';
                    }
                    else{
                        ?>
                        <table>
                         <tr>
                          <th>Aceitar</th>
                          <th>Nome</th> 
                          <th>Email</th> 
                          <th>Data de pedido</th>
                         </tr>
                         <?php
                            while($row=mysqli_fetch_array($search_users)){?>
                            <tr class="card-img-top scale-on-hover">
                               <td style='width: 80px'> <input type="checkbox" name="recruta[]" value="<?php echo $row['nome'];?>"></td> 
                                <td style='width: 180px'><?php echo $row['nome'];?></td>
                                <td style='width: 180px'><?php echo $row['email'];?></td>
                                <td style='width: 180px'><?php echo $row['date_time'];?></td>
                                
                                
                            <?php 
                                                                  
                                                                         
                                                                         
                            };?>
                        </table>
                        <?php
                        
                    }
                }
                else{
                    $query ="SELECT * FROM data";
                    $search_users=mysqli_query($connection,$query);
                }
             
             /*
             
             while($row=mysqli_fetch_array($search_users)){
                 if ($_POST['nome'] == 'value1'){
                    $query_apagar="DELETE FROM possiveis_users WHERE nome='$nome'";
                    $run_query= mysqli_query($connection,$query_apagar);
                  //  $query= "INSERT INTO user_apagado (id,nome,quem_apagou,date_time) VALUES ('NULL','$nome','$user','$today')";
                //    $run_query = mysqli_query($connection,$query);
                 }   
             }
             */
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