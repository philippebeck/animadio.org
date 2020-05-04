"use strict";

document.addEventListener("DOMContentLoaded", function() {
  const name            = document.getElementById("name");
  const timingFunction  = document.getElementById("function");
  const iterationCount  = document.getElementById("count");
  const direction       = document.getElementById("direction");
  const check           = document.getElementById('check');
  const hub             = document.getElementById('hub');
  const goal            = document.getElementById('goal');

  name.oninput = function() {
    return name.value;
  }

  timingFunction.oninput = function() {
    return timingFunction.value;
  }

  iterationCount.oninput = function() {
    return iterationCount.value;
  }

  direction.oninput = function() {
    return direction.value;
  }

  function addClass() {
    let count;
    let duration = 2000;

    function removeClass() {
      check.checked = false;

      check.classList.remove(name.value + "-check");
      hub.classList.remove(name.value + "-hub");
      goal.classList.remove(name.value + "-goal");

      check.classList.remove(timingFunction.value + "-check");
      hub.classList.remove(timingFunction.value + "-hub");
      goal.classList.remove(timingFunction.value + "-goal");

      check.classList.remove(iterationCount.value + "-check");
      hub.classList.remove(iterationCount.value + "-hub");
      goal.classList.remove(iterationCount.value + "-goal");

      check.classList.remove(direction.value + "-check");
      hub.classList.remove(direction.value + "-hub");
      goal.classList.remove(direction.value + "-goal");

      check.removeAttribute("disabled");
    }

    check.classList.add(name.value + "-check");
    hub.classList.add(name.value + "-hub");
    goal.classList.add(name.value + "-goal");

    check.classList.add(timingFunction.value + "-check");
    hub.classList.add(timingFunction.value + "-hub");
    goal.classList.add(timingFunction.value + "-goal");

    check.classList.add(iterationCount.value + "-check");
    hub.classList.add(iterationCount.value + "-hub");
    goal.classList.add(iterationCount.value + "-goal");

    count = iterationCount.value.slice(6);

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

    check.classList.add(direction.value + "-check");
    hub.classList.add(direction.value + "-hub");
    goal.classList.add(direction.value + "-goal");

    if (count) {
      duration = duration * count;
    }

    window.setTimeout(removeClass, duration);
  }

  check.addEventListener("click", function () {
    check.setAttribute("disabled", true);
    addClass();
  })
});
