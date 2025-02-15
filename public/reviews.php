<?php
require __DIR__ . '/../src/bootstrap.php';
require __DIR__ . '/../src/reviews.php';

?>
<?php view('header', ['title' => 'Reviews']) ?>

    <style>
        <?php include 'css/reviews.css' ?>

    </style>

    <a href="leave_review.php" class="styled-link" >Tell us what you think about our work!</a>

<?php
$reviews = [];
if (isset($_GET['userId'])) {
    $user_id = $_GET['userId'];
    $reviews = retrieveReviewsByUserId($user_id);
} else $reviews = retrieveReviews();
foreach ($reviews as $review) {
    ?>
    <div class="review">
        <?php
        $defaultImage = 'https://i.ibb.co/Psdr1P37/defuser.jpg';
        if (!empty($review['photo'])) {
        $imageSource = "data:image/jpeg;base64," . base64_encode($review['photo']);
        } else {
        $imageSource = $defaultImage;
        } ?>
        <img src="<?= $imageSource ?>" alt="Profile Photo" class="profile-picture">
        <div class="review-info">
            <div class="reviewer-name"><?php echo $review['reviewer_name']; ?></div>
            <div class="review-text"><?php echo $review['review_text']; ?></div>
            <div class="star-rating">
                <?php
                $stars = $review['rating'];
                for ($i = 1; $i <= 5; $i++) {
                    if ($i <= $stars) {
                        echo '<i class="fas fa-star"></i>';
                    } else {
                        echo '<i class="far fa-star"></i>';
                    }
                }
                ?>
            </div>
        </div>
    </div>
    <?php
}
?>
<?php view('footer') ?>