<!DOCTYPE html>
<html lang="fr">

<?php include __DIR__ . '/head.php'; ?>

<body>
    <header id="main-header" class="header">
        <div class="logo">
            <img src="/travisscott/public/img/icon.png" alt="Logo Utopia">
        </div>
        <button class="cart" id="cart" onclick="toggleCartMenu()">
            CART <span id="cartCount">0</span>
        </button>
    </header>
</body>
</html>

    <div class="cart-modal" id="cart-modal">
        <div class="modal-header">
            <div class="modal-header-left">
                <p>CART (<span id="cartCount">0 ITEMS)</span></p>
            </div>
            <div class="modal-header-right">
                <button onclick="closeCartMenu()">CLOSE X</button>
            </div>
        </div>
        <div class="bartext"></div>
        <div class="cart-content">

        <?php
            $cartQuery = $pdo->query("SELECT pp.id_panier_produit, pp.id_produit, pp.quantite, p.image1, p.nom, p.prix
                                    FROM panier_produits pp
                                    INNER JOIN produits p ON pp.id_produit = p.id_produit");
            $cartProducts = $cartQuery->fetchAll(PDO::FETCH_ASSOC);

            $paypalClientId = 'Ac64M0rLO-fudi7ngWxEP1G__NwlQmVGQwYNWZxeA23twXdiULP3fpbwDGVUosZCyEH4UrBRD8Tog4U3';

            if (!empty($cartProducts)) {
                foreach ($cartProducts as $cartProduct) :
        ?>
                <div class="cart-item">
                    <button onclick="removeFromCart(<?php echo $cartProduct['id_panier_produit']; ?>)">X</button>
                    <img src="<?php echo $cartProduct['image1']; ?>" alt="Product Image">
                    <h3><?php echo $cartProduct['nom']; ?></h3>
                    <input type="number" value="<?php echo $cartProduct['quantite']; ?>" min="1" max="99" onchange="updateCartQuantity(<?php echo $cartProduct['id_panier_produit']; ?>, this.value)">
                    <p>$<?php echo $cartProduct['prix']; ?></p>
                </div>
        <?php
                endforeach;
        ?>
                <div id="paypal-button-container"></div>
        <?php
            } else {
                echo "<p>YOUR CART IS EMPTY</p>";
            }
        ?>
        </div>
    </div>
    
    <script src="https://www.paypal.com/sdk/js?client-id=<?php echo $paypalClientId; ?>&currency=USD" data-sdk-integration-source="button-factory"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const header = document.getElementById("main-header");
            const logo = document.querySelector(".logo");
            const cartButton = document.querySelector(".cart");

            window.addEventListener("scroll", function() {
                if (window.scrollY > 0) {
                    header.classList.add("scrolled");
                    logo.classList.add("logo-small");
                    cartButton.classList.add("cart-fixed");
                } else {
                    header.classList.remove("scrolled");
                    logo.classList.remove("logo-small");
                    cartButton.classList.remove("cart-fixed");
                }
            });
        });

        document.querySelector('.logo img').addEventListener('click', function() {
            window.location.href = '/travisscott/home';
        });

        function toggleCartMenu() {
            const cartModal = document.getElementById('cart-modal');
            cartModal.classList.toggle('active');
        }

        function updateCartDisplay() {
            const cartCountElement = document.getElementById('cartCount');
            if (cartCountElement) {
                cartCountElement.textContent = cartCount;
            }
        }

        function closeCartMenu() {
            const cartModal = document.getElementById('cart-modal');
            cartModal.classList.remove('active');
        }

        const deleteCartUrl = '/travisscott/home'; // Modifier l'URL si nécessaire
        const deleteCartItemQuery = (productId) => `${deleteCartUrl}?action=delete_cart_item&id_panier_produit=${productId}`;

        function removeFromCart(productId) {
            const xhr = new XMLHttpRequest();

            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        updateCartDisplay();
                        const cartItem = document.querySelector(`.cart-item[data-id="${productId}"]`);
                        if (cartItem) {
                            cartItem.remove();
                        }
                    } else {
                        console.error("Erreur lors de la suppression du produit du panier.");
                    }
                }
            };

            const url = deleteCartItemQuery(productId);
            xhr.open("DELETE", url);
            xhr.send();
        }

        paypal.Buttons({
            createOrder: function(data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: '1.00'
                        }
                    }]
                });
            },
            onApprove: function(data, actions) {
                return actions.order.capture().then(function(details) {
                    alert('Transaction completed by ' + details.payer.name.given_name);
                });
            }
        }).render('#paypal-button-container');
    </script>