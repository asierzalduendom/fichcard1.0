<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link    https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package intecopress
 */
$intecopress_footer_widgets_enabled = get_theme_mod('designexo_footer_widgets_enabled', true);  
$intecopress_footer_container_size = get_theme_mod('designexo_footer_container_size', 'container');
$intecopress_footer_copright_enabled = get_theme_mod('designexo_footer_copright_enabled', true);
$intecopress_footer_copright_text = get_theme_mod('designexo_footer_copright_text', __('Copyright &copy; 2021 | Powered by <a href="//wordpress.org/">WordPress</a> <span class="sep"> | </span> IntecoPress theme by <a target="_blank" href="//themearile.com/">ThemeArile</a>', 'intecopress'));
$intecopress_scroll_to_top_enabled = get_theme_mod('designexo_scroll_to_top_enabled', true); 
?>
	<!--Footer-->
	<footer class="site-footer light">

	<?php if($intecopress_footer_widgets_enabled == true): ?>
		<div class="<?php echo esc_attr($intecopress_footer_container_size); ?>">
			<!--Footer Widgets-->			
			<div class="row footer-sidebar">
			   <?php get_template_part('sidebar','footer');?>
			</div>
		</div>
		<!--/Footer Widgets-->
	<?php endif; ?>		
		

    <?php if($intecopress_footer_copright_enabled == true): ?>
		<!--Site Info copyright-->
		<div class="site-info text-center">
			<?php echo wp_kses_post($intecopress_footer_copright_text); ?>				
		</div>
		<!--/Site Info copyright-->			
	<?php endif; ?>	
			
	</footer>
	<!--/Footer-->		
	<?php if($intecopress_scroll_to_top_enabled == true): ?>
		<!--Page Scroll to Top-->
		<div class="page-scroll-up"><a href="#totop"><i class="fa fa-angle-up"></i></a></div>
		<!--/Page Scroll to Top-->
    <?php endif; ?>	
	
<?php wp_footer(); ?>

</body>
</html>