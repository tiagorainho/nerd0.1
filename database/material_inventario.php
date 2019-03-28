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
        $ultimo_comunicado_visto=$row['ultimo_comunicado'];
        if(strlen($imagem)==0){
            $imagem="logo_nerd.png";
        } 
        $query_notificacao="SELECT * FROM comunicados ORDER BY ID DESC LIMIT 1";
        $run_query_notificacao= mysqli_query($connection,$query_notificacao);
        $ult_id=mysqli_fetch_array($run_query_notificacao);
        $ultimo_comunicado=$ult_id['id'];
        
        
        $material=$_GET['material'];
        $query="SELECT * FROM inventario WHERE nome='$material' and active='1'";
        $run_query= mysqli_query($connection,$query);
        $result=mysqli_num_rows($run_query);

        if($result>0){

            $row=mysqli_fetch_array($run_query);
            $imagem_material=$row['imagem'];
            $texto=$row['descricao'];
            $data_e_hora=$row['date_time'];
            $data=date('d-m-Y', strtotime($data_e_hora));
            
            if(strlen($imagem_material)==0){
                $imagem_material="bar_code.png";
            }
            
            $query="SELECT * FROM data WHERE email='$user' and password='$password' and active='1' and hierarquia='2'";
            $run_query= mysqli_query($connection,$query);
            $result=mysqli_num_rows($run_query);
            if($result==1){
                $hierarquia=2;
            }
            else{
                $hierarquia=0;
            }
            date_default_timezone_set("Europe/Lisbon");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Project Page - Brand</title>
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
                                <!--<a class="dropdown-item" role="presentation" href="#">Log out</a>-->
                                </div>
                            </li>
                </ul>
            </div>
        </div>
    </nav>
    <main class="page project-page">                   
        <section class="portfolio-block project">
            <div class="container">
                <div class="heading">
                    <h2><?php echo $material; ?>
                    </h2>
                </div>
                <div class="image" style="background-image:url(&quot;assets/img/inventario/<?php echo $imagem_material ?>.&quot;);"></div>
                <div class="row">
                    <div class="col-12 col-md-6 offset-md-1 info">
                        <h3>Observações</h3>
                        <?php 
                        if(strlen($texto)==0){
                            $texto="<p style='color:orange'>Sem observações </p>";
                        }
                        ?>
                        <p><?php echo $texto; $observacoes=$texto; ?></p>
                    </div>
                    <div class="col-12 col-md-3 offset-md-1 meta">                       
                        <div class="tags">
                            <span class="meta-heading">Data de criação</span>
                            <span><?php echo $data ?></span>
                            <br>
                            <span class="meta-heading">Adicionar</span>
                            <a href="adicionar_ficheiro_inventario.php?material=<?php echo $material; ?>">Ficheiro</a>                      
                            
                        </div>
                    </div>
                </div>  
            </div>
        </section>
        <div align="center" >
           <?php if($hierarquia==2){  ?>
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?material=<?php echo $material; ?>">
                <div class="form-group"><label class="text-secondary"></label>
                    <textarea name="texto" placeholder="Acrescentar observações" rows="10" cols=60% maxlength="2000"></textarea>
                </div> 
                <button class="btn btn-info mt-2" type="submit">Guardar</button>
            </form>
            <?php } ?>
        </div>
        
        <section class="portfolio-block projects-cards">
            <div class="container" align="center">
                <div align="left">
                    <div class="row people">
                            <div class="col-md-6 col-lg-4 item">
                            <h5 class="title">Ficheiros</h5>
                            <?php
                            $query= "SELECT * FROM inventario WHERE nome='$material' and active='1' and ficheiro!='' and extra='1'";

                           $search_ficheiro=mysqli_query($connection,$query);
                           $result_table=mysqli_num_rows($search_ficheiro);
                            if($result_table>0){
                                while($row=mysqli_fetch_array($search_ficheiro)){
                                    
                                    $fileExt=explode('.',$row['ficheiro']);
                                    $file_actual_ext=strtolower(end($fileExt));
                                    $nome_verdadeiro=$row['nome_real'].".".$file_actual_ext;
                                    ?>
                                    <a style="color:grey" href="force_download.php?dir=inventario&&fich=<?php echo $row['ficheiro']; ?>&&nome=<?php echo $nome_verdadeiro; ?> "><?php echo $nome_verdadeiro; ?></a><p></p>
                            <?php
                                }
                            }
                            else{ ?>
                                <p class="description" style="color:orange">Sem ficheiros </p>
                               <?php }
                                
                               ?> 
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <?php echo "<br><br>" ?>
        <div align="right">
              <form action="upload_imagem_inventario.php?material=<?php echo $material; ?>" method="post" enctype="multipart/form-data">
                    <input type="file" name="file" id="fileToUpload">
                    <button  class="btn btn-info mt-2" type="submit" name="submit">Upload Imagem</button>
              </form>
              <form action="apagar_imagem_inventario.php?material=<?php echo $material ?>" method="post">
                  <button class="btn btn-info mt-2" type="submit" name="submit">Apagar Imagem atual</button>
              </form>
        </div>
        <?php
        if($_SERVER["REQUEST_METHOD"]=="POST"){
            
            $raw_texto=$_POST['texto'];
            $texto=filter_var($raw_texto,FILTER_SANITIZE_STRING);
            
            $texto_novo=$observacoes."<br>".$texto;
            
            
                $query="UPDATE inventario SET descricao = '$texto_novo', quem_adicionou='$nome' WHERE nome = '$material' and active='1' and extra='0'";
                $run_query = mysqli_query($connection,$query);
                                
                if($run_query){
                    header("Location:material_inventario.php?material=$material");
                        
                }
                else{
                    ?>
                        <script>
                            alert("ERRO");
                        </script>
                        <div align="center">
                            <p style=color:red>A atualização do material não foi bem sucedida, tente de novo mais tarde</p>
                        </div>
                    <?php
                    echo "TEXTO:<br>".$texto;
                }
        }
        echo "<br><br>";
        ?>
    </main>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pikaday/1.6.1/pikaday.min.js"></script>
    <script src="assets/js/theme.js"></script>
</body>

</html>
    <?php
        }
        else if($result==0){
            echo "O objeto ".$material." não foi encontrado na base de dados.";
        }
        else{
            echo "Erro, provavelmente houve conflito entre 2 produtos do inventario";
        }
    }
else{
    header("Location:utilizador_nao_identificado.php");
}
?>