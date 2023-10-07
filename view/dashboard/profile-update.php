<?php
$param_id = $_SESSION["id"];
if ($param_id) {
    if (isset($_POST['update'])) {
        if (isset($_FILES['fileToUpload']) && $_FILES['fileToUpload']['error'] == UPLOAD_ERR_OK) {
            // A file has been uploaded
            $target_dir = "../assets/";
            $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // Allow certain file formats
            if (
                $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                && $imageFileType != "gif" && $imageFileType != "pdf"
            ) {
                // echo "Sorry, only JPG, JPEG, PNG, GIF, and PDF files are allowed.";
                $uploadOk = 1;
            }

            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                echo "Sorry, your file was not uploaded.";
                // if everything is ok, try to upload file
            } else {
                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {

                    // Insert filename into database
                    $id = $_POST['id'];
                    $filename = basename($_FILES["fileToUpload"]["name"]);
                    $name = $_POST['name'];
                    $email = $_POST['email'];
                    $mobile_number = $_POST['mobile_number'];
                    $stmt = $link->prepare("UPDATE users SET name=?, email=?, mobile_number=?,image=? WHERE id=?");
                    $stmt->bind_param("ssssi", $name, $email, $mobile_number, $filename, $id);
                    $stmt->execute();


                    $stmp->execute();
                    $result = $stmp->get_result();
                    $row = $result->fetch_assoc();
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            }
        } else {
            // No file has been uploaded
            // Insert other form data into database
            $id = $_POST['id'];
            $name = $_POST['name'];
            $email = $_POST['email'];
            $mobile_number = $_POST['mobile_number'];
            $stmt = $link->prepare("UPDATE users SET name=?, email=?, mobile_number=?, WHERE id=?");
            $stmt->bind_param("sssi", $name, $email, $mobile_number, $id);
            $stmt->execute();
            $stmt->close();


            $stmp->execute();
            $result = $stmp->get_result();
            $row = $result->fetch_assoc();
        }
    }
}

if ($user_type !== "admin") {
    include_once "../view/common/no-access.php";
} else {
?>

    <form method="POST" enctype="multipart/form-data" class="category-details">

        <div class="profile-container">

            <div class="profile-item-container">
                <div class="heading-text">
                    <h2>My Profile</h2>
                    <button type="submit" name="update" class="btn btn-filled">Save</button>
                </div>
                <div class="profile-item" style="justify-content: center;">

                    <label for="fileToUpload" class="profile-left fileToUploadLabel">
                        <input id="fileToUpload" type="file" name="fileToUpload" hidden>
                        <img id="profileImg" src="/assets/<?php if ($row["image"] === null) {
                                                                echo "common/avatar.svg";
                                                            } else {
                                                                echo $row["image"];
                                                            }; ?>" width="100" alt="#" class="profile-img">
                    </label>
                </div>
                <br>
                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

                <div class="profile-item">
                    <div class="profile-item-card">
                        <h3 class="profile-item-title">First Name</h3>
                        <input type="text" class="profile-item-text" placeholder="Ex: John" name="name" value="<?php if ($row["name"] === null) {
                                                                                                                    echo "";
                                                                                                                } else {
                                                                                                                    echo $row['name'];
                                                                                                                }; ?>">
                    </div>
                    <div class="profile-item-card">
                        <h3 class="profile-item-title">Father's Name</h3>
                        <input type="text" class="profile-item-text" placeholder="Ex: Robb" name="father_name" value="Satpal">
                    </div>
                    <div class="profile-item-card">
                        <h3 class="profile-item-title">Email address</h3>
                        <input type="email" class="profile-item-text" placeholder="Ex: johndoe@gmail.com" name="email" value="<?php if ($row["email"] === null) {
                                                                                                                                    echo "";
                                                                                                                                } else {
                                                                                                                                    echo $row['email'];
                                                                                                                                }; ?>">
                    </div>
                    <div class="profile-item-card">
                        <h3 class="profile-item-title">Phone</h3>
                        <input type="text" class="profile-item-text" placeholder="Ex: 987654321" name="mobile_number" value="<?php if ($row["mobile_number"] === null) {
                                                                                                                                    echo "";
                                                                                                                                } else {
                                                                                                                                    echo $row['mobile_number'];
                                                                                                                                }; ?>">
                    </div>
                </div>
            </div>
        </div>
    </form>
<?php } ?>