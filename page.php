<?php
get_header(); ?>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	<div class = "page-header">
		<h2><?php the_title() ;?></h2>
	</div>

	<div class = "content">	
		<?php the_content(); ?>
	</div>
<?php endwhile; else: ?>

	<p>Sorry, this page does not exist</p>

<?php endif; 

	
get_footer();
?>