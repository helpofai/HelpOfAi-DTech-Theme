<?php
/**
 * Template part for displaying posts in a horizontal list format
 * @package HelpOfAi
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'archive-card glass-panel' ); ?>>
    <!-- Left Side: Thumbnail -->
    <div class="archive-card-image">
        <?php if ( has_post_thumbnail() ) : ?>
            <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'full' ); ?></a>
        <?php else : ?>
            <a href="<?php the_permalink(); ?>"><div class="thumb-placeholder"></div></a>
        <?php endif; ?>
    </div>
    
    <!-- Right Side: Content -->
    <div class="archive-card-content">
        <div class="archive-card-meta">
            <span class="cat-link"><?php the_category(', '); ?></span>
            <span class="meta-sep">•</span>
            <span class="date"><?php echo get_the_date(); ?></span>
        </div>
        
        <h3 class="archive-card-title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h3>
        
        <div class="archive-card-excerpt">
            <?php echo wp_trim_words( get_the_excerpt(), 25 ); ?>
        </div>
        
        <div class="archive-card-footer">
            <a href="<?php the_permalink(); ?>" class="btn-read-more">Read Article &rarr;</a>
        </div>
    </div>
</article>
