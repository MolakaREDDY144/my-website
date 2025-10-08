<?php

include '../includes/db.php';

// This is the most important part: Security Check
// If the user is not logged in, or if they are not an admin, redirect them away.
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    // Redirect to the admin login page
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - ReserveEats</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="admin-body">
    <div class="admin-container">
        <aside class="admin-sidebar">
            <h1 class="admin-logo">ReserveEats</h1>
            <nav class="admin-nav">
                <a href="index.php">Dashboard</a>
                <a href="manage_restaurants.php">Restaurants</a>
                <a href="manage_reservations.php">Reservations</a>
                <!-- Add links to manage users, reviews etc. later -->
            </nav>
            <div class="admin-user-info">
                <p>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>
                <a href="../user/logout.php" class="logout-link">Logout</a>
            </div>
        </aside>
        <main class="admin-main-content">
