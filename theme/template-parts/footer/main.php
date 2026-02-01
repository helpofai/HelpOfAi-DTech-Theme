<?php
/**
 * Main Footer Template Part
 */

$footer_about = get_option('helpofai_footer_about', 'HelpOfAi is your premier source for high-tech news and AI-driven insights.');
$logo_url     = get_option('helpofai_logo_url');
$social_fb    = get_option('helpofai_social_fb');
$social_tw    = get_option('helpofai_social_tw');
$social_li    = get_option('helpofai_social_li');
$social_ig    = get_option('helpofai_social_ig');
?>

<div class="footer-grid">
    <!-- Column 1: About -->
    <div class="footer-column">
        <?php if ($logo_url) : ?>
            <img src="<?php echo esc_url($logo_url); ?>" alt="Logo" class="footer-about-logo">
        <?php else : ?>
            <h3 class="footer-column-title"><?php bloginfo('name'); ?></h3>
        <?php endif; ?>
        
        <p class="footer-about-text"><?php echo esc_html($footer_about); ?></p>
        
        <div class="social-links">
            <?php if ($social_fb) : ?>
                <a href="<?php echo esc_url($social_fb); ?>" class="social-icon" target="_blank" aria-label="Facebook">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg>
                </a>
            <?php endif; ?>
            <?php if ($social_tw) : ?>
                <a href="<?php echo esc_url($social_tw); ?>" class="social-icon" target="_blank" aria-label="Twitter">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 4s-.7 2.1-2 3.4c1.6 10-9.4 17.3-18 11.6 2.2.1 4.4-.6 6-2C3 15.5.5 9.6 3 5c2.2 2.6 5.6 4.1 9 4-.9-4.2 4-6.6 7-3.8 1.1 0 3-1.2 3-1.2z"></path></svg>
                </a>
            <?php endif; ?>
            <?php if ($social_li) : ?>
                <a href="<?php echo esc_url($social_li); ?>" class="social-icon" target="_blank" aria-label="LinkedIn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"></path><rect x="2" y="9" width="4" height="12"></rect><circle cx="4" cy="4" r="2"></circle></svg>
                </a>
            <?php endif; ?>
            <?php if ($social_ig) : ?>
                <a href="<?php echo esc_url($social_ig); ?>" class="social-icon" target="_blank" aria-label="Instagram">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>
                </a>
            <?php endif; ?>
        </div>
    </div>

    <!-- Column 2: Quick Links -->
    <div class="footer-column">
        <h3 class="footer-column-title">Company</h3>
        <ul class="footer-links">
            <li><a href="<?php echo home_url('/about'); ?>">About Us</a></li>
            <li><a href="<?php echo home_url('/contact'); ?>">Contact</a></li>
            <li><a href="<?php echo home_url('/careers'); ?>">Careers</a></li>
            <li><a href="<?php echo home_url('/privacy-policy'); ?>">Privacy Policy</a></li>
        </ul>
    </div>

    <!-- Column 3: Topics -->
    <div class="footer-column">
        <h3 class="footer-column-title">Our Topics</h3>
        <ul class="footer-links">
            <?php
            $footer_cats = get_categories(array('number' => 4, 'orderby' => 'count', 'order' => 'DESC'));
            foreach ($footer_cats as $cat) {
                echo '<li><a href="' . get_category_link($cat->term_id) . '">' . $cat->name . '</a></li>';
            }
            ?>
        </ul>
    </div>

    <!-- Column 4: Support -->
    <div class="footer-column">
        <h3 class="footer-column-title">Support</h3>
        <ul class="footer-links">
            <li><a href="#">Help Center</a></li>
            <li><a href="#">Terms of Service</a></li>
            <li><a href="#">Documentation</a></li>
            <li><a href="mailto:info@helpofai.com">Email Support</a></li>
        </ul>
    </div>
</div>
