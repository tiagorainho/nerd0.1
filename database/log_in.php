<?php
session_start();
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
                    <h2 class="text-info font-weight-light mb-5"><i class="fa fa-diamond"></i>&nbsp;NerD</h2>
                    
                    <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
                        <div class="form-group"><label class="text-secondary">Email</label>
                        <input name=rawemail class="form-control" type="text" required="" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,15}$" inputmode="email"></div>
                        <div class="form-group"><label class="text-secondary">Password</label>
                        <input name=rawpassword class="form-control" type="password" required=""></div>
                        <button class="btn btn-info mt-2" type="submit">Log In</button></form>
                    <p class="mt-3 mb-0"><a href="registar.php" class="text-info small">Registar</a></p>
                </div>
                
                <?php
                if($_SERVER["REQUEST_METHOD"]=="POST"){
                    $raw_password=$_POST['rawpassword'];
                    $raw_email=trim($_POST['rawemail']);
                    include('connection.php');
                    
                    $password_filtered=filter_var($raw_password,FILTER_SANITIZE_STRING);
                    $email=filter_var($raw_email,FILTER_VALIDATE_EMAIL);
                    $password=hash("sha256",$password_filtered);
                    
                    $query="SELECT *FROM data WHERE email='$email' and password='$password'";
                    $run_query= mysqli_query($connection,$query);
                    $result=mysqli_num_rows($run_query);
                    $row=mysqli_fetch_array($run_query);
                    $active=$row['active'];
                    if($active==0){
                        echo "<p style='color:orange'>Ainda não foste aceite</p>";
                    }
                    else{
                        $nome=$row['nome'];
                        $imagem=$row['imagem'];
                        if($result==1){

                            $_SESSION['user_info']=array(
                            "email"=>$email,
                            "nome"=>$nome,
                            "password"=>$password
                            );
                            if(strlen($tentativa)==0){
                                $query_update="UPDATE data SET tentativa = '' WHERE nome = '$nome' and password='$password' and active='1'";
                                $run_query = mysqli_query($connection,$query_update);
                                if(!$run_query){
                                    header("Location:projects_images_grid.php?ERRO=Erro com o sistema de recuperação de password");
                                }
                            }
                            header("Location:projects_images_grid.php");
                            
                        }
                        else if($result==0){
                            echo "<p style=color:orange>Username e Password não correspondem.</p>";
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
                }
                ?>
                
                
            </div>
            <div class="col-lg-6 d-flex align-items-end" id="bg-block" style="background-image:url(&quot;assets/img/estrutura/logo2_invert.png&quot;);background-size:cover;background-position:center center;">
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