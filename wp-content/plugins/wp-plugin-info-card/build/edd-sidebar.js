(()=>{var e={694:(e,t,n)=>{"use strict";var r=n(925);function l(){}function o(){}o.resetWarningCache=l,e.exports=function(){function e(e,t,n,l,o,i){if(i!==r){var a=new Error("Calling PropTypes validators directly is not supported by the `prop-types` package. Use PropTypes.checkPropTypes() to call them. Read more at http://fb.me/use-check-prop-types");throw a.name="Invariant Violation",a}}function t(){return e}e.isRequired=e;var n={array:e,bigint:e,bool:e,func:e,number:e,object:e,string:e,symbol:e,any:e,arrayOf:t,element:e,elementType:e,instanceOf:t,node:e,objectOf:t,oneOf:t,oneOfType:t,shape:t,exact:t,checkPropTypes:o,resetWarningCache:l};return n.PropTypes=n,n}},556:(e,t,n)=>{e.exports=n(694)()},925:e=>{"use strict";e.exports="SECRET_DO_NOT_PASS_THIS_OR_YOU_WILL_BE_FIRED"}},t={};function n(r){var l=t[r];if(void 0!==l)return l.exports;var o=t[r]={exports:{}};return e[r](o,o.exports,n),o.exports}n.n=e=>{var t=e&&e.__esModule?()=>e.default:()=>e;return n.d(t,{a:t}),t},n.d=(e,t)=>{for(var r in t)n.o(t,r)&&!n.o(e,r)&&Object.defineProperty(e,r,{enumerable:!0,get:t[r]})},n.o=(e,t)=>Object.prototype.hasOwnProperty.call(e,t),(()=>{"use strict";var e=n(556),t=n.n(e),r=function(e){return React.createElement("svg",{version:"1.1",id:"Calque_1",xmlns:"http://www.w3.org/2000/svg",x:"0px",y:"0px",width:e.width,height:e.height,viewBox:"0 0 850.39 850.39",enableBackground:"new 0 0 850.39 850.39"},React.createElement("path",{fill:e.fill,d:"M425.195,2C190.366,2,0,191.918,0,426.195C0,660.472,190.366,850.39,425.195,850.39\nc234.828,0,425.195-189.918,425.195-424.195C850.39,191.918,660.023,2,425.195,2z M662.409,476.302l-2.624,4.533L559.296,654.451\nl78.654,45.525l-228.108,105.9L388.046,555.33l78.653,45.523l69.391-119.887l-239.354-0.303l-94.925-0.337l-28.75-0.032l-0.041-0.07\nh0l-24.361-42.303l28.111-48.563l109.635-189.419l-78.653-45.524L435.859,48.514l21.797,250.546l-78.654-45.525l-69.391,119.887\nl239.353,0.303l123.676,0.37l16.571,28.772l7.831,13.596L662.409,476.302z"}))};r.defaultProps={width:24,height:24,fill:"#DB3939"},r.propTypes={width:t().number,height:t().number,fill:t().string};const l=r,o=window.wp.i18n,i=window.React,a=window.wp.components,u=window.wp.data;function c(e){return c="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e},c(e)}function p(e,t,n){return(t=function(e){var t=function(e,t){if("object"!=(void 0===e?"undefined":c(e))||!e)return e;var n=e[Symbol.toPrimitive];if(void 0!==n){var r=n.call(e,"string");if("object"!=(void 0===r?"undefined":c(r)))return r;throw new TypeError("@@toPrimitive must return a primitive value.")}return String(e)}(e);return"symbol"==(void 0===t?"undefined":c(t))?t:t+""}(t))in e?Object.defineProperty(e,t,{value:n,enumerable:!0,configurable:!0,writable:!0}):e[t]=n,e}function s(e,t){return function(e){if(Array.isArray(e))return e}(e)||function(e,t){var n=null==e?null:"undefined"!=typeof Symbol&&e[Symbol.iterator]||e["@@iterator"];if(null!=n){var r,l,o,i,a=[],u=!0,c=!1;try{if(o=(n=n.call(e)).next,0===t){if(Object(n)!==n)return;u=!1}else for(;!(u=(r=o.call(n)).done)&&(a.push(r.value),a.length!==t);u=!0);}catch(u){c=!0,l=u}finally{try{if(!u&&null!=n.return&&(i=n.return(),Object(i)!==i))return}finally{if(c)throw l}}return a}}(e,t)||function(e,t){if(e){if("string"==typeof e)return d(e,t);var n={}.toString.call(e).slice(8,-1);return"Object"===n&&e.constructor&&(n=e.constructor.name),"Map"===n||"Set"===n?Array.from(e):"Arguments"===n||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)?d(e,t):void 0}}(e,t)||function(){throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}()}function d(e,t){(null==t||t>e.length)&&(t=e.length);for(var n=0,r=Array(t);n<t;n++)r[n]=e[n];return r}const f=function(e){var t=s((0,i.useState)(""),2),n=t[0],r=t[1],l=s((0,i.useState)(!1),2),c=l[0],d=l[1],f=s((0,i.useState)(0),2),g=f[0],w=f[1],h=s((0,i.useState)(0),2),m=h[0],_=h[1],y=s((0,i.useState)(""),2),v=y[0],b=y[1],R=s((0,i.useState)(""),2),E=R[0],P=R[1],S=(0,u.useDispatch)("core/editor").editPost,C=function(e,t){S({meta:p({},e,t)})};return(0,i.useEffect)((function(){var e=(0,u.select)("core/editor").getEditedPostAttribute("meta"),t=e._wppic_plugin_author,n=e._wppic_override_ratings,l=e._wppic_num_ratings,o=e._wppic_rating_percentage,i=e._wppic_reviews_url,a=e._wppic_downloads_url;r(null!==t||void 0!==t?t:""),null===n&&void 0===n||d(n),null===l&&void 0===l||w(l),null===o&&void 0===o||_(o),null===i&&void 0===i||b(i),null===a&&void 0===a||P(a)}),[]),React.createElement(React.Fragment,null,React.createElement(a.PanelRow,null,React.createElement(a.TextControl,{label:(0,o.__)("Plugin Author","wp-plugin-info-card"),value:n,onChange:function(e){r(e),C("_wppic_plugin_author",e)},help:(0,o.__)("Enter the plugin author name, or the author of the plugin. If this is blank, the post author will be used.","wp-plugin-info-card")})),React.createElement(a.PanelRow,null,React.createElement(a.TextControl,{label:(0,o.__)("Reviews URL","wp-plugin-info-card"),value:v,onChange:function(e){b(e),C("_wppic_reviews_url",e)},help:(0,o.__)("Enter the URL that will be used to link to reviews. Otherwise, it will link to the download page.","wp-plugin-info-card")})),React.createElement(a.PanelRow,null,React.createElement(a.TextControl,{label:(0,o.__)("Downloads URL","wp-plugin-info-card"),value:E,onChange:function(e){P(e),C("_wppic_downloads_url",e)},help:(0,o.__)("Enter the URL that will be used to link to your download. Otherwise, it will link to the EDD download page.","wp-plugin-info-card")})),React.createElement(a.PanelRow,null,React.createElement(a.ToggleControl,{label:(0,o.__)("Override the Plugin Rating","wp-plugin-info-card"),help:(0,o.__)("If the ratings do not match your download, or you need to enter custom values, you can enable overrides to set the rating data manually.","wp-plugin-info-card"),checked:c,onChange:function(e){d(e),C("_wppic_override_ratings",e)}})),c&&React.createElement(React.Fragment,null,React.createElement(a.PanelRow,null,React.createElement(a.TextControl,{label:(0,o.__)("Number of Ratings","wp-plugin-info-card"),value:g,onChange:function(e){w(e),C("_wppic_num_ratings",e)},type:"number",help:(0,o.__)("Enter the number of ratings for the plugin.","wp-plugin-info-card")})),React.createElement(a.PanelRow,null,React.createElement(a.TextControl,{label:(0,o.__)("Rating Percentage","wp-plugin-info-card"),value:m,onChange:function(e){_(e),C("_wppic_rating_percentage",e)},type:"number",help:(0,o.__)("Enter the rating percentage for the plugin (e.g., 95).","wp-plugin-info-card")}))))};var g=wp.plugins.registerPlugin,w=wp.editPost.PluginDocumentSettingPanel,__=wp.i18n.__;g("wppic-edd-sidebar",{render:function(){return React.createElement(React.Fragment,null,React.createElement(w,{title:__("Plugin Info Card","wp-plugin-info-card"),icon:React.createElement(l,null),className:"wppic-edd-sidebar"},React.createElement(f,null)))}})})()})();