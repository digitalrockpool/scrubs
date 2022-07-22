<?php
/**
 * Scrubs functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Scrubs
 */

if ( ! function_exists( 'scrubs_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function scrubs_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Scrubs, use a find and replace
		 * to change 'scrubs' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'scrubs', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'scrubs' ),
			'menu-2' => esc_html__( 'Home', 'scrubs' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'scrubs_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );
		
		// Add theme support for gutenberg color palette
		add_theme_support( 'editor-color-palette', array(
			array(
				'name'  => esc_html__( 'Dark Blue', 'scrubs' ),
				'slug' => 'dark-blue',
				'color' => '#002b52',
			),
			array(
				'name'  => esc_html__( 'Mid Blue', 'scrubs' ),
				'slug' => 'mid-blue',
				'color' => '#2196f3',
			),
			array(
				'name'  => esc_html__( 'Dark Green', 'scrubs' ),
				'slug' => 'dark-green',
				'color' => '#00b964',
			),
			array(
				'name'  => esc_html__( 'Dark Blue Grey', 'scrubs' ),
				'slug' => 'dark-blue-grey',
				'color' => '#335669',
			),
			array(
				'name'  => esc_html__( 'Mid Blue Grey', 'scrubs' ),
				'slug' => 'mid-blue-grey',
				'color' => '#527a91',
			),
			array(
				'name'  => esc_html__( 'Light Blue Grey', 'scrubs' ),
				'slug' => 'light-blue-grey',
				'color' => '#b7c7d1',
			),
			array(
				'name'  => esc_html__( 'Dark Grey', 'scrubs' ),
				'slug' => 'dark-grey',
				'color' => '#272727',
			),
			array(
				'name'  => esc_html__( 'Mid Grey', 'scrubs' ),
				'slug' => 'mid-grey',
				'color' => '#6f6f6f',
			),
			array(
				'name'  => esc_html__( 'White Grey', 'scrubs' ),
				'slug' => 'white-grey',
				'color' => '#eff4f7',
			),
			
			array(
				'name'  => esc_html__( 'White', 'scrubs' ),
				'slug' => 'white',
				'color' => '#ffffff',
			),
		) );
		add_theme_support( 'disable-custom-colors' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'scrubs_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function scrubs_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'scrubs_content_width', 640 );
}
add_action( 'after_setup_theme', 'scrubs_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function scrubs_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'scrubs' ),
		'id'            => 'sidebar-filter',
		'description'   => esc_html__( 'Add widgets here.', 'scrubs' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '',
		'after_title'   => '',
	) );
}
add_action( 'widgets_init', 'scrubs_widgets_init' );

/*** Enqueue custom jquery 
function custom_jquery() {

	wp_deregister_script('jquery');
	wp_enqueue_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js', array(), null, true);

}
add_action('wp_enqueue_scripts', 'custom_jquery'); */

/*** Enqueue scripts and styles */
function scrubs_scripts() {
	wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Open+Sans:100,200,300,400,500,600,700,800' );
	wp_enqueue_style( 'font-awesome', '//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css' );
	wp_enqueue_style( 'font-awesome-pro', '//pro.fontawesome.com/releases/v5.13.0/css/all.css' );
	wp_enqueue_style( 'scrubs-style', get_stylesheet_uri() );
	wp_enqueue_style( 'bootstrap-styles', '//stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css' );
	wp_enqueue_style( 'scrubs-style_custom', get_template_directory_uri() . '/lib/css/scrubs-styles.css' );

	// wp_enqueue_script( 'bootstrap-js', '//stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js' );
	wp_enqueue_script( 'scrubs-skip-link-focus-fix', get_template_directory_uri() . '/lib/js/skip-link-focus-fix.js' );
	wp_enqueue_script( 'scrubs-custom-script', get_template_directory_uri() . '/lib/js/scrubs-script.js' );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'scrubs_scripts' );

/*** Add library includes */
require get_template_directory() . '/lib/inc/custom-header.php'; /* implement the custom header feature */
require get_template_directory() . '/lib/inc/template-functions.php'; /* functions which enhance theme by hooking into WordPress. */
require get_template_directory() . '/lib/inc/template-tags.php';/* custom template tags for this theme */
require get_template_directory() . '/lib/inc/customizer.php'; /* customizer additions */
require get_template_directory().'/lib/inc/gravity_forms.php';

/*** Disable admin bar */
add_filter('show_admin_bar', '__return_false');


/*** Hide Admin Dashboard */
add_action( 'admin_init', 'redirect_non_admin_users' );
function redirect_non_admin_users() {
	if ( ! current_user_can( 'manage_options' ) && ('/wp-admin/admin-ajax.php' != $_SERVER['PHP_SELF']) ) :
		wp_redirect( home_url('/dashboard/') );
		exit;
	endif;
}

/*** Login Redirect */
add_filter( 'login_redirect', 'login_redirect', 10, 3 );
function login_redirect( $redirect_to, $request, $user ){
	return home_url('/dashboard/');
}

/*** Logout Redirect */
function logout_redirect(){
  	wp_redirect( home_url('/sign-in/') );
  	exit();
}
add_action( 'wp_logout', 'logout_redirect');

/*** Custom Login Screen */
function custom_login() {
	echo '<link rel="stylesheet" type="text/css" href="'.get_stylesheet_directory_uri().'/lib/css/login-style.css" />';
}
add_action('login_head', 'custom_login');

function login_logo_url() {
	return get_bloginfo( 'url' );
}
add_filter( 'login_headerurl', 'login_logo_url' );

function login_logo_url_title() {
	return 'Cornwall Scrubs';
}
add_filter( 'login_headertitle', 'login_logo_url_title' );

function custom_register_url( $register_url ) {
    $register_url = get_permalink( $register_page_id = 11 );
    return $register_url;
}
add_filter( 'register_url', 'custom_register_url' );


/*** Auto login after registration */
add_action( 'gform_user_registered', 'gravity_registration_autologin',  10, 4 );
function gravity_registration_autologin( $user_id, $user_config, $entry, $password ) {
	$user = get_userdata( $user_id );
	$user_login = $user->user_login;
	$user_password = $password;
   	// $user->set_role(get_option('default_role', 'subscriber'));

    wp_signon( array(
		'user_login' => $user_login,
		'user_password' =>  $user_password,
		'remember' => false

    ) );
}

// Additional Profile Fields
add_action( 'show_user_profile', 'show_extra_profile_fields' );
add_action( 'edit_user_profile', 'show_extra_profile_fields' );
function show_extra_profile_fields( $user ) { ?>

	<h3>Additional Profile Info</h3>

	<table class="form-table">

		<tr>
			<th><label for="location">Location</label></th>

			<td>
				<input type="text" name="location" id="location" value="<?php echo esc_attr( get_the_author_meta( 'location', $user->ID ) ); ?>" class="regular-text" />
			</td>
		</tr>

		<tr>
			<th><label for="phone">Phone</label></th>

			<td>
				<input type="text" name="phone" id="phone" value="<?php echo esc_attr( get_the_author_meta( 'phone', $user->ID ) ); ?>" class="regular-text" />
			</td>
		</tr>

		<tr>
			<th><label for="self_isolating">Self Isolating</label></th>

			<td>
				<input type="text" name="self_isolating" id="self_isolating" value="<?php echo esc_attr( get_the_author_meta( 'self_isolating', $user->ID ) ); ?>" class="regular-text" />
			</td>
		</tr>

		<tr>
			<th><label for="business_name">Business Name</label></th>

			<td>
				<input type="text" name="business_name" id="business_name" value="<?php echo esc_attr( get_the_author_meta( 'business_name', $user->ID ) ); ?>" class="regular-text" />
			</td>
		</tr>

		<tr>
			<th><label for="business_type">Business Type</label></th>

			<td>
				<input type="text" name="business_type" id="business_type" value="<?php echo esc_attr( get_the_author_meta( 'business_type', $user->ID ) ); ?>" class="regular-text" />
				<input type="text" name="business_other" id="business_other" value="<?php echo esc_attr( get_the_author_meta( 'business_other', $user->ID ) ); ?>" class="regular-text" />
			</td>
		</tr>

	</table><?php 
}

add_action( 'personal_options_update', 'save_extra_profile_fields' );
add_action( 'edit_user_profile_update', 'save_extra_profile_fields' );
function save_extra_profile_fields( $user_id ) {

	if ( !current_user_can( 'edit_user', $user_id ) )
		return false;

	update_usermeta( $user_id, 'location', $_POST['location'] );
	update_usermeta( $user_id, 'phone', $_POST['phone'] );
	update_usermeta( $user_id, 'self_isolating', $_POST['self_isolating'] );
	update_usermeta( $user_id, 'business_name', $_POST['business_name'] );
	update_usermeta( $user_id, 'business_type', $_POST['business_type'] );
	update_usermeta( $user_id, 'business_other', $_POST['business_other'] );
}


// DEFINE SESSIONS
global $wpdb;

	$user_id = get_current_user_id();
	$user = get_userdata( $user_id ); 
	$user_role = $user->roles;
	$user_business = $user->business_name;

	$volunteer_region = $wpdb->get_row( "SELECT * FROM volunteer_region WHERE user_id=$user_id" );
	$_SESSION['volunteer_role'] = $volunteer_region->user_role;
	$_SESSION['regional_group'] = $volunteer_region->regional_group;
	$_SESSION['team'] = $volunteer_region->team;
	$_SESSION['active'] = $volunteer_region->active;
	$_SESSION['user_role'] = $user_role[0];


// ROLE CHANGE BECAUSE GF IS NOT WORKING
if( !empty( $user_business ) && $user_role !='scrubs' ) :

	$change_role = new WP_User( $user_id );
	$change_role->set_role( 'scrubs' );

endif;
