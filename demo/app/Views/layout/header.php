<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Forum</title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/bootstrap.css">
    <script src="<?php echo base_url(); ?>assets/js/jquery-3.6.0.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/bootstrap.js"></script>

    <style>
        .search-container {
            position: relative;
            display: inline-block;
        }

        .dropdown-menu {
            position: absolute;
            top: 100%;
            left: 0;
            z-index: 1000;
            max-width: 300px;
        }
    </style>
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-md bg-dark navbar-dark">
            <a href="<?= base_url() ?>" class="navbar-brand">Brain Exchange</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="collapsibleNavbar">
                <div class="search-container ml-auto">
                    <form action="<?= base_url('search') ?>" method="get" class="form-inline">
                        <input type="text" name="query" id="query" placeholder="Search" class="form-control mr-sm-2">
                        <button type="submit" class="btn btn-success">Search</button>
                    </form>
                </div>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                            <?= session()->get('username') ?>
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="<?= base_url('profile/edit') ?>">Edit Profile</a>
                            <a class="dropdown-item" href="<?= base_url('login/logout') ?>">Logout</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">Notifications</a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
<script>
$(document).ready(function() {
    const searchInput = $('input[name="query"]');
    const suggestionsDropdown = $('<div class="dropdown-menu w-100"></div>');

    searchInput.parent().append(suggestionsDropdown);

    searchInput.on('input', async function() {
        const query = $(this).val().trim();
        if (!query) {
            suggestionsDropdown.empty().hide();
            return;
        }

        const response = await fetch(`<?= base_url('search/suggestions') ?>?query=${encodeURIComponent(query)}`, {
            method: 'GET'
        });

        const suggestions = await response.json();

        suggestionsDropdown.empty();
        if (suggestions.length > 0) {
            for (const suggestion of suggestions) {
                const item = $('<a class="dropdown-item"></a>');
                item.text(suggestion.title);
                item.attr('href', `<?= base_url('home/post_details/') ?>${suggestion.post_id}`);
                suggestionsDropdown.append(item);
            }
        } else {
            suggestionsDropdown.append('<p class="dropdown-item text-muted">No results</p>');
        }
        suggestionsDropdown.show();
    });

    // Hide suggestions when clicking outside
    $(document).on('click', function(event) {
        if (!searchInput.is(event.target) && !suggestionsDropdown.is(event.target)) {
            suggestionsDropdown.hide();
        }
    });
});
</script>

</body>