<?php 
/* Header

@package	Scrubs Cornwall
@author		Digital Rockpool
@link		https://cornwallscrubs.co.uk
@copyright	Copyright (c) Digital Rockpool LTD 2020.
@license	GPL-2.0+ */ ?>

<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); 
	global $wpdb;
	$active_style = $_SESSION['active'];
	
	if( $active_style == -1 || $active_style == -2 ) : ?>
		<style>
			#mega-menu-item-107 {display:none!important;}
		</style> <?php
	
	endif;
	
	if( is_page( 'scrub-request' ) ) : ?>
		<style>
			.wpDataTablesWrapper  a.DTTT_button_edit {display: none!important;}
		</style> <?php
	
	endif; ?>
</head> <?php
	
$hero = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' ); ?>
	
<body <?php body_class(); if( is_page_template( 'template-fullscreen.php' ) ) : ?> style="background-image: url('<?php echo $hero['0'] ?>');" <?php endif; ?>>
	
<div id="page" class="site row no-gutter">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'inm-careers' ); ?></a> <?php
	
 	$site_directory = get_stylesheet_directory_uri();
	$site_url = get_site_url();
	
if( is_page_template( 'template-fullscreen.php' ) ) : ?>
	
	<main id="site-content" class="row justify-content-md-center" style="width: 100%"> <?php
	
elseif( is_front_page() ) : ?>
		
		<header id="masthead" class="col-12 site-header" style="background-image: url('<?php echo $hero['0'] ?>');">
		<section class="site-info">

			<p class="site-title"><?php bloginfo( 'name' ); ?></p><?php

			$inm_scrubs_description = get_bloginfo( 'description', 'display' );
			if ( $inm_scrubs_description || is_customize_preview() ) : ?> <p class="site-description"><?php echo $inm_scrubs_description; /* WPCS: xss ok. */ ?></p> <?php endif;
			
			$user_id = get_current_user_id();
			
			if( empty( $user_id ) ): $entry_page_slug = 'sign-in'; $entry_page = 'Sign In'; else : $entry_page_slug = 'dashboard'; $entry_page = 'Dashboard'; endif;  ?>
			<a href="<?php echo $site_url.'/'.$entry_page_slug; ?>" title="sign in" class="sign-in-btn"><?php echo $entry_page; ?></a>
		</section>
		
			<section class="row justify-content-center align-items-start homepage-stats" style="margin-left: 0;">
		
				<div class="col-xl-3 col-lg-4 col-10"><div class="gfm-embed" data-url="https://www.gofundme.com/f/cornwall-scrubs/widget/medium"></div><script defer src="https://www.gofundme.com/static/js/embed.js"></script></div>
				
				<div class="col-xl-3 col-lg-4 col-10">
					<div class="stat-box">
						<h2>Volunteers</h2><?php
						$count_users = count_users();
						echo '<h3>'.$count_users['total_users'].'</h3>'; ?>
						<!--<a href="<?php echo $site_url; ?>/sign-up/?type=volunteer" title="request to volunteer">Register to Volunteer</a> -->
					</div>
				</div>
				
				<div class="col-xl-3 col-lg-4 col-10">
					<div class="stat-box">
						<h2>Scrubs, hats &amp; bags </h2>
						<h3 class="d-inline"> <?php 
						$scrubs_totals = $wpdb->get_results( "SELECT SUM(quantity) AS total_scrubs FROM scrub_log WHERE scrub_status= 'Accepted'");
						
						foreach( $scrubs_totals as $scrubs_total ) :
							echo $scrubs_total->total_scrubs;
						endforeach; ?> </h3><span class="d-inline">in production and received</span>
						<a href="<?php echo $site_url; ?>/sign-up/?type=scrubs" title="request scrubs">Request Scrubs</a>
					</div>
				</div>
			
		</section>
	
	</header><!-- #masthead -->
		
	<main id="site-content" class="col-12 bg-white"> <?php
		
else :?>
		 
	<header id="masthead" class="col-xl-2 col-12 site-header">
		<section class="site-info">
			<p class="site-title"><?php bloginfo( 'name' ); ?></p><?php

			$inm_scrubs_description = get_bloginfo( 'description', 'display' );
			if ( $inm_scrubs_description || is_customize_preview() ) : ?> <p class="site-description"><?php echo $inm_scrubs_description; /* WPCS: xss ok. */ ?></p> <?php endif; ?>
		</section>

		<nav id="site-navigation" class="main-navigation"> <?php
			wp_nav_menu( array(
				'theme_location' => 'menu-1',
				'menu_id'        => 'main-menu',
			) ); ?>
		</nav><!-- #site-navigation -->
	
	</header><!-- #masthead -->
		
	<main id="site-content" class="col-xl-10 col-12"> <?php
	
endif;
