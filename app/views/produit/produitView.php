<?php
include __DIR__ . '../../partials/head.php';
include __DIR__ . '../../partials/header.php';
?>

<body>
    <section class="product-details">
        <?php if ($productDetails) : ?>
            <form method="post" action="">
                <img src="<?= $productDetails['image1']; ?>" alt="<?= $productDetails['nom']; ?>">
                <h2><?= $productDetails['nom']; ?></h2>
                <p><?= $productDetails['description']; ?></p>
                <p>$<?= $productDetails['prix']; ?></p>
                <button type="submit" name="buy-button" class="buy-button">BUY</button>
            </form>
        <?php else : ?>
            <p>Produit non trouvé.</p>
        <?php endif; ?>
    </section>

    <?php include __DIR__ . '../../partials/footer.php'; ?>
</body>
</html>