<?php

function factorial(int $n)
{
    if ($n == 1 || $n == 0) {
        return 1;
    } else {
	return $n * factorial($n - 1);
    }
}

$a = 5;
echo '5!=' . factorial($a);
