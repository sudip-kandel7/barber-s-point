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
              // location.reload();
              document.getElementById(
                "abpending"
              ).innerHTML = `<div class="text-center py-16">
                    <img src="./public/images/web/empty.png" class="w-24 h-24 mx-auto mb-4 opacity-50" alt="">
                    <p class="text-gray-500 text-lg">No pending approvals</p>
                </div>`;
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
  alert(sid);
  const xhr = new XMLHttpRequest();
  xhr.open("POST", "dashboard.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      try {
        const response = JSON.parse(xhr.responseText);
        if (response.status === "success") {
          const shopRow = document.getElementById("shop-row-" + sid);
          if (shopRow) {
            setTimeout(() => {
              shopRow.remove();
              const shopList = document.getElementById("shopslist").children;
              if (shopList.length < 1) {
                // location.reload();
                document.getElementById(
                  "abshops"
                ).innerHTML = `<p class="text-center text-gray-500">No shops found</p>`;
              }
            }, 300);
          }
        }
      } catch (e) {
        console.error("JSON Parse Error:", e);
        console.error("Response:", xhr.responseText);
      }
    }
  };
  xhr.send("action=delete_shop&sid=" + sid);
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

  xhr.send("action=suspend_user&uid=" + uid);
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
            const list = document.getElementById("userlist").children;
            if (list.length < 1) {
              // location.reload();
              document.getElementById(
                "abusers"
              ).innerHTML = ` <p class="text-center text-gray-500">No users found</p>`;
            }
          }, 300);
        }
      }
    }
  };

  xhr.send("action=delete_user&uid=" + uid);
}

function deleteReview(rid) {
  const xhr = new XMLHttpRequest();
  xhr.open("POST", "dashboard.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  xhr.onreadystatechange = function () {
    if (xhr.readyState == 4 && xhr.status === 200) {
      const response = JSON.parse(xhr.responseText);
      if (response.status === "success") {
        const reviewDiv = document.getElementById("review-" + rid);
        if (reviewDiv) {
          setTimeout(() => {
            reviewDiv.remove();
            const list = document.getElementById("abreviews").children;
            if (list.length <= 2) {
              // location.reload();
              document.getElementById(
                "abreviews"
              ).innerHTML = `<p class="text-center text-gray-500">No reviews found</p>`;
            }
          }, 300);
        }
      }
    }
  };

  xhr.send("action=delete_review&rid=" + rid);
}
