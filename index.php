<?php
session_start(); // Start de sessie

include 'inc/functions.php'; // Zorg dat je dit bestand insluit

HTMLhead("Game Shop");
displaynav();
displayCategory();
HTMLfoot();
?>