<?php
/**
 * Invoice payment Conditions for Cart
 *
 * Displays the meta box for invoice-payment for  cart amount, Products, Product Categories and tags
 *
 * @package  addify-invoice-gateway/meta-boxes
 * @version  1.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$sel_customers1 = json_decode( get_post_meta( get_the_ID(), 'af_ig_customer_select', true ) );
$sel_roles1     = json_decode( get_post_meta( get_the_ID(), 'af_ig_customer_roles', true ) );

// Variable Values check.
$sel_customers1 = is_array( $sel_customers1 ) ? $sel_customers1 : array();
$sel_roles1     = is_array( $sel_roles1 ) ? $sel_roles1 : array();
?>
<div class="extra-fee-conditions">
	<?php wp_nonce_field( 'af_ig_nonce_action', 'af_ig_field_nonce' ); ?>
	<table class="addify-table-optoin">
		<tr class="addify-option-field">
			<th>
				<div class="option-head">
					<h3>
						<?php echo esc_html__( 'Enable Invoice for customers', 'af_ig_td' ); ?>
					</h3>
				</div>
			</th>
			<td>
				<select name="af_ig_customer_select[]"  data-placeholder="Select Customers..." class=" af_ig_ajax_customer_search" multiple="multiple">
				<?php
				foreach ( $sel_customers1 as $usr1 ) {
					$author_obj = get_user_by( 'id', $usr1 );
					?>
					<option value="<?php echo intval( $usr1 ); ?>" selected="selected"><?php echo esc_attr( $author_obj->display_name ); ?>(<?php echo esc_attr( $author_obj->user_email ); ?>)</option>
					<?php
				}
				?>
				</select>
				<p><?php echo esc_html__( 'Search and select customers Leave empty for all.', 'af_ig_td' ); ?></p>
			</td>
		</tr>
		<tr class="addify-option-field">
			<th>
				<div class="option-head">
					<h3>
						<?php echo esc_html__( 'Enable Invoice for User Roles', 'af_ig_td' ); ?>
					</h3>
				</div>
			</th>
			<td>
				<div class="all_cats">
					<ul>
					<?php
					global $wp_roles;
					$roles = $wp_roles->get_names();
					foreach ( $roles as $key => $value ) {
						?>
						<li class="par_cat">
							<input type="checkbox" class="parent" name="af_ig_customer_roles[]"  value="<?php echo esc_attr( $key ); ?>" 
						<?php
						if ( ! empty( $sel_roles1 ) && in_array( (string) $key, $sel_roles1, true ) ) {
							echo 'checked';
						}
						?>
							/>
						<?php
						echo esc_attr( $value );
						?>
						</li>

					<?php } ?>
						<li class="par_cat">
							<input type="checkbox" class="parent" name="af_ig_customer_roles[]"  value="guest" 
							<?php
							if ( ! empty( $sel_roles1 ) && in_array( 'guest', $sel_roles1, true ) ) {
								echo 'checked';
							}
							?>
								/>
							<?php echo esc_html__( 'Guest', 'af_ig_td' ); ?>
						</li>
					</ul>
				</div>
				<p><?php echo esc_html__( 'Select user roles leave empty for all.', 'af_ig_td' ); ?></p>
			</td>
		</tr>
	</table>
</div>
