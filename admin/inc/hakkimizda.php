<?php include_once('header.php'); ?>
<?php $about = $db->query("SELECT * FROM about_us WHERE id=1")->fetch(); ?>
<div class="page-content">
    <form class="py-0 px-3 mt-0" method="POST" action="../ajax/about.html" enctype="multipart/form-data" id="about-form">
        <input type="hidden" name="request" value="about-update">
        <input type="hidden" name="token" value="<?= $_SESSION['token']; ?>">
        <div id="about-details" class="row">
            <div class="col-md-12 mt-4">
                <div class="card shadow-sm rounded-0">
                    <div class="card-header bg-primary rounded-0">
                        <h5 class="card-title text-white mb-0 mr-4" style="border-color: white; border: 1px;" id="about-title">HAKKIMIZDA</h5>
                    </div>
                    <div class="card-body rounded-0">
                        <div class="row">
                            <div class="col-md-12 mt-2">
                                <div class="form-group">
                                    <h6 class="card-title">Açıklama</h6>
                                    <div id="description-container">
                                        <div id="description" style="height: 200px;"><?= htmlspecialchars_decode($about['description']); ?></div>
                                    </div>
                                    <input type="hidden" name="description" id="description-input">
                                </div>
                            </div>
                        </div>
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
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

<script>
    $(document).ready(function() {
        // Quill editörü başlatma
        var quill = new Quill('#description', {
            theme: 'snow'
        });

        // Form gönderilmeden önce Quill içeriğini gizli giriş alanına kopyalama
        $('#about-form').on('submit', function() {
            $('#description-input').val(quill.root.innerHTML);
        });
    });
</script>