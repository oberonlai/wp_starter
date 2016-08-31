<!doctype html>
<html <?php language_attributes(); ?> itemscope="itemscope" itemtype="http://schema.org/WebPage">
	<head>
		<meta charset="UTF-8">
		<title itemprop="name"><?php getTitle(); ?></title>
		<link href="//www.google-analytics.com" rel="dns-prefetch">
        <link href="<?php echo get_template_directory_uri(); ?>/img/icons/favicon.ico" rel="shortcut icon">
        <link href="<?php echo get_template_directory_uri(); ?>/img/icons/touch.png" rel="apple-touch-icon-precomposed">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name='viewport' content='width=device-width, initial-scale=1.0'  />
		<meta name="description" content="<?php getDesp(); ?>">
		<?php getKeyword(); ?>
		<meta property="fb:app_id" content="" />
		<meta property="og:title" content="<?php getTitle(); ?>">
		<meta property="og:type" content="website">
		<meta property="og:url" content="<?php the_permalink();?>">
		<meta property="og:site_name" content="<?php echo get_bloginfo('title'); ?>">
		<meta property="og:description" content="<?php getDesp(); ?>">
		<meta property="og:image" content="<?php getImage(); ?>">
		<?php getAuthor(); ?>
		<?php wp_head(); ?>
		<?php wp_deregister_script('jquery'); ?>
	</head>
	<body <?php body_class(); ?>>
		<div class="wrapper">
			<header class="header clear" role="banner">
				<div class="logo">
					<a href="<?php echo home_url(); ?>">
						<img src="<?php echo get_template_directory_uri(); ?>/img/logo.svg" alt="Logo" class="logo-img">
					</a>
				</div>
				<nav class="nav" role="navigation">
					<?php header_menu(); ?>
				</nav>
			</header>