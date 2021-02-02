<?php require("header.php");
require("footer.php");
require("/users/wildlfctr/phpincludes/connections.php");
                                                                   
showHead(5,2, "Strikes By Airport - Center for Wildlife and Aviation");
 ?>
<script language="Javascript" src="enplanementGroups.js">
</script>
<script src="summary_wl_strike_rpt.js"></script>



<h1 class="underline"> Strike Information Summaries </h1>

<h3>The information below was created using the <a href="http://wildlife.faa.gov"> FAA Wildlife Strike Database</a>.</h3>  Strikes can be reported <a href="http://wildlife.faa.gov/strikenew.aspx"> online</a> and added to the database.

<ul>

<li><b><a href="databaseQuery/strikesByAirport.php">Reported Strike Totals Per Year by Airport</a></b> - This report shows summary information about selected airports and the number of reported strikes at each since 2003.  When viewing this report, keep in mind that strike reporting is voluntary and some airports do a better job at reporting than others.  Results can be downloaded in Excel format.<br><br>  </li>

<li><b><a href="databaseQuery/speciesRpt.php">Reported Strikes Breakdown by Species </a></b> - This report shows summary information about the number of reported strikes for each species since 1990.  The report also looks at the percentage of strikes that involved multiple birds and the percentage of strikes that involved damage to the aircraft.  Results can be downloaded in Excel format.<br><br>  </li>

<li><b><a href="databaseQuery/birdBandRpt.php">USGS Banded Birds Involved in Strikes </a></b> - This report shows summary information about birds that have been banded by USGS and have also been involved in strikes .<br><br>  </li>



<li><b><a href="databaseQuery/selectAirport.php">Search for Strikes at an Individual Airport, FAARegion, or State</a></b> - Enter criteria like time frame of interest, species, airport, state, faaregion, etc. to see all the strikes reported that match that criteria.  Results can be downloaded in Excel format.<br><br></li>


<li><b>Airport Wildlife Strike Summary and Risk Analysis Reports</b><p>
<font size="2">
These reports provide a summary of strike data for any selected Part 139 Certified airport. The reports also provide a simple wildlife species risk analysis to assist in setting risk management priorities at the selected airport.
Please select from one of the 3 choices below:
</li>
</ul>
<center>
<?php
//HM -added for new summary wildlife rpt option                                                                       
$conn=prod_connect();

$query = "SELECT airport_id FROM strikeRate order by airport_id";

$result3 = mysql_query($query) or die(mysql_error());
$num_returns3 = mysql_num_rows($result3);
$airports[0] = "Select";
$count = 1;
for ($i=0; $i <$num_returns3; $i++) {
  $row = mysql_fetch_array($result3);
  $temp =  stripslashes($row["airport_id"]);
  if($temp != "" ){
    $airports[$count] = $temp;
    $count++;
  }
}
$count_airports = $count;
$query = "SELECT faaregion from airport group by faaregion order by faaregion";

$result3 = mysql_query($query) or die(mysql_error());
$num_returns3 = mysql_num_rows($result3);

$faaregion2[0] = "Select";
$count = 1;
for ($i=0; $i <$num_returns3; $i++) {
  $row = mysql_fetch_array($result3);
  $temp =  stripslashes($row["faaregion"]);
  if($temp != ""){
    $faaregion2[$count] = $temp;
    $count++;
  }
}
$count_faaregion2 = $count;

//You can not re-use $faaregion because it includes Canadian regions                                                  
$query = "SELECT state from airport group by state order by state";

$result3 = mysql_query($query) or die(mysql_error());
$num_returns3 = mysql_num_rows($result3);
$states2[0] = "Select";
$count = 1;
for ($i=0; $i <$num_returns3; $i++) {
  $row = mysql_fetch_array($result3);
  $temp =  stripslashes($row["state"]);
  if($temp != "" ){     //&& $temp != "PYAK") {                
    $states2[$count] = $temp;
    $count++;
  }
}
$count_states2 = $count;

?>
<form class="noborder" name="Query">
<table width=450 border=0>
<tr>
<td valign=top><center><font face=Arial,Helvetica size=-1>All US
<SELECT NAME="Airport_id" onChange="checkStrikeRptSelection()">
<?php
for ($index = 0; $index < $count_airports; $index++) {
  if($index == 0) { $selection = "SELECTED"; }  else { $selected = ""; }
  echo "<OPTION VALUE='$airports[$index]' $selected >$airports[$index]";
}
?>
</font></SELECT></center>
</td>
<td valign=top><center><font face=Arial,Helvetica size=-1><font color=FF0000>
<b>or&nbsp;&nbsp;</b> </font>FAA Region
<SELECT NAME="FAARegion2" onChange="checkStrikeRptSelection()">
<?
for ($index = 0; $index < $count_faaregion2; $index++) {
  if($index == 0) { $selection = "SELECTED"; }  else { $selected = "";
  }
  echo "<OPTION VALUE='$faaregion2[$index]' $selected >$faaregion2[$index]";
}
?>
</font></SELECT></center>
</td>
<td valign=top width=30%><center><font face=Arial,Helvetica size=-1><font color=FF0000><b>or&nbsp;&nbsp;</b> </font>State
<SELECT NAME="State2" onChange="checkStrikeRptSelection()">
<?php
for ($index = 0; $index < $count_states2; $index++) {
  if($index == 0) { $selection = "SELECTED"; }  else { $selected = ""; }
  echo "<OPTION VALUE='$states2[$index]' $selected >$states2[$index]";
}
?>
</font></SELECT></center>
</td>
</tr>
</table></center>

</form>



<?php showFooter($_SERVER['SCRIPT_FILENAME']); ?>

