<?php
header('Content-Type: application/json');

include 'db.php';

// Log the POST data
file_put_contents('debug_update.log', print_r($_POST, true));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $name = $_POST['name'] ?? null;
    $description = $_POST['description'] ?? null;
    $price = $_POST['price'] ?? null;
    $image = $_POST['image'] ?? null;

    if ($id && $name && $description && $price && $image) {
        $stmt = $conn->prepare("UPDATE products SET name = ?, description = ?, price = ?, image = ? WHERE id = ?");
        if (!$stmt) {
            echo json_encode(["status" => "error", "message" => "SQL error: " . $conn->error]);
            exit;
        }
        $stmt->bind_param("ssdsi", $name, $description, $price, $image, $id);

        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Product updated successfully"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Execution error: " . $stmt->error]);
        }

        $stmt->close();
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid input data"]);
    }
} else {
    http_response_code(405);
    echo json_encode(["status" => "error", "message" => "Invalid request method"]);
}

$conn->close();
?>
