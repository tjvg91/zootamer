"use strict";

function _typeof(obj) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (obj) { return typeof obj; } : function (obj) { return obj && "function" == typeof Symbol && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }, _typeof(obj); }
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }
function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, _toPropertyKey(descriptor.key), descriptor); } }
function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }
function _toPropertyKey(arg) { var key = _toPrimitive(arg, "string"); return _typeof(key) === "symbol" ? key : String(key); }
function _toPrimitive(input, hint) { if (_typeof(input) !== "object" || input === null) return input; var prim = input[Symbol.toPrimitive]; if (prim !== undefined) { var res = prim.call(input, hint || "default"); if (_typeof(res) !== "object") return res; throw new TypeError("@@toPrimitive must return a primitive value."); } return (hint === "string" ? String : Number)(input); }
(function ($) {
  'use strict';

  /**
   * MerchantSideCartAdminPreview
   * Add tweaks to control the side cart upsell groups label in the module settings page.
   */
  var MerchantSideCartAdminPreview = /*#__PURE__*/function () {
    function MerchantSideCartAdminPreview() {
      _classCallCheck(this, MerchantSideCartAdminPreview);
      this.init();
    }

    /**
     * Initialize the logic.
     */
    _createClass(MerchantSideCartAdminPreview, [{
      key: "init",
      value: function init() {
        this.events();
        this.flexibleContentLabel();
      }

      /**
       * Events.
       */
    }, {
      key: "events",
      value: function events() {
        $(document).on('change keyup merchant.change', '.merchant-module-page-setting-fields', this.flexibleContentLabel.bind(this));
      }

      /**
       * Update the label of the upsell groups in the side cart settings page based on the selected options.
       */
    }, {
      key: "flexibleContentLabel",
      value: function flexibleContentLabel() {
        var self = this;
        if (this.cartUpsellsToggleState() && this.cartUpsellType() === 'custom_upsell') {
          var upsellsGroups = $('.merchant-field-custom_upsells .merchant-flexible-content .layout');
          upsellsGroups.each(function () {
            var group = $(this),
              trigger = self.customUpsellTrigger(group),
              categories = self.customUpsellCategories(group),
              products = self.customUpsellProducts(group);
            if ('categories' === trigger) {
              self.updateGroupLabel(group, 'categories', categories.length, categories);
            }
            if ('products' === trigger) {
              self.updateGroupLabel(group, 'products', products.length, products);
            }
            if ('all' === trigger) {
              self.updateGroupLabel(group, 'all', 10, []);
            }
          });
        }
      }

      /**
       * Get the upsells count label badge.
       * @param group {jQuery} The upsell group.
       * @returns {string}
       */
    }, {
      key: "upsellsLabelBadge",
      value: function upsellsLabelBadge(group) {
        var upsellsType = group.find('.merchant-field-custom_upsell_type select').val();
        if ('products' === upsellsType) {
          var products = group.find('.merchant-field-upsells_product_ids .merchant-selected-products-preview li');
          if (products.length) {
            return "<span class=\"merchant-upsells-badge\">Upsells: ".concat(products.length, "</span>");
          }
        }
        return '';
      }

      /**
       * Update the group label based on the selected options.
       * @param group {jQuery} The upsell group.
       * @param type {string} The type of the upsell group
       * @param count {number} The count of the selected items
       * @param data {Array} The selected items data
       */
    }, {
      key: "updateGroupLabel",
      value: function updateGroupLabel(group, type, count, data) {
        var groupLabel = group.find('.layout-title');
        if ('categories' === type) {
          if (count > 1) {
            groupLabel.html(merchant_side_cart_params.keywords.multi_categories + this.upsellsLabelBadge(group));
          } else if (count === 1) {
            groupLabel.html(merchant_side_cart_params.keywords.category_trigger + ' ' + data[0] + this.upsellsLabelBadge(group));
          } else {
            groupLabel.html(merchant_side_cart_params.keywords.no_cats_selected + this.upsellsLabelBadge(group));
          }
        }
        if ('products' === type) {
          if (count > 1) {
            groupLabel.html(merchant_side_cart_params.keywords.multi_products + this.upsellsLabelBadge(group));
          } else if (count === 1) {
            groupLabel.html(data[0].name + ' (#' + data[0].id + ')' + this.upsellsLabelBadge(group));
          } else {
            groupLabel.html(merchant_side_cart_params.keywords.no_products_selected + this.upsellsLabelBadge(group));
          }
        }
        if ('all' === type) {
          groupLabel.html(merchant_side_cart_params.keywords.all_products + this.upsellsLabelBadge(group));
        }
      }

      /**
       * Get the selected trigger for the upsell group.
       * @param group {jQuery} The upsell group.
       * @returns {string} The selected trigger value.
       */
    }, {
      key: "customUpsellTrigger",
      value: function customUpsellTrigger(group) {
        return group.find('.merchant-field-upsell_based_on select').val();
      }

      /**
       * Get the selected products for the upsell group.
       * @param group {jQuery} The upsell group.
       * @returns {Array} The selected products data.
       */
    }, {
      key: "customUpsellProducts",
      value: function customUpsellProducts(group) {
        var foundProducts = group.find('.merchant-field-product_ids .merchant-selected-products-preview li');
        var products = [];
        foundProducts.each(function () {
          products.push({
            id: $(this).data('id'),
            name: $(this).data('name'),
            element: $(this)
          });
        });
        return products;
      }

      /**
       * Get the selected categories for the upsell group.
       * @param group {jQuery} The upsell group.
       * @returns {Array} The selected categories.
       */
    }, {
      key: "customUpsellCategories",
      value: function customUpsellCategories(group) {
        var upsellDropdown = group.find('.merchant-field-category_slugs select');
        return upsellDropdown.find('option:selected').map(function () {
          return $(this).text().trim();
        }).get();
      }

      /**
       * Check the state of the upsells main toggle.
       * @returns {boolean} True if the toggle is checked otherwise false.
       */
    }, {
      key: "cartUpsellsToggleState",
      value: function cartUpsellsToggleState() {
        var toggle = $('.merchant-field-use_upsells input');
        return !!toggle.is(':checked');
      }

      /**
       * Get the selected upsell type.
       * @returns {string} The selected upsell type.
       */
    }, {
      key: "cartUpsellType",
      value: function cartUpsellType() {
        // custom_upsell
        var type = $('.merchant-field-upsells_type select');
        return type.val();
      }
    }]);
    return MerchantSideCartAdminPreview;
  }(); // Instantiate the class when the DOM is ready
  $(document).ready(function () {
    new MerchantSideCartAdminPreview();
  });
})(jQuery);