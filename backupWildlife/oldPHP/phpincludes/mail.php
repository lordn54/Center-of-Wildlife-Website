<?
/******************************************************************
 *  mail.php  - These PHP functions handle sending mail messages.   
 *  sendWildlifeSummaryMail will filter out addresses that originated
 *  from known ERAU users.
 *
 ******************************************************************/
function sendMail($subject, $message, $from){
//  $to="marric72@erau.edu,newmana@erau.edu";  
  $to="marric72@erau.edu";  
// 5/9/2007 commenting out,too many e-mails mail($to, $subject, $message, $from);
}

function sendWildlifeSummaryMail($user_ip_address, $level, $page){
  #set Filter to On
  $filter_erau =1;

  if($filter_erau == 1){
    #check to see if this is an embry riddle user
    if($user_ip_address == "172.19.9.8"){
      $user_ip_address.=":Heather's Office\n";
      return; 
    } 
    else if($user_ip_address == "24.117.200.20"){
      $user_ip_address.=":Heather's Home\n";
      return;
    }
  }

  $today= date("D M j Y H:i:s") . " MST";

  $subject= "Wildlife Strike Summary page viewed";
  $body="A Wildlife Strike Summary page was viewed: $today\n";
  $body.="               $page\n\n";
  $body.="The viewer is at : $user_ip_address \n";
  $body.="They have permissions: $level\n"; 
 
  $from="From:WildlifeSystem@erau.edu"; 
  sendMail($subject, $body, $from); 
}
