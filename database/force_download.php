<?php
$diretorio=$_GET['dir'];
$true_file_name=$_GET['nome'];
$fileName=$_GET['fich'];
$fileName = basename($fileName);
$filePath = 'assets/ficheiros/'.$diretorio.'/'.$fileName;
if(!empty($fileName) && file_exists($filePath)){
    // Define as caracteristicas
    header("Cache-Control: public");
    header("Content-Description: File Transfer");
    header("Content-Disposition: attachment; filename=$true_file_name");
    header("Content-Type: application/zip");
    header("Content-Transfer-Encoding: binary");
    //header("Content-Transfer-Encoding: utf-8");
    
    // Ler Ficheiro
    readfile($filePath);
    exit;
}else{
    echo 'O ficheiro não foi encontrado, certifique-se que não foi removido';
}
?>