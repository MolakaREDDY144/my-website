<?php
include 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: user/login.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $restaurant_id = $_POST['restaurant_id'];
    $rating = $_POST['rating'];
    $comment = $conn->real_escape_string($_POST['comment']);

    $sql = "INSERT INTO reviews (user_id, restaurant_id, rating, comment) VALUES ('$user_id', '$restaurant_id', '$rating', '$comment')";

    if ($conn->query($sql) === TRUE) {
        header('Location: restaurant-details.php?id=' . $restaurant_id);
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
