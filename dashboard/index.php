<?php
require_once "../config.php";
session_start();
require_once "../common.php";


$param_id = $_SESSION["id"];
$param_username = $_SESSION["username"];
$stmp = $link->prepare("SELECT * from users where id=?");
$stmp->bind_param("i", $param_id);
$stmp->execute();
$result = $stmp->get_result();
$row = $result->fetch_assoc();

$user_type = $row["usertype"];


// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: /login");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="author" content="imankitkalirawana">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Title -->
    <title>Divinely Developers</title>
    <!-- Style Sheet -->
    <link rel="stylesheet" type="text/css" href="/css/theme.css" />
    <link rel="stylesheet" type="text/css" href="/css/common.css" />
    <link rel="stylesheet" type="text/css" href="style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />


    <!-- Javascript -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200">
    <link rel="stylesheet" href="https://pro.Fontawesome.com/releases/v6.0.0-beta3/css/all.css">
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        #notifications-btn {
            position: relative;
        }

        #notifications-btn:after {
            content: "3";
            position: absolute;
            top: 0;
            right: 0;
            font-size: 10px;
            font-weight: 400;
            background: var(--primary);
            color: #fff;
            border-radius: 50%;
            aspect-ratio: 1;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid var(--bc-1);
        }
    </style>

</head>

<body>
    <section class="sidebar">
        <a href="/" class="sidebar-logo">
            <div class="logo-icon">
                <img src="/assets/logo.png" alt="#">
            </div>
            <div class="logo-text">
                <h1>DivDev</h1>
            </div>
        </a>


        <ul class="sidebar-menu">
            <li class="sidebar-item <?php
                                    if (isset($_GET["dashboard"])) {
                                        echo "sidebar-active";
                                    }
                                    ?>">
                <a href="?dashboard">
                    <i class="fa-solid fa-objects-column"></i>
                    <span class="sidebar-item-title">Dashboard</span>
                </a>
            </li>
            <li class="sidebar-item <?php
                                    if (isset($_GET["profile"])) {
                                        echo "sidebar-active";
                                    }
                                    ?>">
                <a href="?profile&view">
                    <i class="fa-solid fa-user"></i>
                    <span class="sidebar-item-title">Profile</span>
                </a>
            </li>
            <li class="sidebar-item <?php
                                    if (isset($_GET["notification"])) {
                                        echo "sidebar-active";
                                    }
                                    ?>">
                <a href="?notification&all">
                    <i class="fa-solid fa-bell"></i>
                    <span class="sidebar-item-title">Notification</span>
                </a>
            </li>
            <li class="sidebar-item <?php
                                    if (isset($_GET["time-table"])) {
                                        echo "sidebar-active";
                                    }
                                    ?>">
                <a href="?time-table">
                    <i class="fa-solid fa-calendar-days"></i>
                    <span class="sidebar-item-title">Time Table</span>
                </a>
            </li>
            <li class="sidebar-item <?php
                                    if (isset($_GET["exam"])) {
                                        echo "sidebar-active";
                                    }
                                    ?>">
                <a href="?exam">
                    <i class="fa-regular fa-calendar-lines-pen"></i>
                    <span class="sidebar-item-title">Exam</span>
                </a>
            </li>
            <li class="sidebar-item <?php
                                    if (isset($_GET["result"])) {
                                        echo "sidebar-active";
                                    }
                                    ?>">
                <a href="?result">
                    <i class="fa-regular fa-file-invoice"></i>
                    <span class="sidebar-item-title">Result</span>
                </a>
            </li>
            <li class="sidebar-item <?php
                                    if (isset($_GET["teachers"])) {
                                        echo "sidebar-active";
                                    }
                                    ?>">
                <a href="?teachers">
                    <i class="fa-solid fa-chalkboard-user"></i>
                    <span class="sidebar-item-title">Teachers</span>
                </a>
            </li>
            <li class="sidebar-item <?php
                                    if (isset($_GET["settings"])) {
                                        echo "sidebar-active";
                                    }
                                    ?>">
                <a href="?settings&appearance">
                    <i class="fa-solid fa-gear"></i>
                    <span class="sidebar-item-title">Settings</span>
                </a>
            </li>
            <li class="sidebar-item <?php
                                    if (isset($_GET["logout"])) {
                                        echo "sidebar-active";
                                    }
                                    ?>">
                <a href="/logout">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <span class="sidebar-item-title">Logout</span>
                </a>
            </li>
        </ul>
    </section>



    <section class="main-content">
        <!-- Header -->
        <?php include_once "../header.php"; ?>

        <?php
        if (isset($_GET['dashboard'])) {

        ?>
            <div class="main-content-container category-dashboard">
                <div class="category">
                    <div class="heading-text">
                        <h2>Overview</h2>
                    </div>
                    <div class="category-container">
                        <a href="/students" class="category-item">
                            <i class="fa-solid fa-users"></i>
                            <div class="item-details">
                                <p class="item-heading">Total Students</p>
                                <h3>600</h3>
                            </div>
                        </a>
                        <a href="?teachers" class="category-item">
                            <i class="fa-solid fa-chalkboard-user"></i>
                            <div class="item-details">
                                <p class="item-heading">Total Teachers</p>
                                <h3>50</h3>
                            </div>
                        </a>
                        <?php if ($user_type == "admin") { ?>
                            <a href="#" class="category-item">
                                <i class="fa-solid fa-screen-users"></i>
                                <div class="item-details">
                                    <p class="item-heading">Total Classes</p>
                                    <h3>21</h3>
                                </div>
                            </a>
                            <a href="#" class="category-item">
                                <i class="fa-regular fa-chart-line-up"></i>
                                <div class="item-details">
                                    <p class="item-heading">Total Profit</p>
                                    <h3>2,00,000</h3>
                                </div>
                            </a>
                        <?php } else if ($user_type == "member") { ?>
                            <a href="#" class="category-item">
                                <i class="fa-solid fa-calendar-day"></i>
                                <div class="item-details">
                                    <p class="item-heading">Days till next payment</p>
                                    <h3>14</h3>
                                </div>
                            </a>
                            <a href="#" class="category-item">
                                <i class="fa-solid fa-books"></i>
                                <div class="item-details">
                                    <p class="item-heading">Subjects</p>
                                    <h3>1</h3>
                                </div>
                            </a>
                        <?php } else if ($user_type == "user") { ?>
                            <a href="#" class="category-item">
                                <i class="fa-solid fa-books"></i>
                                <div class="item-details">
                                    <p class="item-heading">Subjects</p>
                                    <h3>7</h3>
                                </div>
                            </a>
                            <a href="#" class="category-item">
                                <i class="fa-solid fa-wallet"></i>
                                <div class="item-details">
                                    <p class="item-heading">Pending Fees</p>
                                    <h3>2,000</h3>
                                </div>
                            </a>
                        <?php } ?>
                    </div>
                </div>
                <div class="category category-calendar">
                    <div class="heading-text">
                        <h2>Calendar (<span id="currentMonthYear"></span>)</h2>
                    </div>
                    <div class="category-container">

                        <table id="calendar" class="calendar">
                            <thead>
                                <tr>
                                    <th>Sun</th>
                                    <th>Mon</th>
                                    <th>Tue</th>
                                    <th>Wed</th>
                                    <th>Thu</th>
                                    <th>Fri</th>
                                    <th>Sat</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php } else if (isset($_GET['profile'])) { ?>
            <div class="main-content-container category-profile">
                <!-- Profile -->
                <div class="category">
                    <div class="heading-text">
                        <h2>Account Settings</h2>
                    </div>
                    <div class="category-container">
                        <ul class="category-menu">
                            <li class="category-item <?php
                                                        if (isset($_GET['profile']) && isset($_GET['view']) || isset($_GET['edit'])) {
                                                            echo 'selected';
                                                        }
                                                        ?>">
                                <a href="?profile&view">Profile</a>
                            </li>
                            <li class="category-item <?php
                                                        if (isset($_GET['profile']) && isset($_GET['security'])) {
                                                            echo "selected";
                                                        }
                                                        ?>">
                                <a href="?profile&security">Security</a>
                            </li>
                            <li class="category-item <?php
                                                        if (isset($_GET['profile']) && isset($_GET['notifications'])) {
                                                            echo "selected";
                                                        }
                                                        ?>">
                                <a href="?profile&notifications">Notifications</a>
                            </li>
                            <li class="category-item logout">
                                <a href="/logout">Logout</a>
                            </li>
                        </ul>
                        <?php
                        if (isset($_GET['profile'])) {
                            if (isset($_GET['view'])) {
                                include_once "../view/dashboard/profile.php";
                            } else if (isset($_GET['edit'])) {
                                include_once "../view/dashboard/profile-update.php";
                            } else if (isset($_GET['security'])) {
                                include_once "../view/dashboard/security.php";
                            }
                        }  ?>
                    </div>
                </div>
            </div>
        <?php } else if (isset($_GET['notification']) && isset($_GET['all'])) { ?>
            <div class="main-content-container category-notification-all">
                <div class="category">
                    <div class="heading-text">
                        <h2>Announcements</h2>
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
                    <a href="?notification&announcements" class="btn btn-filled view-all-btn">View all announcements</a>
                </div>
                <div class="category">
                    <div class="heading-text">
                        <h2>My Messages</h2>
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
                    <a href="?notification&messages" class="btn btn-filled view-all-btn">View all messages</a>
                </div>
            </div>
        <?php } else if (isset($_GET['notification']) && isset($_GET['announcements'])) {  ?>
            <div class="main-content-container category-notification-announcements">
                <div class="category">
                    <div class="heading-text">
                        <h2>Announcements</h2>
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
                </div>
            </div>
        <?php } else if (isset($_GET['notification']) && isset($_GET['messages'])) { ?>
            <div class="main-content-container category-notification-announcements">
                <div class="category">
                    <div class="heading-text">
                        <h2>Messages</h2>
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
                </div>
            </div>
        <?php } else if (isset($_GET['time-table'])) { ?>
            <div class="main-content-container category-time-table">
                <div class="category">
                    <div class="heading-text">
                        <h2>Time Table</h2>
                    </div>

                    <div class="timetable">
                        <div class="table">
                            <div class="table-head">
                                <div class="table-item">
                                    Day
                                </div>
                                <div class="table-item">
                                    9:00 - 10:00
                                </div>
                                <div class="table-item">
                                    10:00 - 11:00
                                </div>
                                <div class="table-item">
                                    11:00 - 12:00
                                </div>
                                <div class="table-item">
                                    12:00 - 1:00
                                </div>
                                <div class="table-item">
                                    1:00 - 2:00
                                </div>
                                <div class="table-item">
                                    2:00 - 3:00
                                </div>
                                <div class="table-item">
                                    21:00 - 22:00
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } else if (isset($_GET['settings'])) { ?>
            <div class="main-content-container category-settings">
                <!-- Settings -->
                <div class="category">
                    <div class="heading-text">
                        <h2>Settings</h2>
                    </div>
                    <div class="category-container">
                        <ul class="category-menu">
                            <li class="category-item <?php
                                                        if (isset($_GET['settings']) && isset($_GET['appearance'])) {
                                                            echo 'selected';
                                                        }
                                                        ?>">
                                <a href="?settings&appearance">Appearance</a>
                            </li>
                            <li class="category-item <?php
                                                        if (isset($_GET['settings']) && isset($_GET['language'])) {
                                                            echo "selected";
                                                        }
                                                        ?>">
                                <a href="?settings&language">Language</a>
                            </li>
                            <li class="category-item <?php
                                                        if (isset($_GET['settings']) && isset($_GET['report'])) {
                                                            echo "selected";
                                                        }
                                                        ?>">
                                <a href="?settings&report">Report</a>
                            </li>
                            <li class="category-item logout">
                                <a href="/logout">Logout</a>
                            </li>
                        </ul>
                        <?php
                        if (isset($_GET['settings'])) {
                            if (isset($_GET['appearance'])) {
                                include_once "../view/dashboard/appearance.php";
                            } else if (isset($_GET['edit'])) {
                                include_once "../view/dashboard/profile-update.php";
                            } else if (isset($_GET['security'])) {
                                include_once "../view/dashboard/security.php";
                            }
                        }  ?>
                    </div>
                </div>
            </div>
        <?php } ?>
    </section>




    <script src="/js/script.js"></script>
    <script src="script.js"></script>
    <?php
    if (isset($_GET['dashboard'])) { ?>
        <script>
            createCalendar(currentYear, currentMonth);
        </script>
    <?php } else if (isset($_GET['time-table'])) {  ?>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Sample timetable data
                const timetableData = [{
                        day: 'Monday',
                        period1: 'Maths',
                        period2: 'English',
                        period3: 'Science',
                        period4: 'History',
                        period5: 'Economics',
                        period6: 'Art',
                        period7: 'Art'
                    },
                    {
                        day: 'Tuesday',
                        period1: 'English',
                        period2: 'Science',
                        period3: 'Maths',
                        period4: 'History',
                        period5: 'Civics',
                        period6: 'Physical Ed',
                        period7: 'Physical Ed'
                    },
                    {
                        day: 'Wednesday',
                        period1: 'English',
                        period2: 'Science',
                        period3: 'Maths',
                        period4: 'History',
                        period5: 'Hindi',
                        period6: 'Physical Ed',
                        period7: 'Physical Ed'
                    },
                    {
                        day: 'Thursday',
                        period1: 'English',
                        period2: 'Science',
                        period3: 'Maths',
                        period4: 'History',
                        period5: 'Economics',
                        period6: 'Physical Ed',
                        period7: 'Physical Ed'
                    },
                    {
                        day: 'Friday',
                        period1: 'English',
                        period2: 'Science',
                        period3: 'Maths',
                        period4: 'History',
                        period5: 'Maths',
                        period6: 'Physical Ed',
                        period7: 'Physical Ed'
                    },
                    {
                        day: 'Saturday',
                        period1: 'English',
                        period2: 'Science',
                        period3: 'Maths',
                        period4: 'History',
                        period5: 'English',
                        period6: 'Physical Ed',
                        period7: 'Physical Ed'
                    }
                ];

                const today = new Date().toLocaleDateString('en-US', {
                    weekday: 'long'
                });
                const timetableBody = document.querySelector('.table');

                // Function to initialize the timetable
                function initializeTimetable() {
                    populateTimetable();
                }

                // Function to populate the timetable
                function populateTimetable() {
                    timetableData.forEach((dayData) => {
                        const row = createTableRow(dayData);
                        if (dayData.day === today) {
                            row.classList.add('today'); // Apply the highlight class for today's timetable
                        }

                        timetableBody.appendChild(row);
                    });
                }

                // Function to create a table row for the timetable
                function createTableRow(dayData) {
                    const row = document.createElement('div');
                    row.innerHTML = `
                        <div class="table-item">${dayData.day}</div>
                        <div class="table-item">${dayData.period1}</div>
                        <div class="table-item">${dayData.period2}</div>
                        <div class="table-item">${dayData.period3}</div>
                        <div class="table-item">${dayData.period4}</div>
                        <div class="table-item">${dayData.period5}</div>
                        <div class="table-item">${dayData.period6}</div>
                        <div class="table-item">${dayData.period7}</div>
                        `;
                    return row;
                }

                // Call the initialization function
                initializeTimetable();
            });
        </script>
    <?php } else if (isset($_GET['settings'])) { ?>


    <?php } ?>

    <script>
        const themeItem = document.querySelectorAll(".appearance-item");

        function applyTheme(selectedTheme) {
            document.documentElement.setAttribute("data-theme", selectedTheme);
            themeItem.forEach((item) => {
                item.classList.remove("selected-theme");
                if (item.getAttribute("data-theme") === selectedTheme) {
                    item.classList.add("selected-theme");
                }
            });
        }

        function handleThemeSelection(theme) {
            const selectedTheme = theme.getAttribute("data-theme");
            localStorage.setItem("selectedTheme", selectedTheme);
            applyTheme(selectedTheme);
        }

        themeItem.forEach((item) => {
            item.addEventListener("click", () => handleThemeSelection(item));
        });

        // On page load, apply the theme from localStorage (if available)
        const userTheme = localStorage.getItem("selectedTheme");
        if (userTheme) {
            applyTheme(userTheme);
        } else {
            // If the user's selected theme is not available in localStorage,
            // apply the default theme here
            applyTheme("rainbow"); // Default theme
        }
    </script>
</body>

</html>