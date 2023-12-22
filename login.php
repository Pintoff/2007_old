<?php
require 'dbConnect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $pass = $_POST['password'];

    if (strlen($email) > 30 || strlen($pass) > 30) {
        echo json_encode(["error" => "Превышена максимальная длина данных (30 символов)"]);
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(["error" => "Некорректный формат e-mail"]);
        exit();
    }

    $sqlFind = "SELECT * FROM users WHERE mail='$email'";
    $scanResult = $conn->query($sqlFind);

    if ($scanResult->num_rows > 0) {
        $user = $scanResult->fetch_assoc();
    } else {
        echo json_encode(["error" => "Пользователя с таким email не существует"]);
        exit();
    }

    $cryptpass = crypt($pass, substr($user["passwd"], 0, 2));

    $sql = "SELECT * FROM users WHERE mail='$email' AND passwd='$cryptpass'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if ($email == 'admin@admin.ru') {
            $adminQuery = "SELECT FirstName, mail, login, id FROM users";
            $adminResult = $conn->query($adminQuery);
            
            if ($adminResult->num_rows > 0) {
                $adminData = [];
                while ($adminRow = $adminResult->fetch_assoc()) {
                $adminData[] = $adminRow;
                }
                
                echo json_encode([
                "adminData" => $adminData,
                "message" => "Admin information retrieved successfully"
                ]);
                
                exit();
            }
            
            echo json_encode([
            "firstName" => $user["FirstName"],
            "email" => $user["mail"],
            "login" => $user["login"],
            "message" => "Авторизация успешна"
            ]);
            } else {
            echo json_encode(["error" => "Неверный email или пароль"]);
            exit();
            }
    }
}
?>