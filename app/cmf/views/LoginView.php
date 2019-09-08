<?php 

function LoginView() {
    if ($_SERVER["REQUEST_METHOD"]=="POST") {
        $result = User::authorize($_POST["login"], $_POST["password"]);
        if ($result==true) {
            header('Refresh: 0; url=/'); 
            return;
        }
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Fluffy login page</title>
        <base href="<?='//'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/'?>">
        <meta name="description" content="">
        <meta name="keywords" content="">
        <link rel="stylesheet" type="text/css" href="css/style.css">
    </head>
    <body>
        <div id="login">
            <div id="logo-block">
                <img src="img/fluff2.svg" height="60" width="60" id="logo-img">
                <div id="logo-title">Fluffy login</div>
            </div>
            <form action="/" method="post">
                <div class="horisontal-label-input login-input">
                    <label>Логин:</label>
                    <input type="text" required="required" placeholder="Логин" name="login" value="<?php echo isset($_POST["login"])?$_POST["login"]:""?>">
                </div>
                <div class="horisontal-label-input login-input">
                    <label>Пароль:</label>
                    <input type="password" required="required" placeholder="Пароль" name="password" value="">
                </div>
                <?php if (isset($result) && $result==false) { ?>
                <span class="error-message">Неверный логин или пароль.</span>
                <?php }?>
                <input type="submit" value="Войти">
            </form>
        </div>
    </body>
</html>
<?php } ?>
