<?php
include 'inc/functions.php';
$blogId = isset($_GET['blogId']) ? (int)$_GET['blogId'] : null;
$blog = $blogId ? getBlogById($blogId) : null;
$comments = $blogId ? getCommentsByBlog($blogId) : [];
if (!$blog) {
    die("Blog not found.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($blog['title']); ?></title>
    <link rel="stylesheet" href="css/blog.css"> <!-- Corrected the path to the CSS file -->    
</head>
<body class="blog-details">
    <header>
        <div><h1>Game World Blog</h1></div>
        <nav>
            <li><a class="li-btn" href="index.php">Home</a></li>
            <li><a class="li-btn" href="blog.php">Blog</a></li>
        </nav>
    </header>
    <div class="blog-details-container">
        <article class="blog-post">
            <h2><?php echo htmlspecialchars($blog['blogTitle']); ?></h2>
            <p>By <?php echo htmlspecialchars($blog['blogAuther']); ?> on <?php echo htmlspecialchars($blog['postDate']); ?></p>
            <div class="blog-content">
                <?php echo nl2br(htmlspecialchars($blog['blogContent'])); ?>
            </div>
        </article>
        <section class="blog-comments">
            <h3>Comments</h3>
            <?php if (count($comments) > 0): ?>
                <ul>
                    <?php foreach ($comments as $comment): ?>
                        <li>
                            <p><strong><?php echo htmlspecialchars($comment['commentAuthor']); ?></strong> said:</p>
                            <p><?php echo nl2br(htmlspecialchars($comment['comment'])); ?></p>
                            <p><small>On <?php echo htmlspecialchars($comment['commentDate']); ?></small></p>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>No comments yet. Be the first to comment!</p>
            <?php endif; ?>
        </section>
        <section class="add-comment">
            <h3>Add a Comment</h3>
            <form action="blogDetails.php?blogId=<?php echo $blogId; ?>" method="post">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
                <label for="comment">Comment:</label>
                <textarea id="comment" name="comment" required></textarea>
                <button type="submit" name="addComment">Submit</button>
            </form>
            <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['addComment'])) {
                $name = htmlspecialchars($_POST['name']);
                $comment = htmlspecialchars($_POST['comment']);
                if (addComment($blogId, $name, $comment)) {
                    echo "<p>Comment added successfully!</p>";
                    header("Refresh:0");
                } else {
                    echo "<p>Failed to add comment. Please try again.</p>";
                }
            }
            ?>
        </section>
    </div>
</body>
</html>