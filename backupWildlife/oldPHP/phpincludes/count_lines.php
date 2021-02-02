<?php
$count = 0;
if ($handle = opendir('.')) {
     while (false !== ($file = readdir($handle))) {
      //    if ($file != "." && $file != ".." && ereg(".*reports.*", $file)) {
          if ($file != "." && $file != ".." && (ereg(".*pl.*", $file) || ereg(".*php.*", $file) || ereg(".*htm.*", $file)) ) {
                     //echo "$file<br>";

                     $temp = file($file);
                     $lines = count($temp);
                     $total = $total + $lines;
                     echo "$file - $lines<br>";
          }
    }
  closedir($handle);
}
echo "$total<br>";
?> 
