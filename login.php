<?php
require 'dbConnect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $pass = $_POST['password'];
    if (strlen($email) > 30 || strlen($pass) > 30) {
        echo "Превышена максимальная длина данных (30 символов)";
        exit();
    }
    
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Некорректный формат e-mail";
        exit();
    }
    $sql = "SELECT * FROM users WHERE mail='$email' AND passwd='$pass'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        echo "ID: " . $user["id"] . "<br>";
        echo "Имя: " . $user["FirstName"] . "<br>";
        echo "E-mail: " . $user["mail"] . "<br>";
        echo "Логин: " . $user["login"] . "<br>";
        echo "Авторизация успешна";
        } else {
            echo "Неверный email или пароль";
        }
}

?>