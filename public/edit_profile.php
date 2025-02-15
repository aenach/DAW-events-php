<?php
require __DIR__ . '/../src/bootstrap.php';
require __DIR__ . '/../src/user/edit_profile.php';

if (!is_user_logged_in()) {
    header("Location: login.php");
    exit;
}

?>

<?php view('header', ['title' => 'Edit Profile']); ?>

    <style>
        <?php include 'css/edit_profile.css' ?>
    </style>
    <div style="text-align: center; position: relative;">

        <div class="account-details-box">
            <p>Edit your profile:</p>
            <?php
            $defaultImage = 'https://i.ibb.co/yV6Wnzb/no-photo2.png';
            if (!empty($user['photo'])) {
                $imageSource = "data:image/jpeg;base64," . base64_encode($user['photo']);
            } else {
                $imageSource = $defaultImage;
            } ?>
            <img src="<?= $imageSource ?>" alt="Profile Photo" class="profile-picture" style="margin-bottom: 8px">
            <form method="post" action="../src/user/edit_profile.php" enctype="multipart/form-data">
                <table class="details-table">
                    <tr>
                        <td>Photo:</td>
                        <td class="right"><input type="file" name="photo"></td>
                    </tr>
                    <tr>
                        <td>Email:</td>
                        <td class="right">
                            <input type="text" name="email" value="<?= $user['email'] ?>" required readonly>
                        </td>
                    </tr>
                    <tr>
                        <td>Last name:</td>
                        <td class="right"><input type="text" name="lastname" value="<?= $user['lastname'] ?>" required>
                        </td>
                    </tr>
                    <tr>
                        <td>First name:</td>
                        <td class="right"><input type="text" name="firstname" value="<?= $user['firstname'] ?>"
                                                 required></td>
                    </tr>
                </table>
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                <button type="submit" class="styled-link">Update Profile</button>
                <a href="reset_password.php" class="styled-link">Password reset</a>
            </form>
        </div>


    </div>
    <a href="user_account.php" class="styled-link go-back"><i class="fas fa-arrow-left"></i> Go back to Your Account</a>

<?php view('footer') ?>