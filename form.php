<?php
    extract($_REQUEST);
    $file=fopen("saveform.txt","a");

    fwrite($file,"name: ");
    fwrite($file, $name ."\n");

    fwrite($file,"surname: ");
    fwrite($file, $surname ."\n");

    fwrite($file,"number: ");
    fwrite($file, $number ."\n");

    fwrite($file,"email: ");
    fwrite($file, $email ."\n");

    fwrite($file,"password: ");
    fwrite($file, $password ."\n");

    fwrite($file,"repassword: ");
    fwrite($file, $repassword ."\n");

    fclose($file);
    header("location: index.php");
 ?>
