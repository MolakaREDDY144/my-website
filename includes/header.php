<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Reservation System</title>
    <link rel="stylesheet" href="/restaurant-reservation-system/assets/css/style.css">
</head>
<body>
    <header>
        <nav>
            <a href="/restaurant-reservation-system/index.php" class="logo">ReserveEats</a>
            <ul>
                <li><a href="/restaurant-reservation-system/index.php">Home</a></li>
                <li><a href="/restaurant-reservation-system/restaurants.php">Restaurants</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="/restaurant-reservation-system/user/profile.php">Profile</a></li>
                    <li><a href="/restaurant-reservation-system/user/logout.php">Logout</a></li>
                <?php else: ?>
                    <li><a href="/restaurant-reservation-system/user/login.php">Login</a></li>
                    <li><a href="/restaurant-reservation-system/user/register.php">Register</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
    <main>