// Tab switching functionality
function switchTab(tabName) {
  // Hide all tab contents
  document.querySelectorAll(".tab-content").forEach((content) => {
    content.classList.add("hidden");
  });

  // Remove active styling from all tabs
  document.querySelectorAll(".tab-btn").forEach((btn) => {
    btn.classList.remove("border-yellow-400", "text-yellow-600");
    btn.classList.add("text-gray-600");
  });

  // Show selected tab content
  document.getElementById("content-" + tabName).classList.remove("hidden");

  // Add active styling to selected tab
  const activeTab = document.getElementById("tab-" + tabName);
  activeTab.classList.remove("text-gray-600");
  activeTab.classList.add("border-yellow-400", "text-yellow-600");
}

// Approve shop
function approveShop(sid) {
  if (!confirm("Are you sure you want to approve this shop?")) return;

  const xhr = new XMLHttpRequest();
  xhr.open("POST", "dashboard.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  xhr.onload = function () {
    if (xhr.status === 200) {
      const response = JSON.parse(xhr.responseText);
      if (response.status === "success") {
        // Remove the shop card from pending list
        const shopCard = document.getElementById("pending-shop-" + sid);
        if (shopCard) {
          shopCard.style.transition = "all 0.3s ease";
          shopCard.style.opacity = "0";
          shopCard.style.transform = "translateY(-20px)";
          setTimeout(() => {
            shopCard.remove();

            // Check if there are any remaining pending shops
            const pendingList =
              document.getElementById("content-pending").children;
            if (pendingList.length <= 2) {
              // Only header and no shops
              location.reload();
            }
          }, 300);
        }

        // Show success message
        showNotification("Shop approved successfully!", "success");
      } else {
        showNotification(response.msg || "Failed to approve shop", "error");
      }
    }
  };

  xhr.onerror = function () {
    showNotification("Network error occurred", "error");
  };

  xhr.send("action=approve_shop&sid=" + sid);
}

// Reject shop
function rejectShop(sid) {
  if (!confirm("Are you sure you want to reject this shop?")) return;

  const xhr = new XMLHttpRequest();
  xhr.open("POST", "dashboard.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  xhr.onload = function () {
    if (xhr.status === 200) {
      const response = JSON.parse(xhr.responseText);
      if (response.status === "success") {
        const shopCard = document.getElementById("pending-shop-" + sid);
        if (shopCard) {
          shopCard.style.transition = "all 0.3s ease";
          shopCard.style.opacity = "0";
          shopCard.style.transform = "translateY(-20px)";
          setTimeout(() => {
            shopCard.remove();
            const pendingList =
              document.getElementById("content-pending").children;
            if (pendingList.length <= 2) {
              location.reload();
            }
          }, 300);
        }
        showNotification("Shop rejected", "success");
      } else {
        showNotification(response.msg || "Failed to reject shop", "error");
      }
    }
  };

  xhr.onerror = function () {
    showNotification("Network error occurred", "error");
  };

  xhr.send("action=reject_shop&sid=" + sid);
}

// Suspend shop
function suspendShop(sid) {
  if (!confirm("Are you sure you want to suspend this shop?")) return;

  const xhr = new XMLHttpRequest();
  xhr.open("POST", "dashboard.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  xhr.onload = function () {
    if (xhr.status === 200) {
      const response = JSON.parse(xhr.responseText);
      if (response.status === "success") {
        showNotification("Shop suspended successfully", "success");
        setTimeout(() => location.reload(), 1000);
      } else {
        showNotification(response.msg || "Failed to suspend shop", "error");
      }
    }
  };

  xhr.onerror = function () {
    showNotification("Network error occurred", "error");
  };

  xhr.send("action=suspend_shop&sid=" + sid);
}

// Delete shop
function deleteShop(sid) {
  if (
    !confirm(
      "Are you sure you want to delete this shop? This action cannot be undone!"
    )
  )
    return;

  const xhr = new XMLHttpRequest();
  xhr.open("POST", "dashboard.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  xhr.onload = function () {
    if (xhr.status === 200) {
      const response = JSON.parse(xhr.responseText);
      if (response.status === "success") {
        const shopRow = document.getElementById("shop-row-" + sid);
        if (shopRow) {
          shopRow.style.transition = "all 0.3s ease";
          shopRow.style.opacity = "0";
          setTimeout(() => {
            shopRow.remove();
          }, 300);
        }
        showNotification("Shop deleted successfully", "success");
      } else {
        showNotification(response.msg || "Failed to delete shop", "error");
      }
    }
  };

  xhr.onerror = function () {
    showNotification("Network error occurred", "error");
  };

  xhr.send("action=delete_shop&sid=" + sid);
}

// Delete user
function deleteUser(uid) {
  if (
    !confirm(
      "Are you sure you want to delete this user? This will also delete all their associated data!"
    )
  )
    return;

  const xhr = new XMLHttpRequest();
  xhr.open("POST", "dashboard.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  xhr.onload = function () {
    if (xhr.status === 200) {
      const response = JSON.parse(xhr.responseText);
      if (response.status === "success") {
        const userRow = document.getElementById("user-row-" + uid);
        if (userRow) {
          userRow.style.transition = "all 0.3s ease";
          userRow.style.opacity = "0";
          setTimeout(() => {
            userRow.remove();
          }, 300);
        }
        showNotification("User deleted successfully", "success");
      } else {
        showNotification(response.msg || "Failed to delete user", "error");
      }
    }
  };

  xhr.onerror = function () {
    showNotification("Network error occurred", "error");
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

  xhr.onerror = function () {
    showNotification("Network error occurred", "error");
  };

  xhr.send("action=delete_review&rid=" + rid);
}

// Show notification
function showNotification(message, type) {
  // Create notification element
  const notification = document.createElement("div");
  notification.className = `fixed top-20 right-4 z-50 px-6 py-4 rounded-lg shadow-lg transition-all duration-300 transform translate-x-0 ${
    type === "success" ? "bg-green-500 text-white" : "bg-red-500 text-white"
  }`;
  notification.innerHTML = `
        <div class="flex items-center gap-3">
            <img src="./public/images/web/${
              type === "success" ? "correct" : "crossG"
            }.png" class="w-5 h-5 ${type === "success" ? "" : "invert"}" alt="">
            <span class="font-medium">${message}</span>
        </div>
    `;

  document.body.appendChild(notification);

  // Slide in animation
  setTimeout(() => {
    notification.style.transform = "translateX(0)";
  }, 10);

  // Remove after 3 seconds
  setTimeout(() => {
    notification.style.transform = "translateX(400px)";
    setTimeout(() => {
      notification.remove();
    }, 300);
  }, 3000);
}

// Search functionality (optional enhancement)
function searchTable(inputId, tableId) {
  const input = document.getElementById(inputId);
  const filter = input.value.toLowerCase();
  const table = document.getElementById(tableId);
  const rows = table.getElementsByTagName("tr");

  for (let i = 1; i < rows.length; i++) {
    let found = false;
    const cells = rows[i].getElementsByTagName("td");

    for (let j = 0; j < cells.length; j++) {
      if (cells[j].textContent.toLowerCase().indexOf(filter) > -1) {
        found = true;
        break;
      }
    }

    rows[i].style.display = found ? "" : "none";
  }
}

// Initialize on page load
document.addEventListener("DOMContentLoaded", function () {
  console.log("Admin dashboard loaded");

  // Add smooth scrolling to top button
  const scrollBtn = document.createElement("button");
  scrollBtn.innerHTML = `
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
        </svg>
    `;
  scrollBtn.className =
    "fixed bottom-8 right-8 bg-yellow-400 hover:bg-yellow-500 text-white p-3 rounded-full shadow-lg transition-all duration-300 opacity-0 pointer-events-none";
  scrollBtn.id = "scrollToTop";

  document.body.appendChild(scrollBtn);

  // Show/hide scroll button
  window.addEventListener("scroll", () => {
    if (window.pageYOffset > 300) {
      scrollBtn.classList.remove("opacity-0", "pointer-events-none");
    } else {
      scrollBtn.classList.add("opacity-0", "pointer-events-none");
    }
  });

  // Scroll to top on click
  scrollBtn.addEventListener("click", () => {
    window.scrollTo({
      top: 0,
      behavior: "smooth",
    });
  });

  // Add table row hover effects
  document.querySelectorAll("tbody tr").forEach((row) => {
    row.addEventListener("mouseenter", function () {
      this.classList.add("bg-gray-50");
    });
    row.addEventListener("mouseleave", function () {
      this.classList.remove("bg-gray-50");
    });
  });
});

// Export statistics (optional feature)
function exportStatistics() {
  // This would generate a CSV or PDF of statistics
  showNotification("Export feature coming soon!", "success");
}

// Refresh statistics
function refreshStats() {
  location.reload();
}
