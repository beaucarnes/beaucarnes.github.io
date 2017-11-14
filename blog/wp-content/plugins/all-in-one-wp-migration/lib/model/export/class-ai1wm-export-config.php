<?php
/**
 * Copyright (C) 2014-2017 ServMask Inc.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * ███████╗███████╗██████╗ ██╗   ██╗███╗   ███╗ █████╗ ███████╗██╗  ██╗
 * ██╔════╝██╔════╝██╔══██╗██║   ██║████╗ ████║██╔══██╗██╔════╝██║ ██╔╝
 * ███████╗█████╗  ██████╔╝██║   ██║██╔████╔██║███████║███████╗█████╔╝
 * ╚════██║██╔══╝  ██╔══██╗╚██╗ ██╔╝██║╚██╔╝██║██╔══██║╚════██║██╔═██╗
 * ███████║███████╗██║  ██║ ╚████╔╝ ██║ ╚═╝ ██║██║  ██║███████║██║  ██╗
 * ╚══════╝╚══════╝╚═╝  ╚═╝  ╚═══╝  ╚═╝     ╚═╝╚═╝  ╚═╝╚══════╝╚═╝  ╚═╝
 */

class Ai1wm_Export_Config {

	public static function execute( $params ) {
		global $wp_version, $wpdb;

		// Set progress
		Ai1wm_Status::info( __( 'Adding configuration to archive...', AI1WM_PLUGIN_NAME ) );

		// Flush WP cache
		ai1wm_cache_flush();

		// Get options
		$options = wp_load_alloptions();

		// Set config
		$config = array();

		// Get database client
		if ( empty( $wpdb->use_mysqli ) ) {
			$mysql = new Ai1wm_Database_Mysql( $wpdb );
		} else {
			$mysql = new Ai1wm_Database_Mysqli( $wpdb );
		}

		// Set site URL
		$config['SiteURL'] = site_url();

		// Set home URL
		$config['HomeURL'] = home_url();

		// Set internal site URL
		if ( isset( $options['siteurl'] ) && ( untrailingslashit( $options['siteurl'] ) !== site_url() ) ) {
			$config['InternalSiteURL'] = untrailingslashit( $options['siteurl'] );
		}

		// Set internal home URL
		if ( isset( $options['home'] ) && ( untrailingslashit( $options['home'] ) !== home_url() ) ) {
			$config['InternalHomeURL'] = untrailingslashit( $options['home'] );
		}

		// Set replace old and new values
		if ( isset( $params['options']['replace'] ) && ( $replace = $params['options']['replace'] ) ) {
			for ( $i = 0; $i < count( $replace['old_value'] ); $i++ ) {
				if ( ! empty( $replace['old_value'][ $i ] ) && ! empty( $replace['new_value'][ $i ] ) ) {
					$config['Replace']['OldValues'][] = $replace['old_value'][ $i ];
					$config['Replace']['NewValues'][] = $replace['new_value'][ $i ];
				}
			}
		}

		// Set no replace email
		if ( isset( $params['options']['no_email_replace'] ) ) {
			$config['NoEmailReplace'] = true;
		}

		// Set plugin version
		$config['Plugin'] = array( 'Version' => AI1WM_VERSION );

		// Set WordPress version and content
		$config['WordPress'] = array( 'Version' => $wp_version, 'Content' => WP_CONTENT_DIR );

		// Set database version
		$config['Database'] = array( 'Version' => $mysql->version() );

		// Set PHP version
		$config['PHP'] = array( 'Version' => phpversion() );

		// Set active plugins
		$config['Plugins'] = array_values( array_diff( ai1wm_active_plugins(), ai1wm_active_servmask_plugins() ) );

		// Set active template
		$config['Template'] = ai1wm_active_template();

		// Set active stylesheet
		$config['Stylesheet'] = ai1wm_active_stylesheet();

		// Save package.json file
		$handle = ai1wm_open( ai1wm_package_path( $params ), 'w' );
		ai1wm_write( $handle, json_encode( $config ) );
		ai1wm_close( $handle );

		// Add package.json file
		$archive = new Ai1wm_Compressor( ai1wm_archive_path( $params ) );
		$archive->add_file( ai1wm_package_path( $params ), AI1WM_PACKAGE_NAME );
		$archive->close();

		// Set progress
		Ai1wm_Status::info( __( 'Done adding configuration to archive.', AI1WM_PLUGIN_NAME ) );

		return $params;
	}
}
