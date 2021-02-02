<?
/******************************************************************
 *  logging.php  - These PHP functions handle logging activities to   
 *  files. 
 *
 *  Parameters:
 *  $log_name        -  The name of the log file to write to and path if not
 *                    the current directory.
 *  $level           - ex. Level I, Level IIA 
 *  $remote_host     -
 *  $remote_addr     -
 *  $http_user_agent -
 *
 *  An example of a log file entry:
 *
 *  Display Strike Index Airport Statistics Results(Level IIA) for 
 *  /database/strike_index/KJFK.php by Unknown (172.19.9.8) using Mozilla/4.0
 *  (compatible; MSIE 6.0; Windows NT 5.1; SV1; MathPlayer 2.0; .NET CLR
 *  1.1.4322; InfoPath.1; .NET CLR 2.0.50727) - Tue Oct 3 2006 09:57:35 MST
 ******************************************************************/
function writeLog($log_name, $level, $remote_host, $remote_addr,
                  $http_user_agent, $page){
    //phpinfo();
    // Logging Activity
    if(empty($REMOTE_HOST)) { 
        $remote_host = "Unknown"; 
    }
    else { 
        $remote_host = $REMOTE_HOST;
    }

    $today = date("D M j Y H:i:s") . " MST";
    //echo "In writeLog: Ap_PWord=$Ap_PWord level=$level airport=$Airport<br>";  
    $fp = fopen($log_name, "a");

    fwrite($fp, "Display Strike Index Airport Statistics Results(". $level .
           ") for ". $page . " by " . $remote_host . " (" . $remote_addr . 
           ") using " . $http_user_agent . " - " . $today . "\n");

    fclose($fp);
}

function writeActivityLog($level, $remote_host, $remote_addr,
			  $http_user_agent, $page) {
  $log="/users/wildlife/public_html/database/activity_log.txt";

  writeLog($log, $level, $remote_host, $remote_addr, $http_user_agent,
  $page);

}

function writeStrikeRptLog($level, $remote_host, $remote_addr, 
                           $http_user_agent, $page) {
    $log="/users/wildlife/public_html/database/strike_index/strikeRpt_log.txt";

    writeLog($log, $level, $remote_host, $remote_addr, $http_user_agent,
             $page);

}

?>
