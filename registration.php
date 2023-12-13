<?php
?>
<p id="err_msgReg"></p>
<form id="regForm" onsubmit="register(); event.preventDefault();" method="post">
    <label for="FirstName">Имя пользователя:</label>
    <input type="text" name="FirstName" required><br>

    <label for="mail">Адрес электронной почты:</label>
    <input type="email" name="mail" required><br>

    <label for="login">Логин:</label>
    <input type="text" name="login" required><br>

    <label for="passwd">Пароль:</label>
    <input type="password" name="passwd" required><br>

    <label for="rePasswd">Подтверждение пароля:</label>
    <input type="password" name="rePasswd" required><br>

    <input type="submit" value="Зарегистрироваться">
    <input type="reset" value="Очистить">
</form>

<script>
 $(document).ready(function(){
    $('#myForm').submit(function(){
        $.ajax({
        type: "POST",
        url: "reg.php",
        data: "FirstName",
        success: function(html){
            $('.main_content').html(html);
        }
    });
    return false;
    });
 });
</script> 
