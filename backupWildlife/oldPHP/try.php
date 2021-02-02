<?

  $count = 0;
        $fp = fopen("registrants.txt", "r");
        $fp1 = fopen("registrants.newtxt", "w");
                
        while (!feof($fp)) {
          $line = fgets($fp,1000);
          $new_line = $line;
          if (ereg(".*Thur Nov 8 09:00:00 MST 2008.*", $line)) {                                                                                                                   
            $new_line = str_replace("2008", "2007", $line);
            $count++;
          }    
          fwrite($fp1,$new_line);
        }
        fclose($fp);
        fclose($fp1);
echo "Count = $count<br>";    
?>
