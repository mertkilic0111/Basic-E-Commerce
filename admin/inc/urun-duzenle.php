<?php include_once('header.php'); ?>
<?php $id = decrypt($_GET['id']);
$datas = $db->prepare("SELECT * FROM products WHERE id=:id");
$datas->bindParam(':id', $id, PDO::PARAM_INT);
$datas->execute();
$data = $datas->fetch();
if (!$data) {
    require_once('500.php');
    exit;
} ?>
<div class="page-content">
    <form class="py-0 px-3 mt-0" method="POST" action="../ajax/product.html" enctype="multipart/form-data" id="product-form">
        <input type="hidden" name="request" value="product-update">
        <input type="hidden" name="id" value="<?= $_GET['id']; ?>">
        <input type="hidden" name="old_img" value="<?= $data['cover_image']; ?>">
        <input type="hidden" name="token" value="<?= $_SESSION['token']; ?>">
        <div id="product-details" class="row">
            <div class="col-md-12 mt-4">
                <div class="card shadow-sm rounded-0">
                    <div class="card-header bg-primary rounded-0">
                        <h5 class="card-title text-white mb-0 mr-4" style="border-color: white; border: 1px;" id="product-add-title">ÜRÜN DÜZENLE</h5>
                    </div>
                    <div class="card-body rounded-0">
                        <div class="row">
                            <div class="col-md-6 mt-2">
                                <div class="form-group">
                                    <h6 class="card-title">Ürün Adı</h6>
                                    <input type="text" class="form-control" id="product-name" autocomplete="off" name="name" required placeholder="Ürün Adı" value="<?= $data['name']; ?>">
                                </div>
                            </div>
                            <div class="col-md-2 mt-2">
                                <div class="form-group">
                                    <h6 class="card-title">Fiyat</h6>
                                    <input type="text" class="form-control money" name="price" autocomplete="off" required placeholder="Fiyat" value="<?= $data['price']; ?>">
                                </div>
                            </div>
                            <div class="col-md-2 mt-2">
                                <div class="form-group">
                                    <h6 class="card-title">Sıra</h6>
                                    <input type="text" class="form-control" name="p_order" autocomplete="off" required placeholder="Sıra" value="<?= $data['p_order']; ?>">
                                </div>
                            </div>
                            <div class="col-md-2 mt-2">
                                <div class="form-group">
                                    <h6 class="card-title">Durum</h6>
                                    <select name="status" class="js-example-basic-single" id="">
                                        <option value="1" <?= $data['status'] == 1 ? 'selected' : ''; ?>>Aktif</option>
                                        <option value="0" <?= $data['status'] == 0 ? 'selected' : ''; ?>>Pasif</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mt-2">
                                <div class="form-group">
                                    <h6 class="card-title">Kapak Resmi <a href="../../<?= $data['cover_image']; ?>" class="fancybox color-red"><small>Mevcut resmi görüntülemek için tıklayınız.</small></a></h6>
                                    <input type="file" class="form-control" name="cover_image">
                                </div>
                            </div>
                            <div class="col-md-6 mt-2">
                                <div class="form-group">
                                    <h6 class="card-title">Slug URL</h6>
                                    <input type="text" class="form-control" id="slug-url" name="slug_url" readonly value="<?= $data['slug_url']; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mt-2">
                                <div class="form-group">
                                    <h6 class="card-title">Açıklama</h6>
                                    <div id="description-container">
                                        <div id="description" style="height: 200px;"><?= htmlspecialchars_decode($data['description']); ?></div>
                                    </div>
                                    <input type="hidden" name="description" id="description-input">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 mt-4">
                <div class="card shadow-sm rounded-0">
                    <div class="card-header bg-primary rounded-0">
                        <h5 class="card-title text-white mb-0 mr-4" style="border-color: white; border: 1px;">ÜRÜN GALERİSİ</h5>
                    </div>
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <tbody>
                                    <?php $productGallery = dbSelect('product_images', ['product_id' => $data['id']]);
                                    foreach ($productGallery as $productGalleryImage) { ?>
                                        <tr id="image-gallery-<?= encrypt($productGalleryImage['id']); ?>">
                                            <td><a class="fancybox" href="../../<?= $productGalleryImage['image_path']; ?>"><img src="../../<?= $productGalleryImage['image_path']; ?>" alt=""></td>
                                            <td><button type="button" class="btn btn-danger btn-icon" onclick="removeImage('<?= encrypt($productGalleryImage['id']); ?>');"><i data-feather="trash"></i></button></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="text-center col-md-12">
                        <hr style="width: 90%;;">
                    </div>
                    <div class="card-body rounded-0">
                        <input type="file" name="gallery_images[]" class="filepond" id="gallery-pond" multiple data-allow-reorder="true" data-max-file-size="3MB" data-max-files="10">
                    </div>
                </div>
            </div>
            <div class="col-md-12 text-center mt-4">
                <button type="submit" class="btn btn-success">Kaydet</button>
            </div>
        </div>
    </form>
</div>
<?php include_once('footer.php'); ?>

<!-- Ekstra JavaScript ve CSS dosyalarını yükleme -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
<script src="https://unpkg.com/filepond/dist/filepond.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>

<script>
    $(document).ready(function() {
        // Fiyat alanına money mask uygulama
        $('.money').mask('000.000,00', {
            reverse: true
        });

        // Fancybox
        $(".fancybox").fancybox({
            autoSize: true
        });

        // Quill editörü başlatma
        var quill = new Quill('#description', {
            theme: 'snow'
        });

        // Form gönderimi sırasında açıklama alanını gizli input alanına kopyalama
        $('#product-form').on('submit', function() {
            $('#description-input').val(quill.root.innerHTML);
        });

        // Slug oluşturma ve kontrol etme
        $('#product-name').on('input', function() {
            var title = $(this).val();
            if (title.length > 0) {
                $.ajax({
                    url: '../ajax/product.html',
                    type: 'POST',
                    dataType: 'json', // JSON veri tipini belirtmek
                    data: {
                        request: 'check-url',
                        title: title
                    },
                    success: function(response) {
                        if (response.slug) {
                            $('#slug-url').val(response.slug);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Hatası:', error);
                    }
                });
            } else {
                $('#slug-url').val('');
            }
        });

        // FilePond başlatma
        const pond = FilePond.create(document.querySelector('#gallery-pond'), {
            allowMultiple: true,
            instantUpload: false
        });

        $('#product-form').on('submit', function(e) {
            e.preventDefault();

            const submitButton = $(this).find('button[type="submit"]');
            const originalButtonHTML = submitButton.html();

            // Submit butonunu disable et ve spinner ekle
            submitButton.prop('disabled', true);
            submitButton.html('<div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div>');

            // FilePond dosyalarını alın
            const files = pond.getFiles();
            const formData = new FormData(this);

            files.forEach(fileItem => {
                formData.append('gallery_images[]', fileItem.file);
            });

            $.ajax({
                url: this.action,
                type: this.method,
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    const res = JSON.parse(response);
                    if (res.success) {
                        console.log('Ürün eklendi:', res.product_id);
                        window.location.href = 'urunler.html';
                    } else {
                        console.error('Hata:', res.message);
                        alert('Ürün eklenemedi.');
                        // Submit butonunu etkinleştir ve orijinal HTML'i geri yükle
                        submitButton.prop('disabled', false);
                        submitButton.html(originalButtonHTML);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Hatası:', error);
                    alert('Ürün eklenirken hata oluştu.');
                    // Submit butonunu etkinleştir ve orijinal HTML'i geri yükle
                    submitButton.prop('disabled', false);
                    submitButton.html(originalButtonHTML);
                }
            });
        });
    });

    function removeImage(imageId) {
        Swal.fire({
            title: 'Emin misiniz?',
            text: "Bu resmi silmek istediğinize emin misiniz? Bu işlem geri alınamaz.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Evet, sil!',
            cancelButtonText: 'Hayır, iptal et'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '../ajax/product.html',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        request: 'remove-image',
                        image_id: imageId
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire(
                                'Silindi!',
                                'Resim başarıyla silindi.',
                                'success'
                            );
                            // Resmi tablodan kaldır
                            $('#image-gallery-' + imageId).remove();
                        } else {
                            Swal.fire(
                                'Hata!',
                                'Resim silinemedi.',
                                'error'
                            );
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Hatası:', error);
                        Swal.fire(
                            'Hata!',
                            'Resim silinirken bir hata oluştu.',
                            'error'
                        );
                    }
                });
            }
        });
    }
</script>