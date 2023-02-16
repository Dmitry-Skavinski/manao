<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="/static/css/register.css">
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Auth</title>
</head>
<body>
    <main>
        <form id="register">
            <h2>Register</h2>
            <label>
                login
                <input name="login">
            </label>
            <label>
                password
                <input name="password" type="password">
            </label>
            <label>
                confirm password
                <input name="confirm_password" type="password">
            </label>
            <label>
                email
                <input name="email">
            </label>
            <label>
                name
                <input name="name">
            </label>
            <input type="submit" value="register">
        </form>
        <form id="login">
            <h2>Login</h2>
            <label>
                login
                <input name="login">
            </label>
            <label>
                password
                <input name="password" type="password">
            </label>
            <input type="submit" value="login">
        </form>
    </main>
    <script src="/static/js/auth.js"></script>
</body>
</html>