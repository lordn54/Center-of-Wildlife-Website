<?

// Delete old data files
        $fp = fopen("registrants.txt", "r");
        $fp1 = fopen("temp5.txt", "w");
        $count = 0;
        while (!feof($fp)) {
                $temp = fgets($fp,500);
/*
                $temp1 = explode("&", $temp);
                $list1 = explode("=", $temp1[0]);
                $name = $list1[1];
                $temp2 = explode(" ",$name);
                $num = count($temp2);
                echo "$name<br>";
		$list1 = explode("=", $temp1[1]);
		$org = $list1[1];
                $list1 = explode("=", $temp1[2]);
*/
                $temp1[$count] = $temp;
                $$count++; 
                $temp = trim($temp);
                fwrite($fp1, $temp . "\n");
//echo "$org   $email  $ext]<br>";
        }
        fclose($fp);
        fclose($fp1);
        echo "$count<br>";
exit();



?>
<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
   <meta name="Author" content="Allen Newman">
   <meta name="GENERATOR" content="Mozilla/4.74 [en]C-compaq  (Win98; U) [Netscape]">
   <title>FAA National Wildlife Database Query Select</title>
</head>

<script language="Javascript" src="select_i.js">
</script>
<?
    $fp = fopen("misc.txt", "r");   // first entry is ACCESS version
    $data_in = fgetcsv($fp, 100, ",");
    $version = $data_in[0];
    fclose($fp);

// Delete old data files
	$fp = fopen("delete_data_files.txt", "r");
	$fp1 = fopen("temp.txt", "w");

	while (!feof($fp)) {
		$temp = fgets($fp,60);
		$temp1 = explode(",", chop($temp));
		$today = date("d");
		if ($today != $temp1[1]) { system("rm $temp1[0]"); } // UNIX delete if not same day created in submit_nn.php                if ($today != $temp1[1]) { unlink("$temp1[0]"); }
		else { fwrite($fp1, $temp);  }
	}
	fclose($fp);
	fclose($fp1);

	$fp = fopen("delete_data_files.txt", "w"); // copy back
	$fp1 = fopen("temp.txt", "r");

	while (!feof($fp1)) {
		$temp = fgets($fp1,60);
		fwrite($fp, $temp);  
	}

	fclose($fp);
	fclose($fp1);


  @ $db = mysql_pconnect( "localhost", "newmana", "20faa02"); 
  if (!$db)
  {
     echo "Error: Could not connect to database.  Please try again later.";
     exit;
  }

  mysql_select_db("birdstrike");
// Database "wildlife" for checkout only
//  mysql_select_db("wildlife");

  $query = "SELECT MAX(YEAR(incident_date)), MIN(YEAR(incident_date)), MAX(lupdate), MAX(incident_date), MIN(incident_date), COUNT(find_nr) FROM reports";

  $result = mysql_query($query);

// Logging Activity

	if(empty($REMOTE_HOST)) { $remote_host = "Unknown"; }
	else { $remote_host = $REMOTE_HOST; }

	if(empty($HTTP_REFERER)) { $referer = "Unknown"; }
	else { $referer = $HTTP_REFERER; }

	$today = date("D M j Y H:i:s") . " MST";


	$fp = fopen("activity_log.txt", "a");

	$direct = "no";
	if($Level_I_User == "yes") { $direct = "Yes"; }

        fwrite($fp, "Query Select (Level I) by " . $remote_host . " (" . $REMOTE_ADDR . ") using " . $HTTP_USER_AGENT . "  - " . $today . "\n");
	fclose($fp);

	$message = "Query Select (Level I) by " . $remote_host . " (" . $REMOTE_ADDR . ") - " . $today . "\n";
//	mail("newmana@erau.edu", "Level I On-Line Access", $message);

$fp = fopen("months.txt", "r");
$months[0] = "Select";
$count = 1;
while (!feof($fp)) {
     $months[$count] = fgets($fp,20);
     $count++;
}
$count_months = $count - 1;

fclose($fp);

$fp = fopen("days.txt", "r");
$days[0] = "Select";
$count = 1;
while (!feof($fp)) {
     $days[$count] = fgets($fp,20);
     $count++;
}
$count_days = $count - 1;
fclose($fp);

$row = mysql_fetch_array($result);
$max_date = stripslashes($row["MAX(incident_date)"]);
$temp1 = $max_date;
$max_date = substr($max_date, 4, 2) . "-" . substr($max_date, 6, 2) . "-" . substr($max_date, 0, 4);
$min_date = stripslashes($row["MIN(incident_date)"]);
$temp2 = $min_date;
$min_date = substr($min_date, 4, 2) . "-" . substr($min_date, 6, 2) . "-" . substr($min_date, 0, 4);  

$database_max_date = substr($temp1, 4, 2) . "-" . substr($temp1, 6, 2) . "-" . substr($temp1, 0, 4);

$database_min_date = substr($temp2, 4, 2) . "-" . substr($temp2, 6, 2) . "-" . substr($temp2, 0, 4);



$nr_reports = number_format(stripslashes($row["COUNT(find_nr)"]),0);
$last_update = stripslashes($row["MAX(lupdate)"]);
$last_update = substr($last_update, 4, 2) . "-" . substr($last_update, 6, 2) . "-" . substr($last_update, 0, 4);

$max_year = stripslashes($row["MAX(YEAR(incident_date))"]);
$min_year = stripslashes($row["MIN(YEAR(incident_date))"]);

$years[0] = "Select";
$count = 1;
for ($i = $min_year; $i < $max_year + 1; $i++) {
        $years[$count] = $i;
        $count++;
}
$count_years = $count;   

$fp = fopen("tblOperator.txt", "r");
$operator[0] = "Select";
$count = 1;
while (!feof($fp)) {

	$temp = fgets($fp,100);
     	$array = explode("\t", $temp);
      $operator[$count] = $array[1];

     //$operator[$count] = fgets($fp,30);
     $count++;
}
$count_operator = $count - 1;
$operator_count = --$count_operator; // Accommodate "Select"
fclose($fp);


$fp = fopen("tblAirport.txt", "r");
$airport[0] = "Select";
$count = 1;
while (!feof($fp)) {

	$temp = fgets($fp,100);
     	$array = explode("\t", $temp);
        	$airport[$count] = $array[1];
// if($count == 2) { $airportname = $array[1]; $longitude = $array[8]; $latitude = $array[7]; }
        	$airport_id_by_airport[$count] =  $array[0];
		$region[$count] = $array[3]; // FAA regions by Airport
		$apr[$count] = $array[3] . "::" . $array[0];
        	$count++;
}
$count_airport = $count - 1;
$airport_count = $count_airport - 3; // Accommodate "Select" & "Major US Airports", etc. 
fclose($fp);


// echo " *$airportname* *$latitude* *$longitude*<br>";
  $query = "SELECT atype FROM reports group by atype";

  $result2 = mysql_query($query) or die(mysql_error());
  $num_returns2 = mysql_num_rows($result2);
  $atype[0] = "Select";
  $count = 1;
        for ($i=0; $i <$num_returns2; $i++) {
                $row = mysql_fetch_array($result2);
                $temp =  stripslashes($row["atype"]);
                if($temp != "") {
                        $atype[$count] = $temp;
                        $count++;
                }
        }

$count_atype = $count;
$atype_count = --$count_atype; // Accommodate "Select"

$fp = fopen("tblAirport_ID.txt", "r");
$airport_id[0] = "Select";
$count = 1;
while (!feof($fp)) {
     $airport_id[$count] = fgets($fp,30);
     $count++;
}
$count_airport_id = $count - 1;
fclose($fp);

/*
$fp = fopen("tblStates.txt", "r");
$states[0] = "Select";
$count = 1;
while (!feof($fp)) {
        $temp = fgets($fp,100);
        $array = explode("\t", $temp);
        $states[$count] = $array[0];
        $count++;
}
$count_states = $count - 1;
*/

  $query = "SELECT state FROM reports group by state";
 
  $result2 = mysql_query($query) or die(mysql_error());
  $num_returns2 = mysql_num_rows($result2);
  $states[0] = "Select";
  $count = 1;
        for ($i=0; $i <$num_returns2; $i++) {
                $row = mysql_fetch_array($result2);
                $temp =  stripslashes($row["state"]);
                if($temp != "") {
                        $states[$count] = $temp;
                        $count++;
                }
        }
 
$count_states = $count;

  $query = "SELECT faaregion FROM reports group by faaregion";

  $result2 = mysql_query($query) or die(mysql_error());
  $num_returns2 = mysql_num_rows($result2);
  $faaregions[0] = "Select";
  $count = 1; 
        for ($i=0; $i <$num_returns2; $i++) {
                $row = mysql_fetch_array($result2);
                $temp =  stripslashes($row["faaregion"]);
                if($temp != "") {
                        $faaregions[$count] = $temp;
                        $count++;
                }
        }
        
$count_faaregions = $count;


$fp = fopen("tblSpecies.txt", "r");
$species[0] = "Select";
$species_id[0] = "Select";  
$count = 1;
while (!feof($fp)) {
        $temp = fgets($fp,100);
        $array = explode("\t", $temp);
        $species_id[$count] = $array[0];
        $species[$count] = $array[1];
        $count++;
}
$count_species = $count - 1;
$species_count = $count_species - 1;
fclose($fp);    



?>

<script language="Javascript">
<?

	echo "        var database_min_date = \"$database_min_date\"\n";
	echo "        var database_max_date = \"$database_max_date\"\n";

	echo "\n     var apr = new Array()\n\n";
        echo "     apr_count = $count_airport\n\n";
	 for ($i = 0; $i < $count_airport; $i++) {
                echo "     apr[$i] = \"$apr[$i]\"\n";
	}
	echo "\n";
?>
</script>	
<body text="#000000" background="salmon.jpg"  bgproperties=fixed link="#800000" vlink="#800000" alink="#800000" >
&nbsp;
<center>
<table BORDER=0 COLS=1 WIDTH="520" CELLSPACING=0 CELLPADDING=3 >

<caption><b><font size=-1 face="Arial,Helvetica" color="#800000"><font size=+1>FAA<br>National Wildlife Strike Database Query Select<br>(Authorized FAA Personnel)</font></font></b>
<center><form name="Query" method="post" action="submit_i.php" onSubmit="return verifySubmit()">
</center>
</caption>
</tr>
<?
  $checked = "CHECKED";
  $FAA_Instructions = StripSlashes($HTTP_COOKIE_VARS["FAA_Instructions"]);
if($FAA_Instructions != "no") {
$checked = "";
echo "<tr><td colspan='2'>";
echo "<font face='Arial,Helvetica' size=-1 color='#000000'>";
echo "Instructions:";
echo "<ol><li><b>Select 1 (or more) of the criteria shown.</b> At least 1 criterion must be"; 
echo " selected.";
echo "<li>Although a Date criteria is not required, if only a \"From\" date is selected, the search";
echo " will be from that date to (and including) the latest date - if only a \"To\" date is selected, the search";
echo " will be from the earliest date to (and including) the selected date. If both a \"From\" date";
echo " and a \"To\" date are selected and the dates are the same, the query will be a single day search.";
echo " If neither are selected, the search will be from the earliest to the latest date, that is, all dates.";
echo " SHORTCUTS - For a single year, select \"From\" Year only. For a single month, select \"From\" Month and Year only.</li>"; 
echo "<li>If desired, you may also search the Remarks field for the occurrence of a particular
word or phrase. The search is case-insensitive and the entry should not be surrounded by
single or double quotes - just the word/phrase desired.</li>";
echo "<li>After your selection is complete, click \"Submit Query\". If you do not see";
echo " a \"Submit Query\" and \"Reset\" Button beneath the thin brown line, you will need";
echo " to enable Javascript and click the \"Reload\" Icon (Netscape) or \"Refresh\" Icon (MS Explorer) on";
echo " the navigation menu at the top of your screen.</li>";
echo "<li>If an Airport, Operator, Aircraft or Species is not included in their respective 
pulldown lists, there were no reported strikes for that particular item.";
echo "<li>Please be patient after Query Submittal. This is a very large database and will require";
echo " a few moments to search. After successful completion of the search, you will be";
echo " provided a menu of \"hits\" from which you may select a detailed review of any Strike Report";
echo " of interest and/or perform another search.</li>";
echo "<li>Ordering of \"hits\" is defaulted to \"Date\"; however, you may order by Airport, Operator, Aircraft, Damage or Species if you wish.";
echo " \"Hits\" are defaulted to be returned in \"Ascending\" order; 
however, you may select to return \"hits\" in \"Descending\" order.</li>";
echo "<li>The nominal number of \"hits\" allowed is 500 (which is the default value), but you may select a lower";
echo " number to speed up your search or a larger maximum or \"All\" to 
return all hits. If there are more \"hits\" than the number 
selected, you'll be notified and requested to increase maximum hits allowed or narrow your search criteria. 
<b>Use caution in selecting more than 500 hits since you may 
experience excessive download times (depending on the speed of your 
Internet connection) and/or hang your computer (depending on the amount of 
memory available).</b> </li>";
echo "<li>To hide these instructions in future sessions, check the box beneath the thin brown line at the bottom of the selection menu. You may reinstate displaying";
echo " these instructions at the next session by unchecking the box. Be advised \"cookies\" must be enabled for this feature to be effective.<br>&nbsp;</ol></td></tr>"; }
?>

<tr><td colspan=2>
<?
/*
	$row = mysql_fetch_array($result);
     	$max_date = stripslashes($row["MAX(incident_date)"]);
	$max_date = substr($max_date, 4, 2) . "-" . substr($max_date, 6, 2) . "-" . substr($max_date, 0, 4);
     	$min_date = stripslashes($row["MIN(incident_date)"]);
	$min_date = substr($min_date, 4, 2) . "-" . substr($min_date, 6, 2) . "-" . substr($min_date, 0, 4);

     	$nr_reports = number_format(stripslashes($row["COUNT(find_nr)"]),0);
     	$last_update = stripslashes($row["MAX(lupdate)"]);
	$last_update = substr($last_update, 4, 2) . "-" . substr($last_update, 6, 2) . "-" . substr($last_update, 0, 4);
*/
	//echo "<tr><td></center>";
	echo "<font face='Arial,Helvetica' color='#800000' size=-1><b>Latest Report:</b> <font color='#000000'>$max_date</font>";
	echo "<br><font face='Arial,Helvetica' color='#800000' size=-1><b>Earliest Report:</b> <font color='#000000'>$min_date";
	echo "<br><font face='Arial,Helvetica' color='#800000' size=-1><b>Last Update:</b> <font color='#000000'>$last_update</font>";
	echo "<br><font face='Arial,Helvetica' color='#800000' size=-1><b>Corresponds to ACCESS:</b> <font color='#000000'>$version</font><br>&nbsp;";

	echo "<br><font face='Arial,Helvetica' color='#800000' size=-1><b>Reports in Database:</b> <font 
color='#000000'>$nr_reports</font><br>&nbsp;";
        echo "<br><font face='Arial,Helvetica' color='#800000' size=-1><b>Airports in Database:</b> 
<font color='#000000'>$airport_count</font>";
        echo "<br><font face='Arial,Helvetica' color='#800000' size=-1><b>Operators in Database:</b> 
<font color='#000000'>$operator_count</font>";
        echo "<br><font face='Arial,Helvetica' color='#800000' size=-1><b>Aircraft Types in Database:</b> 
<font color='#000000'>$atype_count</font>";
        echo "<br><font face='Arial,Helvetica' color='#800000' size=-1><b>Species in Database:</b> 
<font color='#000000'>$species_count</font><br>&nbsp;";
	
	//echo "<br>&nbsp;</td></tr></center>";

?>
</td></tr></table>
<table width=520>

<tr>
<td BGCOLOR="#A65353" colspan=2><b><font face="Arial,Helvetica"><font color="#FFFFFF"><font size=-1>Select One (or
More) Criteria of Interest:</font></font></font></b>
</td></tr>

<tr><td VALIGN=TOP colspan=2>
<font size=-1 face="Arial,Helvetica">
<b>Date(s)</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<font size=-1 face="Arial,Helvetica">
<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;From: Month&nbsp; 
<SELECT NAME="From_Month" > 
<?
for ($index = 0; $index < $count_months; $index++) {
   echo "<OPTION VALUE='$months[$index]'>$months[$index]";
}
?>
</SELECT>&nbsp;

<font face="Arial,Helvetica"><font size=-1>&nbsp;Day 
<SELECT NAME="From_Day" > 
<?
for ($index = 0; $index < $count_days; $index++) {
   echo "<OPTION VALUE='$days[$index]'>$days[$index]";
}
?>
</SELECT>&nbsp;
<font face="Arial,Helvetica"><font size=-1>&nbsp;Year</font></font>
<SELECT NAME="From_Year" > 
<?
for ($index = 0; $index < $count_years; $index++) {
   echo "<OPTION VALUE='$years[$index]'>$years[$index]";
}
?>
</SELECT>&nbsp;

<font size=-1 face="Arial,Helvetica"><br>

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;To:&nbsp;Month&nbsp;
<SELECT NAME="To_Month" > 
<?
for ($index = 0; $index < $count_months; $index++) {
   echo "<OPTION VALUE='$months[$index]'>$months[$index]";
}
?>
</SELECT>&nbsp;

<font face="Arial,Helvetica"><font size=-1>&nbsp;Day 
<SELECT NAME="To_Day" > 
<?
for ($index = 0; $index < $count_days; $index++) {
   echo "<OPTION VALUE='$days[$index]'>$days[$index]";
}
?>
</SELECT>&nbsp;

<font face="Arial,Helvetica"><font size=-1>&nbsp;Year </font></font>
<SELECT NAME="To_Year" > 
<?
for ($index = 0; $index < $count_years; $index++) {
   echo "<OPTION VALUE='$years[$index]'>$years[$index]";
}
?>
</SELECT>&nbsp;

</TD>
</tr>
<tr><td><font face="Arial,Helvetica"><font size=-1><b>Airport</b><br>
<font color="#FF0000">&nbsp;&nbsp;&nbsp;&nbsp;<b>or</b><br><font color="#000000"><b>Airport Code</b></td>
<td><SELECT NAME="Airport" onChange="checkSelection()">  
<?
for ($index = 0; $index < $count_airport; $index++) {
   echo "<OPTION VALUE=\"$airport[$index]::$airport_id_by_airport[$index]\">$airport[$index]";
}
?>
</SELECT>&nbsp;

<br><SELECT NAME="Airport_ID" onChange="checkSelection()">  
<?
for ($index = 0; $index < $count_airport_id; $index++) {
   echo "<OPTION VALUE='$airport_id[$index]'>$airport_id[$index]";
}
?>
</SELECT>&nbsp;
<font face="Arial,Helvetica"  size=-2><b>(US Airport Codes are 
preceded with a "K" or "P".)</b></font>

</td>

</tr>

<tr><td><font face="Arial,Helvetica"><font size=-1><b>State</b><br>
<font color="#FF0000">&nbsp;&nbsp;&nbsp;&nbsp;<b>or</b><br><font color="#000000"><b>FAA Region</b></td>
<td><SELECT NAME="State" onChange="checkSelection1()">  
<?
for ($index = 0; $index < $count_states; $index++) {
   echo "<OPTION VALUE='$states[$index]'>$states[$index]";
}
?>
</SELECT>&nbsp;

<br><SELECT NAME="FAARegion" onChange="checkSelection1()">  
<?
for ($index = 0; $index < $count_faaregions; $index++) {
   echo "<OPTION VALUE='$faaregions[$index]'>$faaregions[$index]";
}
?>
</SELECT>&nbsp;

</td>

</tr>

<tr><td><font face="Arial,Helvetica"><font size=-1><b>Operator</b></td>
<td><SELECT NAME="Operator" > 
<?
for ($index = 0; $index < $count_operator; $index++) {
   echo "<OPTION VALUE=\"$operator[$index]\">$operator[$index]";
}
?>
</SELECT>

</td></tr>


<tr><td><font face="Arial,Helvetica"><font size=-1><b>Aircraft</b></td>
<td><SELECT NAME="Aircraft" > 
<?
for ($index = 0; $index < $count_atype; $index++) {
   echo "<OPTION VALUE=\"$atype[$index]\">$atype[$index]";
}
?>
</SELECT>&nbsp;
</td>
</tr>

  
<tr><td><font face="Arial,Helvetica"><font size=-1><b>Species</b></td>
<td><SELECT NAME="Species" onChange="checkSelection()">
<?
for ($index = 0; $index < $count_species; $index++) {
   echo "<OPTION VALUE=\"$species_id[$index]\">$species[$index]";
}
?>
</SELECT>
&nbsp;<input type=hidden name=Species_Name>
</td>
</tr>

<tr><td><font face="Arial,Helvetica"><font size=-1><b>Word/Phrase in Remarks&nbsp;</b></td>
<td><input type=text name="Descr" size=20 maxlength=30></td></tr>

<tr>
<td BGCOLOR="#A65353" colspan=2><b><font face="Arial,Helvetica"><font color="#FFFFFF"><font size=-1>Viewing Options:</font></font></font></b>
</td></tr>

<tr><td><font face="Arial,Helvetica"><font size=-1><b>Hits Ordered By&nbsp;&nbsp;&nbsp;&nbsp;</b></td>
<td><SELECT NAME="Order" onChange="checkOrder()"> 
<OPTION VALUE=incident_date>Date
<OPTION VALUE=airport>Airport
<OPTION VALUE=state>State
<OPTION VALUE=faaregion>FAA Region
<OPTION VALUE=operator>Operator
<OPTION VALUE=atype>Aircraft
<OPTION VALUE=damage>Damage
<OPTION VALUE=species>Species
</SELECT>&nbsp;
</td>
</tr>

<tr><td><font face="Arial,Helvetica"><font size=-1><b>Ordering</b></td>
<td><SELECT NAME="Ordering" onChange="checkOrdering()">
<OPTION VALUE="asc">Ascending
<OPTION VALUE="desc">Descending
<? 
        echo "<OPTION VALUE='grp'>Group by Species";
?>

</SELECT>&nbsp;
<font face="Arial,Helvetica" color="#FF0000" size=-2><b>(New Feature "Group by Species")</b></font>

</td>
</tr>

<tr><td><font face="Arial,Helvetica"><font size=-1><b>Maximum Number<br>of Returned Hits</b></td>
<td><SELECT NAME="Hits" >
<OPTION VALUE="All">All
<OPTION VALUE="3001">3000
<OPTION VALUE="2501">2500
<OPTION VALUE="2001">2000
<OPTION VALUE="1501">1500
<OPTION VALUE="1001">1000
<OPTION VALUE="501" SELECTED>500
<OPTION VALUE="251">250
<OPTION VALUE="201">200
<OPTION VALUE="151">150
<OPTION VALUE="101">100
<OPTION VALUE="51">50
<OPTION VALUE="11">10
</SELECT>&nbsp;
<font face="Arial,Helvetica" color="#FF0000" size=-2><b>(Use caution in 
selecting more than 500 returned hits.)</b></font>
<!------------
<tr><td colspan=2>
<?
//  Message about new option

echo "<center><font face='Arial,Helvetica' size=-1 color=800000>----------------<br>";
echo "<font color=FF0000><b>New Feature Available</font><br>";
echo "You may now select an option to summarize strikes by species<br>";
echo "for an entire state or a selected airport. You may select this capability<br>";
echo "by choosing \"Group by Species\" from the Ordering pull-down list<br>";
echo "(immediately above). Then, (1) select a state or (2) select an airport.<br>";
echo "You may not select both a state and an airport and no other selections are allowed.";
echo " Then click the Submit button.";
echo "<br>----------------</b></font></center>";
?>
</td?</tr>
_____>

<!-- Next holds MySQL Query string --->
<input type="hidden" name="query">
<input type="hidden" name="query1">

</td>
</tr>
<tr><td colspan=2><center><img src="brownbar.gif" width=520></center></td></tr>
<?
echo "<tr><td colspan=2><font face='Arial,Helvetica' size=-1><input 
type=checkbox name=FAA_Instructions $checked>&nbsp;Don't show instructions 
in future sessions.<br><font size=-2>&nbsp;</font><td></tr>"; ?>

</table>

<script LANGUAGE="Javascript">
document.write("<CENTER><input type='Submit' VALUE='Submit Query'>&nbsp;&nbsp;<input TYPE='Reset' VALUE='Reset'></CENTER>")
</script>
</form>

</center>

<center><table COLS=1 CELLPADDING=2 WIDTH="500" >
<tr><td>
<p><center><font face="Arial,Helvetica" color="#000000" size=-1>If you haven't done so already, please take
a few moments and complete an <a href=evaluation.html>Evaluation</a> of this site. If this is your first usage,
you'll be able to return here after your queries are completed.</font>
<br>
<font size=-2>&nbsp;</font><center><img src="brownbar.gif" width=520></center>
<p><font face="Arial,Helvetica">Return To</font>
<br><font face="Arial,Helvetica"><a href="../restricted/index.html">Authorized Personnel Data Access Page</a></center>

<p>&nbsp;<br><font size=-2 color="#000000">
<br>Prepared for the FAA by
<br>Embry-Riddle Aeronautical University
<br>Prescott, AZ
<br>Revised: <font color="#000000">ARN, January 16, 2005
<! ---- Accommodate mapping option ---->
</td></tr>
</table>
</body>
</html>
