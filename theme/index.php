<?php
/**
 * The main template file
 * @package HelpOfAi
 */
get_header();
?>

<main id="primary" class="site-main">

	<?php get_template_part( 'template-parts/hero/home' ); ?>

    <?php 
    if ( is_home() && !is_paged() && get_option( 'helpofai_show_home_categories', 1 ) ) {
        get_template_part( 'template-parts/home/categories' );
    }
    ?>

	<div class="container" id="latest">
		<div class="news-grid">
			<?php
			if ( have_posts() ) :
				while ( have_posts() ) : the_post();
					?>
					<article id="post-<?php the_ID(); ?>" <?php post_class( 'news-card' ); ?>>
						<div class="card-image">
							<?php if ( has_post_thumbnail() ) : ?>
								<?php the_post_thumbnail( 'large' ); ?>
							<?php else : ?>
								<div style="width: 100%; height: 100%; background: var(--primary-gradient); opacity: 0.1;"></div>
							<?php endif; ?>
						</div>
						<div class="card-content">
							<span class="card-meta"><?php echo get_the_date(); ?></span>
							<h3 class="card-title">
								<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
							</h3>
							<div class="card-excerpt" style="color: var(--text-muted); font-size: 0.95rem; margin-bottom: 1.5rem;">
								<?php echo wp_trim_words( get_the_excerpt(), 20 ); ?>
							</div>
							<a href="<?php the_permalink(); ?>" style="font-weight: 600; text-decoration: none; color: #6366f1;">Read More &rarr;</a>
						</div>
					</article>
					<?php
				endwhile;
				the_posts_navigation();
			else :
				echo '<p>No posts found.</p>';
			endif;
			?>
		</div>
	</div>

</main>

<?php
get_footer();