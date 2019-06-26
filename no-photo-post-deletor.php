<?php
defined('ABSPATH') or die("Silence is golden");
/*
Plugin Name: No Photo Post Deletor
Description: Elimina automaticamente todos los posts que no contengan foto destacada.
Version: 0.0.1 - 9330c6c
Author: PecceG2
*/

//Updater
require 'assets/libraries/PUC-4.6/plugin-update-checker.php';
$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
	'https://pecceg2.com/development/wordpress-plugins/no-photo-post-deletor/updater.json',
	__FILE__,
	'no-photo-post-deletor-pg2'
);

// Event  Hooks
register_activation_hook(__FILE__, 'onInstallPlugin');
register_deactivation_hook(__FILE__, 'onUninstallPlugin');

// Hooks
add_action('NoPhotoPostDeletorCronJob', 'onCronPerHour');
add_action( 'wp_insert_post', 'onPostCreate', 10, 3);

// Functions/Events
function onInstallPlugin() {
    if (! wp_next_scheduled ('NoPhotoPostDeletorCronJob' )){
	wp_schedule_event(time(), 'hourly', 'NoPhotoPostDeletorCronJob');
    }
}

function onUninstallPlugin() {
	wp_clear_scheduled_hook('NoPhotoPostDeletorCronJob');
}

function onCronPerHour() {
	
}

function onPostCreate($id_post, $obj_post, $update){
	if(wp_is_post_revision($id_post) || !$obj_post)
		return;
	$post_url = get_permalink($id_post);
	$post_thumbnail_id = get_post_thumbnail_id($obj_post);
	wp_mail('demo@example.com', "[HOOK] Nuevo post", $post->post_title." en la URL: ".$post_url." | Con la imagen ID: ".$post_thumbnail_id);
}
?>