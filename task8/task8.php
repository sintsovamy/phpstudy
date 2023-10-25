<?php

$arrEven = [];
$i = 346;

while($i < 357) {
    $arrEven[] = $i;
    $i += 2;
}

foreach($arrEven as $value) {
    echo $value;
    echo '<br>';
}
