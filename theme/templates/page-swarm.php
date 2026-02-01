<?php
/**
 * Template Name: Bioluminescent Swarm
 *
 * @package HelpOfAi
 */

get_header();
?>

<div id="swarm-container" style="position: relative; width: 100%; height: 100vh; overflow: hidden; background: #020205; margin-top: -80px; z-index: 1;">
    <canvas id="swarm-canvas" style="display: block;"></canvas>
    <div class="swarm-overlay" style="position: absolute; bottom: 50px; width: 100%; text-align: center; pointer-events: none; color: rgba(255,255,255,0.4); font-family: 'Inter', sans-serif; letter-spacing: 4px; text-transform: uppercase; font-size: 12px; z-index: 10;">
        Bioluminescent Swarm Engine • Click to Disperse
    </div>
    
    <div class="container" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 20; text-align: center; pointer-events: none;">
        <h1 class="hero-title animate-entry" style="color: white; margin-bottom: 1rem;"><?php the_title(); ?></h1>
        <p class="animate-entry" style="color: rgba(255,255,255,0.8); font-size: 1.25rem; animation-delay: 0.1s;">Move your mouse to guide the swarm.</p>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const canvas = document.getElementById('swarm-canvas');
    if (!canvas) return;
    
    const ctx = canvas.getContext('2d');
    const container = document.getElementById('swarm-container');

    let w, h;
    let mouse = { x: window.innerWidth / 2, y: window.innerHeight / 2 };
    let tick = 0;

    // --- SETTINGS ---
    const COUNT = 250;       // Slightly reduced for WP performance
    const SPEED = 4;         
    const TRAIL_LEN = 12;    
    const FRICTION = 0.96;   

    // --- SETUP ---
    function resize() {
        w = canvas.width = window.innerWidth;
        h = canvas.height = window.innerHeight;
    }
    window.addEventListener('resize', resize);
    resize();

    // --- INPUT ---
    container.addEventListener('mousemove', e => {
        const rect = container.getBoundingClientRect();
        mouse.x = e.clientX - rect.left;
        mouse.y = e.clientY - rect.top;
    });
    
    container.addEventListener('mousedown', () => scatter());

    // --- ENTITY CLASS ---
    class Swimmer {
        constructor() {
            this.reset(true);
        }

        reset(randomStart) {
            this.x = randomStart ? Math.random() * w : mouse.x;
            this.y = randomStart ? Math.random() * h : mouse.y;
            this.vx = (Math.random() - 0.5) * 2;
            this.vy = (Math.random() - 0.5) * 2;
            this.history = [];
            this.offset = Math.random() * Math.PI * 2;
            this.colorOffset = Math.random() * 50;
        }

        update() {
            let dx = mouse.x - this.x;
            let dy = mouse.y - this.y;
            let dist = Math.sqrt(dx * dx + dy * dy);
            let angle = Math.atan2(dy, dx);

            let force = 0.2;
            if (dist < 100) {
                this.vx += Math.cos(angle + Math.PI / 2) * 0.5;
                this.vy += Math.sin(angle + Math.PI / 2) * 0.5;
                force = 0.05;
            }

            this.vx += Math.cos(angle) * force;
            this.vy += Math.sin(angle) * force;
            this.vx += (Math.random() - 0.5) * 0.5;
            this.vy += (Math.random() - 0.5) * 0.5;
            this.vx *= FRICTION;
            this.vy *= FRICTION;

            let speed = Math.sqrt(this.vx * this.vx + this.vy * this.vy);
            if (speed > SPEED) {
                this.vx = (this.vx / speed) * SPEED;
                this.vy = (this.vy / speed) * SPEED;
            }

            this.x += this.vx;
            this.y += this.vy;

            this.history.push({ x: this.x, y: this.y });
            if (this.history.length > TRAIL_LEN) {
                this.history.shift();
            }
        }

        draw() {
            let hue = (tick + this.colorOffset) % 360;
            ctx.strokeStyle = `hsla(${hue}, 100%, 60%, 0.8)`;
            ctx.fillStyle = `hsla(${hue}, 100%, 80%, 1)`;
            ctx.lineWidth = 2;
            ctx.lineCap = 'round';

            ctx.beginPath();
            for (let i = 0; i < this.history.length; i++) {
                let p = this.history[i];
                let wiggle = Math.sin(tick * 0.2 + this.offset + i) * (i * 0.3);
                if (i === 0) ctx.moveTo(p.x + wiggle, p.y + wiggle);
                else ctx.lineTo(p.x + wiggle, p.y + wiggle);
            }
            ctx.stroke();

            ctx.beginPath();
            ctx.arc(this.x, this.y, 2, 0, Math.PI * 2);
            ctx.fill();
        }
    }

    const swarm = Array.from({ length: COUNT }, () => new Swimmer());

    function scatter() {
        swarm.forEach(s => {
            let dx = s.x - mouse.x;
            let dy = s.y - mouse.y;
            let dist = Math.sqrt(dx * dx + dy * dy) + 1;
            let force = 2000 / dist;
            s.vx += (dx / dist) * force;
            s.vy += (dy / dist) * force;
            s.history = [];
        });
    }

    function loop() {
        tick += 1;
        ctx.globalCompositeOperation = 'source-over';
        ctx.fillStyle = 'rgba(2, 2, 5, 0.2)';
        ctx.fillRect(0, 0, w, h);
        ctx.globalCompositeOperation = 'lighter';

        const pulse = Math.sin(tick * 0.1) * 5;
        const coreHue = (tick * 0.5) % 360;

        let grad = ctx.createRadialGradient(mouse.x, mouse.y, 10, mouse.x, mouse.y, 150);
        grad.addColorStop(0, `hsla(${coreHue}, 100%, 50%, 0.3)`);
        grad.addColorStop(1, 'rgba(0,0,0,0)');
        ctx.fillStyle = grad;
        ctx.beginPath();
        ctx.arc(mouse.x, mouse.y, 150, 0, Math.PI * 2);
        ctx.fill();

        ctx.fillStyle = '#fff';
        ctx.beginPath();
        ctx.arc(mouse.x, mouse.y, 5 + pulse * 0.2, 0, Math.PI * 2);
        ctx.fill();

        swarm.forEach(s => {
            s.update();
            s.draw();
        });

        requestAnimationFrame(loop);
    }
    loop();
});
</script>

<?php
get_footer();
