<?php
// Datos de la conexión
$host = 'localhost'; // Nombre del host (normalmente 'localhost')
$dbname = 'gestion_productos'; // Nombre de la base de datos
$username = 'root'; // Nombre de usuario (el valor predeterminado para MySQL es 'root')
$password = ''; // Contraseña (si no tienes una contraseña, déjala vacía)

// Configuración de opciones PDO
$options = array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Manejo de errores
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Modo de recuperación de datos
);

try {
    // Crear una instancia de PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password, $options);
    // Éxito en la conexión
    echo "Conexión exitosa";
} catch (PDOException $e) {
    // Manejo de errores en la conexión
    echo "Error en la conexión: " . $e->getMessage();
    die();
}
?>