document.addEventListener("DOMContentLoaded", () => {
  //  hide and show filter and sort lists

  const btn1 = document.getElementsByClassName("filter")[0];
  const btn2 = document.getElementsByClassName("sort")[0];

  const filterList = document.getElementsByClassName("list1")[0];
  const sortList = document.getElementsByClassName("list2")[0];

  btn1.addEventListener("click", () => {
    filterList.classList.toggle("hidden");
    sortList.classList.add("hidden");
  });

  btn2.addEventListener("click", () => {
    filterList.classList.add("hidden");
    sortList.classList.toggle("hidden");
  });

  // change filter value and img on click

  const filterOpts = document.querySelectorAll(".fOption");
  const filterText = document.querySelector(".filter p");

  let selected1 = filterOpts[0];

  selected1.classList.add("bg-yellow-100");

  selected1.querySelector("img").classList.remove("opacity-0");

  filterOpts.forEach((opt) => {
    opt.addEventListener("click", () => {
      filterText.innerText = opt.querySelector("p").innerText;
      filterList.classList.add("hidden");

      filterOpts.forEach((o) => {
        o.classList.remove("bg-yellow-100");
        o.querySelector("img").classList.add("opacity-0");
      });

      selected1 = opt;
      selected1.classList.add("bg-yellow-100");
      selected1.querySelector("img").classList.remove("opacity-0");
    });
  });

  // change sort value and img on click

  const sortOpts = document.querySelectorAll(".sOption");
  const sortText = document.querySelector(".sort p");

  let selected2 = sortOpts[0];

  selected2.classList.add("bg-yellow-100");

  selected2.querySelector("img").classList.remove("opacity-0");

  sortOpts.forEach((opt) => {
    opt.addEventListener("click", () => {
      sortText.innerText = opt.querySelector("p").innerText;
      sortList.classList.add("hidden");

      sortOpts.forEach((o) => {
        o.classList.remove("bg-yellow-100");
        o.querySelector("img").classList.add("opacity-0");
      });

      selected2 = opt;
      selected2.classList.add("bg-yellow-100");
      selected2.querySelector("img").classList.remove("opacity-0");
    });
  });
});

// close dropdown when clicked outside
