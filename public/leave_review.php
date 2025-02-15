<?php
require __DIR__ . '/../src/bootstrap.php';

view ('header', ['title' => 'Add review']);

if (!is_user_logged_in()){ ?>
    <div class="message-box">
        <p>You need to be logged in to leave a review.</p>
        <a href="login.php">Go to login</a>
    </div>
    <?php
    view('footer');
    exit;}
?>
    <style>
        <?php include 'css/leave_review.css' ?>

    </style>

    <div id="page-container">
        <div id="content-wrap">
            <form class="review-form" action="../src/user/leave_review.php" method="post">
                <h1 class="text-center">Leave a Review</h1>

                <label for="rating">Rating (out of 5):</label>
                <select id="rating" name="rating" required>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>

                <label for="review">Your Review:</label>
                <textarea id="review" name="review" rows="4" required></textarea>
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                <button type="submit">Submit Review</button>
            </form>
        </div>
    </div>

<?php view('footer') ?>