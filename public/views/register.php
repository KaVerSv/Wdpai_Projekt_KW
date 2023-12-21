<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="public\css\style.css">
    <title>Luna register</title>
</head>

<body>

    <div class="login-container">
        <div class="logo">
            <img class="resize" src="public\img\logo_luna_cut.png"/>
        </div>
        <div class="form-container">
            <form class="login" action="register.php" method="post">
                <p class="title">Register</p>

                <label for="login">Login:</label>
                <input type="text" id="login" name="login" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>

                <label for="password">Passoword:</label>
                <input type="password" id="password" name="password" required>

                <label for="repeat password">Repeat password:</label>
                <input type="passwordCheck" id="passwordCheck" name="passwordCheck" required>

                <label for="dates">Date of birth:</label>

                <div class="dates">
                    <label for="day">day:</label>
                    <input type="day" id="day" name="day" required>

                    <label for="month">month:</label>
                    <input type="month" id="month" name="month" required>

                    <label for="year">year:</label>
                    <input type="year" id="year" name="year" required>
                </div>

                <div class="center-this-item" >
                    <button type="submit">Register</button>
                </div>


                <div class="links">
                    <a href="login">I Already have an account</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>