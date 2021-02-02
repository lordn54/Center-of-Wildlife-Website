<?php
$DEBUG=0;

$q = strtolower($_GET["term"]);
if (!$q) return;

$fp = fopen("tblAirport.txt", "r");
$count = 0;
while (!feof($fp)) {

  $temp = fgets($fp,100);
  $array = explode("\t", $temp);
  if($array[0] == "KWLI") { continue; } // Does not display phoney airport KWLI
  //ignore blank
  if($array[0]==""){ continue; }
  $airport_id[$count]=trim($array[0]);

  //$airport[$count] = $array[1]; 
  $airport[$count] = $array[1]; //. "(". $airport_id[$count].")";
  $airport[$count]=trim($airport[$count]);
  if ($DEBUG){
    print "airport $airport[$count]*** airport_id=$airport_id[$count]**<br>";
  }
  $count++;
}
$count_airport = $count_airport_id = $count;

fclose($fp);

//sort($airport);

if($DEBUG){
  print "done reading airports airport[0]=". $airport[0]."<br><br>";
  print "done reading airports airport[1]=". $airport[1]."<br><br>";
  print "done reading airports airport[2]=". $airport[2]."<br><br>";

}

$result = array();


for($i=0; $i<$count; $i++){
  if (strpos(strtolower($airport[$i]), $q) !== FALSE) {

    if ( ((strpos(strtolower($airport[$i]), $q) == 0))){ 
      //print "add to array $airport[$i]<br>";
      array_push($result, array("id"=>$airport[$i], "label"=>$airport[$i]." (".$airport_id[$i].")", "value" => strip_tags($airport[$i])));
    }
    if (count($result) > 11)
      break;
  }
  else if (strpos(strtolower($airport_id[$i]), $q) !== FALSE) {
    //print "add to array ID: $airport[$i] $airport_id[$i]<br>";
    array_push($result, array("id"=>$airport_id[$i], "label"=>$airport[$i]." (".$airport_id[$i].")",
           "value" => strip_tags($airport[$i]." (".$airport_id[$i].")")));
    }
    if (count($result) > 11)
      break;
}


echo array_to_json($result);



//$items{"ABERDEEN REGIONAL AR (KABR)"}="ABERDEEN REGIONAL AR (KABR)"; 

function array_to_json( $array ){

  //echo "In array_to_json  array=$array<br>";
    if( !is_array( $array ) ){
        return false;
    }

    $associative = count( array_diff( array_keys($array), array_keys( array_keys( $array )) ));
    //echo "associative=$associative<br>";
    if( $associative ){

        $construct = array();
        //echo "construct =$construct<br>";
        foreach( $array as $key => $value ){
	  //echo "key =$key value=$value<br>";
            // We first copy each key/value pair into a staging array,
            // formatting each key and value properly as we go.

            // Format the key:
            if( is_numeric($key) ){
                $key = "key_$key";
            }
            $key = "\"".addslashes($key)."\"";

            // Format the value:
            if( is_array( $value )){
                $value = array_to_json( $value );
            } else if( !is_numeric( $value ) || is_string( $value ) ){
                $value = "\"".addslashes($value)."\"";
            }

            // Add to staging array:
            $construct[] = "$key: $value";
        }

        // Then we collapse the staging array into the JSON form:
        $result = "{ " . implode( ", ", $construct ) . " }";

    } else { // If the array is a vector (not associative):

        $construct = array();
        foreach( $array as $value ){

            // Format the value:
            if( is_array( $value )){
                $value = array_to_json( $value );
            } else if( !is_numeric( $value ) || is_string( $value ) ){
                $value = "'".addslashes($value)."'";
            }

            // Add to staging array:
            $construct[] = $value;
        }

        // Then we collapse the staging array into the JSON form:
        $result = "[ " . implode( ", ", $construct ) . " ]";
    }

    return $result;
}


?>