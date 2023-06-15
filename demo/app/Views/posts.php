<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <style>
        #container {
            display: flex;
        }
        #sidebar {
            width: 25%;
            min-width: 200px;
        }
        #main-content {
            width: 75%;
            min-width: 400px;
        }
    </style>
</head>
<body data-page-id="posts-page">
    <?= view('layout/header') ?>
    <div id="container">
        <?= view('layout/sidebar', ['courses' => $courses]) ?>
        <div class="container mt-5">
            <h2>Posts</h2>
            <div>
                <label for="sort-posts">Sort by:</label>
                <select id="sort-posts" name="sort">
                    <option value="default">Default</option>
                    <option value="favorites">Sort by Most Favourites</option>
                </select>
            </div>
            <div id="posts">
                <?php if (!empty($posts)): ?>
                    <?php foreach ($posts as $post): ?>
                        <div class="post" data-post-id="<?= $post['post_id'] ?>">
                            <a href="<?= base_url('home/post_details/' . $post['post_id']); ?>" class="text-decoration-none text-light">
                                <h3><?= $post['title'] ?></h3>
                                <p>
                                    <?php
                                    $words = explode(" ", $post['description']);
                                    echo implode(" ", array_slice($words, 0, 30));
                                    if (count($words) > 30) {
                                        echo "...";
                                    }
                                    ?>
                                </p>
                                <p class="author">Posted by <?= $post['username'] ?> on <?= $post['created_at'] ?> </p>
                                <p class="course-name">Course: <?= $post['course_name'] ?></p> 
                                <span class="favourite-count"><?= $post['favourite_count'] ?> Favourites</span>

                            </a>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No posts found for this course.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?= view('layout/footer') ?>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Set the unique page ID
      const pageId = document.body.getAttribute('data-page-id');
      
      // Check if there's a saved scroll position for the current page
      const savedScrollPosition = localStorage.getItem(`scrollPosition-${pageId}`);

      if (savedScrollPosition) {
        // Restore the saved scroll position
        window.scrollTo(0, parseInt(savedScrollPosition, 10));
      }

      // Save the scroll position when the user navigates away from the page
      window.addEventListener('beforeunload', function() {
        localStorage.setItem(`scrollPosition-${pageId}`, window.scrollY);
      });
    });
    </script>

    <script>
        document.getElementById('sort-posts').addEventListener('change', function() {
            const selectedValue = this.value;
            const currentUrl = new URL(window.location.href);
            if (selectedValue === 'favorites') {
                currentUrl.searchParams.set('sort', 'favorites');
            } else {
                currentUrl.searchParams.delete('sort');
            }
            window.location.href = currentUrl.toString();
        });
    </script>
</body>
</html>

<style>
    body {
        background-color: #343a40;
        color: #ffffff;
    }
    .post {
        margin-bottom: 30px;
        cursor: pointer;
    }
</style>