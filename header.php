<header>
    <div class="header-left">
        <i class="fa-regular fa-bars"></i>
        <div class="main-text">
            <h1>Dashboard</h1>
            <p>Admin / Dashboard</p>
        </div>
    </div>
    <div class="header-right">
        <div class="header-notifications">
            <i class="main-icon fa-solid fa-bell" id="notifications-btn"></i>
            <div class="header-notifications-container header-dropdown" id="notifications-container" style="display: none;">
                <div class="header-dropdown-main-text">
                    <h2>Notifications</h2>
                </div>
                <ul class="header-notifications-menu">
                    <li class="header-notifications-item">
                        <a href="#" class="notifications-user">
                            <img src="/assets/imankitkalirawana.jpg" width="40" alt="#">
                        </a>
                        <a href="#" class="notifications-content">
                            <h3 class="notifications-title">Lorem ipsum dolor sit amet.</h3>
                            <div class="notifications-text">
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Natus, vel repellat ea facere accusamus quaerat!</p>
                            </div>
                            <div class="notifications-date-time">
                                <p class="notifications-time">Friday 2:20pm</p>
                                <p class="notifications date">Sep 20,2024</p>
                            </div>
                        </a>
                    </li>
                    <li class="header-notifications-item">
                        <a href="#" class="notifications-user">
                            <img src="/assets/imankitkalirawana.jpg" width="40" alt="#">
                        </a>
                        <a href="#" class="notifications-content">
                            <h3 class="notifications-title">Lorem ipsum dolor sit amet.</h3>
                            <div class="notifications-text">
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Natus, vel repellat ea facere accusamus quaerat!</p>
                            </div>
                            <div class="notifications-date-time">
                                <p class="notifications-time">Friday 2:20pm</p>
                                <p class="notifications date">Sep 20,2024</p>
                            </div>
                        </a>
                    </li>
                    <li class="header-notifications-item">
                        <a href="#" class="notifications-user">
                            <img src="/assets/imankitkalirawana.jpg" width="40" alt="#">
                        </a>
                        <a href="#" class="notifications-content">
                            <h3 class="notifications-title">Lorem ipsum dolor sit amet.</h3>
                            <div class="notifications-text">
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Natus, vel repellat ea facere accusamus quaerat!</p>
                            </div>
                            <div class="notifications-date-time">
                                <p class="notifications-time">Friday 2:20pm</p>
                                <p class="notifications date">Sep 20,2024</p>
                            </div>
                        </a>
                    </li>
                </ul>
                <a href="?notifications" class="btn btn-filled">View all notifications</a>
            </div>
        </div>
        <div class="header-profile">
            <div class="header-profile-title">
                <span><?php if ($row["name"] === null) {
                            echo $row['username'];
                        } else {
                            echo $row['name'];
                        }; ?></span>
            </div>
        </div>
        <a href="/dashboard?profile&view" class="header-user">
            <img src="/assets/<?php if ($row["image"] === null) {
                                    echo "common/avatar.svg";
                                } else {
                                    echo $row["image"];
                                }; ?>" alt="#" width="40">
        </a>
    </div>
</header>