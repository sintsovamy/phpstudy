<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="/../www/styles.css">
</head>
<body>

<table class="layout">
    <tr>
        <td colspan="2" class="header">
            Мой блог
        </td>
    </tr>
    <tr>
        <td colspan="2" style="text-align: right">
	    <?php if (!empty($user)) {
               echo 'Привет, ' . $user->getNickname() . ' | ' . '<a href="/users/logout">Выйти</a>'; 
		} else {
			echo '<a href="/users/login">Войти</a>' . ' | ' . '<a href="/users/register">Зарегистрироваться</a>';}?>
        </td>
    </tr>
    <tr>
        <td>
