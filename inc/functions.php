<?php

/**
 * Generates a Photon URL.
 *
 * @see http://developer.wordpress.com/docs/photon/
 *
 * @param string $image_url URL to the publicly accessible image you want to manipulate
 * @param array|string $args An array of arguments, i.e. array( 'w' => '300', 'resize' => array( 123, 456 ) ), or in string form (w=123&h=456)
 * @return string The raw final URL. You should run this through esc_url() before displaying it.
 */
function my_photon_url( $image_url, $args = array(), $scheme = null ) {
	$image_url = trim( $image_url );

	$image_url = apply_filters( 'my_photon_pre_image_url', $image_url, $args,      $scheme );
	$args      = apply_filters( 'my_photon_pre_args',      $args,      $image_url, $scheme );

	if ( empty( $image_url ) )
		return $image_url;

	$image_url_parts = @parse_url( $image_url );

	// Unable to parse
	if ( ! is_array( $image_url_parts ) || empty( $image_url_parts['host'] ) || empty( $image_url_parts['path'] ) )
		return $image_url;

	if ( is_array( $args ) ){
		// Convert values that are arrays into strings
		foreach ( $args as $arg => $value ) {
			if ( is_array( $value ) ) {
				$args[$arg] = implode( ',', $value );
			}
		}

		// Encode values
		// See http://core.trac.wordpress.org/ticket/17923
		$args = rawurlencode_deep( $args );
	}

	// You can't run a Photon URL through Photon again because query strings are stripped.
	// So if the image is already a Photon URL, append the new arguments to the existing URL.
	if ( false !== strpos( My_Photon_Settings::get( 'base-url' ), $image_url_parts['host'] ) ) {
		$photon_url = add_query_arg( $args, $image_url );

		return my_photon_url_scheme( $photon_url, $scheme );
	}

	// This setting is Photon Server dependent
	if ( ! apply_filters( 'my_photon_any_extension_for_domain', false, $image_url_parts['host'] ) ) {
		// Photon doesn't support query strings so we ignore them and look only at the path.
		// However some source images are served via PHP so check the no-query-string extension.
		// For future proofing, this is a blacklist of common issues rather than a whitelist.
		$extension = pathinfo( $image_url_parts['path'], PATHINFO_EXTENSION );
		if ( empty( $extension ) || in_array( $extension, array( 'php' ) ) )
			return $image_url;
	}

	$image_host_path = $image_url_parts['host'] . $image_url_parts['path'];

	$photon_url  = My_Photon_Settings::get( 'base-url' ) . $image_host_path;

	// This setting is Photon Server dependent
	if ( isset( $image_url_parts['query'] ) && apply_filters( 'my_photon_add_query_string_to_domain', false, $image_url_parts['host'] ) ) {
		$photon_url .= '?q=' . rawurlencode( $image_url_parts['query'] );
	}

	if ( $args ) {
		if ( is_array( $args ) ) {
			$photon_url = add_query_arg( $args, $photon_url );
		} else {
			// You can pass a query string for complicated requests but where you still want CDN subdomain help, etc.
			$photon_url .= '?' . $args;
		}
	}

	return my_photon_url_scheme( $photon_url, $scheme );
}
add_filter( 'my_photon_url', 'my_photon_url', 10, 3 );


function my_photon_url_scheme( $url, $scheme ) {
	if ( ! in_array( $scheme, array( 'http', 'https', 'network_path' ) ) ) {
		$scheme = is_ssl() ? 'https' : 'http';
	}

	if ( 'network_path' == $scheme ) {
		$scheme_slashes = '//';
	} else {
		$scheme_slashes = "$scheme://";
	}

	return preg_replace( '#^[a-z:]+//#i', $scheme_slashes, $url );
}