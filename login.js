let password = document.getElementById("pass");
let toggle = document.getElementById("toggle");

toggle.addEventListener("click", () => {
  if (password.type === "password") {
    password.type = "text";
    toggle.src = "./public/images/hide.png";
  } else {
    password.type = "password";
    toggle.src = "./public/images/visible.png";
  }
});

let asSelect = document.getElementById("as");

let lform = document.getElementById("loginform");

lform.addEventListener("change", (e) => {
  //   console.log(`Selected user type: ${asSelect.value}`);

  e.preventDefault();
  const input = e.target;
  console.log(input);
  const name = input.name;
  console.log(name);
  const value = input.value.trim();
  console.log(value);

  const lerr = document.querySelector(`p.${name}`);

  if (name === "lpassword") {
    if (value === "") {
      lerr.innerText = "Password cannot be empty";
    } else if (value.length < 8) {
      lerr.innerText = "Password must be at least 8 characters long";
    } else {
      lerr.innerText = "";
    }
  } else if (name === "lemail") {
    const emailPattern =
      /^[a-zA-Z][a-zA-Z0-9._-]*@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    if (value === "") {
      lerr.innerText = "Email cannot be empty";
    } else if (!emailPattern.test(value)) {
      lerr.innerText = "Please enter a valid email address";
    } else {
      lerr.innerText = "";
    }
  }
});
