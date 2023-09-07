<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Martfury
 */
global $wp;
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	
	<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>
	<?php 
	$request =  $wp->request;
	if (strpos($request, 'dashboard') !== false || strpos($request, 'my-account') !== false || strpos($request, 'cart') !== false || strpos($request, 'checkout') !== false  ) {
		echo '<div id="mediavine-settings" data-blocklist-all="1" data-expires-at="2025-11-14"></div>';
	}
	if (strpos($request, 'plant-care') !== false  ) {
		//echo '<div id="mediavine-settings" data-blocklist-content-mobile="1" data-expires-at="2022-11-14"></div>';
	}
	if(is_post_type_archive('product') || is_tax('product_cat') || is_tax('product_tag')){
		echo '<div id="mediavine-settings" data-blocklist-content-mobile="1" data-expires-at="2022-11-14"></div>';
	}
	?>
<?php martfury_body_open(); ?>
<div id="page" class="hfeed site">

	<?php if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'header' ) ) {
		?>
		<?php do_action( 'martfury_before_header' ); ?>
        <header id="site-header" class="site-header <?php martfury_header_class(); ?>">
			<?php do_action( 'martfury_header' ); ?>
			<?php if($wp->request == 'plant-care' || is_singular('post')){ ?>
				<div class="search-trigger">
					<i class="fa fa-search"></i>
				</div>
				<div id="below-header-widget" class="sidebar">
					<div class="container">
						
						<div class="close">
							<i class="fa fa-times"></i>
						</div>
						<?php dynamic_sidebar( 'blog-below-header' ); ?>
					</div>
				</div>
			<?php } ?>
        </header>
	<?php } ?>
	<?php do_action( 'martfury_after_header' ); ?>

    <div id="content" class="site-content">
		<?php do_action( 'martfury_after_site_content_open' ); ?>
