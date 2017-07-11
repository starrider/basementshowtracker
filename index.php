<?php
get_header(); 
?>
<div class = "slider">
	<?php
  if(is_home() || is_front_page()){
      echo do_shortcode('[smartslider3 slider="2"]');
 	 }
	?>
</div>

<?php 

// get posts
/*
$posts = get_posts(array(
	'post_type'			=> 'post',
	'posts_per_page'	=> 3,
	'meta_key'			=> 'time',
	'orderby'			=> 'meta_value',
	'order'				=> 'DESC'
));

if( $posts ): ?>
	
	<ul>
		
	<?php foreach( $posts as $post ): 
		
		setup_postdata( $post );
		
		?>
		<li>
			<a href="<?php the_permalink(); ?>"><?php the_title(); ?> (date: <?php the_field('time'); ?>)</a>
		</li>
	
	<?php endforeach; ?>
	
	</ul>
	
	<?php wp_reset_postdata(); ?>

<?php endif; 
*/

	
     global $query_string;
     $today = time();
     query_posts( array(
		'post_type'=>'post',
		'paged' => $paged,
		'posts_per_page' => 3,
	//	'meta_key'			=> 'time',
		'orderby'			=> 'meta_value',
		'order'				=> 'ASC',
		'meta_query' => array(
			array(
				'key' => 'time',
				'compare' => '>=',
				'value' => $today,
				)
			),
		)
     );


	if(have_posts()):
			$odd_or_even = 'odd'; 
			while(have_posts()):the_post(); ?>
				<div class = "container <?php echo $odd_or_even;?>">
					<?php $odd_or_even = ('odd'==$odd_or_even) ? 'even' : 'odd'; ?>
						<article class = "post">
							<div class="column-container clearfix">
								<!-- title-column -->
								<div class="title-column">
									<h2><?php the_title(); ?></h2>
									<h3><?php 
									$tint = get_field('time');
										$str = date("D F j, g:i", $tint);
										echo $str;
									 ?></h3>
								</div><!-- /title-column -->
								<!-- text-column -->
								<div class="text-column">
									<?php if(have_rows('bands')): ?>
									<!--	<ul class = "bands"> -->
										<?php while(have_rows('bands')): the_row(); ?>
											<div class = "band-container">
											<!-- <li class = "band"> -->
											<!--	<p><?php the_sub_field('band'); ?></p>-->
											<!-- </li> -->
											<?php the_content(); ?>
											</div>
										<?php endwhile;?>
									<!--	</ul> -->
									<?php endif; ?>
								</div><!-- /text-column -->
						
							</div><!-- /column-container -->
						</article>
				</div>
	<?php endwhile;
		else:
			echo "<p> No content found</p>";
		endif;


get_footer();
?>