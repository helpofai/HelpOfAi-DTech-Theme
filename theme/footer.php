<?php
/**
 * The template for displaying the footer
 * @package HelpOfAi
 */
?>

	<footer id="colophon" class="site-footer">
		<div class="container">
			
            <?php get_template_part( 'template-parts/footer/main' ); ?>

			<div class="footer-bottom">
				<?php 
                $footer_text = get_option('helpofai_footer_text');
                if ( ! empty( $footer_text ) ) : 
                    echo esc_html( $footer_text );
                else :
                ?>
                    <p>&copy; <?php echo date( 'Y' ); ?> rajib Adhikary. All rights reserved.</p>
                <?php endif; ?>
			</div>
		</div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>