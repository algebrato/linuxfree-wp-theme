<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package vantage
 * @since vantage 1.0
 * @license GPL 2.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css"/>
	<link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css"/> 

	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta http-equiv="X-UA-Compatible" content="IE=10" />
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php do_action('vantage_before_page_wrapper') ?>

<div id="page-wrapper">

	<?php do_action( 'vantage_before_masthead' ); ?>

	<?php get_template_part( 'parts/masthead', apply_filters( 'vantage_masthead_type', siteorigin_setting( 'layout_masthead' ) ) ); ?>

	<?php do_action( 'vantage_after_masthead' ); ?>

	<!--<?php vantage_render_slider() ?>-->
	<center>
		<div id="placeholder"></div>
		<script src="wp-content/themes/linuxfree-wp-theme/js/gol.js"></script>
	</center>


	<script>
	jQuery("#stop").click( function(){
		console.log("Stop");
		bbTerrarium.stop();
		jQuery("#stop").hide();
		jQuery("#go").show();

	});
	jQuery("#go").click( function(){
		console.log("Start");
		bbTerrarium.animate();
		jQuery("#stop").show();
		jQuery("#go").hide();
	});
	</script>

	<?php do_action( 'vantage_before_main_container' ); ?>

	<div id="main" class="site-main">
		<div class="full-container">
			<?php do_action( 'vantage_main_top' ); ?>
