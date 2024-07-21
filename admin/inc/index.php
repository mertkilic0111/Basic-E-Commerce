<?php include_once('header.php'); ?>
<div class="page-content">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm rounded-0">
                <div class="card-header bg-primary rounded-0">
                    <h5 class="card-title text-white mb-0 mr-4" style="border-color: white; border: 1px;">SİPARİŞLER
                </div>
                </h5>
            </div>
            <div class="card-body rounded-0">
                <div class="table-responsive">
                    <table id="data-table" class="table table-striped" style="max-width: 100% !important;">
                        <thead>
                            <tr>
                                <th class="bg-secondary">MÜŞ. ADI SOYADI</th>
                                <th class="bg-secondary">SİPARİŞ ÖZETİ</th>
                                <th class="bg-secondary">TOPLAM TUTAR</th>
                                <th class="bg-secondary">SİPARİŞ ZAMANI</th>
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
            url: '../ajax/orders.html',
            type: 'POST',
            data: {
                'request': 'get-all-orders'
            }
        },
        order: [
            [3, "asc"]
        ],
        columns: [{
            data: 'name_surname'
        }, {
            data: 'order_summary'
        }, {
            data: 'total_payment'
        }, {
            data: 'ctime'
        }, {
            data: 'buttons',
            orderable: false
        }]
    });

    function removeOrder(i) {
        Swal.fire({
            title: 'Emin misiniz?',
            text: "Bu siparişi silmek istediğinize emin misiniz? Bu işlem geri alınamaz.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Evet, sil!',
            cancelButtonText: 'Hayır, iptal et'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '../ajax/orders.html',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        request: 'remove-order',
                        i: i
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire(
                                'Silindi!',
                                'Sipariş başarıyla silindi.',
                                'success'
                            );
                            $('#tr_' + i).remove();
                        } else {
                            Swal.fire(
                                'Hata!',
                                'Sipariş silinemedi.',
                                'error'
                            );
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Hatası:', error);
                        Swal.fire(
                            'Hata!',
                            'Sipariş silinirken bir hata oluştu.',
                            'error'
                        );
                    }
                });
            }
        });
    }
</script>