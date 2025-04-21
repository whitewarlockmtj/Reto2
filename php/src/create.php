<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = new mysqli(
        getenv('DB_HOST'),
        getenv('DB_USER'),
        getenv('DB_PASSWORD'),
        getenv('DB_NAME')
    );
    
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    
    $stmt = $db->prepare("INSERT INTO products (name, description, price) VALUES (?, ?, ?)");
    $stmt->bind_param("ssd", $name, $description, $price);
    $stmt->execute();
    
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Agregar Producto</title>
</head>
<body>
    <h1>Agregar Producto Nuevo</h1>
    <form method="POST">
        <div>
            <label>Nombre:</label>
            <input type="text" name="name" required>
        </div>
        <div>
            <label>Descripción:</label>
            <textarea name="description"></textarea>
        </div>
        <div>
            <label>Precio:</label>
            <input type="number" step="0.01" name="price" required>
        </div>
        <button type="submit">Guardar</button>
    </form>
    <a href="index.php">Volver al listado</a>
</body>
</html>