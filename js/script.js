/** @format */

// Header Dropdown

var notificationsBtn = document.getElementById("notifications-btn");
var notificationsContainer = document.getElementById("notifications-container");

function toggleNotifications() {
  if (notificationsContainer.style.display === "none") {
    notificationsContainer.style.display = "flex";
  } else {
    notificationsContainer.style.display = "none";
  }
}

document.addEventListener("keydown", function (event) {
  var notificationsContainer = document.getElementById(
    "notifications-container"
  );

  if (event.key === "Escape") {
    notificationsContainer.style.display = "none";
  }
});

document.addEventListener("click", function (event) {
  if (
    !notificationsContainer.contains(event.target) &&
    event.target.id !== "notifications-btn"
  ) {
    notificationsContainer.style.display = "none";
  }
});

notificationsBtn.addEventListener("click", function (event) {
  event.stopPropagation();
  toggleNotifications();
});

// Status Notifications



document.addEventListener("DOMContentLoaded", function () {
  var statusNotifications = document.getElementById("status-notifications");

  if (statusNotifications) {
    // After 3 seconds, set the display of status-notifications to "none"
    setTimeout(function () {
      statusNotifications.style.right = "-100%";
    }, 5000); // 3000 milliseconds = 3 seconds
  }
});
