<?
/******************************************************************
 *  verifyPermissions.php - These PHP functions handle look at values
 *  that are set in cookies and determine if the user has permission to
 *  view the file they are asking for. 
 *
 ******************************************************************/

/* If a User is Level 1 the Level_I_User variable should be set to "yes"
 * and they are authorized.
 * If a User is Level IIA, then the Ap_PWord will have the airport
 * name stored.  Verify that that name matches the airport name they are trying
 * to reverence. All other users are unauthorized.
 */   
function verifyLevel_1_or_IIA($Ap_PWord, $Level_I_User, $airport_name){

  //echo "here in verifyLevel_1_or_IIA<br>";
  //echo "Ap_PWord=$Ap_PWord  Level_I_User=$Level_I_User<br>";

  //Read Ap_PWord cookie to determine if the user has the privilege to see
  //this page
  $parts = explode(":",$Ap_PWord);
  $save=$part[0];
  $airport=$parts[1];
  
  if($Level_I_User == "yes"){
      $level="Level I";
  }
  else if($airport != ""){
    //echo "<br>airport=$airport  airport_name=$airport_name<br>";

    /*Level IIA users can only view their airport's information */
    if($airport == $airport_name){
      $level="Level IIA";
    }
    else{ 
      $level="Unauthorized-$airport";
    }
  }
  else {
      $level="Unauthorized";
  }
  //echo "in verifyPermissions level=$level<br>";
  return $level;
}

/* Redirect the user to the Wildlife Mitigation Home Page  */
function redirectHome(){
    $url="http://wildlife-mitigation.tc.faa.gov/public_html/index.html";
    echo "<META HTTP-EQUIV='Refresh' CONTENT=\"0; URL=$url\">";

}

/* If a User is Level 1 the Level_I_User variable should be set to "yes"
 * and they are authorized.
 *
 * If a User is Level IIA, then the Ap_PWord will have the airport
 * name stored.  Verify that that name matches the airport name they are trying
 * to reverence.
 *
 * If a User is Level IIC, then the SD_PWord will have the state
 * name stored.  Verify that that name matches the state name they are trying
 * to reverence.
 *
 * All other users are unauthorized.
 */
function verifyLevel_1_or_IIAC($Ap_PWord, $Level_I_User, $airport_name, $SD_PWord, $state_name){

  //Read Ap_PWord cookie to determine if the user has the privilege to see
  //this page
  $parts = explode(":",$Ap_PWord);
  $save=$part[0];
  $airport=$parts[1];

  if($Level_I_User == "yes"){
    $level="Level I";
  }
  else if($airport != ""){
    //echo "<br>airport=$airport  airport_name=$airport_name<br>";

    /*Level IIA users can only view their airport's information */
    if($airport == $airport_name){
      $level="Level IIA";
    }
    else{
      $level="Unauthorized-$airport";
    }
  }
  else {
    $level="Unauthorized";
    $parts = explode(":",$SD_PWord);
    $save=$part[0];
    $state=$parts[1];

    //echo "state=$state<br>";

    if($state != ""){
      /*Level IIC users can only view their state's information */
      if($state == $state_name){
	$level="Level IIC";
      }
      else{
	$level="Unauthorized-$state";
      }
    }
  }
  //echo "in verifyPermissions level=$level<br>";
  return $level;
}

?>
