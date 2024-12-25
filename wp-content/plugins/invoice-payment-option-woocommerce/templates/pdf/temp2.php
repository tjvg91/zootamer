
<!DOCTYPE html>
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
	$af_invo_pro_table             = '';
	$af_invoice_header_color       ='';
	$af_invoice_header_text_color  = 'black';
	$af_inv_footer_backgrond_color = '';
	$af_inv_footer_text_color      = 'black';
	$af_invo_pro_table_text        = 'black';

}
?>
<html lang="en" >
<head>
	
	<style type="text/css">

		.af-invoice-pdf-content table {
			width: 100%;
			border-collapse: collapse;
		}

		.af-invoice-pdf-content table tbody tr td {
			border: 1px solid #393a3c38;
		}

		.af-invoice-pdf-content table thead th {
			border: 1px solid #393a3c38;
			
			font-size: 14px;
			line-height: 24px;
			padding: 5px;
			text-align: left;
			background-color: #43e3f8 ;
			color: black;

		}

		.af-invoice-pdf-content table tbody tr td:first-child {
			font-weight: 800;
		}

		.af-invoice-pdf-content table tbody tr td:last-child,
		.af-invoice-pdf-content table thead tr th:last-child {
			text-align: left;
		}

		.af-invoice-pdf-content table tbody tr:nth-child(even) {
			/*background-color: #ebf6ff;*/
					/*border: 1px solid;
					border-color: black;*/
				}
				.af-invoice-pdf-content table td {
					font-size: 14px;
					line-height: 24px;
					padding: 5px;
					text-align: left;
				}
				.af-invoice-pdf-content table tbody tr:nth-child(odd) {
					/*background-color: #fff;*/
						/*border: 1px solid;
						border-color: black;*/
					}

					.af-invoice-product-img img {
						width: 40px;
						height: 40px;
						border-radius: 6px;
						background: transparent;
					}

					.invoice_product_sku_td small {
						font-size: 10px;
					}
					
					#af_inv_proforma_note, #af_inv_invoice_footer{
						font-size: 10pt !important;
					}
					#af_inv_invoice_footer{
						position: fixed !important; 
						bottom: 0px !important; 
						left: 0!important; 
						right: 0 !important;
						width: 100%;
						background-color: #43e3f8 ;
						color: black;
					}
					#af_inv_invoice_footer table{
					
						color: black;
						
					}
					.af_inv_invoice_header{
						background-color: #43e3f8;
						color: black;
					}
					.af-line-temp-mid-sec-left , .af-line-temp-mid-sec-right{
						display: inline-block; width: 49%; vertical-align: top;
					}
					.af-line-temp-mid-sec-left h4 , .af-line-temp-mid-sec-right h4{
						background-color: #43e3f8 ;
						color: black;
						padding: 10px 0px 10px 20px; 
					}
					.af-line-temp-mid-sec-left ul , .af-line-temp-mid-sec-right ul{
						padding-left: 20px;
						list-style: none;
					}
					.af-line-temp-mid-sec-left ul li , .af-line-temp-mid-sec-right ul li{
						font-size: 13px; line-height: 24px; font-weight: normal;
					}
					.af-line-temp-mid-sec-left ul li label , .af-line-temp-mid-sec-right ul li label {
						width: 20%;
						display: inline-block;
						font-weight:bold;
					}
					.af-line-temp-mid-sec-left ul li span, .af-line-temp-mid-sec-right ul li span {
						padding: 0px;
						display: inline-block;
					}
					.af-invoice-subtotal p {
						line-height:8px;
					}
					.af-invoice-subtotal-section ul {
						display: block;
						line-height:0px;

					
					}
					.af-invoice-subtotal-section ul li {
						display: block;
						line-height:0px;
						padding: 0!important; 
						margin:0!important;

					
					}
					.af-invoice-subtotal-section ul li p {
						display: block;
						padding-top: 16px !important; 
						margin:0!important;
					
					}
				
					.af-invoice-subtotal-section ul li p label,
					.af-invoice-mid-section ul li p label {
						display: inline-block;
						padding: 0!important; 
						margin:0!important;
						
					}
					.note {
						display: table;
						margin: 10px 10px;
						width: 100%;
						font-size: 12px;
						float: left;
					}
					.af-invoice-subtotal-section {
					display: table;
					margin: 10px 0;
					width: 100%;
					}	

				.af-pdf-logo {
					display: table-cell;
					width: 65%;
					vertical-align: top;
				}
				.af-invoice-subtotal {
					display: table-cell;
					width: 35%;
					vertical-align: top;
					text-align: right;
					padding: 20px;
				}
				.af-pdf-header td {
					padding-right: 25px;
					font-size:13px; 
					line-height: 22px;
				}
				.af-invoice-mid-section{
					width: 100%; vertical-align: top; padding-bottom: 30px!important;
				}
				.af-invoice-info {
					display: inline-block; width: 40%; vertical-align:top;

				}
				.imag_container {
					width:45%; padding: 10px !important; display: inline-block;
					vertical-align:top;
				}
				.imag_container img{
					width: 100px!important;
				}
				.h2_container {
					padding:10px; width:45%; display: inline-block;
				}
				.h2_container h2{
					font-weight: bold; font-size: 25px; line-height: 35px; margin-bottom:5px;
				}
				.af-store-info-box {
					display: inline-block; width: 50%; vertical-align: top;
				}
				</style>
			</head>

			<meta charset="utf-8">
			<meta name="viewport" content="width=device-width, initial-scale=1">
			<div class="af_inv_invoice_header" style="background-color:<?php echo esc_attr( $af_invoice_header_color ); ?>; color: <?php echo esc_attr( $af_invoice_header_text_color ); ?>;">
				<div class="imag_container">
					<?php if ( ! empty( $af_invoice_upload_icon ) ) { ?>
						<img src="<?php echo esc_url( $af_invoice_upload_icon ); ?>">
					<?php } ?>
				</div>
				<div class="h2_container">
					<h2 style="">
						<?php
						if ( ! empty( $af_invoice_heading ) ) {
							echo esc_attr( $af_invoice_heading );
						} 
						?>
					</h2>
				</div>

			</div>

			<body>

				<div class="af-pdf-wrapper" >
					<div class="">
						<section class="af-pdf-header" style="padding: 20px 0;">
							<div class="af-store-info-box">
								<?php if ( 'yes' == $af_invoice_comp_detail ) { ?>
									<table>
										<?php if ( ! empty( $af_invoice_comp_name ) ) { ?>
											<tr>
												<td ><?php echo esc_html__( 'Company', 'af_ig_td' ); ?>:</td>
												<td style="font-size:14px; line-height: 22px; padding: 2px 0;"><?php echo esc_attr( $af_invoice_comp_name ); ?></td>
											</tr>
											<?php
										}

										if ( ! empty( trim( $af_invoice_add_informiation ) ) ) {
											?>
											<tr>
												<td ><?php echo esc_html__( 'Address', 'af_ig_td' ); ?>:</td>
												<td style="font-size:14px; line-height: 22px; padding: 2px 0;"><?php echo esc_attr( $af_invoice_add_informiation ); ?></td>
											</tr>
										<?php } ?>

										<?php if ( ! empty( get_option( 'woocommerce_store_city' ) ) ) { ?>
										<tr>
											<td ><?php echo esc_html__( 'City', 'af_ig_td' ); ?>:</td>
											<td ><?php echo esc_attr( get_option( 'woocommerce_store_city' ) ); ?></td>
										</tr>
										<?php } ?>
										<?php if ( ! empty( WC()->countries->get_base_state() ) ) { ?>
										<tr>
											<td ><?php echo esc_html__( 'State', 'af_ig_td' ); ?>:</td>
											<td ><?php echo esc_attr( WC()->countries->states[ esc_attr(WC()->countries->get_base_country() ) ][ esc_attr(WC()->countries->get_base_state() ) ] ); ?></td>
										</tr>
										<?php } ?>
										<?php if ( ! empty( WC()->countries->get_base_country() ) ) { ?>
										<tr>
											<td ><?php echo esc_html__( 'Country', 'af_ig_td' ); ?>:</td>
											<td ><?php echo esc_attr( WC()->countries->countries[ esc_attr(WC()->countries->get_base_country() ) ] ); ?></td>
										</tr>
										<?php } ?>
										<?php if ( ! empty( WC()->countries->get_base_postcode() ) ) { ?>
										<tr>
											<td ><?php echo esc_html__( 'Postcode', 'af_ig_td' ); ?>:</td>
											<td ><?php echo esc_attr(WC()->countries->get_base_postcode()); ?></td>
										</tr>
										<?php } ?>
									</table>
								<?php } ?>
							</div>

							<div class="af-invoice-info">

								<table>
									<tr>
										<td ><?php echo esc_html__( 'Order Number:', 'af_ig_td' ); ?></td>
										<td><?php echo esc_attr( $order->get_order_number() ); ?></td>
									</tr>
									<tr>
										<td ><?php echo esc_html__( 'Date:', 'af_ig_td' ); ?></td>
										<td><?php echo esc_attr( $order->get_date_created()->date_i18n( 'Y-m-d' ) ); ?></td>
									</tr>
									<tr>
										<td ><?php echo esc_html__( 'Payment Method:', 'af_ig_td' ); ?></td>
										<td ><?php echo esc_attr( $order->get_payment_method_title() ); ?></td>
									</tr>
									<tr>
										<td ><?php echo esc_html__( 'Time:', 'af_ig_td' ); ?></td>
										<td ><?php echo esc_attr( $order->get_date_created()->date_i18n( 'H:i:s' ) ); ?></td>
									</tr>
									<tr>
										<td ><?php echo esc_html__( 'Email:', 'af_ig_td' ); ?></td>
										<td ><?php echo esc_attr( $order->get_billing_email() ); ?></td>
									</tr>
								</table>
							</div>
						</section>
					</div>
					<section class="af-line-temp-mid-section">
						<div class="af-line-temp-mid-sec-left">
							<h4 style=" background-color:<?php echo esc_attr( $af_invoice_header_color ); ?>; color: <?php echo esc_attr( $af_invoice_header_text_color ); ?>;"><?php echo esc_html__( 'Bill To', 'af_ig_td' ); ?></h4>
							<ul >
								<li ><label><?php echo esc_html__( 'Name:', 'af_ig_td' ); ?></label> <span><?php echo esc_attr( $order->get_billing_first_name() . ' ' . $order->get_billing_last_name() ); ?></span></li>
								<?php if ( ! empty( $order->get_billing_company() ) ) { ?>
									<li >
										<label><?php echo esc_html__( 'Company:', 'af_ig_td' ); ?></label>
										<span><?php echo esc_attr( $order->get_billing_company() ); ?></span>
									</li>
								<?php } ?>
								<li ><label><?php echo esc_html__( 'Address:', 'af_ig_td' ); ?></label><span><?php echo esc_attr( $order->get_billing_address_1() . ' ' . $order->get_billing_address_2()  ); ?></span></li>
								<li ><label><?php echo esc_html__( 'City:', 'af_ig_td' ); ?></label><span><?php echo esc_attr( $order->get_billing_city()   ); ?></span></li>
								<li ><label><?php echo esc_html__( 'State:', 'af_ig_td' ); ?></label><span><?php echo esc_attr( WC()->countries->states[ $order->get_billing_country() ][ $order->get_billing_state() ] ); ?></span></li>
								<li style="font-size: 14px; line-height: 24px; font-weight: normal;"><label><?php echo esc_html__( 'Country:', 'af_ig_td' ); ?></label><span><?php echo esc_attr( WC()->countries->countries[ $order->get_billing_country() ] ); ?></span></li>
								<li ><label><?php echo esc_html__( 'Postcode:', 'af_ig_td' ); ?></label><span><?php echo esc_attr( $order->get_billing_postcode()   ); ?></span></li>
								<li ><label><?php echo esc_html__( 'Phone:', 'af_ig_td' ); ?></label><span><?php echo esc_attr( $order->get_billing_phone() ); ?></span></li>
								<li ><label><?php echo esc_html__( 'E-Mail:', 'af_ig_td' ); ?></label><span><?php echo esc_attr( $order->get_billing_email() ); ?></span></li>
							

							</ul>
						</div>
						<?php
						if ( ! empty( $order->get_shipping_address_1() ) ) :
							?>
						<div class="af-line-temp-mid-sec-right" >
							<h4 style="background-color:<?php echo esc_attr( $af_invoice_header_color ); ?>; color: <?php echo esc_attr( $af_invoice_header_text_color ); ?>; "><?php echo esc_html__( 'Ship To', 'af_ig_td' ); ?></h4>
							<ul >
								<?php if ( ! empty( $order->get_shipping_first_name() ) ) { ?>
									<li >
										<label><?php echo esc_html__( 'Name:', 'af_ig_td' ); ?></label>
										<span><?php echo esc_attr( $order->get_shipping_first_name() . ' ' . $order->get_shipping_last_name() ); ?></span>
									</li>
								<?php } ?>

								<?php if ( ! empty( $order->get_shipping_company() ) ) { ?>
									<li >
										<label><?php echo esc_html__( 'Company:', 'af_ig_td' ); ?></label>
										<span><?php echo esc_attr( $order->get_shipping_company() ); ?></span>
									</li>
								<?php } ?>

								<?php if ( ! empty( $order->get_shipping_address_1() ) ) { ?>
									<li >
										<label><?php echo esc_html__( 'Address:', 'af_ig_td' ); ?></label>
										<span><?php echo esc_attr( $order->get_shipping_address_1() . ' ' . $order->get_shipping_address_2() ); ?></span>
									</li>
								<?php } ?>

								<?php if ( ! empty( $order->get_shipping_city() ) ) { ?>
								<li >
									<label><?php echo esc_html__( 'City:', 'af_ig_td' ); ?></label>
									<span><?php echo esc_attr(  $order->get_shipping_city() ); ?></span>
								</li>
								<?php } ?>
								<?php if ( ! empty( $order->get_shipping_state() ) ) { ?>
									<li >
										<label><?php echo esc_html__( 'State:', 'af_ig_td' ); ?></label>
										<span><?php echo esc_attr( WC()->countries->states[ $order->get_shipping_country() ][ $order->get_shipping_state() ] ); ?></span>
									</li>
								<?php } ?>
								
								<?php if ( ! empty( $order->get_shipping_country() ) ) { ?>
									<li >
										<label><?php echo esc_html__( 'Country:', 'af_ig_td' ); ?></label>
										<span><?php echo esc_attr( WC()->countries->countries[ $order->get_shipping_country() ] ); ?></span>
									</li>
								<?php } ?>
								<?php if ( ! empty( $order->get_shipping_postcode() ) ) { ?>
									<li >
										<label><?php echo esc_html__( 'Postcode:', 'af_ig_td' ); ?></label>
										<span><?php echo esc_attr( $order->get_shipping_postcode()   ); ?></span>
									</li>
								<?php } ?>
			
								
							</ul>
						</div>
					<?php endif; ?>
					</section>

					<section class="af-invoice-pdf-content" style="padding-top: 30px!important;" >
						<table>
							<thead style="background-color: <?php echo esc_attr( $af_invo_pro_table ); ?>; color: <?php echo esc_attr( $af_invo_pro_table_text ); ?>;">
								<tr style="text-align:center;">
									<th style=" background-color: <?php echo esc_attr( $af_invo_pro_table ); ?>; color: <?php echo esc_attr( $af_invo_pro_table_text ); ?>; width:20%; text-align:center; color: <?php echo esc_attr( $af_invo_pro_table_text ); ?>"><?php echo esc_html__( 'Image', 'af_ig_td' ); ?></th>
									<th style=" background-color: <?php echo esc_attr( $af_invo_pro_table ); ?>; color: <?php echo esc_attr( $af_invo_pro_table_text ); ?>; width:20%; text-align:center; color: <?php echo esc_attr( $af_invo_pro_table_text ); ?>"><?php echo esc_html__( 'Product Name', 'af_ig_td' ); ?></th>
									<th style=" background-color: <?php echo esc_attr( $af_invo_pro_table ); ?>; color: <?php echo esc_attr( $af_invo_pro_table_text ); ?>; width:20%; text-align:center;color: <?php echo esc_attr( $af_invo_pro_table_text ); ?>"><?php echo esc_html__( 'QTY', 'af_ig_td' ); ?></th>
									<th style="  background-color: <?php echo esc_attr( $af_invo_pro_table ); ?>; color: <?php echo esc_attr( $af_invo_pro_table_text ); ?>; width:20%; text-align:center; color: <?php echo esc_attr( $af_invo_pro_table_text ); ?>"><?php echo esc_html__( 'Price', 'af_ig_td' ); ?></th>
									<th style=" background-color: <?php echo esc_attr( $af_invo_pro_table ); ?>; color: <?php echo esc_attr( $af_invo_pro_table_text ); ?>; width:20%; text-align:center; color: <?php echo esc_attr( $af_invo_pro_table_text ); ?>"><?php echo esc_html__( 'Total', 'af_ig_td' ); ?></th>

								</tr>
							</thead>
							<tbody>
								<?php
								foreach ( $order->get_items() as $item_id => $order_item ) {
									$product  = $order_item->get_product();
									$_product = wc_get_product( $order_item->get_product_id() );

									$subtotal      = $order_item->get_subtotal();
									$quantity      = $order_item->get_quantity();
									$regular_price = $product->get_regular_price();
									$sale_price    = $product->get_sale_price();
									$line_total    = $order_item->get_total();
									$tax_amount    = wc_get_price_including_tax( $_product ) - wc_get_price_excluding_tax( $_product );
									$total_inc_tax = $tax_amount + $line_total;
									?>
									<tr style="text-align:center;">
										<td style="width:20%; text-align:center; padding:10px;"  class="af-invoice-product-img">
											<?php echo wp_kses_post( $product->get_image() ); ?>
										</td>
										<td style=" width:20%; text-align:center;" class="invoice_product_sku_td">
											<span style="font-weight: bold !important;"><?php echo wp_kses_post( $product->get_name() ); ?></span><br>
											<small><?php echo wp_kses_post( $product->get_sku() ); ?></small><br>
										</td>
										<td style="width:20%; text-align:center;"><?php echo wp_kses_post( $quantity ); ?></td>
										<td style="width:20%; text-align:center;"><?php echo wp_kses_post( wc_price($subtotal/$quantity ) ); ?></td>
										<td style="width:20%; text-align:center;"><?php echo wp_kses_post( wc_price(( $subtotal ) ) ); ?></td>

									</tr>
									<?php
								}
								?>
							</tbody>
						</table>

					</section>
					<section class="af-invoice-subtotal-section" style=" ">
						<div class="af-pdf-logo"></div>
						<div class="af-invoice-subtotal" style="width:100%; background-color:<?php echo esc_attr( $af_invo_pro_table ); ?>: color:<?php echo esc_attr( $af_invo_pro_table_text ); ?>  ?> ;">
							<ul style="list-style:none; padding: 0!important; margin:0!important; ">
								<?php if (!empty($order->get_total_tax())) : ?>
									<li>
										<p>
											<label style="width: 50%; display: inline-block; font-size: bold;">
												<strong><?php esc_html_e( 'Tax', 'af_ig_td' ); ?></strong>
											</label>
											<font>
												<?php echo wp_kses_post( wc_price( $order->get_total_tax() ) ); ?>
											</font>
										</p>
									</li>
								<?php endif; ?>
								<li>
									<p>
										<label style="width: 50%; display: inline-block;">
											<strong><?php esc_html_e( 'Subtotal', 'af_ig_td' ); ?></strong>
										</label>
										<font>
											<?php echo wp_kses_post( wc_price( $order->get_subtotal() ) ); ?>
										</font>
									</p>
								</li>
								<?php if (!empty($order->get_discount_total())) : ?>
									<li>
										<p>
											<label style="width: 50%; display: inline-block;">
												<strong><?php esc_html_e( 'Discount', 'af_ig_td' ); ?></strong>
											</label>
											<font>
												<?php echo wp_kses_post( wc_price( $order->get_discount_total() ) ); ?>
											</font>
										</p>
									</li>
								<?php endif; ?>
								<?php if ( $order->get_shipping_total() > 0 ) : ?>
									<li>
										<p>
											<label style="width: 50%; display: inline-block;">
												<strong><?php echo esc_attr( $order->get_shipping_method() ); ?></strong>
											</label>
											<font>
												<?php echo wp_kses_post( wc_price( $order->get_shipping_total() ) ); ?>
											</font>
										</p>
									</li>
								<?php endif; ?>

								<li>
									<p  class="af-invoice-total-label">
										<label style="width: 50%; display: inline-block;">
											<strong><?php esc_html_e( 'Total', 'af_ig_td' ); ?></strong>
										</label>
										<font>
											<strong><?php echo wp_kses_post( wc_price( $order->get_total() ) ); ?></strong>
										</font>
									</p>
								</li>

							</ul>
						</div>
					</section>
				</div>
				<div class="note">
					<?php if ( ! empty( $af_inv_invoice_note ) ) { ?>
							<p>
								<?php echo esc_attr( get_option( 'af_inv_invoice_note' ) ); ?>
							</p>
						<?php } ?>
				</div>
				<div id="af_inv_invoice_footer" style="background-color:<?php echo esc_attr( $af_inv_footer_backgrond_color ); ?>;color:<?php echo esc_attr( $af_inv_footer_text_color ); ?>;">
					<table style="width:100%; padding:20px;color:<?php echo esc_attr( $af_inv_footer_text_color ); ?>">
						
						<tr>
										<td style="text-align:center">

							<?php
							if ( ! empty( $af_invo_footer_text ) ) {
								?>
								<?php echo esc_attr( $af_invo_footer_text ); ?><?php } ?></td>
						</tr>
					</table>
				</div>
			</body>
			</html>


