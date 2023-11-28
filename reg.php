<?php

require 'dbConnect.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $firstName = $_POST["FirstName"];
    $mail = $_POST["mail"];
    $login = $_POST["login"];
    $passwd = $_POST["passwd"];
    $rePasswd = $_POST["rePasswd"];


    if ($passwd !== $rePasswd) {
        echo "Пароль и подтверждение пароля не совпадают";
        exit();
    }


    if (strlen($firstName) > 30 || strlen($mail) > 30 || strlen($login) > 30 || strlen($passwd) > 30) {
        echo "Превышена максимальная длина данных (30 символов)";
        exit();
    }


    if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        echo "Некорректный формат e-mail";
        exit();
    }



    $checkQuery = "SELECT * FROM users WHERE mail='$mail' OR login='$login'";
    $result = $conn->query($checkQuery);

    if ($result->num_rows > 0) {
        echo "Этот адрес электронной почты или логин уже занят";
        $conn->close();
        exit();
    }


    $insertQuery = "INSERT INTO users (FirstName, mail, login, passwd) VALUES ('$firstName', '$mail', '$login', '$passwd')";
    if ($conn->query($insertQuery) === TRUE) {
        echo "Регистрация успешна";
    } else {
        echo "Ошибка при регистрации: " . $conn->error;
    }

    $conn->close();
} else {
    echo "Неверный метод запроса";
}
?>