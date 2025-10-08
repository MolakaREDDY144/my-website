<?php
include '../includes/db.php';
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
$user_id = $_SESSION['user_id'];
?>
<?php include '../includes/header.php'; ?>

<div class="profile-container">
    <div class="profile-header">
        <h2>My Reservations</h2>
        <p>Here are your upcoming and past bookings.</p>
    </div>

    <div class="reservation-list">
        <?php
        $sql = "SELECT 
                    r.id,
                    r.reservation_time,
                    r.party_size,
                    r.status,
                    rest.name AS restaurant_name,
                    rest.image_url AS restaurant_image
                FROM 
                    reservations r
                JOIN 
                    restaurants rest ON r.restaurant_id = rest.id
                WHERE 
                    r.user_id = $user_id 
                ORDER BY 
                    r.reservation_time DESC";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Determine the status class for styling
                $status_class = strtolower($row['status']);
        ?>
                <!-- Reservation Card Start -->
                <div class="reservation-card">
                    <div class="card-image">
                        <img src="/restaurant-reservation-system/assets/images/<?php echo htmlspecialchars($row['restaurant_image']); ?>" alt="<?php echo htmlspecialchars($row['restaurant_name']); ?>">
                    </div>
                    <div class="card-content">
                        <div class="card-header">
                            <h3><?php echo htmlspecialchars($row['restaurant_name']); ?></h3>
                            <span class="card-status status-<?php echo $status_class; ?>">
                                <?php echo ucfirst($row['status']); ?>
                            </span>
                        </div>
                        <div class="card-body">
                            <p><strong>Date:</strong> <?php echo date('F j, Y', strtotime($row['reservation_time'])); ?></p>
                            <p><strong>Time:</strong> <?php echo date('g:i A', strtotime($row['reservation_time'])); ?></p>
                            <p><strong>Guests:</strong> <?php echo $row['party_size']; ?></p>
                        </div>
                        <div class="card-actions">
                            <?php if ($status_class == 'pending' || $status_class == 'confirmed') : ?>
                                <a href="../cancel_reservation.php?id=<?php echo $row['id']; ?>" class="btn-cancel">Cancel Reservation</a>
                            <?php else: ?>
                                <a href="../reservation.php?id=<?php echo $row['id']; ?>" class="btn-book">Book Again</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <!-- Reservation Card End -->
        <?php
            }
        } else {
            echo "<div class='no-reservations'><p>You have no reservations yet. <a href='/restaurant-reservation-system/restaurants.php'>Find a restaurant</a> to book!</p></div>";
        }
        ?>
    </div>
</div>

<?php include '../includes/footer.php'; ?>

