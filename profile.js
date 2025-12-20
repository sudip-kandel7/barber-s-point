function toggleDiv(btn) {
  let btnr = document.getElementById("myreview");
  let btnf = document.getElementById("myfav");
  let imgr = document.getElementById("imgr");
  let imgf = document.getElementById("imgf");
  let reviewD = document.getElementById("reviewD");
  let favD = document.getElementById("favD");

  if (btn === "review") {
    btnr.classList.add("text-black", "bg-[#f1f5f9]");
    btnr.classList.remove("text-gray-500");
    imgr.src = "./public/images/web/timeB.png";

    reviewD.classList.remove("hidden");
    favD.classList.add("hidden");

    btnf.classList.remove("text-black", "bg-[#f1f5f9]");
    btnf.classList.add("text-gray-500");
    imgf.src = "./public/images/web/favoriteG.png";
  } else if (btn === "fav") {
    btnr.classList.remove("text-black", "bg-[#f1f5f9]");
    btnr.classList.add("text-gray-500");
    imgr.src = "./public/images/web/time.png";
    reviewD.classList.add("hidden");

    favD.classList.remove("hidden");

    btnf.classList.add("text-black", "bg-[#f1f5f9]");
    btnf.classList.remove("text-gray-500");
    imgf.src = "./public/images/web/favoriteB.png";
  }
}

// function changer(btn) {
//   let edit = document.getElementsByClassName("edit")[0];
//   let remove = document.getElementsByClassName("delete")[0];
//   let imge = document.getElementById("imge");
//   let reviewi = btn.dataset.rid;
//   let editer = document.getElementById("editer");

//   if (btn === "edit") {
//     if (editer.innerText === "Edit") {
//       // Changed from .value to .innerText
//       reviewi.disabled = false;
//       editer.innerText = "Save";
//       imge.src = "./public/images/web/check.png";
//       reviewi.focus();
//     } else {
//       reviewi.disabled = true;
//       editer.innerText = "Edit";
//       newReview = reviewi.value;
//       let xhr = new XMLHttpRequest();
//       xhr.open(
//         "GET",
//         "profile.php?review=" +
//           encodeURIComponent(newReview) +
//           "&rid=" +
//           encodeURIComponent(reviewi),
//         true
//       );

// xhr.onreadystatechange = function () {
//   if (xhr.readyState === 4) {
//     if (xhr.status === 200) {
//       try {
//         const response = JSON.parse(xhr.responseText);

//         if (response.status === "success") {
//           console.log("Review updated successfully");
//         } else {
//           console.error(
//             "Server error:",
//             response.message || "Unknown error"
//           );
//         }
//       } catch (e) {
//         console.error("Invalid JSON response:", xhr.responseText);
//       }
//     } else {
//       console.error("HTTP error:", xhr.status);
//     }
//   }
// };

//       xhr.send();
//     }
//     imge.src = "./public/images/web/edit.png";
//   }
// }

function changer(btn, wch) {
  let rid = btn.dataset.rid;

  let review = document.getElementById("review" + rid);

  if (wch === "edit") {
    let img = document.getElementsByClassName("srce")[0];
    let spne = document.getElementsByClassName("edit")[0];

    if (spne.innerText === "Edit") {
      spne.innerText = "Save";
      img.src = "./public/images/web/check.png";
      review.disabled = false;
      review.focus();
    } else {
      let newReview = review.value;
      let xhr = new XMLHttpRequest();
      xhr.open(
        "GET",
        "profile.php?review=" +
          encodeURIComponent(newReview) +
          "&rid=" +
          encodeURIComponent(rid),
        true
      );

      xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
          if (xhr.status === 200) {
            try {
              const response = JSON.parse(xhr.responseText);

              if (response.status === "success") {
                console.log("Review updated successfully");
              } else {
                console.error(
                  "Server error:",
                  response.message || "Unknown error"
                );
              }
            } catch (e) {
              console.error("Invalid JSON response:", xhr.responseText);
            }
          } else {
            console.error("HTTP error:", xhr.status);
          }
        }
      };

      xhr.send();

      spne.innerText = "Edit";
      review.disabled = true;
      img.src = "./public/images/web/edit.png";
    }
  } else if (wch === "delete") {
    let rid = btn.dataset.rid;
    let xhr = new XMLHttpRequest();
    xhr.open("GET", "profile.php?rid=" + encodeURIComponent(rid), true);

    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4) {
        if (xhr.status === 200) {
          try {
            const response = JSON.parse(xhr.responseText);

            if (response.status === "success") {
              location.reload();
            } else {
              console.error(
                "Server error:",
                response.message || "Unknown error"
              );
            }
          } catch (e) {
            console.error("Invalid JSON response:", xhr.responseText);
          }
        } else {
          console.error("HTTP error:", xhr.status);
        }
      }
    };

    xhr.send();
  }
}

// view detail
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
function viewf(btn) {
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

// function changer(btn) {
//   let review = document.getElementById(review1);

//   if (btn === "edit") {
//   }
// }
