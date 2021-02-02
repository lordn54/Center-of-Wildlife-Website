<?

   $query = $HTTP_POST_VARS["query"];
          if($query == "") {
                header("Location:select_i.php\n\n");
           }

function fixdate($incident_date) {
      $temp = substr($incident_date, 4, 2 ) . "/" . substr($incident_date, 6, 2) . "/" . substr($incident_date, 0, 4);
      return $temp;
}
/*
//echo "Query -$query<br>";
  $FAA_Instructions = StripSlashes($HTTP_POST_VARS["FAA_Instructions"]);
	if($FAA_Instructions == "on") {
  setcookie("FAA_Instructions","no",time()+3600*24*30*12*5,"/",$HTTP_HOST,0);
	}
	else {
  setcookie("FAA_Instructions","yes",time()+3600*24*30*12*5,"/",$HTTP_HOST,0);
	}
*/
  $fp = fopen("misc.txt", "r");   // 2nd entry is maximum reports displayed
  $data_in = fgetcsv($fp, 100, ",");
  $revision = $data_in[0];
  $max_displayed = $data_in[1];
  fclose($fp);

  $temp = file('survey_desc.txt');
  $survey_desc = trim($temp[0]);


?>

<html>
<head>
  <title>FAA National Wildlife Strike Database Query Results</title>
</head>
<body text="#000000" background="salmon.jpg" link="#800000" vlink="#800000" alink="#800000" >
<?

  $From_Month = StripSlashes($HTTP_POST_VARS["From_Month"]);
  $From_Day = StripSlashes($HTTP_POST_VARS["From_Day"]);
  $From_Year = StripSlashes($HTTP_POST_VARS["From_Year"]);
  $To_Month = StripSlashes($HTTP_POST_VARS["To_Month"]);
  $To_Day = StripSlashes($HTTP_POST_VARS["To_Day"]);
  $To_Year = StripSlashes($HTTP_POST_VARS["To_Year"]);

  if($From_Month == "Select") { $From_Month = "Earliest"; $From_Day = "Date"; $From_Year = "";}
  else { $From_Month = "<B>$From_Month</B>"; $From_Day = "<B>$From_Day</B>"; $From_Year = "<B>$From_Year</B>";}

  if($To_Month == "Select") { $To_Month = "Latest"; $To_Day = "Date"; $To_Year = "";}
  else { $To_Month = "<B>$To_Month</B>"; $To_Day = "<B>$To_Day</B>"; $To_Year = "<B>$To_Year</B>";}

  $Airport = StripSlashes($HTTP_POST_VARS["Airport"]);
  if($Airport == "Select") { $Airport = "All"; }
  else { $Airport = "<B>$Airport</B>"; }

  $State = StripSlashes($HTTP_POST_VARS["State"]);
  if($State == "Select") { $State = "All"; }
  else { $State = "<B>$State</B>"; $FAARegion = ""; }

 
  $FAARegion = StripSlashes($HTTP_POST_VARS["FAARegion"]);
  if($FAARegion == "Select") { $FAARegion = "All"; }
  else { $FAARegion = "<B>$FAARegion</B>"; $State = ""; }

  $Airport_ID = StripSlashes($HTTP_POST_VARS["Airport_ID"]);
  if($Airport_ID == "Select") { $Airport_ID = "All"; }
  else { $Airport_ID = "<B>$Airport_ID</B>"; }

  $Operator = StripSlashes($HTTP_POST_VARS["Operator"]);
  if($Operator == "Select") { $Operator = "All"; }
  else { $Operator = "<B>$Operator</B>"; }

  $Aircraft = StripSlashes($HTTP_POST_VARS["Aircraft"]);
  if($Aircraft == "Select") { $Aircraft = "All"; }
  else { $Aircraft = "<B>$Aircraft</B>"; }

  $Species_Name = StripSlashes($HTTP_POST_VARS["Species_Name"]);
  if($Species_Name == "Select") { $Species_Name = "All"; }
  else { $Species_Name = "<B>$Species_Name</B>"; }  

  $Descr = StripSlashes($HTTP_POST_VARS["Descr"]);
  if($Descr == "") { $Descr = "None"; }
  else { $Descr = "<B>$Descr</B>"; }

  $Order = StripSlashes($HTTP_POST_VARS["Order"]);
  if($Order == "incident_date") { $Order = "Date"; }
  if($Order == "airport") { $Order = "Airport"; }
  if($Order == "state") { $Order = "State"; }
  if($Order == "faaregion") { $Order = "FAA Region"; }
  if($Order == "operator") { $Order = "Operator"; }
  if($Order == "atype") { $Order = "Aircraft"; }
  if($Order == "damage") { $Order = "Damage"; }
  if($Order == "species") { $Order = "Species"; }

  $Ordering = StripSlashes($HTTP_POST_VARS["Ordering"]);
  if($Ordering == "asc") { $Ordering = "Ascending"; }
  if($Ordering == "desc") { $Ordering = "Descending"; }

//  $Hits = StripSlashes($HTTP_POST_VARS["Hits"]);

  $Hits = "All";
  if($Hits != "All") { $Hits--; } // Test for Over Limit Hits if not "All"

  $query = StripSlashes($HTTP_POST_VARS["query"]);
  $query1 = StripSlashes($HTTP_POST_VARS["query1"]);

  //$SearchHits = $Hits + 1; // Test for Over Limit Hits

  if($Hits != "All") { $MaxHits = $Hits; }   //was $Maxhits = 500;

  @ $db = mysql_pconnect( "localhost", "newmana", "20faa02"); 

  if (!$db)
  {
     echo "Error: Could not connect to database.  Please try again later.";
     exit;
  }

  mysql_select_db("birdstrike");
//  mysql_select_db("wildlife");

  $result1 = mysql_query($query1) or die(mysql_error());
  $num_returns1 = mysql_num_rows($result1);

  	for ($i=0; $i <$num_returns1; $i++) {
     		$row = mysql_fetch_array($result1);
     		$returns1 = stripslashes($row["count(find_nr)"]);
	}

  $result = mysql_query($query);


?>
&nbsp;
<center><table width=825 BORDER=0 CELLPADDING=3 >
<!------
<caption>
<center><font face="Arial,Helvetica" color="#800000" size=+1><b>DEVELOPMENT<br>FAA<br>National Wildlife Strike Database<br>Query 
Results</b><br></font>
</center>
</caption>
----->

<?
/*
echo "<tr><td colspan=4><br><font face='Arial,Helvetica' size=-1 color='#800000'><b>Selected Search Criteria:</b><br><font color='#800000'><b>From:</b> <font color='#000000'>$From_Month $From_Day $From_Year&nbsp;&nbsp;&nbsp;<font color='#800000'><b>To:</b> <font color='#000000'>$To_Month $To_Day $To_Year";
if($Airport_ID == "All") {
	echo "<br><font color='#800000'><b>Airport:</b> <font color='#000000'>$Airport&nbsp;&nbsp;<font color='#800000'><b>Operator:</b> <font color='#000000'>$Operator&nbsp;&nbsp;&nbsp;<font color='#800000'><b>Aircraft:</b> <font color='#000000'>$Aircraft";
}
else {
	echo "<br><font color='#800000'><b>Airport ID:</b> <font color='#000000'>$Airport_ID&nbsp;&nbsp;<font color='#800000'><b>Operator:</b> <font color='#000000'>$Operator&nbsp;&nbsp;&nbsp;<font color='#800000'><b>Aircraft:</b> <font color='#000000'>$Aircraft";
}
echo "<br> <font color='#800000'><b>State:</b> <font color='#000000'>$State <font color='#800000'><b>FAA Region:</b> <font color='#000000'>$FAARegion";

echo "<br> <font color='#800000'><b>Species:</b> <font color='#000000'>$Species_Name"; 
echo "<br> <font color='#800000'><b>Word/Phrase in Remarks:</b> <font color='#000000'>$Descr";


echo "<p> <font color='#800000'><b>Hits Ordered By:</b> <font color='#000000'>$Order <font 
color='#800000'><b>Ordering:</b> <font color='#000000'>$Ordering";

echo "<br><font color='#800000'><b>Max Hits:</b> <font color='#000000'>$Hits";
*/
$num_results = mysql_num_rows($result);
$returns = $num_results;
if ($returns > $Hits && $Hits != "All") { $returns--; }

// Logging Activity

	if(empty($REMOTE_HOST)) { $remote_host = "Unknown"; }
	else { $remote_host = $REMOTE_HOST; }

	$today = date("D M j Y H:i:s") . " MST";

	$fp = fopen("activity_log.txt", "a");
	fwrite($fp, "Enter Summary Results (Level I) " . $returns . " Hits from Query (" . $query . ") by " . $remote_host . " (" . $REMOTE_ADDR . ") - " . $today . "\n");
	fclose($fp);

$returns = number_format($returns,0);
$returns1 = number_format($returns1,0);
 
//echo "<p><font color='#800000'><b>Number of Reports Found:</b> <font color='#000000'>$returns1</font>";
//echo "<br><font color='#800000'><b>Number of Reports Returned:</b> <font color='#000000'>$returns</font>";




  if ($num_results > $Hits && $Hits != "All") {
	$num_results = $num_results - 1; // remove 1 extra from search limit
//	echo "<p><center><font face='Arial,Helvetica' color='red' size=-1><b>More than $Hits Reports Found.";
//	echo "<br><font face='Arial,Helvetica' color='red' size=-1><b>Please Increase Max Hits Allowed or Narrow Your Search Criteria.";
	//if ($Hits <> $MaxHits) {
 	//	echo " or increase allowed hits</b>";
	//	}
  	//echo ".";
	}
//  echo "<br>&nbsp;</td></tr></center>";
?>
</table>
<center><table width=825 BORDER=1 CELLPADDING=3 >

<caption>
<?
        if($num_results !=0) {
//	echo "<font face='Arial,Helvetica' size=-1 color='#800000'><b>Click Incident Date to View 
//Individual Strike Report</b>&nbsp;<font color='#000000'>(</font><b>Bolded Date</b> <font 
//color='#000000'>Indicates Reported Damage on Form 
//5200-7)";
}
 if($num_results > 5) {
//echo "<p><a href='#download'><b>Click</b></a> <font color='#800000'><b>For Info to  Download Individual 
//Strike Reports into EXCEL for a more detailed Analysis.</b><br>&nbsp;";
}
//else { echo "<br>&nbsp;"; }
?>

</font></font></caption>
<tr>
<td width=10% bgcolor="#800000">
<center><font face="Arial,Helvetica" size=-1 color="white"><b>Incident Date</b></center>
</td>

<td bgcolor="#800000">
<center><font face="Arial,Helvetica" size=-1 color="white"><b>Airport</b></center>
</td>

<td bgcolor="#800000">
<center><font face="Arial,Helvetica" size=-1 color="white"><b>State</b></center>
</td>

<td bgcolor="#800000">
<center><font face="Arial,Helvetica" size=-1 color="white"><b>FAA<br>Region</b></center>
</td>

<td bgcolor="#800000">
<center><font face="Arial,Helvetica" size=-1 color="white"><b>Operator</b></center>
</td>

<td bgcolor="#800000">
<center><font face="Arial,Helvetica" size=-1 color="white"><b>Aircraft</b></center>
</td>

<td bgcolor="#800000">
<center><font face="Arial,Helvetica" size=-1 color="white"><b>Damage<br>Code*</b></center>
</td>

<td bgcolor="#800000">
<center><font face="Arial,Helvetica" size=-1 color="white"><b>Species**</b></center>
</td>

</tr>

<?
	if($num_results !=0) {
	mt_srand((double)microtime() * 1000000); // assign filename with random number appended
	$number = mt_rand(1,1000);
	$filename = "LevelIsummary" . $number;

	$filename = $filename . ".xls"; // was cdl

	$fp = fopen("delete_data_files.txt", "a"); // add for subsequent deletion if more than 1 day old
	fwrite($fp, $filename . "," . date("d") . "\n");
	fclose($fp);
	
	$fp = fopen($filename, "w");
	$data = "Find Nr" . "\t"; 
        $data = $data . "Operator ID" . "\t";
        $data = $data . "Operator" . "\t";
        $data = $data . "A/C Type" . "\t";
        $data = $data . "AMA" . "\t";
        $data = $data . "AMO" . "\t";
        $data = $data . "EMA" . "\t";
        $data = $data . "EMO" . "\t";
        $data = $data . "Registration" . "\t";
        $data = $data . "Flt Nr" . "\t";
        $data = $data . "Remains Collected" . "\t";
        $data = $data . "Remains Sent" . "\t";
        $data = $data . "Incident Date" . "\t";
        $data = $data . "Time of Day" . "\t";
        $data = $data . "Time" . "\t";
        $data = $data . "Airport ID" . "\t";
        $data = $data . "Airport" . "\t";
        $data = $data . "State" . "\t";
        $data = $data . "FAA Region" . "\t";
        $data = $data . "Enroute" . "\t";
        $data = $data . "Runway" . "\t";
        $data = $data . "Location" . "\t";
        $data = $data . "Height" . "\t";
        $data = $data . "Speed" . "\t";
        $data = $data . "Phase of Flight" . "\t";
        $data = $data . "Damage" . "\t";
        $data = $data . "Str Radome" . "\t";
        $data = $data . "Dam Radome" . "\t";
        $data = $data . "Str Windshield" . "\t";
        $data = $data . "Dam Windshield" . "\t";
        $data = $data . "Str Nose" . "\t";
        $data = $data . "Dam Nose" . "\t";
        $data = $data . "Str Eng 1" . "\t";
        $data = $data . "Dam Eng 1" . "\t";
        $data = $data . "Str Eng 2" . "\t";
        $data = $data . "Dam Eng 2" . "\t";
        $data = $data . "Str Eng 3" . "\t";
        $data = $data . "Dam Eng 3" . "\t";
        $data = $data . "Str Eng 4" . "\t";
        $data = $data . "Dam Eng 4" . "\t";
        $data = $data . "Ingested" . "\t";
        $data = $data . "Str Prop" . "\t";
        $data = $data . "Dam Prop" . "\t";
        $data = $data . "Str Wing/Rotor" . "\t";
        $data = $data . "Dam Wing/Rotor" . "\t";
        $data = $data . "Str Fuselage" . "\t";
        $data = $data . "Dam Fuselage" . "\t";
        $data = $data . "Str Landing Gear" . "\t";
        $data = $data . "Dam Landing Gear". "\t";
        $data = $data . "Str Tail" . "\t";
        $data = $data . "Dam Tail" . "\t";
        $data = $data . "Str Lights" . "\t";
        $data = $data . "Dam Lights" . "\t";
        $data = $data . "Str Other" . "\t";
        $data = $data . "Dam Other" . "\t";
        $data = $data . "Other Specify" . "\t";
        $data = $data . "Effect" . "\t";
        $data = $data . "Effect Other" . "\t";
        $data = $data . "Sky" . "\t";
        $data = $data . "Precip" . "\t";
        $data = $data . "Species ID" . "\t";
        $data = $data . "Species" . "\t";
        $data = $data . "Birds Seen" . "\t";
        $data = $data . "Birds Struck" . "\t";
        $data = $data . "Size" . "\t";
        $data = $data . "Pilot Warned" . "\t";
        $data = $data . "Comments" . "\t";
        $data = $data . "Description" . "\t";
        $data = $data . "A/C Out-of-Service" . "\t";
        $data = $data . "Cost Repairs" . "\t";
        $data = $data . "Other Costs" . "\t";
        $data = $data . "Nr Injuries" . "\t";
        $data = $data . "Nr Fatalities" . "\t";
        $data = $data . "Reported Name" . "\t";
        $data = $data . "Reported Title" . "\t";
        $data = $data . "Reported Date" . "\t";
        $data = $data . "Source" . "\t";
        $data = $data . "Person" . "\t";
        $data = $data . "Last Update" . "\t";

	fwrite($fp, $data . "\n");
	}


  	for ($i=0; $i <$num_results; $i++) {
     		$row = mysql_fetch_array($result);
     		//$find_nr = stripslashes($row["find_nr"]);
     		$incident_date = stripslashes($row["incident_date"]);
		$incident_date1 = fixdate($incident_date);
//                $incident_date1 = substr($incident_date, 4, 2 ) . "/" . substr($incident_date, 6, 2) . "/" . substr($incident_date, 0, 4);

		//$incident_date = substr($incident_date, 5) . "-" . substr($incident_date, 0, 4);
		$incident_date = substr($incident_date, 4, 2) . "-" . substr($incident_date, 6, 2) . "-" . substr($incident_date, 0, 4);

     		//$incident_date_link = "<a href=results_i.php?find_nr=" . stripslashes($row["find_nr"]) . ">" . stripslashes($row["incident_date"] . "</a>");
     		$incident_date_link = "&nbsp;<a href=results_i.php?find_nr=" . stripslashes($row["find_nr"]) . ">" . $incident_date . "</a>&nbsp;";
     		
		$airport = stripslashes($row["airport"]);
		if ($airport == "") { $airport = "(NONE PROVIDED)" ; }
		else { $airport = stripslashes($row["airport"]) . " (" . stripslashes($row["airport_id"]) . ")"; }

                $state = stripslashes($row["state"]);   
                if ($state == "") { $state = "&nbsp;" ; }

                $faaregion = stripslashes($row["faaregion"]);   
                if ($faaregion == "") { $faaregion = "&nbsp;" ; }

     		$operator = stripslashes($row["operator"]);
		if ($operator == "") { $operator = "(NONE)" ; }

     		$atype = stripslashes($row["atype"]);
		if ($atype == "") { $atype = "(NONE)"; }

     		$damage = stripslashes($row["damage"]);
		if ($damage == "") { $damage = "&nbsp;"; }

     		$species = stripslashes($row["species"]);
		if ($species == "") { $species = "(NONE)"; }

     		$indicated_damage = $row["indicated_damage"];

                if($indicated_damage == "Yes") {
			echo "<tr><td><font face='Arial,Helvetica' size=-1><center><b>" . $incident_date_link . "</b></center></td>";
		}
		else {
			echo "<tr><td><font face='Arial,Helvetica' size=-1><center>" . $incident_date_link . "</center></td>";
		}
		echo "<td><font face='Arial,Helvetica' size=-1>&nbsp;" . $airport . "</td>";
		echo "<td><font face='Arial,Helvetica' size=-1><center>" . $state . "</center></td>";
		echo "<td><font face='Arial,Helvetica' size=-1><center>" . $faaregion . "</center></td>";
                echo "<td><font face='Arial,Helvetica' size=-1>&nbsp;" . $operator . "</td>";
		echo "<td><font face='Arial,Helvetica' size=-1><center>" . $atype . "</center></td>";
		echo "<td><font face='Arial,Helvetica' size=-1><center>" . $damage . "</center></td>";

		$species = str_replace(",", ", ", $species);
		echo "<td><font face='Arial,Helvetica' size=-1>&nbsp;" . $species . "</td></tr>";

		if($num_results !=0) {	
	  $data = $row["find_nr"] . "\t"; 
        $data = $data . $row["opid"] . "\t";
        $data = $data . $row["operator"] . "\t";
        $data = $data . $row["atype"] . "\t";
        $data = $data . $row["ama"] . "\t";
        $data = $data . $row["amo"] . "\t";
        $data = $data . $row["ema"] . "\t";
        $data = $data . $row["emo"] . "\t";
        $data = $data . $row["reg"] . "\t";
        $data = $data . $row["flt"] . "\t";
        $data = $data . $row["remains_collected"] . "\t";
        $data = $data . $row["remains_sent"] . "\t";
 //       $data = $data . $row["incident_date"] . "\t";
        $data = $data . $incident_date1 . "\t";
        $data = $data . $row["time_of_day"] . "\t";
        $data = $data . $row["time"] . "\t";
        $data = $data . $row["airport_id"] . "\t";
        $data = $data . $row["airport"] . "\t";
        $data = $data . $row["state"] . "\t";
        $data = $data . $row["faaregion"] . "\t";
        $data = $data . $row["enroute"] . "\t";
	$runway = str_replace("/", "\\", $row["runway"]);  // rw/rw is read by EXCEL as a date
        $data = $data . $runway. "\t";
        $data = $data . $row["location"] . "\t";
        $data = $data . $row["height"] . "\t";
        $data = $data . $row["speed"] . "\t";
        $data = $data . $row["phase_of_flight"] . "\t";
        $data = $data . $row["damage"] . "\t";
        $data = $data . $row["str_rad"] . "\t";
        $data = $data . $row["dam_rad"] . "\t";
        $data = $data . $row["str_windshld"] . "\t";
        $data = $data . $row["dam_windshld"] . "\t";
        $data = $data . $row["str_nose"] . "\t";
        $data = $data . $row["dam_nose"] . "\t";
        $data = $data . $row["str_eng1"] . "\t";
        $data = $data . $row["dam_eng1"] . "\t";
        $data = $data . $row["str_eng2"] . "\t";
        $data = $data . $row["dam_eng2"] . "\t";
        $data = $data . $row["str_eng3"] . "\t";
        $data = $data . $row["dam_eng3"] . "\t";
        $data = $data . $row["str_eng4"] . "\t";
        $data = $data . $row["dam_eng4"] . "\t";
        $data = $data . $row["ingested"] . "\t";
        $data = $data . $row["str_prop"] . "\t";
        $data = $data . $row["dam_prop"] . "\t";
        $data = $data . $row["str_wing_rot"] . "\t";
        $data = $data . $row["dam_wing_rot"] . "\t";
        $data = $data . $row["str_fuse"] . "\t";
        $data = $data . $row["dam_fuse"] . "\t";
        $data = $data . $row["str_lg"] . "\t";
        $data = $data . $row["dam_lg"] . "\t";
        $data = $data . $row["str_tail"] . "\t";
        $data = $data . $row["dam_tail"] . "\t";
        $data = $data . $row["str_lghts"] . "\t";
        $data = $data . $row["dam_lghts"] . "\t";
        $data = $data . $row["str_other"] . "\t";
        $data = $data . $row["dam_other"] . "\t";
        $data = $data . $row["other_specify"] . "\t";
        $data = $data . $row["effect"] . "\t";
        $data = $data . $row["effect_other"] . "\t";
        $data = $data . $row["sky"] . "\t";
        $data = $data . $row["precip"] . "\t";
        $data = $data . $row["species_id"] . "\t";
        $data = $data . $row["species"] . "\t";

	$temp = $row["birds_seen"];
	if($temp != "") { $temp = str_replace("-", " to ", $temp); }
        $data = $data . $temp . "\t";
	$temp = $row["birds_struck"];         
	if($temp != "") { $temp = str_replace("-", " to ", $temp); }

        $data = $data . $temp . "\t";    
        $data = $data . $row["size"] . "\t";
        $data = $data . $row["warned"] . "\t";
        $data = $data . $row["comments"] . "\t";
        $data = $data . $row["descr"] . "\t";
        $data = $data . $row["aos"] . "\t";
        $data = $data . $row["cost_repairs"] . "\t";
        $data = $data . $row["cost_other"] . "\t";

        $nr_injuries = $row["nr_injuries"];
        if($nr_injuries == 0) { $nr_injuries = ""; }
        $data = $data . $nr_injuries . "\t";
//	$data = $data . $row["nr_injuries"] . "\t";

        $nr_fatalities = $row["nr_fatalities"]; 
        if($nr_fatalities == 0) { $nr_fatalities = ""; }
        $data = $data . $nr_fatalities . "\t";

//      $data = $data . $row["nr_fatalities"] . "\t";

        $data = $data . $row["reported_name"] . "\t";
        $data = $data . $row["reported_title"] . "\t";

	$indate = $row["reported_date"];
	if($indate == 0) { $indate = ""; } else { $indate = fixdate($indate); }
 	$data = $data . $indate . "\t";
//        $data = $data . $row["reported_date"] . "\t";
        $data = $data . $row["source"] . "\t";
        $data = $data . $row["person"] . "\t";

	$indate = $row["lupdate"];
	if($indate == 0) { $indate = ""; } else { $indate = fixdate($indate); }
 	$data = $data . $indate . "\t";
//        $data = $data . $row["lupdate"] . "\t";



	  fwrite($fp, $data . "\n");
		}
  	}


	if($num_results !=0) {

	$From_Month = trim(StripSlashes($HTTP_POST_VARS["From_Month"]));
	$From_Day = trim(StripSlashes($HTTP_POST_VARS["From_Day"]));
	$From_Year = trim(StripSlashes($HTTP_POST_VARS["From_Year"]));
	$To_Month = trim(StripSlashes($HTTP_POST_VARS["To_Month"]));
	$To_Day = trim(StripSlashes($HTTP_POST_VARS["To_Day"]));
	$To_Year = trim(StripSlashes($HTTP_POST_VARS["To_Year"]));
      
  	if($From_Month == "Select") { $From_Month = "Earliest"; $From_Day = "Date"; $From_Year = "";}
        
  	if($To_Month == "Select") { $To_Month = "Latest"; $To_Day = "Date"; $To_Year = "";}
        
  	$Airport = StripSlashes($HTTP_POST_VARS["Airport"]);
	if($Airport == "Select") { $Airport = "All"; }
//                $Airport = strtolower($Airport);
//                $Airport = ucwords($Airport);


  	$State = StripSlashes($HTTP_POST_VARS["State"]);
  	if($State == "Select") { $State = "All"; }
  
	$FAARegion = StripSlashes($HTTP_POST_VARS["FAARegion"]);
	if($FAARegion == "Select") { $FAARegion = "All"; }
  
	$Airport_ID = StripSlashes($HTTP_POST_VARS["Airport_ID"]);
	if($Airport_ID == "Select") { $Airport_ID = "All"; }

	$Operator = StripSlashes($HTTP_POST_VARS["Operator"]);
	if($Operator == "Select") { $Operator = "All"; }
//              $Operator = strtolower($Operator);
//                $Operator = ucwords($Operator);


	$Aircraft = StripSlashes($HTTP_POST_VARS["Aircraft"]);
	if($Aircraft == "Select") { $Aircraft = "All"; }
  
	$Species_Name = StripSlashes($HTTP_POST_VARS["Species_Name"]);
	if($Species_Name == "Select") { $Species_Name = "All"; }
//              $Species_Name = strtolower($Species_Name);          
//                $Species_Name = ucwords($Species_Name);       

	$Descr = StripSlashes($HTTP_POST_VARS["Descr"]);
	if($Descr == "") { $Descr = "None"; }

                $From_Month = strtolower($From_Month);
                $From_Month = ucwords($From_Month);
  
                $To_Month = strtolower($To_Month);
                $To_Month = ucwords($To_Month);

		fwrite($fp, "\nSelected Search Criteria:\n");
		fwrite($fp, "From: $From_Month $From_Day $From_Year  To: $To_Month $To_Day $To_Year\n");

		fwrite($fp, "Airport: $Airport  Airport ID: $Airport_ID\n");
		fwrite($fp, "Operator: $Operator\n");
		fwrite($fp, "Aircraft: $Aircraft\n");
		fwrite($fp, "State: $State\n");
		fwrite($fp, "FAA Region: $FAARegion\n");
		fwrite($fp, "Species: $Species_Name\n");	
		fwrite($fp, "Word/Phrase in Remarks: $Descr\n");

		fwrite($fp, "Number of Reports Found: $returns1\n");
		fwrite($fp, "Number of Reports Returned: $returns\n");

        fwrite($fp, "\nSource: FAA National Wildlife Strike Database (Level I) - " . $revision . "\nDownloaded - " . $today . "\n");
	fclose($fp);
	}


	if($num_results == 0) {
		echo "<tr><td colspan=8><center><font face='Arial,Helvetica' size=-1>No Reports Found.</center></td></tr>";
	}
?>

</table>
<center><table COLS=1 CELLPADDING=2 WIDTH="825" >
<tr><td>
<?

if($num_results !=0) {

	echo "<p>&nbsp;<br><font face='Arial,Helvetica' color='#800000' size=-1>* 
Damage Codes (Civilian) - <font color='#000000'> N (None),
 M (Minor), M? (Damage, but extent unknown), S (Substantial) and D (Destroyed).
<br>&nbsp;&nbsp;<font face='Arial,Helvetica' color='#800000' size=-1>Damage Codes (Military) -
<font face='Arial,Helvetica' color='#000000' size=-1> Class A (Over $1,000,000), Class B ($200,000 - 1,000,000),
Class C ($20,000 - Less Than $200,000),&nbsp;&nbsp;Class N (No Damage or Damage Less Than $20,000).<br>&nbsp;&nbsp;See <a
href='http://wildlife-mitigation.tc.faa.gov/public_html/moa.pdf'>Memorandum
of Agreement (Glossary)</a> for exact definitions of damage codes.";

	echo "<p><font face='Arial,Helvetica' color='#800000' size=-1>** Species<font color='#000000'> - For 
additional information on various species, please see $survey_desc";
	echo "<a name='download'>";

	echo "<p><b><font face='Arial,Helvetica' color='#000000' size=-1><a href=download.php?filename=$filename>Download Data 
File</a>
which contains all of the above Strike Reports suitable for importing into EXCEL (or other 
spreadsheet program). File format is tab-delimited with field names being the first record.</b><br></font></font></font>";} 
/*
else {
	echo "<br>&nbsp;";
     }
*/
?>
<center>
<p></font></font><img SRC="brownbar.gif" ></font>
<br>&nbsp;<center><font face="Arial,Helvetica" color="#000000" size=-0>Return To</font>
<br><font face="Arial,Helvetica" size=-0><a href="javascript:history.back()">Wildlife Strike
Database Query Select</a></center>
</center><p>&nbsp;<br><font size=-2 color="#000000">
<br>Prepared for the FAA by
<br>Embry-Riddle Aeronautical University
<br>Prescott, AZ
<br>Revised: <font color="#000000">ARN, May 25, 2004
</td></tr>
</table>

</body>
</html>
