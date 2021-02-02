<?php

require("header.php");
require("footer.php");
require("/users/wildlfctr/phpincludes/connections.php");
showHead(5,2, "Airport Wildlife Strike Summary and Risk Analysis Report Summary - Center for Wildlife and Aviation"); 
?>

<?php
$fileEx="";
#open a text file for writing the results in
if(($egroup != "All")&&($egroup != "")){
  $fileEx.="_$egroup";
}
if(($faaregion != "All")&&($faaregion != "")){
  $fileEx.="_$faaregion";
}
if(($state != "All")&&($state != "")){
  $fileEx.="_$state";
}

$outputfile="/users/wildlfctr/public_html/strike_index/excel_files/queryResults$fileEx.xls";
$linkName="strike_index/excel_files/queryResults$fileEx.xls";

function faaregion($airport_id){
  $query="select faaregion from airport where airport_id='".$airport_id."'";
  #print "query=$query<br>";
  $result=mysql_query($query);
  $row=mysql_fetch_array($result);
  #print "here in faaregion=".$row["faaregion"];
  return $row["faaregion"];
}

function mgroup($airport_id){
  $query="select movGroup from airport where airport_id='".$airport_id."'";
  #print "query=$query<br>";
  $result=mysql_query($query);
  $row=mysql_fetch_array($result);
  #print "here in mgroup=".$row["movGroup"];
  return $row["movGroup"];
}

function state($airport_id){
  $query="select state from airport where airport_id='".$airport_id."'";
  #print "query=$query<br>";
  $result=mysql_query($query);
  $row=mysql_fetch_array($result);
  #print "here in state=".$row["state"];
  return $row["state"];
}

function listAll($egroup, $faaregion, $state){
  $conn=prod_connect();
  $groupClause="";
  $regionClause="";
  $stateClause="";
  #echo "egroup=$egroup faaregion=$faaregion state=$state<br>";
  if(($egroup != "All")&&($egroup != "")){
    $groupClause=" and airport.Egroup='$egroup' ";
    #echo " groupClause=$groupClause\n";
  }
  if(($faaregion != "All") && ($faaregion !="")){
    $regionClause=" and airport.faaregion='$faaregion' ";
    #echo "regionClause =$regionClause<br>";
  }
  if(($state != "All")&&($state != "")){
    $stateClause=" and airport.state='$state' ";
  }
 
  $query="select airport.airport_name, strikeRate.airport_id, strikeRate.strikes_per_movs, strikeRate.dam_strikes_per_movs, strikeRate.5y_strikes_per_movs, strikeRate.5y_dam_strikes_per_movs from strikeRate,airport where strikeRate.airport_id=airport.airport_id $groupClause $regionClause $stateClause order by strikeRate.airport_id";
  #print "query=$query<br>";
  $result=mysql_query($query);
  return $result;
}?>
<div align="center">
<h1>Airport Wildlife Strike Summary</h1>

<br>
<?php
$result=listAll($egroup, $faaregion, $state);
$num_results=mysql_num_rows($result);
$fp=fopen("$outputfile", "w");
fwrite($fp, "Airport Id"."\t"."Airport"."\t"."Region"."\t"."Recent Year's Strikes less than or equal to 1500 feet per 100000 movements"."\t"." Recent Year's Adverse Effect Strikes less than or equal to 1500 feet per 100000 movements"."\t"."5 Year Strikes less than or equal to 1500 feet per 100000 movements"."\t"."5 Year Adverse Effect Strikes less than or equal to 1500 feet per 100000 movements\n");
if($num_results == 0){
  echo "<p class=\"boldText\">No Airport fits the criteria.<br>
<a href=\"index.php\">click here to try again</a></p>";
}
else{
?>

<table width="350" align="center"><tr><td class="boldText">Group: <?php echo "$egroup"; ?> </td><td class="boldText">Region: <?php echo "$faaregion"; ?></td><td class="boldText"> State: <?php echo "$state"; ?></td></tr>
<tr><td colspan="3"><a href="<?php echo "$linkName"; ?>"><font class="downloadLink">Download Data File</font> </a>(download a tab-delimited file suitable for importing into EXCEL)</td></tr>
<tr><td colspan="3"><hr></td></tr>
</table>
<br>

<table align="center" width="625">
<tr>
<td class="smallText" align="left">A=2016 &le;1500 feet strikes/100,000 movements</td>
<td class="smallText" align="left">B=2016 &le;1500 feet adverse effect strikes/100,000 movements</td>
</tr>
<tr>
<td class="smallText" align="left">C=2012-2016 &le;1500 feet strikes/100,000 movements</td>
<td class="smallText" align="left"> D=2012-2016 &le;1500 adverse effect strikes/100,000 movements</td>
</tr>
</table>
<br>

<table border="1" cellpadding="3" align="center" bgcolor="#FFFFFF" >
<td bgcolor="#006600"><p class="white">Airport Id</p></td>
<td bgcolor="#006600"><p class="white">Airport</p></td>

<?php if (($faaregion == "All")||($faaregion == "")){?>
<td bgcolor="#006600"><p class="white">Region</p></td>
<?php }if (($state == "All")||($state == "")){ ?>
<td bgcolor="#006600"><p class="white">State</p></td>
<?php }?>
<td bgcolor="#006600" align="center"><p class="white">A</p></td>
<td bgcolor="#006600" align="center"><p class ="white">B</p></td>
<td bgcolor="#006600" align="center"><p class="white">C</p></td>
<td bgcolor="#006600" align="center"><p class="white">D</p></td></tr>
</tr>
<?php for ($i=0; $i < $num_results; $i++){
     $row=mysql_fetch_array($result);
     echo "<tr><td><a href=\"strike_index/".$row["airport_id"].".html\">".$row["airport_id"]."</a></td>";
     echo "<td>".$row["airport_name"]."</td>";
     //if (($egroup == "All")||($egroup == "")){ 
     // $airport_group=mgroup($row["airport_id"]);
     // echo "<td>$airport_group</td>";
     //} 
    if (($faaregion == "All")||($faaregion == "")){
       $airport_faaregion=faaregion($row["airport_id"]);
       echo "<td>$airport_faaregion</td>";
     }
     if (($state == "All")||($state == "")){ 
       $airport_state=state($row["airport_id"]);
       echo "<td>$airport_state</td>";
     }
     echo "<td>".$row["strikes_per_movs"]."</td><td>".$row["5y_strikes_per_movs"]."</td><td>".$row["dam_strikes_per_movs"]."</td><td>".$row["5y_dam_strikes_per_movs"]."</td></tr>";
     $line=$row["airport_id"]."\t".$row["airport_name"];

     if (($egroup == "All")||($egroup == "")){
       $line.="$airport_group\t";
     }
     if (($faaregion == "All")||($faaregion == "")){
       $line.="$airport_faaregion\t";
     }
     if (($state == "All")||($state == "")){
       $line.="$airport_state\t";
     }
     $line.=$row["strikes_per_movs"]."\t".$row["5y_strikes_per_movs"]."\t".$row["dam_strikes_per_movs"]."\t".$row["5y_dam_strikes_per_movs"]."\n";
     fwrite($fp, $line);
}
}
fclose($fp);

#Add an entry to excel_files/delete_data_files.php so this temporary
#file will be cleaned out within a day
$fp = fopen("/users/wildlfctr/public_html/strike_index/excel_files/delete_data_files.txt", "a"); // add for subsequent deletion if more than 1 day old
fwrite($fp, "queryResults" . $fileEx . ".xls," . date("d") . "\n");
fclose($fp);

?>
</table>



<br>
<br>


<center>
<?php showFooter($_SERVER['SCRIPT_FILENAME']); ?>
</center>
