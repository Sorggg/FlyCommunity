<?php
session_start();

if (!isset($_SESSION['orderData'])) {
    header("Location: ordinazione.php");
    exit();
}
$aereiFile = 'aerei.json';

// Carica i dati degli aerei dal file JSON
$aerei = json_decode(file_get_contents($aereiFile), true);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">

    <title>Scontrino</title>
</head>
    <header>
        <nav>
            <a href="landing.php">Elenco Aerei</a>
            <a href="aggiungi_aereo.php">Aggiungi Aereo</a>
        </nav>
    </header>
<body>
    
    <h1>FlyCommunity</h1>
    <h2>Aerei</h2>
    <table border="1">
        <tr>
            <th>Id</th>
            <th>Marca</th>
            <th>Modello</th>
            <th>Indirizzo</th>
            <th>Utente</th>
        </tr>
        <?php
        // Verifica se ci sono dati degli aerei disponibili
        if (!empty($aerei)) {
            foreach ($aerei as $aereo) {
                echo "<tr>";
                echo "<td>{$aereo['Id']}</td>";
                echo "<td>{$aereo['Marca']}</td>";
                echo "<td>{$aereo['Modello']}</td>";
                echo "<td>{$aereo['Indirizzo']}</td>";
                echo "<td>{$aereo['Username']}</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>Nessun dato degli aerei disponibile</td></tr>";
        }
        ?>
    </table>

    <form method="post">
    </form>
</body>

</html>
