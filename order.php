<?php

require 'inc/functions.php';
session_start();

// Controleer of de gebruiker is ingelogd
if (!isset($_SESSION['userid'])) {
    // Als de gebruiker niet is ingelogd, redirect naar de loginpagina
    header("Location: login.php");
    exit;
}

// Haal de ingelogde userId op uit de sessie
$userId = $_SESSION['userid'];

if (isset($_POST['emptyCart'])) {
    // Leeg de winkelwagen
    $_SESSION['cart'] = [];
    header("location: checkout.php");
    exit;
}

if (isset($_POST['placeOrder'])) {
    $conn = db_connect();

    // Begin een transactie
    $conn->begin_transaction();

    try {
        // Voeg een nieuwe order toe
        $sql = "INSERT INTO orders (orderDate, userId) VALUES (NOW(), ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $orderId = $conn->insert_id; // Haal het laatst ingevoegde orderId op

        // Voeg de producten toe aan de order
        $values = [];
        foreach ($_SESSION['cart'] as $productId => $quantity) {
            $productId = (int) $productId;
            $quantity = (int) $quantity;
            $values[] = "($orderId, $productId, $quantity)";
        }

        $sql = "INSERT INTO orderproducts (orderid, productid, productQuantity) VALUES " . implode(",", $values);
        $conn->query($sql);

        // Commit de transactie
        $conn->commit();

        // Leeg de winkelwagen
        unset($_SESSION['cart']);

        // Sla een succesbericht op in de sessie
        $_SESSION['message'] = "Your order has been placed successfully!<br />";
        $_SESSION['message'] .= "Check your orders <a href=\"orderHistory.php\">here</a>";

        // Redirect naar de productenpagina
        header("Location: products.php");
        exit;
    } catch (Exception $e) {
        // Rollback de transactie bij een fout
        $conn->rollback();
        die("Error processing your order: " . $e->getMessage());
    }
}
?>
