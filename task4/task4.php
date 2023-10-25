<?php

function minNum(float $a, float $b, float $c)
{
    if ($a < $b && $a < $c) {
        return $a;
    }
    if ($b < $a && $b < $c) {
        return $b;
    }   
    if ($c < $b && $c < $a) {
        return $c;
    }
}

$a = 5;
$b = 4;
$c = 10;

echo "Минимум из a=$a, b=$b, c=$c - b=" . minNum($a, $b, $c);
