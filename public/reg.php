<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login_user = $_POST['login_user'];
    $password_user = password_hash($_POST['password_user'], PASSWORD_DEFAULT);
    $bd_color = $_POST['bd_color'];
    $font_color = $_POST['font_color'];
    // $connect = mysqli_connect('MySQL-8.0', 'root', '', 'log_psw');
    // if ($connect == false){
    //     print("Ошибка: Невозможно подключиться к MySQL " . mysqli_connect_error());
    // }

    $conn = new mysqli('MySQL-8.0', 'root', '', 'log_psw');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
     $stmt = $conn->prepare("INSERT INTO users ( login_user, password_user, bd_color, font_color) VALUES (?, ?, ?, ?)");
     $stmt->bind_param('ssss', $login_user, $password_user, $bd_color, $font_color);
    //$stmt = "INSERT INTO users (id, login_user, password_user, bd_color, font_color) VALUES (NULL, $login_user, $password_user, $bd_color, $font_color)";

    if ($stmt->execute()) {
    //if ($conn->query($stmt)) {
        echo "Регистрация прошла успешно!";
    } else {
        echo "Ошибка: " . $stmt->error;
    }
    $stmt->close();
    $conn->close();
}
?>

<form method="POST">
    Имя пользователя: <input type="text" name="login_user" required><br>
    Пароль: <input type="password" name="password_user" required><br>
    Фоновый цвет: <input type="text" name="bd_color"><br>
    Цвет шрифта: <input type="text" name="font_color"><br>
    <button type="submit">Зарегистрироваться</button>
    <a href="index.php">   На главную</a>
</form>