document.addEventListener('DOMContentLoaded', function() {
    // Seleciona todos os links da navbar
    const navLinks = document.querySelectorAll('#navbar ul li a');

    // Função para adicionar a classe 'active' ao link clicado
    function setActiveLink(event) {
        // Remove a classe 'active' de todos os links
        navLinks.forEach(link => link.classList.remove('active'));
        // Adiciona a classe 'active' ao link clicado
        event.target.classList.add('active');
    }

    // Adiciona evento de clique a cada link da navbar
    navLinks.forEach(link => link.addEventListener('click', setActiveLink));

    // Destaca o link da página atual automaticamente
    window.onhashchange = function() {
        navLinks.forEach(link => {
            if (window.location.hash === link.getAttribute('href')) {
                link.classList.add('active');
            } else {
                link.classList.remove('active');
            }
        });
    };
});

window.addEventListener('scroll', function() {
    var navbar = document.getElementById('navbar');
    if (window.pageYOffset > 0) { // Se a página foi rolada para baixo
        navbar.style.backgroundColor = '#000'; // 
    } else {
        navbar.style.backgroundColor = 'transparent'; // Volta a ser transparente
    }
});