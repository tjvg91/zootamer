<!DOCTYPE html>
<html lang="en" >
<?php
$af_invoice_upload_icon      = get_option( 'af_invoice_upload_icon' );
$af_invoice_comp_name        = get_bloginfo( 'name' );
$af_invoice_add_informiation = WC()->countries->get_base_address() . ' ' . WC()->countries->get_base_address_2();
$af_invoice_customize_theme  = get_option( 'af_invoice_customize_theme' );
$af_invoice_comp_detail      = get_option( 'af_invoice_comp_detail' );
$af_invoice_heading          = get_option( 'af_invoice_heading' );
$af_invo_footer_text         = get_option( 'af_invo_footer_text' );
$af_inv_invoice_note         = get_option( 'af_inv_invoice_note' );
if ( ( 'yes' === $af_invoice_customize_theme ) ) {
	$af_invo_pro_table             = get_option( 'af_invo_pro_table' );
	$af_invoice_header_color       = get_option( 'af_invoice_header_color' );
	$af_inv_footer_backgrond_color = get_option( 'af_inv_footer_backgrond_color' );
	$af_invo_pro_table_text        = get_option( 'af_invo_pro_table_text' );
	$af_inv_footer_text_color      = get_option( 'af_inv_footer_text_color' );
	$af_invoice_header_text_color  = get_option( 'af_invoice_header_text_color' );


} else {
	$af_invo_pro_table             = 'black';
	$af_invoice_header_color       = 'black';
	$af_invoice_header_text_color  = '#fff';
	$af_inv_footer_backgrond_color = 'black';
	$af_inv_footer_text_color      = '#fff';
	$af_invo_pro_table_text        = '#fff';

}
?>
<style type="text/css">
	.main-template-wrap{
			width: 100%;
	max-width: 900px;
	margin: 0 auto;
/*    padding: 18px;*/
	font-family: system-ui;
	}
	.template-header .pdf-tem-logo, .invoice-contact-detail{
		display: inline-block;
			vertical-align: top;
			width: 57%;
	}
	.pdf-tem-logo img{
			width: 155px;
	}
	.header-information, .invoice-information{
			vertical-align: top;
	display: inline-block;
	width: 40%;
	padding: 0 8px;
	}
	.header-information p, .invoice-contact-detail p, .invoice-information table tr td{
			font-size: 13px;
	line-height: 23px;
	color: #000;
	margin: 0;
	}
	.invoice-information table tr td{
		padding: 0;
	}
	.template-header, .template-invoice-slip{
		margin-bottom: 30px;
	}
	.template-invoice-slip h2{
		font-size: 26px;
		line-height: 36px;
		font-weight: 700;
		color: #000;
		margin-bottom: 14px;
	}
	.invoice-products table, .invoice-information table{
		width: 100%;
		border-spacing: 0;
		border-collapse: separate;
	}
	.invoice-products table thead tr th{
		background: <?php echo esc_attr($af_invo_pro_table); ?>;
		border: none;
		font-size: 13px;
		line-height: 23px;
		text-align: left;
		color: <?php echo esc_attr($af_invo_pro_table_text); ?>;
		padding: 9px 7px;
	}
	.invoice-products table tr th{
		text-align: left;
	}
	.invoice-products table tbody tr td{
			padding: 9px 7px;
	font-size: 13px;
	line-height: 23px;
	color: #000;
/*    border-bottom: 1px solid lightgray;*/
	}
	.invoice-products table tfoot tr td,
	.invoice-products table tfoot tr th{
		padding: 9px 7px;;
		background: #fff;
		color: #000;
		font-size: 13px;
		line-height: 23px;
		border-bottom: 1px solid black;
	}
	.invoice-products table tfoot tr td:first-child,
	.invoice-products table tfoot tr th:first-child{
		border-bottom: none;
	}
	.invoice-products table tfoot tr:first-child th,
	.invoice-products table tfoot tr:first-child td{
		padding: 10px 0 0 0;
	}
	.invoice-products table tfoot tr:first-child th span,
	.invoice-products table tfoot tr:first-child td span.woocommerce-Price-amount{
			padding: 9px 7px;
/*		        border-top: 1px solid lightgray;*/
			display: block;
	}
	.invoice-contact-detail .billing-detail,
	.invoice-contact-detail .shipping-detail{
		display: inline-block;
		width: 49%;
		vertical-align: top;
	}
	.invoice-contact-detail .billing-detail h3,
	.invoice-contact-detail .shipping-detail h3,
	.header-information h3{
		font-size: 16px;
		line-height: 17px;
		font-weight: 600;
		color: #000;
		margin: 0 0 10px;
	}
	.invoice-products table tbody tr:nth-child(even) td{
		background: #d3d3d340;
	}
	.main-template-wrap header{
	background: <?php echo esc_attr( $af_invoice_header_color ); ?>;
	padding: 6px 12px;
	margin-bottom: 36px;
	}
	.main-template-wrap footer{
		background: <?php echo esc_attr( $af_inv_footer_backgrond_color ); ?>;
	padding: 6px 12px;
	margin-top: 36px;
	}
	.header-text p{
				font-size: 12px;
	color:<?php echo esc_attr($af_invoice_header_text_color); ?>;
	line-height: 24px;
	margin: 0;
	text-align: center;
	font-weight: 500;
	}
	.footer-text p{
				font-size: 12px;
	color:<?php echo esc_attr($af_inv_footer_text_color); ?>;
	line-height: 24px;
	margin: 0;
	text-align: center;
	font-weight: 500;
	}

	
	.note {
		display: table;
		margin: 10px 10px;
		width: 100%;
		font-size: 12px;
	}
</style>

<div class="main-template-wrap">
	<header>
		<div class="header-text">
			<p>
			<?php
			if ( ! empty( $af_invoice_heading ) ) {
				echo esc_attr( $af_invoice_heading );
			} 
			?>
			</p>
		</div>
	</header>
	<div class="template-header">
		<div class="pdf-tem-logo">
			<img src="<?php echo esc_attr($af_invoice_upload_icon); ?>">
		</div>
		<div class="invoice-information">
			<table>
				<tr>
					<td><?php echo esc_html__( 'Order Number:', 'af_ig_td' ); ?></td>
					<td><?php echo esc_attr( $order->get_order_number() ); ?></td>
				</tr>
				<tr>
					<td><?php echo esc_html__( 'Order Date:', 'af_ig_td' ); ?></td>
					<td><?php echo esc_attr( $order->get_date_created()->date_i18n( 'F d, Y' ) ); ?></td>
				</tr>
				<tr>
					<td><?php echo esc_html__( 'Payment Method:', 'af_ig_td' ); ?></td>
					<td><?php echo esc_attr( $order->get_payment_method_title() ); ?></td>
				</tr>
			</table>
		</div>
	</div>
	<div class="template-invoice-slip">
		<div class="invoice-contact-detail">
			<div class="billing-detail">
				<h3><?php echo esc_html__( 'Billing Info', 'af_ig_td' ); ?></h3>
				<p><?php echo esc_attr( $order->get_billing_first_name() . ' ' . $order->get_billing_last_name()); ?></p>
				<p><?php echo esc_attr( $order->get_billing_company() ); ?></p>
				<p><?php echo esc_attr( $order->get_billing_address_1() . ' ' . $order->get_billing_address_2()  ); ?></p>
				<p><?php echo esc_attr( $order->get_billing_city()   ); ?></p>
				<p><?php echo esc_attr( WC()->countries->states[ $order->get_billing_country() ][ $order->get_billing_state() ] ); ?></p>
				<p><?php echo esc_attr( $order->get_billing_postcode()   ); ?></p>
				<p><?php echo esc_attr( WC()->countries->countries[ $order->get_billing_country() ] ); ?></p>
				<p><?php echo esc_attr( $order->get_billing_phone() ); ?></p>
				<p><?php echo esc_attr( $order->get_billing_email() ); ?></p>
			</div>
			<div class="shipping-detail">
				<h3><?php echo esc_html__( 'Shipping Info', 'af_ig_td' ); ?></h3>
				<p><?php echo esc_attr( $order->get_shipping_first_name() . ' ' . $order->get_shipping_last_name()); ?></p>
				<p><?php echo esc_attr( $order->get_shipping_company() ); ?></p>
				<p><?php echo esc_attr( $order->get_shipping_address_1() . ' ' . $order->get_shipping_address_2()  ); ?></p>
				<p><?php echo esc_attr( $order->get_shipping_city()   ); ?></p>
				<p><?php echo esc_attr( WC()->countries->states[ $order->get_billing_country() ][ $order->get_shipping_state() ] ); ?></p>
				<p><?php echo esc_attr( $order->get_shipping_postcode()   ); ?></p>
				<p><?php echo esc_attr( WC()->countries->countries[ $order->get_shipping_country() ] ); ?></p>
			</div>
		</div>
		<?php if ('yes'==$af_invoice_comp_detail) : ?>
		<div class="header-information">
			<?php if ( ! empty( $af_invoice_comp_name ) ) { ?>
			<h3><?php echo esc_attr( $af_invoice_comp_name ); ?></h3>
			<?php } ?>
			<p><?php echo esc_attr( $af_invoice_add_informiation ); ?></p>
			<p><?php echo esc_attr( get_option( 'woocommerce_store_city' ) ); ?></p>
			<p><?php echo esc_attr(WC()->countries->get_base_postcode()); ?></p>
			<p><?php echo esc_attr( WC()->countries->states[ esc_attr(WC()->countries->get_base_country() ) ][ esc_attr(WC()->countries->get_base_state() ) ] ); ?>, <?php echo esc_attr( WC()->countries->countries[ esc_attr(WC()->countries->get_base_country() ) ] ); ?></p>
		</div>
	<?php endif; ?>
		
	</div>
	<div class="invoice-products">
		<table>
			<thead>
				<tr >
					<th><?php echo esc_html__( 'Product', 'af_ig_td' ); ?></th>
					<th><?php echo esc_html__( 'Quantity', 'af_ig_td' ); ?></th>
					<th><?php echo esc_html__( 'Price', 'af_ig_td' ); ?></th>
				</tr>
			</thead>
			<tbody>
			<?php
			foreach ( $order->get_items() as $item_id => $order_item ) {
				$product = $order_item->get_product();
				$quantity      = $order_item->get_quantity();
				$subtotal      = $order_item->get_subtotal();
				?>
				<tr>
					<td><?php echo wp_kses_post( $product->get_name() ); ?></td>
					<td><?php echo wp_kses_post($order_item->get_quantity()); ?></td>
					<td><?php echo wp_kses_post( wc_price( $subtotal/$quantity ) ); ?></td>
				</tr>
			<?php } ?>
			</tbody>
			<tfoot>
				<?php
				if (!empty($order->get_total_tax())) :
					?>
					<tr>
						<td></td>
						<th><span><?php echo esc_html__( 'Tax', 'af_ig_td' ); ?></span></th>
						<td><?php echo wp_kses_post( wc_price( $order->get_total_tax() ) ); ?></td>
					</tr>
				<?php endif; ?>
				<tr>
					<td></td>
					<th><span><?php echo esc_html__( 'Subtotal', 'af_ig_td' ); ?></span></th>
					<td><?php echo wp_kses_post( wc_price( $order->get_subtotal() ) ); ?></td>
				</tr>
				<?php if (!empty($order->get_discount_total())) : ?>
					<tr>
						<td></td>
						<th><span><?php echo esc_html__( 'Discount', 'af_ig_td' ); ?></span></th>
						<td><?php echo wp_kses_post( wc_price( $order->get_discount_total() ) ); ?>/td>
					</tr>
				<?php endif; ?>
				<?php if (!empty($order->get_shipping_total())) : ?>
					<tr>
						<td></td>
						<th><span><?php echo esc_attr( $order->get_shipping_method() ); ?></span></th>
						<td><?php echo wp_kses_post( wc_price( $order->get_shipping_total() ) ); ?></td>
					</tr>
				<?php endif; ?>
				<tr>
					<td></td>
					<th><?php echo esc_html__( 'Total', 'af_ig_td' ); ?></th>
					<th><?php echo wp_kses_post( wc_price( $order->get_total() ) ); ?></th>
				</tr>
			</tfoot>
		</table>
		<div class="note">
		<?php if ( ! empty( $af_inv_invoice_note ) ) { ?>
				<p>
					<?php echo esc_attr( get_option( 'af_inv_invoice_note' ) ); ?>
				</p>
			<?php } ?>
	</div>
	</div>
	<footer>
		<div class="footer-text" >
			<p>
			<?php
			if ( ! empty( $af_invo_footer_text ) ) {
				echo esc_attr( $af_invo_footer_text ); 
			}
			?>
			</p>
		</div>
	</footer>
</div>
