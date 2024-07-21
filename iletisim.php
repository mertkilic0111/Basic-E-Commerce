<?php include 'header.php'; ?>

<main class="min-h-screen bg-white">
    <div class="container mx-auto py-16 px-6">
        <h1 class="text-4xl font-bold text-center text-gray-800 mb-12">İletişim</h1>
        <div class="flex flex-wrap -mx-4">
            <!-- İletişim Bilgileri -->
            <div class="w-full lg:w-1/2 px-4 mb-8 lg:mb-0">
                <div class="bg-gray-50 p-8 rounded-lg shadow-lg mb-8">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-6">İletişim Bilgilerimiz</h2>
                    <p class="text-gray-600 mb-4">
                        <strong>Adres:</strong> <?= $setting['address']; ?><br>
                        <strong>Telefon:</strong> <a href="tel:<?= $setting['phone_number']; ?>" class="text-dark"><?= $setting['phone_number']; ?></a><br>
                        <strong>E-posta:</strong> <a href="mailto:<?= $setting['e_mail']; ?>" class="text-dark"><?= $setting['e_mail']; ?></a>
                    </p>
                </div>
                <!-- Harita -->
                <iframe src="<?= htmlspecialchars_decode($setting['maps_link']); ?>" width="100%" height="410" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>

            <!-- İletişim Formu -->
            <div class="w-full lg:w-1/2 px-4">
                <div class="bg-gray-50 p-8 rounded-lg shadow-lg">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Bizimle İletişime Geçin</h2>
                    <form action="send_contact.php" method="post">
                        <div class="mb-4">
                            <label for="name" class="block text-gray-700">Ad ve Soyad<span class="text-red-500">*</span></label>
                            <input type="text" id="name" name="name" class="w-full p-2 border border-gray-300 rounded-lg" required>
                        </div>
                        <div class="mb-4">
                            <label for="email" class="block text-gray-700">E-posta</label>
                            <input type="email" id="email" name="email" class="w-full p-2 border border-gray-300 rounded-lg">
                        </div>
                        <div class="mb-4">
                            <label for="phone" class="block text-gray-700">Telefon</label>
                            <input type="text" id="phone" name="phone" class="w-full p-2 border border-gray-300 rounded-lg">
                        </div>
                        <div class="mb-4">
                            <label for="subject" class="block text-gray-700">Konu<span class="text-red-500">*</span></label>
                            <input type="text" id="subject" name="subject" class="w-full p-2 border border-gray-300 rounded-lg" required>
                        </div>
                        <div class="mb-4">
                            <label for="message" class="block text-gray-700">Mesaj<span class="text-red-500">*</span></label>
                            <textarea id="message" name="message" class="w-full p-2 border border-gray-300 rounded-lg" rows="4" required></textarea>
                        </div>
                        <button type="submit" class="bg-blue-500 text-white p-2 rounded-lg hover:bg-blue-700">Gönder</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include 'footer.php'; ?>