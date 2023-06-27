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
} catch (PDOException $e) {
  echo "Error de conexión a la base de datos: " . $e->getMessage();
  die();
}

// Ejecutar una consulta para obtener la información de los yates
$stmt = $pdo->query("SELECT * FROM yates");
$yates = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<style>
    .banner-section {
    width: 100%;
    height: 50vh; /* Ajusta la altura de la imagen según tus preferencias */
    background-image:  url("vistas/paginas/images/yate4.jpg"); /* Reemplaza 'ruta_de_la_imagen.jpg' por la ruta de tu imagen */
    background-size: cover;
    background-position: center;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 20px;
  }

  .banner-title {
    font-size: 28px;
    color: #fff;
    text-align: center;
  }
  .yates-section {
    padding: 20px;
  }

  .yates-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
  }

  .yate-card {
    background-color: #fff;
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
  }

  .yate-card:hover {
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
  }

  .yate-img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    border-radius: 8px;
  }

  .yate-details {
    margin-top: 10px;
  }

  .yate-name {
    font-size: 18px;
    font-weight: bold;
    margin-bottom: 5px;
  }

  .yate-description {
    margin-bottom: 10px;
  }

  .yate-line {
    border-top: 2px solid rgb(2, 150, 214);
    margin: 10px 0;
  }

  .yate-capacity,
  .yate-price {
    margin-bottom: 5px;
  }

  .yate-capacity-color {
  color: rgb(2, 150, 214);
}


  .btn-reserva {
    display: inline-block;
    background-color: #0277bd;
    color: #fff;
    padding: 8px 16px;
    border-radius: 4px;
    text-decoration: none;
    font-weight: bold;
  }

  .btn-reserva:hover {
    background-color: #01579b;
  }
</style>
<section class="banner-section">
  <div class="banner-title">
    <!-- Aquí puedes agregar un título o texto descriptivo para la imagen -->
  </div>
</section>

<section class="yates-section">
  <div class="container">
    <h2>Yates disponibles</h2>
    <div class="yates-grid">
      <?php foreach ($yates as $yate): ?>
        <div class="yate-card">
          <img src="vistas/paginas/images/<?php echo $yate['imagen']; ?>" alt="Imagen del yate" class="yate-img">
          <div class="yate-details">
            <h5 class="yate-name">
              <?php echo $yate['nombre']; ?>
            </h5>
            <p class="yate-description">
              <?php echo $yate['descripcion']; ?>
            </p>
            <hr class="yate-line">
            <p class="yate-capacity yate-capacity-color"><strong>Capacidad:</strong>
              <?php echo $yate['capacidad']; ?>
            </p>

            <p class="yate-price"><strong style="color: rgb(2, 150, 214);">Precio por hora:</strong> $
              <?php echo $yate['precio']; ?>
            </p><br><br>
            <div style="text-align: center;">
              <a href="registroreserva?id=<?php echo $yate['id']; ?>&descripcion=<?php echo urlencode($yate['descripcion']); ?>&imagen=<?php echo urlencode($yate['imagen']); ?>&nombre=<?php echo urlencode($yate['nombre']); ?>"
                class="btn btn-primary btn-block btn-flat"
                style="background-color: rgb(2, 150, 214); font-size: 20px; border-radius: 30px; width: 160px; font-weight: bold; display: inline-block; text-decoration: none; color: #fff;   ">
                Reservar </a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>