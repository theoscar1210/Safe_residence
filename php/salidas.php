<?php
session_start(); // Iniciar la sesión

include('conecta.php'); // Incluir el archivo que establece la conexión a la base de datos

// Verificar si el usuario está autenticado y tiene el rol adecuado (en este caso, el rol del Vigilante es 6)
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 6) {
    header("Location: login.php?error=Acceso no autorizado"); // Si no está autorizado, redirigir al login con un mensaje de error
    exit();
}


try {
    // Consulta para obtener los ingresos que aún no tienen salida registrada
    $stmt = $conn->prepare("SELECT * FROM ingresos WHERE h_salida IS NULL");
    $stmt->execute(); // Ejecutar la consulta
    $ingresos = $stmt->fetchAll(PDO::FETCH_ASSOC); // Obtener todos los registros de ingresos sin salida y almacenarlos en un arreglo asociativo
} catch (PDOException $e) {
    // Si ocurre un error al ejecutar la consulta, guardar el mensaje de error en la sesión
    $_SESSION['error'] = "Error al obtener los ingresos: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Salida - Safe Residence</title>
    <link rel="stylesheet" href="../css/estilos.css"> <!-- Estilos personalizados -->
    <link rel="icon" href="../Imagenes/logo.ico"> <!-- Favicon del sitio -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        //funcion que filtra los datos en la tabla segun lo que el usuario escriba
        function filtrarTabla() {
            let input = document.getElementById("busqueda");
            let filter = input.value.toLowerCase();
            let table = document.querySelector("table");
            let tr = table.getElementsByTagName("tr");

            for (let i = 1; i < tr.length; i++) {
                let tds = tr[i].getElementsByTagName("td");
                tr[i].style.display = "none"; //ocultar inicalmente

                for (let j = 0; j < tds.length; j++) {
                    let td = tds[j];
                    if (td && td.innerHTML.toLowerCase().indexOf(filter) > -1) {
                        tr[i].style.display = ""; //mostrar si hay coincidencia
                        break;
                    }
                }

            }
        }
    </script>
</head>


<body>
    <!-- Encabezado con logo -->
    <header>
        <div class="contenedor_logo_izquierdo">
            <img src="../Imagenes/logo.png" alt="logo"> <!-- Logo del proyecto Safe Residence -->
        </div>
    </header>

    <main>
        <div class="contenedor_salida_del_personal">

            <h1>Registrar Salida del Personal</h1>
            <!--mostrar mensaje de exito si existe -->

            <?php
            if (isset($_SESSION['success'])): ?>
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Éxito',
                        text: '<?= htmlspecialchars($_SESSION['success']); ?>'
                    });
                </script>

            <?php
                unset($_SESSION['success']); //limpiar el mensaje
            endif; ?>

            <!--Mostrar mensaje de error si existe-->
            <?php

            if (isset($_SESSION['error'])) {
                echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: '{$_SESSION['error']}'
                });
            </script>";
                unset($_SESSION['error']); // Limpiar el mensaje después de mostrarlo
            }
            ?>


            <!-- Filtro de búsqueda para facilitar la localización de ingresos -->
            <div class="container_buscar">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" id="busqueda" placeholder="Buscar..." onkeyup="filtrarTabla()"> <!-- Input para filtrar registros -->
            </div>

            <!-- Formulario para seleccionar las salidas -->
            <form method="POST" action="process_salida.php"> <!-- Se enviará el formulario a "process_salida.php" -->
                <table>

                    <tr>
                        <th>Seleccionar</th>
                        <th>Fecha Ingreso</th>
                        <th>Nombres</th>
                        <th>Apellidos</th>
                        <th>Cédula</th>
                        <th>Tipo de Ingreso</th>
                        <th>Apartamento</th>
                        <th>Medio de Ingreso</th>
                        <th>Observaciones</th>
                    </tr>


                    <!-- Verificar si hay registros de ingresos sin salida -->
                    <?php if (!empty($ingresos)): ?>
                        <!-- Mostrar cada ingreso disponible -->
                        <?php foreach ($ingresos as $ingreso): ?>
                            <tr class="table-info">
                                <td><input type="checkbox" name="salidas[]" value="<?= $ingreso['id_ingreso']; ?>"></td> <!-- Checkbox para seleccionar el registro -->
                                <td><?= htmlspecialchars($ingreso['fecha']); ?></td> <!-- Fecha de ingreso -->
                                <td><?= htmlspecialchars($ingreso['nombres']); ?></td> <!-- Nombres del visitante -->
                                <td><?= htmlspecialchars($ingreso['apellidos']); ?></td> <!-- Apellidos del visitante -->
                                <td><?= htmlspecialchars($ingreso['cedula']); ?></td> <!-- Cédula del visitante -->
                                <td><?= htmlspecialchars($ingreso['rol']); ?></td> <!-- Tipo de ingreso o rol (según columna) -->
                                <td><?= htmlspecialchars($ingreso['apartamento']); ?></td> <!-- Apartamento al que se dirige -->
                                <td><?= htmlspecialchars($ingreso['vehiculo']); ?></td> <!--meidio de ingreso  (vehiculo, bicicleta, camioneta)-->
                                <td><?= htmlspecialchars($ingreso['observaciones']); ?></td> <!-- Observaciones registradas -->
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <!-- Mostrar mensaje si no hay ingresos disponibles para registrar salida -->
                        <tr>
                            <td colspan="8">No hay ingresos registrados sin salida.</td>
                        </tr>
                    <?php endif; ?>
                </table>


                <!-- Sección de paginación, si es necesario implementar más adelante -->
                <div class="paginacion">
                    <button type="button" onclick="prevPage()">Anterior</button>
                    <span id="pagina_num">Página 1</span> <!-- Indicador de la página actual -->
                    <button type="button" onclick="nextPage()">Siguiente</button>
                </div>
        </div>

        <!-- Menú lateral derecho con opciones -->


        <div class="contenedor_menu_4">
            <a href="registro_ingreso.php">Regresar</a> <!-- Enlace para regresar a una página anterior -->
            <a href="registro_ingreso.php">
                <i class="fa-solid fa-file-circle-plus"></i>
                Nuevo Ingreso <!-- Enlace para registrar un nuevo ingreso -->
            </a>

            <!-- Botón para registrar la salida seleccionada -->
            <button type="submit">Registrar Salida</button>
            </form>
        </div>

        </div>
    </main>


</body>

</html>