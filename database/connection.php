<?php
        $server = "localhost";//                                  PARA MUDAR NO FUTURO

        $username = "root";

        $password = "";

        $database = "database";

        try{
            $connection=mysqli_connect($server,$username,$password,$database);
            /*
            if($connection){
                echo "Conectado com a base de dados !";
            }
            */
        }
        catch(Exception $errormsg){
            echo $errormsg->getMessage("Algo correu mal com a base de dados");
           ?>
              <script>
                 alert("Não está ligado com a base de dados");
            </script>
            <?php
        }
?>