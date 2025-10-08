<?php include 'includes/header.php'; ?>

<h2 class="admin-page-title">Dashboard</h2>

<div class="dashboard-stats">
    <div class="stat-card">
        <h3>Total Users</h3>
        <?php
            $result = $conn->query("SELECT COUNT(id) AS total_users FROM users WHERE role = 'user'");
            $row = $result->fetch_assoc();
            echo "<p>" . $row['total_users'] . "</p>";
        ?>
    </div>
    <div class="stat-card">
        <h3>Total Restaurants</h3>
        <?php
            $result = $conn->query("SELECT COUNT(id) AS total_restaurants FROM restaurants");
            $row = $result->fetch_assoc();
            echo "<p>" . $row['total_restaurants'] . "</p>";
        ?>
    </div>
    <div class="stat-card">
        <h3>Pending Reservations</h3>
         <?php
            $result = $conn->query("SELECT COUNT(id) AS pending_reservations FROM reservations WHERE status = 'pending'");
            $row = $result->fetch_assoc();
            echo "<p>" . $row['pending_reservations'] . "</p>";
        ?>
    </div>
    <div class="stat-card">
        <h3>Total Reservations</h3>
        <?php
            $result = $conn->query("SELECT COUNT(id) AS total_reservations FROM reservations");
            $row = $result->fetch_assoc();
            echo "<p>" . $row['total_reservations'] . "</p>";
        ?>
    </div>
</div>

<div class="admin-section">
    <h3>Recent Reservations</h3>
    <table class="admin-table">
        <thead>
            <tr>
                <th>Restaurant</th>
                <th>User</th>
                <th>Date & Time</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT res.*, u.username, r.name as restaurant_name 
                    FROM reservations res 
                    JOIN users u ON res.user_id = u.id
                    JOIN restaurants r ON res.restaurant_id = r.id
                    ORDER BY res.created_at DESC LIMIT 5";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['restaurant_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                    echo "<td>" . date('M j, Y, g:i A', strtotime($row['reservation_time'])) . "</td>";
                    echo "<td><span class='status-badge status-" . strtolower($row['status']) . "'>" . ucfirst($row['status']) . "</span></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No recent reservations found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>


<?php include 'includes/footer.php'; ?>