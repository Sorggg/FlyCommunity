<?php
session_start();

if (!isset($_SESSION['orderData'])) {
    header("Location: ordinazione.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $completedOrder = $_POST['completed_order'];
    unset($_SESSION['orderData'][$completedOrder]);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">

    <title>Scontrino</title>
</head>

<body>
    <h1>Ciò che non strozza ingrassa!</h1>
    <h2>Ordini clienti</h2>
    <table border="1">
        <tr>
            <th>N</th>
            <th>Nome Cliente</th>
            <th>Salse</th>
            <th>Ingredienti</th>
            <th>prezzo</th>
        </tr>
        <?php
        foreach ($_SESSION['orderData'] as $order) {
            echo "<tr>";
            echo "<td>{$order['numOrdine']}</td>";
            echo "<td>{$order['nomeCliente']}</td>";
            echo "<td>" . implode(', ', $order['salse']) . "</td>";
            echo "<td>{$order['ingredienti']}</td>";
            echo "<td>{$order['costo']}</td>";
            echo "</tr>";
        }
        ?>
    </table>

    <form method="post">
        <label for="completed_order">Seleziona l'ordine completato:</label>
        <select name="completed_order" id="completed_order">
            <?php
            foreach ($_SESSION['orderData'] as $key => $order) {
                echo "<option value='$key'>{$order['nomeCliente']}</option>\n";
            }
            ?>
        </select>
        <input type="submit" value="Concludi Ordine">
    </form>
</body>

</html>
