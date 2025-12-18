document.addEventListener("DOMContentLoaded", () => {
  //  hide and show filter and sort lists

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

  // change filter value and img on click

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

  // change sort value and img on click

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

// close dropdown when clicked outside

// view detials button

// Services and reviews button color change on click

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

// view details button
function view(btn) {
  const sid = btn.dataset.sid;
  const name = btn.dataset.name;
  const address = btn.dataset.address;
  const photo = btn.dataset.photo;
  const status = btn.dataset.status;

  const showD = document.getElementsByClassName("showD")[0];
  const servicesDiv = document.getElementsByClassName("servicesDetails")[0];

  let xhr = new XMLHttpRequest();
  xhr.open("GET", "shops.php?sid=" + encodeURIComponent(sid), true);

  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      try {
        const response = JSON.parse(xhr.responseText);

        if (response.status === "success") {
          showD.classList.remove("hidden");
          setTimeout(() => {
            showD.classList.remove("opacity-0", "scale-x-0");
          }, 10);

          document.getElementById("sname").innerText = name;
          document.getElementById("saddress").innerText = address;
          const backgroundDiv = document.getElementById("shopBg");
          backgroundDiv.style.backgroundImage = `linear-gradient(to right, rgba(255,255,255,0.8), rgba(255,255,255,0.8)), url('${photo}')`;
          backgroundDiv.style.backgroundPosition = "center";
          backgroundDiv.style.backgroundSize = "cover";
          backgroundDiv.style.backgroundRepeat = "no-repeat";
          document.getElementById("status").innerText = status;
          document.getElementById("review").innerText = response.shop
            .total_reviews
            ? response.shop.total_reviews + " Reviews"
            : "No Reviews";

          document.getElementById("queue").innerText =
            response.shop.current_queue > 1
              ? response.shop.current_queue + " People"
              : response.shop.current_queue + " Person";

          document.getElementById("wait").innerText =
            response.shop.total_wait_time > 1
              ? response.shop.total_wait_time + " Mins"
              : response.shop.total_wait_time + " Min";

          servicesDiv.innerHTML = "";
          servicesDiv.classList.remove("hidden");

          if (response.services && response.services.length > 0) {
            response.services.forEach((service) => {
              servicesDiv.innerHTML += `
                <div class="border rounded-md w-full border-gray-500 flex flex-col sm:flex-row sm:justify-between sm:items-center px-3 py-3 mb-3 gap-2">
                  <div>
                    <p class="font-medium">${service.services_name}</p>
                    <p class="text-sm text-gray-400">${service.duration} mins</p>
                  </div>
                  <p class="font-semibold text-yellow-400">Rs. ${service.price}</p>
                </div>
              `;
            });
          } else {
            servicesDiv.innerHTML =
              "<p class='text-center mb-2 text-2xl text-gray-400'>No services available.</p>";
          }

          const reviewsDiv =
            document.getElementsByClassName("reviewsDetails")[0];
          reviewsDiv.innerHTML = "";
          reviewsDiv.classList.add("hidden");

          if (response.reviews && response.reviews.length > 0) {
            response.reviews.forEach((review) => {
              reviewsDiv.innerHTML += `
                <div class="border rounded-md w-full border-gray-500
flex flex-col px-3 py-3 mb-3 gap-1">

                <div class="flex items-center gap-3">
                  <img src="./public/images/web/profile.png" alt="user icon" class="w-10 h-10 rounded-full"/>
                   <div>
                    <p class="font-medium">${review.name}</p>
                    <p class="text-sm text-gray-400 mb-2">${review.date}</p>
                   </div>
                </div>
                  <p>${review.review_text}</p>
                </div>
              `;
            });
          } else {
            reviewsDiv.innerHTML =
              "<p class='text-center mb-2 text-2xl text-gray-400'>No reviews available.</p>";
          }
        }
      } catch (e) {
        console.error("JSON error:", xhr.responseText);
      }
    }
  };

  document.addEventListener("click", (event) => {
    if (!showD.contains(event.target) && event.target !== btn) {
      showD.classList.add("opacity-0", "scale-x-0");
      setTimeout(() => {
        showD.classList.add("hidden");
      }, 500);
    }
  });

  xhr.send();
}
