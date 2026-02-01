<?php
/**
 * The template for displaying archive pages
 * @package HelpOfAi
 */
get_header();
?>

<main id="primary" class="site-main">

	<header class="archive-header <?php echo get_option('helpofai_global_swarm_bg', 0 ) ? 'swarm-active' : ''; ?>">
		<div class="container archive-header-content animate-entry">
            <span class="archive-label">
                <?php 
                if ( is_category() ) echo 'Category';
                elseif ( is_tag() ) echo 'Tag';
                elseif ( is_author() ) echo 'Author';
                else echo 'Archive';
                ?>
            </span>
			<?php
			the_archive_title( '<h1 class="archive-title">', '</h1>' );
			the_archive_description( '<div class="archive-description">', '</div>' );
			?>
            <div class="archive-post-count">
                <?php echo $wp_query->found_posts; ?> Articles found
            </div>
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
                        echo '<p>No posts found in this category.</p>';
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