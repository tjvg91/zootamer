
<!DOCTYPE html>
<?php
$af_invoice_upload_icon      = get_option( 'af_invoice_upload_icon' );
$af_invoice_comp_name        = get_option( 'woocommerce_company' );
$af_invoice_add_informiation = get_option( 'woocommerce_store_address' );

$af_invoice_header_color = get_option( 'af_invoice_header_color' );

$af_invoice_header_text_color  = get_option( 'af_invoice_header_text_color' );
$af_invo_pro_table             = get_option( 'af_invo_pro_table' );
$af_invo_pro_table_text        = get_option( 'af_invo_pro_table_text' );
$af_invoice_comp_detail        = get_option( 'af_invoice_comp_detail' );
$af_invoice_heading            = get_option( 'af_invoice_heading' );
$af_invo_footer_text           = get_option( 'af_invo_footer_text' );
$af_inv_invoice_note           = get_option( 'af_inv_invoice_note' );
$af_inv_footer_backgrond_color = get_option( 'af_inv_footer_backgrond_color' );
$af_inv_footer_text_color      = get_option( 'af_inv_footer_text_color' );
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
					.af_inv_invoice_header{
						background-color: #43e3f8;
						color: black;
					}
					.af-line-temp-mid-sec-left h4 , .af-line-temp-mid-sec-right h4{
						background-color: #43e3f8 ;
						color: black;
					}
				</style>
			</head>

			<meta charset="utf-8">
			<meta name="viewport" content="width=device-width, initial-scale=1">
			<div class="af_inv_invoice_header" style="background-color:<?php echo esc_attr( $af_invoice_header_color ); ?>; color: <?php echo esc_attr( $af_invoice_header_text_color ); ?>;">
				<div style="width:45%; padding: 10px !important; display: inline-block;">
					<?php if ( ! empty( $af_invoice_upload_icon ) ) { ?>
						<img style="width: 100px!important; margin-top:10px;" src="<?php echo esc_url( $af_invoice_upload_icon ); ?>">
					<?php } ?>
				</div>
				<div style="padding:10px; width:45%; display: inline-block;">
					<h2 style="font-weight: bold; font-size: 25px; line-height: 35px; margin-bottom:5px;">
						<?php
						if ( ! empty( $af_invoice_heading ) ) {
							echo esc_attr( $af_invoice_heading );
						} else {
							echo esc_html__( 'Invoice Slip', 'af_ig_td' );
						}
						?>
					</h2>
				</div>


			</div>

			<body>


				<div class="af-pdf-wrapper" style="" >
					<div class="">
						<section class="af-pdf-header" style="padding: 20px 0;">
							<div class="af-store-info-box" style="display: inline-block; width: 50%; vertical-align: top;">
								<?php if ( 'yes' == $af_invoice_comp_detail ) { ?>
									<table>
										<?php if ( ! empty( $af_invoice_comp_name ) ) { ?>
											<tr>
												<td style="font-size:14px; line-height: 22px; padding: 2px 0;"><?php echo esc_html__( 'Company', 'af_ig_td' ); ?>:</td>
												<td style="font-size:14px; line-height: 22px; padding: 2px 0;"><?php echo esc_attr( $af_invoice_comp_name ); ?></td>
											</tr>
											<?php
										}

										if ( ! empty( $af_invoice_add_informiation ) ) {
											?>
											<tr>
												<td style="font-size:14px; line-height: 22px; padding: 2px 0;"><?php echo esc_html__( 'Address', 'af_ig_td' ); ?>:</td>
												<td style="font-size:14px; line-height: 22px; padding: 2px 0;"><?php echo esc_attr( $af_invoice_add_informiation ); ?></td>
											</tr>
										<?php } ?>

										<tr>
											<td style="font-size:14px; line-height: 22px; padding: 2px 0;"><?php echo esc_html__( 'City', 'af_ig_td' ); ?>:</td>
											<td style="font-size:14px; line-height: 22px; padding: 2px 0;"><?php echo esc_attr( get_option( 'woocommerce_store_city' ) ); ?></td>
										</tr>
										<tr>
											<td style="font-size:14px; line-height: 22px; padding: 2px 0;"><?php echo esc_html__( 'Country', 'af_ig_td' ); ?>:</td>
											<td style="font-size:14px; line-height: 22px; padding: 2px 0;"><?php echo esc_attr( get_option( 'woocommerce_default_country' ) ); ?></td>
										</tr>
									</table>
								<?php } ?>
							</div>

							<div class="af-invoice-info"style="display: inline-block; width: 40%; vertical-align:top;">

								<table>
									<tr>
										<td style="font-size:13px; line-height: 23px;"><?php echo esc_html__( 'Order Number:', 'af_ig_td' ); ?></td>
										<td style="font-size:13px; line-height: 23px;"><?php echo esc_attr( $order->get_order_number() ); ?></td>
									</tr>
									<tr>
										<td style="font-size:13px; line-height: 23px;"><?php echo esc_html__( 'Date:', 'af_ig_td' ); ?></td>
										<td style="font-size:13px; line-height: 23px;"><?php echo esc_attr( $order->get_date_created()->date_i18n( 'Y-m-d' ) ); ?></td>
									</tr>
									<tr>
										<td style="font-size:13px; line-height: 23px;"><?php echo esc_html__( 'Payment Method:', 'af_ig_td' ); ?></td>
										<td style="font-size:13px; line-height: 23px;"><?php echo esc_attr( $order->get_payment_method() ); ?></td>
									</tr>
									<tr>
										<td style="font-size:13px; line-height: 23px;"><?php echo esc_html__( 'Time:', 'af_ig_td' ); ?></td>
										<td style="font-size:13px; line-height: 23px;"><?php echo esc_attr( $order->get_date_created()->date_i18n( 'H:i:s' ) ); ?></td>
									</tr>
									<tr>
										<td style="font-size:13px; line-height: 23px;"><?php echo esc_html__( 'Email:', 'af_ig_td' ); ?></td>
										<td style="font-size:13px; line-height: 23px;"><?php echo esc_attr( $order->get_billing_email() ); ?></td>
									</tr>
								</table>
							</div>
						</section>
					</div>
					<section class="af-line-temp-mid-section" style="width: 100%; vertical-align: top; padding-bottom: 30px!important;">
						<div class="af-line-temp-mid-sec-left" style="display: inline-block; width: 49%; vertical-align: top;">
							<h4 style=" padding: 10px; background-color:<?php echo esc_attr( $af_invoice_header_color ); ?>; color: <?php echo esc_attr( $af_invoice_header_text_color ); ?>;"><?php echo esc_html__( 'Bill To', 'af_ig_td' ); ?></h4>
							<ul style="list-style: none; padding: 0!important; margin: 0!important;">
								<li style="font-size: 14px; line-height: 24px; font-weight: normal;"><label><?php echo esc_html__( 'Invoice to:', 'af_ig_td' ); ?></label> <span><?php echo esc_attr( $order->get_billing_first_name() ); ?></span></li>
								<li style="font-size: 14px; line-height: 24px; font-weight: normal;"><label><?php echo esc_html__( 'Phone:', 'af_ig_td' ); ?></label><span><?php echo esc_attr( $order->get_billing_phone() ); ?></span></li>
								<li style="font-size: 14px; line-height: 24px; font-weight: normal;"><label><?php echo esc_html__( 'E-Mail:', 'af_ig_td' ); ?></label><span><?php echo esc_attr( $order->get_billing_email() ); ?></span></li>
								<li style="font-size: 14px; line-height: 24px; font-weight: normal;"><label><?php echo esc_html__( 'Address:', 'af_ig_td' ); ?></label><span><?php echo esc_attr( $order->get_billing_address_1() ); ?></span></li>


							</ul>
						</div>
						<div class="af-line-temp-mid-sec-right" style="display: inline-block; width: 49%; vertical-align: top;">
							<h4 style="background-color:<?php echo esc_attr( $af_invoice_header_color ); ?>; color: <?php echo esc_attr( $af_invoice_header_text_color ); ?>; padding: 10px;"><?php echo esc_html__( 'Ship To', 'af_ig_td' ); ?></h4>
							<ul style="list-style: none; padding: 0!important; margin: 0!important;">
								<?php if ( ! empty( $order->get_shipping_first_name() ) ) { ?>
									<li style="font-size: 14px; line-height: 24px; font-weight: normal;">
										<label><?php echo esc_html__( 'Name:', 'af_ig_td' ); ?></label>
										<span><?php echo esc_attr( $order->get_shipping_first_name() . ' ' . $order->get_shipping_last_name() ); ?></span>
									</li>
								<?php } ?>

								<?php if ( ! empty( $order->get_shipping_company() ) ) { ?>
									<li style="font-size: 14px; line-height: 24px; font-weight: normal;">
										<label><?php echo esc_html__( 'Company Name:', 'af_ig_td' ); ?></label>
										<span><?php echo esc_attr( $order->get_shipping_company() ); ?></span>
									</li>
								<?php } ?>

								<?php if ( ! empty( $order->get_shipping_address_1() ) ) { ?>
									<li style="font-size: 14px; line-height: 24px; font-weight: normal;">
										<label><?php echo esc_html__( 'Address:', 'af_ig_td' ); ?></label>
										<span><?php echo esc_attr( $order->get_shipping_address_1() . ' ' . $order->get_shipping_address_2() ); ?></span>
									</li>
								<?php } ?>

								<?php if ( ! empty( $order->get_shipping_phone() ) ) { ?>
									<li style="font-size: 14px; line-height: 24px; font-weight: normal;">
										<label><?php echo esc_html__( 'Phone:', 'af_ig_td' ); ?></label>
										<span><?php echo esc_attr( $order->get_shipping_phone() ); ?></span>
									</li>
								<?php } ?>

								<?php if ( ! empty( $order->get_shipping_country() ) ) { ?>
									<li style="font-size: 14px; line-height: 24px; font-weight: normal;">
										<label><?php echo esc_html__( 'Country Name:', 'af_ig_td' ); ?></label>
										<span><?php echo esc_attr( $order->get_shipping_country() ); ?></span>
									</li>
								<?php } ?>
							</ul>
						</div>
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
										<td style="width:20%; text-align:center;"><?php echo wp_kses_post( $regular_price ); ?></td>
										<td style="width:20%; text-align:center;"><?php echo wp_kses_post( $total_inc_tax ); ?></td>

									</tr>
									<?php
								}
								?>
							</tbody>
						</table>

					</section>
					<section class="af-invoice-subtotal-section" style=" width:200px; float: right; background-color:<?php echo esc_attr( $af_invo_pro_table ); ?>: color:<?php echo esc_attr( $af_invo_pro_table_text ); ?>">
						<div class="af-pdf-logo"></div>
						<div class="af-invoice-subtotal" style="width:100%; background-color:<?php echo esc_attr( $af_invo_pro_table ); ?>: color:<?php echo esc_attr( $af_invo_pro_table_text ); ?>  ?> ;">
							<ul style="list-style:none; padding: 0!important; margin:0!important; ">
								<li>
									<p>
										<label style="width: 50%; display: inline-block; font-size: bold;">
											<?php esc_html_e( 'Tax', 'af_ig_td' ); ?>
										</label>
										<font>
											<?php echo wp_kses_post( wc_price( $tax_amount ) ); ?>
										</font>
									</p>
								</li>
								<li>
									<p>
										<label style="width: 50%; display: inline-block;">
											<?php esc_html_e( 'Subtotal', 'af_ig_td' ); ?>
										</label>
										<font>
											<?php echo wp_kses_post( wc_price( $order->get_subtotal() ) ); ?>
										</font>
									</p>
								</li>
								<li>
									<p>
										<label style="width: 50%; display: inline-block;">
											<?php esc_html_e( 'Discount', 'af_ig_td' ); ?>
										</label>
										<font>
											<?php echo wp_kses_post( wc_price( $order->get_discount_total() ) ); ?>
										</font>
									</p>
								</li>
								<?php if ( $order->get_shipping_total() > 0 ) : ?>
									<li>
										<p>
											<label style="width: 50%; display: inline-block;">
												<?php echo esc_attr( $order->get_shipping_method() ); ?>
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
											<?php esc_html_e( 'Total', 'af_ig_td' ); ?>
										</label>
										<font>
											<?php echo wp_kses_post( wc_price( $order->get_total() ) ); ?>
										</font>
									</p>
								</li>

							</ul>
						</div>
					</section>
				</div>
				<div id="af_inv_invoice_footer" style="background-color:<?php echo esc_attr( $af_inv_footer_backgrond_color ); ?>;color:<?php echo esc_attr( $af_inv_footer_text_color ); ?>;">
					<table style="width:100%; padding:20px;">
						<?php if ( ! empty( $af_inv_invoice_note ) ) { ?>
							<tr>
								<th style="text-align:left; padding-left: 0;"><?php echo esc_html__( 'Note :', 'af_ig_td' ); ?></th>
								<td><?php echo esc_attr( get_option( 'af_inv_invoice_note' ) ); ?></td>
							</tr>
						<?php } ?>
						<tr>
							<th style="text-align:left; padding-left: 0;"> <?php echo esc_html__( 'Terms and Conditions', 'af_ig_td' ); ?></th>
							<td>
							<?php
							if ( ! empty( $af_invo_footer_text ) ) {
								?>
								<?php echo esc_attr( $af_invo_footer_text ); ?><?php } ?></td>
						</tr>
					</table>
				</div>
			</body>
			</html>
