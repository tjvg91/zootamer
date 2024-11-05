<?php

// Include Header
include_once 'header.php'; // phpcs:ignore

global $wpowp_fs;

$option = $this->get_settings(); // phpcs:ignore VariableAnalysis.CodeAnalysis.VariableAnalysis.UndefinedVariable

?>
<div class="container">
	<h1><?php esc_html_e( 'Settings', WPOWP_TEXT_DOMAIN ); ?></h1>
	<form id="<?php echo esc_attr( WPOWP_PLUGIN_PREFIX ); ?>settings-form" method="post" action="<?php echo esc_url( admin_url( 'admin.php' ) ); ?>">
		<table class="form-table wpowp-content-table">
			<tbody>

				<?php if ( $wpowp_fs->is_paying() ) { ?>
					<tr>
					<th scope="row"><?php esc_html_e( 'Enable Site-Wide', WPOWP_TEXT_DOMAIN ); ?></th>
					<td>
						<fieldset>
							<legend class="screen-reader-text">
								<span>checkbox</span>
							</legend>
							<label for="wpowp_enable_sitewide">
								<input type="hidden" name="wpowp_enable_sitewide" value="no" />
								<input name="wpowp_enable_sitewide" type="checkbox" id="wpowp_enable_sitewide" value="yes"
									<?php echo ( true === filter_var( $option['enable_sitewide'], FILTER_VALIDATE_BOOLEAN ) ) ? 'checked' : ''; ?> />
								
							</label>
						</fieldset>
						<p><?php esc_html_e( '( Enable Place Order Without Payment store-wide in WooCommerce )', WPOWP_TEXT_DOMAIN ); ?></p>
					</td>
				</tr>
				<?php } ?>
				
				<tr class="wpowp-admin-separator">
					<th scope="row"><label
							for="wpowp_order_status"><?php esc_html_e( 'Order Status', WPOWP_TEXT_DOMAIN ); ?></label>
					</th>
					<td>					
						<select class="regular-text wc-enhanced-select" name="wpowp_order_status" id="wpowp_order_status">
							<?php
							if ( ! empty( $this->order_status_list() ) ) {
								$status_list = $this->order_status_list(); //phpcs:ignore VariableAnalysis.CodeAnalysis.VariableAnalysis.UndefinedVariable 
								foreach ( $status_list as $key => $label ) {
									echo '<option value="' . wp_kses_post( $key ) . '" ' . ( $key === $option['order_status'] ? 'selected' : '' ) . '>' . wp_kses_post( $label ) . '</option>';
								}
							}
							?>
						</select>
						<p><?php esc_html_e( '( Order status after placing order )', WPOWP_TEXT_DOMAIN ); ?></p>
					</td>
				</tr>
				<tr>
					<th scope="row"><?php esc_html_e( 'Skip Cart', WPOWP_TEXT_DOMAIN ); ?></th>
					<td>
						<fieldset>
							<legend class="screen-reader-text">
								<span>checkbox</span>
							</legend>
							<label for="wpowp_skip_cart">
								<input type="hidden" name="wpowp_skip_cart" value="no" />
								<input name="wpowp_skip_cart" type="checkbox" id="wpowp_skip_cart" value="yes"
									<?php echo ( true === filter_var( $option['skip_cart'], FILTER_VALIDATE_BOOLEAN ) ) ? 'checked' : ''; ?> />
								
							</label>
						</fieldset>
						<p><?php esc_html_e( '( Skip Cart & Go to Checkout on Add to Cart )', WPOWP_TEXT_DOMAIN ); ?></p>
					</td>
				</tr>
				<tr>
					<th scope="row"><?php esc_html_e( 'Standard Add Cart Button', WPOWP_TEXT_DOMAIN ); ?></th>
					<td>
						<fieldset>
							<legend class="screen-reader-text">
								<span>checkbox</span>
							</legend>
							<label for="wpowp_standard_add_cart">
								<input type="hidden" name="wpowp_standard_add_cart" value="no" />
								<input name="wpowp_standard_add_cart" type="checkbox" id="wpowp_standard_add_cart" value="yes"
									<?php echo ( true === filter_var( $option['standard_add_cart'], FILTER_VALIDATE_BOOLEAN ) ) ? 'checked' : ''; ?> />							
							</label>
						</fieldset>
						<p><?php esc_html_e( '( Standard Add to cart button on shop pages )', WPOWP_TEXT_DOMAIN ); ?></p>
					</td>
				</tr>				
				<?php
				if ( $wpowp_fs->is_paying() ) {
					?>
									
				<tr class="wpowp-admin-separator-1">
					<th scope="row"><?php esc_html_e( 'Add to cart text', WPOWP_TEXT_DOMAIN ); ?></th>
					<td>
						<input name="wpowp_add_cart_text" class="regular-text"type="text" value="<?php echo esc_attr( $option['add_cart_text'] ); ?>" />
						<p><?php esc_html_e( '( Add to cart text works if Standard Add to cart is unchecked )', WPOWP_TEXT_DOMAIN ); ?></p>
					</td>
				</tr>
				<tr class="wpowp-admin-separator">
					<th scope="row"><?php esc_html_e( 'Order button text', WPOWP_TEXT_DOMAIN ); ?></th>
					<td>
						<input name="wpowp_order_button_text" class="regular-text"type="text" value="<?php echo esc_attr( $option['order_button_text'] ); ?>" />					
					</td>
				</tr>
				<tr>
					<th scope="row"><label
							for="wpowp_remove_shipping_adress"><?php esc_html_e( 'Remove shipping fields & rates', WPOWP_TEXT_DOMAIN ); ?></label>
					</th>
					<td>					
						<select class="regular-text wc-enhanced-select" name="wpowp_remove_shipping" >
							<option value="no" <?php echo ( false === filter_var( $option['remove_shipping'], FILTER_VALIDATE_BOOLEAN ) ) ? 'selected' : ''; ?>><?php esc_html_e( 'No', WPOWP_TEXT_DOMAIN ); ?></option>
							<option value="yes" <?php echo ( true === filter_var( $option['remove_shipping'], FILTER_VALIDATE_BOOLEAN ) ) ? 'selected' : ''; ?>><?php esc_html_e( 'Yes', WPOWP_TEXT_DOMAIN ); ?></option>
						</select>
					</td>
				</tr>			
				<tr>
					<th scope="row"><label
							for="wpowp_remove_shipping_adress"><?php esc_html_e( 'Remove Tax Rates', WPOWP_TEXT_DOMAIN ); ?></label>
					</th>
					<td>					
						<select class="regular-text wc-enhanced-select" name="wpowp_remove_taxes" >
							<option value="no" <?php echo ( false === filter_var( $option['remove_taxes'], FILTER_VALIDATE_BOOLEAN ) ) ? 'selected' : ''; ?>><?php esc_html_e( 'No', WPOWP_TEXT_DOMAIN ); ?></option>
							<option value="yes" <?php echo ( true === filter_var( $option['remove_taxes'], FILTER_VALIDATE_BOOLEAN ) ) ? 'selected' : ''; ?>><?php esc_html_e( 'Yes', WPOWP_TEXT_DOMAIN ); ?></option>
						</select>
					</td>
				</tr>
				<tr>
					<th scope="row"><label
							for="wpowp_remove_privacy_policy_text"><?php esc_html_e( 'Remove checkout privacy text', WPOWP_TEXT_DOMAIN ); ?></label>
					</th>
					<td>					
						<select class="regular-text wc-enhanced-select" name="wpowp_remove_privacy_policy_text">
							<option value="no" <?php echo ( false === filter_var( $option['remove_privacy_policy_text'], FILTER_VALIDATE_BOOLEAN ) ) ? 'selected' : ''; ?>><?php esc_html_e( 'No', WPOWP_TEXT_DOMAIN ); ?></option>
							<option value="yes" <?php echo ( true === filter_var( $option['remove_privacy_policy_text'], FILTER_VALIDATE_BOOLEAN ) ) ? 'selected' : ''; ?>><?php esc_html_e( 'Yes', WPOWP_TEXT_DOMAIN ); ?></option>
						</select>
					</td>
				</tr>
				<tr class="wpowp-admin-separator">
					<th scope="row"><label
							for="wpowp_remove_checkout_terms_conditions"><?php esc_html_e( 'Remove checkout terms and conditions', WPOWP_TEXT_DOMAIN ); ?></label>
					</th>
					<td>					
						<select class="regular-text wc-enhanced-select" name="wpowp_remove_checkout_terms_conditions">
							<option value="no" <?php echo ( false === filter_var( $option['remove_checkout_terms_conditions'], FILTER_VALIDATE_BOOLEAN ) ) ? 'selected' : ''; ?>><?php esc_html_e( 'No', WPOWP_TEXT_DOMAIN ); ?></option>
							<option value="yes" <?php echo ( true === filter_var( $option['remove_checkout_terms_conditions'], FILTER_VALIDATE_BOOLEAN ) ) ? 'selected' : ''; ?>><?php esc_html_e( 'Yes', WPOWP_TEXT_DOMAIN ); ?></option>
						</select>
					</td>
				</tr>
				<tr>
					<th scope="row"><?php esc_html_e( 'Free Product', WPOWP_TEXT_DOMAIN ); ?></th>
					<td>
						<fieldset>
							<legend class="screen-reader-text">
								<span>checkbox</span>
							</legend>
							<label for="wpowp_free_product">
								<input type="hidden" name="wpowp_free_product" value="no" />
								<input name="wpowp_free_product" type="checkbox" id="wpowp_free_product" value="yes" <?php echo ( true === filter_var( $option['free_product'], FILTER_VALIDATE_BOOLEAN ) ) ? 'checked' : ''; ?> />
							</label>
							<p><?php esc_html_e( '( For WooCommerce price label of $0.00, show custom text, such as the word “FREE”)', WPOWP_TEXT_DOMAIN ); ?></p>
						</fieldset>
					</td>
				</tr>
				<tr>
					<th scope="row"><?php esc_html_e( 'On Checkout', WPOWP_TEXT_DOMAIN ); ?></th>
					<td>
						<fieldset>
							<legend class="screen-reader-text">
								<span>checkbox</span>
							</legend>
							<label for="wpowp_free_product">
								<input type="hidden" name="wpowp_free_product_on_checkout" value="no" />
								<input name="wpowp_free_product_on_checkout" type="checkbox" id="wpowp_free_product_on_checkout" value="yes" <?php echo ( true === filter_var( $option['free_product_on_checkout'], FILTER_VALIDATE_BOOLEAN ) ) ? 'checked' : ''; ?> />
							</label>
							<p><?php esc_html_e( '( On Checkout page for WooCommerce price label of $0.00, show custom text, such as the word “FREE”)', WPOWP_TEXT_DOMAIN ); ?></p>
						</fieldset>
					</td>
				</tr>
				<tr>
					<th scope="row"><?php esc_html_e( 'On Cart', WPOWP_TEXT_DOMAIN ); ?></th>
					<td>
						<fieldset>
							<legend class="screen-reader-text">
								<span>checkbox</span>
							</legend>
							<label for="wpowp_free_product">
								<input type="hidden" name="wpowp_free_product_on_cart" value="no" />
								<input name="wpowp_free_product_on_cart" type="checkbox" id="wpowp_free_product_on_cart" value="yes" <?php echo ( true === filter_var( $option['free_product_on_cart'], FILTER_VALIDATE_BOOLEAN ) ) ? 'checked' : ''; ?> />
							</label>
							<p><?php esc_html_e( '( On Cart page for WooCommerce price label of $0.00, show custom text, such as the word “FREE”)', WPOWP_TEXT_DOMAIN ); ?></p>
						</fieldset>
					</td>
				</tr>
				<tr>
					<th scope="row"><?php esc_html_e( 'Free product text', WPOWP_TEXT_DOMAIN ); ?></th>
					<td>
						<input name="wpowp_free_product_text" class="regular-text"type="text" value="<?php echo esc_attr( $option['free_product_text'] ); ?>" />
					</td>
				</tr>
				<?php } ?>
			</tbody>
		</table>		
		<?php
		if ( $wpowp_fs->is_not_paying() ) {
			?>
									
			<table class="form-table wpowp-content-table" >
				<tbody>			
					<tr>
						<th scope="row"><?php esc_html_e( 'Available in PRO Version', WPOWP_TEXT_DOMAIN ); ?></th>
						<td>
							<p><?php esc_html_e( 'Features listed below are Available in PRO version only ', WPOWP_TEXT_DOMAIN ); ?></p>
							<p>
								<a href="<?php echo esc_url( $wpowp_fs->get_upgrade_url() ); ?>" class="button button-primary" target="_blank">
									<?php esc_html_e( 'Upgrade to Pro', WPOWP_TEXT_DOMAIN ); ?>
								</a>
							</p>	
						</td>
					</tr>
					<tr class="wpowp-admin-separator-1">
						<th scope="row"><?php esc_html_e( 'Add to cart text', WPOWP_TEXT_DOMAIN ); ?></th>
						<td>
							<input disabled class="regular-text"type="text" value="<?php echo esc_attr( $option['add_cart_text'] ); ?>" />
						</td>
					</tr>
					<tr class="wpowp-admin-separator">
						<th scope="row"><?php esc_html_e( 'Order button text', WPOWP_TEXT_DOMAIN ); ?></th>
						<td>
							<input disabled class="regular-text"type="text" value="<?php echo esc_attr( $option['order_button_text'] ); ?>" />					
						</td>
					</tr>
					<tr>
						<th scope="row"><label
								for="wpowp_remove_shipping_adress"><?php esc_html_e( 'Remove shipping fields & rates', WPOWP_TEXT_DOMAIN ); ?></label>
						</th>
						<td>					
							<select class="regular-text wc-enhanced-select" disabled>
								<option><?php esc_html_e( 'No', WPOWP_TEXT_DOMAIN ); ?></option>
								<option><?php esc_html_e( 'Yes', WPOWP_TEXT_DOMAIN ); ?></option>
							</select>
						</td>
					</tr>
					<tr>
						<th scope="row"><label
								for="wpowp_remove_taxes"><?php esc_html_e( 'Remove Tax Rates', WPOWP_TEXT_DOMAIN ); ?></label>
						</th>
						<td>					
							<select class="regular-text wc-enhanced-select" disabled>
								<option><?php esc_html_e( 'No', WPOWP_TEXT_DOMAIN ); ?></option>
								<option><?php esc_html_e( 'Yes', WPOWP_TEXT_DOMAIN ); ?></option>
							</select>
						</td>
					</tr>
					<tr>
						<th scope="row"><label
								for="wpowp_remove_privacy_policy_text"><?php esc_html_e( 'Remove checkout privacy text', WPOWP_TEXT_DOMAIN ); ?></label>
						</th>
						<td>					
							<select class="regular-text wc-enhanced-select" disabled>
								<option><?php esc_html_e( 'No', WPOWP_TEXT_DOMAIN ); ?></option>
								<option><?php esc_html_e( 'Yes', WPOWP_TEXT_DOMAIN ); ?></option>
							</select>
						</td>
					</tr>
					<tr class="wpowp-admin-separator">
						<th scope="row"><label
								for="wpowp_remove_checkout_terms_conditions"><?php esc_html_e( 'Remove checkout terms and conditions', WPOWP_TEXT_DOMAIN ); ?></label>
						</th>
						<td>					
							<select class="regular-text wc-enhanced-select" disabled>
								<option><?php esc_html_e( 'No', WPOWP_TEXT_DOMAIN ); ?></option>
								<option><?php esc_html_e( 'Yes', WPOWP_TEXT_DOMAIN ); ?></option>
							</select>
						</td>
					</tr>
					<tr>
						<th scope="row"><?php esc_html_e( 'Free Product', WPOWP_TEXT_DOMAIN ); ?></th>
						<td>
							<fieldset>
								<legend class="screen-reader-text">
									<span>checkbox</span>
								</legend>
								<label for="wpowp_status">
									<input disabled name="" type="checkbox" id="" value="yes"  <?php echo ( true === filter_var( $option['free_product'], FILTER_VALIDATE_BOOLEAN ) ) ? 'checked' : ''; ?> />
								</label>
								<p><?php esc_html_e( '( For WooCommerce price label of $0.00, show custom text, such as the word “FREE”)', WPOWP_TEXT_DOMAIN ); ?></p>
							</fieldset>
						</td>
					</tr>
					<tr>
						<th scope="row"><?php esc_html_e( 'On Checkout', WPOWP_TEXT_DOMAIN ); ?></th>
						<td>
							<fieldset>
								<legend class="screen-reader-text">
									<span>checkbox</span>
								</legend>
								<label for="wpowp_status">
									<input disabled name="" type="checkbox" id="" value="yes"  <?php echo ( true === filter_var( $option['free_product'], FILTER_VALIDATE_BOOLEAN ) ) ? 'checked' : ''; ?> />
								</label>
								<p><?php esc_html_e( '( On Checkout page for WooCommerce price label of $0.00, show custom text, such as the word “FREE”)', WPOWP_TEXT_DOMAIN ); ?></p>
							</fieldset>
						</td>
					</tr>
					<tr>
						<th scope="row"><?php esc_html_e( 'On Cart', WPOWP_TEXT_DOMAIN ); ?></th>
						<td>
							<fieldset>
								<legend class="screen-reader-text">
									<span>checkbox</span>
								</legend>
								<label for="wpowp_status">
									<input disabled name="" type="checkbox" id="" value="yes"  <?php echo ( true === filter_var( $option['free_product'], FILTER_VALIDATE_BOOLEAN ) ) ? 'checked' : ''; ?> />
								</label>
								<p><?php esc_html_e( '( On cart page for WooCommerce price label of $0.00, show custom text, such as the word “FREE”)', WPOWP_TEXT_DOMAIN ); ?></p>
							</fieldset>
						</td>
					</tr>
					<tr>
						<th scope="row"><?php esc_html_e( 'Free product text', WPOWP_TEXT_DOMAIN ); ?></th>
						<td>
							<input disabled name="" class="regular-text"type="text" value="<?php echo esc_attr( $option['free_product_text'] ); ?>" />
						</td>
					</tr>
				</tbody>
			</table>				
		<?php } ?>
		<div class="submit">
			<input type="submit" name="<?php echo esc_attr( WPOWP_PLUGIN_PREFIX ); ?>settings-submit" id="<?php echo esc_attr( WPOWP_PLUGIN_PREFIX ); ?>settings-submit" class="button button-primary"
				value="<?php esc_attr_e( 'Save Changes', WPOWP_TEXT_DOMAIN ); ?>" />
			<input type="button" name="<?php echo esc_attr( WPOWP_PLUGIN_PREFIX ); ?>settings-reset" id="<?php echo esc_attr( WPOWP_PLUGIN_PREFIX ); ?>settings-reset" class="button button-secondary"
				value="<?php esc_attr_e( 'Reset Settings', WPOWP_TEXT_DOMAIN ); ?>">	
			<p><?php esc_html_e( 'Note: Resetting settings will delete all configurations, so use this feature wisely.', WPOWP_TEXT_DOMAIN ); ?></p>
		</div>
	</form>
</div>
