<?php
// Establecer los parámetros de conexión a la base de datos
$host = 'localhost';
$dbname = 'reservas-yate';
$user = 'root';
$password = '';

$url = $_SERVER['REQUEST_URI'];
// Analizar la URL para obtener los componentes
$components = parse_url($url);
// Obtener los parámetros de la consulta
parse_str($components['query'], $queryParameters);
// Verificar si los parámetros necesarios están presentes en la URL
if (isset($queryParameters['id']) && isset($queryParameters['descripcion']) && isset($queryParameters['imagen']) && isset($queryParameters['nombre'])) {
    $id = $queryParameters['id'];
    $yate_id = $id;
    $descripcion = $queryParameters['descripcion'];
    $imagen = $queryParameters['imagen'];
    $nombre = $queryParameters['nombre'];

    // Conectarse a la base de datos
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "Error de conexión a la base de datos: " . $e->getMessage();
        die();
    }

    // Obtener el precio del yate
    $stmt = $pdo->prepare("SELECT precio FROM yates WHERE id = ?");
    $stmt->execute([$yate_id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $precio = $row['precio'];
} else {
    echo "No se proporcionó un ID válido.";
    // Puedes mostrar un mensaje de error o redireccionar a otra página en caso de que no se proporcione el ID en la URL
    die();
}
date_default_timezone_set('America/Lima');
// Obtener la fecha actual
$fecha_actual = date('Y-m-d');

if (isset($_POST['submit'])) {
    // Recuperar los datos del formulario
    $administrador_id = $_SESSION['idBackend'];
    $fecha_reserva = date('Y-m-d');
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_salida = $_POST['fecha_salida'];
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];

    // Calcular el pago de la reserva
    $horas = (strtotime($fecha_salida) - strtotime($fecha_inicio)) / 3600;
    $pago_reserva = $precio * $horas;

    // Insertar la reserva en la tabla 'reservas'
    $stmt = $pdo->prepare("INSERT INTO reservas (yate_id, administrador_id, fecha_reserva, fecha_inicio, fecha_salida, pago_reserva, nombre, correo, telefono) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$yate_id, $administrador_id, $fecha_reserva, $fecha_inicio, $fecha_salida, $pago_reserva, $nombre, $correo, $telefono]);
}
?>
<section class="content" style="display: flex;">
    <div class="col-md-8" style="flex: 1;">
        <div class="card" style="height: 100%;">
            <img src="vistas/paginas/images/<?php echo $imagen; ?>" class="card-img-top" alt="Foto del yate"
                style="width: 100%; height: 100%; object-fit: cover;">
        </div>
    </div>
    <div class="col-md-4"
        style="flex: 1; display: flex; flex-direction: column; justify-content: center; align-items: center;">
        <div class="card" style="height: 100%; background-color: #ffffff; width: 80%;">
            <div class="card-body">
                <h2>
                    <?php echo $nombre; ?>
                </h2>
                <p>
                    <?php echo $descripcion; ?>
                </p>
                <div class="card" style="background-color:#e5efee;">
                    <div class="card-body">
                        <form method="post">
                            <div class="form-group">
                                <input type="hidden" name="yate_id" value="<?php echo $yate_id; ?>">
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="nombre">Ingrese nombre:</label>
                                <input type="text" name="nombre" id="nombre" class="form-control" required>
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="correo">Ingrese correo:</label>
                                <input type="text" name="correo" id="correo" class="form-control" required>
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="telefono">Ingrese teléfono por favor:</label>
                                <input type="text" name="telefono" id="telefono" class="form-control" required>
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="fecha_inicio">Fecha de inicio:</label>
                                <input type="text" name="fecha_inicio" id="fecha_inicio" class="form-control" required>
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="fecha_salida">Fecha de salida:</label>
                                <input type="text" name="fecha_salida" id="fecha_salida" class="form-control" required>
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="cantidad_horas_label">
                                    <span style="font-size: 16px;"></span>
                                </label>
                                <label id="cantidad_horas_label"></label>
                            </div>
                            <div class="form-group">
                                <label for="monto_reserva">
                                    <span style="font-size: 16px;">TOTAL:</span>
                                    <span style="font-size: 20px; margin-left: 10px;">$ </span>
                                    <span id="monto_reserva_label" style="font-size: 50px;">00.00</span>
                                </label>
                            </div>
                            <br>
                            <div style="text-align: center;">
                                <button type="submit" name="submit" class="btn btn-primary btn-block btn-flat"
                                    style="background-color: rgb(2, 150, 214); font-size: 24px; border-radius: 30px; width: 200px; font-weight: bold; display: inline-block;">Generar
                                    reserva</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr>
</section>



<script>
    // Configurar Flatpickr para los campos de fecha de inicio y fecha de salida
    flatpickr("#fecha_inicio", {
        enableTime: true,
        dateFormat: "Y-m-d H:i",
        minuteIncrement: 30,
        minDate: "today"
    });

    flatpickr("#fecha_salida", {
        enableTime: true,
        dateFormat: "Y-m-d H:i",
        minuteIncrement: 30,
        minDate: "today"
    });

    // Actualizar el monto de reserva al cambiar las fechas
    function actualizarMontoReserva() {
        var fechaInicio = document.getElementById("fecha_inicio").value;
        var fechaSalida = document.getElementById("fecha_salida").value;
        var minutos = (new Date(fechaSalida).getMinutes() - new Date(fechaInicio).getMinutes()) % 60;

        if (fechaInicio !== "" && fechaSalida !== "") {
            var precio = <?php echo $precio; ?>;
            var horas = (new Date(fechaSalida) - new Date(fechaInicio)) / 3600000; // Convertir la diferencia de tiempo a horas
            var cantidadHoras = "";

            if (horas < 1) {
                cantidadHoras = minutos + " minutos";
            } else {
                var horasCompletas = Math.floor(horas);
                var minutosRestantes = minutos > 0 ? " y " + minutos + " minutos" : "";
                cantidadHoras = horasCompletas === 1 ? "1 hora" : horasCompletas + " horas";
                cantidadHoras += minutosRestantes;
            }

            var montoReserva = precio * horas;
            document.getElementById("cantidad_horas_label").innerHTML = "Haz reservado: " + cantidadHoras;
            document.getElementById("monto_reserva_label").innerHTML = montoReserva.toFixed(2); // Mostrar el monto con 2 decimales
        } else {
            document.getElementById("cantidad_horas_label").innerHTML = ""; // Si las fechas no están completas, la cantidad de horas se muestra vacía
            document.getElementById("monto_reserva_label").innerHTML = ""; // Si las fechas no están completas, el monto se muestra vacío
        }
    }

    // Agregar event listeners para los campos de fecha de inicio y fecha de salida
    document.getElementById("fecha_inicio").addEventListener("change", actualizarMontoReserva);
    document.getElementById("fecha_salida").addEventListener("change", actualizarMontoReserva);
</script>