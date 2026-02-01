<?php
/**
 * The template for displaying all single posts
 * @package HelpOfAi
 */
get_header();
?>

<main id="primary" class="site-main">
    <?php
    while ( have_posts() ) : the_post();
        
        get_template_part( 'template-parts/hero/single' );
        ?>

        <div class="container post-body-container">
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                
                <?php if ( has_post_thumbnail() ) : ?>
                    <div class="featured-image-container animate-entry" style="animation-delay: 0.2s;">
                        <?php the_post_thumbnail( 'full' ); ?>
                    </div>
                <?php endif; ?>

                <div class="post-layout-grid">
                    <div class="post-content-wrap">
                        <div class="post-content-body entry-content">
                            <?php
                            the_content();
                            wp_link_pages( array( 'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'helpofai' ), 'after'  => '</div>' ) );
                            ?>
                        </div>

                        <?php
                        // --- Related Posts ---
                        if ( get_option( 'helpofai_show_related_posts', 1 ) ) {
                            get_template_part( 'template-parts/post/related' );
                        }

                        // --- Post Navigation ---
                        if ( get_option( 'helpofai_show_post_nav', 1 ) ) {
                            the_post_navigation( array(
                                'class'     => 'post-navigation-modern',
                                'prev_text' => '<span class="nav-subtitle">Previous Post</span> <span class="nav-title">%title</span>',
                                'next_text' => '<span class="nav-subtitle">Next Post</span> <span class="nav-title">%title</span>',
                            ) );
                        }

                        // --- Comments ---
                        if ( comments_open() || get_comments_number() ) :
                            comments_template();
                        endif;
                        ?>
                    </div>

                    <aside class="post-sidebar">
                        <?php get_sidebar(); ?>
                    </aside>
                </div>

            </article>
        </div>
    <?php endwhile; ?>
</main>

<?php
get_footer();