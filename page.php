<?php

/* Page

@package	Scrubs Cornwall
@author		Digital Rockpool
@link		https://cornwallscrubs.co.uk
@copyright	Copyright (c) Digital Rockpool LTD 2020.
@license	GPL-2.0+ */

get_header();?>

<article class="site-wrapper">
	<section class="row no-gutters p-5"><?php 
		
		if ( have_posts() ) : while ( have_posts() ) : the_post();
		
			if( !is_page('dashboard') ) : ?><div class="col-12"><h1><?php the_title(); ?></h1></div><?php endif;
		
			if( get_field('enable_sidebar') == 'yes' ) : ?> <div class="col-10"><?php else : ?> <div class="col-12"><?php endif;
				
				the_content();
		
				$volunteer_region = $_SESSION['regional_group'];
				$table_id = get_field('table_id');
		
				if( !empty( $table_id ) ) :
		
					echo do_shortcode( '[wpdatatable id='.$table_id.' var1=\''.$volunteer_region.'\']' );
		
				endif;?>

			</div> <?php 

			if( get_field('enable_sidebar') == 'yes' ) : ?>

				<div class="col-2 pl-5"> <?php dynamic_sidebar( 'sidebar-filter' ); ?> </div> <?php

			endif;
			
		endwhile; endif; ?>
		
	</section> 
	
</article> <?php

get_footer(); ?>