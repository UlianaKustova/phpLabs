<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// $connect = mysqli_connect('MySQL-8.0', 'root', '', 'log_psw');
//     if ($connect == false){
//         print("Ошибка: Невозможно подключиться к MySQL " . mysqli_connect_error());
//     }
$conn = new mysqli('MySQL-8.0', 'root', '', 'log_psw');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $bd_color = $_POST['bd_color'];
    $font_color = $_POST['font_color'];
    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("UPDATE users SET bd_color = ?, font_color = ? WHERE id = ?");
    $stmt->bind_param("ssi", $bd_color, $font_color, $user_id);
    $stmt->execute();

    setcookie("bd_color", $bd_color, time() + (86400 * 30), "/");
    setcookie("font_color", $font_color, time() + (86400 * 30), "/");
    echo "Настройки обновлены!";
}
$stmt = $conn->prepare("SELECT bd_color, font_color FROM users WHERE id = ?");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$stmt->bind_result($bd_color, $font_color);
$stmt->fetch();
$stmt->close();
$conn->close();
?>

<form method="POST">
    Фоновый цвет: <input type="text" name="bd_color" value="<?php echo $bd_color; ?>"><br>
    Цвет шрифта: <input type="text" name="font_color" value="<?php echo $font_color; ?>"><br>
    <button type="submit">Сохранить настройки</button>
    <a href="index.php">  На главную</a>
</form>