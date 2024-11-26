<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Mi carrito</title>
        <link rel="icon" href="img/Captura1.ico">
        <link href="css/csscarrito.css" rel="stylesheet" type="text/css"/>
    </head>
    <body> 
        <h1>Mi Carrito</h1>

        <?php
        if (!isset($_SESSION['user_id'])) {
            echo '<a href="login.php" class="volver-link">Debe registrar la sesion</a>';
        }else{
            
//        $_SESSION['user_id'] = $usuario['ID'];
//        $_SESSION['user_name'] = $usuario['Nombre'];
// Verifica si la variable de sesión 'carrito' existe
            if (!isset($_SESSION['carrito'])) {
                $_SESSION['carrito'] = array();
            }

// Elimina el producto del carrito si se ha enviado un parámetro 'eliminar'
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar'])) {
                $eliminarProducto = $_POST['eliminar'];

                // Encuentra la posición del producto en el carrito
                $index = -1;
                foreach ($_SESSION['carrito'] as $key => $item) {
                    if ($item['producto'] === $eliminarProducto) {
                        $index = $key;
                        break;
                    }
                }

                // Si se encontró el producto, elimínalo
                if ($index !== -1) {
                    array_splice($_SESSION['carrito'], $index, 1);
                }
            }

// Agrega el producto al carrito si se reciben parámetros del formulario
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['producto']) && isset($_POST['precio']) && isset($_POST['imagen'])) {
                $producto = $_POST['producto'];
                $precio = $_POST['precio'];
                $imagen = $_POST['imagen'];

                // Agrega el producto al carrito
                $_SESSION['carrito'][] = array('producto' => $producto, 'precio' => $precio, 'imagen' => $imagen);

                // Puedes devolver una respuesta si es necesario (puedes ajustar esto según tus necesidades)
                // echo 'Producto agregado al carrito';
            }


            // Mostrar el total de items en la parte superior
            $totalitems = 0;
            if (isset($_SESSION['carrito'])) {
                $totalitems = count($_SESSION['carrito']);
            }
            echo "<div id=totalItems> $totalitems </div>";
            echo '<h2>Numero de productos: ' . $totalitems . '</h2>';
// Mostrar productos en el carrito
            if (!empty($_SESSION['carrito'])) {
                echo '<table border="1">';
                echo '<tr>';
                echo '<th>DESCARTAR</th>';
                echo '<th>IMAGEN</th>';
                echo '<th>NOMBRE DEL PRODUCTO</th>';
                echo '<th>PRECIO</th>';
                echo '</tr>';
// Incluir el archivo que contiene la función
                include('MENUPRINCIPAL/funciones.php');
                $totalcarrito = 0;
                foreach ($_SESSION['carrito'] as $item) {
                    $totalcarrito += $item['precio'];
                    echo '<tr>';
                    echo '<form method="post">';
                    echo '<input type="hidden" name="eliminar" value="' . htmlspecialchars($item['producto']) . '">';
                    echo '<td><button type="submit" class="eliminar">Descartar</button></td>';
                    echo '</form>';
                    echo '<td><img src="' . obtenerRutaImagenProducto($item['imagen']) . '" alt="' . htmlspecialchars($item['producto']) . '" width="50"></td>';
                    echo '<td>' . htmlspecialchars($item['producto']) . '</td>';
                    echo '<td>' . $item['precio'] . '</td>';
                    echo '</tr>';
                }
                echo '</table>';
                echo '<div id="totalCarrito" style="text-align: center;">Total carrito: ' . $totalcarrito . '</div>';
                // Mostrar el número total de productos dentro de <h2>
            } else {
                echo '<p>No hay productos en el carrito.</p>';
            }
        }
        ?>
        <br>
    <center> <a href="Tienda.php" class="volver-link">Volver</a></center>
</body>
</html>