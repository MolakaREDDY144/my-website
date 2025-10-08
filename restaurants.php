<?php include 'includes/db.php'; ?>
<?php include 'includes/header.php'; ?>

<div class="container">
    <h2>All Restaurants</h2>
    <div class="restaurant-grid">
        <?php
        $sql = "SELECT * FROM restaurants";
        if (isset($_GET['search'])) {
            $search = $_GET['search'];
            $sql .= " WHERE name LIKE '%$search%' OR cuisine LIKE '%$search%'";
        }
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<div class='restaurant-card'>";
                echo "<img src='/restaurant-reservation-system/assets/images/" . $row["image_url"] . "' alt='" . $row["name"] . "'>";
                echo "<div class='restaurant-card-content'>";
                echo "<h3>" . $row["name"] . "</h3>";
                echo "<p>" . $row["cuisine"] . "</p>";
                echo "<p>" . substr($row["description"], 0, 100) . "...</p>";
                echo "<a href='restaurant-details.php?id=" . $row["id"] . "' class='btn'>View Details</a>";
                echo "</div>";
                echo "</div>";
            }
        } else {
            echo "<p>No restaurants found.</p>";
        }
        ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
