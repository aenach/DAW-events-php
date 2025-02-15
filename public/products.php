<?php
require __DIR__ . '/../src/bootstrap.php';
require __DIR__ . '/../src/product/products.php';
require __DIR__ . '/../src/product/shopping_cart.php';
require __DIR__ . '/../src/product/delete_product.php';
?>

<?php view('header', ['title' => 'Our Products']); ?>
    <style>
        <?php include 'css/products.css' ?>
</style>

    <div style="display: flex"
        <div id="page-container">
            <div id="content-wrap">
                <div class="product-actions">
                    <?php if (is_seller() || is_admin()) : ?>
                        <button class="button" ><a href='./insert_product.php' style='text-decoration: none; color: white'>Add New
                                Products</a></button>
                    <?php endif ?>
                    <form method="GET" action="#" style="margin: 0 auto;">
                        <label for="sort">Sort by Price:</label>
                        <select name="sort" id="sort">
                            <option value="asc" <?= ($_GET['sort'] ?? '') === 'asc' ? 'selected' : '' ?>>Ascending</option>
                            <option value="desc" <?= ($_GET['sort'] ?? '') === 'desc' ? 'selected' : '' ?>>Descending</option>
                        </select>
                        <button type="submit" style="width: 100px; margin:10px">Apply</button>
                    </form>
                </div>

                <div class="product-list">
                    <?php
                    $sortOrder = isset($_GET['sort']) && ($_GET['sort'] === 'asc' || $_GET['sort'] === 'desc') ? $_GET['sort'] : 'asc';
                    $products = retrieveProducts($sortOrder);
                    foreach ($products as $product) : ?>

                        <div class="product">
                            <?php if (is_seller() || is_admin()) : ?>
                                <div class="admin-options">
                                    <form method='POST' action="../src/product/delete_product.php" style="display: inline; ">
                                        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                                        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                        <button type='submit' name="delete_product" value="deleteProduct" class="small-round-btn btn-delete""> <i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            <?php endif ?>
                            <a href="product_details.php?productId=<?= $product['id'] ?>" style="color:black">
                                <h2><?= $product['name'] ?></h2>
                            </a>
                            <?php
                            $defaultImage = 'https://i.ibb.co/0tFtV35/no-photo.jpg'; // Replace this with the path to your default image
                            if (!empty($product['image'])) {
                                $imageSource = "data:image/jpeg;base64," . base64_encode($product['image']);
                            } else {
                                $imageSource = $defaultImage;
                            } ?>

                            <div class="photo">
                                <img src="<?= $imageSource ?>" alt="Product Photo" id="product-image">
                            </div>

                            <div class="product-details">
                                <p><strong>Description:</strong> <?= $product['description'] ?></p>
                                <p><strong>Price:</strong> $<?= $product['price'] ?></p>
                                <p><strong>Quantity:</strong> <?= $product['quantity'] ?></p>
                                <p><strong>Product id:</strong> <?= $product['id'] ?></p>
                                <div class="product-actions">
                                <form method='POST' action="../src/product/shopping_cart.php">
                                    <label >Quantity:</label>
                                    <input type="hidden" name="quantities[<?= $product['id'] ?>][id]" value="<?= $product['id'] ?>">
                                    <input type="number" style="width: 50px;" name="quantities[<?= $product['id'] ?>][quantity]" value="1" min="1"
                                           max="<?= $product['quantity'] ?>">
                                    <button  type="submit" class="small-round-btn btn-add" value="add_product_to_cart"> <i class="fas fa-plus"></i></button>
                                </form>
                                <?php if (is_seller() || is_admin()) : ?>
                                    <div class="admin-options">
                                        <form method='POST' action="../src/product/delete_product.php" style="display: inline;">
                                            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                                            <button type='submit' name="delete_product" value="deleteProduct" class="small-round-btn btn-delete""> <i class="fas fa-minus"></i></button>
                                        </form>
                                    </div>
                                <?php endif ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
            </div>
        </div>
    </div>
<?php view('footer') ?>