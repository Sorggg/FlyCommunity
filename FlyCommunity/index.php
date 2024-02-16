<?php
$usersFile = 'utenti.json';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $users = json_decode(file_get_contents($usersFile), true);

    if (isset($users[$username]) && $users[$username] === $password) {
        $_SESSION['logged_in'] = true;
        header("Location: ordinazione.php");
        exit();
    } else {
        echo "Username o password sbagliati.";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
    <title>Login</title>
</head>
<body>
    <h1>Ciò che non strozza ingrassa!</h1>
    <h2>Login</h2>
    <form method="post" action="">
        <label for="username">Username</label>
        <input type="text" name="username" id="username" required>
        <label for="password">Password</label>
        <input type="password" name="password" id="password" required>
        <input type="submit" name="login" value="Login">
    </form>
</body>
</html>
