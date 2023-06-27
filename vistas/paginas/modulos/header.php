<?php 

$notificaciones = ControladorInicio::ctrMostrarNotificaciones();

$totalNotificaciones = 0;
$totalReservas = 0;
$totalTestimonios = 0;

foreach ($notificaciones as $key => $value) {

   $totalNotificaciones += $value["cantidad"];

    if($value["tipo"] == "reservas"){
      
      $totalReservas = $value["cantidad"];

    }else{

      $totalTestimonios = $value["cantidad"];
    
    }
}

?>

<nav class="main-header navbar navbar-expand navbar-white navbar-light border-bottom">

  <!--=====================================
  Botón que colapsa el menú lateral
  ======================================--> 

  <ul class="navbar-nav"> 

    <li class="nav-item">
      
      <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
    
    </li>

    <li class="nav-item d-none d-sm-inline-block">

    <a class="nav-link" style="font-weight: bold; color: black;">
  Hola: <?php echo $admin["nombre"]; ?>
</a>

    </li>

  </ul>
  



  <!--=====================================
          Notificaciones
  ======================================--> 

  <ul class="navbar-nav ml-auto" class="breadcrumb float-sm-right">


    <li class="nav-item d-none d-sm-inline-block">

    <a class="nav-link" href="inicio" style="color: black; font-weight: bold;">INICIO</a>

    </li>
    <li class="nav-item d-none d-sm-inline-block">

    <a class="nav-link black-link" href="reservas" style="color: black; font-weight: bold;">HISTORIAL DE RESERVAS</a>

    </li>
    <?php if ($admin["perfil"] == "Administrador"): ?>
    <li class="nav-item d-none d-sm-inline-block">

      <a class="nav-link" href="mantenimiento"  style="color: black; font-weight: bold;">AGREGAR YATE </a>

    </li>
    <?php endif ?>



    <li class="nav-item dropdown">

      <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">

        <i class="far fa-bell"></i>

        <span class="badge badge-danger navbar-badge"><?php if($totalNotificaciones != 0){echo $totalNotificaciones;}  ?></span>

      </a>

      <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        
        <span class="dropdown-item dropdown-header"><?php echo $totalNotificaciones; ?> Notificaciones</span>

        <div class="dropdown-divider"></div>

        <a href="index.php?pagina=reservas&not=0" class="dropdown-item">

          <i class="far fa-calendar-alt mr-2 float-right"></i>

          <span class="badge badge-warning "><?php echo $totalReservas; ?> RESERVAS NUEVAS</span>

        </a>

         <div class="dropdown-divider"></div>

        <a href="index.php?pagina=testimonios&not=0" class="dropdown-item">

          <i class="fas fa-user-check mr-2 float-right"></i>

          <span class="badge badge-warning "><?php echo $totalTestimonios; ?> USUARIOS</span>

        </a>

      </div>

    </li>
  
      <!--=====================================
            BOTON SALIR DEL SISTEMA
  ======================================--> 

            <li class="user-body">
              
              <div class="pull-right">
                
              <a href="salir" class="btn btn-dark"  style="width: 180px; font-weight: bold; ">CERRAR SESION</a>

              </div>

    </ul>

  </nav>

          
        


