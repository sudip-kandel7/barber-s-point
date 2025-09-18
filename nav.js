  
  const hamburger = document.getElementById('hamburger');
  const mobileMenu = document.getElementById('mobileMenu');
  const imgs = hamburger.getElementsByClassName('img');

  hamburger.addEventListener('click', (e) => {
    e.stopPropagation();
    imgs[0].classList.toggle('hidden');   
    imgs[1].classList.toggle('hidden');  
    mobileMenu.classList.toggle('hidden');
  });


document.addEventListener('click', (e) => {
  if (!hamburger.contains(e.target) && !mobileMenu.contains(e.target)) {
    mobileMenu.classList.add('hidden');    
    imgs[0].classList.remove('hidden');    
    imgs[1].classList.add('hidden');       
  }
});
