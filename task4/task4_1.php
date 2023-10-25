<?php

function doubling(int &$x, int &$y)
{
    $x *= 2;
    $y *= 2;
}

$a = 7;
$b = 34;
echo 'Умножая числа a=' . $a . ' и b=' . $b;
doubling($a, $b);
echo ' на 2, получаем a =' . $a . ' и b=' . $b;


