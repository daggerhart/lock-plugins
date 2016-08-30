<?php
/*
 * Plugin Name:     Lock plugin updates
 * Description:     Prevent plugin updates
 * Version:         1.0.0
 * Author:          daggerhart
 */

add_filter( 'http_request_args', 'lock_plugins_http_request_args', 5, 2 );

/**
 * Prevent lookup of certain plugin updates
 * Source: https://markjaquith.wordpress.com/2009/12/14/excluding-your-plugin-or-theme-from-update-checks/
 *
 * @param $request
 * @param $url
 *
 * @return mixed
 */
function lock_plugins_http_request_args( $request, $url ) {
	if ( FALSE === strpos( $url, '//api.wordpress.org/plugins/update-check' ) ) {
		return $request; // Not a plugin update request. Bail immediately.
	}

	if ( empty($request['body']['plugins']) ){
		return $request;
	}

	$plugins = json_decode( $request['body']['plugins'], true );

	// get a list of locked plugins from somewhere
	$locked_plugins = apply_filters('lock_plugins-locked_plugins', array());

	foreach( $locked_plugins as $locked_plugin_basename )
	{
		$active_index = array_search( $locked_plugin_basename, $plugins['active'] );
		unset( $plugins['active'][ $active_index ] );
		unset( $plugins['plugins'][ $locked_plugin_basename ] );
	}

	$request['body']['plugins'] = wp_json_encode( $plugins );
	return $request;
}
