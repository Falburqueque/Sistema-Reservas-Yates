<?php
$conexion = mysqli_connect("localhost", "root", "", "reservas-yate");

$resultado = mysqli_query($conexion, "SELECT reservas.id AS reserva_numero, yates.nombre AS yate_nombre, administradores.nombre AS administrador_nombre, reservas.nombre, reservas.correo, reservas.telefono, fecha_reserva, fecha_inicio, fecha_salida, pago_reserva  FROM reservas INNER JOIN yates ON reservas.yate_id = yates.id INNER JOIN administradores ON reservas.administrador_id = administradores.id ORDER BY reservas.id DESC");

mysqli_close($conexion);
?>

<div class="content-wrapper" style="min-height: 717px;">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>PAGINA DE LISTADO DE RESERVAS</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <style>
            table {
                border-collapse: collapse;
                width: 100%;
            }

            th,
            td {
                text-align: left;
                padding: 8px;
            }

            th {
                background-color: #0397d7;
                color: white;
            }

            tr:nth-child(even) {
                background-color: #f2f2f2;
            }

            .orden-asc::after {
                content: " ↓↑";
            }

            .orden-desc::after {
                content: " ↑↓";
            }

            .orden-btn-container {
                background-color: transparent;
            }

            .orden-btn-container button {
                background-color: #0397d7;
                color: white;
                border: none;
                padding: 8px 16px;
                font-size: 14px;
                cursor: pointer;
                transition: background-color 0.3s;
            }

            .orden-btn-container button:hover {
                background-color: #037abf;
            }
        </style>
        <div class="col-sm-6">
            <h3>Listado de Reservas</h3>
        </div>

        <table id="reservas-table" class="orden-btn-container">
            <tr>
                <th><button id="ordenar-btn" class="orden-desc"></button></th>
                <th>Yate</th>
                <th>Administrador</th>
                <th>Fecha de Reserva</th>
                <th>Fecha de Inicio</th>
                <th>Fecha de Salida</th>
                <th>Acciones</th>
            </tr>
            <style>
  .contador-cell {
    padding-left: 25px;
  }
</style>
            <?php
            $contador = mysqli_num_rows($resultado);
            while ($fila = mysqli_fetch_array($resultado)) {
                echo "<tr>";
                echo '<td class="contador-cell">' . $contador . '</td>';
                echo "<td>" . $fila['yate_nombre'] . "</td>";
                echo "<td>" . $fila['administrador_nombre'] . "</td>";
                echo "<td>" . $fila['fecha_reserva'] . "</td>";
                echo "<td>" . $fila['fecha_inicio'] . "</td>";
                echo "<td>" . $fila['fecha_salida'] . "</td>";
                echo '<td><button class="ver-btn" data-id="' . $fila['reserva_numero'] . '" data-nombre="' . $fila['nombre'] . '" data-correo="' . $fila['correo'] . '" data-telefono="' .  $fila['telefono'] .'" data-pago_reserva="'. $fila['pago_reserva'] . '">VER</button></td>';
                echo "</tr>";

                $contador--;
            }
            ?>
        </table>

        </table>
    </section>
</div>

<script>
    var reservasTable = document.getElementById('reservas-table');
    var ordenarBtn = document.getElementById('ordenar-btn');
    var ordenDescendente = true;

    ordenarBtn.addEventListener('click', function () {
        if (ordenDescendente) {
            ordenarBtn.classList.remove('orden-desc');
            ordenarBtn.classList.add('orden-asc');
            Array.from(reservasTable.rows)
                .slice(1)
                .sort(function (a, b) {
                    var valorA = parseInt(a.cells[0].textContent);
                    var valorB = parseInt(b.cells[0].textContent);
                    return valorA - valorB;
                })
                .forEach(function (row, index) {
                    row.cells[0].textContent = index + 1;
                    reservasTable.appendChild(row);
                });
        } else {
            ordenarBtn.classList.remove('orden-asc');
            ordenarBtn.classList.add('orden-desc');
            Array.from(reservasTable.rows)
                .slice(1)
                .sort(function (a, b) {
                    var valorA = parseInt(a.cells[0].textContent);
                    var valorB = parseInt(b.cells[0].textContent);
                    return valorB - valorA;
                })
                .forEach(function (row, index) {
                    row.cells[0].textContent = reservasTable.rows.length - index - 1;
                    reservasTable.appendChild(row);
                });
        }

        ordenDescendente = !ordenDescendente;
    });
</script>
<style>
    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.4);
    }

    .modal-content {
        background-color: #fff;
        margin: 10% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 60%;
        max-width: 600px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
    }

    .modal-header {
        text-align: center;
        margin-bottom: 20px;
    }

    .modal-title {
        font-size: 24px;
        color: rgb(2, 150, 214);
        margin-bottom: 10px;
    }

    .close {
        color: #888;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
        position: absolute;
        top: 10px;
        right: 20px;
    }

    .modal-details {
        margin-bottom: 10px;
    }

    .modal-details p {
        margin: 5px 0;
    }
</style>

<!-- Código HTML del modal -->
<div id="modal-ver-reserva" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <div class="modal-header">
            <h2 class="modal-title">Detalles de la Reserva</h2>
        </div>
        <div class="modal-details">
            <p><strong>ID:</strong> <span id="modal-reserva-id"></span></p>
            <p><strong>Nombre:</strong> <span id="modal-reserva-nombre"></span></p>
            <p><strong>Correo:</strong> <span id="modal-reserva-correo"></span></p>
            <p><strong>Teléfono:</strong> <span id="modal-reserva-telefono"></span></p>
            <p><strong>Total:$</strong> <span id="modal-reserva-pago_reserva"></span></p>

        </div>
    </div>
</div>



<!-- JavaScript para mostrar el modal y los detalles de la reserva -->
<script>
    var modal = document.getElementById("modal-ver-reserva");
    var btns = document.getElementsByClassName("ver-btn");
    var span = document.getElementsByClassName("close")[0];

    for (var i = 0; i < btns.length; i++) {
        btns[i].onclick = function () {
            var reservaId = this.getAttribute("data-id");
            var reservaNombre = this.getAttribute("data-nombre");
            var reservaCorreo = this.getAttribute("data-correo");
            var reservaTelefono = this.getAttribute("data-telefono");
            var reservaTotal = this.getAttribute("data-pago_reserva");


            document.getElementById("modal-reserva-id").textContent = reservaId;
            document.getElementById("modal-reserva-nombre").textContent = reservaNombre;
            document.getElementById("modal-reserva-correo").textContent = reservaCorreo;
            document.getElementById("modal-reserva-telefono").textContent = reservaTelefono;
            document.getElementById("modal-reserva-pago_reserva").textContent = reservaTotal    ;


            modal.style.display = "block";
        };
    }

    span.onclick = function () {
        modal.style.display = "none";
    };

    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    };
</script>