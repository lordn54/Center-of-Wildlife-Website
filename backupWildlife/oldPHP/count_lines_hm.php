<?php

//turn off warnings
error_reporting(E_ERROR | E_PARSE);

$top_level=getcwd();
listDirectoryContents();
subDirectoryContents();

function subDirectoryContents(){

  $dir = opendir(".");//List files in images directory
  while (($file = readdir($dir)) !== false)
  {
    //echo "Directory handle: " . $file . "<br />";
    if(($file != "..") && ($file != ".") && ($file != $d) && is_dir($file)){
      //echo "subdirectory $file<br>";
      chdir($file);
      listDirectoryContents();
      subDirectoryContents(); 

      //return to the top level directory
      chdir("..");
    }
  }closedir($dir);
}

function listDirectoryContents(){
  //Print the current working directory
  echo getcwd()."<br>";

// Count code lines (in pl and php files)

$count = 0;
$total = 0;
if ($handle = opendir(".")) {
     while (false !== ($file = readdir($handle))) {
      //    if ($file != "." && $file != ".." && ereg(".*reports.*", $file)) {
          if ($file != "." && $file != ".." && (ereg(".*pl.*", $file) || ereg(".*php.*", $file)) ) {
                     //echo "$file<br>";

                     $temp = file($file);
                     $lines = count($temp);
                     unset($temp);
                     $total = $total + $lines;
			   $count++;
                     //echo "$file - $lines<br>";
          }
    }
  closedir($handle);
}
echo "&nbsp;&nbsp;&nbsp;&nbsp;total code lines - $total<br>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;total code files - $count<br>";

// Count web page lines (in htm and html files)

$count = 0;
$total = 0;
if ($handle = opendir('.')) {
     while (false !== ($file = readdir($handle))) {
      //    if ($file != "." && $file != ".." && ereg(".*reports.*", $file)) {
          if ($file != "." && $file != ".." && ereg(".*htm.*", $file)) {
                     //echo "$file<br>";

                     $temp = file($file);
                     $lines = count($temp);
                     unset($temp);
                     $total = $total + $lines;
			   $count++;
                     //echo "$file - $lines<br>";
          }
    }
  closedir($handle);
}
echo "&nbsp;&nbsp;&nbsp;&nbsp;total web page lines - $total<br>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;total web page files- $count<br>";

// Count data lines (in text files)

$count = 0;
$total = 0;
if ($handle = opendir('.')) {
     while (false !== ($file = readdir($handle))) {
          if ($file != "." && $file != ".." && ereg(".*txt.*", $file)) {
          //if ($file != "." && $file != ".." && (ereg(".*pl.*", $file) || ereg(".*php.*", $file) || ereg(".*htm.*", $file)) ) {
                     //echo "$file<br>";

                     $temp = file($file);
                     $lines = count($temp);
                     unset($temp); 
                     $total = $total + $lines;
                     $count++;
                     //echo "$file - $lines<br>";
          }
    }
  closedir($handle);
}
echo "&nbsp;&nbsp;&nbsp;&nbsp;total data lines - $total<br>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;total data files - $count<br><br>";

}
?> 
