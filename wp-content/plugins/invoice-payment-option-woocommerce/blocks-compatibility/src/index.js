const af_ig_settings = window.wc.wcSettings.getSetting( 'invoice_data', {} );
const af_ig_label = window.wp.htmlEntities.decodeEntities( af_ig_settings.title ) || window.wp.i18n.__( 'Invoice', 'af_ig_td' );
const Content = () => {
    return window.wp.htmlEntities.decodeEntities( af_ig_settings.description || '' );
};

const AF_IG_Block_Gateway = {
    name: 'invoice',
    label: af_ig_label,
    content: Object( window.wp.element.createElement )( Content, null ),
    edit: Object( window.wp.element.createElement )( Content, null ),
    canMakePayment: () => true,
    ariaLabel: af_ig_label,
    supports: {
        features: af_ig_settings.supports,
    },
};

window.wc.wcBlocksRegistry.registerPaymentMethod( AF_IG_Block_Gateway );