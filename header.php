<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
		<meta charset="<?php bloginfo('charset'); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
		<title><?php bloginfo('name'); ?></title>
		<?php wp_head(); ?>
	
	</script>
	</head>
	
<body <?php body_class(); ?>>
	
	<!-- site-header -->
		<header class="site-header">
			<div class = "header">
				<div class = "title">
					<h1><a href="<?php echo home_url(); ?>"><?php bloginfo('name'); ?></a></h1>
					<h5><?php bloginfo('description'); ?></h5>
				</div>
				<div class = "search">
					<?php get_search_form(); ?>
				</div>
			</div>
			<div class = "navigation nav">
				<div class = "nav-container nav-home">
					<p><a class = "headline" href="<?php echo home_url(); ?>"> HOME </a></p>
				</div>
				<div class="nav-container nav-submit">
					<p><a class = "headline" href = "http://localhost/wordpress/submit-a-show/"> SUBMIT A SHOW </a></p>
				</div>
				<div class = "nav-container nav-about">
					<p><a class = "headline" href = "http://localhost/wordpress/about/"> ABOUT</a> </p>
				</div>
				<div class = "nav-container nav-calendar">
					<p><a class = "headline" href = "http://localhost/wordpress/calendar/"> CALENDAR </a></p>
				</div>
			</div>
		</header><!-- /site-header -->