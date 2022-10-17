// ==========Nav onscroll effect===========
const nav = document.querySelector('nav')
const hamburger = document.getElementById('hamburger')

const navmenu = document.getElementById('menu_list')

hamburger.addEventListener('click', () => {
  navmenu.classList.toggle('show')
});

window.addEventListener('scroll', () => {
  if (window.scrollY >= 50) {
    nav.classList.add('active_nav')
  } else {
    nav.classList.remove('active_nav')
  }
});

// ============== faqs ============
const faqs = document.querySelectorAll('.faq')

faqs.forEach((faq) => {
  faq.addEventListener('click', () => {
    faq.classList.toggle('active')
  })
});

// =============mobile Navigation=======

document.getElementById('hamburger').onclick = function () {
  openNav()
};

document.getElementById('close').onclick = function () {
  closeNav()
};

function openNav() {
  document.getElementById('sidenav').style.display = 'block'
};

function closeNav() {
  document.getElementById('sidenav').style.display = 'none';
};







