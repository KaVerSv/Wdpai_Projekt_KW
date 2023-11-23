<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">  
    <link rel="stylesheet" type="text/css" href="public\css\style.css">
    <title>Luna Login</title>
</head>

<body>

    <div class="login-container">
        <div class="logo">
            <img class="resize" src="public\img\logo_luna_cut.png"/>
        </div>

        <div class="form-container">
            <form class="login" action="login" method="POST">
                <div class "messages">
                    <?php if (isset($messages)) {
                        foreach ($messages as $message) {
                            echo $message;
                        }
                    }
                    ?>
                </div>
                <p class="title">Log in</p>

                <label for="email">Login/email:</label>
                <input type="text" id="email" name="email" required>

                <label for="password">Hasło:</label>
                <input type="password" id="password" name="password" required>


                <div class="remember-me-container">
                    <input type="checkbox" id="remember" name="remember">
                    <label for="remember">Zapamiętaj mnie</label>
                </div>

                <button type="submit">Zaloguj się</button>

                <button type="submit">continue with Google</button>
                <button type="submit">continue with Facebook</button>
                <button type="submit">continue with Apple</button>


                <div class="links">
                <a href="Views\register.php">Utwórz konto</a>
                <a href="Views\forgot_password.php">Zapomniałem hasła</a>
                </div>
            </form>
        </div>

    </div>
</body>
</html>