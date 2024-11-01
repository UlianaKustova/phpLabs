<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // $username = $_POST['username'];
    // $password = $_POST['password'];
    $login_user = $_POST['login_user'];
    $password_user = $_POST['password_user'];

    // $connect = mysqli_connect('MySQL-8.0', 'root', '', 'log_psw');
    // if ($connect == false){
    //     print("Ошибка: Невозможно подключиться к MySQL " . mysqli_connect_error());
    // }
    $conn = new mysqli('MySQL-8.0', 'root', '', 'log_psw');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

//$stmt = "SELECT id, password_user, bd_color, font_color FROM users WHERE username = ?";
    $stmt = $conn->prepare("SELECT id, password_user, bd_color, font_color FROM users WHERE login_user = ?");
    $stmt->bind_param("s", $login_user);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $hashed_password, $bd_color, $font_color);
    if ($stmt->num_rows > 0) {
        $stmt->fetch();
        if (password_verify($password_user, $hashed_password)) {
            $_SESSION['user_id'] = $id;
            setcookie("bd_color", $bd_color, time() + (86400 * 30), "/");
            setcookie("font_color", $font_color, time() + (86400 * 30), "/");
            echo "Добро пожаловать, " . $login_user;
        } else {
            echo "Неверный пароль.";
        }
    } else {
        echo "Пользователь не найден.";
    }
    $stmt->close();
    $conn->close();
}
?>

<form method="POST">
    Имя пользователя: <input type="text" name="login_user" required><br>
    Пароль: <input type="password" name="password_user" required><br>
    <button type="submit">Войти</button>
    <a href="index.php">  На главную</a>
</form>

