<?php
include 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: user/login.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $restaurant_id = $_POST['restaurant_id'];
    $reservation_time = $_POST['reservation_time'];
    $party_size = $_POST['party_size'];

    $sql = "INSERT INTO reservations (user_id, restaurant_id, reservation_time, party_size) VALUES ('$user_id', '$restaurant_id', '$reservation_time', '$party_size')";

    if ($conn->query($sql) === TRUE) {
        // Here you would integrate SMS/Email notifications
        echo "Reservation made successfully!";
        // Redirect to a confirmation page or user profile
        header('Location: user/profile.php');
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
