<?php include_once('header.php'); ?>
<div class="page-content">
    <form class="py-0 px-3 mt-0" method="POST" action="../ajax/product.html" enctype="multipart/form-data" id="product-form">
        <input type="hidden" name="request" value="product-add">
        <input type="hidden" name="token" value="<?= $_SESSION['token']; ?>">
        <div id="product-details" class="row">
            <div class="col-md-12 mt-4">
                <div class="card shadow-sm rounded-0">
                    <div class="card-header bg-primary rounded-0">
                        <h5 class="card-title text-white mb-0 mr-4" style="border-color: white; border: 1px;" id="product-add-title">ÜRÜN EKLE</h5>
                    </div>
                    <div class="card-body rounded-0">
                        <div class="row">
                            <div class="col-md-6 mt-2">
                                <div class="form-group">
                                    <h6 class="card-title">Ürün Adı</h6>
                                    <input type="text" class="form-control" id="product-name" autocomplete="off" name="name" required placeholder="Ürün Adı">
                                </div>
                            </div>
                            <div class="col-md-2 mt-2">
                                <div class="form-group">
                                    <h6 class="card-title">Fiyat</h6>
                                    <input type="text" class="form-control money" name="price" autocomplete="off" required placeholder="Fiyat">
                                </div>
                            </div>
                            <div class="col-md-2 mt-2">
                                <div class="form-group">
                                    <h6 class="card-title">Sıra</h6>
                                    <input type="text" class="form-control" name="p_order" autocomplete="off" required placeholder="Sıra" value="1">
                                </div>
                            </div>
                            <div class="col-md-2 mt-2">
                                <div class="form-group">
                                    <h6 class="card-title">Durum</h6>
                                    <select name="status" class="js-example-basic-single" id="">
                                        <option value="1" selected>Aktif</option>
                                        <option value="0">Pasif</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mt-2">
                                <div class="form-group">
                                    <h6 class="card-title">Kapak Resmi</h6>
                                    <input type="file" class="form-control" name="cover_image" required>
                                </div>
                            </div>
                            <div class="col-md-6 mt-2">
                                <div class="form-group">
                                    <h6 class="card-title">Slug URL</h6>
                                    <input type="text" class="form-control" id="slug-url" name="slug_url" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mt-2">
                                <div class="form-group">
                                    <h6 class="card-title">Açıklama</h6>
                                    <div id="description-container">
                                        <div id="description" style="height: 200px;"></div>
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

<script>
    $(document).ready(function() {
        // Fiyat alanına money mask uygulama
        $('.money').mask('000.000,00', {
            reverse: true
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
</script>