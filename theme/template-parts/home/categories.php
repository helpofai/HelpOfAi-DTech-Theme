<?php
/**
 * Home Page Categories Section Template
 */

$home_cats_title   = get_option('helpofai_home_cats_title', 'Explore by Category');
$home_cats_count   = get_option('helpofai_home_cats_count', 8);
$home_cats_orderby = get_option('helpofai_home_cats_orderby', 'count');

$categories = get_categories( array(
    'orderby'    => $home_cats_orderby,
    'order'      => 'DESC',
    'number'     => $home_cats_count,
    'hide_empty' => 0
) );

// Professional Color Palettes
$color_presets = array(
    array('color' => '#6366f1', 'grad' => 'linear-gradient(135deg, #6366f1 0%, #a855f7 100%)', 'glow' => 'rgba(99, 102, 241, 0.3)'), // Indigo
    array('color' => '#ef4444', 'grad' => 'linear-gradient(135deg, #ef4444 0%, #f97316 100%)', 'glow' => 'rgba(239, 68, 68, 0.3)'),  // Red/Orange
    array('color' => '#10b981', 'grad' => 'linear-gradient(135deg, #10b981 0%, #3b82f6 100%)', 'glow' => 'rgba(16, 185, 129, 0.3)'), // Emerald/Blue
    array('color' => '#f59e0b', 'grad' => 'linear-gradient(135deg, #f59e0b 0%, #d946ef 100%)', 'glow' => 'rgba(245, 158, 11, 0.3)'), // Amber/Pink
    array('color' => '#3b82f6', 'grad' => 'linear-gradient(135deg, #3b82f6 0%, #2dd4bf 100%)', 'glow' => 'rgba(59, 130, 246, 0.3)'), // Blue/Cyan
    array('color' => '#8b5cf6', 'grad' => 'linear-gradient(135deg, #8b5cf6 0%, #ec4899 100%)', 'glow' => 'rgba(139, 92, 246, 0.3)'), // Violet/Pink
    array('color' => '#06b6d4', 'grad' => 'linear-gradient(135deg, #06b6d4 0%, #3b82f6 100%)', 'glow' => 'rgba(6, 182, 212, 0.3)'), // Cyan/Blue
    array('color' => '#f43f5e', 'grad' => 'linear-gradient(135deg, #f43f5e 0%, #fbbf24 100%)', 'glow' => 'rgba(244, 63, 94, 0.3)'),  // Rose/Yellow
);

if ( ! empty( $categories ) ) :
?>
    <section class="home-categories-section animate-entry">
        <div class="container">
            <div class="section-title-wrap">
                <h2 class="section-title"><?php echo esc_html($home_cats_title); ?></h2>
            </div>

            <div class="categories-grid">
                <?php 
                $i = 0;
                foreach ( $categories as $category ) : 
                    $preset = $color_presets[$i % count($color_presets)];
                    
                    $icon = 'dashicons-category';
                    $slug = strtolower($category->slug);
                    if (strpos($slug, 'tech') !== false) $icon = 'dashicons-laptop';
                    elseif (strpos($slug, 'news') !== false) $icon = 'dashicons-megaphone';
                    elseif (strpos($slug, 'business') !== false) $icon = 'dashicons-chart-bar';
                    elseif (strpos($slug, 'design') !== false) $icon = 'dashicons-art';
                    elseif (strpos($slug, 'video') !== false) $icon = 'dashicons-video-alt3';
                    elseif (strpos($slug, 'ai') !== false) $icon = 'dashicons-brain';
                ?>
                    <a href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>" 
                       class="category-card" 
                       style="--cat-color: <?php echo $preset['color']; ?>; 
                              --cat-gradient: <?php echo $preset['grad']; ?>; 
                              --cat-glow: <?php echo $preset['glow']; ?>;">
                        
                        <div class="cat-card-icon">
                            <span class="dashicons <?php echo $icon; ?>"></span>
                        </div>
                        <h3 class="cat-card-title"><?php echo esc_html( $category->name ); ?></h3>
                        <p class="cat-card-desc">
                            <?php 
                            $desc = category_description($category->term_id);
                            echo $desc ? wp_trim_words($desc, 8) : 'Insights about ' . $category->name . '.';
                            ?>
                        </p>
                        <div class="cat-card-count">
                            <?php echo $category->count; ?> Posts
                        </div>
                    </a>
                <?php $i++; endforeach; ?>
            </div>
        </div>
    </section>
<?php endif; ?>
