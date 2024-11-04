<?php
/**
 * Invoice-payment Conditions for Cart
 *
 * Displays the meta box for invoice-payment cart amount, Products, Product Categories and tags.
 *
 * @package  addify-invoice-gateway/meta-boxes
 * @version  1.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( 'auto-draft' == get_post_status( get_the_ID() ) ) {

	update_post_meta( get_the_ID(), 'af_ig_enable_products', 'yes' );

}

$cart_amount = json_decode( get_post_meta( get_the_ID(), 'af_ig_cart_amount', true ) );

$tax_enable            = get_post_meta( get_the_ID(), 'af_ig_enable_tax', true );
$af_ig_enable_products = get_post_meta( get_the_ID(), 'af_ig_enable_products', true );

// echo $af_ig_enable_products;exit();
$cart_quantity = json_decode( get_post_meta( get_the_ID(), 'af_ig_cart_quantity', true ) );

$sel_products1 = json_decode( get_post_meta( get_the_ID(), 'af_ig_cart_products', true ) );
$sel_cat       = json_decode( get_post_meta( get_the_ID(), 'af_ig_cart_products_cat', true ) );
$sel_tag       = json_decode( get_post_meta( get_the_ID(), 'af_ig_cart_products_tag', true ) );

// Variable Values check.
$cart_amount = is_array( $cart_amount ) ? $cart_amount : array();

$cart_quantity = is_array( $cart_quantity ) ? $cart_quantity : array();
$sel_products1 = is_array( $sel_products1 ) ? $sel_products1 : array();
$sel_cat       = is_array( $sel_cat ) ? $sel_cat : array();
$sel_tag       = is_array( $sel_tag ) ? $sel_tag : array();

$cart_amount[0] = isset( $cart_amount[0] ) ? $cart_amount[0] : '';
$cart_amount[1] = isset( $cart_amount[1] ) ? $cart_amount[1] : '';

$cart_quantity[0] = isset( $cart_quantity[0] ) ? $cart_quantity[0] : '';
$cart_quantity[1] = isset( $cart_quantity[1] ) ? $cart_quantity[1] : '';

?>
<div class="extra-fee-conditions">
	<?php wp_nonce_field( 'af_ig_nonce_action', 'af_ig_field_nonce' ); ?>
	<table class="addify-table-optoin">
		<tr class="addify-option-field">
			<th>
				<div class="option-head">
					<h3>
						<?php echo esc_html__( 'Cart Amount Range', 'af_ig_td' ); ?>
					</h3>
				</div>
			</th>
			<td>
				<input min="1" type="number" class="input-text-half"  title="Cart Amount Lower Limit" placeholder="Cart Amount Lower Limit..." name="af_ig_cart_amount[0]" value="<?php echo esc_attr( $cart_amount[0] ); ?>">
				<input min="1" type="number" class="input-text-half"  placeholder="Cart Amount Upper Limit..." name="af_ig_cart_amount[1]" title="Cart Amount Upper Limit" value="<?php echo esc_attr( $cart_amount[1] ); ?>">
				<br>
				<p><?php echo esc_html__( 'Set Cart range. payment invoice method will show/hide on the bases of cart subtotal.', 'af_ig_td' ); ?></p>
			</td>
		</tr>
		<tr class="addify-option-field">
			<th>
				<div class="option-head">
					<h3>
						<?php echo esc_html__( 'Cart Quantity Range', 'af_ig_td' ); ?>
					</h3>
				</div>
			</th>
			<td>
				<input min="1" type="number" class="input-text-half"  title="Cart quantity Lower Limit" placeholder="Cart Quantity Lower Limit..." name="af_ig_cart_quantity[0]" value="<?php echo esc_attr( $cart_quantity[0] ); ?>">
				<input min="1" type="number" class="input-text-half"  placeholder="Cart quantity Upper Limit..." name="af_ig_cart_quantity[1]" title="Cart Quantity Upper Limit" value="<?php echo esc_attr( $cart_quantity[1] ); ?>">
				<br>
				<p><?php echo esc_html__( 'Set cart quantity, payment invoice method will show/hide on the bases of cart total items.', 'af_ig_td' ); ?></p>
			</td>
		</tr>
		<tr class="addify-option-field">
			<th>
				<div class="option-head">
					<h3>
						<?php echo esc_html__( 'Enable invoice payment option for all products.', 'af_ig_td' ); ?>
					</h3>
				</div>
			</th>
			<td>
				<input type="checkbox" name="af_ig_enable_products" class="af_ig_products" value="yes" <?php checked( 'yes', $af_ig_enable_products ); ?> >
				<p><?php echo esc_html__( 'Use this option to show Invoice for all Products. Atleast 1 product should be in cart', 'af_ig_td' ); ?></p>
			</td>
		</tr>

		<tr class="addify-option-field hide_ig_setting_pro">

			<th>
				<div class="option-head">
					<h3>
						<?php echo esc_html__( 'Enable Invoice for Products, Categories & tags', 'af_ig_td' ); ?>
					</h3>
				</div>
			</th>
			<td>
				<?php
					$enable        = isset( $sel_products1[0] ) ? $sel_products1[0] : 'any';
					$sel_products1 = isset( $sel_products1[1] ) ? $sel_products1[1] : array();
				?>
				<input type="radio" name="af_ig_cart_products[0]"  value="disallow" <?php echo checked( 'disallow', $enable ); ?> /><?php echo esc_html__( 'Disallow other products ', 'af_ig_td' ); ?>
				<input type="radio" name="af_ig_cart_products[0]"  value="only" <?php echo checked( 'only', $enable ); ?> /><?php echo esc_html__( 'Allow other products', 'af_ig_td' ); ?>
				<input type="radio" name="af_ig_cart_products[0]"  value="any" <?php echo checked( 'any', $enable ); ?> /><?php echo esc_html__( 'At least one Product', 'af_ig_td' ); ?>
				<br>
				<p><?php echo esc_html__( 'Invoice Payment Option will NOT display if there is any other product in cart beside the products selected below', 'af_ig_td' ); ?></p>
				<p><?php echo esc_html__( 'Invoice Payment Option will display if any of the selected product is in cart. No matter if there is any other product in cart.', 'af_ig_td' ); ?></p>
				<p><?php echo esc_html__( 'Any one of selected Product in cart. (Other products can be in cart)', 'af_ig_td' ); ?></p>
				<br>
				<select name="af_ig_cart_products[1][]" data-placeholder="Choose Products..."  class="af-ig-ajax-products-search" multiple>
					<?php
					foreach ( $sel_products1 as $product_id1 ) {
						?>
						<option value="<?php echo esc_attr( $product_id1 ); ?>" selected >
						<?php echo esc_attr( get_the_title( intval( $product_id1 ) ) ); ?>
						</option>
						<?php
					}
					?>
				</select>
				<?php


					$product_cat = get_terms( 'product_cat' );
				?>
				<br>
				<p><?php echo esc_html__( 'Enable Invoice when cart has specific product', 'af_ig_td' ); ?></p>
				<select name="af_ig_cart_products_cat[]"  data-placeholder="Choose Categories..." class="af-ig-select2" multiple >
					<?php foreach ( $product_cat as $category ) : ?>
						<option value="<?php echo intval( $category->term_id ); ?>" 
						<?php echo in_array( (string) $category->term_id, $sel_cat, true ) ? 'selected' : ''; ?>
						>
						<?php echo esc_html( $category->name ); ?>
						</option>
					<?php endforeach; ?>
				</select>
				<br>
				<p><?php echo esc_html__( 'Enable Invoice when cart has specific category', 'af_ig_td' ); ?></p>
				<select name="af_ig_cart_products_tag[]"  data-placeholder="Choose tags..." class="af-ig-select2" multiple >

					<?php
					$termss     = get_terms( 'product_tag' );
					$term_array = array();
					if ( ! empty( $termss ) && ! is_wp_error( $termss ) ) {

						foreach ( $termss as $terme ) :
							?>
						<option value="<?php echo intval( $terme->term_id ); ?>"
								<?php echo in_array( (string) $terme->term_id, $sel_tag, true ) ? 'selected' : ''; ?>
						>
							<?php echo esc_html( $terme->name ); ?>
						</option>
							<?php
					endforeach;
					}
					?>
				</select>
				<p><?php echo esc_html__( 'Enable Invoice when cart has specific tag', 'af_ig_td' ); ?></p>
			</td>
		</tr>


		<tr class="addify-option-field hide_ig_setting_pro">
			<th>
				<div class="option-head">
					<h3>
						<?php echo esc_html__( 'Enable Invoice For Virtual Product.', 'af_ig_td' ); ?>
					</h3>
				</div>
			</th>
			<td>
				<input type="checkbox" name="af_ig_enable_tax" value="yes"  <?php checked( 'yes', $tax_enable ); ?> >
				<p><?php echo esc_html__( 'Use this option to enable Invoice for Virtual Product. Atleast 1 virtual product should be in cart', 'af_ig_td' ); ?></p>
			</td>
		</tr>

	</table>
</div>
