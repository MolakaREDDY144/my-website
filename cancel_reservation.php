<?php

include 'includes/db.php';

// Security Check: Ensure the user is logged in.
if (!isset($_SESSION['user_id'])) {
    header('Location: user/login.php');
    exit();
}

// Check if a reservation ID is provided in the URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    // Redirect if no ID is provided
    header('Location: user/profile.php');
    exit();
}

$reservation_id = $_GET['id'];
$user_id = $_SESSION['user_id'];
$user_role = $_SESSION['user_role'] ?? 'user'; // Get user role, default to 'user'

// --- DATABASE UPDATE ---
// Prepare the SQL statement to prevent SQL injection.
// This query will update the reservation status to 'cancelled'.
// We include a check to ensure that a regular user can only cancel their OWN reservation.
// An admin can cancel any reservation.
if ($user_role === 'admin') {
    // Admins can cancel any reservation
    $sql = "UPDATE reservations SET status = 'cancelled' WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $reservation_id);
} else {
    // Regular users can only cancel their own reservations
    $sql = "UPDATE reservations SET status = 'cancelled' WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $reservation_id, $user_id);
}


// Execute the statement and check for success
if ($stmt->execute()) {
    // Set a success message in the session to display on the next page
    $_SESSION['message'] = "Reservation successfully cancelled.";
} else {
    // Set an error message
    $_SESSION['error'] = "Failed to cancel reservation. Please try again.";
}

// Close the statement
$stmt->close();

// Redirect back to the appropriate page
if ($user_role === 'admin') {
    header('Location: admin/manage_reservations.php');
} else {
    header('Location: user/profile.php');
}
exit();
?>