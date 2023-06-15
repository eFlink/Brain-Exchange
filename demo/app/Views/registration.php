<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <style>
        #password-strength {
            font-size: 14px;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Register</h1>
        <?php echo form_open(base_url()."registration/register"); ?>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
                <div id="password-strength"></div>
            </div>
            <div class="form-group">
                <label for="first_name">First Name</label>
                <input type="text" class="form-control" id="first_name" name="first_name" required>
            </div>
            <div class="form-group">
                <label for="last_name">Last Name</label>
                <input type="text" class="form-control" id="last_name" name="last_name" required>
            </div>
            <button type="submit" class="btn btn-primary">Register</button>
            <div>
                <?= validation_list_errors() ?>
            </div>
        <?php echo form_close(); ?>
    </div>

    <script>
        function checkPasswordStrength(password) {
            let strength = 0;

            if (password.length < 8) {
                return 'Too short';
            }

            if (password.match(/[a-z]/)) strength++;
            if (password.match(/[A-Z]/)) strength++;
            if (password.match(/[0-9]/)) strength++;
            if (password.match(/[^a-zA-Z0-9]/)) strength++;

            switch (strength) {
                case 1:
                    return 'Weak';
                case 2:
                    return 'Medium';
                case 3:
                    return 'Strong';
                case 4:
                    return 'Very strong';
                default:
                    return 'Undefined';
            }
        }

        $(document).ready(function() {
            $('#password').on('input', function() {
                const password = $(this).val();
                const strength = checkPasswordStrength(password);
                $('#password-strength').text(strength);
            });
        });
    </script>
    
</body>
</html>
