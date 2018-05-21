<div id="right_sidebar" class="tRightSidebar">
    <?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar('Blog Right') ) : else : ?>
		<?php wp_list_bookmarks('category_before=<div id="tRightColumnInset1">&category_after=</div>&title_before=<h4>&title_after=</h4>&categorize=1&category=2,7,6&orderby=id&category_orderby=id&show_description=0'); ?>
    <?php endif; ?>
    <li>
    	<h4>POPULAR POST</h4>
        <hr/>
        <ul>
        <?php $pc = new WP_Query('post_type=post&posts_per_page=3&orderby=comment_count&order=DESC');
		while ($pc->have_posts()) : $pc->the_post(); ?>
			<?php  if ( has_post_thumbnail() ) { ?>
				<div class="sidebarPopularPost">
					<div class="sidebarPopularPostCol1"><?php the_post_thumbnail(array(60, 60)); ?>
					</div>
					<div class="sidebarPopularPostCol2"><a href="<?php the_permalink(); ?>" 
                           style="color: rgb(0, 158, 224);" title="<?php the_title(); ?>">
					<?php the_title(); ?></a><p><?php the_date(); ?></p>
					</div>
				</div>
			<?php  } else { ?>
				<div class="sidebarPopularPost">
					<a href="<?php the_permalink(); ?>" style="color: rgb(0, 158, 224);" 
                          title="<?php the_title(); ?>">
					<?php the_title(); ?></a>
				</div>
			<?php  } ?>
		<?php endwhile; ?>
        </ul>
    </li>
    <li>
    	<h4>RECENT POST</h4>
        <hr/>
        <ul>
        	<?php
			$recent_posts = wp_get_recent_posts(array('numberposts'=>4));
			foreach( $recent_posts as $recent ){
    			if($recent['post_status']=="publish"){
					if ( has_post_thumbnail($recent["ID"])) { ?>
						<div class="sidebarPopularPost">
							<div class="sidebarPopularPostCol1">
								<?php echo get_the_post_thumbnail($recent["ID"], array(60,60))?>
                           	</div>
                            <div class="sidebarPopularPostCol2">
                            	<a href="<?php echo get_permalink($recent["ID"]) ?>" style="color: rgb(0, 158, 224);" title="<?php echo $recent["post_title"]; ?>">
									<?php echo $recent["post_title"] ?>
                               	</a><p><?php echo get_the_date('',$recent["ID"]) ?></p>
                        </div>
					<?php }else{ ?>
						
					</div>
                    <?php
					}
     			}
			}
			?>
    	</ul>
    </li>
</div>
