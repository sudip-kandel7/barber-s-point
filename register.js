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

select.addEventListener("change", () => {
  if (select.value === "barber") {
    barberinfo.classList.remove("hidden");
    barberinfo.classList.add("block");
  } else {
    barberinfo.classList.add("hidden");
    barberinfo.classList.remove("block");
  }
});

// form validation frontend (js)

let form = document.getElementById("form");

form.addEventListener("change", (e) => {
  e.preventDefault();

  const input = e.target;
  name = input.name;

  console.log(input);

  validate(input, name);
});

function validate(input, name) {
  if (input.value.trim() === "") {
    error.innerText = "";
  } else {
    switch (name) {
      case "firstN":
        if (!/^[a-zA-Z]{3,10}$/.test(input.value)) {
          let err = document.getElementsByClassName("firstN")[0];
          if (!/^[a-zA-Z]+$/.test(input.value)) {
            err.innerText = "First Name must contain only letters.";
          }
          if (input.value.length < 3) {
            err.innerText = "First Name must be at least 3 characters.";
          }
          if (input.value.length > 10) {
            err.innerText = "First Name must be 10 characters or less.";
          }
          return;
        }
        break;

      case "lastN":
        if (!/^[A-Za-z]{3,10}$/.test(input.value)) {
          let err = document.getElementsByClassName("lastN")[0];
          if (!/^[a-zA-Z]+$/.test(input.value)) {
            err.innerText = "First Name must contain only letters.";
          }
          if (input.value.length < 3) {
            err.innerText = "First Name must be at least 3 characters.";
          }
          if (input.value.length > 10) {
            err.innerText = "First Name must be 10 characters or less.";
          }
          return;
        }
        break;

      case "email":
        if (
          !/^[a-zA-Z][a-zA-Z0-9._-]*@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(
            input.value.trim()
          )
        ) {
          let err = document.getElementsByClassName("email")[0];
          err.innerText = "Please enter a valid email address.";
        }
        break;
      case "number":
        if (!/^\d{10}$/.test(input.value)) {
          let err = document.getElementsByClassName("number")[0];
          if (/\D/.test(input.value)) {
            err.innerText = "Phone number must contain only digits.";
            return;
          }
          if (!input.value.startsWith("98") && !input.value.startsWith("97")) {
            err.innerText = "Phone number must start with 98 or 97.";
            return;
          }
          if (input.value.length != 10) {
            err.innerText = "Phone number must be exactly 10 digits.";
            return;
          }
        }
        break;

      // Add more cases for other inputs as needed
      default:
        break;
    }
  }
}
