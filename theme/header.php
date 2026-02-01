<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
    <?php
    // Check Sticky Header Option (default to true/1)
    $sticky_header = get_option( 'helpofai_sticky_header', 1 );
    
    // Get Colors
    $primary_start   = get_option( 'helpofai_color_primary_start', '#6366f1' );
    $primary_end     = get_option( 'helpofai_color_primary_end', '#a855f7' );
    $gradient_angle  = get_option( 'helpofai_gradient_angle', '135' );
    
    $secondary_start = get_option( 'helpofai_color_secondary_start', '#3b82f6' );
    $secondary_end   = get_option( 'helpofai_color_secondary_end', '#2dd4bf' );
    
    $glass_light = get_option( 'helpofai_glass_light', 'rgba(255, 255, 255, 0.7)' );
    $glass_dark  = get_option( 'helpofai_glass_dark', 'rgba(15, 23, 42, 0.7)' );
    
    $logo_url    = get_option( 'helpofai_logo_url' );
    $favicon_url = get_option( 'helpofai_favicon_url' );
    
    // Swarm BG Colors
    $swarm_bg_light = get_option( 'helpofai_swarm_bg_light', '#ffffff' );
    $swarm_bg_dark  = get_option( 'helpofai_swarm_bg_dark', '#020205' );
    
    // Layout Width
    $container_width = get_option( 'helpofai_container_width', '1200px' );
    ?>
    <style>
        :root {
            --primary-gradient: linear-gradient(<?php echo esc_attr( $gradient_angle ); ?>deg, <?php echo esc_attr( $primary_start ); ?> 0%, <?php echo esc_attr( $primary_end ); ?> 100%);
            --secondary-gradient: linear-gradient(135deg, <?php echo esc_attr( $secondary_start ); ?> 0%, <?php echo esc_attr( $secondary_end ); ?> 100%);
            --glass-bg: <?php echo esc_attr( $glass_light ); ?>;
            --swarm-bg: <?php echo esc_attr( $swarm_bg_light ); ?>;
            --container-width: <?php echo esc_attr( $container_width ); ?>;
        }
        
        html.dark-mode, body.dark-mode {
            --glass-bg: <?php echo esc_attr( $glass_dark ); ?>;
            --swarm-bg: <?php echo esc_attr( $swarm_bg_dark ); ?>;
        }
        
        a { color: <?php echo esc_attr( $primary_start ); ?>; }
        
        <?php if ( ! $sticky_header ) : ?>
        .site-header { position: relative !important; top: auto !important; }
        <?php endif; ?>
    </style>
    <?php if ( ! empty( $favicon_url ) ) : ?>
        <link rel="icon" href="<?php echo esc_url( $favicon_url ); ?>" type="image/x-icon" />
        <link rel="shortcut icon" href="<?php echo esc_url( $favicon_url ); ?>" type="image/x-icon" />
    <?php endif; ?>
</head>

<body <?php body_class( get_option( 'helpofai_global_swarm_bg', 0 ) ? 'has-global-swarm' : '' ); ?>>
<?php wp_body_open(); ?>

<?php if ( get_option( 'helpofai_global_swarm_bg', 0 ) ) : ?>
    <canvas id="global-swarm-canvas" style="position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; z-index: -1; pointer-events: none; background: var(--swarm-bg);"></canvas>
<?php endif; ?>

<div id="page" class="site">
	<header id="masthead" class="site-header">
		<?php 
        $header_layout = get_option( 'helpofai_header_layout', 'default' );
        $header_full   = get_option( 'helpofai_header_full_width', 0 );
        
        // Map layout to CSS class
        $layout_class = 'layout-default';
        if ( $header_layout === 'centered' ) $layout_class = 'layout-centered';
        if ( $header_layout === 'balanced' ) $layout_class = 'layout-balanced';
        
        // Container class
        $container_class = $header_full ? 'container-fluid' : 'container';
        ?>
        		<div class="<?php echo esc_attr( $container_class ); ?> header-inner <?php echo esc_attr( $layout_class ); ?>" style="<?php if($header_full) echo 'max-width: 100%; padding: 0 3rem;'; ?>">
        			<div class="site-branding">
                        <?php if ( ! empty( $logo_url ) ) : ?>
                            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                                <img src="<?php echo esc_url( $logo_url ); ?>" alt="<?php bloginfo( 'name' ); ?>" class="custom-logo" style="max-height: 40px; width: auto;">
                            </a>
                        <?php else : ?>
                            <?php
                            if ( is_front_page() && is_home() ) :
                                ?>
                                <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" class="text-gradient"><?php bloginfo( 'name' ); ?></a></h1>
                                <?php
                            else :
                                ?>
                                <p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" class="text-gradient"><?php bloginfo( 'name' ); ?></a></p>
                                <?php
                            endif;
                            ?>
                        <?php endif; ?>
        			</div><!-- .site-branding -->
        
        			<nav id="site-navigation" class="main-navigation" data-dropdown="<?php echo esc_attr( get_option( 'helpofai_dropdown_behavior', 'hover' ) ); ?>">				
                <?php
				wp_nav_menu( array(
					'theme_location' => 'menu-1',
					'menu_id'        => 'primary-menu',
				) );
				?>

                <!-- Mobile Action Buttons -->
                <div class="mobile-nav-actions">
                    <?php if ( is_user_logged_in() ) : ?>
                        <a href="<?php echo esc_url( admin_url() ); ?>" class="btn-dashboard">Dashboard</a>
                        <a href="<?php echo esc_url( wp_logout_url( home_url() ) ); ?>" class="btn-logout-mobile">Logout</a>
                    <?php else : ?>
                        <?php if ( get_option( 'helpofai_show_login_link', 1 ) ) : 
                            $login_url = get_option( 'helpofai_custom_login_url' ) ?: home_url( '/login' );
                        ?>
                            <a href="<?php echo esc_url( $login_url ); ?>" class="btn-login-mobile">Log In</a>
                        <?php endif; ?>
                        
                        <?php if ( get_option( 'helpofai_show_register_link', 1 ) ) : 
                            $register_url = get_option( 'helpofai_custom_register_url' ) ?: home_url( '/login' );
                        ?>
                            <a href="<?php echo esc_url( $register_url ); ?>" class="btn-register-mobile">Register</a>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
			</nav><!-- #site-navigation -->
            
            <div class="header-actions">
                <?php if ( is_user_logged_in() ) : ?>
                    <a href="<?php echo esc_url( admin_url() ); ?>" class="btn-dashboard">Dashboard</a>
                    <a href="<?php echo esc_url( wp_logout_url( home_url() ) ); ?>" class="btn-logout" title="Logout">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                    </a>
                <?php else : ?>
                    <?php if ( get_option( 'helpofai_show_login_link', 1 ) ) : 
                        $login_url = get_option( 'helpofai_custom_login_url' );
                        if ( empty( $login_url ) ) $login_url = home_url( '/login' );
                    ?>
                        <a href="<?php echo esc_url( $login_url ); ?>" class="btn-login">Log In</a>
                    <?php endif; ?>
                    
                    <?php if ( get_option( 'helpofai_show_register_link', 1 ) ) : 
                        $register_url = get_option( 'helpofai_custom_register_url' );
                        if ( empty( $register_url ) ) $register_url = home_url( '/login' );
                    ?>
                        <a href="<?php echo esc_url( $register_url ); ?>" class="btn-register">Register</a>
                    <?php endif; ?>
                <?php endif; ?>
                
                <?php if ( get_option( 'helpofai_dark_mode_active', 1 ) ) : ?>
                <button id="dark-mode-toggle" aria-label="Toggle Dark Mode" title="Toggle Dark Mode">
                    <i>🌙</i>
                </button>
                <?php endif; ?>

                <button id="mobile-menu-toggle" aria-label="Toggle Menu" title="Menu">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </div>
		</div>
	</header><!-- #masthead -->
