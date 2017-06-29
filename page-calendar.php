<?php
get_header(); 
?>


<div class = "banner">
</div>

<div class  = "content calendar">
	<?php 
		$curr = time();
		query_posts( array(
		'post_type'=>'post',
		'paged' => $paged,
	//	'meta_key'			=> 'time',
	/*	'orderby'			=> 'meta_value',
		'order'				=> 'ASC',
		'meta_query' => array(
			array(
				'key' => 'time',
				'compare' => '>=',
				'value' => $curr,
				)
			),*/
		)
     );
		if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<div class = "page-header">
				<h2><?php the_title() ;?></h2>
			</div>

		<div class = "content">	
			<?php the_content(); ?>
		</div>
	<?php endwhile; else: ?>

	<p>Sorry, this page does not exist</p>

<?php endif; 


	 ?>
	<div class = "sunday"></div>
	<div class = "monday"></div>
	<div class = "tuesday"></div>
	<div class = "wednesday"></div>
	<div class = "thursday"></div>
	<div class = "friday"></div>
	<div class = "saturday"></div>
</div>

<?php get_footer()?>