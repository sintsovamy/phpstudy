<?php 

function occurrenceCounter(array $arr, int $num){
    $counter = 0;
    foreach($arr as $value) {
        if ($value !== $num) {
            continue;
	}
	$counter++;
    }
    return $counter;
}

$arr = [1, 2, 1, 3];
$number = 1;

echo occurrenceCounter($arr, $number);
