function switchTab(tabName) {
  document.querySelectorAll(".Acontent").forEach((content) => {
    content.classList.add("hidden");
  });

  document.querySelectorAll(".Abtn").forEach((btn) => {
    btn.classList.remove("border-yellow-400", "text-yellow-500", "border-b-2");
    btn.classList.add("text-gray-600", "hover:text-gray-900");
  });

  document.getElementById("ab" + tabName).classList.remove("hidden");

  const activeTab = document.getElementById("A" + tabName);
  activeTab.classList.remove("text-gray-600");
  activeTab.classList.add("border-yellow-400", "text-yellow-500", "border-b-2");
}

function approveShop(sid) {
  const xhr = new XMLHttpRequest();
  xhr.open("POST", "dashboard.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      const response = JSON.parse(xhr.responseText);
      if (response.status === "success") {
        const card = document.getElementById("pending-shop-" + sid);
        if (card) {
          setTimeout(() => {
            card.remove();
            location.reload();
          }, 300);
        }
      }
    }
  };

  xhr.send("action=approve&sid=" + sid);
}

function rejectShop(sid) {
  const xhr = new XMLHttpRequest();
  xhr.open("POST", "dashboard.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      const response = JSON.parse(xhr.responseText);
      if (response.status === "success") {
        const card = document.getElementById("pending-shop-" + sid);
        if (card) {
          setTimeout(() => {
            card.remove();
            const pendingList =
              document.getElementById("content-pending").children;
            if (pendingList.length <= 2) {
              location.reload();
            }
          }, 300);
        }
      }
    }
  };

  xhr.send("action=reject&sid=" + sid);
}

function suspendShop(sid) {
  const xhr = new XMLHttpRequest();
  xhr.open("POST", "dashboard.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      const response = JSON.parse(xhr.responseText);
      if (response.status === "success") {
        setTimeout(() => location.reload(), 100);
      }
    }
  };

  xhr.send("action=suspend&sid=" + sid);
}
function unsuspendShop(sid) {
  const xhr = new XMLHttpRequest();
  xhr.open("POST", "dashboard.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      const response = JSON.parse(xhr.responseText);
      if (response.status === "success") {
        setTimeout(() => location.reload(), 100);
      }
    }
  };

  xhr.send("action=unsuspend&sid=" + sid);
}

function deleteShop(sid) {
  const xhr = new XMLHttpRequest();
  xhr.open("POST", "dashboard.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      const response = JSON.parse(xhr.responseText);
      if (response.status === "success") {
        const shopRow = document.getElementById("shop-row-" + sid);
        if (shopRow) {
          setTimeout(() => {
            shopRow.remove();
          }, 300);
        }
      }
    }
  };

  xhr.send("action=delete&sid=" + sid);
}

function suspendUser(uid) {
  const xhr = new XMLHttpRequest();
  xhr.open("POST", "dashboard.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      const response = JSON.parse(xhr.responseText);
      if (response.status === "success") {
        setTimeout(() => location.reload(), 100);
      }
    }
  };

  xhr.send("action=suspend_usere&uid=" + uid);
}
function unsuspendUser(uid) {
  const xhr = new XMLHttpRequest();
  xhr.open("POST", "dashboard.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      const response = JSON.parse(xhr.responseText);
      if (response.status === "success") {
        setTimeout(() => location.reload(), 100);
      }
    }
  };

  xhr.send("action=unsuspend_user&uid=" + uid);
}

function deleteUser(uid) {
  const xhr = new XMLHttpRequest();
  xhr.open("POST", "dashboard.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  xhr.onreadystatechange = function () {
    if (xhr.readyState == 4 && xhr.status === 200) {
      const response = JSON.parse(xhr.responseText);
      if (response.status === "success") {
        const userRow = document.getElementById("user-row-" + uid);
        if (userRow) {
          setTimeout(() => {
            userRow.remove();
          }, 300);
        }
      }
    }
  };

  xhr.send("action=delete_user&uid=" + uid);
}

// Delete review
function deleteReview(rid) {
  if (!confirm("Are you sure you want to delete this review?")) return;

  const xhr = new XMLHttpRequest();
  xhr.open("POST", "dashboard.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  xhr.onload = function () {
    if (xhr.status === 200) {
      const response = JSON.parse(xhr.responseText);
      if (response.status === "success") {
        const reviewDiv = document.getElementById("review-" + rid);
        if (reviewDiv) {
          reviewDiv.style.transition = "all 0.3s ease";
          reviewDiv.style.opacity = "0";
          reviewDiv.style.transform = "translateX(-20px)";
          setTimeout(() => {
            reviewDiv.remove();
          }, 300);
        }
        showNotification("Review deleted successfully", "success");
      } else {
        showNotification(response.msg || "Failed to delete review", "error");
      }
    }
  };

  xhr.send("action=delete_review&rid=" + rid);
}
