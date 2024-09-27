const header = document.querySelector('header');

// Navbar'ı sayfa kaydırıldığında sabit tutma
function fixedNavbar() {
    header.classList.toggle('scrolled', window.scrollY > 0); 
}

// Sayfa yüklendiğinde ve kaydırıldığında fonksiyonu çalıştır
fixedNavbar();
window.addEventListener('scroll', fixedNavbar);

// Menü butonu
const menu = document.querySelector('#menu-btn');
menu.addEventListener('click', function() {
    const nav = document.querySelector('.navbar');    
    nav.classList.toggle('active');
});

// Kullanıcı butonu
const userBtn = document.querySelector('#user-btn');
userBtn.addEventListener('click', function() {
    const userBox = document.querySelector('.profile-detail');    
    userBox.classList.toggle('active');
});




