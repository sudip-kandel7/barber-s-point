// mine (not working)

let password1 = document.getElementById("pass1");
let toggle1 = document.getElementById("toggle1");

toggle1.addEventListener("click", () => {
  if (password1.type === "password") {
    password1.type = "text";
    toggle1.src = "./public/images/hide.png";
  } else {
    password1.type = "password";
    toggle1.src = "./public/images/visible.png";
  }
});

let toggle2 = document.getElementById("toggle2");
let password2 = document.getElementById("pass2");

toggle2.addEventListener("click", () => {
  if (password2.type === "password") {
    password2.type = "text";
    toggle2.src = "./public/images/hide.png";
  } else {
    password2.type = "password";
    toggle2.src = "./public/images/visible.png";
  }
});

// error check before form submitting

function checkErrors() {
  const createBtn = document.querySelector('button[name="create"]');
  const errorMessages = document.querySelectorAll("p.text-red-600");
  let hasError = false;

  errorMessages.forEach((p) => {
    if (p.innerText.trim() !== "") {
      hasError = true;
    }
  });

  if (createBtn) {
    createBtn.disabled = hasError;

    if (hasError) {
      createBtn.className =
        "flex justify-center items-center border rounded-xl w-full gap-3 py-3 text-xl font-medium bg-gray-400 cursor-not-allowed opacity-60";
    } else {
      createBtn.className =
        "flex justify-center items-center border bg-yellow-400 rounded-xl hover:bg-yellow-500 w-full gap-3 py-3 text-xl font-medium";
    }
  }
}

// div hide and show

let select = document.getElementById("select");
let barberinfo = document.getElementById("barberinfo");
const shopName = document.querySelector('input[name="sname"]');
const shopAddress = document.querySelector('input[name="address"]');
const shopPhotos = document.querySelector('input[name="photos"]');

select.addEventListener("change", () => {
  if (select.value === "barber") {
    barberinfo.classList.remove("hidden");
    barberinfo.classList.add("block");
    shopName.setAttribute("required", "required");
    shopAddress.setAttribute("required", "required");
    shopPhotos.setAttribute("required", "required");
  } else {
    barberinfo.classList.add("hidden");
    barberinfo.classList.remove("block");
    shopName.removeAttribute("required");
    shopAddress.removeAttribute("required");
    shopPhotos.removeAttribute("required");

    shopName.value = "";
    shopAddress.value = "";
    shopPhotos.value = "";
  }
});

// form validation frontend (js)

let form = document.getElementById("form");

if (form) {
  form.addEventListener("change", (e) => {
    e.preventDefault();

    const input = e.target;
    const name = input.name;
    // console.log(name);
    const value = input.value.trim();
    // console.log(value);

    const err = document.querySelector(`p.${name}`);

    const hasNumberOrSymbol = /[^a-zA-Z\s]/.test(value);
    const wordCount = value.split(/\s+/).filter(Boolean).length;

    let pass1 = document.querySelector('input[name="password"]');
    let pass2 = document.querySelector('input[name="cPassword"]');
    let p1 = document.getElementsByClassName("password")[0];
    let p2 = document.getElementsByClassName("cPassword")[0];

    // validate shop info in registation form

    if (name === "pType") {
      if (value === "barber")
        document.getElementsByClassName("photos").required = true;
      else document.getElementsByClassName("photos").required = false;
    }

    if (name === "firstN" || name === "lastN") {
      if (value === "") {
        err.innerText = "";
      } else if (hasNumberOrSymbol) {
        err.innerText = `${
          name === "firstN" ? "First" : "Last"
        } Name must contain only letters.`;
      } else {
        const length = value.replace(/\s+/g, "").length;

        if (length < 3) {
          err.innerText = `${
            name === "firstN" ? "First" : "Last"
          } Name must be at least 3 characters.`;
        } else if (length > 10) {
          err.innerText = `${
            name === "firstN" ? "First" : "Last"
          } Name must be 10 characters or less.`;
        } else {
          err.innerText = "";
        }
      }
    }

    if (name === "number") {
      if (value === "") {
        err.innerText = "";
      } else {
        let e = value.slice(2);
        if (!value.startsWith("98") && !value.startsWith("97")) {
          err.innerText = "Phone number must start with 98 or 97.";
        } else if (/\D/.test(value)) {
          err.innerText = "Phone number must contain only digits.";
        } else if (value.length != 10) {
          err.innerText = "Phone number must be exactly 10 digits.";
        } else if (/^(\d)\1*$/.test(e)) {
          err.innerText = "The remaining part has repeated digits.";
        } else {
          err.innerText = "";
        }
      }
    }

    if (name === "password") {
      if (value === "") {
        err.innerText = "";
        input.style.border = "";
        if (pass2.value === "") {
          p2.innerText = "";
          pass2.style.border = "";
        }
        setTimeout(checkErrors, 100);
        return;
      }

      if (!/[A-Z]/.test(value)) {
        err.innerText = "Password must contain at least one uppercase letter.";
        input.style.border = "2px solid red";
        setTimeout(checkErrors, 100);
        return;
      }
      if (!/[a-z]/.test(value)) {
        err.innerText = "Password must contain at least one lowercase letter.";
        input.style.border = "2px solid red";
        setTimeout(checkErrors, 100);
        return;
      }
      if (!/[0-9]/.test(value)) {
        err.innerText = "Password must contain at least one number.";
        input.style.border = "2px solid red";
        setTimeout(checkErrors, 100);
        return;
      }
      if (!/[!@#$%^&?*]/.test(value)) {
        err.innerText =
          "Password must contain at least one symbol (!@#$%^&?*).";
        input.style.border = "2px solid red";
        setTimeout(checkErrors, 100);
        return;
      }
      if (value.length < 8) {
        err.innerText = "Password must be at least 8 characters long.";
        input.style.border = "2px solid red";
        setTimeout(checkErrors, 100);
        return;
      }

      err.innerText = "";
      input.style.border = "";

      if (pass2.value !== "") {
        if (value !== pass2.value) {
          err.innerText = "Password and Confirm Password do not match.";
          p2.innerText = "Password and Confirm Password do not match.";
          input.style.border = "2px solid red";
          pass2.style.border = "2px solid red";
        } else {
          err.innerText = "";
          p2.innerText = "";
          input.style.border = "";
          pass2.style.border = "";
        }
      }
    }

    if (name === "cPassword") {
      if (value === "") {
        err.innerText = "";
        input.style.border = "";
        setTimeout(checkErrors, 100);
        return;
      }

      if (pass1.value === "" && value.length > 0) {
        p1.innerText = "First create password!";
        input.style.border = "2px solid red";
        pass1.style.border = "2px solid red";
        setTimeout(checkErrors, 100);
        return;
      } else {
        p1.innerText = "";
        input.style.border = "";
        pass1.style.border = "";
      }

      if (pass1.value !== value) {
        err.innerText = "Password and Confirm Password do not match.";
        p1.innerText = "Password and Confirm Password do not match.";
        input.style.border = "2px solid red";
        pass1.style.border = "2px solid red";
      } else {
        err.innerText = "";
        p1.innerText = "";
        input.style.border = "";
        pass1.style.border = "";
      }
    }

    if (name === "sname") {
      pattern = /^[A-Za-z](?=.*[0-9]{0,4})[A-Za-z0-9]*$/;
      if (value.length === 0) {
        err.innerText = "";
      } else if (!pattern.test(value)) {
        err.innerText = "Must start with and only contain letters!";
      } else if (value.length > 25) {
        err.innerText = "Letters must be less than 25!";
      } else {
        err.innerText = "";
      }
    }

    if (name == "address") {
      pattern = /^[A-Za-z][A-Za-z0-9\-,]*$/;
      if (value.length === 0) {
        err.innerText = "";
      } else if (!pattern.test(value)) {
        err.innerText = "Must start with letters or only - and , are allowed!";
      } else if (value.length > 25) {
        err.innerText = "Letters must be less than 25!";
      } else {
        err.innerText = "";
      }
    }
    setTimeout(checkErrors, 100);
  });
}

// check if emal already exists
const emailInput = document.querySelector('input[name="email"]');
if (emailInput) {
  emailInput.addEventListener("keypress", function (e) {
    if (e.key === "Enter") {
      e.preventDefault();
      this.blur();
    }
  });

  emailInput.addEventListener("blur", function () {
    const value = this.value.trim();
    const err = document.querySelector("p.email");

    if (value === "") {
      err.innerText = "";
      checkErrors();
      return;
    }

    if (!/^[a-zA-Z][a-zA-Z0-9._-]*@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(value)) {
      err.innerText = "Please enter a valid email address.";
      checkErrors();
      return;
    }

    const x = new XMLHttpRequest();
    x.open("POST", "emailCheck.php", true);
    x.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    x.onload = function () {
      if (this.status === 200) {
        const response = this.responseText.trim();
        console.log("Response:", response);

        if (response === "exists") {
          err.innerText = "Email already exists!";
          emailInput.style.border = "2px solid red";
          value = "";
        }
        if (response === "available") {
          err.innerText = "";
          emailInput.style.border = "";
        }
        checkErrors();
      }
    };

    x.send("email=" + encodeURIComponent(value));
  });
}

// photo validate

document.getElementById("photos").addEventListener("change", function () {
  const file = this.files[0];
  const maxSize = 5 * 1024 * 1024;

  if (file && file.size > maxSize) {
    // document.getElementsByClassName("photoErr").innerText =
    //   "Size must be less than 5MB.";
    this.value = "";
  }
});

// custom services in register form

function addCustomService() {
  let name = document.getElementById("customName").value.trim();
  let price = document.getElementById("customPrice").value.trim();
  let duration = document.getElementById("customDuration").value.trim();
  const serviceNpattern = /^[A-Za-z]{2,}$/;

  const el = document.getElementsByClassName("customErr")[0];

  if (name === "" || price === "" || duration === "") {
    el.innerText = "Please Enter All Fields!";
  } else if (price < 0 || duration < 0) {
    el.innerText = "Must Not Enter Negative Value!";
  } else if (name.length < 3) {
    el.innerText = "Service name at least contain 3 leters!";
  } else if (!serviceNpattern.test(name)) {
    el.innerText = "Service name must contain only letters!";
  } else {
    let div = document.createElement("div");
    div.className =
      "services bg-gray-200 rounded-md py-1 px-3 mb-4 flex justify-between items-center";
    div.innerHTML = `
    <div>
      <p>${name}</p>
      <ul class="flex gap-1 items-center text-sm text-gray-500">
        <li>${duration} mins</li>
        <li class="bg-gray-500 w-1 h-1 rounded-full"></li>
        <li>Rs.${price}</li>
      </ul>

      <input type="hidden" name="customSNames[]" value="${name}" />
      <input type="hidden" name="customSPrices[]" value="${price}" />
      <input type="hidden" name="customSDurations[]" value="${duration}" />

    </div>
    <img src="./public/images/remove.png" alt="Remove service"
    class="cursor-pointer w-4 h-4 hover:w-5 hover:h-5" onclick="removeS(this)" />

    `;

    let customList = document.getElementById("customList");

    customList.className = "bg-white p-4 mt-4 rounded-md shadow-lg";

    customList.appendChild(div);

    // Clear
    document.getElementById("customName").value = "";
    document.getElementById("customPrice").value = "";
    document.getElementById("customDuration").value = "";

    checkErrors();
  }
}

// remove custom service

function removeS(ele) {
  let customList = document.getElementById("customList");
  // alert(customList.children.length);
  let toRemove = ele.parentElement;
  toRemove.remove();

  if (customList.children.length === 0) {
    customList.className = "";
  }
}
// this is for error msg of checkbox and other

document.querySelectorAll(".default-service").forEach((service) => {
  const checkbox = service.querySelector("input[type='checkbox']");
  const priceInput = service.querySelector("input[placeholder='Price (Rs.)']");
  const durationInput = service.querySelector(
    "input[placeholder='Duration (min)']"
  );

  const priceError = service.querySelector("p." + priceInput.classList[0]);
  const durationError = service.querySelector(
    "p." + durationInput.classList[0]
  );

  function validateRow() {
    if (checkbox.checked) {
      if (priceInput.value.trim() === "") {
        priceError.textContent = "Enter price";
      } else if (priceInput.value < 0) {
        priceError.textContent = "Must be positive";
      } else {
        priceError.textContent = "";
      }

      if (durationInput.value.trim() === "") {
        durationError.textContent = "Enter duration";
      } else if (durationInput.value < 0) {
        durationError.textContent = "Must be positive";
      } else {
        durationError.textContent = "";
      }
    } else {
      priceError.textContent = "";
      durationError.textContent = "";
    }
    checkErrors();
  }

  checkbox.addEventListener("change", validateRow);
  priceInput.addEventListener("input", validateRow);
  durationInput.addEventListener("input", validateRow);
});

// first time error check
checkErrors();
