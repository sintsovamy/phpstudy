<?php
var_dump($_FILES);
require __DIR__ . '/auth.php';
$login = getUserLogin();

$allowedExtensions = ['jpg', 'png', 'gif'];
if (!empty($_FILES['attachment'])) {
    $file = $_FILES['attachment'];

    $srcFileName = $file['name'];
    $newFilePath = __DIR__ . '/uploads/' . $srcFileName;

    list($width, $height) = getimagesize($file['tmp_name']);
    $extension = pathinfo($srcFileName, PATHINFO_EXTENSION);
    if ($width > 1280 || $height > 720) {
        $error = 'Неподходящая ширина или высота файла';
    } elseif ($file['size'] > 8192000) {
        $error = 'Превышен максимальный размер файла';
    } elseif (!in_array($extension, $allowedExtensions)) {
        $error = 'Загрузка файлов с таким расширением запрещена';
    } elseif ($file['error'] !== UPLOAD_ERR_OK) {
        $error = 'Ошибка при загрузке файла';
    } elseif (file_exists($newFilePath)) {
        $error = 'Файл с таким именем уже существует';
    } elseif (!move_uploaded_file($file['tmp_name'], $newFilePath)) {
        $error = 'Ошибка при загрузке файла';
    } else {
        $result = __DIR__ . '/uploads/' . $srcFileName;
    }
}
?>
<html>
<head>
    <title>Загрузка файла</title>
</head>
<body>
<?php if ($login == null): ?>
    <a href="./login.php">Авторизуйтесь</a>
<?php else: ?>
    Добро пожаловать, <?= $login ?> |
    <a href="./logout.php">Выйти</a>
    <br>
    <?php if (!empty($error)): ?>
        <?= $error ?>
    <?php elseif (!empty($result)): ?>
        <?= $result ?>
    <?php endif; ?>
<form action="./upload.php" method="post" enctype="multipart/form-data">
    <input type="file" name="attachment">
    <input type="submit">
</form>
<?php endif ?>
</body>
</html>
