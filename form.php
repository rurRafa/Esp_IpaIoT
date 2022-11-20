<?php
      $sn1 = $_GET["name"];
      
      $file1 = fopen("sensors.txt","w") or die("Unable to open file!");
      $text1 = "name=" . $sn1    
      fwrite($file1, $text1);
      fclose($file1);

      header("location: index.php?form=sent");
 ?>
