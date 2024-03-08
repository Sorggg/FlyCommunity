<?php
session_start();

if (!isset($_SESSION['orderData'])) {
    header("Location: ordinazione.php");
    exit();
}

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

// Verifica se l'ID dell'aereo è stato passato
if (isset($_POST['modifica_elimina']) && isset($_POST['id'])) {
    $aereoId = $_POST['id'];

    // Query per recuperare i dati dell'aereo dal database
    $stmt = $conn->prepare("SELECT * FROM aerei WHERE Id = :aereoId");
    $stmt->bindParam(':aereoId', $aereoId);
    $stmt->execute();
    $aereo = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($aereo) {
        // Visualizza i dettagli dell'aereo e opzioni per modifica/eliminazione
        echo "<h1>Dettagli Aereo</h1>";
        echo "<p>ID: {$aereo['Id']}</p>";
        echo "<p>Marca: {$aereo['Marca']}</p>";
        echo "<p>Modello: {$aereo['Modello']}</p>";
        echo "<p>Indirizzo: {$aereo['Indirizzo']}</p>";
        echo "<p>Utente: {$aereo['Utente']}</p>";

        // Form di modifica
        echo "<h2>Modifica Aereo</h2>";
        echo "<form method='post' action='modifica_elimina_aereo.php'>";
        echo "<input type='hidden' name='id' value='{$aereo['Id']}'>";
        echo "<label for='marca'>Nuova Marca:</label>";
        echo "<input type='text' name='marca' value='{$aereo['Marca']}'>";
        echo "<label for='modello'>Nuovo Modello:</label>";
        echo "<input type='text' name='modello' value='{$aereo['Modello']}'>";
        echo "<label for='indirizzo'>Nuovo Indirizzo:</label>";
        echo "<input type='text' name='indirizzo' value='{$aereo['Indirizzo']}'>";
        echo "<input type='submit' name='salva_modifiche' value='Salva Modifiche'>";
        echo "</form>";

        // Pulsanti per modifica/eliminazione
        echo "<form method='post' action='modifica_elimina_aereo.php'>";
        echo "<input type='hidden' name='id' value='{$aereo['Id']}'>";
        echo "<input type='submit' name='elimina' value='Elimina'>";
        echo "</form>";
    } else {
        echo "Aereo non trovato.";
    }
}

// Verifica se è stato inviato il form di modifica
if (isset($_POST['salva_modifiche'])) {
    // Aggiorna i valori dell'aereo nel database con i nuovi dati
    $aereoId = $_POST['id'];
    $nuovaMarca = $_POST['marca'];
    $nuovoModello = $_POST['modello'];
    $nuovoIndirizzo = $_POST['indirizzo'];

    $stmtUpdate = $conn->prepare("UPDATE aerei SET Marca = :marca, Modello = :modello, Indirizzo = :indirizzo WHERE Id = :aereoId");
    $stmtUpdate->bindParam(':marca', $nuovaMarca);
    $stmtUpdate->bindParam(':modello', $nuovoModello);
    $stmtUpdate->bindParam(':indirizzo', $nuovoIndirizzo);
    $stmtUpdate->bindParam(':aereoId', $aereoId);
    $stmtUpdate->execute();

    // Ridireziona alla pagina di destinazione dopo la modifica
    header("Location: landing.php");
    exit();
}

// Verifica se è stato cliccato il pulsante di eliminazione
if (isset($_POST['elimina'])) {
    // Elimina l'aereo dal database
    $aereoId = $_POST['id'];
    $stmtDelete = $conn->prepare("DELETE FROM aerei WHERE Id = :aereoId");
    $stmtDelete->bindParam(':aereoId', $aereoId);
    $stmtDelete->execute();

    // Ridireziona alla pagina di destinazione dopo l'eliminazione
    header("Location: landing.php");
    exit();
} else {
    echo "ID dell'aereo non specificato.";
}
?>
