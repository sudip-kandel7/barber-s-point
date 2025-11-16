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
    document.querySelector('textarea[name="exp"]').value = "";
    document.querySelector('textarea[name="services"]').value = "";
  }
});

// form validation frontend (js)

let form = document.getElementById("form");

form.addEventListener("change", (e) => {
  e.preventDefault();

  const input = e.target;
  const name = input.name;
  // console.log(name);
  const value = input.value.trim();
  console.log(value);

  const err = document.querySelector(`p.${name}`);

  const hasNumberOrSymbol = /[^a-zA-Z\s]/.test(value);
  const wordCount = value.split(/\s+/).filter(Boolean).length;

  let pass1 = document.querySelector('input[name="password"]');
  let pass2 = document.querySelector('input[name="cPassword"]');
  let p1 = document.getElementsByClassName("password")[0];
  let p2 = document.getElementsByClassName("cPassword")[0];

  // validate shop info in registation form

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

  if (name === "email") {
    if (value === "") {
      err.innerText = "";
    } else if (
      !/^[a-zA-Z][a-zA-Z0-9._-]*@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(value)
    ) {
      err.innerText = "Please enter a valid email address.";
    } else {
      err.innerText = "";
    }
  }

  if (name === "number") {
    if (value === "") {
      err.innerText = "";
    } else if (!/^\d{10}$/.test(value)) {
      if (/\D/.test(value)) {
        err.innerText = "Phone number must contain only digits.";
        return;
      }
      if (!value.startsWith("98") && !value.startsWith("97")) {
        err.innerText = "Phone number must start with 98 or 97.";
        return;
      }
      if (value.length != 10) {
        err.innerText = "Phone number must be exactly 10 digits.";
        return;
      }
    }
  }

  if (name === "password") {
    // If password field is empty
    if (value === "") {
      err.innerText = "";
      input.style.border = "";
      if (pass2.value === "") {
        p2.innerText = "";
        pass2.style.border = "";
      }
      return;
    }

    if (value.length < 8) {
      err.innerText = "Password must be at least 8 characters long.";
      input.style.border = "2px solid red";
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
      return;
    }

    if (pass1.value === "") {
      if (value.length < 8) {
        err.innerText = "Password must be at least 8 characters long.";
        input.style.border = "2px solid red";
      } else {
        err.innerText = "";
        input.style.border = "";
      }
      return;
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
});

// login page validation starts now

document.addEventListener("DOMContentLoaded", () => {
  let loginForm = document.getElementById("login-form");
  // console.log(loginForm);
});

// loginForm.addEventListener("change", (e) => {
//   e.preventDefault();

//   const input = e.target;
//   const name = input.name;
//   const value = input.value.trim();

//   const err = document.querySelector(`p.${name}`);

//   if (name === "email") {
//     if (value === "") {
//       err.innerText = "";
//     } else if (
//       !/^[a-zA-Z][a-zA-Z0-9._-]*@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(value)
//     ) {
//       err.innerText = "Please enter a valid email address.";
//     } else {
//       err.innerText = "";
//     }
//   }
//   if (name === "password") {
//     if (value === "") {
//       err.innerText = "";
//       return;
//     }

//     if (value.length < 8) {
//       err.innerText = "Password must be at least 8 characters long.";
//       return;
//     }
//   }
// })
