	<footer id="colophon" class="site-footer">
		<div class="container">
			<div class="footer-grid">
				<div class="footer-widget">
					<h3 class="footer-heading"><?php bloginfo( 'name' ); ?></h3>
					<p><?php bloginfo( 'description' ); ?></p>
				</div>
				<div class="footer-widget">
					<h3 class="footer-heading">Quick Links</h3>
					<?php
					wp_nav_menu( array(
						'theme_location' => 'menu-1',
						'menu_class'     => 'footer-links',
						'container'      => false,
					) );
					?>
				</div>
				<div class="footer-widget">
					<h3 class="footer-heading">Contact</h3>
					<p>Email: info@helpofai.com</p>
				</div>
			</div>

			<div class="footer-bottom">
				<p>&copy; <?php echo date( 'Y' ); ?> rajib Adhikary. All rights reserved.</p>
			</div>
		</div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
