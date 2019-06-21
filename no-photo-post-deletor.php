<?php
defined('ABSPATH') or die("Silence is golden");
/*
Plugin Name: No Photo Post Deletor
Description: Elimina automaticamente todos los posts que no contengan foto destacada.
Version: 0.0.1 - 1503902
Author: PecceG2
*/


// Event Hooks
register_activation_hook(__FILE__, 'onInstallPlugin');
register_deactivation_hook(__FILE__, 'onUninstallPlugin');

// Hooks
add_action('NoPhotoPostDeletorCronJob', 'onCronPerHour');

// Functions/Events
function onInstallPlugin() {
    if (! wp_next_scheduled ('NoPhotoPostDeletorCronJob' )){
	wp_schedule_event(time(), 'hourly', 'NoPhotoPostDeletorCronJob');
    }
}
function onCronPerHour() {
	error_log('Ejecutado! : '.Date("h:i:sa"));
}
function onUninstallPlugin() {
	wp_clear_scheduled_hook('NoPhotoPostDeletorCronJob');
}
?>