<?php
// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: /dashboard?dashboard");
    exit;
}

// Include config file
require_once "../config.php";

// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = $login_err = 0;

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if username is empty
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter username.";
    } else {
        $username = trim($_POST["username"]);
    }

    // Check if password is empty
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate credentials
    if (empty($username_err) && empty($password_err)) {
        // Prepare a select statement
        $sql = "SELECT id, username, password FROM users WHERE username = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set parameters
            $param_username = $username;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Store result
                mysqli_stmt_store_result($stmt);

                // Check if username exists, if yes then verify password
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if (mysqli_stmt_fetch($stmt)) {
                        if (password_verify($password, $hashed_password)) {
                            // Password is correct, so start a new session
                            session_start();
                            $expiration_time = time() + (20 * 24 * 60 * 60); // 20 days in seconds
                            setcookie(session_name(), session_id(), $expiration_time, '/');

                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;

                            // Redirect user to welcome page
                            header("location: index.php");
                        } else {
                            // Password is not valid, display a generic error message
                            $login_err = "Your password was incorrect. <a href='/forgot-password'>Forgot password?</a>";
                        }
                    }
                } else {
                    // Username doesn't exist, display a generic error message
                    $login_err = "New to imankitkalirawana? <a href='/register'>Create an acccount</a> instead.";
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Close connection
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en" data-theme="rainbow">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="/css/theme.css">
    <link rel="stylesheet" href="/css/login.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200">
    <link rel="stylesheet" href="https://pro.Fontawesome.com/releases/v6.0.0-beta3/css/all.css">
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <div class="container">
        <div class="container-logo">
            <div class="container-img">
                <img src="/assets/common/login-img.svg" alt="">
            </div>
            <h2 class="container-heading">Sign in with your ID</h2>
        </div>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="container-inputs">
            <div class="container-input-container">
                <div class="container-input container-username">
                    <span class="input-label">Username</span>
                    <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" autocomplete="off" autocapitalize="off">
                </div>
                <div class="container-input container-password">
                    <span class="input-label">Password</span>
                    <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" autocomplete="off" autocapitalize="off">
                    <button type="submit" class="login-btn"><i class="fa-sharp fa-solid fa-arrow-right fa-lg"></i></button>
                </div>
            </div>
            <?php if ($login_err) { ?>
                <div class="container-error">
                    <?php echo $login_err; ?>
                </div>
            <?php } else if ($username_err) { ?>
                <div class="container-error">
                    <?php echo $username_err; ?>
                </div>
            <?php } else if ($password_err) { ?>
                <div class="container-error">
                    <?php echo $password_err; ?>
                </div>
            <?php } ?>

        </form>
        <div class="container-redirects">
            <a href="/forgot-password/" class="container-forgot">Forgot ID or password?</a>
            <a href="/register/" class="container-forgot">Create an account</a>
        </div>


    </div>
    <script>
        $(document).ready(function() {
            // Detect input focus event
            $('.container-input input').on('focus', function() {
                // Add a class to the parent container to indicate focus (optional, but can be useful for additional styling)
                $(this).parent().addClass('input-focused');
            });

            // Detect input blur event (when focus is lost) for both username and password
            $('.container-input input').on('blur', function() {
                // Remove the focus class when input is not focused (optional)
                $(this).parent().removeClass('input-focused');

                // Check if the input field is empty, and if so, reset the position of the label

                if ($(this).val() !== '') {
                    $(this).parent().addClass('input-focused');
                }
            });
            $('.container-input input').each(function() {
                if ($(this).val() !== '') {
                    $(this).parent().addClass('input-focused');
                }
            });
        });
    </script>
</body>

</html>