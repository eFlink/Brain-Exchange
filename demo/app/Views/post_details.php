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
        .favourite-btn {
            cursor: pointer;
            font-size: 24px;
            color: #ccc;
        }

        .favourite-btn.favourited {
            color: gold;
        }

        .favourite-count {
            text-align: center;
            font-size: 14px;
        }

        .favourite-btn {
            cursor: pointer;
            font-size: 14px;
            border: none;
            padding: 6px 12px;
            border-radius: 4px;
            background-color: #ccc;
            color: #333;
        }

        .favourite-btn.favourited {
            background-color: gold;
            color: #333;
        }

    </style>

</head>
<body>
    <?= view('layout/header') ?>
    <div id="container">

        <?= view('layout/sidebar', ['courses' => $courses]) ?>
        <div id="main-content">
            <div class="container mt-5">

                <div class="d-flex justify-content-between">
                    <h2 class="mb-0"><?= $post['title'] ?></h2>
                    <div>
                        <button class="favourite-btn<?= $post['is_favourited'] ? ' favourited' : '' ?>" onclick="toggleFavourite(<?= $post['post_id'] ?>)">Favourite</button>

                        <p class="favourite-count"><?= $post['favourite_count'] ?> Favourites</p>
                    </div>
                </div>

                <p><?= $post['description'] ?></p>
                <p class="author">Posted by <?= $post['username'] ?> on <?= $post['created_at'] ?></p>
<div class="row">
  <?php
    $imagePaths = json_decode($post['image_path']); // Decode the JSON string into an array of image paths
    if (!empty($imagePaths)):
      foreach ($imagePaths as $imagePath):
  ?>
      <div class="col-md-4 my-2">
        <div class="card">
          <img src="<?= $imagePath ?>" class="card-img-top" alt="Post Image">
        </div>
      </div>
  <?php
      endforeach;
    endif;
  ?>
</div>

            </div>
            <div class="container mt-5">
                <h3>Comments</h3>
                <?php foreach ($comments as $comment): ?>
                    <div class="comment mb-3">
                        <p><?= $comment['content'] ?></p>
                        <p class="author">Commented by <?= $comment['username'] ?> on <?= $comment['created_at'] ?></p>
                    </div>
                <?php endforeach; ?>

                <?php echo form_open(base_url().'home/add_comment', ['id' => 'comment-form']); ?>

                    <div class="form-group">
                        <label for="content">Add a comment:</label>
                        <textarea class="form-control" name="content" id="content" rows="3"></textarea>
                    </div>
                    <input type="hidden" name="post_id" value="<?= $post['post_id'] ?>">
                    <button type="submit" class="btn btn-primary">Submit</button>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
    <?= view('layout/footer') ?>
<script>
    function toggleFavourite(postId) {
        const userId = <?= json_encode(session()->get('user_id')) ?>;

        $.ajax({
            url: "<?= base_url('favourites/toggle') ?>",
            method: "POST",
            data: { post_id: postId, user_id: userId },
            dataType: "json",
            success: function (data) {
                const favouriteBtn = $(".favourite-btn");
                const favouriteCount = $(".favourite-count");

                favouriteBtn.toggleClass("favourited", data.is_favourited);
                favouriteCount.text(`${data.favourite_count} Favourites`);
            },
            error: function () {
                // Handle error
                console.error("Failed to toggle favourite.");
            }
        });
    }
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
    }
    .card {
        border: none;
    }
    .card-img-top {
        object-fit: cover;
        height: 200px;
        border-radius: 5px;
    }
</style>
