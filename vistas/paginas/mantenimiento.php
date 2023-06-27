<div class="content-wrapper" style="min-height: 717px;">

    <section class="content-header">

        <div class="container-fluid">

            <div class="row mb-2">

                <div class="col-sm-6">

                    <h1>PAGINA DE MANTENIMIENTO DE YATES</h1>

                </div>


            </div>

        </div><!-- /.container-fluid -->

    </section>

    <!-- Main content -->
    <section class="content">

        <div class="container">

            <hr>

            <?php
            // Conexión a la base de datos
            $conexion = mysqli_connect("localhost", "root", "", "reservas-yate");

            // Verificar si se ha enviado el formulario de editar
            if (isset($_POST["editar"])) {
                $id = $_POST["id"];
                $nombre = $_POST["nombre"];
                $capacidad = $_POST["capacidad"];
                $precio = $_POST["precio"];
                $descripcion = $_POST["descripcion"];

                // Procesar la nueva imagen si se ha enviado
                if (!empty($_FILES['imagen']['name'])) {
                    $imagen = $_FILES['imagen']['name']; // Obtener el nombre del archivo de imagen
                    $rutaImagen = "vistas/paginas/images/" . $imagen; // Ruta donde se guardará la nueva imagen
            
                    // Mover el archivo de imagen a la ruta especificada
                    if (move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaImagen)) {
                        // Actualizar los datos en la base de datos, incluyendo la nueva imagen
                        $sql = "UPDATE yates SET nombre='$nombre', capacidad=$capacidad, precio=$precio, descripcion='$descripcion', imagen='$imagen' WHERE id=$id";
                        mysqli_query($conexion, $sql);
                    } else {
                        echo "Error al subir la nueva imagen.";
                    }
                } else {
                    // Si no se envió una nueva imagen, actualizar los datos sin cambiar la imagen
                    $sql = "UPDATE yates SET nombre='$nombre', capacidad=$capacidad, precio=$precio, descripcion='$descripcion' WHERE id=$id";
                    mysqli_query($conexion, $sql);
                }
            }

            // Validar si se envió el formulario de agregar
            if (isset($_POST['agregar'])) {
                $id = $_POST['id'];
                $nombre = $_POST['nombre'];
                $capacidad = $_POST['capacidad'];
                $precio = $_POST['precio'];
                $descripcion = $_POST['descripcion'];

                // Validar que el ID no exista
                $query = "SELECT * FROM yates WHERE id = $id";
                $result = mysqli_query($conexion, $query);

                if (mysqli_num_rows($result) > 0) {
                    echo "El ID ya existe. Por favor ingrese otro ID.";
                } else {
                    // Procesar la imagen
                    $imagen = $_FILES['imagen']['name']; // Obtener el nombre del archivo de imagen
                    $rutaImagen = "vistas/paginas/images/" . $imagen; // Ruta donde se guardará la imagen
            
                    // Mover el archivo de imagen a la ruta especificada
                    if (move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaImagen)) {
                        // Insertar los datos en la base de datos
                        $query = "INSERT INTO yates (id, nombre, capacidad, descripcion, precio, imagen) VALUES ('$id', '$nombre', '$capacidad', '$descripcion', '$precio', '$imagen')";
                        $result = mysqli_query($conexion, $query);

                        if ($result) {
                            echo "Registro agregado exitosamente.";
                        } else {
                            echo "Error al agregar registro.";
                        }
                    } else {
                        echo "Error al subir la imagen.";
                    }
                }

            }

            // Validar si se envió el formulario de eliminar
            if (isset($_POST['eliminar'])) {
                $id = $_POST['id'];

                $query = "DELETE FROM yates WHERE id = $id";
                $result = mysqli_query($conexion, $query);

                if ($result) {
                    echo "Registro eliminado exitosamente.";
                } else {
                    echo "Error al eliminar registro.";
                }
            }
            ?>
            <div class="container">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="card">
                            <div class="card-body">
                                <h2>Agregar Yate</h2>
                                <form method="post" action="" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label for="id">ID:</label>
                                        <input type="number" class="form-control" name="id" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="nombre">Nombre:</label>
                                        <input type="text" class="form-control" name="nombre" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="capacidad">Capacidad:</label>
                                        <input type="number" class="form-control" name="capacidad" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="precio">Precio:</label>
                                        <input type="number" class="form-control" name="precio" step="0.01" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="descripcion">Descripción:</label>
                                        <input type="text" class="form-control" name="descripcion" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="imagen">Imagen:</label>
                                        <input type="file" class="form-control-file" name="imagen" accept="image/*"
                                            required>
                                    </div>
                                    <input type="submit" class="btn btn-primary" name="agregar" value="Agregar">
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="card">
                            <div class="card-body">
                                <h2>Editar yate</h2>
                                <form method="post" action="" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label for="id">ID:</label>
                                        <input type="number" class="form-control" name="id" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="nombre">Nombre:</label>
                                        <input type="text" class="form-control" name="nombre" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="capacidad">Capacidad:</label>
                                        <input type="number" class="form-control" name="capacidad" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="descripcion">Descripción:</label>
                                        <input type="text" class="form-control" name="descripcion" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="precio">Precio:</label>
                                        <input type="number" class="form-control" step="0.01" name="precio" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="imagen">Imagen:</label>
                                        <input type="file" class="form-control-file" name="imagen" accept="image/*">
                                    </div>
                                    <input type="submit" class="btn btn-primary" name="editar" value="Editar">
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="card">
                            <div class="card-body">
                                <h2>Eliminar yate</h2>
                                <form method="post" action="">
                                    <div class="form-group">
                                        <label for="id">ID:</label>
                                        <input type="number" class="form-control" name="id" required>
                                    </div>
                                    <input type="submit" class="btn btn-danger" name="eliminar" value="Eliminar">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="container">
                <div class="card">
                    <div class="card-body">
                        <h2>Lista de yates</h2>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Capacidad</th>
                                        <th>Descripción</th>
                                        <th>Precio</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = "SELECT * FROM yates";
                                    $result = mysqli_query($conexion, $sql);

                                    while ($fila = mysqli_fetch_assoc($result)) {
                                        $id = $fila["id"];
                                        $nombre = $fila["nombre"];
                                        $capacidad = $fila["capacidad"];
                                        $descripcion = $fila["descripcion"];
                                        $precio = $fila["precio"];

                                        echo "<tr>";
                                        echo "<td>$id</td>";
                                        echo "<td>$nombre</td>";
                                        echo "<td>$capacidad</td>";
                                        echo "<td>$descripcion</td>";
                                        echo "<td>$precio</td>";
                                        echo "</tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>



            <hr>


    </section>

</div>