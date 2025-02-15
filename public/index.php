<?php
require __DIR__ . '/../src/user/register.php';
?>

<?php view('header', ['title' => 'Home']); ?>
    <style>
        <?php include 'css/index.css' ?>

    </style>
    <div id="page-container">
        <div id="content-wrap">
            <div id="page-grid">
                <?php include 'js/slideshow.php'; ?>
                <section class="info-sections">
                    <!-- About Us Section -->
                    <div class="info-box about-us">
                        <div class="overlay">
                            <h2>About Us</h2>
                            <p>
                                At <b>Wild Adventures</b>, we create **unforgettable outdoor experiences**. Whether it's trekking through the mountains, paddling along crystal-clear rivers, or sleeping under a sky full of stars, we help you connect with nature in meaningful ways.
                            </p>
                            <p>
                                Our passion is to provide thrilling, safe, and eco-friendly adventures for explorers of all levels.
                            </p>
                            <a href="products.php" class="styled-link">Discover Our Equipment</a>
                        </div>
                    </div>

                    <div class="info-box our-activities">
                        <div class="overlay">
                            <h2>Our Activities</h2>
                            <p>
                               We want to help you organize for you and your friends an amazing experience in nature.
                            </p>
                            <ul>
                                <li>🌲 Guided Hiking & Trekking</li>
                                <li>🚵 Biking</li>
                                <li>⛷️ Skiing & Snowboarding</li>
                                <li>🚣 Kayaking & Canoeing</li>
                                <li>🏕  Camping Expeditions</li>

                            </ul>
                            <a href="activities.php?category=hiking" class="styled-link">Plan Your Adventure</a>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

<?php view('footer') ?>