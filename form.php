<?php
    extract($_REQUEST);
    $file=fopen("saveform.txt","a");

    fwrite($file,"name :");
    fwrite($file, $username ."\n");

    fwrite($file,"surname :");
    fwrite($file, $email ."\n");

    fwrite($file,"number :");
    fwrite($file, $password ."\n");

    fwrite($file,"email :");
    fwrite($file, $password ."\n");

    fwrite($file,"password :");
    fwrite($file, $password ."\n");

    fwrite($file,"repassword :");
    fwrite($file, $password ."\n");

    fclose($file);
    header("location: index.php");
 ?>
