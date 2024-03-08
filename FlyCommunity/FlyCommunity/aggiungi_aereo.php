<?php
session_start();
// Configurazione del database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "aereiDB";

// Connessione al database
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica la connessione
if ($conn->connect_error) {
    die("Connessione al database fallita: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    // Leggi l'username dell'utente dalla sessione
    $username = $_SESSION['username']; // Assicurati di avere una chiave 'username' nella sessione

    // Leggi i dati inviati dal form
    $marca = $_POST['marca'];
    $modello = $_POST['modello'];
    $indirizzo = $_POST['indirizzo'];

    // Prepara e esegui l'inserimento nel database
    $stmt = $conn->prepare("INSERT INTO aerei (Marca, Modello, Indirizzo, Utente) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $marca, $modello, $indirizzo, $username);

    // Esegui la query
    if ($stmt->execute()) {
        echo "Nuovo aereo aggiunto con successo.";
    } else {
        echo "Errore durante l'aggiunta del nuovo aereo: " . $stmt->error;
    }

    // Chiudi lo statement
    $stmt->close();
}

// Chiudi la connessione al database
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
    <title>Aggiungi Aereo</title>
</head>
<header>
        <nav>
            <a href="landing.php">Elenco Aerei</a>
            <a href="aggiungi_aereo.php">Aggiungi Aereo</a>
        </nav>
    </header>
<body>
    
    <h1>FlyCommunity</h1>
    <h2>Aggiungi Aereo</h2>
    <form method="post" action="">
        
        <label for="marca">Marca</label>
        <input type="text" name="marca" id="marca" required>
        <br><br>

        <label for="modello">Modello</label>
        <input type="text" name="modello" id="modello" required>
        <br><br>

        <label for="indirizzo">Indirizzo</label>
        <input type="text" name="indirizzo" id="indirizzo" required>

        <input type="submit" name="submit" value="Aggiungi Aereo">
    </form>
</body>

</html>
