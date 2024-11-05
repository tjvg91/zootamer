"use strict";

function _typeof(obj) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (obj) { return typeof obj; } : function (obj) { return obj && "function" == typeof Symbol && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }, _typeof(obj); }
function _slicedToArray(arr, i) { return _arrayWithHoles(arr) || _iterableToArrayLimit(arr, i) || _unsupportedIterableToArray(arr, i) || _nonIterableRest(); }
function _nonIterableRest() { throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }
function _iterableToArrayLimit(arr, i) { var _i = null == arr ? null : "undefined" != typeof Symbol && arr[Symbol.iterator] || arr["@@iterator"]; if (null != _i) { var _s, _e, _x, _r, _arr = [], _n = !0, _d = !1; try { if (_x = (_i = _i.call(arr)).next, 0 === i) { if (Object(_i) !== _i) return; _n = !1; } else for (; !(_n = (_s = _x.call(_i)).done) && (_arr.push(_s.value), _arr.length !== i); _n = !0); } catch (err) { _d = !0, _e = err; } finally { try { if (!_n && null != _i.return && (_r = _i.return(), Object(_r) !== _r)) return; } finally { if (_d) throw _e; } } return _arr; } }
function _arrayWithHoles(arr) { if (Array.isArray(arr)) return arr; }
function _createForOfIteratorHelper(o, allowArrayLike) { var it = typeof Symbol !== "undefined" && o[Symbol.iterator] || o["@@iterator"]; if (!it) { if (Array.isArray(o) || (it = _unsupportedIterableToArray(o)) || allowArrayLike && o && typeof o.length === "number") { if (it) o = it; var i = 0; var F = function F() {}; return { s: F, n: function n() { if (i >= o.length) return { done: true }; return { done: false, value: o[i++] }; }, e: function e(_e2) { throw _e2; }, f: F }; } throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); } var normalCompletion = true, didErr = false, err; return { s: function s() { it = it.call(o); }, n: function n() { var step = it.next(); normalCompletion = step.done; return step; }, e: function e(_e3) { didErr = true; err = _e3; }, f: function f() { try { if (!normalCompletion && it.return != null) it.return(); } finally { if (didErr) throw err; } } }; }
function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }
function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) arr2[i] = arr[i]; return arr2; }
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }
function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, _toPropertyKey(descriptor.key), descriptor); } }
function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }
function _toPropertyKey(arg) { var key = _toPrimitive(arg, "string"); return _typeof(key) === "symbol" ? key : String(key); }
function _toPrimitive(input, hint) { if (_typeof(input) !== "object" || input === null) return input; var prim = input[Symbol.toPrimitive]; if (prim !== undefined) { var res = prim.call(input, hint || "default"); if (_typeof(res) !== "object") return res; throw new TypeError("@@toPrimitive must return a primitive value."); } return (hint === "string" ? String : Number)(input); }
var merchant = merchant || {};
var _ref = (merchant === null || merchant === void 0 ? void 0 : merchant.setting) || {},
  _ref$clear_cart = _ref.clear_cart,
  clearCartObj = _ref$clear_cart === void 0 ? {} : _ref$clear_cart;
;
(function ($, window, document) {
  $(document).ready(function ($) {
    new ClearCart($);
  });
})(jQuery, window, document);
var ClearCart = /*#__PURE__*/function () {
  function ClearCart() {
    _classCallCheck(this, ClearCart);
    this.timer;
    this.clearCartCookie = 'merchant_clear_cart';
    this.init();
  }
  _createClass(ClearCart, [{
    key: "init",
    value: function init() {
      this.events();
    }
  }, {
    key: "events",
    value: function events() {
      this.clearCartPageLoadAlert();
      this.clearCartButtonAlert();
      this.clearCartAutoAlert();
    }

    /**
     * Clear the cart AJAX
     *
     * @param $button
     */
  }, {
    key: "clearCartAjax",
    value: function clearCartAjax() {
      var _merchant$setting, _merchant$setting2;
      var $button = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : null;
      var $ = jQuery;
      $button === null || $button === void 0 ? void 0 : $button.prop('disabled', true);
      $.ajax({
        url: merchant === null || merchant === void 0 ? void 0 : (_merchant$setting = merchant.setting) === null || _merchant$setting === void 0 ? void 0 : _merchant$setting.ajax_url,
        type: 'POST',
        data: {
          action: 'clear_cart',
          nonce: merchant === null || merchant === void 0 ? void 0 : (_merchant$setting2 = merchant.setting) === null || _merchant$setting2 === void 0 ? void 0 : _merchant$setting2.nonce
        },
        success: function success(response) {
          if (response.success) {
            var _response$data;
            var redirectUrl = (_response$data = response.data) === null || _response$data === void 0 ? void 0 : _response$data.url;
            $(document.body).trigger('wc_cart_emptied');
            if (redirectUrl) {
              window.location.href = redirectUrl;
            } else {
              // If no redirect URL, refresh the Cart table & Mini/Side Cart
              $(document.body).trigger('wc_update_cart').trigger('wc_fragment_refresh');
            }
          }
        },
        error: function error(_error) {
          console.log(_error);
        },
        complete: function complete() {
          $button === null || $button === void 0 ? void 0 : $button.prop('disabled', false);
        }
      });
    }

    /**
     * Check if time passed as soon as the page loaded and show the alert if so.
     */
  }, {
    key: "clearCartPageLoadAlert",
    value: function clearCartPageLoadAlert() {
      var that = this;
      jQuery(window).on('load', function () {
        if (!(clearCartObj !== null && clearCartObj !== void 0 && clearCartObj.auto_clear)) {
          that.deleteClearCartCookie();
          return;
        }
        var expirationTime = that.getCookie(that.clearCartCookie);
        if (expirationTime && that.getCurrentTime() > expirationTime) {
          setTimeout(function () {
            return that.showClearCartAlert();
          }, 1000);
        }
      });
    }

    /**
     * Show Alert on Clear Cart Button Click
     */
  }, {
    key: "clearCartButtonAlert",
    value: function clearCartButtonAlert() {
      var $ = jQuery;
      var that = this;

      // Clear Cart On Button Click
      $(document).on('click', '.merchant-clear-cart-button', function (e) {
        e.preventDefault();
        that.showClearCartAlert($(this));

        // Sometimes the cookie doesn't clear automatically when the clear button is clicked on the home page (or other pages).
        // In those cases, delete it after a short delay.
        setTimeout(function () {
          return that.deleteClearCartCookie();
        }, 1000);
      });
    }

    /**
     * Auto Clear Cart
     */
  }, {
    key: "clearCartAutoAlert",
    value: function clearCartAutoAlert() {
      var $ = jQuery;
      var that = this;
      var is_product_single = clearCartObj.is_product_single,
        is_cart_page = clearCartObj.is_cart_page,
        auto_clear = clearCartObj.auto_clear,
        total_items = clearCartObj.total_items,
        threshold = clearCartObj.threshold,
        added_to_cart_no_ajax = clearCartObj.added_to_cart_no_ajax;

      // Cart is being emptied
      $(document.body).on('wc_cart_emptied', function (event) {
        that.deleteClearCartCookie();
      });

      // All Removed in Side/Mini Cart
      $(document.body).on('removed_from_cart', function (event, fragments, hash, button) {
        if (!hash) {
          that.deleteClearCartCookie();
        }
      });

      // Product Single Page
      if (auto_clear && added_to_cart_no_ajax) {
        var expireTime = that.setClearCartCookie();
        that.timer = setTimeout(function () {
          return that.showClearCartAlert();
        }, expireTime);
      }

      // Adding & Updating Qty - AJAX.
      $(document.body).on('wc_fragment_refresh added_to_cart updated_wc_div removed_from_cart', function (event, data, hash, button) {
        // Cart Page
        if ((event === null || event === void 0 ? void 0 : event.type) === 'updated_wc_div' && is_cart_page && !$('.woocommerce-cart-form').length) {
          that.deleteClearCartCookie();
          return;
        }

        // Product Single
        if (is_product_single && (event === null || event === void 0 ? void 0 : event.type) === 'wc_fragment_refresh') {
          that.deleteClearCartCookie();
          return;
        }

        // If All items removed.
        if ((event === null || event === void 0 ? void 0 : event.type) === 'removed_from_cart' && !hash) {
          return;
        }
        var refreshCookie = total_items >= threshold;
        if (data && data['.merchant_clear_cart_cart_count'] !== undefined) {
          refreshCookie = data['.merchant_clear_cart_cart_count'] >= threshold;
          if (!refreshCookie) {
            that.deleteClearCartCookie();
            return;
          }
        }
        if (auto_clear && refreshCookie) {
          var _expireTime = that.setClearCartCookie();
          that.timer = setTimeout(function () {
            return that.showClearCartAlert();
          }, _expireTime);
        }
      });
    }

    /**
     * Show Alert.
     *
     * @param $button
     */
  }, {
    key: "showClearCartAlert",
    value: function showClearCartAlert() {
      var $button = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : null;
      var that = this;
      var expirationTime = that.getCookie(that.clearCartCookie);
      if (!expirationTime && !$button.length) {
        that.deleteClearCartCookie();
        return;
      }
      var message = $button && $button.length ? clearCartObj === null || clearCartObj === void 0 ? void 0 : clearCartObj.popup_message : clearCartObj === null || clearCartObj === void 0 ? void 0 : clearCartObj.popup_message_inactive;
      if (window.confirm(message)) {
        that.deleteClearCartCookie();
        that.clearCartAjax($button);
      } else {
        if (!$button) {
          var expireTime = that.setClearCartCookie();
          that.timer = setTimeout(function () {
            return that.showClearCartAlert();
          }, expireTime);
        }
      }
    }

    /**
     * Set Clear Cart Cookie.
     *
     * @returns {number}
     */
  }, {
    key: "setClearCartCookie",
    value: function setClearCartCookie() {
      clearTimeout(this.timer);
      var _ref2 = clearCartObj || {},
        expiration_time = _ref2.expiration_time,
        wc_session_expiration_time = _ref2.wc_session_expiration_time;
      var cartExpireDuration = expiration_time * 1000;
      var cartExpireTime = this.getCurrentTime() + cartExpireDuration; // millisecond
      var cookieExpireTime = this.getCurrentTime() + wc_session_expiration_time * 1000; // millisecond

      this.setCookie(this.clearCartCookie, cartExpireTime, cookieExpireTime);
      return cartExpireDuration;
    }

    /**
     * Delete Clear Cart Cookie.
     */
  }, {
    key: "deleteClearCartCookie",
    value: function deleteClearCartCookie() {
      clearTimeout(this.timer);
      this.deleteCookie(this.clearCartCookie);
    }

    /**
     * Get Current time.
     *
     * @param time
     * @returns {number|Date}
     */
  }, {
    key: "getCurrentTime",
    value: function getCurrentTime() {
      var time = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : true;
      var date = new Date();
      return time ? date.getTime() : date;
    }

    /**
     * Set Cookie Helper.
     *
     * @param name
     * @param value
     * @param expiration
     */
  }, {
    key: "setCookie",
    value: function setCookie(name, value, expiration) {
      var date = new Date(expiration);
      var expires = "expires=".concat(date.toUTCString());
      document.cookie = "".concat(name, "=").concat(value, ";").concat(expires, ";path=/");
    }

    /**
     * Get Cookie Helper.
     *
     * @param name
     * @returns {null|string}
     */
  }, {
    key: "getCookie",
    value: function getCookie(name) {
      var cookies = document.cookie.split(';');
      var _iterator = _createForOfIteratorHelper(cookies),
        _step;
      try {
        for (_iterator.s(); !(_step = _iterator.n()).done;) {
          var cookie = _step.value;
          var _cookie$trim$split = cookie.trim().split('='),
            _cookie$trim$split2 = _slicedToArray(_cookie$trim$split, 2),
            cookieName = _cookie$trim$split2[0],
            cookieValue = _cookie$trim$split2[1];
          if (cookieName === name) {
            return decodeURIComponent(cookieValue);
          }
        }
      } catch (err) {
        _iterator.e(err);
      } finally {
        _iterator.f();
      }
      return null;
    }

    /**
     * Delete Cookie Helper.
     *
     * @param name
     */
  }, {
    key: "deleteCookie",
    value: function deleteCookie(name) {
      document.cookie = "".concat(name, "=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;");
    }
  }]);
  return ClearCart;
}();