/** @format */

//! Sidebar

// Get all the sidebar list items
const sidebarItems = document.querySelectorAll(".sidebar-item");

// Loop through each list item
sidebarItems.forEach((item) => {
  // Add a click event listener to each list item
  item.addEventListener("click", () => {
    // Remove the 'sidebar-active' class from all list items
    sidebarItems.forEach((item) => {
      item.classList.remove("sidebar-active");
    });

    // Add the 'sidebar-active' class to the clicked list item
    item.classList.add("sidebar-active");
  });
});

//! Profile Sidebar

const profileItem = document.querySelectorAll(
  ".category-profile .category-item"
);
profileItem.forEach((item) => {
  item.addEventListener("click", () => {
    profileItem.forEach((item) => {
      item.classList.remove("selected");
    });
    item.classList.add("selected");
  });
});

//! Calendar

function createCalendar(year, month) {
  var daysInMonth = new Date(year, month + 1, 0).getDate();
  var firstDayOfWeek = new Date(year, month, 1).getDay();

  var calendarBody = document
    .getElementById("calendar")
    .getElementsByTagName("tbody")[0];
  calendarBody.innerHTML = "";

  document.getElementById("currentMonthYear").textContent = new Date(
    year,
    month
  ).toLocaleDateString("en-US", {
    month: "long",
    year: "numeric",
  });

  var currentDate = new Date();
  var currentDay = currentDate.getDate();
  var currentMonth = currentDate.getMonth();
  var currentYear = currentDate.getFullYear();

  var specialDays = [5, 12, 15];

  var date = 1;
  for (var i = 0; i < 6; i++) {
    var row = calendarBody.insertRow();

    for (var j = 0; j < 7; j++) {
      if (i === 0 && j < firstDayOfWeek) {
        var cell = row.insertCell();
      } else if (date > daysInMonth) {
        break;
      } else {
        var cell = row.insertCell();
        cell.textContent = date;
        if (
          year === currentYear &&
          month === currentMonth &&
          date === currentDay
        ) {
          cell.classList.add("current-day");
        }
        if (j === 0) {
          cell.classList.add("sunday");
        }
        if (specialDays.includes(date)) {
          cell.classList.add("special-day");
        }
        date++;
      }
    }
  }
}

var currentDate = new Date();
var currentYear = currentDate.getFullYear();
var currentMonth = currentDate.getMonth();


//! Security Change password
function validatePassword() {
  var newPassword = document.getElementsByName("new_password")[0].value;
  var confirmPassword = document.getElementsByName("confirm_password")[0].value;

  // Regular expressions for password requirements
  var hasSpecialChar = /[@#$%^&*()_+\-=[\]{};':"\\|,.<>/?]/.test(newPassword);
  var hasNumber = /\d/.test(newPassword);
  var hasLowercase = /[a-z]/.test(newPassword);
  var hasUppercase = /[A-Z]/.test(newPassword);
  var hasLength = newPassword.length >= 8;
  var verifyCharacters = document.getElementById("verify-characters");
  var verifyLength = document.getElementById("verify-length");
  var verifyPassword = document.getElementById("verify-password");
  var submitBtn = document.getElementById("submit-btn");
  var passwordStatus = 0;

  if (hasSpecialChar && hasUppercase && hasLowercase && hasNumber) {
    verifyCharacters.style.color = "#14b86a";
  } else {
    verifyCharacters.style.color = "var(--fc-1)";
  }

  if (hasLength) {
    verifyLength.style.color = "#14b86a";
    if (newPassword !== confirmPassword) {
      verifyPassword.style.color = "var(--fc-1)";
    } else {
      passwordStatus = 1;
      verifyPassword.style.color = "#14b86a";
    }
  } else {
    verifyLength.style.color = "var(--fc-1)";
  }

  if (passwordStatus) {
    submitBtn.style.opacity = "1";
    submitBtn.disabled = false;
  } else {
    submitBtn.style.opacity = "0.5";
    submitBtn.disabled = true;
  }
}
