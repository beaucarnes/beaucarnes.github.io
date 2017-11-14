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

// ================
// = Plugin Debug =
// ================
define( 'AI1WM_DEBUG', false );

// ==================
// = Plugin Version =
// ==================
define( 'AI1WM_VERSION', '6.50' );

// ===============
// = Plugin Name =
// ===============
define( 'AI1WM_PLUGIN_NAME', 'all-in-one-wp-migration' );

// ===================
// = Directory Index =
// ===================
define( 'AI1WM_DIRECTORY_INDEX', 'index.php' );

// ================
// = Storage Path =
// ================
define( 'AI1WM_STORAGE_PATH', AI1WM_PATH . DIRECTORY_SEPARATOR . 'storage' );

// ==================
// = Error Log Path =
// ==================
define( 'AI1WM_ERROR_FILE', AI1WM_STORAGE_PATH . DIRECTORY_SEPARATOR . 'error.log' );

// ===============
// = Status Path =
// ===============
define( 'AI1WM_STATUS_FILE', AI1WM_STORAGE_PATH . DIRECTORY_SEPARATOR . 'status.js' );

// ============
// = Lib Path =
// ============
define( 'AI1WM_LIB_PATH', AI1WM_PATH . DIRECTORY_SEPARATOR . 'lib' );

// ===================
// = Controller Path =
// ===================
define( 'AI1WM_CONTROLLER_PATH', AI1WM_LIB_PATH . DIRECTORY_SEPARATOR . 'controller' );

// ==============
// = Model Path =
// ==============
define( 'AI1WM_MODEL_PATH', AI1WM_LIB_PATH . DIRECTORY_SEPARATOR . 'model' );

// ===============
// = Export Path =
// ===============
define( 'AI1WM_EXPORT_PATH', AI1WM_MODEL_PATH . DIRECTORY_SEPARATOR . 'export' );

// ===============
// = Import Path =
// ===============
define( 'AI1WM_IMPORT_PATH', AI1WM_MODEL_PATH . DIRECTORY_SEPARATOR . 'import' );

// =============
// = Http Path =
// =============
define( 'AI1WM_HTTP_PATH', AI1WM_MODEL_PATH . DIRECTORY_SEPARATOR . 'http' );

// =============
// = View Path =
// =============
define( 'AI1WM_TEMPLATES_PATH', AI1WM_LIB_PATH . DIRECTORY_SEPARATOR . 'view' );

// ===================
// = Set Bandar Path =
// ===================
define( 'BANDAR_TEMPLATES_PATH', AI1WM_TEMPLATES_PATH );

// ===============
// = Vendor Path =
// ===============
define( 'AI1WM_VENDOR_PATH', AI1WM_LIB_PATH . DIRECTORY_SEPARATOR . 'vendor' );

// =========================
// = ServMask Feedback Url =
// =========================
define( 'AI1WM_FEEDBACK_URL', 'https://servmask.com/ai1wm/feedback/create' );

// =======================
// = ServMask Report Url =
// =======================
define( 'AI1WM_REPORT_URL', 'https://servmask.com/ai1wm/report/create' );

// ==============================
// = ServMask Archive Tools Url =
// ==============================
define( 'AI1WM_ARCHIVE_TOOLS_URL', 'https://servmask.com/archive/tools' );

// =========================
// = ServMask Table Prefix =
// =========================
define( 'AI1WM_TABLE_PREFIX', 'SERVMASK_PREFIX_' );

// ========================
// = Archive Backups Name =
// ========================
define( 'AI1WM_BACKUPS_NAME', 'ai1wm-backups' );

// =========================
// = Archive Database Name =
// =========================
define( 'AI1WM_DATABASE_NAME', 'database.sql' );

// ========================
// = Archive Package Name =
// ========================
define( 'AI1WM_PACKAGE_NAME', 'package.json' );

// ==========================
// = Archive Multisite Name =
// ==========================
define( 'AI1WM_MULTISITE_NAME', 'multisite.json' );

// ======================
// = Archive Blogs Name =
// ======================
define( 'AI1WM_BLOGS_NAME', 'blogs.json' );

// ========================
// = Archive FileMap Name =
// ========================
define( 'AI1WM_FILEMAP_NAME', 'filemap.list' );

// =================================
// = Archive Must-Use Plugins Name =
// =================================
define( 'AI1WM_MUPLUGINS_NAME', 'mu-plugins' );

// ===================
// = Export Log Name =
// ===================
define( 'AI1WM_EXPORT_NAME', 'export.log' );

// ===================
// = Import Log Name =
// ===================
define( 'AI1WM_IMPORT_NAME', 'import.log' );

// ==================
// = Error Log Name =
// ==================
define( 'AI1WM_ERROR_NAME', 'error.log' );

// ==========
// = URL IP =
// ==========
define( 'AI1WM_URL_IP', 'ai1wm_url_ip' );

// ===============
// = URL Adapter =
// ===============
define( 'AI1WM_URL_ADAPTER', 'ai1wm_url_adapter' );

// ==============
// = Secret Key =
// ==============
define( 'AI1WM_SECRET_KEY', 'ai1wm_secret_key' );

// =============
// = Auth User =
// =============
define( 'AI1WM_AUTH_USER', 'ai1wm_auth_user' );

// =================
// = Auth Password =
// =================
define( 'AI1WM_AUTH_PASSWORD', 'ai1wm_auth_password' );

// ==================
// = Active Plugins =
// ==================
define( 'AI1WM_ACTIVE_PLUGINS', 'active_plugins' );

// ===========================
// = Active Sitewide Plugins =
// ===========================
define( 'AI1WM_ACTIVE_SITEWIDE_PLUGINS', 'active_sitewide_plugins' );

// ==========================
// = Jetpack Active Modules =
// ==========================
define( 'AI1WM_JETPACK_ACTIVE_MODULES', 'jetpack_active_modules' );

// ======================
// = MS Files Rewriting =
// ======================
define( 'AI1WM_MS_FILES_REWRITING', 'ms_files_rewriting' );

// ===================
// = Active Template =
// ===================
define( 'AI1WM_ACTIVE_TEMPLATE', 'template' );

// =====================
// = Active Stylesheet =
// =====================
define( 'AI1WM_ACTIVE_STYLESHEET', 'stylesheet' );

// ===============
// = Updater Key =
// ===============
define( 'AI1WM_UPDATER', 'ai1wm_updater' );

// ==============
// = Status Key =
// ==============
define( 'AI1WM_STATUS', 'ai1wm_status' );

// =================
// = Support Email =
// =================
define( 'AI1WM_SUPPORT_EMAIL', 'support@servmask.com' );

// =================
// = Max File Size =
// =================
define( 'AI1WM_MAX_FILE_SIZE', 536870912 );

// ==================
// = Max Chunk Size =
// ==================
define( 'AI1WM_MAX_CHUNK_SIZE', 5242880 );

// =====================
// = Max Chunk Retries =
// =====================
define( 'AI1WM_MAX_CHUNK_RETRIES', 10 );

// ===========================
// = WP_CONTENT_DIR Constant =
// ===========================
if ( ! defined( 'WP_CONTENT_DIR' ) ) {
	define( 'WP_CONTENT_DIR', ABSPATH . 'wp-content' );
}

// ================
// = Uploads Path =
// ================
define( 'AI1WM_UPLOADS_PATH', 'uploads' );

// ==============
// = Blogs Path =
// ==============
define( 'AI1WM_BLOGSDIR_PATH', 'blogs.dir' );

// ==============
// = Sites Path =
// ==============
define( 'AI1WM_SITES_PATH', AI1WM_UPLOADS_PATH . DIRECTORY_SEPARATOR . 'sites' );

// ================
// = Backups Path =
// ================
define( 'AI1WM_BACKUPS_PATH', WP_CONTENT_DIR . DIRECTORY_SEPARATOR . 'ai1wm-backups' );

// ======================
// = Storage Index File =
// ======================
define( 'AI1WM_STORAGE_INDEX', AI1WM_STORAGE_PATH . DIRECTORY_SEPARATOR . 'index.php' );

// ======================
// = Backups Index File =
// ======================
define( 'AI1WM_BACKUPS_INDEX', AI1WM_BACKUPS_PATH . DIRECTORY_SEPARATOR . 'index.php' );

// =========================
// = Backups Htaccess File =
// =========================
define( 'AI1WM_BACKUPS_HTACCESS', AI1WM_BACKUPS_PATH . DIRECTORY_SEPARATOR . '.htaccess' );

// ==========================
// = Backups Webconfig File =
// ==========================
define( 'AI1WM_BACKUPS_WEBCONFIG', AI1WM_BACKUPS_PATH . DIRECTORY_SEPARATOR . 'web.config' );

// ================================
// = WP Migration Plugin Base Dir =
// ================================
if ( defined( 'AI1WM_PLUGIN_BASENAME' ) ) {
	define( 'AI1WM_PLUGIN_BASEDIR', dirname( AI1WM_PLUGIN_BASENAME ) );
} else {
	define( 'AI1WM_PLUGIN_BASEDIR', 'all-in-one-wp-migration' );
}

// ==============================
// = Dropbox Extension Base Dir =
// ==============================
if ( defined( 'AI1WMDE_PLUGIN_BASENAME' ) ) {
	define( 'AI1WMDE_PLUGIN_BASEDIR', dirname( AI1WMDE_PLUGIN_BASENAME ) );
} else {
	define( 'AI1WMDE_PLUGIN_BASEDIR', 'all-in-one-wp-migration-dropbox-extension' );
}

// ===========================
// = Dropbox Extension About =
// ===========================
if ( ! defined( 'AI1WMDE_PLUGIN_ABOUT' ) ) {
	define( 'AI1WMDE_PLUGIN_ABOUT', 'https://servmask.com/products/dropbox-extension/about' );
}

// =========================
// = Dropbox Extension Key =
// =========================
if ( ! defined( 'AI1WMDE_PLUGIN_KEY' ) ) {
	define( 'AI1WMDE_PLUGIN_KEY', 'ai1wmde_plugin_key' );
}

// ===========================
// = Dropbox Extension Short =
// ===========================
if ( ! defined( 'AI1WMDE_PLUGIN_SHORT' ) ) {
	define( 'AI1WMDE_PLUGIN_SHORT', 'dropbox' );
}

// ===================================
// = Google Drive Extension Base Dir =
// ===================================
if ( defined( 'AI1WMGE_PLUGIN_BASENAME' ) ) {
	define( 'AI1WMGE_PLUGIN_BASEDIR', dirname( AI1WMGE_PLUGIN_BASENAME ) );
} else {
	define( 'AI1WMGE_PLUGIN_BASEDIR', 'all-in-one-wp-migration-gdrive-extension' );
}

// ================================
// = Google Drive Extension About =
// ================================
if ( ! defined( 'AI1WMGE_PLUGIN_ABOUT' ) ) {
	define( 'AI1WMGE_PLUGIN_ABOUT', 'https://servmask.com/products/google-drive-extension/about' );
}

// ==============================
// = Google Drive Extension Key =
// ==============================
if ( ! defined( 'AI1WMGE_PLUGIN_KEY' ) ) {
	define( 'AI1WMGE_PLUGIN_KEY', 'ai1wmge_plugin_key' );
}

// ================================
// = Google Drive Extension Short =
// ================================
if ( ! defined( 'AI1WMGE_PLUGIN_SHORT' ) ) {
	define( 'AI1WMGE_PLUGIN_SHORT', 'gdrive' );
}

// ================================
// = Amazon S3 Extension Base Dir =
// ================================
if ( defined( 'AI1WMSE_PLUGIN_BASENAME' ) ) {
	define( 'AI1WMSE_PLUGIN_BASEDIR', dirname( AI1WMSE_PLUGIN_BASENAME ) );
} else {
	define( 'AI1WMSE_PLUGIN_BASEDIR', 'all-in-one-wp-migration-s3-extension' );
}

// =============================
// = Amazon S3 Extension About =
// =============================
if ( ! defined( 'AI1WMSE_PLUGIN_ABOUT' ) ) {
	define( 'AI1WMSE_PLUGIN_ABOUT', 'https://servmask.com/products/amazon-s3-extension/about' );
}

// ===========================
// = Amazon S3 Extension Key =
// ===========================
if ( ! defined( 'AI1WMSE_PLUGIN_KEY' ) ) {
	define( 'AI1WMSE_PLUGIN_KEY', 'ai1wmse_plugin_key' );
}

// =============================
// = Amazon S3 Extension Short =
// =============================
if ( ! defined( 'AI1WMSE_PLUGIN_SHORT' ) ) {
	define( 'AI1WMSE_PLUGIN_SHORT', 's3' );
}

// ================================
// = Multisite Extension Base Dir =
// ================================
if ( defined( 'AI1WMME_PLUGIN_BASENAME' ) ) {
	define( 'AI1WMME_PLUGIN_BASEDIR', dirname( AI1WMME_PLUGIN_BASENAME ) );
} else {
	define( 'AI1WMME_PLUGIN_BASEDIR', 'all-in-one-wp-migration-multisite-extension' );
}

// =============================
// = Multisite Extension About =
// =============================
if ( ! defined( 'AI1WMME_PLUGIN_ABOUT' ) ) {
	define( 'AI1WMME_PLUGIN_ABOUT', 'https://servmask.com/products/multisite-extension/about' );
}

// ===========================
// = Multisite Extension Key =
// ===========================
if ( ! defined( 'AI1WMME_PLUGIN_KEY' ) ) {
	define( 'AI1WMME_PLUGIN_KEY', 'ai1wmme_plugin_key' );
}

// =============================
// = Multisite Extension Short =
// =============================
if ( ! defined( 'AI1WMME_PLUGIN_SHORT' ) ) {
	define( 'AI1WMME_PLUGIN_SHORT', 'multisite' );
}

// ================================
// = Unlimited Extension Base Dir =
// ================================
if ( defined( 'AI1WMUE_PLUGIN_BASENAME' ) ) {
	define( 'AI1WMUE_PLUGIN_BASEDIR', dirname( AI1WMUE_PLUGIN_BASENAME ) );
} else {
	define( 'AI1WMUE_PLUGIN_BASEDIR', 'all-in-one-wp-migration-unlimited-extension' );
}

// =============================
// = Unlimited Extension About =
// =============================
if ( ! defined( 'AI1WMUE_PLUGIN_ABOUT' ) ) {
	define( 'AI1WMUE_PLUGIN_ABOUT', 'https://servmask.com/products/unlimited-extension/about' );
}

// ===========================
// = Unlimited Extension Key =
// ===========================
if ( ! defined( 'AI1WMUE_PLUGIN_KEY' ) ) {
	define( 'AI1WMUE_PLUGIN_KEY', 'ai1wmue_plugin_key' );
}

// =============================
// = Unlimited Extension Short =
// =============================
if ( ! defined( 'AI1WMUE_PLUGIN_SHORT' ) ) {
	define( 'AI1WMUE_PLUGIN_SHORT', 'unlimited' );
}

// ==========================
// = FTP Extension Base Dir =
// ==========================
if ( defined( 'AI1WMFE_PLUGIN_BASENAME' ) ) {
	define( 'AI1WMFE_PLUGIN_BASEDIR', dirname( AI1WMFE_PLUGIN_BASENAME ) );
} else {
	define( 'AI1WMFE_PLUGIN_BASEDIR', 'all-in-one-wp-migration-ftp-extension' );
}

// =======================
// = FTP Extension About =
// =======================
if ( ! defined( 'AI1WMFE_PLUGIN_ABOUT' ) ) {
	define( 'AI1WMFE_PLUGIN_ABOUT', 'https://servmask.com/products/ftp-extension/about' );
}

// =====================
// = FTP Extension Key =
// =====================
if ( ! defined( 'AI1WMFE_PLUGIN_KEY' ) ) {
	define( 'AI1WMFE_PLUGIN_KEY', 'ai1wmfe_plugin_key' );
}

// =======================
// = FTP Extension Short =
// =======================
if ( ! defined( 'AI1WMFE_PLUGIN_SHORT' ) ) {
	define( 'AI1WMFE_PLUGIN_SHORT', 'ftp' );
}

// ==========================
// = URL Extension Base Dir =
// ==========================
if ( defined( 'AI1WMLE_PLUGIN_BASENAME' ) ) {
	define( 'AI1WMLE_PLUGIN_BASEDIR', dirname( AI1WMLE_PLUGIN_BASENAME ) );
} else {
	define( 'AI1WMLE_PLUGIN_BASEDIR', 'all-in-one-wp-migration-url-extension' );
}

// =======================
// = URL Extension About =
// =======================
if ( ! defined( 'AI1WMLE_PLUGIN_ABOUT' ) ) {
	define( 'AI1WMLE_PLUGIN_ABOUT', 'https://servmask.com/products/url-extension/about' );
}

// =====================
// = URL Extension Key =
// =====================
if ( ! defined( 'AI1WMLE_PLUGIN_KEY' ) ) {
	define( 'AI1WMLE_PLUGIN_KEY', 'ai1wmle_plugin_key' );
}

// =======================
// = URL Extension Short =
// =======================
if ( ! defined( 'AI1WMLE_PLUGIN_SHORT' ) ) {
	define( 'AI1WMLE_PLUGIN_SHORT', 'url' );
}

// ===============================
// = OneDrive Extension Base Dir =
// ===============================
if ( defined( 'AI1WMOE_PLUGIN_BASENAME' ) ) {
	define( 'AI1WMOE_PLUGIN_BASEDIR', dirname( AI1WMOE_PLUGIN_BASENAME ) );
} else {
	define( 'AI1WMOE_PLUGIN_BASEDIR', 'all-in-one-wp-migration-onedrive-extension' );
}

// ============================
// = OneDrive Extension About =
// ============================
if ( ! defined( 'AI1WMOE_PLUGIN_ABOUT' ) ) {
	define( 'AI1WMOE_PLUGIN_ABOUT', 'https://servmask.com/products/onedrive-extension/about' );
}

// ==========================
// = OneDrive Extension Key =
// ==========================
if ( ! defined( 'AI1WMOE_PLUGIN_KEY' ) ) {
	define( 'AI1WMOE_PLUGIN_KEY', 'ai1wmoe_plugin_key' );
}

// ============================
// = OneDrive Extension Short =
// ============================
if ( ! defined( 'AI1WMOE_PLUGIN_SHORT' ) ) {
	define( 'AI1WMOE_PLUGIN_SHORT', 'onedrive' );
}

// ==========================
// = Box Extension Base Dir =
// ==========================
if ( defined( 'AI1WMBE_PLUGIN_BASENAME' ) ) {
	define( 'AI1WMBE_PLUGIN_BASEDIR', dirname( AI1WMBE_PLUGIN_BASENAME ) );
} else {
	define( 'AI1WMBE_PLUGIN_BASEDIR', 'all-in-one-wp-migration-box-extension' );
}

// =======================
// = Box Extension About =
// =======================
if ( ! defined( 'AI1WMBE_PLUGIN_ABOUT' ) ) {
	define( 'AI1WMBE_PLUGIN_ABOUT', 'https://servmask.com/products/box-extension/about' );
}

// =====================
// = Box Extension Key =
// =====================
if ( ! defined( 'AI1WMBE_PLUGIN_KEY' ) ) {
	define( 'AI1WMBE_PLUGIN_KEY', 'ai1wmbe_plugin_key' );
}

// =======================
// = Box Extension Short =
// =======================
if ( ! defined( 'AI1WMBE_PLUGIN_SHORT' ) ) {
	define( 'AI1WMBE_PLUGIN_SHORT', 'box' );
}
