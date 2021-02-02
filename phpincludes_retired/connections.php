<?php
#library file with utility routines for dealing with bird strike databases.

function heather_connect(){
    $db_name="heather";
    $host_name="localhost";
    $user_name="marric72";
    $password="**4Center**"; #7/31/17 password changed after hacking attempts


    $conn_id=@mysql_connect($host_name, $user_name, $password);
    if(! $conn_id){
      if(mysql_errno()){
        die(sprintf("Cannot connect to server: %s (%d)\n", htmlspecialchars(mysql_error()), mysql_errno()));
      }
      else{
        die("Cannot connect to server: ".htmlspecialchars($php_errormsg)."\n");
      }
    }
    if(!@mysql_select_db($db_name)){
      die(sprintf("Cannot select database: %s (%d)\n", htmlspecialchars(mysql_error($conn_id)), mysql_errno($conn_id)));
    }
    return ($conn_id);
}

function wltest_connect(){
  $db_name="wl_test";
  $host_name="localhost";
  $user_name="marric72";
  $password="**4Center**"; #7/31/17 password changed after hacking attempts


  $conn_id=@mysql_connect($host_name, $user_name, $password);
  if(! $conn_id){
    if(mysql_errno()){
      die(sprintf("Cannot connect to server: %s (%d)\n", htmlspecialchars(mysql_error()), mysql_errno()));
    }
    else{
      die("Cannot connect to server: ".htmlspecialchars($php_errormsg)."\n");
    }
  }
  if(!@mysql_select_db($db_name)){
    die(sprintf("Cannot select database: %s (%d)\n", htmlspecialchars(mysql_error($conn_id)), mysql_errno($conn_id)));
  }
  return ($conn_id);
}

function prod_connect(){
  $db_name="birdstrike";
  $host_name="localhost";
  $user_name="marric72"; #11/21/2013 marric72 got same permissions on birdstrike as newmana
  $password="**4Center**"; #7/31/17 password changed after hacking attempts

  $conn_id=@mysql_connect($host_name, $user_name, $password);
  if(! $conn_id){
    if(mysql_errno()){
      die(sprintf("Cannot connect to server: %s (%d)\n", htmlspecialchars(mysql_error()), mysql_errno()));
    }
    else{
      die("Cannot connect to server: ".htmlspecialchars($php_errormsg)."\n");
    }
  }
  if(!@mysql_select_db($db_name)){
    die(sprintf("Cannot select database: %s (%d)\n", htmlspecialchars(mysql_error($conn_id)), mysql_errno($conn_id)));
  }
  return ($conn_id);
}

?>
