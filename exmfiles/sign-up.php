<?php include 'includes/header.php';?>

<div class="su-li-box">
    <h2>Sign Up</h2>
        <form>
            
        <div class="form-input">
            <label for="name" class="form-label">Your Name</label>
            <input type="text" class="form-control" id="name" placeholder="Enter your name" required>
        </div>
        <div class="form-input">
            <label for="surname" class="form-label">Your Surname</label>
            <input type="text" class="form-control" id="surname" placeholder="Enter your surname" required>
        </div>
        <div class="form-input">
            <label for="email" class="form-label">Your Email</label>
            <input type="email" class="form-control" id="email" placeholder="Enter your email" required>
        </div>
        <div class="form-input">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" placeholder="Enter your password" required>
        </div>
        <div class="form-input">
            <label for="confirm-password" class="form-label">Repeat your password</label>
            <input type="password" class="form-control" id="confirm-password" placeholder="Repeat your password" required>
        </div>
        <div class="form-input form-check">
            <input type="checkbox" class="form-check-input" id="terms">
            <label class="form-check-label" for="terms">I agree to all statements in Terms of Service</label>
        </div>

        <button type="submit" class="red-btn">Register</button>
        </form>
</div>

<?php include 'includes/footer.php';?>
