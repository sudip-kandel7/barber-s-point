checkErrors();
checkShopErrors();

function switchInfo(wch) {
  document.querySelectorAll(".infoD").forEach((div) => {
    div.classList.add("hidden");
  });

  document.querySelectorAll(".info-btn").forEach((btn) => {
    btn.classList.remove("bg-yellow-400", "text-white");
    btn.classList.add("hover:bg-gray-100", "text-gray-700");

    const img = btn.querySelector("img");
    if (img) {
      img.src = `./public/images/web/${btn.id}B.png`;
    }
  });

  const activeDiv = document.getElementById(wch + "D");
  if (activeDiv) {
    activeDiv.classList.remove("hidden");
  }

  const activeBtn = document.getElementById(wch);
  activeBtn.classList.remove("hover:bg-gray-100", "text-gray-700");
  activeBtn.classList.add("bg-yellow-400", "text-white");

  const activeImg = activeBtn.querySelector("img");
  if (activeImg) {
    activeImg.src = `./public/images/web/${wch}W.png`;
  }
}

const form = document.getElementById("profileForm");
const originalEmail = document.getElementById("bemail").dataset.original;

form.addEventListener("input", (e) => {
  const input = e.target;
  const name = input.name;
  const value = input.value.trim();
  const p = document.getElementById(name + "Err");

  if (value === "") {
    p.innerText = "";
    checkErrors();
    return;
  }

  if (name === "bemail") {
    if (!/^[a-zA-Z][a-zA-Z0-9._-]*@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(value)) {
      p.innerText = "Please enter valid email!";
    } else {
      p.innerText = "";

      if (value !== originalEmail) {
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "emailCheck.php", true);
        xhr.setRequestHeader(
          "Content-Type",
          "application/x-www-form-urlencoded"
        );

        xhr.onreadystatechange = function () {
          if (xhr.readyState === 4 && xhr.status === 200) {
            if (xhr.responseText.trim() === "exists") {
              p.innerText = "Email already exists!";
            } else {
              p.innerText = "";
            }
            checkErrors();
          }
        };

        xhr.send("email=" + value);
      }
    }
  }

  if (name === "bname") {
    if (!/^(?=.{2,20}$)[A-Za-z]+(?:\s[A-Za-z]+)*$/.test(value)) {
      p.innerText = "Name must have only letters and (2,20) words.";
    } else {
      p.innerText = "";
    }
  }

  if (name === "bphone") {
    let e = value.slice(2);

    if (/\D/.test(value)) {
      p.innerText = "Phone number must contain only digits.";
    } else if (!value.startsWith("98") && !value.startsWith("97")) {
      p.innerText = "Phone number must start with 98 or 97.";
    } else if (value.length !== 10) {
      p.innerText = "Phone number must be exactly 10 digits.";
    } else if (/^(\d)\1*$/.test(e)) {
      p.innerText = "The remaining part has repeated digits.";
    } else {
      p.innerText = "";
    }
  }

  if (name === "baddress") {
    const pattern = /^[A-Za-z][A-Za-z0-9\-, ]*$/;
    if (!pattern.test(value)) {
      p.innerText = "Must start with letters or only - and , are allowed!";
    } else if (value.length > 25) {
      p.innerText = "Letters must be less than 25!";
    } else {
      p.innerText = "";
    }
  }

  checkErrors();
});

function checkErrors() {
  const btn = document.getElementById("shopPbtn");
  const errorMessages = document.querySelectorAll(
    "#profileForm p.text-red-600"
  );
  let hasError = false;

  errorMessages.forEach((p) => {
    if (p.innerText.trim() !== "") {
      hasError = true;
    }
  });

  if (btn) {
    btn.disabled = hasError;
    if (hasError) {
      btn.className =
        "flex justify-center items-center gap-2 bg-gray-400 hover:bg-gray-500 p-3 text-black rounded-lg font-semibold transition-all cursor-not-allowed opacity-60";
    } else {
      btn.className =
        "flex items-center justify-center gap-2 bg-yellow-400 hover:bg-yellow-500 text-white p-3 rounded-lg font-semibold transition-all";
    }
  }
}

const shopForm = document.getElementById("shopForm");

shopForm.addEventListener("input", (e) => {
  const input = e.target;
  const name = input.name;
  const value = input.value.trim();
  const p = document.getElementById(name + "Err");

  if (value === "") {
    p.innerText = "";
    checkShopErrors();
    return;
  }

  if (name === "sname") {
    const pattern = /^[A-Za-z][A-Za-z ]*$/;
    if (!pattern.test(value)) {
      p.innerText = "Must start with and only contain letters!";
    } else if (value.length > 25) {
      p.innerText = "Letters must be less than 25!";
    } else {
      p.innerText = "";
    }
  }

  if (name === "saddress") {
    const pattern = /^[A-Za-z][A-Za-z0-9\-, ]*$/;
    if (!pattern.test(value)) {
      p.innerText = "Must start with letters or only - and , are allowed!";
    } else if (value.length > 25) {
      p.innerText = "Letters must be less than 25!";
    } else {
      p.innerText = "";
    }
  }

  checkShopErrors();
});

document.getElementById("photo").addEventListener("change", function () {
  const file = this.files[0];
  const maxSize = 5 * 1024 * 1024;
  const p = document.getElementById("photoErr");

  if (file && file.size > maxSize) {
    p.innerText = "File size must be less than 5MB!";
    this.value = "";
    checkShopErrors();
  } else {
    p.innerText = "";
    checkShopErrors();
  }
});

function checkShopErrors() {
  const btn = document.getElementById("shopUpdateBtn");
  const errorMessages = document.querySelectorAll("#shopForm p.text-red-600");
  let hasError = false;

  errorMessages.forEach((p) => {
    if (p.innerText.trim() !== "") {
      hasError = true;
    }
  });

  if (btn) {
    btn.disabled = hasError;
    if (hasError) {
      btn.className =
        "flex justify-center items-center gap-2 bg-gray-400 hover:bg-gray-500 p-3 text-black rounded-lg font-semibold transition-all cursor-not-allowed opacity-60";
    } else {
      btn.className =
        "flex items-center justify-center gap-2 bg-yellow-400 hover:bg-yellow-500 text-white p-3 rounded-lg font-semibold transition-all";
    }
  }
}

document
  .getElementById("service_select")
  .addEventListener("change", function () {
    const newServiceDiv = document.getElementById("newServiceDiv");
    const newServiceInput = document.getElementById("new_service_name");

    if (this.value === "new") {
      newServiceDiv.classList.remove("hidden");
      newServiceInput.required = true;
    } else {
      newServiceDiv.classList.add("hidden");
      newServiceInput.required = false;
      newServiceInput.value = "";
      document.getElementById("newServiceErr").innerText = "";
    }
    checkAddServiceErrors();
  });

const addServiceForm = document.getElementById("addServiceForm");

addServiceForm.addEventListener("input", (e) => {
  const input = e.target;
  const name = input.name;
  const value = input.value.trim();

  if (name === "new_service_name") {
    const p = document.getElementById("newServiceErr");
    const pattern = /^[A-Za-z][A-Za-z ]*$/;
    if (value === "") {
      p.innerText = "";
    } else if (!pattern.test(value)) {
      p.innerText = "Must start with and only contain letters!";
    } else if (value.length > 20) {
      p.innerText = "Service name must be less than 20 characters!";
    } else {
      p.innerText = "";
    }
  }

  if (name === "price") {
    const p = document.getElementById("priceErr");
    if (value === "") {
      p.innerText = "";
    } else if (parseInt(value) < 1) {
      p.innerText = "Price must not be negative!";
    } else if (parseInt(value) > 10000) {
      p.innerText = "Price must be less than 10,000!";
    } else {
      p.innerText = "";
    }
  }

  if (name === "duration") {
    const p = document.getElementById("durationErr");
    if (value === "") {
      p.innerText = "";
    } else if (parseInt(value) < 1) {
      p.innerText = "Duration must not be negative!";
    } else if (parseInt(value) > 300) {
      p.innerText = "Duration must be less than 300 minutes!";
    } else {
      p.innerText = "";
    }
  }

  checkAddServiceErrors();
});

function checkAddServiceErrors() {
  const btn = document.getElementById("addServiceBtn");
  const errorMessages = document.querySelectorAll(
    "#addServiceForm p.text-red-600"
  );
  let hasError = false;

  errorMessages.forEach((p) => {
    if (p.innerText.trim() !== "") {
      hasError = true;
    }
  });

  if (btn) {
    btn.disabled = hasError;
    if (hasError) {
      btn.className =
        "flex justify-center items-center gap-2 bg-gray-400 hover:bg-gray-500 text-white px-6 py-3 rounded-lg font-semibold transition-all cursor-not-allowed opacity-60";
    } else {
      btn.className =
        "flex items-center justify-center gap-2 bg-yellow-400 hover:bg-yellow-500 text-white px-6 py-3 rounded-lg font-semibold transition-all";
    }
  }
}
