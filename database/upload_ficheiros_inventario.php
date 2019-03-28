<?php
    session_start();
    include('connection.php');
    $user=$_SESSION['user_info']['email'];
    $password=$_SESSION['user_info']['password'];
    $nome=$_SESSION['user_info']['nome'];
    $nome_user=$nome;
    $query="SELECT * FROM data WHERE email='$user' and password='$password' and active='1'";
    $run_query= mysqli_query($connection,$query);
    $result=mysqli_num_rows($run_query);
    if($result==1){
        $material=$_GET['material'];
        $raw_nome_ficheiro=trim($_POST['raw_nome_ficheiro']);
        $nome_ficheiro=filter_var($raw_nome_ficheiro,FILTER_SANITIZE_STRING);
        $nome_real=$nome_ficheiro;
        $diretorio=$_GET['dir'];
        $nome_projeto=$_GET['nome_projeto'];
        $query="SELECT * FROM inventario WHERE nome='$material' and active='1'";
        $run_query= mysqli_query($connection,$query);
        $result=mysqli_num_rows($run_query);
        date_default_timezone_set("Europe/Lisbon");
        if($result>0){
            $buscar_imagem=mysqli_fetch_array($run_query);
            //$imagem=$buscar_imagem['imagem'];
            if(isset($_POST['submit'])){
                $file=$_FILES['file'];
                $file_name=$_FILES['file']['name'];
                $file_tmpName=$_FILES['file']['tmp_name'];
                $file_size=$_FILES['file']['size'];
                $file_error=$_FILES['file']['error'];
                $file_type=$_FILES['file']['type'];

                $fileExt=explode('.',$file_name);
                $file_actual_ext=strtolower(end($fileExt));
                $ext_allowed=array('jpg','jpeg','png','pdf','txt','zip','rar','gcode');
                if(in_array($file_actual_ext,$ext_allowed)){
                    if($file_error===0){
                        if($file_size<100000000){
                           // $path="assets/ficheiros/inventario/".$imagem;
                            
                          /*  if(strlen($imagem)>0){
                                unlink($path);
                            } */
                                $file_new_name=uniqid('',true).".".$file_actual_ext;
                                $file_destination="assets/ficheiros/".$diretorio."/".$file_new_name;
                                move_uploaded_file($file_tmpName,$file_destination);
                                $today = date("Y-m-d H:i:s");
                            
                                $query= "INSERT INTO inventario (id,nome,quem_adicionou,ficheiro,date_time,nome_real,extra,active) VALUES ('NULL','$material','$nome_user','$file_new_name','$today','$nome_real','1','1')";
                            
                                $run_query = mysqli_query($connection,$query);
                                if($run_query){
                                    ?>
                                    <script>
                                        alert("Ficheiro recebido com sucesso!");
                                    </script>
                                    <?php
                                    header("Location:material_inventario.php?material=$material");
                                }
                                     
                                   
                        }
                        else{
                            echo "Ficheiro demasiado grande";
                        }
                    }
                    else{
                        echo "Erro a fazer o upload";
                    }
                }
                else{
                    echo "Não podes fazer upload de ficheiros deste tipo, apenas jpg, png, jpeg, pdf, gcode, txt, zip e rar";
                }    
            }
        }
        else{
            echo '<p style="color:red">Projeto &quot'.$nome_projeto.'&quot nao encontrado !!</p>';
        }
    }
    else{
        header("Location:utilizador_nao_identificado.php");
    }
?>