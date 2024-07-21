<?php include 'header.php'; ?>

<main class="min-h-screen bg-white">
    <div class="container mx-auto py-16 px-6">
        <h1 class="text-4xl font-bold text-center text-gray-800 mb-12">Sepet</h1>
        <div id="cart-container" class="bg-white shadow-lg rounded-lg p-8">
            <div id="cart-items" class="mb-8">
                <?php if (isset($_SESSION['cart']) && count($_SESSION['cart'])) { ?>
                    <?php
                    $bir = 1;
                    $toplam_tutar = 0;
                    foreach ($_SESSION['cart'] as $cartItem => $cartItemValue) {
                        $datas = $db->prepare("SELECT * FROM products WHERE id= :id AND status= :status");
                        $datas->bindValue(':id', $cartItem, PDO::PARAM_INT);
                        $datas->bindValue(':status', $bir, PDO::PARAM_INT);
                        $datas->execute();
                        $data = $datas->fetch();
                        $toplam_tutar += ($data['price'] * $cartItemValue['quantity']); ?>
                        <div class="cart-item flex justify-between items-center mb-4" id="product-tr-<?= $cartItem; ?>">
                            <img src="<?= $data['cover_image']; ?>" alt="" class="w-24 h-24 object-cover rounded-lg shadow-lg mr-4">
                            <div class="flex-1 ml-4">
                                <h2 class="text-l font-semibold"><?= $data['name']; ?></h2>
                                <p class="text-gray-600"><?= fiyatYazdir($data['price']); ?> ₺ x <?= $cartItemValue['quantity']; ?></p>
                            </div>
                            <div class="text-right flex items-center">
                                <div class="text-l font-semibold mr-4"><?= fiyatYazdir($data['price'] * $cartItemValue['quantity']); ?> ₺</div>
                                <button class="text-red-500 hover:underline font-bold" onclick="removeCartFromCart(<?= $cartItem; ?>);">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <hr class="my-4">
                    <?php }
                } else {
                    $toplam_tutar = '0.00'; ?>
                    <p class="text-center font-bold">Sepetiniz boş.</p>
                <?php } ?>
            </div>
            <!-- Ad ve Soyad Input Alanı -->
            <div class="mb-8">
                <label for="name_surname" class="block text-gray-700">Ad ve Soyad</label>
                <input type="text" id="name_surname" name="name_surname" class="w-full border border-gray-300 p-2 rounded mt-1">
            </div>
            <div class="text-right">
                <div class="text-l font-semibold mb-2">Toplam: <span id="toplam-tutar"><?= fiyatYazdir($toplam_tutar); ?></span> ₺</div>
                <button onclick="validateForm();" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 mt-4">Satın Al</button>
            </div>
            <div id="toast-container" class="fixed bottom-4 right-4"></div>
        </div>
    </div>
</main>

<?php include 'footer.php'; ?>