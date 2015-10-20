<?php
/*************************************************************
functions-base is for functions that rarely get changed
	-not stuff you switch on and off
functions-options is for functions that are commonly used
	-stuff you switch on and off
functions-site file should be the specific functions for the website

**************************************************************/

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
>>>TABLE OF CONTENTS
**************************************************************/
/*
SITE SPECIFIC FUNCTIONS
	- set content width
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
**********************************************************/

/** Site Specific Functions
**************************************************************/

/*********************
SCRIPTS & ENQUEUEING
*********************/

// loading modernizr and jquery, and reply script
function tr_scripts_and_styles() {
	global $post;
	
	// FONTS
  wp_enqueue_style( 'google-fonts', 'http://fonts.googleapis.com/css?family=PT+Serif|Open+Sans:400,700|Open+Sans+Condensed:700' );
  wp_enqueue_style( 'font-awesome',  'http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css');		
  
	if (!is_admin()) {

    // register main stylesheet
		//wp_enqueue_style( 'tabula-rasa-style', get_stylesheet_directory_uri() . '/css/style.css' );
		
    // ie-only style sheet
		global $wp_styles; // call global $wp_styles variable to add conditional wrapper around ie stylesheet the WordPress way
		$wp_styles->add_data( 'tabula_rasa-ie-only', 'conditional', 'lte IE 9' ); // add conditional wrapper around ie stylesheet		
    wp_enqueue_style( 'tabula_rasa-ie-only', get_stylesheet_directory_uri() . '/css/ie.css', array(), '' );
//wp_enqueue_style( 'mmenu-css', get_template_directory_uri() . '/css/jquery.mmenu.css' );

//wp_enqueue_style( 'reset', get_template_directory_uri() . '/css/reset.css' );
//wp_enqueue_style( 'mmenu-css', get_template_directory_uri() . '/css/mmenu.css' );

		//wp_enqueue_script( 'hide-search', get_template_directory_uri() . '/js/mmenu.js', array( 'jquery' ), '20140703', true );
		
		//adding scripts file in the footer
		wp_enqueue_script( 'tabula_rasa-js', get_stylesheet_directory_uri() . '/js/scripts.js', array( 'jquery' ), '', true );

		/*
		wp_enqueue_script( 'superfish', get_template_directory_uri() . '/js/superfish.min.js', array( 'jquery' ), '20140703', true );
		wp_enqueue_script( 'superfish-settings', get_template_directory_uri() . '/js/superfish-settings.js', array('superfish'), '20140703', true );
		
		wp_enqueue_script( 'prefix-fitvids', get_template_directory_uri() . '/js/jquery.fitvids.js', array( 'jquery' ), '1.0.0', true );

		wp_enqueue_script( 'mmenu-js', get_template_directory_uri() . '/js/jquery.mmenu.min.js', array( 'jquery' ), '20140703', true );
		wp_enqueue_script( 'mmenu-settings', get_template_directory_uri() . '/js/mmenu-settings.js', array('mmenu-js'), '20140703', true );
		
     
		wp_enqueue_script( 'hide-search', get_template_directory_uri() . '/js/hide-search.js', array( 'jquery' ), '20140703', true );
		
    wp_enqueue_script( 'tabula_rasa-js' );
		*/
  }
	//if( is_page('my-page') ) {}
  // if( is_single() )
  // if( is_home() )
  // if( 'cpt-name' == get_post_type() )
	// For shortcodes
	//if( is_a( $post, 'WP_Post' ) && has_shortcode( $post->post_content, 'custom-shortcode') ) {}
	
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}	
	 
	// I recommend using a plugin to call jQuery using the google cdn. That way it stays cached and your site will load faster.
	wp_enqueue_script( 'jquery' );	
}
//add_action( 'wp_enqueue_scripts', 'tr_scripts_and_styles' );

/**************************************************************
INCLUDES
**************************************************************/
/** Custom Post Types
**************************************************************/
//require_once('custom-post-type.php'); 

/** Widgets
**************************************************************/
//require_once('functions-widgets.php'); 

/** Meta Boxes
**************************************************************/
//require_once('metabox/metabox-functions.php'); 

/************************************************
EXCERPTS
*************************************************/
// This removes the annoying […] to a Read More link
function tr_excerpt_more($more) {
	global $post;
	// edit here if you like
	return '...  <a class="excerpt-read-more" href="'. get_permalink($post->ID) . '" title="'. __('Read', 'tabula_rasa') . get_the_title($post->ID).'">'. __('Read more &raquo;', 'tabula_rasa') .'</a>';
}	
add_filter('excerpt_more', 'tr_excerpt_more');

//Excerpt length
function tr_excerpt_length( $length ) {
	if ( tribe_is_past() || tribe_is_upcoming() && !is_tax() ) {
		return 20;	
	} elseif( tribe_is_day() && !is_tax() ) {
		return 20;
	} elseif(  tribe_is_photo() && !is_tax() ) {
		return 50;
	} else {
		return 20;
	}
}
add_filter( 'excerpt_length', 'tr_excerpt_length', 999 );

/*************************************************************
POST THUMBNAILS
**************************************************************/
//add_image_size( $name, $width, $height, $crop );
add_image_size( 'list-thumb', 90, 90, true );
add_image_size( 'photo-thumb', 300, 150, true );

/*************************************************************
MISC
**************************************************************/
/*
 * Social media icon menu as per http://justintadlock.com/archives/2013/08/14/social-nav-menus-part-2
 */

function tr_social_menu() {
  if ( has_nav_menu( 'social' ) ) {
		wp_nav_menu(
			array(
				'theme_location'  => 'social',
				'container'       => 'div',
				'container_id'    => 'menu-social',
				'container_class' => 'menu-social',
				'menu_id'         => 'menu-social-items',
				'menu_class'      => 'menu-items',
				'depth'           => 1,
				'link_before'     => '<span class="screen-reader-text">',
				'link_after'      => '</span>',			
				'fallback_cb'     => '',
			)
		);
  }
}


/** Google Analytics
**************************************************************/
function google_analytics_tracking_code(){ ?>
	<script>
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

		ga('create', 'UA-2432710-6', 'prescott-az.gov');
		ga('send', 'pageview');
	</script>
<?php }	
add_action('wp_head', 'google_analytics_tracking_code');

/** Theme Options Data
**************************************************************/
/*
This function is needed by inc/theme-options-inc
Helper function to return the theme option value. If no value has been saved, it returns $default.
Needed because options are saved as serialized strings.
------------------------------------------------------------------*/
function theme_options() {
	if ( !function_exists( 'of_get_option' ) ) {
		function of_get_option($name, $default = false) {
			$optionsframework_settings = get_option('optionsframework');
			
			// Gets the unique option id
			$option_name = $optionsframework_settings['id'];
			if ( get_option($option_name) ) {
				$options = get_option($option_name);
			}
			if ( isset($options[$name]) ) {
				return $options[$name];
			} else {
				return $default;
			}
		}
	}
}
add_action( 'after_setup_theme', 'theme_options' );
//require_once('inc/theme-options.php');
?>