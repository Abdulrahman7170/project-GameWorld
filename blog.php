<?php
include 'inc/functions.php';
$categories = getBlogCategories(); // Fetch all blog categories
$categoryId = isset($_GET['categoryId']) ? (int)$_GET['categoryId'] : null; // Get selected category
$blogs = getBlogs($categoryId); // Fetch blogs based on the selected category
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog</title>
    <link rel="stylesheet" href="css/blog.css"> <!-- Corrected the path to the CSS file -->
    <header>
        <div><h1>Game World Blog</h1></div>
        <nav>
            <li><a class="li-btn" href="index.php">Home</a></li>
            <li><a class="li-btn" href="blog.php">Blog</a></li>
        </nav>
    </header>
</head>
<body class="blog-page">
    <div class="blog-container">
        <aside class="blog-categories">
            <h2>Categories</h2>
            <header>
            <ul>
                <li><a href="blog.php">All Blogs</a></li>
                <?php foreach ($categories as $category): ?>
                    <li>
                        <a href="blog.php?categoryId=<?php echo $category['blogCategoryId']; ?>"
                           class="<?php echo ($categoryId == $category['blogCategoryId']) ? 'active' : ''; ?>">
                            <?php echo htmlspecialchars($category['blogCategoryName']); ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </aside>
        <main class="blog-list">
            <h2>Blogs</h2>
            <?php if (count($blogs) > 0): ?>
                <?php foreach ($blogs as $blog): ?>
                    <div class="blog-item">
                        <h3><a href="blogDetails.php?blogId=<?php echo $blog['blogId']; ?>">
                            <?php echo htmlspecialchars($blog['blogTitle']); ?>
                        </a></h3>
                        <p>By <?php echo htmlspecialchars($blog['blogAuther']); ?> on <?php echo htmlspecialchars($blog['postDate']); ?></p>
                        <p><?php echo substr(htmlspecialchars($blog['blogContent']), 0, 100); ?>...</p>
                        <a href="blogDetails.php?blogId=<?php echo $blog['blogId']; ?>">Read More</a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No blogs found in this category.</p>
            <?php endif; ?>
        </main>
    </div>
</body>
</html>