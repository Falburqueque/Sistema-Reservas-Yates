<?php

if ($admin["perfil"] != "Administrador") {

  echo '<script>

      window.location = "inicior";

    </script>';

  return;

}

?>
<?php
// Establecer los parámetros de conexión a la base de datos
$host = 'localhost';
$dbname = 'reservas-yate';
$user = 'root';
$password = '';

// Conectarse a la base de datos
try {
  $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // Obtener las últimas reservas y el total de ventas
  $reservas_query = "SELECT reservas.*, yates.nombre AS id, yates.precio
                   FROM reservas
                   INNER JOIN yates ON reservas.yate_id = yates.id
                   ORDER BY reservas.fecha_reserva DESC
                   LIMIT 5;";
  $reservas_stmt = $pdo->query($reservas_query);
  $reservas = $reservas_stmt->fetchAll(PDO::FETCH_ASSOC);

  $sql = "SELECT SUM(pago_reserva) AS total_pagos FROM reservas";
  $stmt = $pdo->prepare($sql);
  $stmt->execute();
  $total_pagos = $stmt->fetch(PDO::FETCH_ASSOC)['total_pagos'];

  // Consulta para obtener la cantidad de reservas
  $sql = "SELECT COUNT(*) as count FROM reservas";
  $stmt = $pdo->prepare($sql);
  $stmt->execute();
  $count = $stmt->fetch(PDO::FETCH_ASSOC)['count'];

  // Consulta para obtener la cantidad de reservas
  $sql = "SELECT COUNT(*) as count2 FROM administradores";
  $stmt = $pdo->prepare($sql);
  $stmt->execute();
  $count2 = $stmt->fetch(PDO::FETCH_ASSOC)['count2'];

  // Consulta para obtener la cantidad de reservas
  $sql = "SELECT COUNT(*) as count3 FROM yates";
  $stmt = $pdo->prepare($sql);
  $stmt->execute();
  $count3 = $stmt->fetch(PDO::FETCH_ASSOC)['count3'];

  // Consulta SQL para obtener el yate más reservado
  $sql = "SELECT yates.nombre, COUNT(*) AS total_reservas
  FROM reservas
  INNER JOIN yates ON reservas.yate_id = yates.id
  GROUP BY reservas.yate_id
  ORDER BY total_reservas DESC
  LIMIT 1";

  // Ejecutar la consulta
  $stmt = $pdo->query($sql);

  // Obtener los resultados
  $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
  echo "Error de conexión a la base de datos: " . $e->getMessage();
  die();
}
?>



<div class="content-wrapper" style="min-height: 717px;">

  <section class="content-header">

    <div class="container-fluid">

      <div class="row mb-2">

        <div class="col-sm-6">

          <h1>ANALISIS</h1>

        </div>

      </div>

    </div><!-- /.container-fluid -->

  </section>

  <!-- Main content -->
  <section class="content">

    <div class="container-fluid">

      <div class="row">

        <div class="col-12 col-sm-6 col-lg-3">

          <div class="small-box" style="background-color: white;">

            <div class="inner" style="text-align: center;">

              <p class="text-uppercase"><strong>VENTAS TOTALES</strong></p>


              <h3>$ <span>
                  <?= number_format($total_pagos) ?>
                </span></h3>


            </div>

            <div class="icon">

              <i class="fas fa-dollar-sign"></i>

            </div>

            <a href="reservas" class="small-box-footer" style="color: #00BFFF;background-color: white;">Más información
              <i class="fa fa-arrow-circle-right"></i></a>

          </div>

        </div>

        <!--=====================================
    Total Reservas
======================================-->

        <div class="col-12 col-sm-6 col-lg-3">

          <div class="small-box" style="background-color: white;">

            <div class="inner" style="text-align: center;">

              <p class="text-uppercase"><strong>RESERVAS</strong></p>


              <h3>
                <?= $count ?>
              </h3>


            </div>

            <div class="icon">

              <i class="far fa-calendar-alt"></i>

            </div>

            <a href="reservas" class="small-box-footer" style="color: #00BFFF;background-color: white;">Más información
              <i class="fa fa-arrow-circle-right"></i></a>

          </div>

        </div>

        <!--=====================================
    Total Usuarios
======================================-->

        <div class="col-12 col-sm-6 col-lg-3">

          <div class="small-box" style="background-color: white;">

            <div class="inner" style="text-align: center;">
              <p class="text-uppercase"><strong>USUARIOS</strong></p>

              <h3>
                <?= $count2 ?>
              </h3>


            </div>

            <div class="icon">

              <i class="fas fa-users"></i>

            </div>

            <a href="administradores" class="small-box-footer" style="color: #00BFFF;background-color: white;">Más información
              <i class="fa fa-arrow-circle-right"></i></a>

          </div>

        </div>

        <!--=====================================
    Total Yates
======================================-->

        <div class="col-12 col-sm-6 col-lg-3">

          <div class="small-box" style="background-color: white;">

            <div class="inner" style="text-align: center;">
              <p class="text-uppercase"><strong>Yates</strong></p>

              <h3>
                <?= $count3 ?>
              </h3>


            </div>

            <div class="icon">

              <i class="fas fa-anchor"></i>

            </div>


            <a href="usuarios" class="small-box-footer" style="color: #00BFFF ;background-color: white;">Más información
              <i class=" fa fa-arrow-circle-right"></i></a>

          </div>

        </div>


        <div class="card card-outline">

          <div class="card-header">
            <h5 class="m-0"><strong>ÚLTIMAS RESERVAS</strong></h5>
          </div>

          <div class="card-body">

            <ul>
              <?php foreach ($reservas as $reserva): ?>
                <li>
                  <strong style="color: rgb(2, 150, 214);">
                    <?= $reserva['id'] ?>
                  </strong><br>
                  Registrado:
                  <?= $reserva['fecha_reserva'] ?><br> Desde
                  <?= $reserva['fecha_inicio'] ?> Hasta
                  <?= $reserva['fecha_salida'] ?>
                </li>
              <?php endforeach; ?>

            </ul>


            <div>
              <div style="text-align: center;">
                <a href="reservas" class="btn btn-primary btn-block btn-flat"
                  style="background-color: rgb(2, 150, 214); font-size: 20px; border-radius: 30px; width: 180px; font-weight: bold; display: inline-block;">Ver
                  más reservas</a>
              </div>
            </div>

          </div>

        </div>
        <div class="images-container">
  <div class="image-container">
    <div class="image-title">Yate EJEMPLO 1</div>
    <img src="vistas/paginas/images/yate3.jpg" alt="Imagen 1" class="medium-image">
    <hr class="image-separator">
  </div>
  <div class="image-container">
    <div class="image-title">Yate EJEMPLO 2</div>
    <img src="vistas/paginas/images/yate2.jpg" alt="Imagen 2" class="medium-image">
    <hr class="image-separator">
  </div>
</div>

<style>
  .images-container {
    display: flex;
    align-items: center;
    justify-content: flex-start;
    margin-top: 20px;
    margin-left: 80px;
  }

  .image-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-right: 20px;
    position: relative;
  }

  .image-title {
    position: absolute;
    top: 20px;
    left: 20px;
    font-size: 24px;
    font-weight: bold;
    color: white;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);
  }

  .image-separator {
    width: 100%;
    height: 2px;
    background-color: white;
    margin-top: 8px;
    margin-bottom: 10px;
  }

  .images-container img {
    width: 500px; /* Ancho fijo */
    height: 300px; /* Alto fijo */
    border-radius: 5px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
   object-fit: cover; /* Ajusta la imagen al tamaño del contenedor */
}
</style>


    </div>

  </section>
</div>