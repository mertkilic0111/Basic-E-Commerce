<?php include 'header.php'; ?>
<?php
$slug_url = htmlspecialchars(strip_tags($_GET['slug_url']));
$datas = $db->prepare("SELECT * FROM products WHERE slug_url= :slug_url");
$datas->bindValue(':slug_url', $slug_url, PDO::PARAM_STR);
$datas->execute();
$data = $datas->fetch(PDO::FETCH_ASSOC);
if (!$data) {
    header("Location: 404.html");
    exit;
} ?>
<main class="p-4 bg-gray-100 min-h-screen">
    <div class="container mx-auto mt-4 md:mt-12 lg:mt-12">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Product Image Gallery -->
            <div class="relative">
                <div class="relative">
                    <img id="main-image" src="<?= $data['cover_image']; ?>" alt="Product Image" class="w-full h-auto rounded-lg shadow-lg mb-4 cursor-pointer border-2 border-gray-300">
                    <div id="zoom-box" class="hidden absolute right-0 top-0 w-64 h-64 bg-white shadow-lg overflow-hidden ml-4 rounded-md"></div>
                </div>
                <div id="zoom-box-mobile" class="hidden absolute w-48 h-48 bg-white shadow-lg overflow-hidden mx-auto rounded-md"></div>
                <div class="flex space-x-4 overflow-x-auto mt-4">
                    <img src="<?= $data['cover_image']; ?>" alt="Product Thumbnail" class="thumbnail selected-thumbnail w-24 h-24 object-cover rounded-lg shadow-lg cursor-pointer border-4 border-gray-300">
                    <?php $dataImages = dbSelect('product_images', ['product_id' => $data['id']]);
                    foreach ($dataImages as $dataImage) { ?>
                        <img src="<?= $dataImage['image_path']; ?>" alt="Product Thumbnail" class="thumbnail w-24 h-24 object-cover rounded-lg shadow-lg cursor-pointer border-4 border-transparent">
                    <?php } ?>
                </div>
            </div>
            <!-- Product Details -->
            <div>
                <h1 class="text-3xl font-bold mb-4 text-gray-800"><?= $data['name']; ?></h1>
                <p class="text-gray-600 mb-4">₺<?= fiyatYazdir($data['price']); ?></p>
                <div class="text-gray-600 mb-4"><?= htmlspecialchars_decode($data['description']); ?></div>
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
                <div id="toast-container" class="fixed bottom-4 right-4"></div>
            </div>
        </div>
    </div>
</main>

<?php include 'footer.php'; ?>

<script src="assets/js/zoom.js?v=<?= time(); ?>"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        initializeZoom();
    });
</script>