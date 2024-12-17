<?php
include 'db.php';

// Fetch all products from the database
$sql = "SELECT id, name, description, price, image FROM products";
$result = $conn->query($sql);

$products = [];
$defaultImage = "Images/default.jpg"; // Path to the default image

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = [
            'id' => $row['id'],
            'name' => $row['name'],
            'description' => $row['description'],
            'price' => $row['price'],
            'image' => $row['image'] ?: $defaultImage // Use the default image if none is provided
        ];
    }
}

// Output products as JSON
header('Content-Type: application/json');
echo json_encode($products);
?>
