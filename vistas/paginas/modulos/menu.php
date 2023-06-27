<aside class="main-sidebar sidebar-dark-primary elevation-4 bg-black">

  <!--=====================================
              LOGO
  ======================================-->
  <a href="inicio" class="brand-link">

    <img src="vistas/img/plantilla/icono.jpg" class="brand-image img-circle elevation-3" style="opacity: .8">

    <span class="brand-text font-weight-light text-center" style="width: 150px">YATES RESERVE</span>

  </a>

  <!--=====================================
                  MENÚ
  ======================================-->

  <div class="sidebar">

    <nav class="mt-2">

      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <br>


        <!-- Botón página inicio -->

        <li class="nav-item">

          <a href="inicio" class="nav-link">

            <i class="nav-icon fas fa-home"></i>

            <p>INICIO</p>

          </a>

        </li>

        <!-- Botón página banner -->

        <li class="nav-item">

          <a href="inicior" class="nav-link">

            <i class="nav-icon far fa-images"></i>
            <p>
              RESERVAR
            </p>
          </a>
        </li>

        <!-- Botón página planes -->
        <?php if ($admin["perfil"] == "Administrador"): ?>




          <li class="nav-item">

            <a href="reservas" class="nav-link">

              <i class="nav-icon far fa-calendar-alt"></i>

              <p>HISTORIAL DE RESERVAS</p>

            </a>

          </li>


          <li class="nav-item">

            <a href="mantenimiento" class="nav-link">

              <i class="nav-icon fas fa-shopping-bag"></i>

              <p>AGREGAR YATES</p>

            </a>

          </li>
        <?php endif ?>

        <!-- Botón página categorías 

        <li class="nav-item">
          
          <a href="categorias" class="nav-link">
            
            <i class="nav-icon fas fa-list-ul"></i>
            
            <p>CATEGORIAS</p>
          
          </a>

        </li>-->
        <!--*************************************************************************
        <!-- Botón página habitaciones -->

        <!--<li class="nav-item">

          <a href="habitaciones" class="nav-link">

            <i class="nav-icon fas fa-bed"></i>
            
            <p>HABITACIONES</p>

          </a>

        </li>-->
        <!--*************************************************************************

        <!-- Botón página reservas -->


        <!-- Botón página testimonios

        <li class="nav-item">

          <a href="testimonios" class="nav-link">

            <i class="nav-icon fas fa-user-check"></i>

            <p>TESTIMONIOS</p>

          </a>

        </li>

        <!-- Botón página usuarios 
        <!-- Botón página administradores -->

        <?php if ($admin["perfil"] == "Administrador"): ?>

          <li class="nav-item">

            <a href="administradores" class="nav-link">

              <i class="nav-icon fas fa-users-cog"></i>

              <p>ADMINISTRADORES</p>

            </a>

          </li>

        <?php endif ?>

        <li class="nav-item">

          <a href="cerrar-sesion" class="nav-link">

            <i class="nav-icon  fa fa-power-off"></i>

            <p>SALIR DEL SISTEMA</p>

          </a>

        </li>

      </ul>

    </nav>

  </div>

</aside>

<script>
  // Obtener el enlace seleccionado almacenado en el almacenamiento local
  const selectedLink = localStorage.getItem('selectedLink');

  // Obtener todas las etiquetas <a> del menú
  const menuLinks = document.querySelectorAll('.sidebar .nav-link');

  // Iterar sobre cada enlace del menú
  menuLinks.forEach(link => {
    link.addEventListener('click', function(event) {
      // Remover la clase "active" de todos los enlaces del menú
      menuLinks.forEach(link => {
        link.classList.remove('active');
      });
      // Agregar la clase "active" al enlace seleccionado
      this.classList.add('active');
      // Almacenar el enlace seleccionado en el almacenamiento local
      localStorage.setItem('selectedLink', this.href);
    });
    
    // Aplicar el estilo "active" al enlace seleccionado al cargar la página
    if (link.href === selectedLink) {
      link.classList.add('active');
    }
  });
</script>

<style>
.nav-link.active {
  background-color: #00BFFF;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
}

</style>
