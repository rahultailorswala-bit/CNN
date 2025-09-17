<?php
session_start();
require_once 'db.php';
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News Website - Home</title>
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
        header h1 {
            font-size: 2.5rem;
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
        .featured {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 1rem;
        }
        .featured h2 {
            font-size: 2rem;
            margin-bottom: 1rem;
            color: #333;
        }
        .news-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
        }
        .news-card {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        }
        .news-card:hover {
            transform: translateY(-5px);
        }
        .news-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .news-card h3 {
            font-size: 1.5rem;
            padding: 1rem;
            color: #333;
        }
        .news-card p {
            padding: 0 1rem 1rem;
            color: #666;
        }
        .news-card a {
            text-decoration: none;
            color: inherit;
        }
        @media (max-width: 768px) {
            nav ul {
                flex-direction: column;
                align-items: center;
            }
            .news-grid {
                grid-template-columns: 1fr;
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
    <section class="featured">
        <h2>Featured News</h2>
        <div class="news-grid">
            <?php
            $sql = "SELECT * FROM articles WHERE featured = 1 LIMIT 6";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()) {
                echo "
                <div class='news-card'>
                    <a href='#' onclick='redirectToArticle({$row['id']})'>
                        <img src='{$row['image']}' alt='{$row['title']}'>
                        <h3>{$row['title']}</h3>
                        <p>" . substr($row['content'], 0, 100) . "...</p>
                    </a>
                </div>";
            }
            ?>
        </div>
    </section>
    <script>
        function redirectToArticle(id) {
            window.location.href = `article.php?id=${id}`;
        }
    </script>
</body>
</html>
