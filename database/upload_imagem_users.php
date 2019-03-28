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
        date_default_timezone_set("Europe/Lisbon");
            $info=mysqli_fetch_array($run_query);
            $imagem=$info['imagem'];
            $nome=$info['nome'];
            if(isset($_POST['submit'])){
                $file=$_FILES['file'];
                $file_name=$_FILES['file']['name'];
                $file_tmpName=$_FILES['file']['tmp_name'];
                $file_size=$_FILES['file']['size'];
                $file_error=$_FILES['file']['error'];
                $file_type=$_FILES['file']['type'];

                $fileExt=explode('.',$file_name);
                $file_actual_ext=strtolower(end($fileExt));
                $ext_allowed=array('jpg','jpeg','png');
                if(in_array($file_actual_ext,$ext_allowed)){
                    if($file_error===0){
                        if($file_size<20000000){
                            $path="assets/img/users/".$imagem;
                            
                            if(strlen($imagem)>0){
                                unlink($path);
                            }
                                $file_new_name=uniqid('',true).".".$file_actual_ext;
                                $file_destination="assets/img/users/$file_new_name";
                                move_uploaded_file($file_tmpName,$file_destination);

                                $query_update="UPDATE data SET imagem = '$file_new_name' WHERE nome = '$nome'";
                                $run_query = mysqli_query($connection,$query_update);
                                ?>
                                <script>
                                    alert("Imagem recebida com sucesso!");
                                </script>
                                <?php
                                header("Location:minha_conta.php");
                        }
                        else{
                            echo "Imagem demasiado grande";
                        }
                    }
                    else{
                        echo "Erro a fazer o upload";
                    }
                }
                else{
                    echo "Não podes fazer upload de ficheiros deste tipo, apenas jpg, png e jpeg";
                }    
            }
        }    
    else{
        header("Location:utilizador_nao_identificado.php");
    }
?>