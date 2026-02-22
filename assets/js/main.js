/**
* Template Name: Squadfree
* Template URL: https://bootstrapmade.com/squadfree-free-bootstrap-template-creative/
* Updated: Aug 07 2024 with Bootstrap v5.3.3
* Author: BootstrapMade.com
* License: https://bootstrapmade.com/license/
*/

(function () {
  "use strict";

  /**
   * Apply .scrolled class to the body as the page is scrolled down
   */
  function toggleScrolled() {
    const selectBody = document.querySelector('body');
    const selectHeader = document.querySelector('#header');
    if (!selectHeader.classList.contains('scroll-up-sticky') && !selectHeader.classList.contains('sticky-top') && !selectHeader.classList.contains('fixed-top')) return;
    window.scrollY > 100 ? selectBody.classList.add('scrolled') : selectBody.classList.remove('scrolled');
  }

  document.addEventListener('scroll', toggleScrolled);
  window.addEventListener('load', toggleScrolled);

  /**
   * Mobile nav toggle
   */
  const mobileNavToggleBtn = document.querySelector('.mobile-nav-toggle');

  function mobileNavToogle() {
    document.querySelector('body').classList.toggle('mobile-nav-active');
    mobileNavToggleBtn.classList.toggle('bi-list');
    mobileNavToggleBtn.classList.toggle('bi-x');
  }
  mobileNavToggleBtn.addEventListener('click', mobileNavToogle);

  /**
   * Hide mobile nav on same-page/hash links
   */
  document.querySelectorAll('#navmenu a').forEach(navmenu => {
    navmenu.addEventListener('click', () => {
      if (document.querySelector('.mobile-nav-active')) {
        mobileNavToogle();
      }
    });

  });

  /**
   * Toggle mobile nav dropdowns
   */
  document.querySelectorAll('.navmenu .toggle-dropdown').forEach(navmenu => {
    navmenu.addEventListener('click', function (e) {
      e.preventDefault();
      this.parentNode.classList.toggle('active');
      this.parentNode.nextElementSibling.classList.toggle('dropdown-active');
      e.stopImmediatePropagation();
    });
  });

  /**
   * Preloader
   */
  const preloader = document.querySelector('#preloader');
  if (preloader) {
    window.addEventListener('load', () => {
      preloader.remove();
    });
  }

  /**
   * Scroll top button
   */
  let scrollTop = document.querySelector('.scroll-top');

  function toggleScrollTop() {
    if (scrollTop) {
      window.scrollY > 100 ? scrollTop.classList.add('active') : scrollTop.classList.remove('active');
    }
  }
  scrollTop.addEventListener('click', (e) => {
    e.preventDefault();
    window.scrollTo({
      top: 0,
      behavior: 'smooth'
    });
  });

  window.addEventListener('load', toggleScrollTop);
  document.addEventListener('scroll', toggleScrollTop);

  /**
   * Animation on scroll function and init
   */
  function aosInit() {
    AOS.init({
      duration: 600,
      easing: 'ease-in-out',
      once: true,
      mirror: false
    });
  }
  window.addEventListener('load', aosInit);

  /**
   * Initiate Pure Counter
   */
  new PureCounter();

  /**
   * Initiate glightbox
   */
  const glightbox = GLightbox({
    selector: '.glightbox'
  });

  /**
   * Init isotope layout and filters
   */
  document.querySelectorAll('.isotope-layout').forEach(function (isotopeItem) {
    let layout = isotopeItem.getAttribute('data-layout') ?? 'masonry';
    let filter = isotopeItem.getAttribute('data-default-filter') ?? '*';
    let sort = isotopeItem.getAttribute('data-sort') ?? 'original-order';

    let initIsotope;
    imagesLoaded(isotopeItem.querySelector('.isotope-container'), function () {
      initIsotope = new Isotope(isotopeItem.querySelector('.isotope-container'), {
        itemSelector: '.isotope-item',
        layoutMode: layout,
        filter: filter,
        sortBy: sort
      });
    });

    isotopeItem.querySelectorAll('.isotope-filters li').forEach(function (filters) {
      filters.addEventListener('click', function () {
        isotopeItem.querySelector('.isotope-filters .filter-active').classList.remove('filter-active');
        this.classList.add('filter-active');
        initIsotope.arrange({
          filter: this.getAttribute('data-filter')
        });
        if (typeof aosInit === 'function') {
          aosInit();
        }
      }, false);
    });

  });

  /**
   * Init swiper sliders
   */
  function initSwiper() {
    document.querySelectorAll(".init-swiper").forEach(function (swiperElement) {
      let config = JSON.parse(
        swiperElement.querySelector(".swiper-config").innerHTML.trim()
      );

      if (swiperElement.classList.contains("swiper-tab")) {
        initSwiperWithCustomPagination(swiperElement, config);
      } else {
        new Swiper(swiperElement, config);
      }
    });
  }

  window.addEventListener("load", initSwiper);

  /**
   * Correct scrolling position upon page load for URLs containing hash links.
   */
  window.addEventListener('load', function (e) {
    if (window.location.hash) {
      if (document.querySelector(window.location.hash)) {
        setTimeout(() => {
          let section = document.querySelector(window.location.hash);
          let scrollMarginTop = getComputedStyle(section).scrollMarginTop;
          window.scrollTo({
            top: section.offsetTop - parseInt(scrollMarginTop),
            behavior: 'smooth'
          });
        }, 100);
      }
    }
  });

  /**
   * Navmenu Scrollspy
   */
  let navmenulinks = document.querySelectorAll('.navmenu a');

  function navmenuScrollspy() {
    navmenulinks.forEach(navmenulink => {
      if (!navmenulink.hash) return;
      let section = document.querySelector(navmenulink.hash);
      if (!section) return;
      let position = window.scrollY + 200;
      if (position >= section.offsetTop && position <= (section.offsetTop + section.offsetHeight)) {
        document.querySelectorAll('.navmenu a.active').forEach(link => link.classList.remove('active'));
        navmenulink.classList.add('active');
      } else {
        navmenulink.classList.remove('active');
      }
    })
  }
  window.addEventListener('load', navmenuScrollspy);
  document.addEventListener('scroll', navmenuScrollspy);

})();

// Cuando la imagen entra en el viewport, activa la clase visible
document.addEventListener('DOMContentLoaded', function () {
  const taxi = document.querySelector('.taxi-img');

  const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        taxi.classList.add('visible');
        observer.unobserve(taxi); // deja de observar (solo se ejecuta una vez)
      }
    });
  });

  observer.observe(taxi);
});



document.getElementById('formContacto').addEventListener('submit', function (e) {
  e.preventDefault(); // Evita el envio normal
  var buttonSend = $('#buttonSend');
  buttonSend.prop('disabled', true); // Deshabilita el boton para evitar multiples envios
  buttonSend.html('Enviando... <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
  var nombre = document.getElementById('nombre').value;
  var correo = document.getElementById('correo').value;
  var asunto = document.getElementById('asunto').value;
  var mensaje = document.getElementById('mensaje').value;
  // Crea un objeto FormData para enviar los datos
  var datos = new FormData();
  datos.append('nombre', nombre);
  datos.append('correo', correo);
  datos.append('asunto', asunto);
  datos.append('mensaje', mensaje);

  //verificar que los campos no esten vacios
  if (!datos.get('nombre') || !datos.get('correo') || !datos.get('asunto') || !datos.get('mensaje')) {
    alert('Por favor, completa todos los campos del formulario.');
    buttonSend.prop('disabled', false); // Habilita el boton nuevamente
    buttonSend.html('Enviar Mensaje');
    return;
  }

  fetch('mailContacto.php', {
    method: 'POST',
    body: datos
  })
    .then(response => response.json()) // Aqui espera JSON valido
    .then(data => {
      if (data.success) {
        alert(data.message);
        document.getElementById('formContacto').reset(); // Resetea el formulario
        buttonSend.prop('disabled', false);
        buttonSend.html('Enviar Mensaje');
      } else {
        alert('Error: ' + data.message);
        buttonSend.prop('disabled', false);
        buttonSend.html('Enviar Mensaje');
      }
    })
    .catch(error => {
      console.error('Error:', error);
      buttonSend.prop('disabled', false);
      buttonSend.html('Enviar Mensaje');
    });
});

document.getElementById('formReservacion').addEventListener('submit', function (e) {
  e.preventDefault(); // Evita el envio normal
  var buttonSend = $('#botonReservar');
  buttonSend.prop('disabled', true); // Deshabilita el boton para evitar multiples envios
  buttonSend.html('Enviando... <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
  var nombreReservacion = document.getElementById('nombreReservacion').value;
  var apellidoReservacion = document.getElementById('apellidoReservacion').value;
  var correoReservacion = document.getElementById('correoReservacion').value;
  var telefonoReservacion = document.getElementById('telefonoReservacion').value;
  var fechaReservacion = document.getElementById('fechaReservacion').value;
  var horaReservacion = document.getElementById('horaReservacion').value;
  var numeroPersonasReservacion = document.getElementById('numeroPersonasReservacion').value;
  var domicilioOrigenReservacion = document.getElementById('domicilioOrigenReservacion').value;
  var domicilioDestinoReservacion = document.getElementById('domicilioDestinoReservacion').value;
  var notasReservacion = document.getElementById('notasReservacion').value;
  // Crea un objeto FormData para enviar los datos
  var datos = new FormData();
  datos.append('nombreReservacion', nombreReservacion);
  datos.append('apellidoReservacion', apellidoReservacion);
  datos.append('correoReservacion', correoReservacion);
  datos.append('telefonoReservacion', telefonoReservacion);
  datos.append('fechaReservacion', fechaReservacion);
  datos.append('horaReservacion', horaReservacion);
  datos.append('numeroPersonasReservacion', numeroPersonasReservacion);
  datos.append('domicilioOrigenReservacion', domicilioOrigenReservacion);
  datos.append('domicilioDestinoReservacion', domicilioDestinoReservacion);
  datos.append('notasReservacion', notasReservacion);
  //verificar que los campos no esten vacios
  if (!datos.get('nombreReservacion') || !datos.get('apellidoReservacion') || !datos.get('correoReservacion') || !datos.get('telefonoReservacion') || !datos.get('fechaReservacion') || !datos.get('horaReservacion') || !datos.get('numeroPersonasReservacion') || !datos.get('domicilioOrigenReservacion') || !datos.get('domicilioDestinoReservacion') || !datos.get('notasReservacion')) {
    alert('Por favor, completa todos los campos del formulario.');
    buttonSend.prop('disabled', false); // Habilita el boton nuevamente
    buttonSend.html('Enviar Mensaje');
    return;
  }

  fetch('mailReservacion.php', {
    method: 'POST',
    body: datos
  })
    .then(response => response.json()) // Aqui espera JSON valido
    .then(data => {
      if (data.success) {
        alert(data.message);
        document.getElementById('formReservacion').reset(); // Resetea el formulario
        buttonSend.prop('disabled', false);
        buttonSend.html('Enviar Mensaje');
      } else {
        alert('Error: ' + data.message);
        buttonSend.prop('disabled', false);
        buttonSend.html('Enviar Mensaje');
      }
    })
    .catch(error => {
      console.error('Error:', error);
      buttonSend.prop('disabled', false);
      buttonSend.html('Enviar Mensaje');
    });
});