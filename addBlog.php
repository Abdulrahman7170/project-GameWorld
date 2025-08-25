<?php
require_once 'inc/functions.php';  
session_start();
 
// Controleer of de gebruiker is ingelogd en of de userId 4 is
if (!isset($_SESSION['name']) || $_SESSION['name']['Id'] != 10) {
    //header("Location: blog.php"); // Redirect als de gebruiker geen toegang heeft
    //exit;
}
 
// Variabelen voor blog invoer
$title = '';
$author = '';
$date = date('Y-m-d H:i:s');
$category = '';
$content = '';
$error = '';
 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verkrijg de gegevens uit het formulier
    $title = trim($_POST['title']);
    $author = trim($_POST['author']);
    $category = (int)$_POST['category'];
    $content = trim($_POST['content']);
 
    // Valideer de velden
    if (empty($title) || empty($author) || empty($category) || empty($content)) {
        $error = "Alle velden moeten worden ingevuld.";
    } else {
        // Voeg de blog toe aan de database
        $conn = db_connect();
 
        $sql = "INSERT INTO blog (blogTitle, blogAuther, postDate, blogCategoryId, blogContent)
                VALUES (?, ?, ?, ?, ?)";
 
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("sssss", $title, $author, $date, $category, $content);
 
            if ($stmt->execute()) {
                header("Location: blog.php");
                exit;
            } else {
                $error = "Er is een fout opgetreden bij het toevoegen van de blog.";
            }
        } else {
            $error = "De databasequery kon niet worden uitgevoerd.";
        }
    }
}
?>
 
 <!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voeg Blog Toe</title>
    <link rel="stylesheet" href="css/blog.css"> <!-- Correcte stylesheet -->
    <header>
        <div><h1>Game World Blog</h1></div>
        <nav>
            <li><a class="li-btn" href="index.php">Home</a></li>
            <li><a class="li-btn" href="blog.php">Blog</a></li>
        </nav>
    </header>
</head>
<body class="add-blog-page"> <!-- HIER de juiste class toegevoegd -->


<main class="add-blog-container"> <!-- Correcte class zonder foutje -->
    <h1>Voeg een nieuwe blog toe</h1>

    <?php if (isset($error) && !empty($error)): ?>
        <p class="error-message"><?php echo $error; ?></p>
    <?php endif; ?>

    <form action="addBlog.php" method="POST" class="add-blog-form">
        <label for="title">Titel:</label>
        <input type="text" name="title" id="title" value="<?= htmlspecialchars($title) ?>" required>

        <label for="author">Auteur:</label>
        <input type="text" name="author" id="author" value="<?= htmlspecialchars($author) ?>" required>

        <label for="category">Categorie:</label>
        <select name="category" id="category" required>
            <option value="">Kies een categorie</option>
            <option value="1" <?= $category == 1 ? 'selected' : '' ?>>Nieuwe Producten</option>
            <option value="2" <?= $category == 2 ? 'selected' : '' ?>>Game Reviews</option>
            <option value="3" <?= $category == 3 ? 'selected' : '' ?>>Fun Facts</option>
        </select>

        <label for="content">Inhoud:</label>
        <textarea name="content" id="content" required><?= htmlspecialchars($content) ?></textarea>

        <div class="form-buttons">
            <button type="submit" class="submit-btn">Blog Toevoegen</button>
            <button type="reset" class="reset-btn">Reset</button>
        </div>
    </form>
</main>

</body>
</html>
