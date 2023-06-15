<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookmarked Posts</title>

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

<body>
    <?= view('layout/header') ?>
    <div id="container">
        <?= view('layout/sidebar', ['courses' => $courses]) ?>
        <div class="container mt-5">
            <h2>Bookmarked Posts</h2>

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