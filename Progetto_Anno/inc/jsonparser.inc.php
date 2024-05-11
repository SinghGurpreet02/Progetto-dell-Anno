<?php

function Jsonparser($data,$class)
{
    //Non testato su array
    //https://stackoverflow.com/questions/5397758/json-decode-to-custom-class
    foreach ($data as $key => $value) $class->{$key} = $value;

    return $class; 
}

?>