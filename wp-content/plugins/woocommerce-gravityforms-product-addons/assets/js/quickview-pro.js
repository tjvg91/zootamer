

gform.tools.trigger( 'gform_main_scripts_loaded' );
jQuery(document).trigger('gform_post_render', [1, 1]);

gform.initializeOnLoaded(function () {
    jQuery(document).on('gform_post_render', function (event, formId, currentPage) {
        if (formId == 1) {
            gf_global["number_formats"][1] = {
                "1": {
                    "price": "decimal_dot",
                    "value": false
                },
                "15": {
                    "price": false,
                    "value": false
                },
                "13": {
                    "price": "decimal_dot",
                    "value": false
                },
                "3": {
                    "price": "decimal_dot",
                    "value": false
                },
                "11": {
                    "price": false,
                    "value": false
                },
                "14": {
                    "price": "decimal_dot",
                    "value": false
                },
                "2": {
                    "price": false,
                    "value": false
                },
                "12": {
                    "price": false,
                    "value": "decimal_dot"
                }
            };
            if (window['jQuery']) {
                if (!window['gf_form_conditional_logic']) {
                    window['gf_form_conditional_logic'] = new Array();
                }
                window['gf_form_conditional_logic'][1] = {
                    logic: {
                        11: {
                            "field": {
                                "enabled": true,
                                "actionType": "show",
                                "logicType": "all",
                                "rules": [{
                                    "fieldId": "gspc_quantity",
                                    "operator": "is",
                                    "value": ""
                                }]
                            },
                            "nextButton": null,
                            "section": null
                        }
                    },
                    dependents: {
                        11: [11]
                    },
                    animation: 0,
                    defaults: {
                        "1": {
                            "1.1": "",
                            "1.2": "$0.00",
                            "1.3": ""
                        },
                        "15": "{wc_product:name} - {wc_product:price}",
                        "14": {
                            "14.1": "",
                            "14.2": "$100.00",
                            "14.3": ""
                        }
                    },
                    fields: {
                        "1": [],
                        "15": [],
                        "13": [],
                        "3": [],
                        "11": [],
                        "14": [],
                        "2": [],
                        "12": []
                    }
                };
                if (!window['gf_number_format']) {
                    window['gf_number_format'] = 'decimal_dot';
                }


                jQuery(document).ready(function () {
                    gform.utils.trigger({
                        event: 'gform/conditionalLogic/init/start',
                        native: false,
                        data: {
                            formId: 1,
                            fields: null,
                            isInit: true
                        }
                    });
                    window['gformInitPriceFields']();
                    gf_apply_rules(1, [11], true);
                    debugger;
                    jQuery('#gform_wrapper_1').show();
                    jQuery('#gform_wrapper_1 form').css('opacity', '');
                    jQuery(document).trigger('gform_post_conditional_logic', [1, null, true]);
                    gform.utils.trigger({
                        event: 'gform/conditionalLogic/init/end',
                        native: false,
                        data: {
                            formId: 1,
                            fields: null,
                            isInit: true
                        }
                    });
                });
            }


            if (window["gformInitPriceFields"]) {
                jQuery(document).ready(function () {
                    gformInitPriceFields();
                });
            }
        }
    });
    jQuery(document).on('gform_post_conditional_logic', function (event, formId, fields, isInit) {
    })
});

gform.initializeOnLoaded(function () {
    jQuery(document).trigger("gform_pre_post_render", [{
        formId: "1",
        currentPage: "1",
        abort: function () {
            this.preventDefault();
        }
    }]);
    if (event && event.defaultPrevented) {
        return;
    }
    const gformWrapperDiv = document.getElementById("gform_wrapper_1");
    if (gformWrapperDiv) {
        const visibilitySpan = document.createElement("span");
        visibilitySpan.id = "gform_visibility_test_1";
        gformWrapperDiv.insertAdjacentElement("afterend", visibilitySpan);
    }
    const visibilityTestDiv = document.getElementById("gform_visibility_test_1");
    let postRenderFired = false;

    function triggerPostRender() {
        if (postRenderFired) {
            return;
        }
        postRenderFired = true;
        jQuery(document).trigger('gform_post_render', [1, 1]);
        gform.utils.trigger({
            event: 'gform/postRender',
            native: false,
            data: {
                formId: 1,
                currentPage: 1
            }
        });
        if (visibilityTestDiv) {
            visibilityTestDiv.parentNode.removeChild(visibilityTestDiv);
        }
    }

    function debounce(func, wait, immediate) {
        var timeout;
        return function () {
            var context = this
                , args = arguments;
            var later = function () {
                timeout = null;
                if (!immediate) {
                    func.apply(context, args);
                }
            };
            var callNow = immediate && !timeout;
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
            if (callNow) {
                func.apply(context, args);
            }
        }
            ;
    }

    const debouncedTriggerPostRender = debounce(function () {
        triggerPostRender();
    }, 200);
    if (visibilityTestDiv && visibilityTestDiv.offsetParent === null) {
        const observer = new MutationObserver((mutations) => {
                mutations.forEach((mutation) => {
                        if (mutation.type === 'attributes' && visibilityTestDiv.offsetParent !== null) {
                            debouncedTriggerPostRender();
                            observer.disconnect();
                        }
                    }
                );
            }
        );
        observer.observe(document.body, {
            attributes: true,
            childList: false,
            subtree: true,
            attributeFilter: ['style', 'class'],
        });
    } else {
        triggerPostRender();
    }
});
