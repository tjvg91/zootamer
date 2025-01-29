"use strict";Object.defineProperty(exports,"__esModule",{value:!0}),exports.DownloadBlockEdit=DownloadBlockEdit;const i18n_1=require("@wordpress/i18n"),components_1=require("@wordpress/components"),data_1=require("@wordpress/data"),element_1=require("@wordpress/element"),icons_1=require("@wordpress/icons"),block_templates_1=require("@woocommerce/block-templates"),components_2=require("@woocommerce/components"),core_data_1=require("@wordpress/core-data"),downloads_menu_1=require("./downloads-menu"),manage_download_limits_modal_1=require("../../../components/manage-download-limits-modal"),edit_downloads_modal_1=require("./edit-downloads-modal"),upload_image_1=require("./upload-image"),block_slot_fill_1=require("../../../components/block-slot-fill");function getFileName(e){var o;const[n]=null!==(o=null==e?void 0:e.split("/").reverse())&&void 0!==o?o:[];return n}function stringifyId(e){return e?String(e):""}function stringifyEntityId(e){return{...e,id:stringifyId(e.id)}}function DownloadBlockEdit({attributes:e,context:{postType:o}}){var n;const t=(0,block_templates_1.useWooBlockProps)(e),[l,a]=(0,core_data_1.useEntityProp)("postType",o,"downloads"),[i,r]=(0,core_data_1.useEntityProp)("postType",o,"download_limit"),[d,c]=(0,core_data_1.useEntityProp)("postType",o,"download_expiry"),[m,s]=(0,element_1.useState)(),{allowedMimeTypes:_}=(0,data_1.useSelect)((e=>{const{getEditorSettings:o}=e("core/editor");return o()})),p=_?Object.values(_):[],{createErrorNotice:u}=(0,data_1.useDispatch)("core/notices"),[w,f]=(0,element_1.useState)(!1);function E(e){if(!Array.isArray(e))return;const o=e.filter((e=>!l.some((o=>o.file===e.url))));if(o.length!==e.length&&u(1===e.length?(0,i18n_1.__)("This file has already been added","woocommerce"):(0,i18n_1.__)("Some of these files have already been added","woocommerce")),o.length){const e=o.map((e=>({id:stringifyId(e.id),file:e.url,name:e.title||e.alt||e.caption||getFileName(e.url)}))),n=l.map(stringifyEntityId);n.push(...e),a(n)}}function g(e){const o=l.reduce((function(o,n){return n.file===e.file?o:[...o,stringifyEntityId(n)]}),[]);a(o)}function y(e){return function(){g(e)}}function b(e){return function(){s(stringifyEntityId(e))}}const k=function(e){u((0,i18n_1.sprintf)((0,i18n_1.__)("Error uploading file:%1$s%2$s","woocommerce"),"\n",e.message))};return(0,element_1.createElement)("div",{...t},(0,element_1.createElement)(block_slot_fill_1.SectionActions,null,Boolean(l.length)&&(0,element_1.createElement)(components_1.Button,{variant:"tertiary",onClick:function(){f(!0)}},(0,i18n_1.__)("Manage limits","woocommerce")),(0,element_1.createElement)(downloads_menu_1.DownloadsMenu,{allowedTypes:p,onUploadSuccess:E,onUploadError:k,onLinkError:function(e){u((0,i18n_1.sprintf)((0,i18n_1.__)("Error linking file:%1$s%2$s","woocommerce"),"\n",e))}})),(0,element_1.createElement)("div",{className:"wp-block-woocommerce-product-downloads-field__body"},(0,element_1.createElement)(components_2.MediaUploader,{label:Boolean(l.length)?"":(0,element_1.createElement)("div",{className:"wp-block-woocommerce-product-downloads-field__drop-zone-content"},(0,element_1.createElement)(upload_image_1.UploadImage,null),(0,element_1.createElement)("p",{className:"wp-block-woocommerce-product-downloads-field__drop-zone-label"},(0,element_1.createInterpolateElement)((0,i18n_1.__)("Supported file types: <Types /> and more. <link>View all</link>","woocommerce"),{Types:(0,element_1.createElement)(element_1.Fragment,null,"PNG, JPG, PDF, PPT, DOC, MP3, MP4"),link:(0,element_1.createElement)("a",{href:"https://codex.wordpress.org/Uploading_Files",target:"_blank",rel:"noreferrer",onClick:e=>e.stopPropagation()})}))),buttonText:"",allowedMediaTypes:p,multipleSelect:"add",maxUploadFileSize:null===(n=window.productBlockEditorSettings)||void 0===n?void 0:n.maxUploadFileSize,onUpload:E,onFileUploadChange:E,onError:k,additionalData:{type:"downloadable_product"}}),Boolean(l.length)&&(0,element_1.createElement)(components_2.Sortable,{className:"wp-block-woocommerce-product-downloads-field__table"},l.map((e=>{const o=getFileName(e.file),n=e.file.startsWith("blob");return(0,element_1.createElement)(components_2.ListItem,{key:e.file,className:"wp-block-woocommerce-product-downloads-field__table-row"},(0,element_1.createElement)("div",{className:"wp-block-woocommerce-product-downloads-field__table-filename"},(0,element_1.createElement)("span",null,e.name),e.name!==o&&(0,element_1.createElement)("span",{className:"wp-block-woocommerce-product-downloads-field__table-filename-description"},o)),(0,element_1.createElement)("div",{className:"wp-block-woocommerce-product-downloads-field__table-actions"},n&&(0,element_1.createElement)(components_1.Spinner,{"aria-label":(0,i18n_1.__)("Uploading file","woocommerce")}),!n&&(0,element_1.createElement)(components_1.Button,{onClick:b(e),variant:"tertiary"},(0,i18n_1.__)("Edit","woocommerce")),(0,element_1.createElement)(components_1.Button,{icon:icons_1.closeSmall,label:(0,i18n_1.__)("Remove file","woocommerce"),disabled:n,onClick:y(e)})))})))),w&&(0,element_1.createElement)(manage_download_limits_modal_1.ManageDownloadLimitsModal,{initialValue:{downloadLimit:i,downloadExpiry:d},onSubmit:function(e){r(e.downloadLimit),c(e.downloadExpiry),f(!1)},onClose:function(){f(!1)}}),m&&(0,element_1.createElement)(edit_downloads_modal_1.EditDownloadsModal,{downloadableItem:{...m},onCancel:()=>s(null),onRemove:()=>{g(m),s(null)},onChange:e=>{s({...m,name:e})},onSave:(v=m,function(){const e=l.map(stringifyEntityId).map((e=>e.id===v.id?v:e));a(e),s(null)})}));var v}