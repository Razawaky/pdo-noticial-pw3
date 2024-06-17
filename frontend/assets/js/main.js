$(document).ready(function() {
    // Seleciona todos os links da navbar
    var navLinks = $('#navbar ul li a');

    // Função para adicionar a classe 'active' ao link clicado
    function setActiveLink(event) {
        // Remove a classe 'active' de todos os links
        navLinks.removeClass('active');
        // Adiciona a classe 'active' ao link clicado
        $(event.target).addClass('active');
    }

    // Adiciona evento de clique a cada link da navbar
    navLinks.click(setActiveLink);

    // Destaca o link da página atual automaticamente
    $(window).on('hashchange', function() {
        navLinks.each(function() {
            if (window.location.hash === $(this).attr('href')) {
                $(this).addClass('active');
            } else {
                $(this).removeClass('active');
            }
        });
    });

    // Muda a cor de fundo da navbar ao rolar a página
    $(window).on('scroll', function() {
        if ($(window).scrollTop() > 0) { // Se a página foi rolada para baixo
            $('#navbar').css('backgroundColor', '#000'); 
        } else {
            $('#navbar').css('backgroundColor', 'transparent'); // Volta a ser transparente
        }
    });
});

// BUTTON HAMBURGUER

$('.menu-btn').click(function() {
    $(this).toggleClass('open'); /* ABRE O ICONE */
    $('.menu').slideToggle(); /* MOSTRA OU OCULTA MENU */
});

