<?php
require __DIR__ . '/../src/bootstrap.php';
require __DIR__ . '/../src/product/products.php';

view('header', ['title' => 'Our Product']);

if (empty($_GET['productId'])) {
    header("Location: products.php");
    exit();
}

$productId = $_GET['productId'];
$product = retrieveProductById($productId);

if (!$product) {
    header("Location: products.php");
    exit();
}
?>
    <style>
        <?php include 'css/product_details.css' ?>
    </style>

    <div class="container-fluid" style="margin-bottom: 5%;">
        <div class="row">
            <div class="product-details">
                <h1><?= $product['name'] ?></h1>
                <p><?= $product['description'] ?></p>
                <p>Price: $<?= $product['price'] ?></p>
                <p>Quantity: <?= $product['quantity'] ?></p>
                <?php if (!empty($product['image'])) : ?>
                    <div class="photo">
                        <img src="data:image/jpeg;base64,<?= base64_encode($product['image']) ?>" alt="Product Photo">
                    </div>
                <?php endif; ?>
                <p><?= $product['info'] ?></p>
            </div>

            <div class="similar-products">
                <div class="similar-products-box">
                    <h3>Looking for similar items?</h3>
                    <div class="product-grid">
                        <?php
                        // TODO o functie pentru similar items
                        $similarProducts = array_slice(retrieveProducts(), 4, 3);
                        foreach ($similarProducts as $similarProduct) : ?>
                            <div class="similar-product">

                                <?php
                                $defaultImage = 'https://i.ibb.co/0tFtV35/no-photo.jpg';
                                if (!empty($similarProduct['image'])) {
                                    $imageSource = "data:image/jpeg;base64," . base64_encode($similarProduct['image']);
                                } else {
                                    $imageSource = $defaultImage;
                                } ?>
                                <img src="<?= $imageSource ?>" alt="Product Photo" id="product-image">
                                <a href="product_details.php?productId=<?= $similarProduct['id'] ?>" style="color:black">
                                    <h4><?= $similarProduct['name'] ?></h4>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">

        </div>
    </div>

<?php view('footer') ?>