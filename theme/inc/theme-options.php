<?php
/**
 * HelpOfAi Theme Options (Advanced Tabbed UI)
 *
 * @package HelpOfAi
 */

function helpofai_add_admin_menu() {
    add_menu_page(
        'HelpOfAi Settings',
        'HelpOfAi Options',
        'manage_options',
        'helpofai-options',
        'helpofai_options_page_html',
        'dashicons-art',
        60
    );
}
add_action( 'admin_menu', 'helpofai_add_admin_menu' );

// Enqueue WordPress Media Uploader
function helpofai_admin_scripts() {
    if ( isset($_GET['page']) && $_GET['page'] === 'helpofai-options' ) {
        wp_enqueue_media();
    }
}
add_action( 'admin_enqueue_scripts', 'helpofai_admin_scripts' );

function helpofai_settings_init() {
    register_setting( 'helpofai_options_group', 'helpofai_dark_mode_active' );
    register_setting( 'helpofai_options_group', 'helpofai_container_width' ); // New
    register_setting( 'helpofai_options_group', 'helpofai_global_swarm_bg' );
    register_setting( 'helpofai_options_group', 'helpofai_swarm_bg_light' ); // New
    register_setting( 'helpofai_options_group', 'helpofai_swarm_bg_dark' );  // New
    register_setting( 'helpofai_options_group', 'helpofai_login_swarm_bg' );
    register_setting( 'helpofai_options_group', 'helpofai_sticky_header' );
    register_setting( 'helpofai_options_group', 'helpofai_header_full_width' ); // New
    register_setting( 'helpofai_options_group', 'helpofai_header_layout' );
    register_setting( 'helpofai_options_group', 'helpofai_show_login_link' );
    register_setting( 'helpofai_options_group', 'helpofai_show_register_link' );
    register_setting( 'helpofai_options_group', 'helpofai_custom_login_url' );
    register_setting( 'helpofai_options_group', 'helpofai_custom_register_url' );
    // Logo & Favicon
    register_setting( 'helpofai_options_group', 'helpofai_logo_url' );
    register_setting( 'helpofai_options_group', 'helpofai_favicon_url' );
    // Dropdown Behavior
    register_setting( 'helpofai_options_group', 'helpofai_dropdown_behavior' ); // New
    register_setting( 'helpofai_options_group', 'helpofai_footer_text' );
    
    // Hero Section
    register_setting( 'helpofai_options_group', 'helpofai_hero_enable' );
    register_setting( 'helpofai_options_group', 'helpofai_hero_swarm_bg' ); // New
    register_setting( 'helpofai_options_group', 'helpofai_show_home_categories' );
    register_setting( 'helpofai_options_group', 'helpofai_home_cats_title' ); // New
    register_setting( 'helpofai_options_group', 'helpofai_home_cats_count' ); // New
    register_setting( 'helpofai_options_group', 'helpofai_home_cats_orderby' ); // New
    register_setting( 'helpofai_options_group', 'helpofai_hero_title' );
    register_setting( 'helpofai_options_group', 'helpofai_hero_subtitle' );
    register_setting( 'helpofai_options_group', 'helpofai_hero_btn_text' );
    register_setting( 'helpofai_options_group', 'helpofai_hero_btn_url' );
    register_setting( 'helpofai_options_group', 'helpofai_hero_bg_image' );
    register_setting( 'helpofai_options_group', 'helpofai_hero_overlay_opacity' );
    
    // Single Page Settings
    register_setting( 'helpofai_options_group', 'helpofai_show_related_posts' );
    register_setting( 'helpofai_options_group', 'helpofai_show_post_nav' );
}
add_action( 'admin_init', 'helpofai_settings_init' );

function helpofai_options_page_html() {
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }
    
    // Get saved values
    $dark_mode = get_option('helpofai_dark_mode_active', 1);
    $container_width = get_option('helpofai_container_width', '1200px');
    $global_swarm = get_option('helpofai_global_swarm_bg', 0);
    $swarm_bg_light = get_option('helpofai_swarm_bg_light', '#ffffff');
    $swarm_bg_dark = get_option('helpofai_swarm_bg_dark', '#020205');
    $login_swarm = get_option('helpofai_login_swarm_bg', 0);
    $sticky_header = get_option('helpofai_sticky_header', 1);
    $header_full_width = get_option('helpofai_header_full_width', 0);
    $header_layout = get_option('helpofai_header_layout', 'default');
    $show_login = get_option('helpofai_show_login_link', 1);
    $show_register = get_option('helpofai_show_register_link', 1);
    $custom_login_url = get_option('helpofai_custom_login_url', '');
    $custom_register_url = get_option('helpofai_custom_register_url', '');
    
    $logo_url = get_option('helpofai_logo_url', '');
    $favicon_url = get_option('helpofai_favicon_url', '');
    $dropdown_behavior = get_option('helpofai_dropdown_behavior', 'hover');
    
    // Single Page Settings
    $show_related = get_option('helpofai_show_related_posts', 1);
    $show_nav = get_option('helpofai_show_post_nav', 1);
    
    $footer_text = get_option('helpofai_footer_text', '');
    
    // Hero Defaults
    $hero_enable = get_option('helpofai_hero_enable', 1);
    $hero_swarm = get_option('helpofai_hero_swarm_bg', 0);
    $show_home_cats = get_option('helpofai_show_home_categories', 1);
    $home_cats_title = get_option('helpofai_home_cats_title', 'Explore by Category');
    $home_cats_count = get_option('helpofai_home_cats_count', 8);
    $home_cats_orderby = get_option('helpofai_home_cats_orderby', 'count');
    
    $hero_title = get_option('helpofai_hero_title', 'Discover the Future of Technology');
    $hero_subtitle = get_option('helpofai_hero_subtitle', 'Insights powered by artificial intelligence and expert analysis.');
    $hero_btn_text = get_option('helpofai_hero_btn_text', 'Start Reading');
    $hero_btn_url = get_option('helpofai_hero_btn_url', '#latest');
    $hero_bg_image = get_option('helpofai_hero_bg_image', '');
    $hero_overlay = get_option('helpofai_hero_overlay_opacity', '0.2');
    
    // Primary Colors
    $primary_start = get_option('helpofai_color_primary_start', '#6366f1');
    $primary_end = get_option('helpofai_color_primary_end', '#a855f7');
    $gradient_angle = get_option('helpofai_gradient_angle', '135');
    
    // Secondary Colors
    $secondary_start = get_option('helpofai_color_secondary_start', '#3b82f6');
    $secondary_end = get_option('helpofai_color_secondary_end', '#2dd4bf');
    
    $glass_light = get_option('helpofai_glass_light', 'rgba(255, 255, 255, 0.7)');
    $glass_dark = get_option('helpofai_glass_dark', 'rgba(15, 23, 42, 0.7)');
    
    $color_accent = get_option('helpofai_color_accent', '#3b82f6');
    ?>
    <div class="wrap helpofai-admin-wrap">
        <h1>HelpOfAi Settings</h1>
        
        <div class="helpofai-tabs-container">
            <!-- Left Sidebar Navigation -->
            <ul class="helpofai-tabs-nav">
                <li class="active" data-tab="tab-general">
                    <span class="dashicons dashicons-admin-generic"></span> General
                </li>
                <li data-tab="tab-home">
                    <span class="dashicons dashicons-admin-home"></span> Home Page
                </li>
                <li data-tab="tab-single">
                    <span class="dashicons dashicons-media-text"></span> Single Page
                </li>
                <li data-tab="tab-header">
                    <span class="dashicons dashicons-align-center"></span> Header
                </li>
                <li data-tab="tab-colors">
                    <span class="dashicons dashicons-color-picker"></span> Colors & Gradients
                </li>
                <li data-tab="tab-appearance">
                    <span class="dashicons dashicons-desktop"></span> Appearance
                </li>
                <li data-tab="tab-footer">
                    <span class="dashicons dashicons-editor-insertmore"></span> Footer
                </li>
            </ul>

            <!-- Right Content Area -->
            <div class="helpofai-tabs-content">
                <form action="options.php" method="post">
                    <?php settings_fields( 'helpofai_options_group' ); ?>

                    <!-- Tab: General -->
                    <div id="tab-general" class="tab-pane active">
                        <h2>General Settings</h2>
                        <hr>
                        <table class="form-table">
                            <tr>
                                <th scope="row">Site Layout Width</th>
                                <td>
                                    <select name="helpofai_container_width">
                                        <option value="1140px" <?php selected('1140px', $container_width); ?>>Standard (1140px)</option>
                                        <option value="1320px" <?php selected('1320px', $container_width); ?>>Wide (1320px)</option>
                                        <option value="1600px" <?php selected('1600px', $container_width); ?>>Extra Wide (1600px)</option>
                                        <option value="100%" <?php selected('100%', $container_width); ?>>Full Screen (100%)</option>
                                    </select>
                                    <p class="description">Choose how much of the screen the content should occupy.</p>
                                </td>
                            </tr>
                        </table>
                        <p>Welcome to the HelpOfAi settings panel. Select a category from the left to begin customizing.</p>
                    </div>

                    <!-- Tab: Home Page -->
                    <div id="tab-home" class="tab-pane">
                        <div class="settings-group">
                            <h3 class="group-title"><span class="dashicons dashicons-format-image"></span> Hero Section Settings</h3>
                            <table class="form-table">
                                <tr>
                                    <th scope="row">Enable Hero Section</th>
                                    <td>
                                        <label class="switch">
                                            <input type="checkbox" name="helpofai_hero_enable" value="1" <?php checked(1, $hero_enable); ?>>
                                            <span class="slider round"></span>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Use Swarm Background</th>
                                    <td>
                                        <label class="switch">
                                            <input type="checkbox" name="helpofai_hero_swarm_bg" value="1" <?php checked(1, $hero_swarm); ?>>
                                            <span class="slider round"></span>
                                        </label>
                                        <p class="description">Use the Bioluminescent Swarm engine as the background for the Hero section.</p>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Hero Title</th>
                                    <td><input type="text" name="helpofai_hero_title" value="<?php echo esc_attr($hero_title); ?>" class="large-text"></td>
                                </tr>
                                <tr>
                                    <th scope="row">Hero Subtitle</th>
                                    <td><textarea name="helpofai_hero_subtitle" class="large-text" rows="2"><?php echo esc_textarea($hero_subtitle); ?></textarea></td>
                                </tr>
                                <tr>
                                    <th scope="row">Button Text</th>
                                    <td><input type="text" name="helpofai_hero_btn_text" value="<?php echo esc_attr($hero_btn_text); ?>" class="regular-text"></td>
                                </tr>
                                <tr>
                                    <th scope="row">Button URL</th>
                                    <td><input type="text" name="helpofai_hero_btn_url" value="<?php echo esc_attr($hero_btn_url); ?>" class="regular-text"></td>
                                </tr>
                                <tr>
                                    <th scope="row">Background Image</th>
                                    <td>
                                        <input type="text" name="helpofai_hero_bg_image" id="helpofai_hero_bg_image" value="<?php echo esc_attr($hero_bg_image); ?>" class="regular-text">
                                        <button type="button" class="button helpofai-upload-btn" data-target="helpofai_hero_bg_image">Upload Image</button>
                                        <?php if($hero_bg_image): ?><br><img src="<?php echo esc_url($hero_bg_image); ?>" style="max-height: 100px; margin-top: 10px;"><?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Overlay Opacity</th>
                                    <td>
                                        <input type="range" min="0" max="1" step="0.1" name="helpofai_hero_overlay_opacity" value="<?php echo esc_attr($hero_overlay); ?>" oninput="this.nextElementSibling.value = this.value">
                                        <output><?php echo esc_attr($hero_overlay); ?></output>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <div class="settings-group" style="margin-top: 3rem; padding-top: 2rem; border-top: 1px solid #e5e7eb;">
                            <h3 class="group-title"><span class="dashicons dashicons-category"></span> Categories Grid Settings</h3>
                            <table class="form-table">
                                <tr>
                                    <th scope="row">Show Categories Grid</th>
                                    <td>
                                        <label class="switch">
                                            <input type="checkbox" name="helpofai_show_home_categories" value="1" <?php checked(1, $show_home_cats); ?>>
                                            <span class="slider round"></span>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Categories Section Title</th>
                                    <td><input type="text" name="helpofai_home_cats_title" value="<?php echo esc_attr($home_cats_title); ?>" class="regular-text"></td>
                                </tr>
                                <tr>
                                    <th scope="row">Number of Categories</th>
                                    <td><input type="number" name="helpofai_home_cats_count" value="<?php echo esc_attr($home_cats_count); ?>" class="small-text" min="1" max="20"></td>
                                </tr>
                                <tr>
                                    <th scope="row">Order Categories By</th>
                                    <td>
                                        <select name="helpofai_home_cats_orderby">
                                            <option value="count" <?php selected('count', $home_cats_orderby); ?>>Post Count (Most Popular)</option>
                                            <option value="name" <?php selected('name', $home_cats_orderby); ?>>Name (Alphabetical)</option>
                                            <option value="slug" <?php selected('slug', $home_cats_orderby); ?>>Slug</option>
                                        </select>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <!-- Tab: Single Page -->
                    <div id="tab-single" class="tab-pane">
                        <h2>Single Post Settings</h2>
                        <hr>
                        <table class="form-table">
                            <tr>
                                <th scope="row">Show Related Posts</th>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="helpofai_show_related_posts" value="1" <?php checked(1, $show_related); ?>>
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Show Post Navigation</th>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="helpofai_show_post_nav" value="1" <?php checked(1, $show_nav); ?>>
                                        <span class="slider round"></span>
                                    </label>
                                    <p class="description">Enable Previous and Next post links.</p>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <!-- Tab: Single Page -->
                    <div id="tab-single" class="tab-pane">
                        <h2>Single Post Settings</h2>
                        <hr>
                        <table class="form-table">
                            <tr>
                                <th scope="row">Show Related Posts</th>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="helpofai_show_related_posts" value="1" <?php checked(1, $show_related); ?>>
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Show Post Navigation</th>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="helpofai_show_post_nav" value="1" <?php checked(1, $show_nav); ?>>
                                        <span class="slider round"></span>
                                    </label>
                                    <p class="description">Enable Previous and Next post links.</p>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <!-- Tab: Header -->
                    <div id="tab-header" class="tab-pane">
                        <h2>Header Settings</h2>
                        <hr>
                        <table class="form-table">
                            <tr>
                                <th scope="row">Header Layout</th>
                                <td>
                                    <fieldset>
                                        <label><input type="radio" name="helpofai_header_layout" value="default" <?php checked('default', $header_layout); ?>> Default</label><br>
                                        <label><input type="radio" name="helpofai_header_layout" value="centered" <?php checked('centered', $header_layout); ?>> Centered</label><br>
                                        <label><input type="radio" name="helpofai_header_layout" value="balanced" <?php checked('balanced', $header_layout); ?>> Balanced</label>
                                    </fieldset>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Sticky Header</th>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="helpofai_sticky_header" value="1" <?php checked(1, $sticky_header); ?>>
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Full Width Header</th>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="helpofai_header_full_width" value="1" <?php checked(1, $header_full_width); ?>>
                                        <span class="slider round"></span>
                                    </label>
                                    <p class="description">Ignore the site width setting and make the header span edge-to-edge.</p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Dropdown Behavior</th>
                            <tr>
                                <th scope="row">Show Login Button</th>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="helpofai_show_login_link" value="1" <?php checked(1, $show_login); ?>>
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Custom Login URL</th>
                                <td>
                                    <input type="text" name="helpofai_custom_login_url" value="<?php echo esc_attr($custom_login_url); ?>" class="regular-text" placeholder="https://...">
                                    <p class="description">Leave empty to use default.</p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Show Register Button</th>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="helpofai_show_register_link" value="1" <?php checked(1, $show_register); ?>>
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Custom Register URL</th>
                                <td>
                                    <input type="text" name="helpofai_custom_register_url" value="<?php echo esc_attr($custom_register_url); ?>" class="regular-text" placeholder="https://...">
                                    <p class="description">Leave empty to use default.</p>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <!-- Tab: Colors -->
                    <div id="tab-colors" class="tab-pane">
                        <h2>Gradients & Colors</h2>
                        <p class="description">Create beautiful linear gradients for your theme.</p>
                        <hr>
                        
                        <h3>Primary Gradient</h3>
                        <table class="form-table">
                            <tr>
                                <th scope="row">Start Color</th>
                                <td><input type="color" name="helpofai_color_primary_start" value="<?php echo esc_attr($primary_start); ?>"></td>
                            </tr>
                            <tr>
                                <th scope="row">End Color</th>
                                <td><input type="color" name="helpofai_color_primary_end" value="<?php echo esc_attr($primary_end); ?>"></td>
                            </tr>
                            <tr>
                                <th scope="row">Gradient Angle (Deg)</th>
                                <td>
                                    <input type="range" min="0" max="360" name="helpofai_gradient_angle" value="<?php echo esc_attr($gradient_angle); ?>" oninput="this.nextElementSibling.value = this.value">
                                    <output><?php echo esc_attr($gradient_angle); ?></output>°
                                </td>
                            </tr>
                        </table>

                        <hr>
                        <h3>Secondary Gradient</h3>
                        <table class="form-table">
                            <tr>
                                <th scope="row">Start Color</th>
                                <td><input type="color" name="helpofai_color_secondary_start" value="<?php echo esc_attr($secondary_start); ?>"></td>
                            </tr>
                            <tr>
                                <th scope="row">End Color</th>
                                <td><input type="color" name="helpofai_color_secondary_end" value="<?php echo esc_attr($secondary_end); ?>"></td>
                            </tr>
                        </table>

                        <hr>
                        <h3>Smart Glass Transparency</h3>
                        <table class="form-table">
                            <tr>
                                <th scope="row">Light Theme Glass</th>
                                <td>
                                    <input type="text" name="helpofai_glass_light" value="<?php echo esc_attr($glass_light); ?>" class="regular-text">
                                    <p class="description">Use RGBA format (e.g. rgba(255,255,255,0.7)) for the light mode background.</p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Dark Theme Glass</th>
                                <td>
                                    <input type="text" name="helpofai_glass_dark" value="<?php echo esc_attr($glass_dark); ?>" class="regular-text">
                                    <p class="description">Use RGBA format (e.g. rgba(15,23,42,0.7)) for the dark mode background.</p>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <!-- Tab: Appearance -->
                    <div id="tab-appearance" class="tab-pane">
                        <h2>Appearance</h2>
                        <hr>
                        <table class="form-table">
                            <tr>
                                <th scope="row">Dark Mode Toggle</th>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="helpofai_dark_mode_active" value="1" <?php checked(1, $dark_mode); ?>>
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Global Swarm Background</th>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="helpofai_global_swarm_bg" value="1" <?php checked(1, $global_swarm); ?>>
                                        <span class="slider round"></span>
                                    </label>
                                    <p class="description">Enable the interactive swarm background across the entire theme.</p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Swarm BG (Light Mode)</th>
                                <td><input type="color" name="helpofai_swarm_bg_light" value="<?php echo esc_attr($swarm_bg_light); ?>"></td>
                            </tr>
                            <tr>
                                <th scope="row">Swarm BG (Dark Mode)</th>
                                <td><input type="color" name="helpofai_swarm_bg_dark" value="<?php echo esc_attr($swarm_bg_dark); ?>"></td>
                            </tr>
                            <tr>
                                <th scope="row">Use Swarm Background (Login)</th>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="helpofai_login_swarm_bg" value="1" <?php checked(1, $login_swarm); ?>>
                                        <span class="slider round"></span>
                                    </label>
                                    <p class="description">Use the Bioluminescent Swarm engine as the background for the Login page.</p>
                                </td>
                            </tr>
                        </table>
                    </div>
                    
                    <!-- Tab: Footer -->
                    <div id="tab-footer" class="tab-pane">
                        <h2>Footer Options</h2>
                        <hr>
                        <table class="form-table">
                            <tr>
                                <th scope="row">Custom Copyright Text</th>
                                <td><input type="text" name="helpofai_footer_text" value="<?php echo esc_attr($footer_text); ?>" class="regular-text"></td>
                            </tr>
                        </table>
                    </div>

                    <div class="helpofai-actions">
                        <?php submit_button( 'Save Changes' ); ?>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        .helpofai-admin-wrap { margin-top: 2rem; }
        .helpofai-tabs-container { display: flex; background: #fff; border: 1px solid #ccd0d4; min-height: 500px; margin-top: 1rem; }
        .helpofai-tabs-nav { width: 220px; background: #f3f4f6; margin: 0; border-right: 1px solid #ccd0d4; flex-shrink: 0; }
        .helpofai-tabs-nav li { padding: 15px 20px; cursor: pointer; border-bottom: 1px solid #e5e7eb; display: flex; align-items: center; gap: 10px; }
        .helpofai-tabs-nav li.active { background: #fff; color: #6366f1; border-left: 4px solid #6366f1; }
        .helpofai-tabs-content { flex-grow: 1; padding: 2rem; }
        .tab-pane { display: none; }
        .tab-pane.active { display: block; }
        .helpofai-actions { margin-top: 2rem; padding-top: 1rem; border-top: 1px solid #e5e7eb; }
        .switch { position: relative; display: inline-block; width: 50px; height: 24px; }
        .switch input { opacity: 0; width: 0; height: 0; }
        .slider { position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #cbd5e1; transition: .4s; border-radius: 34px; }
        .slider:before { position: absolute; content: ""; height: 16px; width: 16px; left: 4px; bottom: 4px; background-color: white; transition: .4s; border-radius: 50%; }
        input:checked + .slider { background-color: #6366f1; }
        input:checked + .slider:before { transform: translateX(26px); }
        input[type="range"] { vertical-align: middle; }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Tabs Logic
            const tabs = document.querySelectorAll('.helpofai-tabs-nav li');
            const panes = document.querySelectorAll('.tab-pane');
            tabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    tabs.forEach(t => t.classList.remove('active'));
                    panes.forEach(p => p.classList.remove('active'));
                    this.classList.add('active');
                    document.getElementById(this.getAttribute('data-tab')).classList.add('active');
                });
            });

            // Media Uploader Logic
            jQuery(document).ready(function($){
                $('.helpofai-upload-btn').click(function(e) {
                    e.preventDefault();
                    var button = $(this);
                    var targetId = button.data('target');
                    
                    var custom_uploader = wp.media({
                        title: 'Select Logo or Favicon',
                        button: {
                            text: 'Use this image'
                        },
                        library: {
                            type: [ 'image', 'image/svg+xml', 'image/webp' ]
                        },
                        multiple: false
                    })
                    .on('select', function() {
                        var attachment = custom_uploader.state().get('selection').first().toJSON();
                        $('#' + targetId).val(attachment.url);
                        // Optional: Update preview immediately
                    })
                    .open();
                });
            });
        });
    </script>
    <?php
}