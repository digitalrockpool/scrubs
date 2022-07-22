<?php
/* Footer

@package	Scrubs Cornwall
@author		Digital Rockpool
@link		https://scrubscornwall.co.uk
@copyright	Copyright (c) Digital Rockpool LTD 2020.
@license	GPL-2.0+ */ 

$site_url = get_site_url();
 ?>

<footer id="colophon" class="site-footer no-gutters row mt-5 mb-2"> <?php

if( is_page_template( 'template-fullscreen.php' ) ) : $col_width_info = 'col-12 text-center'; $col_width_links = 'col-12 text-center'; else : $col_width_info = 'col-sm-9 col-12'; $col_width_links = 'col-sm-3 col-12'; endif; ?>
	
	<section class="legal-info <?php echo $col_width_info ?> pl-3">
		Copyright &copy; Digital Rockpool LTD <?php echo date('Y') ?>. All rights reserved.
	</section>
	
	<section class="legal-links <?php echo $col_width_links ?> text-right pr-2"> <?php
		$terms_id = get_post(63);
		$privacy_id = get_post(61);?>
		
		<!-- Button trigger modal -->
		<button type="button" class="btn-legal-link" data-toggle="modal" data-target="#terms">T&amp;Cs</button>

		<!-- Modal -->
		<div class="modal fade" id="terms" tabindex="-1" role="dialog" aria-labelledby="terms" aria-hidden="true">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="terms"><?php  echo apply_filters('the_title' , $terms_id -> post_title );?></h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					</div>
					<div class="modal-body"><?php echo apply_filters('the_content' , $terms_id -> post_content ); ?></div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>
		
		<!-- Button trigger modal -->
		<button type="button" class="btn-legal-link" data-toggle="modal" data-target="#privacy">Privacy</button>

		<!-- Modal -->
		<div class="modal fade" id="privacy" tabindex="-1" role="dialog" aria-labelledby="privacy" aria-hidden="true">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="privacy"><?php  echo apply_filters('the_title' , $privacy_id -> post_title );?></h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					</div>
					<div class="modal-body"><?php echo apply_filters('the_content' , $privacy_id -> post_content ); ?></div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>
		
	</section><!-- .site-info -->
</footer><!-- #colophon --> <?php

if( is_page_template( 'template-fullscreen.php' ) ) : ?>
			
	</section>
	</article> <?php

endif; ?>

</main><!-- #site-content -->
</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>