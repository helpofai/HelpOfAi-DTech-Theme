<?php
/**
 * The template for displaying the main blog index (Blog Page)
 * @package HelpOfAi
 */
get_header();
?>

<main id="primary" class="site-main">

	<header class="archive-header <?php echo get_option('helpofai_global_swarm_bg', 0 ) ? 'swarm-active' : ''; ?>">
		<div class="container archive-header-content animate-entry">
            <span class="archive-label">Blog</span>
			<h1 class="archive-title"><?php echo get_the_title( get_option('page_for_posts') ) ?: 'Latest Articles'; ?></h1>
            <p class="archive-description">Discover our latest insights, tutorials, and news about AI and technology.</p>
		</div>
	</header>

	<div class="container archive-container">
        <div class="archive-layout-grid">
            <div class="archive-content-area">
                <div class="archive-posts-grid">
                    <?php
                    if ( have_posts() ) :
                        while ( have_posts() ) : the_post();
                            get_template_part( 'template-parts/post/content-list' );
                        endwhile;
                        
                        the_posts_navigation( array(
                            'prev_text' => '&larr; Older Posts',
                            'next_text' => 'Newer Posts &rarr;',
                        ) );
                        
                    else :
                        echo '<p>No posts found.</p>';
                    endif;
                    ?>
                </div>
            </div>

            <aside class="archive-sidebar">
                <?php get_sidebar(); ?>
            </aside>
        </div>
	</div>

</main>

<?php
get_footer();
