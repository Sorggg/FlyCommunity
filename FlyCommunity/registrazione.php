<?php
$usersFile = 'utenti.json';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $users = json_decode(file_get_contents($usersFile), true);

    // Verifica se l'utente esiste già
    if (isset($users[$username])) {
        echo "Username già in uso. Scegli un altro.";
    } else {
        // Aggiunge l'utente al file JSON
        $users[$username] = $password;
        file_put_contents($usersFile, json_encode($users));
        $_SESSION['logged_in'] = true;
        header("Location: landing.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
    <title>Registrazione</title>
</head>
<body>
    <h1>Benvenuto nella FlyCommunity</h1>
    <h2>Registrazione</h2>
    <form method="post" action="">
        <label for="username">Username</label>
        <input type="text" name="username" id="username" required>
        <label for="password">Password</label>
        <input type="password" name="password" id="password" required>
        <input type="submit" name="register" value="Registra">
    </form>
</body>
</html>
