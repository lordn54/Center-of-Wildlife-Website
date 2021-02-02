<?
# Eliminate spam

//	echo "$valid_nr*$gen_valid_nr<br>";

  if($valid_nr != $gen_valid_nr) {
    $message = "Remote_Host =" . $REMOTE_HOST . "\nRemote_Address =" . $REMOTE_ADDR . "\ngen_valid_number=" . $gen_valid_nr . "\nvalid_number=" . $valid_nr . "\n";
//    mail("marric72@erau.edu", "Invalid Forum Form Submitted ", $message);
    header("Location:http://wildlife-mitigation.tc.faa.gov\n");
    exit();
  }
  
# Try to catch a hacker

// Filter words

        $words = array("nude", "naked", "acyclovir", "zoloft", "cyclobenzaprine", "sexual", "diazepam", "avatrim", "herbal", "hoodia", "porn", "promethazine", "zyrtec", "phentermine", "viagra", "cialis", "levitra", "testosterone", "meridia", "soma", "ultram", "propecia", "xanax", "valium", "virgin");

// Logging Activity

	if(empty($REMOTE_HOST)) { $remote_host = "Unknown"; }
	else { $remote_host = $REMOTE_HOST; }

	if(empty($HTTP_REFERER)) { $referer = "Unknown"; }
	else { $referer = $HTTP_REFERER; }

	$today = date("D M j Y H:i:s") . " MST";


	$fp = fopen("./restricted/activity_log.txt", "a");


      fwrite($fp, "Forum Form Submitted by " . $remote_host . " (" . $REMOTE_ADDR . ") using " . $HTTP_USER_AGENT . "  - " . $today . "\n");
	fclose($fp);

	$fp = fopen("./database/activity_log.txt", "a");


      fwrite($fp, "Forum Form Submitted by " . $remote_host . " (" . $REMOTE_ADDR . ") using " . $HTTP_USER_AGENT . "  - " . $today . "\n");
	fclose($fp);

	$message = "Forum Form Submitted by " . $remote_host . " (" . $REMOTE_ADDR . ") - " . $today . "\n";

	while(list($key,$val)=each($_POST)) {
	  $$key = $val;
          $message .= $key . " - " . $val . "\n";
          }
          // echo "***$message<br>";
          

	// Bad (Filter) words above

      $bad_words = "N";
      $bad_place = "N";
      

// Nothing but junk/porn from Russia and Germany (xxxx@xxxx.ru or xxxxx@xxxx.de)

        if(ereg(".*.ru.*", $email) || ereg(".*.de.*", $email)) {
                //echo "**$email**<br>";
                $message .= "\n" . $email . "\n";
                $bad_place = "Y";
        } 
                                               
	
        for ($i = 0; $i < count($words); $i++) {
                $temp = strtolower($words[$i]);
                if(ereg(".*$temp.*",  strtolower($comments))){
                      $message .= $temp . "\n";
                      $bad_words = "Y";
                }      
        }  
        
        $message .= "\n" . $email . "\nReferrer =" . $HTTP_REFERER . "\n";

        if($bad_words == "N" && $bad_place == "N") {                                                            
	  mail("marric72@erau.edu", "Forum Form Submitted ", $message);
	} else {
//	  mail("marric72@erau.edu", "Forum Form Rejected ", $message);
          header("Location:http://wildlife-mitigation.tc.faa.gov\n");
        }
 
# Try to catch a hacker

	$hackers = file("hackers.txt");
	$count = count($hackers);

	$hacker = "";
	for($i = 0; $i < $count; $i++) {
		$hackers[$i] = trim($hackers[$i]);
		//echo "*$REMOTE_ADDR* *$hackers[$i]*<br>";
		if(ereg(".*$hackers[$i].*", $REMOTE_ADDR)) {
		//echo "Found<br>";  
		$hacker = $hackers[$i];
		last;
		}		
	}

	if($hacker != "") {
		// Bye-Bye Hacker
		header("Location:./database/hacker.php?Host=$REMOTE_HOST&Address=$REMOTE_ADDR\n\n");
		exit;
	}
      
//	Lets add all Forum response address to hackers list - hand delete any legit Forum responees

	$parts = explode(".", $REMOTE_ADDR);
	$address = $parts[0] . "." . $parts[1] . ".";

/*
        $fp = fopen("hackers.txt", "a");
        fwrite($fp, $address . "\n");
        fclose($fp);
*/
/*
//	Sort the hackers file(?)

        $hackers = file("hackers.txt");
        $count = count($hackers);
        sort($hackers,SORT_NUMERIC);
        
        $fp = fopen("hackers.txt", "w");
        for($i = 0; $i < $count; $i++) {
            fwrite($fp, $hackers[$i]); 
        }
        fclose($fp);
*/       

echo "
<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.0 Transitional//EN\">
<HTML>
<HEAD>
   <META HTTP-EQUIV=\"Content-Type\" CONTENT=\"text/html; charset=iso-8859-1\">
   <META HTTP-EQUIV=\"Refresh\" CONTENT=\"5; URL=http://wildlife-mitigation.tc.faa.gov\">
   <META NAME=\"GENERATOR\" CONTENT=\"Mozilla/4.07 [en] (Win95; I; 16bit) [Netscape]\">
   <META NAME=\"Author\" CONTENT=\"Allen R. Newman\">
   <TITLE>E-Mail Acknowledgment</TITLE>
</HEAD>
<BODY TEXT=\"#000000\" BGCOLOR=\"#FFFFFF\" LINK=\"#0000EE\" VLINK=\"#FF00FF\" ALINK=\"#3333FF\" background=\"pics/bg5.jpg\">
&nbsp;
<CENTER><TABLE COLS=1 WIDTH=\"551\" >
<CAPTION><FONT FACE=\"Arial,Helvetica\"><FONT COLOR=\"#3333FF\"><FONT SIZE=+1>E-Mail Acknowledgment<br>&nbsp;</FONT></FONT></FONT></CAPTION>

<TR>
<TD BGCOLOR=\"#3333FF\">&nbsp;
<CENTER>
<BR><FONT FACE=\"Arial,Helvetica\"><FONT COLOR=\"#FFFFFF\"><B>Thank You for
the E-Mail.</B>
<P><FONT COLOR=#FFFFFF><FONT FACE=Arial,Helvetica><b>We will update the appropriate posting
as soon as possible.</b></FONT>&nbsp;</FONT>
<P><B><FONT FACE=Arial,Helvetica><FONT COLOR=#FFFFFF>Allen Newman,
Webmaster<p><font size=-2>Oct 28, 2008</FONT></FONT></FONT></B></CENTER>
<BR>&nbsp;</TD>
</TR>

<TR>
<TD></TD>
</TR>

</TABLE></CENTER>

</BODY>
</HTML>";

?>
