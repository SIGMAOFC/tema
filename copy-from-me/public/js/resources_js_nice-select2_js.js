"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_nice-select2_js"],{

/***/ "./resources/js/nice-select2.js":
/*!**************************************!*\
  !*** ./resources/js/nice-select2.js ***!
  \**************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "bind": () => (/* binding */ bind),
/* harmony export */   "default": () => (/* binding */ NiceSelect)
/* harmony export */ });
/* harmony import */ var _scss_nice_select2_scss__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../scss/nice-select2.scss */ "./resources/scss/nice-select2.scss");
 // utility functions

function triggerClick(el) {
  var event = document.createEvent("MouseEvents");
  event.initEvent("click", true, false);
  el.dispatchEvent(event);
}

function triggerChange(el) {
  var event = document.createEvent("HTMLEvents");
  event.initEvent("change", true, false);
  el.dispatchEvent(event);
}

function triggerFocusIn(el) {
  var event = document.createEvent("FocusEvent");
  event.initEvent("focusin", true, false);
  el.dispatchEvent(event);
}

function triggerFocusOut(el) {
  var event = document.createEvent("FocusEvent");
  event.initEvent("focusout", true, false);
  el.dispatchEvent(event);
}

function attr(el, key) {
  return el.getAttribute(key);
}

function data(el, key) {
  return el.getAttribute("data-" + key);
}

function hasClass(el, className) {
  if (el) return el.classList.contains(className);else return false;
}

function addClass(el, className) {
  if (el) return el.classList.add(className);
}

function removeClass(el, className) {
  if (el) return el.classList.remove(className);
}

var defaultOptions = {
  data: null,
  searchable: false
};
function NiceSelect(element, options) {
  this.el = element;
  this.config = Object.assign({}, defaultOptions, options || {});
  this.data = this.config.data;
  this.selectedOptions = [];
  this.placeholder = attr(this.el, "placeholder") || this.config.placeholder || "Select an option";
  this.dropdown = null;
  this.multiple = attr(this.el, "multiple");
  this.disabled = attr(this.el, "disabled");
  this.create();
}

NiceSelect.prototype.create = function () {
  this.el.style.display = "none";

  if (this.data) {
    this.processData(this.data);
  } else {
    this.extractData();
  }

  this.renderDropdown();
  this.bindEvent();
};

NiceSelect.prototype.processData = function (data) {
  var options = [];
  data.forEach(function (item) {
    options.push({
      data: item,
      attributes: {
        selected: false,
        disabled: false,
        optgroup: item.value == 'optgroup'
      }
    });
  });
  this.options = options;
};

NiceSelect.prototype.extractData = function () {
  var options = this.el.querySelectorAll("option,optgroup");
  var data = [];
  var allOptions = [];
  var selectedOptions = [];
  options.forEach(function (item) {
    if (item.tagName == 'OPTGROUP') {
      var itemData = {
        text: item.label,
        value: 'optgroup'
      };
    } else {
      var itemData = {
        text: item.innerText,
        value: item.value
      };
    }

    var attributes = {
      selected: item.getAttribute("selected") != null,
      disabled: item.getAttribute("disabled") != null,
      optgroup: item.tagName == 'OPTGROUP'
    };
    data.push(itemData);
    allOptions.push({
      data: itemData,
      attributes: attributes
    });
  });
  this.data = data;
  this.options = allOptions;
  this.options.forEach(function (item) {
    if (item.attributes.selected) selectedOptions.push(item);
  });
  this.selectedOptions = selectedOptions;
};

NiceSelect.prototype.renderDropdown = function () {
  var classes = ["nice-select", attr(this.el, "class") || "", this.disabled ? "disabled" : "", this.multiple ? "has-multiple" : ""];
  var searchHtml = "<div class=\"nice-select-search-box\">\n<input type=\"text\" class=\"nice-select-search\" placeholder=\"Search...\"/>\n</div>";
  var html = "<div class=\"".concat(classes.join(" "), "\" tabindex=\"").concat(this.disabled ? null : 0, "\">\n  <span class=\"").concat(this.multiple ? "multiple-options" : "current", "\"></span>\n  <div class=\"nice-select-dropdown\">\n  ").concat(this.config.searchable ? searchHtml : "", "\n  <ul class=\"list\"></ul>\n  </div></div>\n");
  this.el.insertAdjacentHTML("afterend", html);
  this.dropdown = this.el.nextElementSibling;

  this._renderSelectedItems();

  this._renderItems();
};

NiceSelect.prototype._renderSelectedItems = function () {
  if (this.multiple) {
    var selectedHtml = "";

    if (window.getComputedStyle(this.dropdown).width == 'auto' || this.selectedOptions.length < 2) {
      this.selectedOptions.forEach(function (item) {
        selectedHtml += "<span class=\"current\">".concat(item.data.text, "</span>");
      });
      selectedHtml = selectedHtml == "" ? this.placeholder : selectedHtml;
    } else {
      selectedHtml = this.selectedOptions.length + ' selected';
    }

    this.dropdown.querySelector(".multiple-options").innerHTML = selectedHtml;
  } else {
    var html = this.selectedOptions.length > 0 ? this.selectedOptions[0].data.text : this.placeholder;
    this.dropdown.querySelector(".current").innerHTML = html;
  }
};

NiceSelect.prototype._renderItems = function () {
  var _this = this;

  var ul = this.dropdown.querySelector("ul");
  this.options.forEach(function (item) {
    ul.appendChild(_this._renderItem(item));
  });
};

NiceSelect.prototype._renderItem = function (option) {
  var el = document.createElement("li");
  el.innerHTML = option.data.text;

  if (option.attributes.optgroup) {
    el.classList.add('optgroup');
  } else {
    var _el$classList;

    el.setAttribute("data-value", option.data.value);
    var classList = ["option", option.attributes.selected ? "selected" : null, option.attributes.disabled ? "disabled" : null];
    el.addEventListener("click", this._onItemClicked.bind(this, option));

    (_el$classList = el.classList).add.apply(_el$classList, classList);
  }

  option.element = el;
  return el;
};

NiceSelect.prototype.update = function () {
  this.extractData();

  if (this.dropdown) {
    var open = hasClass(this.dropdown, "open");
    this.dropdown.parentNode.removeChild(this.dropdown);
    this.create();

    if (open) {
      triggerClick(this.dropdown);
    }
  }
};

NiceSelect.prototype.disable = function () {
  if (!this.disabled) {
    this.disabled = true;
    addClass(this.dropdown, "disabled");
  }
};

NiceSelect.prototype.enable = function () {
  if (this.disabled) {
    this.disabled = false;
    removeClass(this.dropdown, "disabled");
  }
};

NiceSelect.prototype.clear = function () {
  this.selectedOptions = [];

  this._renderSelectedItems();

  this.updateSelectValue();
  triggerChange(this.el);
};

NiceSelect.prototype.destroy = function () {
  if (this.dropdown) {
    this.dropdown.parentNode.removeChild(this.dropdown);
    this.el.style.display = "";
  }
};

NiceSelect.prototype.bindEvent = function () {
  var $this = this;
  this.dropdown.addEventListener("click", this._onClicked.bind(this));
  this.dropdown.addEventListener("keydown", this._onKeyPressed.bind(this));
  this.dropdown.addEventListener("focusin", triggerFocusIn.bind(this, this.el));
  this.dropdown.addEventListener("focusout", triggerFocusOut.bind(this, this.el));
  window.addEventListener("click", this._onClickedOutside.bind(this));

  if (this.config.searchable) {
    this._bindSearchEvent();
  }
};

NiceSelect.prototype._bindSearchEvent = function () {
  var searchBox = this.dropdown.querySelector(".nice-select-search");
  if (searchBox) searchBox.addEventListener("click", function (e) {
    e.stopPropagation();
    return false;
  });
  searchBox.addEventListener("input", this._onSearchChanged.bind(this));
};

NiceSelect.prototype._onClicked = function (e) {
  if (this.multiple) {
    this.dropdown.classList.add("open");
  } else {
    this.dropdown.classList.toggle("open");
  }

  if (this.dropdown.classList.contains("open")) {
    var search = this.dropdown.querySelector(".nice-select-search");

    if (search) {
      search.value = "";
      search.focus();
    }

    var t = this.dropdown.querySelector(".focus");
    removeClass(t, "focus");
    t = this.dropdown.querySelector(".selected");
    addClass(t, "focus");
    this.dropdown.querySelectorAll("ul li").forEach(function (item) {
      item.style.display = "";
    });
  } else {
    this.dropdown.focus();
  }
};

NiceSelect.prototype._onItemClicked = function (option, e) {
  var optionEl = e.target;

  if (!hasClass(optionEl, "disabled")) {
    if (this.multiple) {
      if (hasClass(optionEl, "selected")) {
        removeClass(optionEl, "selected");
        this.selectedOptions.splice(this.selectedOptions.indexOf(option), 1);
        this.el.querySelector('option[value="' + optionEl.dataset.value + '"]').selected = false;
      } else {
        addClass(optionEl, "selected");
        this.selectedOptions.push(option);
      }
    } else {
      this.selectedOptions.forEach(function (item) {
        removeClass(item.element, "selected");
      });
      addClass(optionEl, "selected");
      this.selectedOptions = [option];
    }

    this._renderSelectedItems();

    this.updateSelectValue();
  }
};

NiceSelect.prototype.updateSelectValue = function () {
  if (this.multiple) {
    var select = this.el;
    this.selectedOptions.forEach(function (item) {
      var el = select.querySelector('option[value="' + item.data.value + '"]');

      if (el) {
        el.setAttribute("selected", true);
      }
    });
  } else if (this.selectedOptions.length > 0) {
    this.el.value = this.selectedOptions[0].data.value;
  }

  triggerChange(this.el);
};

NiceSelect.prototype._onClickedOutside = function (e) {
  if (!this.dropdown.contains(e.target)) {
    this.dropdown.classList.remove("open");
  }
};

NiceSelect.prototype._onKeyPressed = function (e) {
  // Keyboard events
  var focusedOption = this.dropdown.querySelector(".focus");
  var open = this.dropdown.classList.contains("open"); // Space or Enter

  if (e.keyCode == 32 || e.keyCode == 13) {
    if (open) {
      triggerClick(focusedOption);
    } else {
      triggerClick(this.dropdown);
    }
  } else if (e.keyCode == 40) {
    // Down
    if (!open) {
      triggerClick(this.dropdown);
    } else {
      var next = this._findNext(focusedOption);

      if (next) {
        var t = this.dropdown.querySelector(".focus");
        removeClass(t, "focus");
        addClass(next, "focus");
      }
    }

    e.preventDefault();
  } else if (e.keyCode == 38) {
    // Up
    if (!open) {
      triggerClick(this.dropdown);
    } else {
      var prev = this._findPrev(focusedOption);

      if (prev) {
        var t = this.dropdown.querySelector(".focus");
        removeClass(t, "focus");
        addClass(prev, "focus");
      }
    }

    e.preventDefault();
  } else if (e.keyCode == 27 && open) {
    // Esc
    triggerClick(this.dropdown);
  }

  return false;
};

NiceSelect.prototype._findNext = function (el) {
  if (el) {
    el = el.nextElementSibling;
  } else {
    el = this.dropdown.querySelector(".list .option");
  }

  while (el) {
    if (!hasClass(el, "disabled") && el.style.display != "none") {
      return el;
    }

    el = el.nextElementSibling;
  }

  return null;
};

NiceSelect.prototype._findPrev = function (el) {
  if (el) {
    el = el.previousElementSibling;
  } else {
    el = this.dropdown.querySelector(".list .option:last-child");
  }

  while (el) {
    if (!hasClass(el, "disabled") && el.style.display != "none") {
      return el;
    }

    el = el.previousElementSibling;
  }

  return null;
};

NiceSelect.prototype._onSearchChanged = function (e) {
  var open = this.dropdown.classList.contains("open");
  var text = e.target.value;
  text = text.toLowerCase();

  if (text == "") {
    this.options.forEach(function (item) {
      item.element.style.display = "";
    });
  } else if (open) {
    var matchReg = new RegExp(text);
    this.options.forEach(function (item) {
      var optionText = item.data.text.toLowerCase();
      var matched = matchReg.test(optionText);
      item.element.style.display = matched ? "" : "none";
    });
  }

  this.dropdown.querySelectorAll(".focus").forEach(function (item) {
    removeClass(item, "focus");
  });

  var firstEl = this._findNext(null);

  addClass(firstEl, "focus");
};

function bind(el, options) {
  return new NiceSelect(el, options);
}
window.NiceSelect = NiceSelect;

/***/ }),

/***/ "./node_modules/.pnpm/css-loader@5.2.7_webpack@5.74.0/node_modules/css-loader/dist/cjs.js??ruleSet[1].rules[7].oneOf[1].use[1]!./node_modules/.pnpm/postcss-loader@6.2.1_qjv4cptcpse3y5hrjkrbb7drda/node_modules/postcss-loader/dist/cjs.js??ruleSet[1].rules[7].oneOf[1].use[2]!./node_modules/.pnpm/sass-loader@8.0.2_sass@1.54.4+webpack@5.74.0/node_modules/sass-loader/dist/cjs.js??ruleSet[1].rules[7].oneOf[1].use[3]!./resources/scss/nice-select2.scss":
/*!**********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/.pnpm/css-loader@5.2.7_webpack@5.74.0/node_modules/css-loader/dist/cjs.js??ruleSet[1].rules[7].oneOf[1].use[1]!./node_modules/.pnpm/postcss-loader@6.2.1_qjv4cptcpse3y5hrjkrbb7drda/node_modules/postcss-loader/dist/cjs.js??ruleSet[1].rules[7].oneOf[1].use[2]!./node_modules/.pnpm/sass-loader@8.0.2_sass@1.54.4+webpack@5.74.0/node_modules/sass-loader/dist/cjs.js??ruleSet[1].rules[7].oneOf[1].use[3]!./resources/scss/nice-select2.scss ***!
  \**********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_pnpm_css_loader_5_2_7_webpack_5_74_0_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../node_modules/.pnpm/css-loader@5.2.7_webpack@5.74.0/node_modules/css-loader/dist/runtime/api.js */ "./node_modules/.pnpm/css-loader@5.2.7_webpack@5.74.0/node_modules/css-loader/dist/runtime/api.js");
/* harmony import */ var _node_modules_pnpm_css_loader_5_2_7_webpack_5_74_0_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_pnpm_css_loader_5_2_7_webpack_5_74_0_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__);
// Imports

var ___CSS_LOADER_EXPORT___ = _node_modules_pnpm_css_loader_5_2_7_webpack_5_74_0_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default()(function(i){return i[1]});
// Module
___CSS_LOADER_EXPORT___.push([module.id, ".nice-select {\n  -webkit-tap-highlight-color: rgba(0, 0, 0, 0);\n  background-color: #fff;\n  border-radius: 5px;\n  border: solid 1px #e8e8e8;\n  box-sizing: border-box;\n  clear: both;\n  cursor: pointer;\n  display: block;\n  float: left;\n  font-family: inherit;\n  font-size: 14px;\n  font-weight: normal;\n  height: 38px;\n  line-height: 36px;\n  outline: none;\n  padding-left: 18px;\n  padding-right: 30px;\n  position: relative;\n  text-align: left !important;\n  transition: all 0.2s ease-in-out;\n  -webkit-user-select: none;\n     -moz-user-select: none;\n          user-select: none;\n  white-space: nowrap;\n  width: auto;\n}\n.nice-select:hover {\n  border-color: #dbdbdb;\n}\n.nice-select:active, .nice-select.open, .nice-select:focus {\n  border-color: #999;\n}\n.nice-select:after {\n  border-bottom: 2px solid #999;\n  border-right: 2px solid #999;\n  content: \"\";\n  display: block;\n  height: 5px;\n  margin-top: -4px;\n  pointer-events: none;\n  position: absolute;\n  right: 12px;\n  top: 50%;\n  transform-origin: 66% 66%;\n  transform: rotate(45deg);\n  transition: all 0.15s ease-in-out;\n  width: 5px;\n}\n.nice-select.open:after {\n  transform: rotate(-135deg);\n}\n.nice-select.open .nice-select-dropdown {\n  opacity: 1;\n  pointer-events: auto;\n  transform: scale(1) translateY(0);\n}\n.nice-select.disabled {\n  border-color: #ededed;\n  color: #999;\n  pointer-events: none;\n}\n.nice-select.disabled:after {\n  border-color: #cccccc;\n}\n.nice-select.wide {\n  width: 100%;\n}\n.nice-select.wide .nice-select-dropdown {\n  left: 0 !important;\n  right: 0 !important;\n}\n.nice-select.right {\n  float: right;\n}\n.nice-select.right .nice-select-dropdown {\n  left: auto;\n  right: 0;\n}\n.nice-select.small {\n  font-size: 12px;\n  height: 36px;\n  line-height: 34px;\n}\n.nice-select.small:after {\n  height: 4px;\n  width: 4px;\n}\n.nice-select.small .option {\n  line-height: 34px;\n  min-height: 34px;\n}\n.nice-select .nice-select-dropdown {\n  margin-top: 4px;\n  background-color: #fff;\n  border-radius: 5px;\n  box-shadow: 0 0 0 1px rgba(68, 68, 68, 0.11);\n  pointer-events: none;\n  position: absolute;\n  top: 100%;\n  left: 0;\n  transform-origin: 50% 0;\n  transform: scale(0.75) translateY(19px);\n  transition: all 0.2s cubic-bezier(0.5, 0, 0, 1.25), opacity 0.15s ease-out;\n  z-index: 9;\n  opacity: 0;\n}\n.nice-select .list {\n  border-radius: 5px;\n  box-sizing: border-box;\n  overflow: hidden;\n  padding: 0;\n  max-height: 210px;\n  overflow-y: auto;\n}\n.nice-select .list:hover .option:not(:hover) {\n  background-color: transparent !important;\n}\n.nice-select .option {\n  cursor: pointer;\n  font-weight: 400;\n  line-height: 40px;\n  list-style: none;\n  outline: none;\n  padding-left: 18px;\n  padding-right: 29px;\n  text-align: left;\n  transition: all 0.2s;\n}\n.nice-select .option:hover, .nice-select .option.focus, .nice-select .option.selected.focus {\n  background-color: #f6f6f6;\n}\n.nice-select .option.selected {\n  font-weight: bold;\n}\n.nice-select .option.disabled {\n  background-color: transparent;\n  color: #999;\n  cursor: default;\n}\n.nice-select .optgroup {\n  font-weight: bold;\n}\n\n.no-csspointerevents .nice-select .nice-select-dropdown {\n  display: none;\n}\n.no-csspointerevents .nice-select.open .nice-select-dropdown {\n  display: block;\n}\n\n.nice-select .list::-webkit-scrollbar {\n  width: 0;\n}\n\n.nice-select .has-multiple {\n  white-space: inherit;\n  height: auto;\n  padding: 7px 12px;\n  min-height: 36px;\n  line-height: 22px;\n}\n.nice-select .has-multiple span.current {\n  border: 1px solid #CCC;\n  background: #EEE;\n  padding: 0 10px;\n  border-radius: 3px;\n  display: inline-block;\n  line-height: 24px;\n  font-size: 14px;\n  margin-bottom: 3px;\n  margin-right: 3px;\n}\n.nice-select .has-multiple .multiple-options {\n  display: block;\n  line-height: 24px;\n  padding: 0;\n}\n.nice-select .nice-select-search-box {\n  box-sizing: border-box;\n  width: 100%;\n  padding: 5px;\n  pointer-events: none;\n  border-radius: 5px 5px 0 0;\n}\n.nice-select .nice-select-search {\n  box-sizing: border-box;\n  background-color: #fff;\n  border: 1px solid #e8e8e8;\n  border-radius: 3px;\n  color: #444;\n  display: inline-block;\n  vertical-align: middle;\n  padding: 7px 12px;\n  margin: 0 10px 0 0;\n  width: 100%;\n  min-height: 36px;\n  line-height: 22px;\n  height: auto;\n  outline: 0 !important;\n  font-size: 14px;\n}", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/.pnpm/css-loader@5.2.7_webpack@5.74.0/node_modules/css-loader/dist/runtime/api.js":
/*!********************************************************************************************************!*\
  !*** ./node_modules/.pnpm/css-loader@5.2.7_webpack@5.74.0/node_modules/css-loader/dist/runtime/api.js ***!
  \********************************************************************************************************/
/***/ ((module) => {



/*
  MIT License http://www.opensource.org/licenses/mit-license.php
  Author Tobias Koppers @sokra
*/
// css base code, injected by the css-loader
// eslint-disable-next-line func-names
module.exports = function (cssWithMappingToString) {
  var list = []; // return the list of modules as css string

  list.toString = function toString() {
    return this.map(function (item) {
      var content = cssWithMappingToString(item);

      if (item[2]) {
        return "@media ".concat(item[2], " {").concat(content, "}");
      }

      return content;
    }).join("");
  }; // import a list of modules into the list
  // eslint-disable-next-line func-names


  list.i = function (modules, mediaQuery, dedupe) {
    if (typeof modules === "string") {
      // eslint-disable-next-line no-param-reassign
      modules = [[null, modules, ""]];
    }

    var alreadyImportedModules = {};

    if (dedupe) {
      for (var i = 0; i < this.length; i++) {
        // eslint-disable-next-line prefer-destructuring
        var id = this[i][0];

        if (id != null) {
          alreadyImportedModules[id] = true;
        }
      }
    }

    for (var _i = 0; _i < modules.length; _i++) {
      var item = [].concat(modules[_i]);

      if (dedupe && alreadyImportedModules[item[0]]) {
        // eslint-disable-next-line no-continue
        continue;
      }

      if (mediaQuery) {
        if (!item[2]) {
          item[2] = mediaQuery;
        } else {
          item[2] = "".concat(mediaQuery, " and ").concat(item[2]);
        }
      }

      list.push(item);
    }
  };

  return list;
};

/***/ }),

/***/ "./resources/scss/nice-select2.scss":
/*!******************************************!*\
  !*** ./resources/scss/nice-select2.scss ***!
  \******************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_pnpm_style_loader_2_0_0_webpack_5_74_0_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../node_modules/.pnpm/style-loader@2.0.0_webpack@5.74.0/node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/.pnpm/style-loader@2.0.0_webpack@5.74.0/node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_pnpm_style_loader_2_0_0_webpack_5_74_0_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_pnpm_style_loader_2_0_0_webpack_5_74_0_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_pnpm_css_loader_5_2_7_webpack_5_74_0_node_modules_css_loader_dist_cjs_js_ruleSet_1_rules_7_oneOf_1_use_1_node_modules_pnpm_postcss_loader_6_2_1_qjv4cptcpse3y5hrjkrbb7drda_node_modules_postcss_loader_dist_cjs_js_ruleSet_1_rules_7_oneOf_1_use_2_node_modules_pnpm_sass_loader_8_0_2_sass_1_54_4_webpack_5_74_0_node_modules_sass_loader_dist_cjs_js_ruleSet_1_rules_7_oneOf_1_use_3_nice_select2_scss__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../node_modules/.pnpm/css-loader@5.2.7_webpack@5.74.0/node_modules/css-loader/dist/cjs.js??ruleSet[1].rules[7].oneOf[1].use[1]!../../node_modules/.pnpm/postcss-loader@6.2.1_qjv4cptcpse3y5hrjkrbb7drda/node_modules/postcss-loader/dist/cjs.js??ruleSet[1].rules[7].oneOf[1].use[2]!../../node_modules/.pnpm/sass-loader@8.0.2_sass@1.54.4+webpack@5.74.0/node_modules/sass-loader/dist/cjs.js??ruleSet[1].rules[7].oneOf[1].use[3]!./nice-select2.scss */ "./node_modules/.pnpm/css-loader@5.2.7_webpack@5.74.0/node_modules/css-loader/dist/cjs.js??ruleSet[1].rules[7].oneOf[1].use[1]!./node_modules/.pnpm/postcss-loader@6.2.1_qjv4cptcpse3y5hrjkrbb7drda/node_modules/postcss-loader/dist/cjs.js??ruleSet[1].rules[7].oneOf[1].use[2]!./node_modules/.pnpm/sass-loader@8.0.2_sass@1.54.4+webpack@5.74.0/node_modules/sass-loader/dist/cjs.js??ruleSet[1].rules[7].oneOf[1].use[3]!./resources/scss/nice-select2.scss");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_pnpm_style_loader_2_0_0_webpack_5_74_0_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_pnpm_css_loader_5_2_7_webpack_5_74_0_node_modules_css_loader_dist_cjs_js_ruleSet_1_rules_7_oneOf_1_use_1_node_modules_pnpm_postcss_loader_6_2_1_qjv4cptcpse3y5hrjkrbb7drda_node_modules_postcss_loader_dist_cjs_js_ruleSet_1_rules_7_oneOf_1_use_2_node_modules_pnpm_sass_loader_8_0_2_sass_1_54_4_webpack_5_74_0_node_modules_sass_loader_dist_cjs_js_ruleSet_1_rules_7_oneOf_1_use_3_nice_select2_scss__WEBPACK_IMPORTED_MODULE_1__["default"], options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_pnpm_css_loader_5_2_7_webpack_5_74_0_node_modules_css_loader_dist_cjs_js_ruleSet_1_rules_7_oneOf_1_use_1_node_modules_pnpm_postcss_loader_6_2_1_qjv4cptcpse3y5hrjkrbb7drda_node_modules_postcss_loader_dist_cjs_js_ruleSet_1_rules_7_oneOf_1_use_2_node_modules_pnpm_sass_loader_8_0_2_sass_1_54_4_webpack_5_74_0_node_modules_sass_loader_dist_cjs_js_ruleSet_1_rules_7_oneOf_1_use_3_nice_select2_scss__WEBPACK_IMPORTED_MODULE_1__["default"].locals || {});

/***/ }),

/***/ "./node_modules/.pnpm/style-loader@2.0.0_webpack@5.74.0/node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js":
/*!*********************************************************************************************************************************!*\
  !*** ./node_modules/.pnpm/style-loader@2.0.0_webpack@5.74.0/node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js ***!
  \*********************************************************************************************************************************/
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {



var isOldIE = function isOldIE() {
  var memo;
  return function memorize() {
    if (typeof memo === 'undefined') {
      // Test for IE <= 9 as proposed by Browserhacks
      // @see http://browserhacks.com/#hack-e71d8692f65334173fee715c222cb805
      // Tests for existence of standard globals is to allow style-loader
      // to operate correctly into non-standard environments
      // @see https://github.com/webpack-contrib/style-loader/issues/177
      memo = Boolean(window && document && document.all && !window.atob);
    }

    return memo;
  };
}();

var getTarget = function getTarget() {
  var memo = {};
  return function memorize(target) {
    if (typeof memo[target] === 'undefined') {
      var styleTarget = document.querySelector(target); // Special case to return head of iframe instead of iframe itself

      if (window.HTMLIFrameElement && styleTarget instanceof window.HTMLIFrameElement) {
        try {
          // This will throw an exception if access to iframe is blocked
          // due to cross-origin restrictions
          styleTarget = styleTarget.contentDocument.head;
        } catch (e) {
          // istanbul ignore next
          styleTarget = null;
        }
      }

      memo[target] = styleTarget;
    }

    return memo[target];
  };
}();

var stylesInDom = [];

function getIndexByIdentifier(identifier) {
  var result = -1;

  for (var i = 0; i < stylesInDom.length; i++) {
    if (stylesInDom[i].identifier === identifier) {
      result = i;
      break;
    }
  }

  return result;
}

function modulesToDom(list, options) {
  var idCountMap = {};
  var identifiers = [];

  for (var i = 0; i < list.length; i++) {
    var item = list[i];
    var id = options.base ? item[0] + options.base : item[0];
    var count = idCountMap[id] || 0;
    var identifier = "".concat(id, " ").concat(count);
    idCountMap[id] = count + 1;
    var index = getIndexByIdentifier(identifier);
    var obj = {
      css: item[1],
      media: item[2],
      sourceMap: item[3]
    };

    if (index !== -1) {
      stylesInDom[index].references++;
      stylesInDom[index].updater(obj);
    } else {
      stylesInDom.push({
        identifier: identifier,
        updater: addStyle(obj, options),
        references: 1
      });
    }

    identifiers.push(identifier);
  }

  return identifiers;
}

function insertStyleElement(options) {
  var style = document.createElement('style');
  var attributes = options.attributes || {};

  if (typeof attributes.nonce === 'undefined') {
    var nonce =  true ? __webpack_require__.nc : 0;

    if (nonce) {
      attributes.nonce = nonce;
    }
  }

  Object.keys(attributes).forEach(function (key) {
    style.setAttribute(key, attributes[key]);
  });

  if (typeof options.insert === 'function') {
    options.insert(style);
  } else {
    var target = getTarget(options.insert || 'head');

    if (!target) {
      throw new Error("Couldn't find a style target. This probably means that the value for the 'insert' parameter is invalid.");
    }

    target.appendChild(style);
  }

  return style;
}

function removeStyleElement(style) {
  // istanbul ignore if
  if (style.parentNode === null) {
    return false;
  }

  style.parentNode.removeChild(style);
}
/* istanbul ignore next  */


var replaceText = function replaceText() {
  var textStore = [];
  return function replace(index, replacement) {
    textStore[index] = replacement;
    return textStore.filter(Boolean).join('\n');
  };
}();

function applyToSingletonTag(style, index, remove, obj) {
  var css = remove ? '' : obj.media ? "@media ".concat(obj.media, " {").concat(obj.css, "}") : obj.css; // For old IE

  /* istanbul ignore if  */

  if (style.styleSheet) {
    style.styleSheet.cssText = replaceText(index, css);
  } else {
    var cssNode = document.createTextNode(css);
    var childNodes = style.childNodes;

    if (childNodes[index]) {
      style.removeChild(childNodes[index]);
    }

    if (childNodes.length) {
      style.insertBefore(cssNode, childNodes[index]);
    } else {
      style.appendChild(cssNode);
    }
  }
}

function applyToTag(style, options, obj) {
  var css = obj.css;
  var media = obj.media;
  var sourceMap = obj.sourceMap;

  if (media) {
    style.setAttribute('media', media);
  } else {
    style.removeAttribute('media');
  }

  if (sourceMap && typeof btoa !== 'undefined') {
    css += "\n/*# sourceMappingURL=data:application/json;base64,".concat(btoa(unescape(encodeURIComponent(JSON.stringify(sourceMap)))), " */");
  } // For old IE

  /* istanbul ignore if  */


  if (style.styleSheet) {
    style.styleSheet.cssText = css;
  } else {
    while (style.firstChild) {
      style.removeChild(style.firstChild);
    }

    style.appendChild(document.createTextNode(css));
  }
}

var singleton = null;
var singletonCounter = 0;

function addStyle(obj, options) {
  var style;
  var update;
  var remove;

  if (options.singleton) {
    var styleIndex = singletonCounter++;
    style = singleton || (singleton = insertStyleElement(options));
    update = applyToSingletonTag.bind(null, style, styleIndex, false);
    remove = applyToSingletonTag.bind(null, style, styleIndex, true);
  } else {
    style = insertStyleElement(options);
    update = applyToTag.bind(null, style, options);

    remove = function remove() {
      removeStyleElement(style);
    };
  }

  update(obj);
  return function updateStyle(newObj) {
    if (newObj) {
      if (newObj.css === obj.css && newObj.media === obj.media && newObj.sourceMap === obj.sourceMap) {
        return;
      }

      update(obj = newObj);
    } else {
      remove();
    }
  };
}

module.exports = function (list, options) {
  options = options || {}; // Force single-tag solution on IE6-9, which has a hard limit on the # of <style>
  // tags it will allow on a page

  if (!options.singleton && typeof options.singleton !== 'boolean') {
    options.singleton = isOldIE();
  }

  list = list || [];
  var lastIdentifiers = modulesToDom(list, options);
  return function update(newList) {
    newList = newList || [];

    if (Object.prototype.toString.call(newList) !== '[object Array]') {
      return;
    }

    for (var i = 0; i < lastIdentifiers.length; i++) {
      var identifier = lastIdentifiers[i];
      var index = getIndexByIdentifier(identifier);
      stylesInDom[index].references--;
    }

    var newLastIdentifiers = modulesToDom(newList, options);

    for (var _i = 0; _i < lastIdentifiers.length; _i++) {
      var _identifier = lastIdentifiers[_i];

      var _index = getIndexByIdentifier(_identifier);

      if (stylesInDom[_index].references === 0) {
        stylesInDom[_index].updater();

        stylesInDom.splice(_index, 1);
      }
    }

    lastIdentifiers = newLastIdentifiers;
  };
};

/***/ })

}]);