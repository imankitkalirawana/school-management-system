<?php
// Include config file
require_once "../config.php";

// Define variables and initialize with empty values
$email = "";
$email_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate email
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter your email address.";
    } else {
        $email = trim($_POST["email"]);

        // Check if the email exists in the database
        $sql = "SELECT id FROM users WHERE email = ?";
        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $email);
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);
                if (mysqli_stmt_num_rows($stmt) == 0) {
                    $email_err = "Email address not found.";
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
            mysqli_stmt_close($stmt);
        }

        if (empty($email_err)) {
            // Generate OTP
            $otp = mt_rand(100000, 999999);

            // Set OTP expiration time (24 hours from now)
            $otp_expiry = time() + 24 * 60 * 60;

            // Store the OTP and its expiration time in the database
            $sql = "INSERT INTO password_reset (email, otp, otp_expiry) VALUES (?, ?, ?)";
            if ($stmt = mysqli_prepare($link, $sql)) {
                mysqli_stmt_bind_param($stmt, "sis", $email, $otp, $otp_expiry);
                if (mysqli_stmt_execute($stmt)) {
                    // Send OTP via email
                    $subject = "Password Reset OTP";
                    $url = 'reset.php?email=' . urlencode($email);
                    $headers = "From: 009ankitkalirawana@gmail.com"; // Replace with your email address
                    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                    $message = 'This is the OTP to reset your password: ' . $otp;

                    mail($email, $subject, $message, $headers);

                    // Redirect to reset.php with email parameter
                    header("location: reset.php?email=" . urlencode($email));
                } else {
                    echo "Oops! Something went wrong. Please try again later.";
                }
                mysqli_stmt_close($stmt);
            }
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
    <title>Forgot Password</title>
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
            <h2 class="container-heading">Forgot your ID or password</h2>
        </div>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="container-inputs">
            <div class="container-input-container">
                <div class="container-input container-password">
                    <span class="input-label">Email</span>
                    <input style="border-radius: 12px" type="email" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" autocomplete="off" autocapitalize="off">
                    <button type="submit" class="login-btn"><i class="fa-sharp fa-solid fa-arrow-right fa-lg"></i></button>
                </div>
            </div>
            <?php if ($email_err) { ?>
                <div class="container-error">
                    <?php echo $email_err; ?>
                </div>
            <?php } ?>
        </form>
        <div class="container-redirects">
            <a href="/login" class="container-forgot">Go back to Login</a>
            <a href="/register/" class="container-forgot">Create an account</a>
        </div>


    </div>



    <!-- <div class="wrapper">
        <h2>Forgot Password</h2>
        <p>Please enter your email address to receive the OTP for password reset.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                <span class="invalid-feedback"><?php echo $email_err; ?></span>
            </div>
            <div class="mb-3">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-secondary ml-2" value="Reset">
            </div>
        </form>
    </div> -->

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
        });
    </script>
</body>

</html>