<?php
// start or resume session
session_start();
// get the functions
require 'inc/functions.php';
// grab a cart if not yet done
if(!isset($_SESSION['cart']))
{
    $_SESSION['cart'] = [];
}
HTMLhead("Cart");
// display the navbar
displaynav(); // Navigatie tonen
// display the cart
displayShoppingCart();
// display the html header
HTMLfoot();