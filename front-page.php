<?php

/* Front Page

@@package	Scrubs Cornwall
@author		Digital Rockpool
@link		https://cornwallscrubs.co.uk
@copyright	Copyright (c) Digital Rockpool LTD 2020.
@license	GPL-2.0+ */

get_header();?>

<article class="site-wrapper">
	<section class="row justify-content-md-center mt-5">
		<div class="col-xl-8 col-lg-10 col-11"> <?php 
		
		if ( have_posts() ) : while ( have_posts() ) : the_post();
				
				the_content(); ?>

		<?php 
			
		endwhile; endif;?>

	</section> 
</article> <?php

get_footer(); ?>