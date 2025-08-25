<?php
include 'inc/functions.php'; // Functies insluiten

HTMLhead("Contact"); // HTML-head genereren
displaynav(); // Navigatie tonen
?>

<main>
    <p>Neem contact met ons</p>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $message = $_POST['message'];

        echo "<p style='color: wiht;'>🎉 Dank je wel, <b>$name</b>! Je bericht is verzonden.</p>";
    }
    ?>

    <form method="POST">
        <label>Naam:</label>
        <input type="text" name="name" required>

        <label>Email:</label>
        <input type="email" name="email" required>

        <label>Bericht:</label>
        <textarea name="message" required></textarea>

        <div class="form-buttons">
        <button type="submit">Verstuur</button>
        <button type="reset">Reset</button>
    </div>
    </form>
</main>

<?php
HTMLfoot(); // HTML-footer genereren
?>
