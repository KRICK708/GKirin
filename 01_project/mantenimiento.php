<?php
include 'conexion.php'; // Incluir el archivo de conexión

// Manejar las operaciones CRUD
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['accion'])) {
        if ($_POST['accion'] == 'crear') {
            $sql = "INSERT INTO productos (producto, categoria, stock, precio) VALUES (?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$_POST['producto'], $_POST['categoria'], $_POST['stock'], $_POST['precio']]);
        } elseif ($_POST['accion'] == 'actualizar') {
            $sql = "UPDATE productos SET producto = ?, categoria = ?, stock = ?, precio = ? WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$_POST['producto'], $_POST['categoria'], $_POST['stock'], $_POST['precio'], $_POST['id']]);
        } elseif ($_POST['accion'] == 'eliminar') {
            $sql = "DELETE FROM productos WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$_POST['id']]);
        }
    }
}

// Leer productos
$sql = "SELECT * FROM productos";
$stmt = $pdo->query($sql);
$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Productos</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
    <h1>Gestión de Productos</h1>
    
    <button onclick="mostrarFormulario('crear')">Agregar Producto</button>
    
    <table border="1" cellpadding="10">
        <tr>
            <th>ID</th>
            <th>Producto</th>
            <th>Categoría</th>
            <th>Stock</th>
            <th>Precio</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($productos as $producto): ?>
        <tr>
            <td><?= $producto['id'] ?></td>
            <td><?= $producto['producto'] ?></td>
            <td><?= $producto['categoria'] ?></td>
            <td><?= $producto['stock'] ?></td>
            <td><?= $producto['precio'] ?></td>
            <td>
                <button onclick="mostrarFormulario('editar', <?= $producto['id'] ?>, '<?= $producto['producto'] ?>', '<?= $producto['categoria'] ?>', <?= $producto['stock'] ?>, <?= $producto['precio'] ?>)">Editar</button>
                <form style="display:inline;" method="POST">
                    <input type="hidden" name="id" value="<?= $producto['id'] ?>">
                    <input type="hidden" name="accion" value="eliminar">
                    <button type="submit">Eliminar</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

    <div id="formulario" style="display:none;">
        <h2 id="form-title">Agregar Producto</h2>
        <form method="POST" id="producto-form">
            <input type="hidden" name="accion" id="accion" value="crear">
            <input type="hidden" name="id" id="producto-id">
            
            <label for="producto">Producto:</label>
            <input type="text" name="producto" id="producto" required><br><br>
            
            <label for="categoria">Categoría:</label>
            <input type="text" name="categoria" id="categoria" required><br><br>
            
            <label for="stock">Stock:</label>
            <input type="number" name="stock" id="stock" required><br><br>
            
            <label for="precio">Precio:</label>
            <input type="number" step="0.01" name="precio" id="precio" required><br><br>
            
            <button type="submit" id="submit-button">Guardar</button>
            <button type="button" onclick="ocultarFormulario()">Cancelar</button>
        </form>
    </div>

    <script>
        function mostrarFormulario(accion, id = '', producto = '', categoria = '', stock = '', precio = '') {
            document.getElementById('form-title').innerText = accion === 'crear' ? 'Agregar Producto' : 'Editar Producto';
            document.getElementById('accion').value = accion;
            document.getElementById('producto-id').value = id;
            document.getElementById('producto').value = producto;
            document.getElementById('categoria').value = categoria;
            document.getElementById('stock').value = stock;
            document.getElementById('precio').value = precio;
            document.getElementById('formulario').style.display = 'block';
        }

        function ocultarFormulario() {
            document.getElementById('formulario').style.display = 'none';
        }
    </script>
</body>
</html>