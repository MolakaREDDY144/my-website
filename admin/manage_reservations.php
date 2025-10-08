<?php
include 'includes/header.php';

// Handle status updates
if (isset($_GET['action']) && isset($_GET['id'])) {
    $action = $_GET['action'];
    $reservation_id = $_GET['id'];

    if ($action === 'confirm' || $action === 'cancel') {
        $new_status = ($action === 'confirm') ? 'confirmed' : 'cancelled';
        $stmt = $conn->prepare("UPDATE reservations SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $new_status, $reservation_id);
        $stmt->execute();
        $stmt->close();
        // Redirect to avoid re-processing on refresh
        header("Location: manage_reservations.php");
        exit();
    }
}
?>

<h2 class="admin-page-title">Manage Reservations</h2>

<div class="admin-section">
    <h3>All Reservations</h3>
    <table class="admin-table">
        <thead>
            <tr>
                <th>Restaurant</th>
                <th>User</th>
                <th>Date & Time</th>
                <th>Party Size</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT res.*, u.username, r.name as restaurant_name 
                    FROM reservations res 
                    JOIN users u ON res.user_id = u.id
                    JOIN restaurants r ON res.restaurant_id = r.id
                    ORDER BY res.reservation_time DESC";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['restaurant_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                    echo "<td>" . date('M j, Y, g:i A', strtotime($row['reservation_time'])) . "</td>";
                    echo "<td>" . $row['party_size'] . "</td>";
                    echo "<td><span class='status-badge status-" . strtolower($row['status']) . "'>" . ucfirst($row['status']) . "</span></td>";
                    echo "<td>";
                    if ($row['status'] == 'pending') {
                        echo "<a href='manage_reservations.php?action=confirm&id=" . $row['id'] . "' class='btn-action'>Confirm</a>";
                        echo "<a href='manage_reservations.php?action=cancel&id=" . $row['id'] . "' class='btn-action btn-cancel'>Cancel</a>";
                    }
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No reservations found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php include 'includes/footer.php'; ?>
