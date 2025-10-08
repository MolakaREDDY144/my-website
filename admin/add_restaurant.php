<?php
// The header includes the database connection and the all-important security check
include 'includes/header.php';

// Initialize variables to hold form data and messages
$name = $description = $address = $cuisine = $opening_time = $closing_time = "";
$success_message = $error_message = "";

// --- FORM PROCESSING LOGIC ---
// Check if the form was submitted using POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Sanitize and retrieve form data
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $address = trim($_POST['address']);
    $cuisine = trim($_POST['cuisine']);
    $opening_time = $_POST['opening_time'];
    $closing_time = $_POST['closing_time'];
    $image_url = 'assets/images/default-restaurant.jpg'; // Default image for now

    // Simple validation
    if (empty($name) || empty($address) || empty($cuisine)) {
        $error_message = "Please fill in all required fields (Name, Address, Cuisine).";
    } else {
        // --- DATABASE INSERTION ---
        // Prepare an SQL statement to prevent SQL injection
        $sql = "INSERT INTO restaurants (name, description, address, cuisine, opening_time, closing_time, image_url) VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $conn->prepare($sql);
        
        // Bind the variables to the prepared statement as parameters
        $stmt->bind_param("sssssss", $name, $description, $address, $cuisine, $opening_time, $closing_time, $image_url);
        
        // Execute the statement and check for success
        if ($stmt->execute()) {
            $success_message = "New restaurant added successfully! You will be redirected shortly.";
            // Redirect back to the manage restaurants page after a short delay
            header("refresh:3;url=manage_restaurants.php");
        } else {
            $error_message = "Error: " . $stmt->error;
        }
        
        // Close the statement
        $stmt->close();
    }
}
?>

<!-- --- HTML FORM --- -->
<div class="admin-main-content">
    <h2 class="admin-page-title">Add New Restaurant</h2>

    <div class="admin-section">
        
        <!-- Display Success or Error Messages -->
        <?php if(!empty($success_message)): ?>
            <p class="success"><?php echo $success_message; ?></p>
        <?php endif; ?>
        <?php if(!empty($error_message)): ?>
            <p class="error"><?php echo $error_message; ?></p>
        <?php endif; ?>

        <form action="add_restaurant.php" method="post">
            <div class="form-group">
                <label for="name">Restaurant Name</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" rows="4"></textarea>
            </div>
            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" id="address" name="address" required>
            </div>
            <div class="form-group">
                <label for="cuisine">Cuisine Type (e.g., Italian, Indian)</label>
                <input type="text" id="cuisine" name="cuisine" required>
            </div>
            <div class="form-group">
                <label for="opening_time">Opening Time</label>
                <input type="time" id="opening_time" name="opening_time" required>
            </div>
            <div class="form-group">
                <label for="closing_time">Closing Time</label>
                <input type="time" id="closing_time" name="closing_time" required>
            </div>
            <!-- Note: Image upload functionality will be a future enhancement -->
            
            <button type="submit" class="btn">Add Restaurant</button>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
