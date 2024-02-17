<?php
session_start();



if (!isset($_SESSION['orderData'])) {
    $_SESSION['orderData'] = array();
}
if (!isset($_SESSION['orderData'])) {
    $_SESSION['orderData'] = array();
}
if (!isset($_SESSION['numOrdine'])) {
    $_SESSION['numOrdine'] = 0;
}
if (!isset($costro)) {
    $costo = 5;
}
if (!isset($ingredientiAggiunti)) {
    $ingredientiAggiunti = "";
}

$salse = array("ketchup", "maionese", "senape");
$ingredienti = array("-","cipolla", "peperoni", "scamorza","patate","salamino" );

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if($_POST['ingrediente1']!="-"){
        $costo += 2;
        $ingredientiAggiunti = $ingredientiAggiunti . $_POST['ingrediente1'] . " ";
    }
    if($_POST['ingrediente2']!="-"){
        $costo += 2;
        $ingredientiAggiunti = $ingredientiAggiunti . $_POST['ingrediente2'] . " ";
    }
    if($_POST['ingrediente3']!="-"){
        $costo += 2;
        $ingredientiAggiunti = $ingredientiAggiunti . $_POST['ingrediente3'] . " ";
    }
    $_SESSION['numOrdine'] += 1;
    $orderData = array(
        
        'numOrdine' => $_SESSION['numOrdine'],
        'nomeCliente' => $_POST['nomeCliente'],
        'costo' => $costo,
        'ingredienti' =>  $ingredientiAggiunti,
        'tipo' => $_POST['tipoPanino'],
        'salse' => isset($_POST['salse']) ? $_POST['salse'] : array()
    );

    $_SESSION['orderData'][] = $orderData;
    $ordersFile = 'scontrino.json';
    file_put_contents($ordersFile, json_encode($_SESSION['orderData'], JSON_PRETTY_PRINT));
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
    <title>Ordinazione</title>
</head>

<body>
    <h1>Ciò che non strozza ingrassa!</h1>
    <h2>Effettua ordine</h2>
    <form method="post">
    <label for="nomeCliente">Nome Cliente</label>
        <input type="text" name="nomeCliente" id="nomeCliente" required><br><br>
        <label for="tipoPanino">Tipo panino</label> <br>
        <input type="radio" id="hamburger" name="tipoPanino" value="hamburger" required>
        <label for="">hamburger</label>
        <input type="radio" id="salsiccia" name="tipoPanino" value="salsiccia" required>
        <label for="">salsiccia</label>
        <br>
        <br>
        <?php
        foreach ($salse as $salsa) {
            echo "<input type='checkbox' id='$salsa' name='salse[]' value='$salsa'>";
            echo "<label for='$salsa'> $salsa</label>";
        }
        echo "<br><br>" ;
        echo "<select name='ingrediente1' id='ingrediente1'>"; 
        foreach ($ingredienti as $ingrediente) {
            echo "<option value='$ingrediente'>$ingrediente</option>";
        }
        echo "</select>";
        echo "<select name='ingrediente2' id='ingrediente2'>"; 
        foreach ($ingredienti as $ingrediente) {
            echo "<option value='$ingrediente'>$ingrediente</option>";
        }
        echo "</select>";
        echo "<select name='ingrediente3' id='ingrediente3'>"; 
        foreach ($ingredienti as $ingrediente) {
            echo "<option value='$ingrediente'>$ingrediente</option>";
        }
        echo "</select>";
        ?>
        <br>
        <br>
        <input type="submit" name="submit" value="NUOVO ORDINE">
        <button onclick="window.open('scontrino.php', '_blank')">SCONTRINO</button>
    </form>
   
</body>

</html>

