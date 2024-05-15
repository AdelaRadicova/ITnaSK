
/* Title animation */
/* Inspirovane zdrojom : https://tobiasahlin.com/moving-letters/#12 */
let textWrapper1 = document.querySelector('.sl1');
textWrapper1.innerHTML = textWrapper1.textContent.replace(/\S/g, "<span class='letter'>$&</span>");

let textWrapper2 = document.querySelector('.sl2');
textWrapper2.innerHTML = textWrapper2.textContent.replace(/\S/g, "<span class='letter'>$&</span>");

let textWrapper3 = document.querySelector('.ttl');
textWrapper3.innerHTML = textWrapper3.textContent.replace(/\S/g, "<span class='letter'>$&</span>");


anime.timeline({loop: false})
    .add({
        targets: '.sl1, .sl2, .ttl .letter',
        translateX: [40,0],
        translateZ: 0,
        opacity: [0,1],
        easing: "easeOutExpo",
        delay: (el, i) => 300 + 30 * i
    });


/* Arrow scroll-up animation */
/* Inspirovane zdrojom : https://www.youtube.com/watch?v=SJVCvnKM_lI */

const toTop = document.querySelector(".shift-up");
window.addEventListener("scroll", () => {
    if (window.pageYOffset > 500) {
        toTop.classList.add("active");
    } else {
        toTop.classList.remove("active");
    }
})
$('#scroll-top').click(function() {
    $('html, body').animate({scrollTop: 0}, 20);
});


$('#scroll-to-message').click(function() {
    const devSection = document.getElementById('sp-clanok');
    const devSectionPos = devSection.getBoundingClientRect().bottom - 50;

    $('html, body').animate({scrollTop: devSectionPos}, 20);
});