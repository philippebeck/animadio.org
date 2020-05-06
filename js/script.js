"use strict";

document.addEventListener("DOMContentLoaded", function() {
  var animadio = new Animadio(
      ["name", "function", "count", "direction"],
      ["anima", ["check", "hub", "goal"]],
      [2000, {few: 2, many: 5, loop: 30}]
  );
});
