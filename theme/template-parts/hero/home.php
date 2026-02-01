<?php
/**
 * Home Page Hero Section
 */
$hero_enable   = get_option( 'helpofai_hero_enable', 1 );
$hero_swarm    = get_option( 'helpofai_hero_swarm_bg', 0 );
$hero_title    = get_option( 'helpofai_hero_title', 'Discover the Future of Technology and News' );
$hero_subtitle = get_option( 'helpofai_hero_subtitle', 'HelpOfAi brings you the latest insights, powered by artificial intelligence and expert analysis.' );
$hero_btn_text = get_option( 'helpofai_hero_btn_text', 'Start Reading' );
$hero_btn_url  = get_option( 'helpofai_hero_btn_url', '#latest' );
$hero_bg_image = get_option( 'helpofai_hero_bg_image', '' );
$hero_overlay  = get_option( 'helpofai_hero_overlay_opacity', '0.2' );

$hero_style = !empty($hero_bg_image) ? 'background-image: url(' . esc_url($hero_bg_image) . '); background-size: cover; background-position: center;' : '';

if ( (is_home() || is_front_page()) && !is_paged() && $hero_enable ) : 
?>
    <section class="hero-section" id="hero-swarm-container" style="<?php echo esc_attr($hero_style); ?>">
        <?php if ($hero_swarm) : ?>
            <canvas id="hero-swarm-canvas" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 0; background: #020205;"></canvas>
        <?php elseif (!empty($hero_bg_image)) : ?>
            <div class="hero-overlay" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,<?php echo esc_attr($hero_overlay); ?>); z-index: 0;"></div>
        <?php else : ?>
            <div class="hero-bg-glow"></div>
        <?php endif; ?>
        
        <div class="container hero-container" style="position: relative; z-index: 1;">
            <div class="hero-content animate-entry">
                <h2 class="hero-title"><?php echo esc_html($hero_title); ?></h2>
                <p class="hero-subtitle"><?php echo nl2br(esc_html($hero_subtitle)); ?></p>
                <?php if (!empty($hero_btn_text)) : ?>
                    <a href="<?php echo esc_url($hero_btn_url); ?>" class="btn-primary"><?php echo esc_html($hero_btn_text); ?></a>
                <?php endif; ?>
            </div>
            
            <div class="hero-visual animate-entry" style="animation-delay: 0.2s;">
                <div class="hero-card-stack">
                    <div class="hero-card glass-panel">
                        <div class="skeleton-img"></div>
                        <div class="skeleton-text"></div>
                        <div class="skeleton-text short"></div>
                    </div>
                    <div class="hero-card glass-panel accent">
                        <div class="skeleton-circle"></div>
                        <div class="skeleton-text"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php if ($hero_swarm) : ?>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const canvas = document.getElementById('hero-swarm-canvas');
        const container = document.getElementById('hero-swarm-container');
        if (!canvas || !container) return;
        const ctx = canvas.getContext('2d');
        let w, h;
        let mouse = { x: 0, y: 0 };
        let tick = 0;
        function resize() {
            w = canvas.width = container.offsetWidth;
            h = canvas.height = container.offsetHeight;
            mouse.x = w / 2; mouse.y = h / 2;
        }
        window.addEventListener('resize', resize);
        resize();
        container.addEventListener('mousemove', e => {
            const rect = container.getBoundingClientRect();
            mouse.x = e.clientX - rect.left; mouse.y = e.clientY - rect.top;
        });
        class Swimmer {
            constructor() { this.reset(true); }
            reset(randomStart) {
                this.x = randomStart ? Math.random() * w : mouse.x;
                this.y = randomStart ? Math.random() * h : mouse.y;
                this.vx = (Math.random() - 0.5) * 2; this.vy = (Math.random() - 0.5) * 2;
                this.history = []; this.offset = Math.random() * Math.PI * 2; this.colorOffset = Math.random() * 50;
            }
            update() {
                let dx = mouse.x - this.x; let dy = mouse.y - this.y;
                let dist = Math.sqrt(dx * dx + dy * dy); let angle = Math.atan2(dy, dx);
                let force = 0.15;
                if (dist < 100) { this.vx += Math.cos(angle + Math.PI / 2) * 0.4; this.vy += Math.sin(angle + Math.PI / 2) * 0.4; force = 0.04; }
                this.vx += Math.cos(angle) * force; this.vy += Math.sin(angle) * force;
                this.vx *= 0.96; this.vy *= 0.96;
                this.x += this.vx; this.y += this.vy;
                this.history.push({ x: this.x, y: this.y });
                if (this.history.length > 10) this.history.shift();
            }
            draw() {
                let hue = (tick + this.colorOffset) % 360;
                ctx.strokeStyle = `hsla(${hue}, 100%, 70%, 0.6)`;
                ctx.lineWidth = 1.5; ctx.beginPath();
                for (let i = 0; i < this.history.length; i++) {
                    let p = this.history[i]; if (i === 0) ctx.moveTo(p.x, p.y); else ctx.lineTo(p.x, p.y);
                }
                ctx.stroke();
            }
        }
        const swarm = Array.from({ length: 150 }, () => new Swimmer());
        function animate() {
            requestAnimationFrame(animate); tick++;
            ctx.globalCompositeOperation = 'source-over'; ctx.fillStyle = 'rgba(2, 2, 5, 0.15)'; ctx.fillRect(0, 0, w, h);
            ctx.globalCompositeOperation = 'lighter'; swarm.forEach(s => { s.update(); s.draw(); });
        }
        animate();
    });
    </script>
    <?php endif; ?>
<?php endif; ?>
