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
        date_default_timezone_set("Europe/Lisbon");
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>database</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:300,400,700">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/fonts/ionicons.min.css">
    <link rel="stylesheet" href="assets/fonts/simple-line-icons.min.css">
    <link rel="stylesheet" href="assets/css/-Login-form-Page-BS4-.css">
    <link rel="stylesheet" href="assets/css/Data-Table-1.css">
    <link rel="stylesheet" href="assets/css/Data-Table.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.15/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pikaday/1.6.1/css/pikaday.min.css">
    <link rel="stylesheet" href="assets/css/sidebar-1.css">
    <link rel="stylesheet" href="assets/css/sidebar.css">
</head>

<body>
    <div class="container-fluid">
        <div class="row mh-100vh">
            <div class="col-10 col-sm-8 col-md-6 col-lg-6 offset-1 offset-sm-2 offset-md-3 offset-lg-0 align-self-center d-lg-flex align-items-lg-center align-self-lg-stretch bg-white p-5 rounded rounded-lg-0 my-5 my-lg-0" id="login-block">
                <div class="m-auto w-lg-75 w-xl-50">
                    <h2 class="text-info font-weight-light mb-5"><i class="fa fa-diamond"></i>&nbsp;Criar Projeto</h2>
                    
                    
                    <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
                       
                       
                        <div class="form-group"><label class="text-secondary">Nome</label>
                        <input name=raw_nome class="form-control" type="text" required=""></div>
                        <div class="form-group"><label class="text-secondary">Objetivo</label>
                        <input name=raw_descricao class="form-control" type="text" required=""></div>
                        
                        <script src="assets/js/jquery.min.js"></script>
                        <script src="assets/bootstrap/js/bootstrap.min.js"></script>
                        <script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
                        <script src="https://cdn.datatables.net/1.10.15/js/dataTables.bootstrap.min.js"></script>
                        <script src="https://cdnjs.cloudflare.com/ajax/libs/pikaday/1.6.1/pikaday.min.js"></script>
                        <script src="assets/js/theme.js"></script>
                        
                        
                        <button class="btn btn-info mt-2" type="submit">Gravar</button></form>
                    <p class="mt-3 mb-0"><a href="projects_images_grid.php" class="text-info small">Voltar</a></p>
                </div>
                
                <?php
                if($_SERVER["REQUEST_METHOD"]=="POST"){
                    $raw_nome=$_POST['raw_nome'];
                    $raw_objetivo=$_POST['raw_descricao'];
                    include('connection.php');
                    
                    $nome=filter_var($raw_nome,FILTER_SANITIZE_STRING);
                    $objetivo=filter_var($raw_objetivo,FILTER_SANITIZE_STRING);
                    
                    $query="SELECT *FROM projetos WHERE nome='$nome'";
                    $run_query= mysqli_query($connection,$query);
                    $result=mysqli_num_rows($run_query); 
                    if($result==1){
                        echo "<p style= color:orange>O projeto &quot$nome&quot já existe.</p>";                     
                    }
                    else if($result==0){
                        $today = date("Y-m-d H:i:s");
                        $query= "INSERT INTO projetos (id,nome,descricao,date_time) VALUES ('NULL','$nome','$objetivo','$today')";
                        $run_query = mysqli_query($connection,$query);
                        /*
                        $query= "INSERT INTO inventario_projetos (id,nome) VALUES ('NULL','$nome')";
                        $run_query_inv = mysqli_query($connection,$query);
                        */
                        if($run_query){
                            echo "<p style=color:green>Projeto &quot$nome&quot criado com sucesso!</p>";
                        }
                        else{
                            echo "<p style=color:red>Projeto &quot$nome&quot não foi criado com sucesso!</p>";
                        }
                      /*  if(!$run_query_users || !$run_query_inv){
                            echo "<p style=red:green>Projeto &quot$nome&quot teve erros nas bases de dados adjacentes, falar com Tiago!</p>";
                        }*/
                    }
                    else{
                        ?>
                        <p style= color:red>BASE DE DADOS CURRUMPIDA</p>
                        
                        <script>
                            alert("ERRO !!! FALAR COM O TIAGO !")
                        </script>
                        <?php
                    }
                }
                ?>
                
                
            </div>
            <div class="col-lg-6 d-flex align-items-end" id="bg-block" style="background-image:url(&quot;assets/img/estrutura/projetos.jpg&quot;);background-size:cover;background-position:center center;">
            </div>
        </div>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.15/js/dataTables.bootstrap.min.js"></script>
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