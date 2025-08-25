<?php
// Get the functions
include 'inc/functions.php'; // Zorg dat je dit bestand insluit

// Print the HTML header
HTMLhead("Game Shop");

// Print the HTML navbar
displaynav();

// Get the product
$product = getProduct();

// Controleer of het product bestaat en een geldige array is
if ($product && is_array($product)) {
?>
    <!-- Product details -->
    <div class="product-add-to-cart">
        <h3><?php echo htmlspecialchars($product['title']); ?></h3>
        <h4>&euro; <?php echo htmlspecialchars($product['price']); ?></h4>
        <img src="<?php echo htmlspecialchars($product['img']); ?>" alt="Product Image" class="product-img">
        
        <form action="cart.php" method="post" onsubmit="return validateQuantity()">
            <input type="hidden" name="productid" value="<?php echo htmlspecialchars($product['id']); ?>">
            <input type="number" name="productQuantity" min="1" required />
            <button type="submit">Add to cart</button>
        <!--  <button type="button" onclick="window.location.href='products.php';">terug naar products</button> -->
            <a href="products.php" class="Terug-naar-producten">Terug naar producten</a>
        </form>
    </div>

<?php
} else {
    // Foutmelding als er geen geldig product is
    echo "<p>Dit product is niet beschikbaar of er is een fout opgetreden.</p>";
}

// Form handling logic (validate quantity)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $quantity = $_POST['productQuantity'];

    if (empty($quantity) || $quantity < 1) {
        echo "<div class='error-message'>Please select at least 1 product.</div>";
    } else {
        // Verzend het formulier of verwerk verder
        echo "<div class='success-message'>Form is valid. Proceeding...</div>";
    }
}

// Print the HTML footer
HTMLfoot();
?>
