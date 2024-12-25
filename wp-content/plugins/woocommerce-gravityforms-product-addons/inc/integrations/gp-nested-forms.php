<?php

add_filter( 'woocommerce_gravityforms_order_entry', 'wc_gfpa_update_nested_entry_field_values', 5, 5 );

function wc_gfpa_update_nested_entry_field_values( $entry, $entry_id, $form, $lead_data ) {
	if ( ! $form ) {
		return $entry;
	}

	$parent_entry_form_fields = $form['fields'] ?? array();
	$has_changes              = false;
	foreach ( $parent_entry_form_fields as $field ) {
		if ( $field->type != 'form' ) {
			continue;
		}
		$has_changes         = true;
		$entry[ $field->id ] = $lead_data[ $field->id ] ?? null;
	}

	if ( $has_changes ) {
		GFAPI::update_entry( $entry );
	}

	return $entry;
}
