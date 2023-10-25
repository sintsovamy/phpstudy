<?php

function printFromZero2Num(int $n)
{
    if ($n == 0) {
        echo $n;
	echo '<br>';    
    } else {
	echo $n - printFromZero2Num($n - 1);
        echo '<br>';
    }
}

$a = 10;

printFromZero2Num($a);

