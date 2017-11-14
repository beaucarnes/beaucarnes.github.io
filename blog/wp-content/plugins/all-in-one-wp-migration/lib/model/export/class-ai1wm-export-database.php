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

class Ai1wm_Export_Database {

	public static function execute( $params ) {
		global $wpdb;

		// Set exclude database
		if ( isset( $params['options']['no_database'] ) ) {
			return $params;
		}

		// Set table offset
		if ( isset( $params['table_offset'] ) ) {
			$table_offset = (int) $params['table_offset'];
		} else {
			$table_offset = 0;
		}

		// Set total tables count
		if ( isset( $params['total_tables_count'] ) ) {
			$total_tables_count = (int) $params['total_tables_count'];
		} else {
			$total_tables_count = 1;
		}

		// What percent of tables have we processed?
		$progress = (int) ( ( $table_offset / $total_tables_count ) * 100 );

		// Set progress
		Ai1wm_Status::info( sprintf( __( 'Exporting database...<br />%d%% complete', AI1WM_PLUGIN_NAME ), $progress ) );

		// Get database client
		if ( empty( $wpdb->use_mysqli ) ) {
			$mysql = new Ai1wm_Database_Mysql( $wpdb );
		} else {
			$mysql = new Ai1wm_Database_Mysqli( $wpdb );
		}

		// Spam comments
		if ( isset( $params['options']['no_spam_comments'] ) ) {
			$mysql->set_table_query_clauses( ai1wm_table_prefix() . 'comments', " WHERE comment_approved != 'spam' " );
			$mysql->set_table_query_clauses( ai1wm_table_prefix() . 'commentmeta', sprintf(
				" WHERE comment_id IN ( SELECT comment_ID FROM `%s` WHERE comment_approved != 'spam' ) ",
				ai1wm_table_prefix() . 'comments'
			) );
		}

		// Post revisions
		if ( isset( $params['options']['no_revisions'] ) ) {
			$mysql->set_table_query_clauses( ai1wm_table_prefix() . 'posts', " WHERE post_type != 'revision' " );
		}

		$old_table_prefixes = array();
		$new_table_prefixes = array();

		// Set table prefixes
		if ( ai1wm_table_prefix() ) {
			$old_table_prefixes[] = ai1wm_table_prefix();
			$new_table_prefixes[] = ai1wm_servmask_prefix();
		} else {
			// Set table prefixes based on table name
			foreach ( $mysql->get_tables() as $table_name ) {
				$old_table_prefixes[] = $table_name;
				$new_table_prefixes[] = ai1wm_servmask_prefix() . $table_name;
			}

			// Set table prefixes based on user meta
			foreach ( array( 'capabilities', 'user_level', 'user_roles' ) as $user_meta ) {
				$old_table_prefixes[] = $user_meta;
				$new_table_prefixes[] = ai1wm_servmask_prefix() . $user_meta;
			}
		}

		$include_table_prefixes = array();

		// Include table prefixes
		if ( ai1wm_table_prefix() ) {
			$include_table_prefixes[] = ai1wm_table_prefix();
		} else {
			foreach ( $mysql->get_tables() as $table_name ) {
				$include_table_prefixes[] = $table_name;
			}
		}

		// Set database options
		$mysql->set_old_table_prefixes( $old_table_prefixes )
			  ->set_new_table_prefixes( $new_table_prefixes )
			  ->set_include_table_prefixes( $include_table_prefixes )
			  ->set_table_prefix_columns( ai1wm_table_prefix() . 'options', array( 'option_name' ) )
			  ->set_table_prefix_columns( ai1wm_table_prefix() . 'usermeta', array( 'meta_key' ) );

		// Exclude active plugins and status options
		$mysql->set_table_query_clauses( ai1wm_table_prefix() . 'options', sprintf( " WHERE option_name NOT IN ('%s', '%s', '%s', '%s') ", AI1WM_ACTIVE_PLUGINS, AI1WM_ACTIVE_TEMPLATE, AI1WM_ACTIVE_STYLESHEET, AI1WM_STATUS ) );

		// Export database
		if ( $mysql->export( ai1wm_database_path( $params ), $table_offset, 10 ) ) {

			// Get archive file
			$archive = new Ai1wm_Compressor( ai1wm_archive_path( $params ) );

			// Add database to archive
			$archive->add_file( ai1wm_database_path( $params ), AI1WM_DATABASE_NAME );
			$archive->close();

			// Set progress
			Ai1wm_Status::info( __( 'Done exporting database...', AI1WM_PLUGIN_NAME ) );

			// Unset table offset
			unset( $params['table_offset'] );

			// Unset total tables count
			unset( $params['total_tables_count'] );

			// Unset completed flag
			unset( $params['completed'] );

		} else {

			// Get total tables count
			$total_tables_count = count( $mysql->get_tables() );

			// What percent of tables have we processed?
			$progress = (int) ( ( $table_offset / $total_tables_count ) * 100 );

			// Set progress
			Ai1wm_Status::info( sprintf( __( 'Exporting database...<br />%d%% complete', AI1WM_PLUGIN_NAME ), $progress ) );

			// Set table offset
			$params['table_offset'] = $table_offset;

			// Set total tables count
			$params['total_tables_count'] = $total_tables_count;

			// Set completed flag
			$params['completed'] = false;

		}

		return $params;
	}
}
