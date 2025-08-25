<?php
include 'inc/functions.php'; // Zorg dat je dit bestand insluit
session_start();

// Zorg ervoor dat de winkelwagen bestaat
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Controleer of het formulier is ingediend
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $productID = $_POST['productid'];
    $quantity = (int) $_POST['productQuantity']; // Zorg ervoor dat het een integer is

    // Als het product al in de winkelwagen zit, tel dan de hoeveelheid op
    if (isset($_SESSION['cart'][$productID])) {
        $_SESSION['cart'][$productID] += $quantity;
    } else {
        $_SESSION['cart'][$productID] = $quantity;
    }
}

// Stuur gebruiker naar checkout
header("Location: checkout.php");
exit;
?>
