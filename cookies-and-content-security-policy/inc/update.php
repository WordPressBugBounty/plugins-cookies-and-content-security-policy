<?php
// Update 

function cacsp_migrate_option_key( $old_key, $new_key ) {
    $old_value = get_option( $old_key, null );
    $new_value = get_option( $new_key, null );

    if ( null !== $old_value && null === $new_value ) {
        update_option( $new_key, $old_value );
    }
}

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

if ( version_compare( $installed_version, '2.40', '<' ) ) {
    cacsp_migrate_option_key( 'cacsp_option_markerting_scripts', 'cacsp_option_marketing_scripts' );
    cacsp_migrate_option_key( 'cacsp_option_markerting_images', 'cacsp_option_marketing_images' );
    cacsp_migrate_option_key( 'cacsp_option_markerting_frames', 'cacsp_option_marketing_frames' );
    cacsp_migrate_option_key( 'cacsp_option_markerting_forms', 'cacsp_option_marketing_forms' );
    cacsp_migrate_option_key( 'cacsp_option_markerting_worker', 'cacsp_option_marketing_worker' );
    $needs_db_version_update = true;
}

if ( version_compare( $installed_version, '2.41', '<' ) ) {
    $cacsp_old_options = array(
        'cacsp_option_markerting_scripts', 
        'cacsp_option_markerting_images', 
        'cacsp_option_markerting_frames', 
        'cacsp_option_markerting_forms', 
        'cacsp_option_markerting_worker', 
    );
    foreach ( $cacsp_old_options as $cacsp_old_option ) {
        delete_option( $cacsp_old_option );
        delete_site_option( $cacsp_old_option );
    }
    $needs_db_version_update = true;
}

if ( $needs_db_version_update ) {
    $current_version = cacsp_get_plugin_version();
    update_option( 'cacsp_db_version', $current_version, true );
}
