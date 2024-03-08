<?php
session_start();

// Configurazione del database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "aereiDB";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connessione al database fallita: " . $e->getMessage();
    die();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Utilizza una query parametrizzata per evitare SQL injection
    $stmt = $conn->prepare("SELECT * FROM utenti WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['Password'])) {
        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = $username;
        header("Location: landing.php");
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
    <h1>Benvenuto nella FlyCommunity</h1>
    <h2>Login</h2>
    <form method="post" action="">
        <label for="username">Username</label>
        <input type="text" name="username" id="username" required>
        <label for="password">Password</label>
        <input type="password" name="password" id="password" required>
        <input type="submit" name="login" value="Login">
    </form>

    <p>Non hai un account? <a href="registrazione.php">Registrati qui</a>.</p>
</body>
</html>
