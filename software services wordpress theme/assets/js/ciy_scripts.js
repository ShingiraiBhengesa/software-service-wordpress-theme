const left = document.querySelector('.left');
const right = document.querySelector('.right');
const container = document.querySelector('.container');

left.addEventListener('mouseenter', () => {
    container.classList.add('hover-left');
});

left.addEventListener('mouseleave', () => {
    container.classList.remove('hover-left');
});

right.addEventListener('mouseenter', () => {
    container.classList.add('hover-right');
});

right.addEventListener('mouseleave', () => {
    container.classList.remove('hover-right');
});

// Menu functions
function openSideMenu()
{
    document.getElementById('navbar__side-menu').style.width = '250px';
    document.getElementById('main').style.marginLeft = '250px';
}

function closeSideMenu()
{
    document.getElementById('navbar__side-menu').style.width = '0px';
    document.getElementById('main').style.marginLeft = '0px';
}