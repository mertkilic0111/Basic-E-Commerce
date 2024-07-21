<script>
    function islem_basarili() {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        Toast.fire({
            icon: 'success',
            title: 'İşlem Başarılı !'
        })
    }

    function hata_olustu() {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        Toast.fire({
            icon: 'error',
            title: 'Hata Oluştu !'
        })
    }
</script>
<?php if (@$_GET['e'] == 'ok') { ?>
    <script>
        islem_basarili();
    </script>
<?php } else if (@$_GET['e'] == 'no') { ?>
    <script>
        hata_olustu();
    </script>
<?php } ?>

<script>
    window.addEventListener('online', () => {
        Swal.fire(
            'Harika !',
            'İnternet bağlantınız geri geldi !',
            'success'
        )
    })
    window.addEventListener('offline', () => {
        Swal.fire(
            'İnternet ?',
            'İnternet bağlantınız kopmuş olabilir mi?',
            'question'
        )
    })
</script>