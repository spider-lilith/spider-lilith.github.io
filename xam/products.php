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
        p.quantity,
        p.image_url,
        c.name AS category_name
    FROM products p
    JOIN categories c ON p.category_id = c.id
    ORDER BY p.product_id
    LIMIT 3
");
$featuredProducts = $featuredStmt->fetchAll(PDO::FETCH_ASSOC);

/* =========================
    ALL PRODUCTS QUERY (FILTERABLE)
========================= */

$sql = "
    SELECT 
        p.product_id,
        p.product_name,
        p.price,
        p.quantity,
        p.image_url,
        c.name AS category_name,
        pr.business_name AS producer_name
    FROM products p
    JOIN categories c ON p.category_id = c.id
    JOIN producers pr ON p.producer_id = pr.producer_id
    WHERE 1
";
$params = [];

/* CATEGORY CHECKBOX FILTER */
if (!empty($_GET['category'])) {
    $placeholders = implode(',', array_fill(0, count($_GET['category']), '?'));
    $sql .= " AND p.category_id IN ($placeholders)";
    $params = array_merge($params, $_GET['category']);
}


/* PRODUCER CHECKBOX FILTER */
if (!empty($_GET['producer'])) {
    $placeholders = implode(',', array_fill(0, count($_GET['producer']), '?'));
    $sql .= " AND p.producer_id IN ($placeholders)";
    $params = array_merge($params, $_GET['producer']);
}

/* SEARCH */
if (!empty($_GET['search'])) {
    $sql .= " AND p.product_name LIKE ?";
    $params[] = '%' . $_GET['search'] . '%';
}

/* SORT */
if (!empty($_GET['sort'])) {
    if ($_GET['sort'] === 'price_asc') {
        $sql .= " ORDER BY p.price ASC";
    } elseif ($_GET['sort'] === 'price_desc') {
        $sql .= " ORDER BY p.price DESC";
    }
} else {
    $sql .= " ORDER BY p.product_name";
}

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- --------------------------------------------------------------------------------- -->
<!-- PAGE CONTENT -->
<!-- --------------------------------------------------------------------------------- -->

<!-- --------------------------------------------------------------------------------- -->
<!-- HERO -->
<!-- --------------------------------------------------------------------------------- -->
<div class="head-img">
    <img src="<?= BASE_URL ?>img/apple-orchard.png" alt="Apple orchard">
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

    <h2 class="section-title">Top Seasonal Picks</h2>

<section class="seasonal-products">

    <?php foreach ($featuredProducts as $product): ?>
        <div class="ssn-box">
            <img
                src="<?= BASE_URL . htmlspecialchars($product['image_url'] ?: 'img/produce.jpg'); ?>"
                alt="<?= htmlspecialchars($product['product_name']); ?>"
            >
            <h3><?= htmlspecialchars($product['product_name']); ?></h3>
            <p class="small-txt"><?= htmlspecialchars($product['category_name']); ?></p>
            <p><strong>£<?= number_format($product['price'], 2); ?></strong></p>

            <?php if ($product['quantity'] > 0): ?>
                <form method="POST" action="<?= BASE_URL ?>cart-add.php">
                    <input type="hidden" name="product_id" value="<?= $product['product_id']; ?>">
                    <button type="submit" class="red-btn">Add to Cart</button>
                </form>
            <?php else: ?>
                <button class="red-btn" disabled>Out of Stock</button>
            <?php endif; ?>

        </div>
    <?php endforeach; ?>
</section>

<!-- --------------------------------------------------------------------------------- -->
<!-- SEARCH & SORT BAR -->
<!-- --------------------------------------------------------------------------------- -->
<section class="search-filter-bar">
    <form method="GET" action="<?= BASE_URL ?>products.php" class="product-filters">
        <h1>All Products</h1>

        <input
            type="text"
            name="search"
            placeholder="Search products..."
            value="<?= htmlspecialchars($_GET['search'] ?? '') ?>"
        >

        <select name="sort">
            <option value="">Sort by</option>
            <option value="price_asc" <?= ($_GET['sort'] ?? '') === 'price_asc' ? 'selected' : '' ?>>
                Price (Low → High)
            </option>
            <option value="price_desc" <?= ($_GET['sort'] ?? '') === 'price_desc' ? 'selected' : '' ?>>
                Price (High → Low)
            </option>
        </select>

        <button type="submit" class="red-btn">Apply</button>
    </form>
</section>

<!-- --------------------------------------------------------------------------------- -->
<!-- FILTERS -->
<!-- --------------------------------------------------------------------------------- -->
<div class="product-showcase">
    
    <aside class="filters">
        <form method="GET" action="<?= BASE_URL ?>products.php">
            <!-- preserve search/sort when filtering -->
            <input type="hidden" name="search" value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
            <input type="hidden" name="sort" value="<?= htmlspecialchars($_GET['sort'] ?? '') ?>">

            <h3>Categories</h3>
            <?php foreach ($categories as $cat): ?>
                <label>
                    <input
                        type="checkbox"
                        name="category[]"
                        value="<?= $cat['id']; ?>"
                        <?= in_array($cat['id'], $_GET['category'] ?? []) ? 'checked' : ''; ?>
                    >
                    <?= htmlspecialchars($cat['name']); ?>
                </label>
            <?php endforeach; ?>

            <hr>

            <h3>Producers</h3>
            <?php foreach ($producers as $producer): ?>
                <label>
                    <input
                        type="checkbox"
                        name="producer[]"
                        value="<?= $producer['producer_id']; ?>"
                        <?= in_array($producer['producer_id'], $_GET['producer'] ?? []) ? 'checked' : ''; ?>
                    >
                    <?= htmlspecialchars($producer['business_name']); ?>
                </label>
            <?php endforeach; ?>

            <button type="submit" class="red-btn">Filter</button>
        </form>
    </aside>

<!-- --------------------------------------------------------------------------------- -->
<!-- SHOWCASE -->
<!-- --------------------------------------------------------------------------------- -->
    <div class="showcase">
        <?php if (empty($products)): ?>
            <p>No products match your filters.</p>
        <?php else: ?>
            <?php foreach ($products as $product): ?>
                <div class="product-box">
                    <img
                        src="<?= BASE_URL . htmlspecialchars($product['image_url'] ?: 'img/cherry-produce.png'); ?>"
                        alt="<?= htmlspecialchars($product['product_name']); ?>"
                    >

                    <h3><?= htmlspecialchars($product['product_name']); ?></h3>
                    <p class="small-txt"><?= htmlspecialchars($product['category_name']); ?></p>
                    <p class="small-txt"><?= htmlspecialchars($product['producer_name']); ?></p>
                    <p><strong>£<?= number_format($product['price'], 2); ?></strong></p>

                    <?php if ($product['quantity'] > 0): ?>
                        <form method="POST" action="<?= BASE_URL ?>cart-add.php">
                            <input type="hidden" name="product_id" value="<?= $product['product_id']; ?>">
                            <button type="submit" class="red-btn">Add to Cart</button>
                        </form>
                    <?php else: ?>
                        <button class="red-btn" disabled>Out of Stock</button>
                    <?php endif; ?>

                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
