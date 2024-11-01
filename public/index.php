<?php
session_start();

if (!isset($_SESSION['user_id']) && isset($_COOKIE['username'])) {
    $username = $_COOKIE['username'];
}

$bd_color = isset($_COOKIE['bd_color']) ? $_COOKIE['bd_color'] : 'white';
$font_color = isset($_COOKIE['font_color']) ? $_COOKIE['font_color'] : 'black';
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Главная страница</title>
    <style>
        body {
            background-color: <?php echo $bd_color; ?>;
            color: <?php echo $font_color; ?>;
        }
    </style>
</head>
<body>
    <h1>Добро пожаловать!</h1>
    <a href="login.php">Войти</a>
    <a href="reg.php">Регистрация</a>
    <a href="exitlog.php">Выйти</a>
    <a href="settings.php">Настройки</a>

</body>
</html>