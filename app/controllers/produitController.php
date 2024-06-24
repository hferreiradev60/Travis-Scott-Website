<?php

class produitController {
    public function index() {
        include __DIR__ . '/../../app/models/model.php';

        $productId = isset($_GET['id']) ? $_GET['id'] : null;

        if ($productId) {
            try {
                $productDetailsQuery = $pdo->prepare("SELECT * FROM produits WHERE id_produit = ?");
                $productDetailsQuery->execute([$productId]);
                $productDetails = $productDetailsQuery->fetch(PDO::FETCH_ASSOC);

                if ($productDetails) {
                    include __DIR__ . '/../../app/views/produit/produitView.php';

                    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['buy-button'])) {
                        $quantity = 1;

                        $addToCartQuery = $pdo->prepare("INSERT INTO panier_produits (id_produit, quantite) VALUES (?, ?)");
                        $addToCartQuery->execute([$productId, $quantity]);

                        header("Location: /travisscott/app/views/home/homeView.php");
                        exit();
                    }
                } else {
                    header("Location: /travisscott/app/views/home/homeView.php");
                    exit();
                }
            } catch (PDOException $e) {
                die("Erreur lors de la récupération des détails du produit : " . $e->getMessage());
            }
        } else {
            header("Location: /travisscott/app/views/home/homeView.php");
            exit();
        }
    }
}
