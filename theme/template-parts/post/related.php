<?php
/**
 * Related Posts Template Part
 */
$categories = get_the_category();
if ( $categories ) {
    $category_ids = array();
    foreach( $categories as $individual_category ) $category_ids[] = $individual_category->term_id;

    $args = array(
        'category__in'     => $category_ids,
        'post__not_in'     => array( get_the_ID() ),
        'posts_per_page'   => 3,
        'orderby'          => 'rand'
    );

    $related_query = new WP_Query( $args );

    if( $related_query->have_posts() ) {
        ?>
        <section class="related-posts-section">
            <h3 class="related-posts-title">You Might Also Like</h3>
            <div class="related-posts-grid">
                <?php while( $related_query->have_posts() ) : $related_query->the_post(); ?>
                    <article class="related-card">
                        <div class="related-card-image">
                            <?php if ( has_post_thumbnail() ) : ?>
                                <?php the_post_thumbnail('medium_large'); ?>
                            <?php else : ?>
                                <div style="width: 100%; height: 100%; background: var(--primary-gradient); opacity: 0.1;"></div>
                            <?php endif; ?>
                        </div>
                        <div class="related-card-content">
                            <span class="related-card-category"><?php echo $categories[0]->name; ?></span>
                            <h4 class="related-card-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h4>
                        </div>
                    </article>
                <?php endwhile; wp_reset_postdata(); ?>
            </div>
        </section>
        <?php
    }
}
