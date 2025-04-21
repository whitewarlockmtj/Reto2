<?php
$db = new mysqli(
    getenv('DB_HOST'),
    getenv('DB_USER'),
    getenv('DB_PASSWORD'),
    getenv('DB_NAME')
);

if ($db->connect_error) {
    die("Conexión fallida " . $db->connect_error);
}

// gestionar delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $db->prepare("DELETE FROM products WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: index.php");
}

// mostrar todos los productos
$result = $db->query("SELECT * FROM products");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Gestión de productos</title>
</head>
<body>
    <h1>Productos</h1>
    <p>Entregados por: <?php echo gethostname(); ?></p>
    
    <a href="create.php">Agregar producto nuevo</a>
    
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Precio</th>
            <th>Acciones</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo htmlspecialchars($row['name']); ?></td>
            <td><?php echo htmlspecialchars($row['description']); ?></td>
            <td>$<?php echo number_format($row['price'], 2); ?></td>
            <td>
                <a href="update.php?id=<?php echo $row['id']; ?>">Edit</a>
                <a href="index.php?delete=<?php echo $row['id']; ?>" onclick="return confirm('¿Esta seguro?')">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>