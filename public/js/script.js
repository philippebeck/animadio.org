"use strict";

class Input {
  /**
   * @param {Object} inputs
   * @param {Object} elements
   * @param {Object} duration
   */
  constructor(inputs, elements = ["animadio", ["trigger"]], duration = [2000, {}, {}]) {
    this.inputIds   = inputs;
    this.inputCount = inputs.length;
    this.inputs     = [];

    this.mainElement  = elements[0];
    this.elements     = elements[1];
    this.elementCount = elements[1].length;

    this.mainClass  = null;
    this.classes    = [];

    this.duration       = duration[0];
    this.durationBase   = duration[0];
    this.countValues    = duration[1];
    this.durationValues = duration[2];

    this.getAllElements();
    this.getAllValues();
    this.mainClass.addEventListener("click", this.clickCheckBtn.bind(this));
  }

  getAllElements() {
    for (let elementIndex = 0; elementIndex < this.elementCount; elementIndex++) {
      this.classes[elementIndex] = document.querySelector("#" + this.mainElement + "-" + this.elements[elementIndex]);
    }
    this.mainClass = this.classes[0];
  }

  getAllValues() {
    for (let inputIndex = 0; inputIndex < this.inputCount; inputIndex++) {
      this.inputs[inputIndex] = document.querySelector("#" + this.inputIds[inputIndex]);
      this.inputs[inputIndex].addEventListener("input", this.getValue.bind(this, inputIndex));
    }
  }

  /**
   * @param {number} inputIndex
   * @returns {string}
   */
  getValue(inputIndex) {
    return this.inputs[inputIndex].value;
  }

  clickCheckBtn() {
    this.mainClass.setAttribute("disabled", true);

    for (let inputIndex = 0; inputIndex < this.inputCount; inputIndex++) {
      this.inputs[inputIndex].setAttribute("disabled", true);
    }
    this.addClasses();
  }

  addClasses() {
    for (let inputIndex = 0; inputIndex < this.inputCount; inputIndex++) {
      if (this.inputs[inputIndex].value) {
        this.toggleClass(inputIndex);
      }
      this.setAllDuration(inputIndex);
    }
    window.setTimeout(this.removeClasses.bind(this), this.duration);
  }

  /**
   * @param {number} inputIndex
   */
  toggleClass(inputIndex) {
    for (let elementIndex = 0; elementIndex < this.elementCount; elementIndex++) {
      this.classes[elementIndex].classList.toggle(this.inputs[inputIndex].value + "-" + this.elements[elementIndex]);
    }
  }

  /**
   * @param {number} inputIndex
   */
  setAllDuration(inputIndex) {
    if (this.durationValues) {
      this.setDuration(inputIndex);
    }

    if (this.countValues) {
      this.setCount(inputIndex);
    }
  }

  /**
   * @param {number} inputIndex
   */
  setDuration(inputIndex) {
    for (let [durationKey, durationValue] of Object.entries(this.durationValues)) {
      if (this.inputs[inputIndex].value.includes(durationKey)) {
        this.duration = durationValue;
      }
    }
  }

  /**
   * @param {number} inputIndex
   */
  setCount(inputIndex) {
    for (let [countKey, countValue] of Object.entries(this.countValues)) {
      if (this.inputs[inputIndex].value.includes(countKey)) {
        this.duration = this.duration * countValue;
      }
    }
  }

  removeClasses() {
    this.mainClass.checked  = false;
    this.duration           = this.durationBase;

    for (let inputIndex = 0; inputIndex < this.inputCount; inputIndex++) {
      if (this.inputs[inputIndex].value) {
        this.toggleClass(inputIndex);
      }
      this.inputs[inputIndex].removeAttribute("disabled");
    }
    this.mainClass.removeAttribute("disabled");
  }
}

document.addEventListener("DOMContentLoaded", function() {
  new Input(
      ["name", "function", "count", "direction"],
      ["anima", ["check", "hub", "goal"]],
      [2000, {few: 2, many: 5, loop: 30}]
  );

  Animadio.slider(3000);

  Animadio.canvas();
});
