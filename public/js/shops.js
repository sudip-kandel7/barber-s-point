// Global variable to store current shop ID
let currentShopId = null;

document.addEventListener("DOMContentLoaded", () => {
  const btn1 = document.getElementsByClassName("filter")[0];
  const btn2 = document.getElementsByClassName("sort")[0];

  const filterList = document.getElementsByClassName("list1")[0];
  const sortList = document.getElementsByClassName("list2")[0];

  btn1.addEventListener("click", () => {
    filterList.classList.toggle("hidden");
    sortList.classList.add("hidden");
  });

  btn2.addEventListener("click", () => {
    filterList.classList.add("hidden");
    sortList.classList.toggle("hidden");
  });

  const filterOpts = document.querySelectorAll(".fOption");
  const filterText = document.querySelector(".filter p");

  let selected1 = filterOpts[0];

  selected1.classList.add("bg-yellow-100");
  selected1.querySelector("img").classList.remove("opacity-0");

  filterOpts.forEach((opt) => {
    opt.addEventListener("click", () => {
      filterText.innerText = opt.querySelector("p").innerText;
      filterList.classList.add("hidden");

      filterOpts.forEach((o) => {
        o.classList.remove("bg-yellow-100");
        o.querySelector("img").classList.add("opacity-0");
      });

      selected1 = opt;
      selected1.classList.add("bg-yellow-100");
      selected1.querySelector("img").classList.remove("opacity-0");
    });
  });

  const sortOpts = document.querySelectorAll(".sOption");
  const sortText = document.querySelector(".sort p");

  let selected2 = sortOpts[0];

  selected2.classList.add("bg-yellow-100");
  selected2.querySelector("img").classList.remove("opacity-0");

  sortOpts.forEach((opt) => {
    opt.addEventListener("click", () => {
      sortText.innerText = opt.querySelector("p").innerText;
      sortList.classList.add("hidden");

      sortOpts.forEach((o) => {
        o.classList.remove("bg-yellow-100");
        o.querySelector("img").classList.add("opacity-0");
      });

      selected2 = opt;
      selected2.classList.add("bg-yellow-100");
      selected2.querySelector("img").classList.remove("opacity-0");
    });
  });
});

// View details button
function view(sid) {
  // alert(sid);
  const xhr = new XMLHttpRequest();
  xhr.open("GET", "shopdetails.php?sid=" + sid);

  xhr.onload = function () {
    if (xhr.status === 200) {
      // alert("ok");
      document.body.insertAdjacentHTML("beforeend", xhr.responseText);
    }
  };

  xhr.send();
}

// book appointment

function bookapp(sid) {
  // alert(sid);
  const xhr = new XMLHttpRequest();
  xhr.open("GET", "book_services.php?sid=" + sid);

  xhr.onload = function () {
    if (xhr.status === 200) {
      document.body.insertAdjacentHTML("beforeend", xhr.responseText);
    }
  };

  xhr.send();
}

// remove view detail overlay or book overlay
document.addEventListener("click", function (e) {
  if (e.target && e.target.id === "shopOverlay") {
    e.target.remove();
    window.location.reload();
    return;
  }

  if (e.target && e.target.id === "bookOverlay") {
    e.target.remove();
    return;
  }
});

function toggleTab(btn) {
  const btnServices = document.getElementsByClassName("services")[0];
  const btnReviews = document.getElementsByClassName("reviews")[0];

  if (btn === "services") {
    btnServices.classList.add("bg-white", "text-black");
    btnServices.classList.remove("text-gray-600");

    document
      .getElementsByClassName("servicesDetails")[0]
      .classList.remove("hidden");
    document
      .getElementsByClassName("reviewsDetails")[0]
      .classList.add("hidden");

    btnReviews.classList.remove("bg-white", "text-black");
    btnReviews.classList.add("text-gray-600");
  } else if (btn === "reviews") {
    btnReviews.classList.add("bg-white", "text-black");
    btnReviews.classList.remove("text-gray-600");

    document
      .getElementsByClassName("servicesDetails")[0]
      .classList.add("hidden");
    document
      .getElementsByClassName("reviewsDetails")[0]
      .classList.remove("hidden");

    btnServices.classList.remove("bg-white", "text-black");
    btnServices.classList.add("text-gray-600");
  }
}

function addfav(btn) {
  const favimg = document.getElementById("favimg");
  let sid = btn.dataset.sid;
  let saved = btn.dataset.saved === "true";
  console.log(sid);
  console.log(saved);
  console.log(typeof saved);

  const xhr = new XMLHttpRequest();
  xhr.open("POST", "addfavorite.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  xhr.onload = function () {
    if (xhr.status === 200) {
      const res = JSON.parse(xhr.responseText);

      if (res.status === "success") {
        if (!saved) {
          favimg.src = "./public/images/web/saved.png";
          btn.dataset.saved = "true";
        } else {
          favimg.src = "./public/images/web/save.png";
          btn.dataset.saved = "false";
        }
      } else {
        alert(res.msg);
      }
    }
  };

  xhr.send("sid=" + sid + "&status=" + saved);
}

// check if any checkbox clicked also changed total dur and price

function booking(sid, price, duration) {
  // alert(sid + " " + price + " " + duration);

  price = parseInt(price);
  duration = parseInt(duration);

  const boxes = document.querySelectorAll(".checkboxes");
  const btn = document.getElementById("bookbtn");
  let dur = document.getElementById("duration");
  let p = document.getElementById("price");

  let currentD = parseInt(dur.innerText);
  let currentP = parseInt(p.innerText);

  const checkbox = event.target;
  if (checkbox.checked) {
    currentD += duration;
    currentP += price;
  } else {
    currentD -= duration;
    currentP -= price;
  }

  dur.innerText = currentD;
  p.innerText = currentP;

  let anyChecked;
  boxes.forEach((box) => {
    if (box.checked) {
      anyChecked = true;
    }

    if (anyChecked) {
      btn.disabled = false;
      btn.innerText = "Confirm Booking";
      btn.classList.remove(
        "bg-gray-200",
        "text-gray-500",
        "hover:cursor-not-allowed"
      );
      btn.classList.add("bg-green-500", "text-white", "hover:cursor-pointer");
    } else {
      btn.disabled = true;
      btn.innerText = "Select at least one service";
      btn.classList.remove(
        "bg-green-500",
        "text-white",
        "hover-cursor-pointer"
      );
      btn.classList.add(
        "bg-gray-200",
        "text-gray-500",
        "hover:cursor-not-allowed"
      );
    }
  });
  anyChecked = false;
}

// booking

function adding(sid) {
  const boxes = document.querySelectorAll(".checkboxes");
  const selected = [];
  let totalD = 0;
  let totalP = 0;
  boxes.forEach((box) => {
    if (box.checked) {
      totalD += parseInt(box.dataset.duration);
      totalP += parseInt(box.dataset.price);
      selected.push({
        serviceId: box.dataset.serviceId,
        serviceName: box.dataset.serviceName,
        price: parseInt(box.dataset.price),
        duration: parseInt(box.dataset.duration),
      });
    }
  });

  // console.log({
  //   shopId: sid,
  //   services: selected,
  //   totalPrice: totalP,
  //   totalDuration: totalD,
  // });

  // insert to db now

  xhr = new XMLHttpRequest();

  xhr.open("POST", "update_queue.php", true);
  xhr.onreadystatechange = function () {
    if (xhr.readyState == 4 && xhr.status === 200) {
      const res = JSON.parse(xhr.responseText);
      const bookOverlay = document.getElementById("bookOverlay");
      if (res.status === "good") {
        // alert(res.msg);
        showPopup("already");
        bookOverlay.remove();
      }
      if (res.status === "success") {
        // alert(res.msg);
        showPopup("booked");
        bookOverlay.remove();
      }
      if (res.status === "err") {
        // alert(res.msg);
        showPopup("error");
        bookOverlay.remove();
      }
      if (res.status === "not") {
        showPopup("login");
        bookOverlay.remove();
      }
    }
  };
  xhr.send(
    JSON.stringify({
      sid: sid,
      selected: selected,
      totalDuration: totalD,
      totalPrice: totalP,
    })
  );
}

function showPopup(type) {
  const xhr = new XMLHttpRequest();
  xhr.open("GET", "pop_up.php?txt=" + type, true);
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      document.body.insertAdjacentHTML("beforeend", xhr.responseText);
      setTimeout(() => {
        const popup = document.getElementById("popUpOverlay");
        popup.remove();
      }, 2000);
    }
  };
  xhr.send();
}
