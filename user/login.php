<?php
// Start the session at the very beginning

include '../includes/db.php';

// Initialize error variable
$error = '';

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // --- SECURITY ENHANCEMENT: Use Prepared Statements ---
    // Prepare the SQL query to prevent SQL injection
    $sql = "SELECT id, username, password, role FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // User found, now verify the password
        $user = $result->fetch_assoc();
        
        // Use password_verify() to check the hashed password
        // Note: Make sure your registration process uses password_hash()
        if (password_verify($password, $user['password'])) {
            // Password is correct, set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['user_role'] = $user['role'];

            // --- ROLE-BASED REDIRECTION ---
            // Check the user's role and redirect accordingly
            if ($user['role'] === 'admin') {
                // If the user is an admin, redirect to the admin dashboard
                header('Location: ../admin/index.php');
            } else {
                // Otherwise, it's a regular user, redirect to the homepage
                header('Location: ../index.php');
            }
            // Stop script execution after redirect
            exit(); 
        } else {
            // Password does not match
            $error = "The password you entered is incorrect.";
        }
    } else {
        // No user found with the provided email
        $error = "No account found with that email address.";
    }
    // Close the statement
    $stmt->close();
}
?>

<?php include '../includes/header.php'; ?>

<div class="form-container">
    <h2>Login to ReserveEats</h2>
    
    <?php 
    // Display the error message if it exists
    if (!empty($error)) { 
        echo "<p class='error'>$error</p>"; 
    } 
    ?>
    
    <form action="login.php" method="post">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit" class="btn">Login</button>
    </form>
    <p class="form-switch">Don't have an account? <a href="register.php">Register here</a></p>
</div>

<?php include '../includes/footer.php'; ?>

