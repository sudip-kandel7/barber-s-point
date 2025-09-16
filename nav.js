  
  const hamburger = document.getElementById('hamburger');
  const mobileMenu = document.getElementById('mobileMenu');
  const imgs = hamburger.getElementsByClassName('img');

  hamburger.addEventListener('click', () => {
    imgs[0].classList.toggle('hidden');   
    imgs[1].classList.toggle('hidden');  
    mobileMenu.classList.toggle('hidden');
  });