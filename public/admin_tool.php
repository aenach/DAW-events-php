<?php
require __DIR__ . '/../src/bootstrap.php';
require __DIR__ . '/../src/package/activities.php';
require __DIR__ . '/../src/user/admin/admin_tool.php';
if ( !is_admin() ) {
    header("Location: index.php");
    exit;
}
?>

<?php view('admin_header', ['title' => 'Admin tool']); ?>

    <style>
        <?php include 'css/admin.css' ?>
    </style>

    <div class="container-fluid">
        <h2 class="text-center title">All Users</h2>
        <div class="row">
            <div class="table-wrapper">
                <table class="table table-bordered">
                    <thead>
                    <th>Id</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Verified</th>
                    <th>Role</th>
                    <th>Update role</th>
                    <th>Remove user</th>
                    </thead>
                    <tbody>
                    <div class = "users">
                    <?php $users = get_all_users();
                    $current_user_id = $_SESSION['user_id'];
                    foreach ($users as $user):
//                        don't show the current user
                        if ($user['id'] == $current_user_id) {
                            continue;
                        }?>
                        <tr>
                            <td><?php echo $user['id']; ?></td>
                            <td><?php echo $user['username']; ?></td>
                            <td><?php echo $user['email']; ?></td>
                            <td class="text-center">
                                <?php
                                if ($user['verified'] == 1) {
                                    echo '<i class="fa fa-check" />';
                                } else {
                                    echo '<i class="fa fa-times" />';
                                }
                                ?>

                                <?php
                                if ($user['verified'] != 1) {
                                    ?>
                                    <form method="POST" action="" style="padding-top: 10%;">
                                        <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                                        <button class="btn btn-primary action-btn btn-sm" type="submit" name="verify">Verify</button>
                                    </form>
                                    <?php
                                }
                                ?>
                            </td>
                            <td><?php echo $user['role']; ?></td>
                            <td>
                                <form method="POST" action="">
                                    <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <select class="form-input form-control text-center" name="new_role">
                                                    <option value="seller" <?php echo ($user['role'] === 'seller') ? 'selected' : ''; ?>>Seller</option>
                                                    <option value="admin" <?php echo ($user['role'] === 'admin') ? 'selected' : ''; ?>>Admin</option>
                                                    <option value="common" <?php echo ($user['role'] === 'common') ? 'selected' : ''; ?>>Common</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                                                <button class="btn btn-primary action-btn btn-sm" type="submit" name="update_role">Update Role</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </td>
                            <td>
                                <form method="POST" action="">
                                    <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                                    <button class="btn btn-primary btn-sm action-btn" type="submit" name="delete_user">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </div>
                    </tbody>
                </table>
            </div>
        </div>
    </div>