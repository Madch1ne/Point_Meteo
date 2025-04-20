/**
 * Main JavaScript file 
 */


// Quand le DOM est prêt
document.addEventListener('DOMContentLoaded', function() {
  const toggle = document.getElementById('theme-toggle');
  const linkEl = document.querySelector('link[rel="stylesheet"][href*="style"]');
  const body = document.body;

  toggle.addEventListener('click', function() {
    // On envoie la classe 'dark' sur <body>
    const isDark = body.classList.toggle('dark');
    body.classList.toggle('light', !isDark);

    // On change la feuille de style
    const newCss = isDark ? 'css/style_alternatif.css' : 'css/style.css';
    linkEl.setAttribute('href', newCss);

    // On met à jour le cookie pour 1 an
    document.cookie = `theme=${isDark ? 'dark' : 'light'};path=/;max-age=${60*60*24*365}`;
  });
});

