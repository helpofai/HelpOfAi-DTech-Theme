<?php
/**
 * Template Name: Custom Login Page
 *
 * @package HelpOfAi
 */

// Redirect logged-in users to home or dashboard
if ( is_user_logged_in() ) {
    wp_redirect( home_url() );
    exit;
}

// Get Theme Options
$primary_start = get_option( 'helpofai_color_primary_start', '#6366f1' );
$primary_end   = get_option( 'helpofai_color_primary_end', '#a855f7' );
$use_swarm     = get_option( 'helpofai_login_swarm_bg', 0 );
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - <?php bloginfo( 'name' ); ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css?family=Poppins:300,400,600,700&display=swap');

        :root {
            /* Dynamic Theme Colors */
            --primary-gradient: linear-gradient(to right, <?php echo esc_attr($primary_start); ?> 0%, <?php echo esc_attr($primary_end); ?> 100%);
            --glass-bg: rgba(255, 255, 255, 0.1); /* Slightly more visible glass */
            --glass-border: 1px solid rgba(255, 255, 255, 0.18);
            --glass-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
        }

        * {
            box-sizing: border-box;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            font-family: 'Poppins', sans-serif;
            height: 100vh;
            margin: 0;
            overflow: hidden;
            background: #f0f2f5; /* Fallback */
        }

        h1 {
            font-weight: 700;
            margin: 0;
            color: #333;
        }

        h1.white-text {
            color: #fff;
        }

        p {
            font-size: 14px;
            font-weight: 300;
            line-height: 20px;
            letter-spacing: 0.5px;
            margin: 20px 0 30px;
            color: #eee;
        }

        span {
            font-size: 12px;
            color: #666;
            margin-bottom: 10px;
        }

        a {
            color: #333;
            font-size: 14px;
            text-decoration: none;
            margin: 15px 0;
            transition: color 0.3s;
        }

        a:hover {
            color: <?php echo esc_attr($primary_start); ?>;
        }

        button {
            border-radius: 50px;
            border: none;
            background: var(--primary-gradient);
            color: #FFFFFF;
            font-size: 12px;
            font-weight: bold;
            padding: 12px 45px;
            letter-spacing: 1px;
            text-transform: uppercase;
            transition: transform 80ms ease-in, box-shadow 0.3s;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            margin-top: 10px;
        }

        button:hover {
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
        }

        button:active {
            transform: scale(0.95);
        }

        button:focus {
            outline: none;
        }

        button.ghost {
            background: transparent;
            border: 2px solid #FFFFFF;
            box-shadow: none;
        }

        form {
            background-color: #FFFFFF;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            padding: 0 50px;
            height: 100%;
            text-align: center;
        }

        input {
            background-color: transparent;
            border: none;
            border-bottom: 2px solid #ddd;
            padding: 12px 15px;
            margin: 8px 0;
            width: 100%;
            font-family: 'Poppins', sans-serif;
            transition: border-color 0.3s;
        }

        input:focus {
            outline: none;
            border-bottom-color: <?php echo esc_attr($primary_start); ?>;
        }

        .container {
            background: rgba(255, 255, 255, 0.9); /* Opaque white for readability */
            box-shadow: var(--glass-shadow);
            border-radius: 20px;
            position: relative;
            overflow: hidden;
            width: 850px;
            max-width: 100%;
            min-height: 550px;
            z-index: 10;
        }

        .form-container {
            position: absolute;
            top: 0;
            height: 100%;
            transition: all 0.6s ease-in-out;
        }

        .sign-in-container {
            left: 0;
            width: 50%;
            z-index: 2;
        }

        .container.right-panel-active .sign-in-container {
            transform: translateX(100%);
        }

        .sign-up-container {
            left: 0;
            width: 50%;
            opacity: 0;
            z-index: 1;
        }

        .container.right-panel-active .sign-up-container {
            transform: translateX(100%);
            opacity: 1;
            z-index: 5;
            animation: show 0.6s;
        }

        @keyframes show {
            0%, 49.99% { opacity: 0; z-index: 1; }
            50%, 100% { opacity: 1; z-index: 5; }
        }

        .overlay-container {
            position: absolute;
            top: 0;
            left: 50%;
            width: 50%;
            height: 100%;
            overflow: hidden;
            transition: transform 0.6s ease-in-out;
            z-index: 100;
        }

        .container.right-panel-active .overlay-container {
            transform: translateX(-100%);
        }

        .overlay {
            background: var(--primary-gradient);
            background-repeat: no-repeat;
            background-size: cover;
            background-position: 0 0;
            color: #FFFFFF;
            position: relative;
            left: -100%;
            height: 100%;
            width: 200%;
            transform: translateX(0);
            transition: transform 0.6s ease-in-out;
        }

        .container.right-panel-active .overlay {
            transform: translateX(50%);
        }

        .overlay-panel {
            position: absolute;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            padding: 0 40px;
            text-align: center;
            top: 0;
            height: 100%;
            width: 50%;
            transform: translateX(0);
            transition: transform 0.6s ease-in-out;
        }

        .overlay-left { transform: translateX(-20%); }
        .container.right-panel-active .overlay-left { transform: translateX(0); }
        .overlay-right { right: 0; transform: translateX(0); }
        .container.right-panel-active .overlay-right { transform: translateX(20%); }

        .social-container { margin: 20px 0; }
        .social-container a {
            border: 1px solid #DDDDDD;
            border-radius: 50%;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            margin: 0 5px;
            height: 40px;
            width: 40px;
            transition: 0.3s;
            color: #333;
        }
        .social-container a:hover {
            background-color: <?php echo esc_attr($primary_start); ?>;
            color: white;
            border-color: <?php echo esc_attr($primary_start); ?>;
            transform: translateY(-3px);
        }

        #canvas1 {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            z-index: -1;
            background: <?php echo $use_swarm ? '#020205' : 'linear-gradient(to right, #ece9e6, #ffffff)'; ?>;
        }
        
        /* WordPress Error Message Styling */
        .login-error {
            color: red;
            font-size: 12px;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>

    <div class="container" id="container">
        
        <!-- Sign Up Form (Registration) -->
        <div class="form-container sign-up-container">
            <form action="<?php echo esc_url( site_url( 'wp-login.php?action=register' ) ); ?>" method="post">
                <h1>Create Account</h1>
                
                <span>Use your email for registration</span>
                <input type="text" name="user_login" placeholder="Username" required />
                <input type="email" name="user_email" placeholder="Email" required />
                
                <?php do_action( 'register_form' ); ?>
                
                <button type="submit" name="wp-submit" id="wp-submit">Sign Up</button>
                <input type="hidden" name="redirect_to" value="<?php echo esc_url( home_url( '/login?registered=true' ) ); ?>" />
            </form>
        </div>

        <!-- Sign In Form (Login) -->
        <div class="form-container sign-in-container">
            <form action="<?php echo esc_url( site_url( 'wp-login.php' ) ); ?>" method="post">
                <h1>Sign in</h1>
                
                <span>Use your account</span>
                
                <?php
                // Display errors if any (simple check)
                if ( isset( $_GET['login'] ) && $_GET['login'] == 'failed' ) {
                    echo '<p class="login-error">Invalid credentials. Please try again.</p>';
                }
                if ( isset( $_GET['registered'] ) && $_GET['registered'] == 'true' ) {
                    echo '<p style="color: green; font-size: 12px;">Registration successful! Check your email.</p>';
                }
                ?>

                <input type="text" name="log" placeholder="Username or Email" required />
                <input type="password" name="pwd" placeholder="Password" required />
                
                <a href="<?php echo esc_url( wp_lostpassword_url() ); ?>">Forgot your password?</a>
                
                <button type="submit" name="wp-submit">Sign In</button>
                <input type="hidden" name="redirect_to" value="<?php echo esc_url( home_url() ); ?>" />
            </form>
        </div>

        <!-- Overlay Container -->
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1 class="white-text">Welcome Back!</h1>
                    <p>To keep connected with us please login with your personal info</p>
                    <button class="ghost" id="signIn">Sign In</button>
                </div>
                <div class="overlay-panel overlay-right">
                    <h1 class="white-text">Hello, Friend!</h1>
                    <p>Enter your personal details and start your journey with us</p>
                    <button class="ghost" id="signUp">Sign Up</button>
                </div>
            </div>
        </div>
    </div>

    <canvas id="canvas1"></canvas>

    <script>
        // --- Form Toggle Logic ---
        const signUpButton = document.getElementById('signUp');
        const signInButton = document.getElementById('signIn');
        const mainContainer = document.getElementById('container');

        signUpButton.addEventListener('click', () => {
            mainContainer.classList.add("right-panel-active");
        });

        signInButton.addEventListener('click', () => {
            mainContainer.classList.remove("right-panel-active");
        });

        // --- Background Logic ---
        const canvas = document.getElementById("canvas1");
        const ctx = canvas.getContext('2d');
        let w, h;
        let mouse = { x: window.innerWidth / 2, y: window.innerHeight / 2 };
        let tick = 0;

        function resize() {
            w = canvas.width = window.innerWidth;
            h = canvas.height = window.innerHeight;
        }
        window.addEventListener('resize', resize);
        resize();

        window.addEventListener('mousemove', e => {
            mouse.x = e.clientX;
            mouse.y = e.clientY;
        });

        <?php if ( $use_swarm ) : ?>
        /* --- Bioluminescent Swarm Engine --- */
        const COUNT = 150; // Balanced for login overlay
        const SPEED = 3;
        const TRAIL_LEN = 10;
        const FRICTION = 0.96;

        class Swimmer {
            constructor() { this.reset(true); }
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
                let dx = mouse.x - this.x; let dy = mouse.y - this.y;
                let dist = Math.sqrt(dx * dx + dy * dy); let angle = Math.atan2(dy, dx);
                let force = 0.15;
                if (dist < 100) { this.vx += Math.cos(angle + Math.PI / 2) * 0.4; this.vy += Math.sin(angle + Math.PI / 2) * 0.4; force = 0.04; }
                this.vx += Math.cos(angle) * force; this.vy += Math.sin(angle) * force;
                this.vx *= FRICTION; this.vy *= FRICTION;
                this.x += this.vx; this.y += this.vy;
                this.history.push({ x: this.x, y: this.y });
                if (this.history.length > TRAIL_LEN) this.history.shift();
            }
            draw() {
                let hue = (tick + this.colorOffset) % 360;
                ctx.strokeStyle = `hsla(${hue}, 100%, 60%, 0.5)`;
                ctx.lineWidth = 1.5;
                ctx.beginPath();
                for (let i = 0; i < this.history.length; i++) {
                    let p = this.history[i];
                    if (i === 0) ctx.moveTo(p.x, p.y); else ctx.lineTo(p.x, p.y);
                }
                ctx.stroke();
            }
        }
        const swarm = Array.from({ length: COUNT }, () => new Swimmer());
        function animate() {
            requestAnimationFrame(animate);
            tick++;
            ctx.globalCompositeOperation = 'source-over';
            ctx.fillStyle = 'rgba(2, 2, 5, 0.2)';
            ctx.fillRect(0, 0, w, h);
            ctx.globalCompositeOperation = 'lighter';
            swarm.forEach(s => { s.update(); s.draw(); });
        }
        animate();

        <?php else : ?>
        /* --- Standard Particle Logic --- */
        let particlesArray;
        mouse.radius = (canvas.height / 80) * (canvas.width / 80);

        class Particle {
            constructor(x, y, dx, dy, size) { this.x = x; this.y = y; this.dx = dx; this.dy = dy; this.size = size; }
            draw() { ctx.beginPath(); ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2); ctx.fillStyle = '#8E9EAB'; ctx.fill(); }
            update() {
                if (this.x > w || this.x < 0) this.dx = -this.dx;
                if (this.y > h || this.y < 0) this.dy = -this.dy;
                this.x += this.dx; this.y += this.dy;
                this.draw();
            }
        }
        function initParticles() {
            particlesArray = [];
            for (let i = 0; i < 100; i++) {
                particlesArray.push(new Particle(Math.random()*w, Math.random()*h, (Math.random()-0.5)*2, (Math.random()-0.5)*2, Math.random()*3+1));
            }
        }
        function animate() {
            requestAnimationFrame(animate);
            ctx.clearRect(0,0,w,h);
            particlesArray.forEach(p => p.update());
        }
        initParticles();
        animate();
        <?php endif; ?>
    </script>
</body>
</html>
