<?php

/*
	Plugin Name: My Photon
	Plugin URI: http://www.alleyinteractive.com/
	Description: Integrate a self-hosted version of Photon with your WordPress site.
	Version: 0.1
	Author: Matthew Boynes
	Author URI: http://www.alleyinteractive.com/
*/
/*  The following code is a derivative work of code from the Automattic
    plugin Jetpack, which is licensed GPLv2. This code therefore is also
    licensed under the terms of the GNU Public License, verison 2.

    This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation; either version 2 of the License, or
	(at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

define( 'MY_PHOTON_PATH', dirname( __FILE__ ) );
define( 'MY_PHOTON_URL', trailingslashit( plugins_url( '', __FILE__ ) ) );

require_once MY_PHOTON_PATH . '/inc/class-my-photon-settings.php';

if ( My_Photon_Settings::get( 'active' ) ) {
	require_once MY_PHOTON_PATH . '/inc/functions.php';

	require_once MY_PHOTON_PATH . '/inc/class-my-photon.php';
}
