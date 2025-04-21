<?php
$db = new mysqli(
    getenv('DB_HOST'),
    getenv('DB_USER'),
    getenv('DB_PASSWORD'),
    getenv('DB_NAME')
);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    
    $stmt = $db->prepare("UPDATE products SET name = ?, description = ?, price = ? WHERE id = ?");
    $stmt->bind_param("ssdi", $name, $description, $price, $id);
    $stmt->execute();
    
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];
$stmt = $db->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Editar producto</title>
</head>
<body>
    <h1>Editar producto</h1>
    <form method="POST">
        <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
        <div>
            <label>Nombre:</label>
            <input type="text" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>
        </div>
        <div>
            <label>Descripción:</label>
            <textarea name="description"><?php echo htmlspecialchars($product['description']); ?></textarea>
        </div>
        <div>
            <label>Precio:</label>
            <input type="number" step="0.01" name="price" value="<?php echo $product['price']; ?>" required>
        </div>
        <button type="submit">Actualizar</button>
    </form>
    <a href="index.php">Volver a la lista</a>
</body>
</html>