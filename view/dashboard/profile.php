<div class="category-details">
    <div class="heading-text">
        <h2>My Profile</h2>
        <a href="?profile&edit" class="btn <?php if ($user_type !== "admin") {
                                                echo 'btn-disabled" onclick="return false';
                                            } ?>">Edit <i class="fa-regular fa-pen-line"></i></a>
    </div>
    <div class="profile-container">
        <div class="profile-item-container">
            <div class="profile-item">
                <div class="profile-left">
                    <img src="/assets/<?php if ($row["image"] === null) {
                                            echo "common/avatar.svg";
                                        } else {
                                            echo $row["image"];
                                        }; ?>" width="100" alt="#" class="profile-img">
                    <div class="profile-details">
                        <h2 class="profile-name"><?php echo $row['username']; ?></h2>
                        <p class="profile-profession">10th</p>
                    </div>
                </div>
                <div class="profile-right">
                </div>
            </div>
        </div>
        <div class="profile-item-container">
            <div class="heading-text">
                <h2>Personal Information</h2>
            </div>
            <div class="profile-item">
                <div class="profile-item-card">
                    <h3 class="profile-item-title">Name</h3>
                    <p class="profile-item-text"><?php if ($row["name"] === null) {
                                                        echo "-";
                                                    } else {
                                                        echo $row['name'];
                                                    }; ?></p>
                </div>
                <div class="profile-item-card">
                    <h3 class="profile-item-title">Father's Name</h3>
                    <p class="profile-item-text">Satpal</p>
                </div>
                <div class="profile-item-card">
                    <h3 class="profile-item-title">Email address</h3>
                    <p class="profile-item-text"><?php if ($row["email"] === null) {
                                                        echo "-";
                                                    } else {
                                                        echo $row['email'];
                                                    }; ?></p>
                </div>
                <div class="profile-item-card">
                    <h3 class="profile-item-title">Phone</h3>
                    <p class="profile-item-text"><?php if ($row["mobile_number"] === null) {
                                                        echo "-";
                                                    } else {
                                                        echo "+91 " . $row['mobile_number'];
                                                    }; ?></p>
                </div>
            </div>
        </div>
        <div class="profile-item-container">
            <div class="heading-text">
                <h2>Schooling Details</h2>
            </div>
            <div class="profile-item">
                <div class="profile-item-card">
                    <h3 class="profile-item-title">Registeration No.</h3>
                    <p class="profile-item-text"><?php echo $row['id']; ?></p>
                </div>
                <div class="profile-item-card">
                    <h3 class="profile-item-title">Grade</h3>
                    <p class="profile-item-text">10</p>
                </div>
                <div class="profile-item-card">
                    <h3 class="profile-item-title">CGPA</h3>
                    <p class="profile-item-text">7.8</p>
                </div>
            </div>
        </div>
    </div>
</div>