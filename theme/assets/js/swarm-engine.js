/**
 * HelpOfAi Bioluminescent Swarm Engine
 */
class SwarmEngine {
    constructor(canvasId, containerId = null) {
        this.canvas = document.getElementById(canvasId);
        if (!this.canvas) return;
        
        this.ctx = this.canvas.getContext('2d');
        this.container = containerId ? document.getElementById(containerId) : window;
        this.w = 0;
        this.h = 0;
        this.mouse = { x: 0, y: 0 };
        this.tick = 0;
        this.swarm = [];
        this.count = 150;
        
        this.init();
    }

    init() {
        this.resize();
        window.addEventListener('resize', () => this.resize());
        
        const moveTarget = this.container === window ? window : this.container;
        moveTarget.addEventListener('mousemove', (e) => {
            if (this.container === window) {
                this.mouse.x = e.clientX;
                this.mouse.y = e.clientY;
            } else {
                const rect = this.container.getBoundingClientRect();
                this.mouse.x = e.clientX - rect.left;
                this.mouse.y = e.clientY - rect.top;
            }
        });

        this.swarm = Array.from({ length: this.count }, () => new Swimmer(this));
        this.animate();
    }

    resize() {
        this.w = this.canvas.width = (this.container === window) ? window.innerWidth : this.container.offsetWidth;
        this.h = this.canvas.height = (this.container === window) ? window.innerHeight : this.container.offsetHeight;
        this.mouse.x = this.w / 2;
        this.mouse.y = this.h / 2;
    }

    animate() {
        requestAnimationFrame(() => this.animate());
        this.tick++;
        
        const isDarkMode = document.documentElement.classList.contains('dark-mode');
        
        // 1. CLEARING LOGIC (The "Erasing" Speed)
        this.ctx.globalCompositeOperation = 'source-over';
        
        const bgVar = getComputedStyle(document.documentElement).getPropertyValue('--swarm-bg').trim();
        let trailColor = bgVar;
        
        // Faster clearing (0.25 alpha) to prevent "shadow" ghosting
        const alpha = 0.25; 
        
        if (bgVar.startsWith('#')) {
            const r = parseInt(bgVar.slice(1, 3), 16);
            const g = parseInt(bgVar.slice(3, 5), 16);
            const b = parseInt(bgVar.slice(5, 7), 16);
            trailColor = `rgba(${r}, ${g}, ${b}, ${alpha})`;
        } else if (bgVar.startsWith('rgb')) {
            trailColor = bgVar.replace('rgb', 'rgba').replace(')', `, ${alpha})`);
        }
        
        this.ctx.fillStyle = trailColor; 
        this.ctx.fillRect(0, 0, this.w, this.h);
        
        // 2. BLENDING MODE (Glow for Dark, Sharp for Light)
        this.ctx.globalCompositeOperation = isDarkMode ? 'lighter' : 'source-over';
        
        this.swarm.forEach(s => {
            s.update();
            s.draw(isDarkMode);
        });
    }
}

class Swimmer {
    constructor(engine) {
        this.engine = engine;
        this.reset(true);
    }

    reset(randomStart) {
        this.x = randomStart ? Math.random() * this.engine.w : this.engine.mouse.x;
        this.y = randomStart ? Math.random() * this.engine.h : this.engine.mouse.y;
        this.vx = (Math.random() - 0.5) * 2;
        this.vy = (Math.random() - 0.5) * 2;
        this.history = [];
        this.colorOffset = Math.random() * 360;
    }

    update() {
        let dx = this.engine.mouse.x - this.x;
        let dy = this.engine.mouse.y - this.y;
        let dist = Math.sqrt(dx * dx + dy * dy);
        let angle = Math.atan2(dy, dx);

        let force = 0.25;
        if (dist < 150) {
            this.vx += Math.cos(angle + Math.PI / 2) * 0.5;
            this.vy += Math.sin(angle + Math.PI / 2) * 0.5;
            force = 0.06;
        }

        this.vx += Math.cos(angle) * force;
        this.vy += Math.sin(angle) * force;
        this.vx *= 0.96;
        this.vy *= 0.96;
        this.x += this.vx;
        this.y += this.vy;

        this.history.push({ x: this.x, y: this.y });
        if (this.history.length > 12) this.history.shift();
    }

    draw(isDarkMode) {
        let hue = (this.engine.tick + this.colorOffset) % 360;
        
        // Dynamic styling: Glowy for dark mode, darker/vibrant for light mode
        const saturation = isDarkMode ? '100%' : '80%';
        const lightness = isDarkMode ? '70%' : '50%';
        const opacity = isDarkMode ? 0.5 : 0.7;

        this.engine.ctx.strokeStyle = `hsla(${hue}, ${saturation}, ${lightness}, ${opacity})`;
        this.engine.ctx.lineWidth = 2;
        this.engine.ctx.lineCap = 'round';
        this.engine.ctx.beginPath();
        for (let i = 0; i < this.history.length; i++) {
            let p = this.history[i];
            if (i === 0) this.engine.ctx.moveTo(p.x, p.y);
            else this.engine.ctx.lineTo(p.x, p.y);
        }
        this.engine.ctx.stroke();
    }
}

// Global Initialization
document.addEventListener('DOMContentLoaded', () => {
    if (document.getElementById('global-swarm-canvas')) {
        new SwarmEngine('global-swarm-canvas');
    }
});
