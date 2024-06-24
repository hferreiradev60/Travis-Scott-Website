<!DOCTYPE html>
<html lang="fr">

<?php
include __DIR__ . '../../partials/head.php';
include __DIR__ . '../../partials/header.php';
?>

<body>
    <section class="products-list">
        <div class="album-list">
            <?php foreach ($albums as $product) : ?>
                <a href="/travisscott/produit?id=<?php echo $product['id_produit']; ?>" class="product">
                    <img src="<?php echo $product['image1']; ?>" alt="<?php echo $product['nom']; ?>">
                    <h3><?php echo $product['nom']; ?></h3>
                    <p>$<?php echo $product['prix']; ?></p>
                </a>
            <?php endforeach; ?>
        </div>

        <div class="zine-list">
            <?php foreach ($magazines as $product) : ?>
                <a href="/travisscott/produit?id=<?php echo $product['id_produit']; ?>" class="product">
                    <img src="<?php echo $product['image1']; ?>" alt="<?php echo $product['nom']; ?>">
                    <h3><?php echo $product['nom']; ?></h3>
                    <p>$<?php echo $product['prix']; ?></p>
                </a>
            <?php endforeach; ?>
        </div>

        <div class="single-list">
            <?php foreach ($singles as $product) : ?>
                <a href="/travisscott/produit?id=<?php echo $product['id_produit']; ?>" class="product">
                    <img src="<?php echo $product['image1']; ?>" alt="<?php echo $product['nom']; ?>">
                    <h3><?php echo $product['nom']; ?></h3>
                    <p>$<?php echo $product['prix']; ?></p>
                </a>
            <?php endforeach; ?>
        </div>
    </section>

    <?php include __DIR__ . '../../partials/footer.php'; ?>
</body>
</html>
