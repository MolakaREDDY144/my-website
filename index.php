<?php include 'includes/db.php'; ?>
<?php include 'includes/header.php'; ?>

<section class="hero">
    <div class="hero-content">
        <h1>Find and book the best restaurants</h1>
        <p>Discover and reserve a table at your favorite restaurants in seconds.</p>
        <form class="search-bar" action="restaurants.php" method="get">
            <input type="text" name="search" placeholder="Search for restaurants, cuisine...">
            <button type="submit">Search</button>
        </form>
    </div>
</section>

<section class="featured-restaurants">
    <h2>Featured Restaurants</h2>
    <div class="restaurant-grid">
        <?php
        $sql = "SELECT * FROM restaurants LIMIT 6";
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
            echo "<p>No featured restaurants found.</p>";
        }
        ?>
    </div>
</section>

<?php include 'includes/footer.php'; ?>