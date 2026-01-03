console.log("✅ profile.js loaded!");

function toggleDiv(btn) {
  let btnb = document.getElementById("mybooking");
  let btnr = document.getElementById("myreview");
  let btnf = document.getElementById("myfav");
  let imgb = document.getElementById("imgb");
  let imgr = document.getElementById("imgr");
  let imgf = document.getElementById("imgf");
  let bookingD = document.getElementById("bookingD");
  let reviewD = document.getElementById("reviewD");
  let favD = document.getElementById("favD");

  if (btn === "booking") {
    btnr.classList.remove("text-black", "bg-[#f1f5f9]");
    btnr.classList.add("text-gray-500");
    imgr.src = "./public/images/web/time.png";
    reviewD.classList.add("hidden");

    btnf.classList.remove("text-black", "bg-[#f1f5f9]");
    btnf.classList.add("text-gray-500");
    imgf.src = "./public/images/web/favoriteG.png";
    favD.classList.add("hidden");

    btnb.classList.remove("text-gray-500");
    btnb.classList.add("text-black", "bg-[#f1f5f9]");
    imgb.src = "./public/images/web/bookingB.png";
    bookingD.classList.remove("hidden");
  } else if (btn === "review") {
    btnb.classList.remove("text-black", "bg-[#f1f5f9]");
    btnb.classList.add("text-gray-500");
    imgb.src = "./public/images/web/bookingG.png";
    bookingD.classList.add("hidden");

    btnf.classList.remove("text-black", "bg-[#f1f5f9]");
    btnf.classList.add("text-gray-500");
    imgf.src = "./public/images/web/favoriteG.png";
    favD.classList.add("hidden");

    btnr.classList.remove("text-gray-500");
    btnr.classList.add("text-black", "bg-[#f1f5f9]");
    imgr.src = "./public/images/web/timeB.png";
    reviewD.classList.remove("hidden");
  } else if (btn === "fav") {
    btnb.classList.remove("text-black", "bg-[#f1f5f9]");
    btnb.classList.add("text-gray-500");
    imgb.src = "./public/images/web/bookingG.png";
    bookingD.classList.add("hidden");

    btnr.classList.remove("text-black", "bg-[#f1f5f9]");
    btnr.classList.add("text-gray-500");
    imgr.src = "./public/images/web/time.png";
    reviewD.classList.add("hidden");

    btnf.classList.remove("text-gray-500");
    btnf.classList.add("text-black", "bg-[#f1f5f9]");
    imgf.src = "./public/images/web/favoriteB.png";
    favD.classList.remove("hidden");
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
              const card = document.getElementById("review-shop-" + rid);
              card?.remove();

              const container = document.querySelector(".r");
              if (container && container.children.length === 0) {
                document.getElementById("reviewD").innerHTML = `
      <div class="text-center py-16">
        <img src="./public/images/web/empty.png" class="w-24 h-24 mx-auto mb-4 opacity-50" alt="">
        <p class="text-gray-500 text-lg">You haven't written any reviews yet</p>
        <p class="text-gray-400 text-sm mt-2">Visit a shop and share your experience!</p>
      </div>`;
              }
            } else {
              console.error(response.message);
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
// remove overlay if clicked ouside the modal or cancel button
document.addEventListener("click", function (e) {
  const overlayp = document.getElementById("overlayp");
  const cancel = document.getElementById("cancel");

  if (!overlayp) return;

  if (e.target === overlayp || e.target === cancel) {
    overlayp?.remove();
    window.location.reload();
  }
});

function review(sid) {
  // alert(sid);
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
    if (xhr.readyState == 4 && xhr.status === 200) {
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

// edited user info validate

// error check before form submitting
function checkErrors() {
  const saveBtn = document.querySelector('button[name="save"]');
  const errorMessages = document.querySelectorAll("p.text-red-600");
  let hasError = false;

  errorMessages.forEach((p) => {
    if (p.innerText.trim() !== "") {
      hasError = true;
    }
  });

  if (saveBtn) {
    saveBtn.disabled = hasError;

    if (hasError) {
      saveBtn.className =
        "px-4 py-2 rounded-lg flex justify-center items-center gap-2 bg-gray-200 text-black font-semibold cursor-not-allowed hover:bg-gray-300 opacity-60";
    } else {
      saveBtn.className =
        "px-4 py-2 rounded-lg flex items-center justify-center gap-2 bg-yellow-300 text-white font-semibold cursor-pointer hover:bg-yellow-400 ";
    }
  }
}
function validate(wch, val) {
  const value = val.value.trim();
  const err = document.querySelector(`p.${wch}`);

  if (wch === "name") {
    if (value === "") {
      err.innerText = "";
      return;
    }

    if (!/^[A-Za-z][A-Za-z\s]*$/.test(value)) {
      err.innerText =
        "Name must contain only letters and must not start with space.";
    } else {
      err.innerText = "";
    }
    checkErrors();
  } else if (wch === "email") {
    if (value === "") {
      err.innerText = "";
      return;
    }

    if (!/^[a-zA-Z][\w.-]*@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(value)) {
      err.innerText = "Please enter a valid email address.";
      return;
    }

    const x = new XMLHttpRequest();
    x.open("POST", "emailCheck.php", true);
    x.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    x.onload = function () {
      if (x.status === 200 && x.readyState === 4) {
        const response = x.responseText.trim();

        if (response === "exists") {
          err.innerText = "Email already exists!";
          val.style.border = "2px solid red";
        } else {
          err.innerText = "";
          val.style.border = "";
        }
      }
    };

    x.send("email=" + value);
    checkErrors();
  } else if (wch === "phone") {
    if (value === "") {
      err.innerText = "";
      return;
    }

    let e = value.slice(2);

    if (/\D/.test(value)) {
      err.innerText = "Phone number must contain only digits.";
    } else if (!value.startsWith("98") && !value.startsWith("97")) {
      err.innerText = "Phone number must start with 98 or 97.";
    } else if (value.length !== 10) {
      err.innerText = "Phone number must be exactly 10 digits.";
    } else if (/^(\d)\1*$/.test(e)) {
      err.innerText = "The remaining part has repeated digits.";
    } else {
      err.innerText = "";
    }
    checkErrors();
  } else if (wch === "address") {
    if (value === "") {
      err.innerText = "";
      return;
    }

    if (/^[\d,-]/.test(value)) {
      err.innerText = "Address cannot start with number, '-' or ','.";
      return;
    }

    if (!/^[A-Za-z0-9\s,.-]+$/.test(value)) {
      err.innerText = "Address contains invalid characters.";
      return;
    }

    const digitCount = (value.match(/\d/g) || []).length;
    if (digitCount > 2) {
      err.innerText = "Address can contain at most 2 numbers.";
      return;
    }

    const length = value.replace(/\s+/g, "").length;

    if (length < 3) {
      err.innerText = "Address must be at least 3 characters.";
    } else if (length > 25) {
      err.innerText = "Address must be 25 characters or less.";
    } else {
      err.innerText = "";
    }
    checkErrors();
  }
}

// update form submit function
// let overlayp = document.getElementById("overlayp");

// let updateform = document.getElementById("updateform");
// updateform.addEventListener("submit", (e) => {
//   e.preventDefault();

//   const formData = new FormData(e.target);
//   const xhr = new XMLHttpRequest();
//   xhr.open("POST", "update_profile.php", true);

//   xhr.onreadystatechange = function () {
//     if (xhr.readyState === 4 && xhr.status === 200) {
//       const resp = JSON.parse(xhr.responseText);
//       if (resp.status === "success") {
//         showPopup("updated");
//       } else if (resp.status === "error") {
//         overlayp.remove();
//         showPopup("notupdated");
//       }
//     }
//   };

//   xhr.send(formData);
// });

document.addEventListener("submit", function (e) {
  if (e.target.id === "updateform") {
    e.preventDefault();

    const formData = new FormData(e.target);
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "update_profile.php", true);

    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4) {
        if (xhr.status === 200) {
          try {
            console.log("Response:", xhr.responseText);
            const resp = JSON.parse(xhr.responseText);

            if (resp.status === "success") {
              const overlayp = document.getElementById("overlayp");
              overlayp?.remove();
              showPopup("updated");
              setTimeout(() => {
                window.location.reload();
              }, 500);
            } else if (resp.status === "error") {
              const overlayp = document.getElementById("overlayp");
              overlayp?.remove();
              showPopup("notupdated");
            }
          } catch (e) {
            console.error("JSON Parse Error:", e);
            console.error("Response was:", xhr.responseText);
            alert("Error: " + xhr.responseText);
          }
        } else {
          console.error("HTTP Error:", xhr.status);
          alert("HTTP Error: " + xhr.status);
        }
      }
    };

    xhr.send(formData);
  }
});

// ajax to call pop up php file

function showPopup(type) {
  const xhr = new XMLHttpRequest();
  xhr.open("GET", "pop_up.php?txt=" + type, true);
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      document.body.insertAdjacentHTML("beforeend", xhr.responseText);
      setTimeout(() => {
        const popup = document.getElementById("popUpOverlay");
        popup.remove();
      }, 400);
    }
  };
  xhr.send();
}

// cancel booking by a user

function cancelBooking(bid, sid, totalD) {
  const xhr = new XMLHttpRequest();
  xhr.open("POST", "cancel_booking.php", true);
  xhr.setRequestHeader("Content-Type", "application/json");

  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4) {
      console.log("Status:", xhr.status);
      console.log("Response:", xhr.responseText);

      if (xhr.status === 200) {
        try {
          const resp = JSON.parse(xhr.responseText);
          console.log("Parsed response:", resp);

          if (resp.status === "success") {
            alert("Booking cancelled successfully!");

            const bookingCard = document.getElementById(bid);
            if (bookingCard) {
              bookingCard.remove();
            }

            window.location.reload();
          } else {
            alert(
              "Error: " +
                (resp.msg || resp.message || "Could not cancel booking")
            );
          }
        } catch (e) {
          console.error("JSON Parse Error:", e);
          console.error("Response was:", xhr.responseText);
          alert("Error: Invalid response from server");
        }
      } else {
        alert("HTTP Error: " + xhr.status);
      }
    }
  };

  xhr.send(
    JSON.stringify({
      bid: bid,
      sid: sid,
      totalD: totalD,
    })
  );
}
