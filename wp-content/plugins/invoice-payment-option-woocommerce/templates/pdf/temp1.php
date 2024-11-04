
<style type="text/css">
	<?php require AF_IG_PLUGIN_DIR . 'include/css/attachment.css'; ?>
	#af_inv_proforma_note, #af_inv_invoice_footer{
		font-size: 10pt !important;
	}
	#af_inv_invoice_footer{
		/*position: fixed !important; 
		bottom: 0px !important; 
		left: 0!important; 
		right: 0 !important;*/
		display: block!important;
		width: 100%;
		background-color: #220053;
		color: white;
	}

	.container{
		width: 100%;
		margin: 0;
		position: relative;
	}

	.row{
		width: 100%;
	}   

	.col-6{
		text-align: center;
		width: 100%;
	}

	.col-6 .text{
		padding: 0px 57px 0px 20px;
		color: black;
		margin: 0px;
	}

	.afcea-img img{
		height: auto;
		width: 130px;
		display: block;
		margin: 0px;
		background: transparent;
	}

	.pdf-table .header_text{
		border-top-left-radius: 25px;
		padding: 20px 0px 30px 17px;
	}

	.header_text h4{
		padding: 0;
		margin: 0; 
		float: left;
	}

	.pdf-table {
		width:100%;
		max-width:625px;
		margin:20px auto;
	}

	.pdf-table table {
		font-family: arial, sans-serif;
		width: 100%;
	}

	.pdf-table th{
		background-color: #0668ac;
		width: 40%;
	}

	.pdf-table td {
		padding: 7px 15px;
		border: 1px solid #dddddd;
	}

	.pdf-table tr:nth-child(even) {
		background-color: #dddddd;
	}


	.container footer {
		font-size: 18px; 
		line-height: 22px;
		width: 100%;
		position: fixed;
		bottom: 0px;
		color: black;
		text-align: center;
	}
	.af-invoice-info {
		width: 100%;
		max-width: 1000px;
		position: relative;
		margin: 0 auto;
		display: block;
		font-family: 'Poppins', sans-serif !important;
		color: white;
	}

	.af-invoice-pdf ul {
		list-style: none;
		padding: 0;
		margin: 0;
	}

	.af-invoice-pdf-header {
		display: table;
		width: 100%;
		padding: 15px 20px;
		background-color:  #220053;
		color: white;
		color: <?php echo esc_attr( get_option( 'af_invoice_header_text_color' ) ); ?> ;
		background-color: <?php echo esc_attr( get_option( 'af_invoice_header_color' ) ); ?> ;
		box-sizing: border-box;
	}

	.af-store-info-box {
		width: 70%;
		vertical-align: top;
		display: table-cell;
		text-align: left;
	}

	.af-store-info-box h3 {
		font-size: 16px;
		line-height: 26px;
		color: #000;
		font-weight: bold;
		margin: 0 0 15px;
	}

	.af-store-info-box li {
		display: inline-block;
		vertical-align: top;
		margin-right: 15px;
	}

	.af-store-info-box p {
		margin-right: 0px;
	}

	.af-store-info-box img {
		max-width: 100px;
	}



	.af-invoice-pdf-header p {
		font-size: 14px;
		line-height: 24px;
	}

	.af-invoice-info {
		display: table-cell;
		width: 30%;
		vertical-align: top;
		text-align: left;
	}
	.af-invoice-info table{
		color: white;
		text-align: left;
	}
	.af-invoice-info table tr td{
		width: 40%;
		padding: 5px 10px !important;
		font-size: 14px;
		line-height: 24px;
	}

	.af-invoice-info h2{
		font-size: 20px;
		line-height: 42px;
		margin: 0 0 15px;
		color: white;
		font-weight: bold;
		test-align:left;
	}

	.af-invoice-subtotal-section ul li p {
		display: block;
		margin: 10px 0;
		font-size: 14px;
		line-height: 24px;
	}

	.af-invoice-subtotal-section ul li p label,
	.af-invoice-mid-section ul li p label {
		display: inline-block;
		width: 48%;
		vertical-align: middle;
		font-weight: bold;
		text-align: left;
	}

	.af-invoice-subtotal-section ul li p font,
	.af-invoice-mid-section ul li p span {
		text-align: left;
		display: inline-block;
		width: 48%;
		vertical-align: middle;
	}

	.af-invoice-pdf-content table {
		width: 100%;
		border-collapse: collapse;
	}

	.af-invoice-pdf-content table tbody tr td {
		border: 1px solid #393a3c38;
	}

	.af-invoice-pdf-content table thead th {
		border: 1px solid #393a3c38;
		background-color: #220053;
		color: #fff;
		font-size: 14px;
		line-height: 24px;
		padding: 5px;
		text-align: left;
	}

	.af-invoice-pdf-content table tbody tr td:first-child {
		font-weight: 800;
	}

	.af-invoice-pdf-content table tbody tr td:last-child,
	.af-invoice-pdf-content table thead tr th:last-child {
		text-align: left;
	}

	.af-invoice-pdf-content table tbody tr:nth-child(even) {
/*		background-color: #ebf6ff;*/
		border: 1px solid;
		border-color: black;
	}

	.af-invoice-pdf-content table tbody tr:nth-child(odd) {
/*		background-color: #fff;*/
		border: 1px solid;
		border-color: black;
	}

	.af-invoice-product-img img {
		width: 50px;
		height: 50px;
		border-radius: 6px;
	}

	.invoice_product_sku_td small {
		font-size: 10px;
	}
	.invoice_product_sku_td span{
		font-weight: 700;
	}
	.af-invoice-subtotal-section ul li,
	.af-invoice-mid-section ul li {
		width: 100%;
	}

	.af-invoice-subtotal-section .af-invoice-total-label {
		padding: 5px 10px;
		color: #fff;
		font-size: 15px;
		margin: 0!important;
		background-color: black; 
	}

	.af-invoice-subtotal-section .af-invoice-total-label label,
	.af-invoice-subtotal-section .af-invoice-total-label span {
		font-size: 20px;
		line-height: 30px;
		color: #fff
	}

	.af-invoice-pdf-content table td {
		font-size: 14px;
		line-height: 24px;
		padding: 5px;
		text-align: left;
	}

	.af-invoice-mid-section {
		margin: 10px 0 20px;
		display: table;
		width: 100%;
		padding: 20px;
	}
	.af-invoice-pdf-content{
		padding: 20px;
	}
	.af-invoice-mid-section ul li p {
		width: 90%;
		margin: 0 0 10px;
		font-size: 12px;
		line-height: 22px;
	}

	.af-line-invoice-mid-sec-left,
	.af-line-invoice-sec-right {
		display: table-cell;
		vertical-align: top;
		width: 50%;
	}
	.af-line-invoice-sec-right h4{
		color: white;
	}
	.af_invoice_header_color h4{
		color: white;
	}

	.af-invoice-mid-section h4 {
		font-size: 20px;
		line-height: 30px;
		background-color: #220053;
		color: black;
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

	#invoice_note {
		width: 100%;
		padding: 10px;
		max-width: 1150px;
		margin: 0 auto;
		background-color: #ff6600;
	}

	.af-invoice-subtotal {
		display: table-cell;
		width: 35%;
		vertical-align: top;
		text-align: right;
		padding: 20px;
	}

</style>
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

<div class="af-invoice-pdf">
	<section class="af-invoice-pdf-header" style="background-color: <?php echo esc_attr( $af_invoice_header_color ); ?>  color: <?php echo esc_attr( $af_invoice_header_text_color ); ?>;">
		<div class="af-store-info-box">
			<table>
				<tr>
					<td>
						<?php if ( ! empty( $af_invoice_upload_icon ) ) { ?>
							<img style="width: 150px!important; margin-top:10px;" src="<?php echo esc_url( $af_invoice_upload_icon ); ?>">
						<?php } ?>

					</td>
				</tr>
				<?php if ( ! empty( $af_invoice_comp_name ) ) { ?>
					<tr>
						<td style="   color: <?php echo esc_attr( $af_invoice_header_text_color ); ?>; font-size:14px; line-height: 18px; padding: 1px 0;"><?php echo esc_html__( 'Company', 'af_ig_td' ); ?>:</td>
						<td style=" color: <?php echo esc_attr( $af_invoice_header_text_color ); ?>; font-size:14px; line-height: 18px; padding: 1px 0;"><?php echo esc_attr( $af_invoice_comp_name ); ?></td>
					</tr>
					<?php
				}

				if ( ! empty( $af_invoice_add_informiation ) ) {
					?>
					<tr>
						<td style=" color: <?php echo esc_attr( $af_invoice_header_text_color ); ?>; font-size:14px; line-height: 18px; padding: 1px 0;"><?php echo esc_html__( 'Address', 'af_ig_td' ); ?>:</td>
						<td style="  color: <?php echo esc_attr( $af_invoice_header_text_color ); ?>; font-size:14px; line-height: 18px; padding: 1px 0;"><?php echo esc_attr( $af_invoice_add_informiation ); ?></td>
					</tr>
				<?php } ?>

				<tr>
					<td  style=" color: <?php echo esc_attr( $af_invoice_header_text_color ); ?>; font-size:14px; line-height: 18px; padding: 1px 0;"><?php echo esc_html__( 'City', 'af_ig_td' ); ?>:</td>
					<td  style=" color: <?php echo esc_attr( $af_invoice_header_text_color ); ?>; font-size:14px; line-height: 18px; padding: 1px 0;"><?php echo esc_attr( get_option( 'woocommerce_store_city' ) ); ?></td>
				</tr>
				<tr>
					<td style=" color: <?php echo esc_attr( $af_invoice_header_text_color ); ?>; font-size:14px; line-height: 18px; padding: 1px 0;"><?php echo esc_html__( 'Country', 'af_ig_td' ); ?>:</td>
					<td style=" color: <?php echo esc_attr( $af_invoice_header_text_color ); ?>; font-size:14px; line-height: 18px; padding: 1px 0;"><?php echo esc_attr( get_option( 'woocommerce_default_country' ) ); ?></td>
				</tr>

			</table>
		</div>

		<div class="af-invoice-info">
			<h2 style="font-weight: bold; color:<?php echo esc_attr( $af_invoice_header_text_color ); ?> font-size: 25px; line-height: 35px; margin-bottom:5px;">
				<?php
				if ( ! empty( $af_invoice_heading ) ) {
					echo esc_attr( $af_invoice_heading );
				} else {
					echo esc_html__( 'Invoice Slip', 'af_ig_td' );
				}
				?>
			</h2>
			<table>
				<tr style="color:<?php echo esc_attr( $af_invoice_header_text_color ); ?>">
					<td><?php esc_html_e( 'Order Number:', 'af_ig_td' ); ?></td>
					<td><?php echo esc_attr( $order->get_order_number() ); ?></td>
				</tr>
				<tr style="color:<?php echo esc_attr( $af_invoice_header_text_color ); ?>">
					<td><?php esc_html_e( 'Date:', 'af_ig_td' ); ?></td>
					<td><?php echo esc_attr( $order->get_date_created()->date_i18n( 'Y-m-d' ) ); ?></td>
				</tr >
				<tr style="color:<?php echo esc_attr( $af_invoice_header_text_color ); ?>">
					<td><?php esc_html_e( 'Payment Method:', 'af_ig_td' ); ?></td>
					<td><?php echo esc_attr( $order->get_payment_method() ); ?></td>
				</tr>
				<tr style="color:<?php echo esc_attr( $af_invoice_header_text_color ); ?>">
					<td><?php esc_html_e( 'Time:', 'af_ig_td' ); ?></td>
					<td><?php echo esc_attr( $order->get_date_created()->date_i18n( 'H:i:s' ) ); ?></td>
				</tr>
				<tr style="color:<?php echo esc_attr( $af_invoice_header_text_color ); ?>">
					<td><?php esc_html_e( 'Email:', 'af_ig_td' ); ?></td>
					<td><?php echo esc_attr( $order->get_billing_email() ); ?></td>
				</tr>
			</table>

		</div>
	</section>

	<section class="af-invoice-mid-section">
		<div class="af-line-invoice-mid-sec-left">
			<h4 style=" color:white; background-color:<?php echo esc_attr( $af_invoice_header_color ); ?>; color: <?php echo esc_attr( $af_invoice_header_text_color ); ?>;">
				<?php esc_html_e( 'Bill To', 'af_ig_td' ); ?>
			</h4>
			<ul>
				<?php if ( ! empty( $order->get_billing_company() ) ) { ?>
					<li>
						<p>
							<label>
								<?php echo esc_html__( 'Company Name:', 'af_ig_td' ); ?>
							</label>
							<span>
								<?php echo esc_attr( $order->get_billing_company() ); ?>
							</span>
						</p>
					</li>
				<?php } ?> 
				<li>
					<p>
						<label>
							<?php echo esc_html__( 'Address:', 'af_ig_td' ); ?>
						</label>
						<span>
							<?php echo esc_attr( $order->get_billing_address_1() ); ?>
						</span>
					</p>
				</li>
				<li>
					<p>
						<label>
							<?php esc_html_e( 'Phone:', 'af_ig_td' ); ?>
						</label>
						<span>
							<?php echo esc_attr( $order->get_billing_phone() ); ?>
						</span>
					</p>
				</li>
				<li>
					<p>
						<label>
							<?php esc_html_e( 'E-Mail:', 'af_ig_td' ); ?>
						</label>
						<span>
							<?php
							$order_email = $order->get_billing_email();
							echo esc_attr( $order_email );
							?>
						</span>
					</p>
				</li>
			</ul>
		</div>
		<?php if ( ! empty( $order ) ) : ?>
			<div class="af-line-invoice-sec-right">
				<h4 style= " color:white; background-color:<?php echo esc_attr( $af_invoice_header_color ); ?>; color: <?php echo esc_attr( $af_invoice_header_text_color ); ?>;"><?php esc_html_e( 'Ship To', 'af_ig_td' ); ?></h4>
				<ul>
					<?php if ( ! empty( $order->get_shipping_first_name() ) ) : ?>
						<li>
							<p>
								<label><?php echo esc_html__( 'Name:', 'af_ig_td' ); ?></label>
								<span><?php echo esc_attr( $order->get_shipping_first_name() ); ?></span>
							</p>
						</li>
					<?php endif; ?>


					<?php if ( ! empty( $order->get_shipping_address_1() ) ) : ?>
						<li>
							<p>
								<label><?php echo esc_html__( 'Address:', 'af_ig_td' ); ?></label>
								<span><?php echo esc_attr( $order->get_shipping_address_1() ); ?></span>
							</p>
						</li>
					<?php endif; ?>

					<?php if ( ! empty( $order->get_shipping_phone() ) ) : ?>
						<li>
							<p>
								<label><?php esc_html_e( 'Phone:', 'af_ig_td' ); ?></label>
								<span><?php echo esc_attr( $order->get_shipping_phone() ); ?></span>
							</p>
						</li>
					<?php endif; ?>

					<?php if ( ! empty( $order->get_shipping_country() ) ) : ?>
						<li>
							<p>
								<label><?php esc_html_e( 'Country Name:', 'af_ig_td' ); ?></label>
								<span><?php echo esc_attr( $order->get_shipping_country() ); ?></span>
							</p>
						</li>
					<?php endif; ?>
				</ul>
			</div>
		<?php endif; ?>
	</section>

	<section class="af-invoice-pdf-content" style="padding-top: 30px!important;" >
		<table>
			<thead style="background-color: <?php echo esc_attr( $af_invo_pro_table ); ?>; color: <?php echo esc_attr( $af_invo_pro_table_text ); ?>;">
				<tr style="text-align:center;">
					<th style=" width:20%; text-align:center; background-color: <?php echo esc_attr( $af_invo_pro_table ); ?>; color: <?php echo esc_attr( $af_invo_pro_table_text ); ?>"><?php echo esc_html__( 'Image', 'af_ig_td' ); ?></th>
					<th style=" width:20%; text-align:center; background-color: <?php echo esc_attr( $af_invo_pro_table ); ?>; color: <?php echo esc_attr( $af_invo_pro_table_text ); ?>"><?php echo esc_html__( 'Product Name', 'af_ig_td' ); ?></th>
					<th style=" width:20%; text-align:center; background-color: <?php echo esc_attr( $af_invo_pro_table ); ?>; color: <?php echo esc_attr( $af_invo_pro_table_text ); ?>"><?php echo esc_html__( 'QTY', 'af_ig_td' ); ?></th>
					<th style=" width:20%; text-align:center; background-color: <?php echo esc_attr( $af_invo_pro_table ); ?>; color: <?php echo esc_attr( $af_invo_pro_table_text ); ?>"><?php echo esc_html__( 'Price', 'af_ig_td' ); ?></th>

					<th style=" width:20%; text-align:center; background-color: <?php echo esc_attr( $af_invo_pro_table ); ?>; color: <?php echo esc_attr( $af_invo_pro_table_text ); ?>"><?php echo esc_html__( 'Total', 'af_ig_td' ); ?></th>

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
						<td style="padding:10px; text-align:center;  margin:0 auto !important"  class="af-invoice-product-img">
							<?php echo wp_kses_post( $product->get_image() ); ?>
						</td>
						<td style="text-align:center;" class="invoice_product_sku_td">
							<span style="font-weight: bold !important;"><?php echo wp_kses_post( $product->get_name() ); ?></span><br>
							<small><?php echo wp_kses_post( $product->get_sku() ); ?></small><br>
						</td>
						<td style="text-align:center;"><?php echo wp_kses_post( $quantity ); ?></td>
						<td style="text-align:center;"><?php echo wp_kses_post( wc_price($regular_price ) ); ?></td>

						<td style="text-align:center;"><?php echo wp_kses_post(wc_price( $total_inc_tax ) ); ?></td>

					</tr>
					<?php
				}
				?>
			</tbody>
		</table>

	</section>

	<section class="af-invoice-subtotal-section">
		<div class="af-pdf-logo"></div>
		<div class="af-invoice-subtotal" style="background-color:<?php echo esc_attr( $af_invo_pro_table ); ?>;
		color: <?php echo esc_attr( $af_invo_pro_table_text ); ?>;">
		<ul>
			<li>
				<p>
					<label style="font-size:bold;">
						<?php esc_html_e( 'Tax', 'af_ig_td' ); ?>
					</label>
					<font>
						<?php echo wp_kses_post( wc_price( $tax_amount ) ); ?>
					</font>
				</p>
			</li>
			<li>
				<p>
					<label style="font-size:bold;">
						<?php esc_html_e( 'Subtotal', 'af_ig_td' ); ?>
					</label>
					<font>
						<?php echo wp_kses_post( $order->get_subtotal() ); ?>
					</font>
				</p>
			</li>
			<li>
				<p>
					<label style="font-size:bold;">
						<?php esc_html_e( 'Discount', 'af_ig_td' ); ?>
					</label>
					<font>
						<?php echo wp_kses_post( $order->get_discount_total() ); ?>
					</font>
				</p>
			</li>
			<?php if ( $order->get_shipping_total() > 0 ) : ?>
				<li>
					<p>
						<label>
							<?php echo esc_attr( $order->get_shipping_method() ); ?>
						</label>
						<font>
							<?php echo wp_kses_post( $order->get_shipping_total() ); ?>
						</font>
					</p>
				</li>
			<?php endif; ?>

			<li>
				<p class="af-invoice-total-label">
					<label style="font-size:bold;">
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
</div>

