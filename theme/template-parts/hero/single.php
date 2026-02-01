<?php
/**
 * Single Post Hero Section
 */
$thumb_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
$hero_bg_style = !empty($thumb_url) ? 'background-image: url(' . esc_url($thumb_url) . '); background-size: cover; background-position: center;' : '';
?>
<header class="post-hero-section <?php echo get_option('helpofai_global_swarm_bg', 0) ? 'swarm-active' : ''; ?>" style="<?php echo esc_attr($hero_bg_style); ?>">
    <div class="hero-overlay"></div>
    <div class="container hero-container-single">
        <div class="post-hero-content animate-entry">
            <div class="post-meta-badge">
                <?php the_category(', '); ?>
            </div>
            
            <h1 class="post-title-main"><?php the_title(); ?></h1>
            
            <div class="post-meta-detailed">
                <div class="author-avatar-wrap">
                    <?php echo get_avatar( get_the_author_meta( 'ID' ), 48 ); ?>
                </div>
                <div class="meta-info-wrap">
                    <span class="meta-author">By <?php the_author(); ?></span>
                    <div class="meta-bottom">
                        <span class="meta-date"><?php echo get_the_date(); ?></span>
                        <span class="meta-divider">|</span>
                        <span class="meta-comments"><?php comments_number('No Comments', '1 Comment', '% Comments'); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
