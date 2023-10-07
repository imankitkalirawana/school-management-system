<?php
// Define variables and initialize with empty values
$new_password = $confirm_password = "";
$new_password_err = $confirm_password_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate new password
    if (empty(trim($_POST["new_password"]))) {
        $new_password_err = "Please enter the new password.";
    } elseif (strlen(trim($_POST["new_password"])) < 6) {
        $new_password_err = "Password must have atleast 6 characters.";
    } else {
        $new_password = trim($_POST["new_password"]);
    }

    // Validate confirm password
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Please confirm the password.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($new_password_err) && ($new_password != $confirm_password)) {
            $confirm_password_err = "Password did not match.";
        } 
    }

    // Check input errors before updating the database
    if (empty($new_password_err) && empty($confirm_password_err)) {
        // Prepare an update statement
        $sql = "UPDATE users SET password = ? WHERE id = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "si", $param_password, $param_id);

            // Set parameters
            $param_password = password_hash($new_password, PASSWORD_DEFAULT);
            $param_id = $_SESSION["id"];

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Password updated successfully. Destroy the session, and redirect to login page
                $notification_state = "success";
                $notification_title = "Password Changed!"; 
                $notification_text = "Your password was changed successfully.";
                $notification_icon = "circle-check";
            } else {
                $notification_state = "danger";
                $notification_title = "Can't Change Password";
                $notification_text = "There was a problem changing your password.";
                $notification_icon = "triangle-exclamation";
            }
            include_once "../view/common/status-notification.php";

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Close connection
    mysqli_close($link);
}
?>

<form method="post" class="category-details" oninput="validatePassword()">
    <div class="heading-text">
        <h2>Change Password</h2>
        <button type="submit" name="update" class="btn btn-filled" id="submit-btn" disabled style="opacity: 0.5;">Save</button>
    </div>
    <div class="profile-container">
        <div class="profile-item-container">
            <div class="profile-item">
                <div class="div profile-item-card">
                    <h3 class="profile-item-title">New Password</h3>
                    <input type="password" name="new_password" class="profile-item-text">
                </div>
                <div class="div profile-item-card">
                    <h3 class="profile-item-title">Confirm Password</h3>
                    <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>">
                </div>
                <div class="form-alert">
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
            </div>
        </div>

    </div>
</form>