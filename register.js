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
