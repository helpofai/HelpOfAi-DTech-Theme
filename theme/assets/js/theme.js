document.addEventListener('DOMContentLoaded', () => {
    const toggleBtn = document.getElementById('dark-mode-toggle');
    const body = document.body;
    const icon = toggleBtn.querySelector('i');

    // Check Local Storage or System Preference
    const currentTheme = localStorage.getItem('theme');
    const prefersDarkScheme = window.matchMedia('(prefers-color-scheme: dark)');

    if (currentTheme === 'dark' || (!currentTheme && prefersDarkScheme.matches)) {
        body.classList.add('dark-mode');
        document.documentElement.classList.add('dark-mode');
        updateIcon(true);
    }

    toggleBtn.addEventListener('click', () => {
        body.classList.toggle('dark-mode');
        document.documentElement.classList.toggle('dark-mode');
        const isDark = body.classList.contains('dark-mode');
        
        // Save Preference
        localStorage.setItem('theme', isDark ? 'dark' : 'light');
        updateIcon(isDark);
    });

    function updateIcon(isDark) {
        // Simple text/emoji swap, can be replaced with SVG icons
        toggleBtn.textContent = isDark ? '☀️' : '🌙';
    }

    /* --- Mobile Menu Logic --- */
    const menuToggle = document.getElementById('mobile-menu-toggle');
    const nav = document.getElementById('site-navigation');
    
    if (menuToggle && nav) {
        // Create Overlay
        const overlay = document.createElement('div');
        overlay.classList.add('menu-overlay');
        document.body.appendChild(overlay);

        function toggleMenu() {
            body.classList.toggle('menu-open');
            nav.classList.toggle('mobile-active');
        }

        menuToggle.addEventListener('click', toggleMenu);
        overlay.addEventListener('click', toggleMenu);
        
        // Close on ESC
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && body.classList.contains('menu-open')) {
                toggleMenu();
            }
        });

        // Mobile Sub-menu Toggle
        const mobileParentLinks = nav.querySelectorAll('.menu-item-has-children > a');
        mobileParentLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                if (window.innerWidth <= 992) {
                    e.preventDefault();
                    const parent = this.parentElement;
                    parent.classList.toggle('mobile-dropdown-open');
                }
            });
        });
    }

    /* --- Desktop Dropdown (Click Mode) --- */
    if (nav && nav.getAttribute('data-dropdown') === 'click') {
        const dropdownParents = nav.querySelectorAll('.menu-item-has-children > a');
        
        dropdownParents.forEach(link => {
            link.addEventListener('click', function(e) {
                if (window.innerWidth > 992) { // Only on Desktop
                    e.preventDefault();
                    const parent = this.parentElement;
                    const isOpen = parent.classList.contains('dropdown-open');

                    // Close all others
                    nav.querySelectorAll('.menu-item-has-children').forEach(item => {
                        if (item !== parent) item.classList.remove('dropdown-open');
                    });

                    // Toggle current
                    parent.classList.toggle('dropdown-open');
                }
            });
        });

        // Close when clicking outside
        document.addEventListener('click', (e) => {
            if (!nav.contains(e.target)) {
                nav.querySelectorAll('.dropdown-open').forEach(item => {
                    item.classList.remove('dropdown-open');
                });
            }
        });
    }

    /* --- Smart Sticky Header --- */
    const header = document.getElementById('masthead');
    let lastScrollY = window.scrollY;
    
    if (header) {
        // Initial check
        if (window.scrollY === 0) {
            header.classList.add('header-transparent');
        } else {
            header.classList.add('header-scrolled');
        }

        window.addEventListener('scroll', () => {
            const currentScrollY = window.scrollY;
            
            // 1. Transparent vs Scrolled
            if (currentScrollY <= 10) {
                header.classList.add('header-transparent');
                header.classList.remove('header-scrolled');
                header.classList.remove('header-hidden'); // Always show at top
            } else {
                header.classList.remove('header-transparent');
                header.classList.add('header-scrolled');
            }

            // 2. Hide/Show Logic (Only if scrolled past 100px)
            if (currentScrollY > 100) {
                if (currentScrollY > lastScrollY) {
                    // Scrolling DOWN -> Hide
                    header.classList.remove('header-visible');
                    header.classList.add('header-hidden');
                } else {
                    // Scrolling UP -> Show
                    header.classList.remove('header-hidden');
                    header.classList.add('header-visible');
                }
            } else {
                // Near top -> always visible
                header.classList.remove('header-hidden');
                header.classList.add('header-visible');
            }

            lastScrollY = currentScrollY;
        }, { passive: true });
    }
});
