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

function changer(btn, wch) {
  let rid = btn.dataset.rid;

  let review = document.getElementById("review" + rid);

  if (wch === "edit") {
    // alert("ok");
    let img = document.getElementById("scrE" + rid);
    let spnE = document.getElementById("edit" + rid);

    if (spnE.innerText === "Edit") {
      spnE.innerText = "Save";
      img.src = "./public/images/web/check.png";
      review.disabled = false;
      review.focus();
    } else {
      let newReview = review.value;
      let xhr = new XMLHttpRequest();
      xhr.open("GET", "profile.php?review=" + newReview + "&rid=" + rid, true);

      xhr.onload = function () {
        if (xhr.readyState === 4) {
          if (xhr.status === 200) {
            try {
              const response = JSON.parse(xhr.responseText);

              if (response.status === "success") {
                console.log("Review updated successfully");
              } else {
                console.error("Server error:", response.message);
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

      spnE.innerText = "Edit";
      review.disabled = true;
      img.src = "./public/images/web/edit.png";
    }
  } else if (wch === "delete") {
    let rid = btn.dataset.rid;
    let xhr = new XMLHttpRequest();
    xhr.open("GET", "profile.php?rid=" + rid, true);

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

// view details button to show overaly

function viewf(sid) {
  // alert(sid);
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
    overlay?.remove();
  }
});

document.addEventListener("DOMContentLoaded", function () {
  const profileD = document.getElementById("overlayp");
  const editp = document.getElementById("editp");

  editp.addEventListener("click", () => {
    profileD.classList.remove("hidden");
  });

  profileD.addEventListener("click", () => {
    profileD.classList.add("hidden");
  });
});

// profile overaly
function viewp() {
  const xhr = new XMLHttpRequest();
  xhr.open("GET", "update_profile.php");
  xhr.onload = function () {
    if (xhr.status === 200) {
      document.body.insertAdjacentHTML("beforeend", xhr.responseText);
    }
  };
  xhr.send();
}

document.addEventListener("click", function (e) {
  const overlayp = document.getElementById("overlayp");
  const modal = document.getElementById("profileModal");

  if (!overlayp || !modal) return;

  if (e.target === overlayp) {
    overlayp?.remove();
  }
});

// delete from favorite

function removefav(sid) {
  alert(sid);
  const xhr = new XMLHttpRequest();
  xhr.open("POST", "profile.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.onload = function () {
    if (xhr.status === 200) {
      const res = JSON.parse(xhr.responseText);
      if (res.status === "success") {
        alert("removed");
      } else {
        alert(res.message || "not removed");
      }
    }
  };
  xhr.send("sid=" + sid);
}

function review(sid) {
  alert(sid);
  let reviewD = document.getElementsByClassName("reviewD")[0];
  let reviewtxt = document.getElementsByClassName("reviewtxt")[0];

  if (reviewtxt.value.trim().length === 0) {
    reviewD.classList.remove("border-gray-400");
    reviewD.classList.add("border-red-500");
    reviewtxt.focus();
    return;
  }

  const xhr = new XMLHttpRequest();
  xhr.open("POST", "add_review.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.onload = function () {
    if (xhr.status === 200) {
      const res = JSON.parse(xhr.responseText);
      if (res.status === "success") {
        alert("added");
        reviewtxt.value = "";
      } else {
        alert(res.message || "not added");
      }
    }
  };
  xhr.send("sid=" + sid + "&reviewtxt=" + reviewtxt.value);
}
