<?php
/**
 * The Template for displaying all single posts
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */

get_header(); ?>
<div class="container">
  	<div class="row">
  	<div class="col-md-9" style="margin-top:2%;">
	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">
			<?php
				// Start the Loop.
				while ( have_posts() ) : the_post();

					/*
					 * Include the post format-specific template for the content. If you want to
					 * use this in a child theme, then include a file called called content-___.php
					 * (where ___ is the post format) and that will be used instead.
					 */
					get_template_part( 'content-single', get_post_format() );

					// Previous/next post navigation.
					twentyfourteen_post_nav();

					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) {
						comments_template();
					}
				endwhile; 
			?>
		</div><!-- #content -->
	</div><!-- #primary -->
    </div>
    <div class="col-md-3" style="margin-top:20px;">
		<?php do_action('je_theme_post_sidebar',get_the_ID()); ?>
     </div>
	</div>
</div>
<?php
get_sidebar( 'content' );
get_sidebar();
get_footer();
