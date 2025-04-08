/**
 * Main JavaScript file for the Météo France website
 */

document.addEventListener('DOMContentLoaded', function() {
    // Theme toggle functionality
    const themeToggle = document.getElementById('theme-toggle');
    if (themeToggle) {
        themeToggle.addEventListener('click', function() {
            const currentTheme = document.body.classList.contains('dark') ? 'light' : 'dark';
            document.body.classList.toggle('dark');
            
            // Save theme preference in cookie
            document.cookie = `theme=${currentTheme}; path=/; max-age=31536000`; // 1 year
        });
    }
    
   
});