document.addEventListener('DOMContentLoaded', function () {
    const navLinks = document.querySelectorAll('.nav-link');
  
    navLinks.forEach(link => {
        link.addEventListener('click', function () {
            // Remover la clase 'active' de todos los enlaces
            navLinks.forEach(link => link.classList.remove('active'));
  
            // Agregar la clase 'active' solo al enlace que fue clicado
            this.classList.add('active');
        });
    });
  });
  
  document.addEventListener('DOMContentLoaded', function () {
    const navLinks = document.querySelectorAll('.nav-link');
    const welcomeMessage = document.querySelector('.welcome-message');
    const searchBar = document.querySelector('.search-bar');
  
    navLinks.forEach(link => {
        link.addEventListener('click', function () {
            // Remover la clase 'active' de todos los enlaces
            navLinks.forEach(link => link.classList.remove('active'));
  
            // Agregar la clase 'active' solo al enlace que fue clicado
            this.classList.add('active');
  
            // Ocultar el mensaje de bienvenida y mostrar la barra de búsqueda
            if (this.textContent.trim() === "Préstamos" || this.textContent.trim() === "Devoluciones" || this.textContent.trim() === "Renovaciones") {
                welcomeMessage.style.display = 'none';
                searchBar.style.display = 'block'; // Mostrar la barra de búsqueda
            } else {
                welcomeMessage.style.display = 'block';
                searchBar.style.display = 'none'; // Ocultar la barra de búsqueda
            }
        });
    });
  });

  // Evento para cerrar sesión
  document.addEventListener('DOMContentLoaded', function () {
    const logoutButton = document.querySelector('#logoutButton'); // Asegúrate de que este ID exista en tu HTML

    if (logoutButton) {
        logoutButton.addEventListener('click', function (event) {
            event.preventDefault();

            fetch('php/logout.php', { method: 'GET' })
                .then(response => response.json())
                .then(data => {
                    if (data.status === "success") {
                        window.location.href = "index.html"; // Redirigir al login
                    }
                })
                .catch(error => console.error('Error al cerrar sesión:', error));
        });
    }
});