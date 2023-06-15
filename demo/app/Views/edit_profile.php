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
        .main-content {
            width: 75%;
            min-width: 400px;
        }
    </style>
</head>
<body>
    <?= view('layout/header') ?>
    <div id="container">
        <?= view('layout/sidebar', ['courses' => $courses]) ?>
        <div class="main-content mt-5">
            <h2>Dashboard</h2>
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">User Statistics</h5>
                        <p class="card-text">Total Posts: <?= $total_posts ?></p>
                        <p class="card-text">Total Likes Received: <?= $total_likes ?></p>
                    </div>
                </div>
            <h2>Edit Profile</h2>

            <?php echo form_open(base_url().'profile/update'); ?>
                <div class="form-group">
                    <label for="course_id">Add Course</label>
                    <select class="form-control" name="course_id" id="course_id">
                        <option value="">Select a course</option>
                        <?php foreach ($available_courses as $course): ?>
                            <option value="<?= $course['course_id'] ?>"><?= $course['course_name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary mt-3">Update Profile</button>
            <?php echo form_close(); ?>
        </div>
    </div>
    <?= view('layout/footer') ?>
</body>
</html>
