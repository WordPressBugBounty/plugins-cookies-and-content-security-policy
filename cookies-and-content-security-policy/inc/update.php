<?php
// Update 

$installed_version = get_option( 'cacsp_db_version' );
$installed_version = $installed_version ? $installed_version : '0.991';
$needs_db_version_update = false;

if ( version_compare( $installed_version, '2.27', '<' ) ) {
    cacsp_save_error_message_js();
    $needs_db_version_update = true;
}

if ( version_compare( $installed_version, '2.35', '<' ) ) {
    delete_option( 'cacsp_option_settings_admin_email' );
    delete_option( 'cacsp_version' );
    $needs_db_version_update = true;
}

if ( version_compare( $installed_version, '2.37', '<' ) ) {
    update_option( 'cacsp_option_blob', true );
	update_option( 'cacsp_option_data', true );
    $needs_db_version_update = true;
}

if ( $needs_db_version_update ) {
    $current_version = cacsp_get_plugin_version();
    update_option( 'cacsp_db_version', $current_version, true );
}
