"use strict";

document.addEventListener("DOMContentLoaded", function() {
  let selectedAnimation;

  const animation   = document.getElementById('animation');
  const animate     = document.getElementById('animate-check');
  const animadio    = document.getElementById('animadio');
  const logo        = document.getElementById('logo');

  function removeClass() {
    animate.classList.remove(selectedAnimation + "-check");
    animadio.classList.remove(selectedAnimation + "-hub");
    logo.classList.remove(selectedAnimation + "-goal");
    animate.checked = false;
  }

  animation.addEventListener("input", function () {
    selectedAnimation = animation.options[animation.selectedIndex].value;

    animate.addEventListener("click", function () {
      animate.classList.add(selectedAnimation + "-check");
      animadio.classList.add(selectedAnimation + "-hub");
      logo.classList.add(selectedAnimation + "-goal");

      window.setTimeout(removeClass, 2000);
    })
  })
});


