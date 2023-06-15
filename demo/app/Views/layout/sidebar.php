<div id="sidebar" class="bg-dark text-light">
    <div class="text-center">
        <a href="<?= base_url('home/create_post'); ?>" id="create-post-btn" class="btn btn-primary custom-btn mx-auto">Create Post</a>
    </div>
    <style>
        .custom-btn {
            width: 80%;
        }
    </style>

    <h3>Courses</h3>
        <ul class="list-group mb-3">
            <?php foreach ($courses as $course): ?>
                <li class="list-group-item bg-secondary">
                    <a href="<?= base_url('home/course_posts/' . $course['course_id']); ?>" class="course-item text-light">
                        <?= $course['course_name'] ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    <hr class="sidebar-divider">
    <style>
        .sidebar-divider {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }
    </style>
    <ul class="list-group">
        <li class="list-group-item bg-secondary">
            <a href="<?= base_url('home/bookmarks') ?>" class="text-light">Bookmarks</a>
        </li>
    </ul>
</div>