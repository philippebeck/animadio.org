"use strict";

document.addEventListener("DOMContentLoaded", function() {
  Animadio.input(
      ["name", "function", "count", "direction"],
      ["anima", ["check", "hub", "goal"]],
      [2000, {few: 2, many: 5, loop: 30}]
  );

  Animadio.slider(3000);

  Animadio.canvas();
});
