<?php
/**
 * Extra fee
 *
 * Displays the meta box for payment-invoice, virtual products-enable/disbale, shipping methods
 *
 * @package  addify-invoice-gateway/meta-boxes
 * @version  1.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Get Post Meta.

$ship_method = json_decode( get_post_meta( get_the_ID(), 'af_ig_shipping', true ) );
$ship_method = is_array( $ship_method ) ? $ship_method : array();
?>
<div class="extra-fee">
	<?php wp_nonce_field( 'af_ig_nonce_action', 'af_ig_field_nonce' ); ?>
	<table class="addify-table-optoin">
		<tr class="addify-option-field">
			<th>
				<div class="option-head">
					<h3>
						<?php echo esc_html__( 'Select Shipping Methods', 'af_ig_td' ); ?>
					</h3>
				</div>
			</th>
			<td>
			<?php

				$shipping_methods = array();
			foreach ( WC()->shipping()->load_shipping_methods() as $method ) {
				$shipping_methods[ $method->id ] = $method->get_method_title();
			}
			?>
				<div>
				<?php
				foreach ( $shipping_methods as $key => $value ) {
					?>
					<p><input type="checkbox" name="af_ig_shipping[]" value="<?php echo esc_attr( $key ); ?>" <?php echo in_array( (string) $key, $ship_method, true ) ? 'checked' : ''; ?> >
					<?php echo esc_attr( $value ); ?> </p> 
								<?php
				}
				?>
				</div>
				<p><?php echo esc_html__( 'Show invoice payment option on shipping method bases. Leave empty for all', 'af_ig_td' ); ?></p>
			</td>
		</tr>
		
	</table>
</div>
