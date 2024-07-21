<?php include 'header.php'; ?>
<?php $datas = $db->prepare("SELECT * FROM about_us WHERE id=:id");
$datas->execute(['id' => 1]);
$data = $datas->fetch(); ?>

<main class="min-h-screen bg-white">
    <div class="container mx-auto py-16 px-6">
        <div class="bg-gray-50 p-8 rounded-lg shadow-lg">
            <?= htmlspecialchars_decode($data['description']); ?>
        </div>
    </div>
</main>

<?php include 'footer.php'; ?>
<script>
    function addTailwindClasses() {
        document.querySelectorAll('main h1').forEach(el => el.classList.add('text-4xl', 'font-bold', 'mb-4'));
        document.querySelectorAll('main h2').forEach(el => el.classList.add('text-3xl', 'font-bold', 'mb-4'));
        document.querySelectorAll('main h3').forEach(el => el.classList.add('text-2xl', 'font-semibold', 'mb-4'));
        document.querySelectorAll('main h4').forEach(el => el.classList.add('text-xl', 'font-semibold', 'mb-2'));
        document.querySelectorAll('main h5').forEach(el => el.classList.add('text-lg', 'font-semibold', 'mb-2'));
        document.querySelectorAll('main h6').forEach(el => el.classList.add('text-base', 'font-semibold', 'mb-2'));
        document.querySelectorAll('main p').forEach(el => el.classList.add('mb-4', 'text-base', 'leading-relaxed'));
        document.querySelectorAll('main a').forEach(el => el.classList.add('text-blue-500', 'hover:underline'));
        document.querySelectorAll('main ul').forEach(el => el.classList.add('list-disc', 'list-inside', 'mb-4'));
        document.querySelectorAll('main ol').forEach(el => el.classList.add('list-decimal', 'list-inside', 'mb-4'));
        document.querySelectorAll('main li').forEach(el => el.classList.add('mb-2'));
    }

    document.addEventListener('DOMContentLoaded', addTailwindClasses);
</script>