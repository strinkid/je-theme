<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */
?>
<?php $url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?>
<div class="col-md-4 first-blog-col" align="center">
	<div style="height:30px">
		<?php
		$brtitle = strlen(get_the_title()) < 30 ? "\n" : '';
		if ( is_single() ) :
			the_title( '<h1 class="entry-title">', '</h1>'.$brtitle);
		else :
			the_title( '<h1 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h1>'.$brtitle);
		endif;
		?>
	</div>
	<a href="<?php the_permalink() ?>">
    	<div class="blog-content" style="background-image:url(<?php echo $url; ?>);"></div>
	</a>
</div>