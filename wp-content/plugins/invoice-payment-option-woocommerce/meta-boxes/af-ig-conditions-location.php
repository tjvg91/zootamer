<?php
/**
 * Invoice-payment Conditions
 *
 * Displays the meta box for invoice-paymet conditions cart, location, user, shipping etc.
 *
 * @package  addify-invoice-gateway/meta-boxes
 * @version  1.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Get Post Meta.
$sel_countries = json_decode( get_post_meta( get_the_ID(), 'af_ig_countries', true ) );
$sel_states    = json_decode( get_post_meta( get_the_ID(), 'af_ig_states', true ) );
$sel_zips      = get_post_meta( get_the_ID(), 'af_ig_zip_codes', true );
$sel_cities    = get_post_meta( get_the_ID(), 'af_ig_cities', true );

// variable values check.
$sel_countries = is_array( $sel_countries ) ? $sel_countries : array();
$sel_states    = is_array( $sel_states ) ? $sel_states : array();
// General Variables.
$countires = WC()->countries->get_countries();
?>

<div class="extra-fee-conditions">
	<?php wp_nonce_field( 'af_ig_nonce_action', 'af_ig_field_nonce' ); ?>
	<table class="addify-table-optoin">
		<tr class="addify-option-field">
			<th>
				<div class="option-head">
					<h3>
						<?php echo esc_html__( 'Select Countries', 'af_ig_td' ); ?>
					</h3>
				</div>
			</th>
			<td>
				<select name="af_ig_countries[]" id="af_ig_countries" class="af-ig-select2" multiple>
					<?php foreach ( $countires as $key => $value ) : ?>
							<option value="<?php echo esc_attr( $key ); ?>" 
						<?php echo in_array( (string) $key, $sel_countries, true ) ? 'selected' : ''; ?>
							>
						<?php echo esc_attr( $value ); ?>
							</option>
					<?php endforeach; ?>
				</select>
				<p><?php echo esc_html__( 'Choose countries. Leave it empty for all countries.', 'af_ig_td' ); ?></p>
			</td>
		</tr>
		<tr class="addify-option-field">
			<th>
				<div class="option-head">
					<h3>
						<?php echo esc_html__( 'Select States', 'af_ig_td' ); ?>
					</h3>
				</div>
			</th>
			<td>
				<select name="af_ig_states[]" id="af_ig_states" class="af-ig-select2" multiple>
					<?php

					foreach ( $countires as $key => $val ) {
						$states = WC()->countries->get_states( $key );
						if ( empty( $states ) ) {
							continue;
						} else {
							echo '<optgroup label="' . esc_attr( $val ) . '">';
							foreach ( $states as $key1 => $value ) {

									$state_val = esc_attr( $key ) . ':' . esc_attr( $key1 );
								?>
									<option value="<?php echo esc_attr( $state_val ); ?>"
								<?php echo in_array( (string) $state_val, $sel_states, true ) ? 'selected' : ''; ?>
									>
								<?php echo esc_attr( $val ) . ' &mdash; ' . esc_attr( $value ); ?>
									</option>
								<?php
							}
							echo '</optgroup>';
						}
					}
					?>
				</select>
				<p><?php echo esc_html__( 'Select states. Leave empty for all states.', 'af_ig_td' ); ?></p>
			</td>
		</tr>
		<tr class="addify-option-field">
			<th>
				<div class="option-head">
					<h3>
						<?php echo esc_html__( 'Enter Cities', 'af_ig_td' ); ?>
					</h3>
				</div>
			</th>
			<td>
				<textarea name="af_ig_cities" id="af_ig_cities" cols="45" rows="5"><?php echo esc_attr( $sel_cities ); ?></textarea>
				<p><?php echo esc_html__( 'Enter Cities. Leave it empty for all cities', 'af_ig_td' ); ?></p>
				<p><?php echo esc_html__( 'Insert all cities separated by comma(,). e.g. New York, Rawalpindi, Lahore etc', 'af_ig_td' ); ?></p>
			</td>
		</tr>
		<tr class="addify-option-field">
			<th>
				<div class="option-head">
					<h3>
						<?php echo esc_html__( 'Enter Zip Codes', 'af_ig_td' ); ?>
					</h3>
				</div>
			</th>
			<td>
				<textarea name="af_ig_zip_codes" id="af_ig_zip_codes" cols="45" rows="5"><?php echo esc_attr( $sel_zips ); ?></textarea>
				<p><?php echo esc_html__( 'Enter ZIP codes. Leave it empty for all ZIP codes.', 'af_ig_td' ); ?></p>
				<p><?php echo esc_html__( 'Insert all ZIP codes separated by comma(,). e.g. 45000,46000,47000 etc', 'af_ig_td' ); ?></p>
				<p><?php echo esc_html__( 'For range of ZIP codes use hyphen(-). e.g. 45000-46000', 'af_ig_td' ); ?></p>
			</td>
		</tr>        
	</table>
</div>
