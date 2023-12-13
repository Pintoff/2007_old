<?php

require 'dbConnect.php';


function Salt (){
    $i;
    $salt ='';
    for ($i = 1; $i <= 2; $i++) {
    $rnd = (int)(rand(75) + 48);
    if (($rnd > 57) && ($rnd < 65)) {
    $rnd = 65;
    } elseif (($rnd > 90) && ($rnd < 97)) {
    $rnd = 97;
    }
    $salt .= chr($rnd);
    }
    return $salt;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
 

    $firstName = $_POST["FirstName"];
    $mail = $_POST["mail"];
    $login = $_POST["login"];
    $passwd = $_POST["passwd"];
    $rePasswd = $_POST["rePasswd"];


    if ($passwd !== $rePasswd) {
        echo json_encode(["error" => "Пароль и подтверждение пароля не совпадают"]);
        exit();
    }


    if (strlen($firstName) > 30 || strlen($mail) > 30 || strlen($login) > 30 || strlen($passwd) > 30) {
        echo json_encode(["error" => "Превышена максимальная длина данных (30 символов)"]);
        exit();
    }


    if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(["error" => "Некорректный формат e-mail"]);
        exit();
    }

    $salt = Salt();
    $cryptPasswd = crypt($passwd, $salt);

    $checkQuery = "SELECT * FROM users WHERE mail='$mail' OR login='$login'";
    $result = $conn->query($checkQuery);

    if ($result->num_rows > 0) {
        echo json_encode(["error" => "Этот адрес электронной почты или логин уже занят"]);
        $conn->close();
        exit();
    }


    $insertQuery = "INSERT INTO users (FirstName, mail, login, passwd) VALUES ('$firstName', '$mail', '$login', '$cryptPasswd')";
    if ($conn->query($insertQuery) === TRUE) {
        echo json_encode(["info" => "Вы успешно зарегистрировались, авторизуйтесь с использованием email и пароля."]);
    } else {
        echo json_encode(["error" => "Ошибка при регистрации."]);
    }

    $conn->close();
} else {
    echo json_encode(["error" => "Неверный метод запроса"]);
}
?>