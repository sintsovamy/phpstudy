<?php

function isInArray(array &$arr, int $val){
    $inArray = false;
    foreach ($arr as $value) {
        if ($value == $val) {
            $inArray = true;
            break;
	    }
    }
    return $inArray;
}

$array = [2, 3, 6, 1, 23, 2, 56, 7, 1, 15];
$number = 1;

echo isInArray($array, $number);
