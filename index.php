<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme and one
 * of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query,
 * e.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */
get_header(); ?>

<div id="main-content" class="main-content">
<?php
	if ( is_front_page() && twentyfourteen_has_featured_posts() ) {
		// Include the featured content template.
		get_template_part( 'featured-content' );
	}
?>
<style>
/*.main-blog{
	margin-top:2%;
}*/
.first-blog-col{
	margin-top:2%;
	/*height:280px;*/
	font-family:Arial,sans-serif;
}
.blog-content{
    height: 200px;
	border:1px solid #E8E8E8;
	bottom:1px;
	padding-bottom:1px;
	margin-bottom:1px;
}
.first-blog-col:hover{
	opacity: 0.6;
 	filter: alpha(opacity=60); /* For IE8 and earlier */
}
.entry-title a{
	font-size:12px;
	color:#717070;
}

</style>
<div class="container main-blog">
	<div class="row">
    <div class="col-md-9">
	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">
		<?php
			if ( have_posts() ) :
				// Start the Loop.
				?>
                <div class="row">
                <?php
				while ( have_posts() ) : the_post();

					/*
					 * Include the post format-specific template for the content. If you want to
					 * use this in a child theme, then include a file called called content-___.php
					 * (where ___ is the post format) and that will be used instead.
					 */
					get_template_part( 'content-blog', get_post_format() );

				endwhile;
				?>
                </div>
                <?php
				// Previous/next post navigation.
				echo '<hr>';
				sa_bootstrap_paginate_links();

			else :
				// If no content, include the "No posts found" template.
				get_template_part( 'content-blog', 'none' );

			endif;
		?>

		</div><!-- #content -->
	</div><!-- #primary -->
</div>
<div class="col-md-3"><?php get_sidebar( 'right' ); ?></div>
</div>
</div> <!-- #container -->
</div><!-- #main-content -->
<?php get_footer(); ?>

<script>
    $(document).ready(function(){
        // console.log($(document).height());
        // console.log($('#header').height());
        // console.log($('#footer').height());
        // console.log($('#wpadminbar').height());
        var fullHeight = $(document).height();
        var newHeight = fullHeight - $('#header').height() - 224 - $('#wpadminbar').outerHeight(true);
        $('#main').css('min-height',newHeight+'px');
    });
</script>