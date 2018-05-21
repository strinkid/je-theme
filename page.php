<?php get_header(); ?>
    <div id="main">
        <div class="limitWidth clearfix">
		<div class="col-md-3">
		<?php dynamic_sidebar('front-page'); ?>
		</div>
        <div id="content" class="col-md-9">
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <?php the_content('Read more...'); ?>
                <?php endwhile;
            else: ?>
                <?php _e('Sorry, no posts matched your criteria.'); ?><?php endif; ?>
        </div>
        </div>
    </div>
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