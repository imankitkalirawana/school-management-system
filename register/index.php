<?php
// Include config file
require_once "../config.php";

// Define variables and initialize with empty values
$username = $email = $password = $confirm_password = "";
$username_err = $email_err = $password_err = $confirm_password_err = $register_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate username
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter a username.";
    } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))) {
        $username_err = "Username can only contain letters, numbers, and underscores.";
    } else {
        // Prepare a select statement
        $username = $param_username = trim($_POST["username"]);
        $email = $param_email = trim($_POST["email"]);

        $stmt = $link->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $param_username, $param_email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if ($row['email'] === $param_email) {
                $email_err = "Email already exist";
            } else if ($row['username'] === $param_username) {
                $username_err = "Username already exist";
            }
        }
        $stmt->close();
    }


    if (empty($username_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err)) {
        // Insert user into table
        $password = $_POST['new_password'];
        $param_password = password_hash($password, PASSWORD_DEFAULT);
        $sql = $link->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $sql->bind_param("sss", $param_username, $param_email, $param_password);
        $sql->execute();
        echo "<script>alert('Registration successful.');</script>";
    } else {
        $register_err = "Oops! Something went wrong. Please try again later.";
    }
}
?>

<!DOCTYPE html>
<html lang="en" data-theme="rainbow">

<head>
    <meta charset="UTF-8">
    <title>Register</title>
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
                <img src="/assets/common/register-img.svg" alt="">
            </div>
            <h2 class="container-heading">Sign in with your ID</h2>
        </div>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="container-inputs" oninput="validatePassword()">
            <div class="container-input-container">
                <div class="container-input container-username">
                    <span class="input-label">Username</span>
                    <input type="text" name="username" id="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                </div>
                <div class="container-input container-email">
                    <span class="input-label">Email</span>
                    <input type="email" name="email" id="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                </div>
                <div class="container-input container-username">
                    <span class="input-label">Password</span>
                    <input type="password" name="new_password" id="new_password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                </div>
                <div class="container-input container-password">
                    <span class="input-label">Confirm Password</span>
                    <input type="password" name="confirm_password" id="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                    <button type="submit" id="submit-btn" class="login-btn" disabled><i class="fa-sharp fa-solid fa-arrow-right fa-lg"></i></button>
                </div>
            </div>
            <div class="form-alert">
                <?php if ($register_err) { ?>
                    <p class="form-alert-text form-alert-text-danger"><i class="fa-duotone fa-circle-xmark"></i> <?php echo $register_err; ?></p>
                <?php } else if ($username_err) { ?>
                    <p class="form-alert-text form-alert-text-danger"><i class="fa-duotone fa-circle-xmark"></i> <?php echo $username_err; ?></p>

                <?php } else if ($password_err) { ?>
                    <p class="form-alert-text form-alert-text-danger"><i class="fa-duotone fa-circle-xmark"></i> <?php echo $password_err; ?></p>

                <?php } else if ($confirm_password_err) { ?>
                    <p class="form-alert-text form-alert-text-danger"><i class="fa-duotone fa-circle-xmark"></i> <?php echo $confirm_password_err; ?></p>

                <?php } else if ($email_err) { ?>
                    <p class="form-alert-text form-alert-text-danger"><i class="fa-duotone fa-circle-xmark"></i> <?php echo $eerr; ?></p>

                <?php } ?>
                <p class="form-alert-text">
                    <i class="fa-duotone fa-circle-check" id="verify-characters"></i>
                    Password must contain special, UPPER & lowercase alphanumeric characters.
                </p>
                <p class="form-alert-text">
                    <i class="fa-duotone fa-circle-check" id="verify-length"></i>
                    Password must be minimum 8 characters long.
                </p>
                <p class="form-alert-text">
                    <i class="fa-duotone fa-circle-check" id="verify-password"></i>
                    Password in both fields must match.
                </p>
            </div>


        </form>
        <div class="container-redirects">
            <a href="/forgot-password/" class="container-forgot">Forgot ID or password?</a>
            <a href="/login" class="container-forgot">Already have account?</a>
        </div>
    </div>
    <script src="/dashboard/script.js"></script>
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