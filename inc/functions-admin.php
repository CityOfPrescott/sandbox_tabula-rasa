<?php
/*************************************************************
ADMIN MENU
**************************************************************/

function remove_admin_menus () {
	if (!current_user_can('manage_options')){ // Only proceed if user does not have admin role.
		//remove_menu_page('index.php'); 				// Dashboard
		//remove_menu_page('edit.php'); 				// Posts
		//remove_menu_page('upload.php'); 			// Media
		//remove_menu_page('link-manager.php'); 			// Links
		//remove_menu_page('edit.php?post_type=page'); 		// Pages
		//remove_menu_page('edit-comments.php'); 			// Comments
		//remove_menu_page('themes.php'); 			// Appearance
		//remove_menu_page('plugins.php'); 			// Plugins
		//remove_menu_page('users.php'); 				// Users
		//remove_menu_page('tools.php'); 				// Tools
		//remove_menu_page('options-general.php'); 		// Settings
 
		//remove_submenu_page( 'edit.php', 'edit-tags.php?taxonomy=post_tag' );	// Remove posts->tags submenu
		//remove_submenu_page( 'edit.php', 'edit-tags.php?taxonomy=category' );	// Remove posts->categories submenu
		remove_submenu_page( 'index.php', 'index.php?page=simple_history_page' );
		remove_submenu_page( 'themes.php', 'themes.php' );
		remove_submenu_page( 'themes.php', 'widgets.php' );
	}
}
add_action('admin_menu', 'remove_admin_menus');

function edit_admin_menu_titles() {  
    global $menu;  
    global $submenu;  
      
    //$menu[5][0] = 'Recipes'; // Change Posts to Recipes  
    //$submenu['edit.php'][5][0] = 'All Recipes';  
    //$submenu['edit.php'][10][0] = 'Add a Recipe';  
    //$submenu['edit.php'][15][0] = 'Meal Types'; // Rename categories to meal types  
    //$submenu['edit.php'][16][0] = 'Ingredients'; // Rename tags to ingredients  
}  
add_action( 'admin_menu', 'edit_admin_menu_titles' ); 

function custom_menu_order($menu_ord) {  
    if (!$menu_ord) return true;  
      
    return array(  
        'index.php', // Dashboard  
        'separator1', // First separator  
        'edit.php', // Posts  
        'upload.php', // Media  
        'link-manager.php', // Links  
        'edit.php?post_type=page', // Pages  
        'edit-comments.php', // Comments  
        'separator2', // Second separator  
        'themes.php', // Appearance  
        'plugins.php', // Plugins  
        'users.php', // Users  
        'tools.php', // Tools  
        'options-general.php', // Settings  
        'separator-last', // Last separator  
    );  
}  
//add_filter('custom_menu_order', 'custom_menu_order'); // Activate custom_menu_order  
//add_filter('menu_order', 'custom_menu_order');  

/*************************************************************
WORDPRESS ADMIN BAR
***********************************************************/

/** Remove admin bar 
**************************************************************/
//remove_action( 'init', '_wp_admin_bar_init' );  

/** Remove admin bar except admin
**************************************************************/
/*  
if ( !current_user_can( 'manage_options' ) ) {  // Enable the WordPress Admin Bar for admins only 
if ( is_admin() ) {  // Display the WordPress Admin Bar in the Admin Area only
if ( !is_admin() ) {    // Display the WordPress Admin bar on Websites only 
if ( is_network_admin() ) { // Disable The Admin Bar within the Network Admin only
    remove_action( 'init', '_wp_admin_bar_init' );  
}  
*/

/* Remove admin bar from admin area
**************************************************************/
/*
if ( is_admin() ) {  
    remove_action( 'init', '_wp_admin_bar_init' );  
    add_action( 'admin_head', 'remove_adminbar_margin' );  
}*/ 

/* Remove admin bar from from end
**************************************************************/
/*if ( !is_admin() ) {  
    remove_action( 'init', '_wp_admin_bar_init' );  
    add_action( 'wp_head', 'remove_adminbar_margin' );  
}  */

function remove_admin_bar_links() {
	global $wp_admin_bar;
	$wp_admin_bar->remove_menu('wp-logo');          // Remove the WordPress logo
	//$wp_admin_bar->remove_menu('about');            // Remove the about WordPress link
	//$wp_admin_bar->remove_menu('wporg');            // Remove the WordPress.org link
	//$wp_admin_bar->remove_menu('documentation');    // Remove the WordPress documentation link
	//$wp_admin_bar->remove_menu('support-forums');   // Remove the support forums link
	//$wp_admin_bar->remove_menu('feedback');         // Remove the feedback link
	//$wp_admin_bar->remove_menu('site-name');        // Remove the site name menu
	//$wp_admin_bar->remove_menu('my-sites');  				// Remove My Sites menu
	//$wp_admin_bar->remove_menu('view-site');        // Remove the view site link
	//$wp_admin_bar->remove_menu('updates');          // Remove the updates link
	//$wp_admin_bar->remove_menu('comments');         // Remove the comments link
	//$wp_admin_bar->remove_menu('search');  					// Remove Search Icon
	//$wp_admin_bar->remove_menu('new-content');      // Remove the content link
	//$wp_admin_bar->remove_menu('w3tc');             // If you use w3 total cache remove the performance link
	//$wp_admin_bar->remove_menu('my-account');       // Remove the user details tab
}
add_action( 'wp_before_admin_bar_render', 'remove_admin_bar_links' );

/** Add custom link to admin bar
**************************************************************/
function custom_adminbar_menu( $meta = TRUE ) {  
    global $wp_admin_bar;  
        if ( !is_user_logged_in() ) { return; }  
        if ( !is_super_admin() || !is_admin_bar_showing() ) { return; }  
    $wp_admin_bar->add_menu( array(  
        'id' => 'custom_menu',  
        'title' => __( 'Menu Name', 'tabula-rasa' ),  
        'href' => 'http://google.com/',  
        'meta'  => array( target => '_blank' ) )  
    );  
}
/*------------------------------------------------------------------ 
The add_action # is the menu position: 
10 = Before the WP Logo 
15 = Between the logo and My Sites 
25 = After the My Sites menu 
100 = End of menu 
------------------------------------------------------------------*/
//add_action( 'admin_bar_menu', 'custom_adminbar_menu', 15 );  


/** Removes the 28px margin for the Admin Bar 
**************************************************************/
/*   
function remove_adminbar_margin() {  
    $remove_adminbar_margin = '<style type="text/css">  
        html { margin-top: -28px !important; }  
        * html body { margin-top: -28px !important; }  
    </style>';  
    echo $remove_adminbar_margin;  
}  
*/

/*************************************************************
DASHBOARD WIDGETS 
**************************************************************/

/** Disable default dashboard widgets
**************************************************************/
function disable_default_dashboard_widgets() {
	// remove_meta_box('dashboard_right_now', 'dashboard', 'core');    // Right Now Widget
	//remove_meta_box('dashboard_recent_comments', 'dashboard', 'core'); // Comments Widget
	remove_meta_box('dashboard_incoming_links', 'dashboard', 'core');  // Incoming Links Widget
	remove_meta_box('dashboard_plugins', 'dashboard', 'core');         // Plugins Widget

	remove_meta_box('dashboard_quick_press', 'dashboard', 'core');  // Quick Press Widget
	remove_meta_box('dashboard_recent_drafts', 'dashboard', 'core');   // Recent Drafts Widget
	remove_meta_box('dashboard_primary', 'dashboard', 'core');         //
	remove_meta_box('dashboard_secondary', 'dashboard', 'core');       //

	// removing plugin dashboard boxes
	//remove_meta_box('yoast_db_widget', 'dashboard', 'normal');         // Yoast's SEO Plugin Widget
	//Remove sections that should only be displayed to admin

	add_action('add_meta_boxes', 'yoast_is_toast', 99);
	function yoast_is_toast(){
		if (!current_user_can('manage_options')){	
			remove_meta_box('simple_history_dashboard_widget', 'dashboard', 'normal'); // Simple History Module
			remove_meta_box('yoast_db_widget', 'dashboard', 'normal'); 
			remove_meta_box('wpseo_meta', 'post', 'normal'); 
			remove_meta_box('wpseo_meta', 'page', 'normal'); 
			remove_meta_box('wpseo_meta', 'construction', 'normal'); 
		}
	}
	if (!current_user_can('manage_options')){	
		remove_meta_box('simple_history_dashboard_widget', 'dashboard', 'normal'); // Simple History Module
	}	
}
add_action('admin_menu', 'disable_default_dashboard_widgets');

// RSS Dashboard Widget
function rss_dashboard_widget() {
	if(function_exists('fetch_feed')) {
		include_once(ABSPATH . WPINC . '/feed.php');               // include the required file
		$feed = fetch_feed('http://themble.com/feed/rss/');        // specify the source feed
		$limit = $feed->get_item_quantity(7);                      // specify number of items
		$items = $feed->get_items(0, $limit);                      // create an array of items
	}
	if ($limit == 0) echo '<div>The RSS Feed is either empty or unavailable.</div>';   // fallback message
	else foreach ($items as $item) { ?>

	<h4 style="margin-bottom: 0;">
		<a href="<?php echo $item->get_permalink(); ?>" title="<?php echo mysql2date(__('j F Y @ g:i a', 'tabula_rasa'), $item->get_date('Y-m-d H:i:s')); ?>" target="_blank">
			<?php echo $item->get_title(); ?>
		</a>
	</h4>
	<p style="margin-top: 0.5em;">
		<?php echo substr($item->get_description(), 0, 200); ?>
	</p>
	<?php }
}

// calling all custom dashboard widgets
function custom_dashboard_widgets() {
	wp_add_dashboard_widget('rss_dashboard_widget', __('Recently on Themble (Customize on admin.php)', 'tabula_rasa'), 'rss_dashboard_widget');
	// Be sure to drop any other created Dashboard Widgets in this function and they will all load.
}
//add_action('wp_dashboard_setup', 'custom_dashboard_widgets');

/*************************************************************
CUSTOM LOGIN PAGE
**************************************************************/

// calling your own login css so you can style it
function tr_login_css() {
	wp_enqueue_style( 'login_css', get_template_directory_uri() . '/css/login.css', false );
}

// changing the logo link from wordpress.org to your site
function tr_login_url() {  return home_url(); }

// changing the alt text on the logo to show your site name
function tr_login_title() { return get_option('blogname'); }

// calling it only on the login page
add_action( 'login_enqueue_scripts', 'tr_login_css', 10 );
add_filter('login_headerurl', 'tr_login_url');
add_filter('login_headertitle', 'tr_login_title');


/*************************************************************
LOGIN REDIRECT 
**************************************************************/
// Redirect user from admin area except certain roles
function only_admins_login_area( $redirect_to, $request, $user ) {
	global $user;
	if ( isset( $user->roles ) && is_array( $user->roles ) ) {
		//check for admins
		if ( in_array( 'administrator', $user->roles ) ) {
			// Redirect to default admin area
			return $redirect_to;
		}
	}
	return home_url();
}
//add_filter( 'login_redirect', 'only_admins_login_area', 10, 3 );

// Remove Access to wp-admin from certain roles
function redirect_user_on_role() {
	global $current_user;
	get_currentuserinfo();

	//If login user role is Subscriber
	if ($current_user->user_level == 0)  {
		wp_redirect( home_url() ); exit;
	}

	//If login user role is Contributor
	if ($current_user->user_level > 1) {
		wp_redirect( home_url() ); exit;
	}

	//If login user role is Editor
	if ($current_user->user_level > 8) {
		wp_redirect( home_url() ); exit;
	}
}
//add_action('admin_init', 'redirect_user_on_role');

/*************************************************************
CUSTOMIZE ADMIN 
**************************************************************/

/** Load admin css
**************************************************************/
function load_custom_wp_admin_style() {
	wp_register_style( 'custom_wp_admin_css', get_template_directory_uri() . '/css/admin.css', false, '1.0.0' );
	wp_enqueue_style( 'custom_wp_admin_css' );
}
add_action( 'admin_enqueue_scripts', 'load_custom_wp_admin_style' );

function cd_add_editor_styles() {
	add_editor_style( get_stylesheet_directory_uri() . '/css/style.css' );
}
add_action( 'init', 'cd_add_editor_styles' );

/**  Custom Backend Footer
**************************************************************/
function tr_custom_admin_footer() {
	_e('<span id="footer-thankyou">Developed by <a href="http://third-law.com" target="_blank">Kenny Scott (Third Law Web Design)</a></span>. Built using Tabula Rasa.', 'tabula_rasa');
}
add_filter('admin_footer_text', 'tr_custom_admin_footer');

/*************************************************************
HELP PAGE 
**************************************************************/
/** Creates Help page for users **/
function my_help_menu() {
	add_menu_page( 'Help', 'Help', 'read', 'help', 'help_options' );
}

function help_options() {
	include('theme-options-inc/help.php');
}
add_action( 'admin_menu', 'my_help_menu' );
?>