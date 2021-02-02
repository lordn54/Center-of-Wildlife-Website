<?php
$fh=fopen("count_lines.csv", "w");
fwrite($fh, "Directory,  Code Lines, Code Files,  Web Page Lines, Web Page Files, Data Lines, Data Files\n");

echo "Directory,  Code Lines, Code Files,  Web Page Lines, Web Page Files, Data Lines, Data Files<br>";

//turn off warnings
error_reporting(E_ERROR | E_PARSE);

$top_level=getcwd();
listDirectoryContents($fh);
subDirectoryContents($fh);
fclose($fh);


function subDirectoryContents($fh){

  $dir = opendir(".");//List files in images directory
  while (($file = readdir($dir)) !== false)
  {
    //echo "Directory handle: " . $file . "<br />";
    if(($file != "..") && ($file != ".") && ($file != $d) && is_dir($file)){
      //echo "subdirectory $file<br>";
      chdir($file);
      listDirectoryContents($fh);
      subDirectoryContents($fh); 

      //return to the top level directory
      chdir("..");
    }
  }closedir($dir);
}

function listDirectoryContents($fh){
  //Print the current working directory
  echo getcwd().", ";
  fwrite($fh, getcwd().", ");

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
echo "$total, ";
fwrite($fh, "$total, ");
echo "$count, ";
fwrite($fh, "$count, ");

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
echo "$total, ";
fwrite($fh, "$total, "); 
echo "$count, ";
fwrite($fh, "$count, ");

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
echo "$total, ";
fwrite($fh,  "$total, ");  
echo "$count<br>";
fwrite($fh,  "$count\n");
}
?> 
