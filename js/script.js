"use strict";

document.addEventListener("DOMContentLoaded", function() {
  const name            = document.getElementById("name");
  const timingFunction  = document.getElementById("function");
  const iterationCount  = document.getElementById("count");
  const direction       = document.getElementById("direction");
  const animate         = document.getElementById('animate-check');
  const animadio        = document.getElementById('animadio');
  const logo            = document.getElementById('logo');

  var nameValue = name.onclick = function() {
    return name.value;
  }

  var functionValue = timingFunction.onclick = function() {
    return timingFunction.value;
  }

  var countValue = iterationCount.onclick = function() {
    return iterationCount.value;
  }

  var directionValue = direction.onclick = function() {
    return direction.value;
  }

  function addClass() {
    let count;
    let duration = 2000;

    function removeClass() {
      animate.checked = false;

      animate.classList.remove(nameValue() + "-check");
      animadio.classList.remove(nameValue() + "-hub");
      logo.classList.remove(nameValue() + "-goal");

      if (functionValue()) {
        animate.classList.remove(functionValue() + "-check");
        animadio.classList.remove(functionValue() + "-hub");
        logo.classList.remove(functionValue() + "-goal");
      }

      if (countValue()) {
        animate.classList.remove(countValue() + "-check");
        animadio.classList.remove(countValue() + "-hub");
        logo.classList.remove(countValue() + "-goal");
      }

      if (directionValue()) {
        animate.classList.remove(directionValue() + "-check");
        animadio.classList.remove(directionValue() + "-hub");
        logo.classList.remove(directionValue() + "-goal");
      }

      animate.removeAttribute("disabled");
    }

    animate.classList.add(nameValue() + "-check");
    animadio.classList.add(nameValue() + "-hub");
    logo.classList.add(nameValue() + "-goal");

    if (functionValue()) {
      animate.classList.add(functionValue() + "-check");
      animadio.classList.add(functionValue() + "-hub");
      logo.classList.add(functionValue() + "-goal");
    }

    if (countValue()) {
      animate.classList.add(countValue() + "-check");
      animadio.classList.add(countValue() + "-hub");
      logo.classList.add(countValue() + "-goal");

      count = countValue().slice(6);

      switch (count) {
        case "few":
          count = 2;
          break;
        case "many":
          count = 5;
          break;
        case "loop":
          count = 30;
          alert("Loop is limited to 1mn for this demo !")
          break;
      }
    }

    if (directionValue()) {
      animate.classList.add(directionValue() + "-check");
      animadio.classList.add(directionValue() + "-hub");
      logo.classList.add(directionValue() + "-goal");
    }

    if (count) {
      duration = duration * count;
    }

    window.setTimeout(removeClass, duration);
  }

  animate.addEventListener("click", function () {
    animate.setAttribute("disabled", true);
    addClass();
  })
});
