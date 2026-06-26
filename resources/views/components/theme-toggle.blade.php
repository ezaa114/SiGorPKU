<button class="theme-toggle-btn relative inline-flex h-7 w-12 items-center rounded-full transition-all focus:outline-none focus:ring-2 focus:ring-blue-500/20 cursor-pointer" aria-label="Ganti Tema">
    <span class="sr-only">Toggle Theme</span>
    
    <!-- Sun icon (Light Mode indicator) -->
    <span class="theme-sun-icon absolute left-1 flex h-5 w-5 items-center justify-center transition-all duration-200 z-10">
        <i class="fa-solid fa-sun text-xs"></i>
    </span>
    
    <!-- Moon icon (Dark Mode indicator) -->
    <span class="theme-moon-icon absolute right-1 flex h-5 w-5 items-center justify-center transition-all duration-200 z-10">
        <i class="fa-solid fa-moon text-xs"></i>
    </span>
    
    <!-- Slider thumb -->
    <span class="theme-toggle-thumb inline-block h-5 w-5 transform rounded-full bg-white transition-all duration-200 shadow-md"></span>
</button>

<style>
    /* Button background transitions */
    .theme-toggle-btn {
        background-color: #cbd5e1; /* slate-300 */
    }
    [data-theme="dark"] .theme-toggle-btn {
        background-color: #1e293b; /* slate-800 */
    }
    
    /* Sun/Moon opacity/color controls (always visible, active is highlighted) */
    .theme-sun-icon {
        color: #f59e0b; /* amber-500 (active) */
        opacity: 1;
    }
    .theme-moon-icon {
        color: #64748b; /* slate-500 (inactive) */
        opacity: 0.6;
    }
    
    [data-theme="dark"] .theme-sun-icon {
        color: #475569; /* slate-600 (inactive) */
        opacity: 0.6;
    }
    [data-theme="dark"] .theme-moon-icon {
        color: #38bdf8; /* sky-400 (active) */
        opacity: 1;
    }
    
    /* Thumb position translate transition */
    .theme-toggle-thumb {
        transform: translateX(4px);
    }
    [data-theme="dark"] .theme-toggle-thumb {
        transform: translateX(24px);
    }
</style>

<script>
    if (typeof window.initThemeToggle === 'undefined') {
        window.handleThemeToggleClick = function() {
            const currentTheme = document.documentElement.getAttribute('data-theme') || 'light';
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            document.documentElement.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
        };

        window.initThemeToggle = function() {
            const btns = document.querySelectorAll('.theme-toggle-btn');
            btns.forEach(btn => {
                btn.removeEventListener('click', window.handleThemeToggleClick);
                btn.addEventListener('click', window.handleThemeToggleClick);
            });
        };
        
        document.addEventListener('DOMContentLoaded', window.initThemeToggle);
        
        if (document.readyState === 'interactive' || document.readyState === 'complete') {
            window.initThemeToggle();
        }
    } else {
        window.initThemeToggle();
    }
</script>
