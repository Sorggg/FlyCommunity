<?php
session_start();


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

// Riempi l'array aerei con i dati degli aerei
$stmt = $conn->query("SELECT * FROM aerei");
$aerei = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">

    <title>Elenco Aerei</title>
    <script>
        function cerca(testo) {
            var righe = document.getElementsByTagName("tr");
            for (var i = 1; i < righe.length; i++) {
                var t = righe[i].getElementsByTagName("td")[1].innerText;
                if (t.includes(testo)) {
                    righe[i].style.display = "";
                } else {
                    righe[i].style.display = "none";
                }
            }
        }
    </script>
</head>

<body>
    <header>
        <nav>
            <a href="landing.php">Elenco Aerei</a>
            <a href="aggiungi_aereo.php">Aggiungi Aereo</a>
        </nav>
    </header>

    <h1>FlyCommunity</h1>

    <!-- Barra di Ricerca -->
    <form method="post" action="landing.php">
        <label for="search">Ricerca:</label>
        <input type="text" name="search" id="search" onkeyup="cerca(this.value)">
    </form>

    <h2>Aerei</h2>
    <table border="1">
        <tr>
            <th>Id</th>
            <th>Marca</th>
            <th>Modello</th>
            <th>Indirizzo</th>
            <th>Utente</th>
            <th>Azioni</th>
            
        </tr>
        <?php
        // Verifica se ci sono dati degli aerei disponibili
        if (!empty($aerei)) {
            foreach ($aerei as $aereo) {
                echo "<tr>";
                echo "<td>{$aereo['Id']}</td>";
                echo "<td>{$aereo['Marca']}</td>";
                echo "<td>{$aereo['Modello']}</td>";
                echo "<td><a href='{$aereo['Indirizzo']}' target='_blank'>{$aereo['Indirizzo']}</a></td>";
                echo "<td>{$aereo['Utente']}</td>";

                // Verifica se l'utente loggato corrisponde all'utente dell'aereo
                if (isset($_SESSION['username']) && $_SESSION['username'] == $aereo['Utente']) {
                    echo "<td>";
                    echo "<form method='post' action='modifica_elimina_aereo.php'>";
                    echo "<input type='hidden' name='id' value='{$aereo['Id']}'>";
                    echo "<input type='submit' name='modifica_elimina' value='Modifica/Elimina'>";
                    echo "</form>";
                    echo "</td>";
                
                    // Salva l'indice dell'aereo nella sessione
                    $_SESSION['indiceAereoDaModificare'] = $aereo['Id'];
                } else {
                    echo "<td>Non autorizzato</td>";
                }

                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>Nessun dato degli aerei disponibile</td></tr>";
        }
        ?>
    </table>
</body>

</html>
