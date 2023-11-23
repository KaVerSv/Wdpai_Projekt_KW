<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Public\css\style.css">
    <title>Reset Password</title>
</head>
<body>

    <div class="reset-container">
        <form action="reset_password.php" method="post">
            <label for="email">Adres e-mail:</label>
            <input type="email" id="email" name="email" required>

            <button type="submit">Zresetuj hasło</button>
        </form>
    </div>

</body>
</html>