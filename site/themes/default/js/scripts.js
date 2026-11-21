(function () {
    'use strict';

    var toggle = document.querySelector('.nav-toggle');
    var navigation = document.getElementById('site-nav');

    if (!toggle || !navigation) {
        return;
    }

    toggle.addEventListener('click', function () {
        var isOpen = navigation.classList.toggle('is-open');
        toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
    });
})();
