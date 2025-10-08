<?php include 'includes/db.php'; ?>
<?php include 'includes/header.php'; ?>

<?php
if (!isset($_GET['id'])) {
    // Redirect or show error
    header('Location: restaurants.php');
    exit();
}

$restaurant_id = $_GET['id'];
$sql = "SELECT * FROM restaurants WHERE id = $restaurant_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $restaurant = $result->fetch_assoc();
} else {
    echo "Restaurant not found.";
    exit();
}
?>

<div class="container">
    <div class="restaurant-details">
        <img src="/restaurant-reservation-system/assets/images/<?php echo $restaurant['image_url']; ?>" alt="<?php echo $restaurant['name']; ?>" class="restaurant-image">
        <h1><?php echo $restaurant['name']; ?></h1>
        <p><strong>Cuisine:</strong> <?php echo $restaurant['cuisine']; ?></p>
        <p><strong>Address:</strong> <?php echo $restaurant['address']; ?></p>
        <p><strong>Hours:</strong> <?php echo date('g:i a', strtotime($restaurant['opening_time'])) . ' - ' . date('g:i a', strtotime($restaurant['closing_time'])); ?></p>
        <p><?php echo $restaurant['description']; ?></p>
    </div>

    <div class="reservation-form form-container">
        <h2>Make a Reservation</h2>
        <form action="reservation.php" method="post">
            <input type="hidden" name="restaurant_id" value="<?php echo $restaurant_id; ?>">
            <div class="form-group">
                <label for="reservation_time">Date and Time</label>
                <input type="datetime-local" id="reservation_time" name="reservation_time" required>
            </div>
            <div class="form-group">
                <label for="party_size">Party Size</label>
                <input type="number" id="party_size" name="party_size" min="1" required>
            </div>
            <button type="submit" class="btn">Book a Table</button>
        </form>
    </div>

     <div class="reviews-section">
        <h2>Reviews</h2>
        <!-- Review submission form -->
        <div class="review-form form-container">
             <h3>Leave a Review</h3>
             <form action="review.php" method="post">
                 <input type="hidden" name="restaurant_id" value="<?php echo $restaurant_id; ?>">
                 <div class="form-group">
                     <label for="rating">Rating</label>
                     <select name="rating" id="rating" required>
                         <option value="5">5 Stars</option>
                         <option value="4">4 Stars</option>
                         <option value="3">3 Stars</option>
                         <option value="2">2 Stars</option>
                         <option value="1">1 Star</option>
                     </select>
                 </div>
                 <div class="form-group">
                     <label for="comment">Comment</label>
                     <textarea name="comment" id="comment" rows="4" required></textarea>
                 </div>
                 <button type="submit" class="btn">Submit Review</button>
             </form>
        </div>
        <!-- Display existing reviews -->
        <div class="existing-reviews">
            <?php
            $sql_reviews = "SELECT reviews.*, users.username FROM reviews JOIN users ON reviews.user_id = users.id WHERE restaurant_id = $restaurant_id ORDER BY created_at DESC";
            $result_reviews = $conn->query($sql_reviews);
            if ($result_reviews->num_rows > 0) {
                while($review = $result_reviews->fetch_assoc()) {
                    echo "<div class='review'>";
                    echo "<h4>" . $review['username'] . "</h4>";
                    echo "<p>Rating: " . $review['rating'] . "/5</p>";
                    echo "<p>" . $review['comment'] . "</p>";
                    echo "</div>";
                }
            } else {
                echo "<p>No reviews yet.</p>";
            }
            ?>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>