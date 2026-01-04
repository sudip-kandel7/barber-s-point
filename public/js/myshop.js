function switchDiv(wch) {
  document.querySelectorAll(".divs").forEach((content) => {
    content.classList.add("hidden");
  });

  document.querySelectorAll(".btn").forEach((btn) => {
    btn.classList.remove("border-yellow-400", "text-yellow-500", "border-b-2");
    btn.classList.add("text-gray-600", "hover:text-gray-900");
  });

  document.getElementById("D" + wch).classList.remove("hidden");

  const activeTab = document.getElementById(wch);
  activeTab.classList.remove("text-gray-600");
  activeTab.classList.add("border-yellow-400", "text-yellow-500", "border-b-2");
}

function toggleStatus(status) {
  const newStatus = status === "open" ? "closed" : "open";

  const xhr = new XMLHttpRequest();
  xhr.open("POST", "myshop.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      const response = JSON.parse(xhr.responseText);
      if (response.status === "success") {
        location.reload();
      } else {
        alert(response.msg);
      }
    }
  };

  xhr.send("status=" + newStatus);
}

function startService(bid) {
  const xhr = new XMLHttpRequest();
  xhr.open("POST", "myshop.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  xhr.onload = function () {
    if (xhr.status === 200) {
      const response = JSON.parse(xhr.responseText);
      if (response.status === "success") {
        location.reload();
      } else {
        alert(response.msg);
      }
    }
  };

  xhr.send("action=start_service&bid=" + bid);
}

function completeService(bid, totalD) {
  const xhr = new XMLHttpRequest();
  xhr.open("POST", "myshop.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      const response = JSON.parse(xhr.responseText);
      if (response.status === "success") {
        location.reload();
      } else {
        alert(response.msg);
      }
    }
  };

  xhr.send("bid=" + bid + "&totalD=" + totalD);
}
