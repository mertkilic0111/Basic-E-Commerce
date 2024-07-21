</div>
</div>

<!-- core:js -->
<script src="../assets/vendors/core/core.js"></script>
<script src="../assets/vendors/datatables.net/jquery.dataTables.js"></script>
<script src="../assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
<script src="../assets/vendors/feather-icons/feather.min.js"></script>
<script src="../assets/js/template.js"></script>
</body>

</html>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="../assets/vendors/promise-polyfill/polyfill.min.js"></script> <!-- Optional:  polyfill for ES6 Promises for IE11 and Android browser -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js"></script>
<?php include('../assets/js/global-custom.php'); ?>
<script>
    $(window).on('load', function() {
        setTimeout(function() {
            $('#loading').fadeOut(500);
        }, 300)
        $('.main-wrapper').show();
    });

    $(document).ready(function() {
        $('.js-example-basic-single').select2();
        $('.money').maskMoney({
            allowNegative: true,
            thousands: '.',
            decimal: ',',
            precision: 2,
            affixesStay: false
        });
    });

    function ilceleriGetir(il_id) {
        $('#ilce').html('');
        $.ajax({
            url: '../ajax/get-data.html',
            type: 'post',
            data: {
                'request': 'ilceleri-getir',
                'il_id': il_id
            },
            success: function(e) {
                var r = JSON.parse(e);
                $('#ilce').html(r.html);
            }
        })
    }

    function excelExport(request) {
        var form = $('<form>', {
            'method': 'POST',
            'action': '../ajax/excel.php'
        });

        form.append($('<input>', {
            'type': 'hidden',
            'name': 'request',
            'value': request
        }));

        $('body').append(form);
        form.submit();
        form.remove();
    }

    function selectSec(selectName, value) {
        const selectElement = document.getElementsByName(selectName)[0];
        if (selectElement) {
            for (let option of selectElement.options) {
                if (option.value === value) {
                    option.selected = true;
                    break;
                }
            }
        }
    }

    function degerYaz(inputName, value) {
        const inputElement = document.getElementsByName(inputName)[0];
        if (inputElement) {
            inputElement.value = value;
        }
    }
</script>