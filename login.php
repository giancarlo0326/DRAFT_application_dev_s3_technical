<?php
session_start();

// Check if the user is already logged in
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header('Location: index.php');
    exit;
}

$login_error = '';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Hardcoded credentials (replace with your actual login logic)
    if ($username == 'admin' && $password == 'password123') {
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;

        // Remember Me functionality (cookie)
        if (isset($_POST['remember']) && $_POST['remember'] == 'on') {
            $cookie_name = 'remember_user';
            $cookie_value = $username;
            setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 30 days
        } else {
            // If not checked, unset the cookie if it exists
            if (isset($_COOKIE['remember_user'])) {
                unset($_COOKIE['remember_user']);
                setcookie('remember_user', null, -1, '/');
            }
        }

        header('Location: index.php');
        exit;
    } else {
        $login_error = 'Incorrect username or password.';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2.0/dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <a href="#"><b>Log</b>In</a>
    </div>
    <!-- Login form -->
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Sign in to start your session</p>
            <p class="login-box-msg"><a href="signup.php">or create an account</a></p>

            <?php if ($login_error != ''): ?>
            <p class="text-danger"><?= $login_error ?></p>
            <?php endif; ?>

            <form action="login.php" method="post">
                <div class="input-group mb-3">
                    <input type="text" name="username" class="form-control" placeholder="Username" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Password" required id="password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-8">
                        <div class="icheck-primary">
                            <input type="checkbox" id="showPassword">
                            <label for="showPassword">
                                Show Password
                            </label>
                        </div>
                        <div class="icheck-primary mt-2">
                            <input type="checkbox" id="remember" name="remember">
                            <label for="remember">
                                Remember Me
                            </label>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>
        </div>
        <!-- /.login-card-body -->
    </div>
</div>
<!-- /.login-box -->

<!-- AdminLTE JS -->
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2.0/dist/js/adminlte.min.js"></script>
<script>
    // Toggle password visibility
    document.getElementById('showPassword').addEventListener('change', function() {
        var passwordInput = document.getElementById('password');
        if (this.checked) {
            passwordInput.type = 'text';
        } else {
            passwordInput.type = 'password';
        }
    });
</script>
</body>
</html>
