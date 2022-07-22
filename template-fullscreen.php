<?php

/* Template Name: Fullscreen

Template Post Type: Page

@package	Inmarsat Debt Investors
@author		Inmarsat
@link		https://debtinvestors.inmarsat.com
@copyright	Copyright (c) Inmarsat Global Limited 2020.
@license	GPL-2.0+  */

get_header();

global $post; ?>
	
<article class="col-12 col-xl-10 col-xxl-8 p-5">
	<section class="p-5 mb-4 clearfix" style="background-color:rgba(255, 255, 255, 0.9);"> 
		<?php

		if ( have_posts() ) : while ( have_posts() ) : the_post();
			
			the_content();
		
		endwhile; endif; 
		
get_footer();