<?php include_once('header.php'); ?>
<div class="page-content">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm rounded-0">
                <div class="card-header bg-primary rounded-0">
                    <h5 class="card-title text-white mb-0 mr-4" style="border-color: white; border: 1px;">ÜRÜNLER <div class="float-right"><a href="urun-ekle.html" class="text-white"> + Ürün Ekle</a></div>
                    </h5>
                </div>
                <div class="card-body rounded-0">
                    <div class="table-responsive">
                        <table id="data-table" class="table table-striped" style="max-width: 100% !important;">
                            <thead>
                                <tr>
                                    <th class="bg-secondary">ÜRÜN ADI</th>
                                    <th class="bg-secondary">FİYAT</th>
                                    <th class="bg-secondary">DURUM</th>
                                    <th class="bg-secondary">SIRA</th>
                                    <th class="bg-secondary">RESİM</th>
                                    <th class="bg-secondary"></th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include_once('footer.php'); ?>
<script>
    $("#data-table").DataTable({
        rowCallback: function(row, data) {
            row.id = 'tr_' + data.id;
            feather.replace();
        },
        language: {
            'url': '../assets/datatable-language.json'
        },
        pageLength: 10,
        lengthMenu: [
            [10, 25, 50, 100, 250],
            ['10', '25', '50', '100', '250']
        ],
        processing: true,
        serverSide: true,
        ajax: {
            url: '../ajax/product.html',
            type: 'POST',
            data: {
                'request': 'get-all-products'
            }
        },
        order: [
            [3, "asc"]
        ],
        columns: [{
            data: 'name'
        }, {
            data: 'price'
        }, {
            data: 'status'
        }, {
            data: 'p_order'
        }, {
            data: 'img',
            orderable: false
        }, {
            data: 'buttons',
            orderable: false
        }]
    });

    function removeProduct(i) {
        Swal.fire({
            title: 'Emin misiniz?',
            text: "Bu ürünü silmek istediğinize emin misiniz? Bu işlem geri alınamaz.",
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
                        request: 'remove-product',
                        i: i
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire(
                                'Silindi!',
                                'Ürün başarıyla silindi.',
                                'success'
                            );
                            $('#tr_' + i).remove();
                        } else {
                            Swal.fire(
                                'Hata!',
                                'Ürün silinemedi.',
                                'error'
                            );
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Hatası:', error);
                        Swal.fire(
                            'Hata!',
                            'Ürün silinirken bir hata oluştu.',
                            'error'
                        );
                    }
                });
            }
        });
    }
</script>