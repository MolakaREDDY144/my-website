<?php include 'includes/header.php'; ?>

<h2 class="admin-page-title">Manage Restaurants</h2>

<!-- We will add the "Add New Restaurant" form logic later -->
<div class="admin-section">
    <a href="add_restaurant.php" class="btn">Add New Restaurant</a>
</div>

<div class="admin-section">
    <h3>All Restaurants</h3>
    <table class="admin-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Cuisine</th>
                <th>Address</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT * FROM restaurants ORDER BY name ASC";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['cuisine']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['address']) . "</td>";
                    echo "<td>";
                    echo "<a href='edit_restaurant.php?id=" . $row['id'] . "' class='btn-action'>Edit</a>";
                    echo "<a href='delete_restaurant.php?id=" . $row['id'] . "' class='btn-action btn-cancel' onclick='return confirm(\"Are you sure?\");'>Delete</a>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No restaurants found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php include 'includes/footer.php'; ?>
