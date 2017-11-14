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

class Ai1wm_Import_Database {

	public static function execute( $params ) {
		global $wpdb;

		// Skip database import
		if ( ! is_file( ai1wm_database_path( $params ) ) ) {
			return $params;
		}

		// Set query offset
		if ( isset( $params['query_offset'] ) ) {
			$query_offset = (int) $params['query_offset'];
		} else {
			$query_offset = 0;
		}

		// Set total queries size
		if ( isset( $params['total_queries_size'] ) ) {
			$total_queries_size = (int) $params['total_queries_size'];
		} else {
			$total_queries_size = 1;
		}

		// Read blogs.json file
		$handle = ai1wm_open( ai1wm_blogs_path( $params ), 'r' );

		// Parse blogs.json file
		$blogs = ai1wm_read( $handle, filesize( ai1wm_blogs_path( $params ) ) );
		$blogs = json_decode( $blogs, true );

		// Close handle
		ai1wm_close( $handle );

		// Read package.json file
		$handle = ai1wm_open( ai1wm_package_path( $params ), 'r' );

		// Parse package.json file
		$config = ai1wm_read( $handle, filesize( ai1wm_package_path( $params ) ) );
		$config = json_decode( $config, true );

		// Close handle
		ai1wm_close( $handle );

		// What percent of queries have we processed?
		$progress = (int) ( ( $query_offset / $total_queries_size ) * 100 );

		// Set progress
		Ai1wm_Status::info( sprintf( __( 'Restoring database...<br />%d%% complete', AI1WM_PLUGIN_NAME ), $progress ) );

		$old_values = array();
		$new_values = array();

		$old_raw_values = array();
		$new_raw_values = array();

		// Get Blog URLs
		foreach ( $blogs as $blog ) {

			$home_urls = array();

			// Add Home URL
			if ( ! empty( $blog['Old']['HomeURL'] ) ) {
				$home_urls[] = $blog['Old']['HomeURL'];
			}

			// Add Internal Home URL
			if ( ! empty( $blog['Old']['InternalHomeURL'] ) ) {
				$home_urls[] = $blog['Old']['InternalHomeURL'];
			}

			// Get Home URL
			foreach ( $home_urls as $home_url ) {

				// Get blogs dir Upload Path
				if ( ! in_array( sprintf( "'%s'", trim( ai1wm_blogsdir_path( $blog['Old']['BlogID'] ), '/' ) ), $old_raw_values ) ) {
					$old_raw_values[] = sprintf( "'%s'", trim( ai1wm_blogsdir_path( $blog['Old']['BlogID'] ), '/' ) );
					$new_raw_values[] = sprintf( "'%s'", get_option( 'upload_path' ) );
				}

				// Get sites dir Upload Path
				if ( ! in_array( sprintf( "'%s'", trim( ai1wm_uploads_path( $blog['Old']['BlogID'] ), '/' ) ), $old_raw_values ) ) {
					$old_raw_values[] = sprintf( "'%s'", trim( ai1wm_uploads_path( $blog['Old']['BlogID'] ), '/' ) );
					$new_raw_values[] = sprintf( "'%s'", get_option( 'upload_path' ) );
				}

				// Handle old and new sites dir style
				if ( defined( 'UPLOADBLOGSDIR' ) ) {

					// Get plain Upload Path
					if ( ! in_array( ai1wm_blogsdir_path( $blog['Old']['BlogID'] ), $old_values ) ) {
						$old_values[] = ai1wm_blogsdir_path( $blog['Old']['BlogID'] );
						$new_values[] = ai1wm_blogsdir_path( $blog['New']['BlogID'] );
					}

					// Get URL encoded Upload Path
					if ( ! in_array( urlencode( ai1wm_blogsdir_path( $blog['Old']['BlogID'] ) ), $old_values ) ) {
						$old_values[] = urlencode( ai1wm_blogsdir_path( $blog['Old']['BlogID'] ) );
						$new_values[] = urlencode( ai1wm_blogsdir_path( $blog['New']['BlogID'] ) );
					}

					// Get JSON escaped Upload Path
					if ( ! in_array( addcslashes( ai1wm_blogsdir_path( $blog['Old']['BlogID'] ), '/' ), $old_values ) ) {
						$old_values[] = addcslashes( ai1wm_blogsdir_path( $blog['Old']['BlogID'] ), '/' );
						$new_values[] = addcslashes( ai1wm_blogsdir_path( $blog['New']['BlogID'] ), '/' );
					}

					// Get plain Upload Path
					if ( ! in_array( ai1wm_uploads_path( $blog['Old']['BlogID'] ), $old_values ) ) {
						$old_values[] = ai1wm_uploads_path( $blog['Old']['BlogID'] );
						$new_values[] = ai1wm_blogsdir_path( $blog['New']['BlogID'] );
					}

					// Get URL encoded Upload Path
					if ( ! in_array( urlencode( ai1wm_uploads_path( $blog['Old']['BlogID'] ) ), $old_values ) ) {
						$old_values[] = urlencode( ai1wm_uploads_path( $blog['Old']['BlogID'] ) );
						$new_values[] = urlencode( ai1wm_blogsdir_path( $blog['New']['BlogID'] ) );
					}

					// Get JSON escaped Upload Path
					if ( ! in_array( addcslashes( ai1wm_uploads_path( $blog['Old']['BlogID'] ), '/' ), $old_values ) ) {
						$old_values[] = addcslashes( ai1wm_uploads_path( $blog['Old']['BlogID'] ), '/' );
						$new_values[] = addcslashes( ai1wm_blogsdir_path( $blog['New']['BlogID'] ), '/' );
					}
				} else {

					// Get files dir Upload URL
					if ( ! in_array( sprintf( '%s/%s/', untrailingslashit( $home_url ), 'files' ), $old_values ) ) {
						$old_values[] = sprintf( '%s/%s/', untrailingslashit( $home_url ), 'files' );
						$new_values[] = ai1wm_uploads_url( $blog['New']['BlogID'] );
					}

					// Get plain Upload Path
					if ( ! in_array( ai1wm_blogsdir_path( $blog['Old']['BlogID'] ), $old_values ) ) {
						$old_values[] = ai1wm_blogsdir_path( $blog['Old']['BlogID'] );
						$new_values[] = ai1wm_uploads_path( $blog['New']['BlogID'] );
					}

					// Get URL encoded Upload Path
					if ( ! in_array( urlencode( ai1wm_blogsdir_path( $blog['Old']['BlogID'] ) ), $old_values ) ) {
						$old_values[] = urlencode( ai1wm_blogsdir_path( $blog['Old']['BlogID'] ) );
						$new_values[] = urlencode( ai1wm_uploads_path( $blog['New']['BlogID'] ) );
					}

					// Get JSON escaped Upload Path
					if ( ! in_array( addcslashes( ai1wm_blogsdir_path( $blog['Old']['BlogID'] ), '/' ), $old_values ) ) {
						$old_values[] = addcslashes( ai1wm_blogsdir_path( $blog['Old']['BlogID'] ), '/' );
						$new_values[] = addcslashes( ai1wm_uploads_path( $blog['New']['BlogID'] ), '/' );
					}

					// Get plain Upload Path
					if ( ! in_array( ai1wm_uploads_path( $blog['Old']['BlogID'] ), $old_values ) ) {
						$old_values[] = ai1wm_uploads_path( $blog['Old']['BlogID'] );
						$new_values[] = ai1wm_uploads_path( $blog['New']['BlogID'] );
					}

					// Get URL encoded Upload Path
					if ( ! in_array( urlencode( ai1wm_uploads_path( $blog['Old']['BlogID'] ) ), $old_values ) ) {
						$old_values[] = urlencode( ai1wm_uploads_path( $blog['Old']['BlogID'] ) );
						$new_values[] = urlencode( ai1wm_uploads_path( $blog['New']['BlogID'] ) );
					}

					// Get JSON escaped Upload Path
					if ( ! in_array( addcslashes( ai1wm_uploads_path( $blog['Old']['BlogID'] ), '/' ), $old_values ) ) {
						$old_values[] = addcslashes( ai1wm_uploads_path( $blog['Old']['BlogID'] ), '/' );
						$new_values[] = addcslashes( ai1wm_uploads_path( $blog['New']['BlogID'] ), '/' );
					}
				}
			}

			$site_urls = array();

			// Add Site URL
			if ( ! empty( $blog['Old']['SiteURL'] ) ) {
				$site_urls[] = $blog['Old']['SiteURL'];
			}

			// Add Internal Site URL
			if ( ! empty( $blog['Old']['InternalSiteURL'] ) ) {
				$site_urls[] = $blog['Old']['InternalSiteURL'];
			}

			// Get Site URL
			foreach ( $site_urls as $site_url ) {

				// Replace Site URL
				if ( $site_url !== $blog['New']['SiteURL'] ) {

					// Get domain
					$old_domain = parse_url( $site_url, PHP_URL_HOST );
					$new_domain = parse_url( $blog['New']['SiteURL'], PHP_URL_HOST );

					// Get path
					$old_path = parse_url( $site_url, PHP_URL_PATH );
					$new_path = parse_url( $blog['New']['SiteURL'], PHP_URL_PATH );

					// Get scheme
					$new_scheme = parse_url( $blog['New']['SiteURL'], PHP_URL_SCHEME );

					// Add domain and path
					if ( ! in_array( sprintf( "'%s','%s'", $old_domain, trailingslashit( $old_path ) ), $old_raw_values ) ) {
						$old_raw_values[] = sprintf( "'%s','%s'", $old_domain, trailingslashit( $old_path ) );
						$new_raw_values[] = sprintf( "'%s','%s'", $new_domain, trailingslashit( $new_path ) );
					}

					// Replace Site URL scheme
					foreach ( array( 'http', 'https' ) as $old_scheme ) {

						// Add plain Site URL
						if ( ! in_array( set_url_scheme( $site_url, $old_scheme ), $old_values ) ) {
							$old_values[] = set_url_scheme( $site_url, $old_scheme );
							$new_values[] = set_url_scheme( $blog['New']['SiteURL'], $new_scheme );
						}

						// Add URL encoded Site URL
						if ( ! in_array( urlencode( set_url_scheme( $site_url, $old_scheme ) ), $old_values ) ) {
							$old_values[] = urlencode( set_url_scheme( $site_url, $old_scheme ) );
							$new_values[] = urlencode( set_url_scheme( $blog['New']['SiteURL'], $new_scheme ) );
						}

						// Add JSON escaped Site URL
						if ( ! in_array( addcslashes( set_url_scheme( $site_url, $old_scheme ), '/' ), $old_values ) ) {
							$old_values[] = addcslashes( set_url_scheme( $site_url, $old_scheme ), '/' );
							$new_values[] = addcslashes( set_url_scheme( $blog['New']['SiteURL'], $new_scheme ), '/' );
						}
					}

					// Add email
					if ( ! isset( $config['NoEmailReplace'] ) ) {
						if ( ! in_array( sprintf( '@%s', $old_domain ), $old_values ) ) {
							$old_values[] = sprintf( '@%s', $old_domain );
							$new_values[] = sprintf( '@%s', $new_domain );
						}
					}
				}
			}

			$home_urls = array();

			// Add Home URL
			if ( ! empty( $blog['Old']['HomeURL'] ) ) {
				$home_urls[] = $blog['Old']['HomeURL'];
			}

			// Add Internal Home URL
			if ( ! empty( $blog['Old']['InternalHomeURL'] ) ) {
				$home_urls[] = $blog['Old']['InternalHomeURL'];
			}

			// Get Home URL
			foreach ( $home_urls as $home_url ) {

				// Replace Home URL
				if ( $home_url !== $blog['New']['HomeURL'] ) {

					// Get domain
					$old_domain = parse_url( $home_url, PHP_URL_HOST );
					$new_domain = parse_url( $blog['New']['HomeURL'], PHP_URL_HOST );

					// Get path
					$old_path = parse_url( $home_url, PHP_URL_PATH );
					$new_path = parse_url( $blog['New']['HomeURL'], PHP_URL_PATH );

					// Get scheme
					$new_scheme = parse_url( $blog['New']['HomeURL'], PHP_URL_SCHEME );

					// Add domain and path
					if ( ! in_array( sprintf( "'%s','%s'", $old_domain, trailingslashit( $old_path ) ), $old_raw_values ) ) {
						$old_raw_values[] = sprintf( "'%s','%s'", $old_domain, trailingslashit( $old_path ) );
						$new_raw_values[] = sprintf( "'%s','%s'", $new_domain, trailingslashit( $new_path ) );
					}

					// Replace Home URL scheme
					foreach ( array( 'http', 'https' ) as $old_scheme ) {

						// Add plain Home URL
						if ( ! in_array( set_url_scheme( $home_url, $old_scheme ), $old_values ) ) {
							$old_values[] = set_url_scheme( $home_url, $old_scheme );
							$new_values[] = set_url_scheme( $blog['New']['HomeURL'], $new_scheme );
						}

						// Add URL encoded Home URL
						if ( ! in_array( urlencode( set_url_scheme( $home_url, $old_scheme ) ), $old_values ) ) {
							$old_values[] = urlencode( set_url_scheme( $home_url, $old_scheme ) );
							$new_values[] = urlencode( set_url_scheme( $blog['New']['HomeURL'], $new_scheme ) );
						}

						// Add JSON escaped Home URL
						if ( ! in_array( addcslashes( set_url_scheme( $home_url, $old_scheme ), '/' ), $old_values ) ) {
							$old_values[] = addcslashes( set_url_scheme( $home_url, $old_scheme ), '/' );
							$new_values[] = addcslashes( set_url_scheme( $blog['New']['HomeURL'], $new_scheme ), '/' );
						}
					}

					// Add email
					if ( ! isset( $config['NoEmailReplace'] ) ) {
						if ( ! in_array( sprintf( '@%s', $old_domain ), $old_values ) ) {
							$old_values[] = sprintf( '@%s', $old_domain );
							$new_values[] = sprintf( '@%s', $new_domain );
						}
					}
				}
			}
		}

		$site_urls = array();

		// Add Site URL
		if ( ! empty( $config['SiteURL'] ) ) {
			$site_urls[] = $config['SiteURL'];
		}

		// Add Internal Site URL
		if ( ! empty( $config['InternalSiteURL'] ) ) {
			$site_urls[] = $config['InternalSiteURL'];
		}

		// Get Site URL
		foreach ( $site_urls as $site_url ) {

			// Replace Site URL
			if ( $site_url !== site_url() ) {

				// Get www URL
				if ( stripos( $site_url, '//www.' ) !== false ) {
					$www_url = str_ireplace( '//www.', '//', $site_url );
				} else {
					$www_url = str_ireplace( '//', '//www.', $site_url );
				}

				// Replace Site URL
				foreach ( array( $site_url, $www_url ) as $url ) {

					// Get domain
					$old_domain = parse_url( $url, PHP_URL_HOST );
					$new_domain = parse_url( site_url(), PHP_URL_HOST );

					// Get path
					$old_path = parse_url( $url, PHP_URL_PATH );
					$new_path = parse_url( site_url(), PHP_URL_PATH );

					// Get scheme
					$new_scheme = parse_url( site_url(), PHP_URL_SCHEME );

					// Add domain and path
					if ( ! in_array( sprintf( "'%s','%s'", $old_domain, trailingslashit( $old_path ) ), $old_raw_values ) ) {
						$old_raw_values[] = sprintf( "'%s','%s'", $old_domain, trailingslashit( $old_path ) );
						$new_raw_values[] = sprintf( "'%s','%s'", $new_domain, trailingslashit( $new_path ) );
					}

					// Replace Site URL scheme
					foreach ( array( 'http', 'https' ) as $old_scheme ) {

						// Add plain Site URL
						if ( ! in_array( set_url_scheme( $url, $old_scheme ), $old_values ) ) {
							$old_values[] = set_url_scheme( $url, $old_scheme );
							$new_values[] = set_url_scheme( site_url(), $new_scheme );
						}

						// Add URL encoded Site URL
						if ( ! in_array( urlencode( set_url_scheme( $url, $old_scheme ) ), $old_values ) ) {
							$old_values[] = urlencode( set_url_scheme( $url, $old_scheme ) );
							$new_values[] = urlencode( set_url_scheme( site_url(), $new_scheme ) );
						}

						// Add JSON escaped Site URL
						if ( ! in_array( addcslashes( set_url_scheme( $url, $old_scheme ), '/' ), $old_values ) ) {
							$old_values[] = addcslashes( set_url_scheme( $url, $old_scheme ), '/' );
							$new_values[] = addcslashes( set_url_scheme( site_url(), $new_scheme ), '/' );
						}
					}

					// Add email
					if ( ! isset( $config['NoEmailReplace'] ) ) {
						if ( ! in_array( sprintf( '@%s', $old_domain ), $old_values ) ) {
							$old_values[] = sprintf( '@%s', $old_domain );
							$new_values[] = sprintf( '@%s', $new_domain );
						}
					}
				}
			}
		}

		$home_urls = array();

		// Add Home URL
		if ( ! empty( $config['HomeURL'] ) ) {
			$home_urls[] = $config['HomeURL'];
		}

		// Add Internal Home URL
		if ( ! empty( $config['InternalHomeURL'] ) ) {
			$home_urls[] = $config['InternalHomeURL'];
		}

		// Get Home URL
		foreach ( $home_urls as $home_url ) {

			// Replace Home URL
			if ( $home_url !== home_url() ) {

				// Get www URL
				if ( stripos( $home_url, '//www.' ) !== false ) {
					$www_url = str_ireplace( '//www.', '//', $home_url );
				} else {
					$www_url = str_ireplace( '//', '//www.', $home_url );
				}

				// Replace Home URL
				foreach ( array( $home_url, $www_url ) as $url ) {

					// Get domain
					$old_domain = parse_url( $url, PHP_URL_HOST );
					$new_domain = parse_url( home_url(), PHP_URL_HOST );

					// Get path
					$old_path = parse_url( $url, PHP_URL_PATH );
					$new_path = parse_url( home_url(), PHP_URL_PATH );

					// Get scheme
					$new_scheme = parse_url( home_url(), PHP_URL_SCHEME );

					// Add domain and path
					if ( ! in_array( sprintf( "'%s','%s'", $old_domain, trailingslashit( $old_path ) ), $old_raw_values ) ) {
						$old_raw_values[] = sprintf( "'%s','%s'", $old_domain, trailingslashit( $old_path ) );
						$new_raw_values[] = sprintf( "'%s','%s'", $new_domain, trailingslashit( $new_path ) );
					}

					// Replace Home URL scheme
					foreach ( array( 'http', 'https' ) as $old_scheme ) {

						// Add plain Home URL
						if ( ! in_array( set_url_scheme( $url, $old_scheme ), $old_values ) ) {
							$old_values[] = set_url_scheme( $url, $old_scheme );
							$new_values[] = set_url_scheme( home_url(), $new_scheme );
						}

						// Add URL encoded Home URL
						if ( ! in_array( urlencode( set_url_scheme( $url, $old_scheme ) ), $old_values ) ) {
							$old_values[] = urlencode( set_url_scheme( $url, $old_scheme ) );
							$new_values[] = urlencode( set_url_scheme( home_url(), $new_scheme ) );
						}

						// Add JSON escaped Home URL
						if ( ! in_array( addcslashes( set_url_scheme( $url, $old_scheme ), '/' ), $old_values ) ) {
							$old_values[] = addcslashes( set_url_scheme( $url, $old_scheme ), '/' );
							$new_values[] = addcslashes( set_url_scheme( home_url(), $new_scheme ), '/' );
						}
					}

					// Add email
					if ( ! isset( $config['NoEmailReplace'] ) ) {
						if ( ! in_array( sprintf( '@%s', $old_domain ), $old_values ) ) {
							$old_values[] = sprintf( '@%s', $old_domain );
							$new_values[] = sprintf( '@%s', $new_domain );
						}
					}
				}
			}
		}

		// Get WordPress Content Dir
		if ( isset( $config['WordPress']['Content'] ) && ( $content_dir = $config['WordPress']['Content'] ) ) {

			// Replace WordPress Content Dir
			if ( $content_dir !== WP_CONTENT_DIR ) {

				// Add plain WordPress Content
				if ( ! in_array( $content_dir, $old_values ) ) {
					$old_values[] = $content_dir;
					$new_values[] = WP_CONTENT_DIR;
				}

				// Add URL encoded WordPress Content
				if ( ! in_array( urlencode( $content_dir ), $old_values ) ) {
					$old_values[] = urlencode( $content_dir );
					$new_values[] = urlencode( WP_CONTENT_DIR );
				}

				// Add JSON escaped WordPress Content
				if ( ! in_array( addcslashes( $content_dir, '/' ), $old_values ) ) {
					$old_values[] = addcslashes( $content_dir, '/' );
					$new_values[] = addcslashes( WP_CONTENT_DIR, '/' );
				}
			}
		}

		// Get replace old and new values
		if ( isset( $config['Replace'] ) && ( $replace = $config['Replace'] ) ) {
			for ( $i = 0; $i < count( $replace['OldValues'] ); $i++ ) {
				if ( ! empty( $replace['OldValues'][ $i ] ) && ! empty( $replace['NewValues'][ $i ] ) ) {

					// Add plain replace values
					if ( ! in_array( $replace['OldValues'][ $i ], $old_values ) ) {
						$old_values[] = $replace['OldValues'][ $i ];
						$new_values[] = $replace['NewValues'][ $i ];
					}

					// Add URL encoded replace values
					if ( ! in_array( urlencode( $replace['OldValues'][ $i ] ), $old_values ) ) {
						$old_values[] = urlencode( $replace['OldValues'][ $i ] );
						$new_values[] = urlencode( $replace['NewValues'][ $i ] );
					}

					// Add JSON Escaped replace values
					if ( ! in_array( addcslashes( $replace['OldValues'][ $i ], '/' ), $old_values ) ) {
						$old_values[] = addcslashes( $replace['OldValues'][ $i ], '/' );
						$new_values[] = addcslashes( $replace['NewValues'][ $i ], '/' );
					}
				}
			}
		}

		// Get URL IP
		$url_ip = get_option( AI1WM_URL_IP );

		// Get URL adapter
		$url_adapter = get_option( AI1WM_URL_ADAPTER );

		// Get secret key
		$secret_key = get_option( AI1WM_SECRET_KEY );

		// Get HTTP user
		$auth_user = get_option( AI1WM_AUTH_USER );

		// Get HTTP password
		$auth_password = get_option( AI1WM_AUTH_PASSWORD );

		$old_prefixes = array();
		$new_prefixes = array();

		// Set main table prefixes
		$old_prefixes[] = ai1wm_servmask_prefix( 'mainsite' );
		$new_prefixes[] = ai1wm_table_prefix();

		// Set site table prefixes
		foreach ( $blogs as $blog ) {
			if ( ai1wm_main_site( $blog['Old']['BlogID'] ) === false ) {
				$old_prefixes[] = ai1wm_servmask_prefix( $blog['Old']['BlogID'] );
				$new_prefixes[] = ai1wm_table_prefix( $blog['New']['BlogID'] );
			}
		}

		// Set base table prefixes
		foreach ( $blogs as $blog ) {
			if ( ai1wm_main_site( $blog['Old']['BlogID'] ) === true ) {
				$old_prefixes[] = ai1wm_servmask_prefix( 'basesite' );
				$new_prefixes[] = ai1wm_table_prefix( $blog['New']['BlogID'] );
			}
		}

		// Set site table prefixes
		foreach ( $blogs as $blog ) {
			if ( ai1wm_main_site( $blog['Old']['BlogID'] ) === true ) {
				$old_prefixes[] = ai1wm_servmask_prefix( $blog['Old']['BlogID'] );
				$new_prefixes[] = ai1wm_table_prefix( $blog['New']['BlogID'] );
			}
		}

		// Set table prefixes
		$old_prefixes[] = ai1wm_servmask_prefix();
		$new_prefixes[] = ai1wm_table_prefix();

		// Get database client
		if ( empty( $wpdb->use_mysqli ) ) {
			$mysql = new Ai1wm_Database_Mysql( $wpdb );
		} else {
			$mysql = new Ai1wm_Database_Mysqli( $wpdb );
		}

		// Set database options
		$mysql->set_old_table_prefixes( $old_prefixes )
			  ->set_new_table_prefixes( $new_prefixes )
			  ->set_old_replace_values( $old_values )
			  ->set_new_replace_values( $new_values )
			  ->set_old_replace_raw_values( $old_raw_values )
			  ->set_new_replace_raw_values( $new_raw_values );

		// Flush database
		if ( isset( $config['Plugin']['Version'] ) && ( $version = $config['Plugin']['Version'] ) ) {
			if ( $version !== 'develop' && version_compare( $version, '4.10', '<' ) ) {
				$mysql->set_include_table_prefixes( array( ai1wm_table_prefix() ) );
				$mysql->flush();
			}
		}

		// Set atomic tables (do not stop the current request for all listed tables if timeout has been exceeded)
		$mysql->set_atomic_tables( array( ai1wm_table_prefix() . 'options' ) );

		// Set Visual Composer
		$mysql->set_visual_composer( ! is_wp_error( validate_plugin( 'js_composer/js_composer.php' ) ) );

		// Import database
		if ( $mysql->import( ai1wm_database_path( $params ), $query_offset, 10 ) ) {

			// Set progress
			Ai1wm_Status::info( __( 'Done restoring database...', AI1WM_PLUGIN_NAME ) );

			// Unset query offset
			unset( $params['query_offset'] );

			// Unset total queries size
			unset( $params['total_queries_size'] );

			// Unset completed flag
			unset( $params['completed'] );

		} else {

			// Get total queries size
			$total_queries_size = ai1wm_database_bytes( $params );

			// What percent of queries have we processed?
			$progress = (int) ( ( $query_offset / $total_queries_size ) * 100 );

			// Set progress
			Ai1wm_Status::info( sprintf( __( 'Restoring database...<br />%d%% complete', AI1WM_PLUGIN_NAME ), $progress ) );

			// Set query offset
			$params['query_offset'] = $query_offset;

			// Set total queries size
			$params['total_queries_size'] = $total_queries_size;

			// Set completed flag
			$params['completed'] = false;
		}

		// Flush WP cache
		ai1wm_cache_flush();

		// Activate plugins
		ai1wm_activate_plugins( ai1wm_active_servmask_plugins() );

		// Set the new URL IP
		update_option( AI1WM_URL_IP, $url_ip );

		// Set the new URL adapter
		update_option( AI1WM_URL_ADAPTER, $url_adapter );

		// Set the new secret key value
		update_option( AI1WM_SECRET_KEY, $secret_key );

		// Set the new HTTP user
		update_option( AI1WM_AUTH_USER, $auth_user );

		// Set the new HTTP password
		update_option( AI1WM_AUTH_PASSWORD, $auth_password );

		return $params;
	}
}
