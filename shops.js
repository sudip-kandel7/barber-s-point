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
  alert(sid);
  const xhr = new XMLHttpRequest();
  xhr.open("GET", "shopdetails.php?sid=" + sid);

  xhr.onload = function () {
    if (xhr.status === 200) {
      document.body.insertAdjacentHTML("beforeend", xhr.responseText);
    }
  };

  xhr.send();
}

document.addEventListener("click", function (e) {
  const overlay = document.getElementById("shopOverlay");
  const modal = document.getElementById("shopModal");
  const fav = document.getElementById("fav");

  if (!overlay || !modal) return;

  if (e.target === overlay) {
    // alert("ok");
    overlay?.remove();
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

function addfav(sid) {
  // alert(sid);
  const favimg = document.getElementById("favimg");
  const xhr = new XMLHttpRequest();
  xhr.open("POST", "addfavorite.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function () {
    if (xhr.status === 200) {
      const res = JSON.parse(xhr.responseText);
      if (res.status === "success") {
        if (favimg) favimg.src = "./public/images/web/saved.png";
      } else {
        alert(res.message || "Already in favorites");
      }
    }
  };
  xhr.send("sid=" + sid);
}

// book appointment

function bookapp(sid) {
  alert(sid);
}
