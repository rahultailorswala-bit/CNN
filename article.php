<?php
session_start();
require_once 'db.php';
$article_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$sql = "SELECT * FROM articles WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $article_id);
$stmt->execute();
$article = $stmt->get_result()->fetch_assoc();
$stmt->close();
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($article['title'] ?? 'Article'); ?></title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        body {
            background-color: #f4f4f4;
        }
        header {
            background-color: #c00;
            color: white;
            padding: 1rem;
            text-align: center;
        }
        nav {
            background-color: #333;
            padding: 1rem;
        }
        nav ul {
            list-style: none;
            display: flex;
            justify-content: center;
            gap: 2rem;
        }
        nav a {
            color: white;
            text-decoration: none;
            font-size: 1.1rem;
        }
        nav a:hover {
            color: #c00;
        }
        .article {
            max-width: 800px;
            margin: 2rem auto;
            padding: 1rem;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .article img {
            width: 100%;
            height: 300px;
            object-fit: cover;
            border-radius: 8px;
        }
        .article h1 {
            font-size: 2rem;
            margin: 1rem 0;
            color: #333;
        }
        .article p {
            font-size: 1.1rem;
            line-height: 1.6;
            color: #666;
        }
        .related {
            margin-top: 2rem;
        }
        .related h2 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }
        .related ul {
            list-style: none;
        }
        .related li {
            margin-bottom: 0.5rem;
        }
        .related a {
            text-decoration: none;
            color: #c00;
        }
        .related a:hover {
            text-decoration: underline;
        }
        @media (max-width: 768px) {
            nav ul {
                flex-direction: column;
                align-items: center;
            }
            .article {
                margin: 1rem;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>News Network</h1>
    </header>
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="category.php?cat=World">World</a></li>
            <li><a href="category.php?cat=Sports">Sports</a></li>
            <li><a href="category.php?cat=Technology">Technology</a></li>
            <li><a href="category.php?cat=Entertainment">Entertainment</a></li>
        </ul>
    </nav>
    <section class="article">
        <?php if ($article): ?>
            <img src="<?php echo htmlspecialchars($article['image']); ?>" alt="<?php echo htmlspecialchars($article['title']); ?>">
            <h1><?php echo htmlspecialchars($article['title']); ?></h1>
            <p><?php echo nl2br(htmlspecialchars($article['content'])); ?></p>
            <div class="related">
                <h2>Related News</h2>
                <ul>
                    <?php
                    $sql = "SELECT * FROM articles WHERE category = ? AND id != ? LIMIT 3";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("si", $article['category'], $article_id);
                    $stmt->execute();
                    $related = $stmt->get_result();
                    while ($row = $related->fetch_assoc()) {
                        echo "<li><a href='#' onclick='redirectToArticle({$row['id']})'>" . htmlspecialchars($row['title']) . "</a></li>";
                    }
                    $stmt->close();
                    ?>
                </ul>
            </div>
        <?php else: ?>
            <p>Article not found.</p>
        <?php endif; ?>
    </section>
    <script>
        function redirectToArticle(id) {
            window.location.href = `article.php?id=${id}`;
        }
    </script>
</body>
</html>
