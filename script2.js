const header = document.querySelector('header');
function fixedNavbar(){
    header.classList.toggle('scrolled',window.pageYOffset > 0)
}

fixedNavbar();
window.addEventListener('scroll', fixedNavbar);



