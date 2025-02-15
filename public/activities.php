<?php
require __DIR__ . '/../src/bootstrap.php';
require __DIR__ . '/../src/package/activities.php';
require __DIR__ . '/../src/package/activities_pdf.php';

$activitiesPerPage = 3;

$pageNumber = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;

$category = $_GET['category'] ?? null;

if(!($category == 'hiking' || $category == 'cycling' || $category == 'skiing' || $category == 'camping' || $category == 'kayaking' || $category == null) ){
    redirect_to('activities.php');
}

$offset = ($pageNumber - 1) * $activitiesPerPage;

try {
    $activities = retrieveActivitiesWithLimit($activitiesPerPage, $offset, $category);
} catch (Exception $e) {
    redirect_with_message('index.php','Error');
}

try {
    $totalActivities = countActivities($category);
} catch (Exception $e) {
    redirect_with_message('index.php','Error');
}

$totalPages = ceil($totalActivities / $activitiesPerPage);
?>

<?php view('header', ['title' => 'Our Activities']); ?>
    <style>
        <?php include 'css/activities.css' ?>
    </style>
    <div id="page-container">
        <div id="content-wrap">
            <?php if (is_admin()) : ?>
                <div class="admin-options">
                    <button class="button" style="width: 20%">
                        <a href='insert_activity.php' style='text-decoration: none; color: white'>Add New Activities</a></button>
                </div>
            <?php endif; ?>

            <div class="activity-list">
                <!-- Display activities -->
                <?php foreach ($activities as $activity) : ?>
                    <div class="activity">
                        <!-- Activity details -->
                        <h2><?= $activity['name'] ?></h2>
                        <?php if (!empty($activity['photo'])) : ?>
                            <div class="photo">
                                <img src="data:image/jpeg;base64,<?= $activity['photo'] ?>"
                                     alt="Service Photo">
                            </div>
                        <?php endif; ?>
                        <div class="activity-details">
                            <p><strong>Description:</strong> <?= $activity['description'] ?></p>
                            <p><strong>Price:</strong> $<?= $activity['price'] ?></p>
                            <p><strong>Season:</strong> <?= $activity['season'] ?></p>
                            <p><strong>Country:</strong> <?= $activity['country'] ?></p>
                            <input type="hidden" name="category" value="<?= $activity['category'] ?>">
                            <p style="margin-bottom: 5%"><strong>Max Group Number:</strong> <?= $activity['max_group_number'] ?></p>

                            <?php if (is_admin()) : ?>
                                <form method="POST" action="../src/package/delete_activity.php">
                                <form method="POST" action="../src/package/delete_activity.php">
                                    <input type="hidden" name="activity_id" value="<?= $activity['id'] ?>">
                                    <input type="hidden" name="csrf_token"
                                           value="<?php echo $_SESSION['csrf_token']; ?>">
                                    <button type="submit" name="delete_activity" class="delete-button">Delete</button>
                                </form>
                            <?php endif; ?>

                            <form method='POST' action="../src/package/activities_pdf.php">
                                <input type="hidden" name="activity_id" value="<?= $activity['id'] ?>">
                                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                                <button type="submit" name="generate_service_pdf" value="<?= $activity['id'] ?>"
                                        style="width: 60%; position: absolute; bottom: 0;
            left: 5px;">More details (PDF)
                                </button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="pagination">
                <?php if ($pageNumber > 1) : ?>
                    <a href="?page=<?= $pageNumber - 1 ?>">Previous</a>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                    <a href="?page=<?= $i ?>&name=<?= $category ?>" <?= ($i == $pageNumber) ? 'class="active"' : '' ?>><?= $i ?></a>
                <?php endfor; ?>

                <?php if ($pageNumber < $totalPages) : ?>
                    <a href="?page=<?= $pageNumber + 1 ?>&category=<?= $category ?>">Next</a>
                <?php endif; ?>
            </div>
        </div>
    </div>

<?php view('footer') ?>