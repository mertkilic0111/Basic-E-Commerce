<?php include 'header.php'; ?>

<main class="p-4 bg-gray-100 min-h-screen">
    <div class="container mx-auto mt-4 md:mt-12 lg:mt-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php $datas = dbSelect('products', ['status' => 1], 'p_order');
            foreach ($datas as $data) { ?>
                <div class="bg-white rounded-lg shadow-lg p-4 relative transition">
                    <a href="<?= $data['slug_url']; ?>" class="block">
                        <img src="<?= $data['cover_image']; ?>" alt="Ürün Resmi" class="w-full h-48 object-cover rounded-t-lg">
                    </a>
                    <div class="p-4 relative">
                        <a href="<?= $data['slug_url']; ?>" class="block">
                            <div class="flex justify-between items-center mt-2">
                                <h2 class="text-lg font-semibold text-gray-800 hover:text-blue-500 transition"><?= $data['name']; ?></h2>
                                <span class="text-lg font-semibold text-gray-800">₺<?= fiyatYazdir($data['price']); ?></span>
                            </div>
                        </a>
                        <div class="line-clamp-3 text-gray-600 mb-4 mt-5">
                            <?= htmlspecialchars_decode($data['description']); ?>
                        </div>
                        <?php if (isset($_SESSION['cart']) && array_key_exists($data['id'], $_SESSION['cart'])) { ?>
                            <div class="flex items-center justify-between mb-4">
                                <select id="quantity-<?= $data['id']; ?>" class="quantity-select w-16 p-2 border border-gray-300 rounded text-center bg-gray-50" data-title="<?= $data['name']; ?>">
                                    <?php for ($j = 1; $j <= 10; $j++) { ?>
                                        <option value="<?= $j; ?>" <?= $_SESSION['cart'][$data['id']]['quantity'] == $j ? 'selected' : ''; ?>><?= $j; ?></option>
                                    <?php } ?>
                                </select>
                                <button onclick="updateCart(<?= $data['id']; ?>);" id="update-to-cart-<?= $data['id']; ?>" class="bg-blue-500 text-white px-4 py-2 rounded-full shadow-md hover:bg-blue-600 transition">Sepeti Güncelle (<?= $_SESSION['cart'][$data['id']]['quantity']; ?>)</button>
                            </div>
                            <div class="text-right" id="remove-from-cart-div-<?= $data['id']; ?>">
                                <button onclick="removeCart(<?= $data['id']; ?>);" id="remove-from-cart-<?= $data['id']; ?>" class="bg-red-500 text-white px-4 py-2 rounded-full shadow-md hover:bg-red-600 transition">Sepetten Kaldır</button>
                            </div>
                        <?php } else { ?>
                            <div class="flex items-center justify-between mb-4">
                                <select id="quantity-<?= $data['id']; ?>" class="quantity-select w-16 p-2 border border-gray-300 rounded text-center bg-gray-50" data-title="<?= $data['name']; ?>">
                                    <?php for ($j = 1; $j <= 10; $j++) { ?>
                                        <option value="<?= $j; ?>" <?= $j == 1 ? 'selected' : ''; ?>><?= $j; ?></option>
                                    <?php } ?>
                                </select>
                                <button onclick="addCart(<?= $data['id']; ?>);" id="add-to-cart-<?= $data['id']; ?>" class="bg-blue-500 text-white px-4 py-2 rounded-full shadow-md hover:bg-blue-600 transition">Sepete Ekle</button>
                            </div>
                            <div class="text-right" id="remove-from-cart-div-<?= $data['id']; ?>" style="display:none;">
                                <button onclick="removeCart(<?= $data['id']; ?>);" id="remove-from-cart-<?= $data['id']; ?>" class="bg-red-500 text-white px-4 py-2 rounded-full shadow-md hover:bg-red-600 transition">Sepetten Kaldır</button>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
        </div>
        <div id="toast-container" class="fixed bottom-4 right-4"></div>
    </div>
</main>

<?php include 'footer.php'; ?>