<?php
if (empty($_GET)) {
    return 'Ничего не передано!';
}

if (empty($_GET['operation'])) {
    return 'Не передана операция';
}

if (empty($_GET['x1']) || empty($_GET['x2'])) {
	if($_GET['x1'] !== '0' && $_GET['x2'] !== '0') {
            return 'Не переданы аргументы';
	}
}

$x1 = $_GET['x1'];
$x2 = $_GET['x2'];

$expression = $x1 . ' ' . $_GET['operation'] . ' ' . $x2 . ' = ';

if(is_numeric($x1) && is_numeric($x2)){
    if (($_GET['x2'] == '0') && ($_GET['operation'] == '/')) {
        return 'Операция не поддерживается';
    } else {
	    switch ($_GET['operation']) {
        case '+':
            $result = $x1 + $x2;
            break;
        case '-':
            $result = $x1 - $x2;
	    break;
        case '*':
            $result = $x1 * $x2;
            break;
        case '/': 
            $result = $x1 / $x2;
            break;
        default:
            return 'Операция не поддерживается';
	    }
    }
} else {
   return 'Введено не число';
}

return $expression . $result;
