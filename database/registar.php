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
                        
                        
                        <div class="form-group"><label class="text-secondary">Nome</label>
                        <input name=rawnome class="form-control" type="text" required=""></div>
                        
                        
                        <div class="form-group"><label class="text-secondary">Password</label>
                        <input name=rawpassword1 class="form-control" type="password" required=""></div>
                        
                        <div class="form-group"><label class="text-secondary">Confirmar Password</label>
                        <input name=rawpassword2 class="form-control" type="password" required="" placeholder=""></div>
                        
                        <button class="btn btn-info mt-2" type="submit">Registar</button></form>
                    <p class="mt-3 mb-0"><a href="log_in.php" class="text-info small">Voltar ao login</a></p>
                </div>
                
                <?php
                include('connection.php');
                if($_SERVER["REQUEST_METHOD"]=="POST"){
                    
                    $raw_password1=$_POST['rawpassword1'];
                    $raw_password2=$_POST['rawpassword2'];
                     if(strcmp($raw_password1,$raw_password2)==0){
                        $password_hashed=hash("sha256",$raw_password1);    
                        $raw_email=trim($_POST['rawemail']);
                        $raw_nome=$_POST['rawnome'];

                        $email=filter_var($raw_email,FILTER_VALIDATE_EMAIL);
                        $nome=filter_var($raw_nome,FILTER_SANITIZE_STRING);
                        $today = date("Y-m-d H:i:s");
                         
                        $query_select = "SELECT * FROM data WHERE email='$email' or nome='$nome'";
                        $run_query= mysqli_query($connection,$query_select);
                        $result=mysqli_num_rows($run_query);
                         
                        if(!($result>0)){
                             $query= "INSERT INTO data (id,email,password,nome,date_time) VALUES ('NULL','$email','$password_hashed','$nome','$today')";
                             $run_query = mysqli_query($connection,$query);

                             if($run_query){
                                include('connection.php');
                                ?>
                                <p style="color:green">Foi registado com sucesso!</p>
                                <?php
                            }
                         }
                         else{
                            ?>
                            <p style="color:orange">E-mail ou nome já usado!</p>
                            <?php 
                        }  
                    }
                     else{
                          ?>
                          <p style="color:red">As passwords não correspondem.</p>
                         <?php
                    }  
                mysqli_close($connection);
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