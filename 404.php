<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package vantage
 * @since vantage 1.0
 * @license GPL 2.0
 */

get_header(); ?>

<div calss="container-fluid">
	<div class="row">	
		<h1 class="text-center text-danger" style="font-size: 600%; font-family: 'Open Sans'; " ><strong>404</strong></h1>
		<br>
		<center>
			<h1 class="text-center text-danger" style="font-size: 400%; font-family: 'Open Sans'; " ><strong>DON'T PANIC!</strong></h1>
		</center>
		<br>
	</div>

	<div class="row">
		<center>
			<img style="border-radius: 50%" src="http://linuxfree.ddns.net/wp-content/uploads/2016/06/Urlo-di-Munch-parodia.jpg">
		</center>
	</div>

	<div class="row">
		<div class="col-sm-4"></div>
		<div class="col-sm-4">
			<br>
			<a class="btn btn-primary btn-block" href="http://linuxfree.ddns.net">Home</a>
			<a class="btn btn-info btn-block" href="http://linuxfree.ddns.net">Send Batman-Request</a>
			<a class="btn btn-danger btn-block" href="http://linuxfree.ddns.net">Send ChuckNorris-Request</a>
		</div>
		<div class="col-sm-4"></div>
	</div>

</div>



<?php get_footer(); ?>
