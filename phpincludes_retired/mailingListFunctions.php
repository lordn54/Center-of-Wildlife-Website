<?php
//  These are functions that are useful in the work with the Mailing List.
//
//  We have decided instead of updating registrants.txt directly we
//  will put them in a holding area.  An e-mail will be sent telling the
//  forum administrators that there are new requests.
//  The new requests are temporarily placed in files in the MailingList
//  directory.
//  XML format is used for the posting files. 
// 
//  The admins can easily add them from the admin section of the website.

function mailNotice($name, $email, $organization){
  $FORUM_ADMIN="marric72@erau.edu";

  mail($FORUM_ADMIN, "New Mailing List Request for Review", "name=$name\nemail=$email\norganization=$organization\n");

}

function postMessage($name, $email, $organization){
  $errors=0;  //keep track of any errors you see with posting, to add
             //error checking later (maybe some spam checks here)
  
  //commented this out 12/6/10 because we were getting many junk
  //additions daily.  Instead of reading/deleting each e-mail individually
  //I will just check the list of additions once a week. 
  //mailNotice($name, $email, $organization);

  //Add today's date
  $today=date("Y:m:j H:i:s");
  //echo "today=$today<b>";
  $fileEx=date("Ymj_His"); //extension to append to file name

  $fh=fopen("MailingList/newUser${fileEx}.txt", 'w');
  fwrite($fh, "<request>\n");
  fwrite($fh, "<name>$name</name>\n");
  fwrite($fh, "<email>$email</email>\n");
  fwrite($fh, "<organization>$organization</organization>\n");
  fwrite($fh, "<datetime>$today</datetime>\n");
  fwrite($fh, "</request>\n");

  fclose($fh);

  return $errors;
}

function dirList($directory){
  $results=array();
  $handler=opendir($directory);
  while($file=readdir($handler)){
    // if $file isn't this directory or its parent, 
    // add it to the results array
    if ($file != '.' && $file != '..')
      $results[] = $file;
  }
  closedir($handler);

  return $results;
}

function getPosting($file){
  //echo "Reading from file: $file<br>";
  $postDir="../MailingList/";
  $fh2=fopen("${postDir}$file", 'r');
  $post['file']="${file}";
  while(!feof($fh2)){
    $line=fgets($fh2, 9999);
    if(preg_match( '/<email>(.*)<\/email>/', $line, $match)){
      //echo "email=".$match[1]."<br>";
      $post['email']=$match[1];
    }
    elseif(preg_match( '/<name>(.*)<\/name>/', $line, $match)){
      //echo "name=".$match[1]."<br>";
      $post['name']=$match[1];
    }
    elseif(preg_match( '/<organization>(.*)<\/organization>/', $line, $match)){
      //echo "organization=".$match[1]."<br>";
      $post['organization']=$match[1];
    }
    elseif(preg_match( '/<datetime>(.*)<\/datetime>/', $line, $match)){
      //echo "datetime=".$match[1]."<br>";
      $post['datetime']=$match[1];
    }
  }
  fclose($fh2);
  return $post;
}

function findNewRequests(){
  $numPosts=0;
  //This function is run from the admin directory
  $postDir="../MailingList/";
  $files=dirList($postDir);
  foreach($files as $file){ 
    $p=getPosting("$file");
    $post[$numPosts]=$p;
    $numPosts++;
  }
  return $post;
}

function printPosting($post){
  echo "In mailing list requests .....<br>";
  echo "name: ".$post['name']."<br>"; 
  echo "email: ".$post['email']."<br>";
  echo "company: ".$post['organization']."<br>";
  echo "datetime: ".$post['datetime']."<br>";
}