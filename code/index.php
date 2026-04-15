<?php
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/header.php';

/* =========================
    FETCH CATEGORIES & PRODUCERS
   ========================= */

$catStmt = $pdo->query("SELECT id, name FROM categories ORDER BY name");
$categories = $catStmt->fetchAll(PDO::FETCH_ASSOC);

$producerStmt = $pdo->query("
    SELECT producer_id, business_name
    FROM producers
    ORDER BY business_name
");
$producers = $producerStmt->fetchAll(PDO::FETCH_ASSOC);

/* =========================
    FEATURED PRODUCTS (3 ONLY)
   ========================= */

$featuredStmt = $pdo->query("
    SELECT 
        p.product_id,
        p.product_name,
        p.price,
        p.image_url,
        c.name AS category_name
    FROM products p
    JOIN categories c ON p.category_id = c.id
    ORDER BY p.product_id
    LIMIT 3
");
$featuredProducts = $featuredStmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!-- --------------------------------------------------------------------------------- -->
<!-- HERO SLIDESHOW -->
<!-- --------------------------------------------------------------------------------- -->

    <div class="head-img">
        <img src="img/overhead-shot.png" alt="Overhead Farm Image">
    </div>


<!-- WAVE SEPARATOR -->
    <div class="wave-divider">
        <svg viewBox="0 0 1440 150" preserveAspectRatio="none">
        <path
            d="M0,80
                C90,120 180,120 270,80
                C360,40 450,40 540,80
                C630,120 720,120 810,80
                C900,40 990,40 1080,80
                C1170,120 1260,120 1350,80
                C1410,60 1440,60 1440,80
                L1440,0 L0,0 Z"
            fill="#fffdfa"
        />
        </svg>
    </div>

<!-- --------------------------------------------------------------------------------- -->
<!-- FEATURED PRODUCTS -->
<!-- --------------------------------------------------------------------------------- -->

    <h2 class="section-title">Featured Products</h2>
    <section class="seasonal-products">

    <?php foreach ($featuredProducts as $product): ?>
        <div class="ssn-box">
            <img
                src="<?= htmlspecialchars($product['image_url'] ?: 'img/produce.jpg'); ?>"
                alt="<?= htmlspecialchars($product['product_name']); ?>"
            >
            <h3><?= htmlspecialchars($product['product_name']); ?></h3>
            <p class="small-txt"><?= htmlspecialchars($product['category_name']); ?></p>
            <p><strong>£<?= number_format($product['price'], 2); ?></strong></p>
            <button class="red-btn">Buy</button>
        </div>
    <?php endforeach; ?>
</section>

<!-- --------------------------------------------------------------------------------- -->
<!-- WHAT IS GLH -->
<!-- --------------------------------------------------------------------------------- -->
    <section id="what-is">
        <div class="what-is-box">
            <div class="what-is-left">
                <h1>What is Greenfield Local Hub?</h1>
                <p>short paragraph explaining</p>
                <img src="img/GLH-logo.png" alt="GLH IMAGE">
                <button class="red-btn">Learn More</button>
            </div>

            <div class="what-is-right">
                <div class="what-is-paragraph">
                    <p> ICON </p>
                    <h2>Local Farmers</h2>
                    <p>paragraph about local farmers</p>
                </div>

                <div class="what-is-paragraph">
                    <p> ICON </p>
                    <h2>Fresh Food</h2>
                    <p>paragraph about food sourcing</p>
                </div>

                <div class="what-is-paragraph">
                    <p> ICON </p>
                    <h2>Delivered to You</h2>
                    <p>paragraph about the delivery services</p>
                </div>
            </div>
        </div>
    </section>

<!-- --------------------------------------------------------------------------------- -->
<!-- FAQ -->
<!-- --------------------------------------------------------------------------------- -->

    <section id="faq">
        <h1>FAQ</h1>
        <p>Find answers to our most frequently asked questions</p>
        <div class="faq-q" id="faq-q">
            <h3>Question 1</h3>
            <p>Answer</p>
        </div>
        <div class="faq-q" id="faq-q">
            <h3>Question 2</h3>
            <p>Answer</p>
        </div>
        <div class="faq-q" id="faq-q">
            <h3>Question 3</h3>
            <p>Answer</p>
        </div>
        <div class="faq-q" id="faq-q">
            <h3>Question 4</h3>
            <p>Answer</p>
        </div>
        <div class="faq-q" id="faq-q">
            <h3>Question 5</h3>
            <p>Answer</p>
        </div>
    </section>

<!-- --------------------------------------------------------------------------------- -->
<!-- REVIEWS -->
<!-- --------------------------------------------------------------------------------- -->

    <section id="reviews">
        <h1>Reviews</h1>
        <p>See what our previous customers have said!</p>
        <div class="review-box">
            <img src="#" alt="Customer profile picture">
            <h5 class="reviewer-name">Name Surname</h5>
            <p>Review message here</p>
        </div>

        <div class="review-box">
            <img src="#" alt="Customer profile picture">
            <h5 class="reviewer-name">Name Surname</h5>
            <p>Review message here</p>
        </div>

        <div class="review-box">
            <img src="#" alt="Customer profile picture">
            <h5 class="reviewer-name">Name Surname</h5>
            <p>Review message here</p>
        </div>
    </section>

<!-- --------------------------------------------------------------------------------- -->
<!-- FINAL CTA -->
<!-- --------------------------------------------------------------------------------- -->

    <section id="cta">
        <h1>Ready to Start Fresh?</h1>
        <button class="red-btn">Browse Products</button>
    </section>

<!-- --------------------------------------------------------------------------------- -->
<!-- FOOTER -->
<!-- --------------------------------------------------------------------------------- -->

    <?php include 'includes/footer.php';?>

</body>
</html>