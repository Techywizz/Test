<?php  die('sdas');
/* Read the file and assign to a variable */
$data = file_get_contents( 'https://techsolitaire.com/api/city.list.json' );

/* Decode the json data and create an array */
$json = jsondecode( $data, true );

/* get the array keys */
$keys = array_keys( $json );

/* debug output */
var_dump( $keys );

/* process each node of the json data */
foreach( $json as $arr ){
    foreach( $arr as $obj ) echo $obj->id, $obj->name;
}

?>