<?php
include 'includes/header.php';
include 'includes/db.php'; // your PDO connection

// Fetch categories
$catStmt = $pdo->query("SELECT id, name FROM categories ORDER BY name");
$categories = $catStmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php
$sql = "
    SELECT 
        p.product_id,
        p.product_name,
        p.description,
        p.price,
        p.quantity,
        p.image_url,
        c.name AS category_name
    FROM products p
    JOIN categories c ON p.category_id = c.id
    WHERE 1
";

$params = [];

/* SEARCH */
if (!empty($_GET['search'])) {
    $sql .= " AND p.product_name LIKE :search";
    $params['search'] = '%' . $_GET['search'] . '%';
}

/* CATEGORY FILTER */
if (!empty($_GET['category'])) {
    $sql .= " AND c.id = :category";
    $params['category'] = $_GET['category'];
}

/* SORTING */
if (!empty($_GET['sort'])) {
    switch ($_GET['sort']) {
        case 'price_asc':
            $sql .= " ORDER BY p.price ASC";
            break;
        case 'price_desc':
            $sql .= " ORDER BY p.price DESC";
            break;
        case 'name_asc':
            $sql .= " ORDER BY p.product_name ASC";
            break;
    }
} else {
    $sql .= " ORDER BY p.product_name";
}

/* EXECUTE */
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<div class="head-img">
    <img src="img/apple-orchard.png" alt="apple orchard">
</div>

<section class="seasonal-products">
    <?php if (empty($products)): ?>
        <p>No products found.</p>
    <?php else: ?>
        <?php foreach ($products as $product): ?>
            <div class="ssn-box">
                <img
                    src="<?= htmlspecialchars($product['image_url'] ?: 'img/produce.jpg'); ?>"
                    alt="<?= htmlspecialchars($product['product_name']); ?>"
                >

                <h3><?= htmlspecialchars($product['product_name']); ?></h3>
                <p class="small-txt"><?= htmlspecialchars($product['category_name']); ?></p>

                <p><?= htmlspecialchars($product['description'] ?? ''); ?></p>

                <p><strong>£<?= number_format($product['price'], 2); ?></strong></p>

                <button class="red-btn">Buy</button>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</section>

<hr>

<section class="search-filter-bar">
    <h1>All Products</h1>

    <form method="GET" class="product-filters">
        <input
            type="text"
            name="search"
            placeholder="Search products..."
            value="<?= htmlspecialchars($_GET['search'] ?? '') ?>"
        >

        <select name="category">
            <option value="">All Categories</option>
            <?php foreach ($categories as $category): ?>
                <option value="<?= $category['id']; ?>"
                    <?= (($_GET['category'] ?? '') == $category['id']) ? 'selected' : ''; ?>>
                    <?= htmlspecialchars($category['name']); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <select name="sort">
            <option value="">Sort by</option>
            <option value="price_asc">Price (Low → High)</option>
            <option value="price_desc">Price (High → Low)</option>
            <option value="name_asc">Name (A–Z)</option>
        </select>

        <button type="submit" class="red-btn">Apply</button>
    </form>
</section>

<hr>

