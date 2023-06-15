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
<body>
    <?= view('layout/header') ?>
    <div id="container">
        <?= view('layout/sidebar', ['courses' => $courses]) ?>
        <div id="main-content">
        </div>
    </div>
    <?= view('layout/footer') ?>

</body>
</html>
