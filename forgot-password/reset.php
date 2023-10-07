<?php
// Include config file
require_once "../config.php";

$otp_err = 0;


if (isset($_GET['email'])) {

    $email = trim($_GET['email']);

    if (isset($_POST['submit'])) {

        $stmt = $link->prepare("SELECT * FROM password_reset WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $db_otp = $row['otp'];
            $user_otp = $_POST['otp'];
            $new_password = $_POST['new_password'];

            // Match otp
            if ($user_otp == $db_otp) {
                $sql = "UPDATE users SET password = ? WHERE email = ?";
                if ($stmt = mysqli_prepare($link, $sql)) {
                    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                    mysqli_stmt_bind_param($stmt, "ss", $hashed_password, $email);
                    if (mysqli_stmt_execute($stmt)) {
                        echo "Passoword Updated Successfully";
                        $sql = "DELETE from password_reset WHERE email = ?";
                        if ($stmt = mysqli_prepare($link, $sql)) {
                            mysqli_stmt_bind_param($stmt, "s", $email);
                            mysqli_stmt_execute($stmt);
                            header("location: /login");
                        }
                    } else {
                        $otp_err = "Oops!! Something went wrong";
                    }
                    mysqli_stmt_close($stmt);
                } else {
                    $otp_err = "Oops!!! Something went wrong";
                }
            } else {
                $otp_err = "Otp Mismatched";
            }
        } else {
            $otp_err = "Otp not found or expired!";
        }
    }
} else {
    header("location: /login");
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
                <img src="/assets/common/forgot-password.svg" alt="">
            </div>
            <h2 class="container-heading">Forgot your ID or password</h2>
        </div>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="container-inputs">
            <div class="container-input-container">
                <div class="container-input container-username">
                    <input type="email" name="email" value="<?php echo $email; ?>" disabled>
                </div>
                <div class="container-input container-otp">
                    <span class="input-label">OTP</span>
                    <input style="border-radius: 0;" type="text" name="otp" class="form-control" autocomplete="off">
                </div>
                <div class="container-input container-password">
                    <span class="input-label">New Password</span>
                    <input type="password" name="new_password" class="form-control" autocomplete="off">
                    <button type="submit" class="login-btn"><i class="fa-sharp fa-solid fa-arrow-right fa-lg"></i></button>
                </div>
            </div>
            <?php if ($otp_err) { ?>
                <div class="container-error">
                    <?php echo $otp_err; ?>
                </div>
            <?php } ?>
        </form>
        <div class="container-redirects">
            <a href="/login" class="container-forgot">Go back to Login</a>
            <a href="/register/" class="container-forgot">Create an account</a>
        </div>


    </div>


    <!-- <div class="wrapper">
        <h2>Reset Password</h2>
        <p>Please enter the OTP and your new password to reset your password.</p>
        <form method="post">
            <div class="mb-3">
                <input type="hidden" name="email" value="<?php echo $email; ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">OTP</label>
                <input type="text" name="otp" class="form-control" autocomplete="off">
            </div>
            <div class="mb-3">
                <label class="form-label">New Password</label>
                <input type="password" name="new_password" class="form-control">
            </div>
            <div class="mb-3">
                <input type="submit" name="submit" class="btn btn-primary" value="Submit">
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