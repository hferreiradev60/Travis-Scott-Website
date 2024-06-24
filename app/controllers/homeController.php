<?php

class homeController {
    public function index() {
        include __DIR__ . '/../../app/models/model.php';

        try {
            $albumsQuery = $pdo->query("SELECT id_produit, nom, prix, image1 FROM produits WHERE id_categorie = 1");
            $albums = $albumsQuery->fetchAll(PDO::FETCH_ASSOC);

            $magazinesQuery = $pdo->query("SELECT id_produit, nom, prix, image1 FROM produits WHERE id_categorie = 2");
            $magazines = $magazinesQuery->fetchAll(PDO::FETCH_ASSOC);

            $singlesQuery = $pdo->query("SELECT id_produit, nom, prix, image1 FROM produits WHERE id_categorie = 5");
            $singles = $singlesQuery->fetchAll(PDO::FETCH_ASSOC);

            include __DIR__ . '/../../app/views/home/homeView.php';
        } catch (PDOException $e) {
            die("Erreur lors de la récupération des produits : " . $e->getMessage());
        }
    }

    public function addToCart($productId) {
        include __DIR__ . '/../../app/models/model.php';

        try {
            $existingProductQuery = $pdo->prepare("SELECT * FROM panier_produits WHERE id_produit = ?");
            $existingProductQuery->execute([$productId]);
            $existingProduct = $existingProductQuery->fetch(PDO::FETCH_ASSOC);

            if ($existingProduct) {
                $updateQuantityQuery = $pdo->prepare("UPDATE panier_produits SET quantite = quantite + 1 WHERE id_produit = ?");
                $updateQuantityQuery->execute([$productId]);
            } else {
                $addToCartQuery = $pdo->prepare("INSERT INTO panier_produits (id_produit, quantite) VALUES (?, 1)");
                $addToCartQuery->execute([$productId]);
            }

            header("Location: /travisscott/produit");
            exit();
        } catch (PDOException $e) {
            die("Erreur lors de l'ajout au panier : " . $e->getMessage());
        }
    }
}
