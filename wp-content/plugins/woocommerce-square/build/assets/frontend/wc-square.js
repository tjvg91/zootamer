(()=>{"use strict";jQuery(document).ready((e=>{window.WC_Square_Payment_Form_Handler=class{constructor(t){if(this.id=t.id,this.id_dasherized=t.id_dasherized,this.csc_required=t.csc_required,this.enabled_card_types=t.enabled_card_types,this.square_card_types=t.square_card_types,this.ajax_log_nonce=t.ajax_log_nonce,this.ajax_url=t.ajax_url,this.application_id=t.application_id,this.currency_code=t.currency_code,this.general_error=t.general_error,this.input_styles=t.input_styles,this.is_add_payment_method_page=t.is_add_payment_method_page,this.is_checkout_registration_enabled=t.is_checkout_registration_enabled,this.is_user_logged_in=t.is_user_logged_in,this.location_id=t.location_id,this.logging_enabled=t.logging_enabled,this.ajax_wc_checkout_validate_nonce=t.ajax_wc_checkout_validate_nonce,this.is_manual_order_payment=t.is_manual_order_payment,this.current_postal_code_value="",this.payment_token_nonce=t.payment_token_nonce,this.payment_token_status=!0,this.billing_details_message_wrapper=e("#square-pay-for-order-billing-details-wrapper"),this.orderId=t.order_id,this.ajax_get_order_amount_nonce=t.ajax_get_order_amount_nonce,e("form.checkout").length)this.form=e("form.checkout"),this.handle_checkout_page();else if(e("form#order_review").length)this.form=e("form#order_review"),this.handle_pay_page();else{if(!e("form#add_payment_method").length)return void this.log("No payment form found!");this.form=e("form#add_payment_method"),this.handle_add_payment_method_page()}this.params=window.sv_wc_payment_gateway_payment_form_params,e(document.body).on("checkout_error",(()=>{e("input[name=wc-square-credit-card-payment-nonce]").val(""),e("input[name=wc-square-credit-card-buyer-verification-token]").val("")})),e(document.body).on("change",`#payment_method_${this.id}`,(()=>{this.payment_form&&(this.log("Recalculating payment form size"),this.payment_form.recalculateSize())})),e('input[name="payment_method"]').on("change",(t=>{this.billing_details_message_wrapper.length&&("square_credit_card"===e(t.target).val()&&e(t.target).prop("checked")?this.billing_details_message_wrapper.slideDown():this.billing_details_message_wrapper.slideUp(),e(document.body).trigger("country_to_state_changed"))})).trigger("change")}handle_checkout_page(){e(document.body).on("updated_checkout",(()=>this.set_payment_fields())),e(document.body).on("updated_checkout",(()=>this.handle_saved_payment_methods())),this.form.on(`checkout_place_order_${this.id}`,(()=>this.validate_payment_data()))}handle_saved_payment_methods(){const t=this.id_dasherized,i=this,n=e(`div.js-wc-${t}-new-payment-method-form`);e(`input.js-wc-${this.id_dasherized}-payment-token`).on("change",(()=>{e(`input.js-wc-${t}-payment-token:checked`).val()?n.slideUp(200):n.slideDown(200)})).trigger("change"),e("input#createaccount").on("change",(n=>{e(n.target).is(":checked")?i.show_save_payment_checkbox(t):i.hide_save_payment_checkbox(t)})),e("input#createaccount").is(":checked")||e("input#createaccount").trigger("change"),this.is_user_logged_in||this.is_checkout_registration_enabled||this.hide_save_payment_checkbox(t)}handle_pay_page(){this.set_payment_fields(),this.handle_saved_payment_methods();const t=this;this.form.on("submit",(function(){if(e("#order_review input[name=payment_method]:checked").val()===t.id)return t.validate_payment_data()}))}handle_add_payment_method_page(){this.set_payment_fields();const t=this;this.form.on("submit",(function(){if(e("#add_payment_method input[name=payment_method]:checked").val()===t.id)return t.validate_payment_data()}))}set_payment_fields(){if(this.payment_form)return e("#wc-square-credit-card-container .sq-card-iframe-container").children().length?void this.payment_form.configure({postalCode:e("#billing_postcode").val()}):(this.log("Destroying payment form"),void this.payment_form.destroy().then((()=>{this.log("Re-building payment form"),this.initializeCard(this.payments)})));this.log("Building payment form");const{applicationId:t,locationId:i}=this.get_form_params();this.payments=window.Square.payments(t,i),this.initializeCard(this.payments)}initializeCard(t){let i=e("#billing_postcode").val();i=i||"",t.card({postalCode:i}).then((e=>{document.getElementById("wc-square-credit-card-container")&&(e.attach("#wc-square-credit-card-container"),this.payment_form=e,this.log("Payment form loaded"))}))}get_form_params(){return{applicationId:this.application_id,locationId:this.location_id}}validate_payment_data(){if(!this.payment_token_status)return this.payment_token_status=!0,!0;if(this.form.is(".processing"))return!1;if(this.has_nonce())return this.log("Payment nonce present, placing order"),!0;const e=this.get_tokenized_payment_method_id();return e?this.has_verification_token()?(this.log("Tokenized payment verification token present, placing order"),!0):(this.log("Requesting verification token for tokenized payment"),this.block_ui(),fetch(`${wc_checkout_params.ajax_url}?action=wc_square_credit_card_get_token_by_id&token_id=${e}&nonce=${this.payment_token_nonce}`).then((e=>{if(e.ok)return e.json();throw new Error("Error in fetching payment token by ID.")})).then((({success:e,data:t})=>{e?(this.log("Requesting verification token for tokenized payment"),this.block_ui(),this.get_verification_details().then((e=>this.payments.verifyBuyer(t,e).then((e=>{this.handle_verify_buyer_response(!1,e)})).catch((e=>{this.handle_errors([e])}))))):(this.payment_token_status=!1,this.form.trigger("submit"),this.log(t))})),!1):(this.log("Requesting payment nonce"),this.block_ui(),this.handleSubmission(),!1)}handleSubmission(){this.payment_form.tokenize().then((e=>{const{token:t,details:i,status:n}=e;"OK"===n?this.handle_card_nonce_response(t,i):e.errors&&this.handle_errors(e.errors)}))}get_tokenized_payment_method_id(){return e(`.payment_method_${this.id}`).find(".js-wc-square-credit-card-payment-token:checked").val()}handle_card_nonce_response(t,i){const{card:n,billing:a}=i;if(!t){const e="Nonce is missing from the Square response";return this.log(e,"error"),this.log_data(e,"response"),this.handle_errors()}this.log("Card data received"),this.log(n),this.log_data(n,"response"),n.last4&&e(`input[name=wc-${this.id_dasherized}-last-four]`).val(n.last4),n.expMonth&&e(`input[name=wc-${this.id_dasherized}-exp-month]`).val(n.expMonth),n.expYear&&e(`input[name=wc-${this.id_dasherized}-exp-year]`).val(n.expYear),a?.postalCode&&e(`input[name=wc-${this.id_dasherized}-payment-postcode]`).val(a.postalCode),n.brand&&e(`input[name=wc-${this.id_dasherized}-card-type]`).val(n.brand),e(`input[name=wc-${this.id_dasherized}-payment-nonce]`).val(t),this.log("Verifying buyer"),this.get_verification_details().then((e=>this.payments.verifyBuyer(t,e).then((e=>{this.handle_verify_buyer_response(!1,e)})).catch((e=>{this.handle_errors([e])}))))}handle_verify_buyer_response(t,i){if(t)return e(t).each(((e,t)=>{t.field||(t.field="none")})),this.handle_errors(t);if(!i||!i.token){const e="Verification token is missing from the Square response";return this.log(e,"error"),this.log_data(e,"response"),this.handle_errors()}this.log("Verification result received"),this.log(i),e(`input[name=wc-${this.id_dasherized}-buyer-verification-token]`).val(i.token),this.form.trigger("submit")}get_verification_details(){const t={billingContact:{familyName:e("#billing_last_name").val()||"",givenName:e("#billing_first_name").val()||"",email:e("#billing_email").val()||"",country:e("#billing_country").val()||"",region:e("#billing_state").val()||"",city:e("#billing_city").val()||"",postalCode:e("#billing_postcode").val()||"",phone:e("#billing_phone").val()||"",addressLines:[e("#billing_address_1").val()||"",e("#billing_address_2").val()||""]},intent:this.get_intent()};return"CHARGE"===t.intent?(t.currencyCode=this.currency_code,this.get_amount().then((e=>(t.amount=e,this.log(t),t)))):new Promise((e=>{this.log(t),e(t)}))}get_intent(){const t=e("#wc-square-credit-card-tokenize-payment-method");let i;return i=t.is("input:checkbox")?t.is(":checked"):"true"===t.val(),!this.get_tokenized_payment_method_id()&&i?"STORE":"CHARGE"}get_amount(){return new Promise(((t,i)=>{const n={action:"wc_"+this.id+"_get_order_amount",security:this.ajax_get_order_amount_nonce,order_id:this.orderId,is_pay_order:this.is_manual_order_payment};e.ajax({url:this.ajax_url,method:"post",cache:!1,data:n,complete:e=>{const n=e.responseJSON;return n&&n.success?t(n.data):i(n)}})}))}handle_errors(t=null){this.log("Error getting payment data","error"),e("input[name=wc-square-credit-card-payment-nonce]").val(""),e("input[name=wc-square-credit-card-buyer-verification-token]").val("");const i=[];if(t){const n=["none","cardNumber","expirationDate","cvv","postalCode"];t.length>=1&&t.sort(((e,t)=>n.indexOf(e.field)-n.indexOf(t.field))),e(t).each(((e,n)=>"UNSUPPORTED_CARD_BRAND"===n.type||"VALIDATION_ERROR"===n.type?i.push(n.message):this.log_data(t,"response")))}0===i.length&&i.push(this.general_error),this.is_add_payment_method_page||this.is_manual_order_payment?this.render_errors(i):this.render_checkout_errors(i),this.unblock_ui()}render_errors(t){e(".woocommerce-error, .woocommerce-message").remove(),this.form.prepend('<ul class="woocommerce-error"><li>'+t.join("</li><li>")+"</li></ul>"),this.form.removeClass("processing").unblock(),this.form.find(".input-text, select").trigger("blur"),e("html, body").animate({scrollTop:this.form.offset().top-100},1e3)}block_ui(){this.form.block({message:null,overlayCSS:{background:"#fff",opacity:.6}})}unblock_ui(){return this.form.unblock()}hide_save_payment_checkbox(t){const i=e(`input.js-wc-${t}-tokenize-payment-method`).closest("p.form-row");i.hide(),i.next().hide()}show_save_payment_checkbox(t){const i=e(`input.js-wc-${t}-tokenize-payment-method`).closest("p.form-row");i.slideDown(),i.next().show()}has_nonce(){return e(`input[name=wc-${this.id_dasherized}-payment-nonce]`).val()}has_verification_token(){return e(`input[name=wc-${this.id_dasherized}-buyer-verification-token]`).val()}log_data(t,i){if(!this.logging_enabled)return;const n={action:"wc_"+this.id+"_log_js_data",security:this.ajax_log_nonce,type:i,data:t};e.ajax({url:this.ajax_url,data:n})}log(e,t="notice"){this.logging_enabled&&("error"===t?console.error("Square Error: "+e):console.log("Square: "+e))}render_checkout_errors(t){const i=(window.wc_cart_fragments_params||window.wc_cart_params||window.wc_checkout_params).wc_ajax_url.toString().replace("%%endpoint%%",this.id+"_checkout_handler"),n=this,a=this.form.serializeArray();return a.push({name:"wc_"+this.id+"_checkout_validate_nonce",value:this.ajax_wc_checkout_validate_nonce}),e.ajax({url:i,method:"post",cache:!1,data:a,complete:i=>{const a=i.responseJSON;a.hasOwnProperty("result")&&"failure"===a.result?e(a.messages).map((i=>{const n=[];return e(i).children("li").each((()=>{n.push(e(this).text().trim())})),t.unshift(...n)})):a.hasOwnProperty("success")&&!a.success&&t.unshift(...a.data.messages),n.render_errors(t)}})}},class{static SELECTORS={PAYMENT_METHOD_CHECKBOX:"#payment_method_square_credit_card",PAYMENT_METHOD_FORM:"#payment",ERROR_NOTICE:".woocommerce-NoticeGroup-checkout"};static init(){e(document.body).on("checkout_error",(()=>{this.isSquareCreditCardPaymentSelected()&&this.handleCheckoutError()}))}static handleCheckoutError(){this.repositionNotice(),this.cancelAllScrolling(),this.isNoticeOffscreen()&&this.scrollToNotice()}static isSquareCreditCardPaymentSelected(){const t=e(this.SELECTORS.PAYMENT_METHOD_CHECKBOX);return t.length>0&&t.is(":checked")}static repositionNotice(){const t=e(this.SELECTORS.ERROR_NOTICE),i=e(this.SELECTORS.PAYMENT_METHOD_FORM);t.length&&i.length&&t.insertBefore(i)}static cancelAllScrolling(){e("html, body").stop()}static isNoticeOffscreen(){const t=e(this.SELECTORS.ERROR_NOTICE);return t.length&&(t[0].getBoundingClientRect().bottom<=0||t[0].getBoundingClientRect().top>=window.innerHeight)}static scrollToNotice(){e(this.SELECTORS.ERROR_NOTICE)[0].scrollIntoView({behavior:"smooth",block:"start"})}}.init()}))})();