<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package Martfury
 */



get_header();

$img = martfury_get_option( 'not_found_img' );

if ( ! $img ) {
	$img = get_home_url() . '/wp-content/uploads/2020/09/Plantly-404-v2-8bit-e1599699876951.jpg';
}

?>

<div id="primary" class="content-area yikes">
	<main id="main" class="site-main">

		<section class="error-404 not-found">
			<div class="page-content col-md-12 col-xs-12 col-sm-12">
				<h1 class="page-title yikes"><?php esc_html_e( '404', 'martfury' ); ?></h1>
				<h3 class="page-title"><?php esc_html_e( 'This is not the plant you are looking for...', 'martfury' ); ?></h3>
				<?php printf( '<img src="%s" alt="%s">', esc_url($img), esc_attr__( 'ohh! page not found', 'martfury' )); ?>
			<p>
					<?php esc_html_e( " Perhaps searching can help or we'd love for you to ", 'martfury' ); ?>
					<a href="<?php echo esc_url( home_url( '/sell-with-us' ) ); ?>"><?php esc_html_e( 'join us', 'martfury' ); ?></a>
				</p>

				<h3 style="text-align: center;">You are one button away from finding the plant you seek:<h3>
<p class="popmake-5366" style="background:#00a651; padding:10px; border-radius: 5px;  color: #fff; width:fit-content; margin: 0 auto; ">Launch Product Finder</p>

			</div>
			<!-- .page-content -->
		</section>
		<!-- .error-404 -->

	</main>
	<!-- #main -->
</div><!-- #primary -->

<?php get_footer(); ?>
