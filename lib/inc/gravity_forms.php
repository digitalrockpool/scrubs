<?php

/* Includes: Gravity Forms

@package	Scrubs Cornwall
@author		Digital Rockpool
@link		https://cornwallscrubs.co.uk
@copyright	Copyright (c) Digital Rockpool LTD 2020.
@license	GPL-2.0+ */

add_action( 'gform_user_registered', 'add_volunteer_region', 10, 4 );
function add_volunteer_region( $user_id, $feed, $entry, $password ) {
	
	global $wpdb;
	
	$form_id = rgar( $feed, 'form_id' );
	$user = get_userdata( $user_id );
	$entry_date = date( 'Y-m-d H:i:s' );
	
	if( $form_id == 1 || $form_id == 8 ) : /* user registration form */
	
		$user_login = $user->user_login;
		$user_password = $password;
		$user_phone = $user->phone; 
		$user_roles = $user->roles;
		$user_business = $user->business_name; 
		$user_role_array = array_keys($user_roles);
		$user_role = $user_roles[$user_role_array[0]];
		
		wp_signon(
			array(
				'user_login' => $user_login,
				'user_password' =>  $user_password,
				'remember' => false
			)
		);
	
		if( $user_role == 'volunteer' ) :
	
			$wpdb->insert( 'volunteer_region',
				array(
					'user_id' => $user->ID,
					'user_role' => 'Volunteer',
					'regional_group' => 'Unassigned',
					'team' => 'Unassigned',
					'active' => -2, /* volunteer form has not been completed */
					)
			);
	
		endif;
	
		if( empty( $user_phone ) ) :
	
			$wpdb->insert( 'wp_usermeta',
				array(
					'user_id' => $user->ID,
					'meta_key' => 'phone',
					'meta_value' => 'Not Provided',
					)
			);
	
		endif;
	
	endif;
		
}

// SCRUBS REQUEST
add_action( 'gform_after_submission_5', 'submit_scrub_request', 10, 2 );
function submit_scrub_request( $entry, $form ) {
	
  	global $wpdb;
	
	$entry_date = date( 'Y-m-d H:i:s' );
	$business_name = $entry[13];
	$business_type = $entry[14];
	$business_other_entry = $entry[15];
	$item = $entry[2];
	$quantity = $entry[7];
	$collect  = $entry[12];
    $requested_by = get_current_user_id();
	
	if( !empty( $business_other_entry ) ) : $business_other = ' - '.$business_other_entry; endif;
	if( $business_type == 'Hospital' ) : $colour = $entry[3]; else : $colour = $entry[18]; endif;
	if( $item == 'Full Scrubs' ) : $size = $entry[6]; else : $size = $entry[20]; endif;
	
	$wpdb->insert( 'scrub_log',
		array(
			'entry_date' => $entry_date,
			'business_name' => $business_name,
			'business_type' => $business_type.$business_other,
			'item' => $item,
			'colour' => $colour,
			'size' => $size,
			'quantity' => $quantity,
		  	'collect' => $collect,
		  	'requested_by' => $requested_by,
			'scrub_status' => 'Pending',
		  	'customer_notes' => NULL,
			'expected_date' => NULL,
		  	'accepted_id' => NULL,
		  	'scrub_notes' => NULL
		)
	);
}

// SCRUBS STOCK
add_action( 'gform_after_submission_6', 'submit_scrub_stock', 10, 2 );
function submit_scrub_stock( $entry, $form ) {
	
  	global $wpdb;
	
	$entry_date = date( 'Y-m-d H:i:s' );
	$team_name_entry = $entry[13];
	$item = $entry[2];
	$colour = $entry[3];
	$size = $entry[6];
	$one_size = $entry[15];
	$quantity = $entry[7];
	$status  = $entry[8];
    $accepted_id = get_current_user_id();
	$scrub_notes_entry = $entry[14];
	
	if( empty( $team_name_entry ) ) : $team_name = NULL; else :  $team_name = $team_name_entry; endif;
	if( empty( $scrub_notes_entry ) ) : $scrub_notes = NULL; else :  $scrub_notes = $scrub_notes_entry; endif;
	
	$wpdb->insert( 'scrub_log',
		array(
			'entry_date' => $entry_date,
			'business_name' => $team_name,
			'business_type' => NULL, 
			'item' => $item,
			'colour' => $colour,
			'size' => $size.$one_size,
			'quantity' => $quantity,
		  	'collect' => NULL,
		  	'requested_by' => NULL,
			'scrub_status' => $status,
		  	'customer_notes' => NULL,
			'expected_date' => NULL,
		  	'accepted_id' => $accepted_id,
		  	'scrub_notes' => $scrub_notes
		)
	);
}


add_filter( 'gform_pre_render_6', 'populate_team_name' );
add_filter( 'gform_admin_pre_render_6', 'populate_team_name' );
function populate_team_name( $form ) {
	
	global $wpdb;

	$results = $wpdb->get_results( "SELECT team FROM volunteer_region GROUP BY team ORDER BY team ASC" );

	foreach( $results as $rows ) :
		$choices[] = array( 'text' => $rows->team, 'value' => $rows->team );
	endforeach;

	foreach( $form['fields'] as &$field ) :
		if( $field['id'] == 13 ) :
			$field['placeholder'] = 'Select Team Name';
			$field['choices'] = $choices;
		endif;
	endforeach;

	return $form;
}


add_filter( 'gform_field_value', 'dynamic_population', 10, 3 );
function dynamic_population( $value, $field, $name ) {
	
	global $wpdb;
	
	$user_id = get_current_user_id();
	$team = $_SESSION['team'];
	
	$volunteers = $wpdb->get_row( "SELECT distance, machinery_loan, sewist_level, buy_fabric, budget, extra FROM volunteer_log WHERE ID=$user_id" );

	$coordinator_ids = $wpdb->get_row( "SELECT user_id, user_role FROM volunteer_region WHERE team='$team' AND user_role='Regional Coordinator'" );
	$coordinator_id = $coordinator_ids->user_id;

	$coordinator_details = $wpdb->get_row( "SELECT display_name, user_email, meta_value FROM wp_users LEFT JOIN wp_usermeta ON wp_users.id=wp_usermeta.user_id WHERE meta_key='phone' AND ID=$coordinator_id" );
	$rc_name = $coordinator_details->display_name;
	$rc_email = $coordinator_details->user_email;
	$rc_phone = $coordinator_details->meta_value;
	
	if( empty( $rc_name ) ) :
	   $regional_coordinator = 'Unassigned';
	  
	 else:
	   $regional_coordinator = $rc_name.': '.$rc_email.' | '.$rc_phone;
	   
	endif;
	
	$metadata = get_user_meta ($user_id);
	$business_name = $metadata['business_name'][0];
	$business_type = $metadata['business_type'][0];
	$business_other = $metadata['business_other'][0];

	$values = array(
		'business_name' => $business_name,
		'business_type' => $business_type,
		'business_other' => $business_other,
		'active' => $_SESSION['active'],
		'user_role' => $_SESSION['volunteer_role'],
		'regional_group' => $_SESSION['regional_group'],
		'team' => $team,
		'regional_coordinator' => $regional_coordinator,
		'distance' => $volunteers->distance,
		'machinery_loan' => $volunteers->machinery_loan,
		'sewist_level' => $volunteers->sewist_level,
		'buy_fabric' => $volunteers->buy_fabric,
		'budget' => $volunteers->budget,
		'extra' => $volunteers->extra
	);

	return isset( $values[ $name ] ) ? $values[ $name ] : $value;
}


add_filter( 'gform_pre_render_3', 'my_populate_checkbox' );
function my_populate_checkbox( $form ) {
	
	global $wpdb;
	
	$user_id = get_current_user_id();
	
	$volunteers = $wpdb->get_row( "SELECT * FROM volunteer_log WHERE ID=$user_id" );
	$admin = $volunteers->admin;
	$delivery = $volunteers->delivering;
	$cutting = $volunteers->cutting;
	$sourcing = $volunteers->sourcing;
	$machinery = $volunteers->machinery;
	$ironing = $volunteers->ironing;
	$overlocking = $volunteers->overlocking;
	$printing = $volunteers->printing;
	$sewing = $volunteers->sewing;
	$coordination = $volunteers->coordination; 
	$scrubs = $volunteers->scrubs; 
	$scrub_hats = $volunteers->scrub_hats; 
	$bags = $volunteers->bags; 
	$fabric = $volunteers->fabric; 
	$pattern = $volunteers->pattern; 
	
	foreach( $form['fields'] as &$field ) :
	
		if( 14 === $field->id ) :
			foreach( $field->choices as &$choice ) :

				if( $admin === $choice['value'] ) : $choice['isSelected'] = true; endif;
				if( $delivery === $choice['value'] ) : $choice['isSelected'] = true; endif;
				if( $cutting === $choice['value'] ) : $choice['isSelected'] = true; endif;
				if( $sourcing === $choice['value'] ) : $choice['isSelected'] = true; endif;
				if( $machinery === $choice['value'] ) : $choice['isSelected'] = true; endif;
				if( $ironing === $choice['value'] ) : $choice['isSelected'] = true; endif;
				if( $overlocking === $choice['value'] ) : $choice['isSelected'] = true; endif;
				if( $printing === $choice['value'] ) : $choice['isSelected'] = true; endif;
				if( $sewing === $choice['value'] ) : $choice['isSelected'] = true; endif;
				if( $coordination === $choice['value'] ) : $choice['isSelected'] = true; endif;
	
		  endforeach;
    	endif;
	
		if( 17 === $field->id ) :
			foreach( $field->choices as &$choice ) :

				if( $scrubs === $choice['value'] ) : $choice['isSelected'] = true; endif;
				if( $scrub_hats === $choice['value'] ) : $choice['isSelected'] = true; endif;
				if( $bags === $choice['value'] ) : $choice['isSelected'] = true; endif;
	
		  endforeach;
    	endif;
	
		if( 25 === $field->id ) :
			foreach( $field->choices as &$choice ) :
	
				if( $fabric === $choice['value'] ) : $choice['isSelected'] = true; endif;
				if( $pattern === $choice['value'] ) : $choice['isSelected'] = true; endif;
	
		  endforeach;
    	endif;
	
	endforeach; 
  
  return $form;

}