<?
$fp = fopen("../tblSpecies.txt", "r");   // Get Operational File
$fp1 = fopen("tblnewSpecies.txt", "w");
                                
for ($i = 1; $i < $count + 1; $i++) {
    $line = fgets($fp,100);
    $line1 = explode("\t", chop($line));
                                                                                                                                                                                                                                 
                                                                                                                                                                                                                                                 if($returns1 != 0 ) {
                    fwrite($fp1, $line);
                                                                                                                                                                                                                                                                         //echo "***$line***<br>";
                                                                                                                                                                                                                                                                                                 $count1++;
                                                                                                                                                                                                                                                                                                                 }
                                                                                                                                                                                                                                                                                                                                 else { echo "No Hits - $line<br>"; }
                                                                                                                                                                                                                                                                                                                                         }
fclose($fp);


?>                                                                                                                                                                                                                                                                                                                                                 
