const hamburger = document.getElementById("hamburger");
const mobileMenu = document.getElementById("mobileMenu");
const imgs = hamburger.getElementsByClassName("img");

hamburger.addEventListener("click", (e) => {
  e.stopPropagation();
  imgs[0].classList.toggle("hidden");
  imgs[1].classList.toggle("hidden");
  mobileMenu.classList.toggle("hidden");
});

document.addEventListener("click", (e) => {
  if (!hamburger.contains(e.target) && !mobileMenu.contains(e.target)) {
    mobileMenu.classList.add("hidden");
    imgs[0].classList.remove("hidden");
    imgs[1].classList.add("hidden");
  }
});

// voice

let voice = "normal";
let recog,
  finalTranscript = "";

const voiceBtn = document.getElementById("voiceBtn");
const searchBtn = document.getElementById("search");
const cross = document.getElementById("cross");
const micIcon = voiceBtn.querySelector('img[alt="voice search icon"]');
const pauseIcon = voiceBtn.querySelector('img[alt="voice pause icon"]');
const playIcon = voiceBtn.querySelector('img[alt="voice resume icon"]');

searchBtn.addEventListener("input", () => {
  if (searchBtn.value.length > 0) {
    cross.classList.remove("hidden");
  } else {
    cross.classList.add("hidden");
  }
});

cross.addEventListener("click", () => {
  searchBtn.value = "";
  finalTranscript = "";
  cross.classList.add("hidden");
  micIcon.classList.remove("hidden")
  pauseIcon.classList.add("hidden")
  playIcon.classList.add("hidden")
});

const SpeechRecog = window.SpeechRecognition || window.webkitSpeechRecognition;

if (SpeechRecog) {
  recog = new SpeechRecog();
  recog.continuous = true;
  recog.interimResults = true;

  recog.addEventListener("result", (event) => {
    let interimTranscript = "";
    for (let i = event.resultIndex; i < event.results.length; i++) {
      if (event.results[i].isFinal) {
        finalTranscript += event.results[i][0].transcript + " ";
      } else {
        interimTranscript += event.results[i][0].transcript;
      }
    }
    searchBtn.value = (finalTranscript + interimTranscript).trim();

    if (searchBtn.value.length > 0) {
      cross.classList.remove("hidden");
    } else {
      cross.classList.add("hidden");
    }
  });

  searchBtn.addEventListener("search", () => {
    if (searchBtn.value === "") {
      finalTranscript = "";

      recog.stop();

      micIcon.classList.remove("hidden");
      pauseIcon.classList.add("hidden");
      playIcon.classList.add("hidden");
      voice = "normal";
    }
  });

  voiceBtn.addEventListener("click", () => {
    if (voice === "normal" || voice === "resume") {
      micIcon.classList.add("hidden");
      pauseIcon.classList.remove("hidden");
      playIcon.classList.add("hidden");
      voice = "mic";

      recog.start();
    } else if (voice === "mic") {
      pauseIcon.classList.add("hidden");
      playIcon.classList.remove("hidden");
      voice = "resume";

      recog.stop();
    }
  });
} else {
  alert("Sorry, your browser does not support speech recognition.");
}
