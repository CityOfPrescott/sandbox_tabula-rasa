<?php
/*************************************************************
ALL CAPS CASE
**************************************************************/

/** Proper Case
**************************************************************/

/** Proper Case **/

/*
Comments Single Line
or Multiple Line
*/

/*************************************************************
FUNCTION TABLE OF CONTENTS
**************************************************************/
require_once('inc/functions-base.php');
/*------------------------------------------------------------------
LAUNCH TABULA RASA
	- tr_launch()
WP_HEAD GOODNESS	
	- head cleanup (remove rss, uri links, junk css, ect)
	- remove WP version from RSS
	- remove WP version from scripts
	- remove injected CSS for recent comments widget
	- remove injected CSS from recent comments widget
	- remove injected CSS from gallery
SCRIPTS & ENQUEUEING		
	- modernizer
	- main stylesheet
	- IE only stylesheet
	- comment reply script for threaded comments
	- scripts.js
	- mobile menu script
THEME SUPPORT	
	- add_theme_support('post-thumbnails')
	- add_editor_style( get_template_directory_uri() . '/css/editor-style.css' )
	- add_theme_support( 'custom-background')
	- add_theme_support('automatic-feed-links')
	- add_theme_support( 'post-formats') 
	- add_theme_support( 'menus' )
	- register_nav_menus( 'The Main Menu', 'The Secondary Menu', 'Footer Links' )
MENUS & NAVIGATION	
	- tr_main_nav()
	- tr_sec_nav()
	- tr_footer_links()
	- tr_main_nav_fallback()
	- tr_sec_nav_fallback()
	- tr_footer_links_fallback()
	- tr_register_sidebars( 'Main Sidebar', 'Secondary Widget Area' )
	- removing <p> from around images
	- tr_content_nav( $html_id )
		// Displays navigation to next/previous pages when applicable.		
	
MISC
	- Custom Header
	- remove the p from around imgs 
	- tr_get_the_author_posts_link()
		// This is a modified the_author_posts_link() which just returns the link.
	- of_get_option
		// This function is needed by inc/theme-options-inc
	- Meta Boxes
		// This function is needed by inc/metabox
------------------------------------------------------------------*/

require_once('inc/functions-settings.php');
/*------------------------------------------------------------------
SITE SPECIFIC FUNCTIONS
	- tr_site_specific_support()
	- tr_excerpt_more()
		// This removes the annoying […] to a Read More link
	- tr_register_site_specific_sidebars()
	- tr_entry_meta()
COMMENT LAYOUT 
	- tr_comment()
MISC
	 - remove_default_post_formats()
	 - Google Analytics
------------------------------------------------------------------*/

require_once('inc/functions-_s.php');
/*------------------------------------------------------------------
Functions that come with _s
------------------------------------------------------------------*/

require_once('inc/functions-site.php');
/*------------------------------------------------------------------
Site Specific Functions
------------------------------------------------------------------*/

require_once('inc/functions-admin.php'); 
/*------------------------------------------------------------------
ADMIN MENU
	- remove_admin_menus ()
	- edit_admin_menu_titles()
	- custom_menu_order($menu_ord)
WORDPRESS ADMIN BAR
	- remove admin bar
	- remove admin bar except admin
	- remove admin bar from admin area
	- remove admin bar from from end
	- remove_admin_bar_links()
	- custom_adminbar_menu()
		// Add custom link to admin bar
	- remove margin from the admin bar
DASHBOARD WIDGETS
	- disable_default_dashboard_widgets()
	- custom_dashboard_widgets()
CUSTOM LOGIN PAGE
	- tr_login_css()
	- tr_login_url()
	- tr_login_title()
	- tr_login_redirect()
CUSTOMIZE ADMIN 
	- load_custom_wp_admin_style()
		// Load admin css
	- tr_custom_admin_footer()
HELP PAGE
	-  my_help_menu
------------------------------------------------------------------*/

require_once('inc/functions-tribe_events.php');
/*------------------------------------------------------------------
Functions for tribe events calendar
------------------------------------------------------------------*/
?>