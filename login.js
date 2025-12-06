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
