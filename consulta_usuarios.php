<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Usuarios - Safe Residence</title>
    <link rel="stylesheet" href="css/estilos.css">
    <link rel="icon" href="Imagenes/logo.ico">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <!--logo-->
    <header>
        <div class="contenedor_logo_izquierdo">
            <img src="Imagenes/logo.png" alt="logo">
        </div>
    </header>
    <main>
        <div class="contenedor_consulta_usurios">
            <h1>Consulta de Usuarios</h1>
            <!--tabla con la informacion de consulta de usuarios-->
            <table action="consultaUsuarios.php" method="POST">
                <tr>
                    <th>Cedula</th>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>Apto</th>
                    <th>Telefono</th>
                    <th>E-mail</th>
                    <th>Usuario</th>
                    <th>Editar</th>

                </tr>
                <!--Datos de los usuarios-->
                <?php
                //Consultar tabla usuarios
                include("consultaUsuarios.php");
                $stmt = $conn->prepare("$query");
                $stmt->execute();
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row["cedula"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["nombres"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["apellidos"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["apartamento"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["telefono"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["email"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["usuario"]) . "</td>";
                    echo "<td>
                        <div class='checkbox-container'>
                            <button>
                                <i class='fa-solid fa-user-pen'></i>
                            </button>
                        </div>
                    </td>";
                    echo "</tr>";
                }

                ?>

                <!--
                    <td>1072548987</td>
                    <td>Oscar Daniel</td>
                    <td>Fernandez Fernandez</td>
                    <td>401</td>
                    <td>3155555555</td>
                    <td>eeeee@gmail.com</td>
                    <td>Fer_2023</td>
                    -->
            </table>


        </div>
        <!--boton de cerrar sesion -->
        <div class="contenedor_cerrar_sesion_consulta">
            <a href="login.html" class="boton_cerrar_sesion">Cerrar Sesión</a>



            <!--menu lateral derecho -->

            <div class="contenedor_menu">
                <a href="index.html">Regresar</a>
                <a href="consulta_ingresos_salidas.html">
                    <i class="fa-regular fa-pen-to-square"></i>
                    <a href="consulta_ingresos_salidas.html">Reportes</a>
                </a>
                <a href="#">
                    <i class="fa-regular fa-file-pdf"></i>
                    <i class="fa-solid fa-print"></i>
                    <a href="#">Imprimir PDF</a>
                </a>
                <a href="#">
                    <i class="fa-regular fa-file-excel"></i>
                    <a href="#">Exportar Xls</a>
                </a>
                <a href="index.html">
                    <i class="fa-solid fa-house"></i>
                    <a href="index.html">Inicio</a>
                </a>
            </div>

    </main>



</body>

</html>