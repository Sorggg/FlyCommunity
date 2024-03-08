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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Utilizza una query parametrizzata per evitare SQL injection
    $stmt = $conn->prepare("SELECT * FROM utenti WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    // Verifica se l'utente esiste già
    if ($stmt->rowCount() > 0) {
        echo "Username già in uso. Scegli un altro.";
    } else {
        // Hash della password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Aggiunge l'utente al database con la password hashata
        $stmt = $conn->prepare("INSERT INTO utenti (username, password) VALUES (:username, :password)");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->execute();

        $_SESSION['username'] = $_POST['username'];
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
