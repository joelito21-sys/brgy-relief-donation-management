class ThemeSwitcher {
    constructor() {
        this.themeToggle = document.getElementById('theme-toggle');
        this.themePalette = document.getElementById('theme-palette');
        this.themeButtons = document.querySelectorAll('.theme-option');
        this.themeClose = document.getElementById('close-theme-palette');
        this.currentTheme = localStorage.getItem('theme') || 'light';
        
        this.init();
    }

    init() {
        // Set initial theme
        this.setTheme(this.currentTheme);
        
        // Toggle theme palette
        if (this.themeToggle) {
            this.themeToggle.addEventListener('click', () => {
                this.themePalette.classList.toggle('show');
            });
        }

        // Close theme palette
        if (this.themeClose) {
            this.themeClose.addEventListener('click', () => {
                this.themePalette.classList.remove('show');
            });
        }

        // Theme selection
        this.themeButtons.forEach(button => {
            button.addEventListener('click', () => {
                const theme = button.getAttribute('data-theme');
                this.setTheme(theme);
                this.themePalette.classList.remove('show');
            });
        });

        // Close when clicking outside
        document.addEventListener('click', (e) => {
            if (this.themePalette && !this.themePalette.contains(e.target) && 
                this.themeToggle && !this.themeToggle.contains(e.target)) {
                this.themePalette.classList.remove('show');
            }
        });
    }

    setTheme(theme) {
        // Remove all theme classes
        document.documentElement.classList.remove('theme-light', 'theme-dark', 'theme-semi-dark', 'theme-highlight');
        
        // Add selected theme class
        document.documentElement.classList.add(`theme-${theme}`);
        
        // Save to localStorage
        localStorage.setItem('theme', theme);
        
        // Update active button
        this.themeButtons.forEach(btn => {
            if (btn.getAttribute('data-theme') === theme) {
                btn.classList.add('active');
            } else {
                btn.classList.remove('active');
            }
        });
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    if (document.getElementById('theme-toggle')) {
        new ThemeSwitcher();
    }
});
