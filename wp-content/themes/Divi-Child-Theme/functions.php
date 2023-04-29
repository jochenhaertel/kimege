<?php
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
}

// Must use all three filters for this to work properly. 
add_filter( 'ninja_forms_admin_parent_menu_capabilities',   'nf_subs_capabilities' ); // Parent Menu
add_filter( 'ninja_forms_admin_all_forms_capabilities',     'nf_subs_capabilities' ); // Forms Submenu
add_filter( 'ninja_forms_admin_submissions_capabilities',   'nf_subs_capabilities' ); // Submissions Submenu

function nf_subs_capabilities( $cap ) {
    return 'edit_posts'; // EDIT: User Capability
}

/**
 * Filter hook used in the API route permission callback to retrieve submissions
 *
 * return bool as for authorized or not.
 */
add_filter( 'ninja_forms_api_allow_get_submissions', 'nf_define_permission_level', 10, 2 );
add_filter( 'ninja_forms_api_allow_delete_submissions', 'nf_define_permission_level', 10, 2 );
add_filter( 'ninja_forms_api_allow_update_submission', 'nf_define_permission_level', 10, 2 );
add_filter( 'ninja_forms_api_allow_handle_extra_submission', 'nf_define_permission_level', 10, 2 );
add_filter( 'ninja_forms_api_allow_email_action', 'nf_define_permission_level', 10, 2 );

function nf_define_permission_level() {
  
  $allowed = \current_user_can("delete_others_posts");
  
  return $allowed;
}